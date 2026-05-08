<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Muestra el listado de pedidos activos con filtros de búsqueda.
     * Accesible a Sales, Warehouse, Route y Admin (CU-09 / CU-15).
     */
    public function index(Request $request)
    {
        $query = Order::where('is_deleted', false);

        // Filtro por número de factura (CU-15)
        if ($request->filled('invoice_number')) {
            $query->where('invoice_number', 'like', '%' . $request->invoice_number . '%');
        }

        // Filtro por número de cliente (CU-15)
        if ($request->filled('customer_number')) {
            $query->where('customer_number', 'like', '%' . $request->customer_number . '%');
        }

        // Filtro por estado (CU-15)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por fecha (CU-15)
        if ($request->filled('order_date')) {
            $query->whereDate('order_datetime', $request->order_date);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Muestra el formulario para crear un pedido nuevo.
     * Solo accesible a Sales (verificado en middleware de rutas).
     */
    public function create()
    {
        // Solo Sales puede crear pedidos (CU-06)
        if (!Auth::user()->hasRole('Sales') && !Auth::user()->hasRole('Admin')) {
            abort(403, 'Solo el rol Ventas puede crear pedidos.');
        }

        return view('orders.create');
    }

    /**
     * Guarda un pedido nuevo.
     * - El número de factura se genera automáticamente (CU-08).
     * - El estado inicial siempre es "Ordered", ignorando lo que envíe el formulario (CU-07).
     */
    public function store(Request $request)
    {
        // Solo Sales puede guardar pedidos (CU-06)
        if (!Auth::user()->hasRole('Sales') && !Auth::user()->hasRole('Admin')) {
            abort(403, 'Solo el rol Ventas puede registrar pedidos.');
        }

        // Validación de campos obligatorios (NO incluye invoice_number ni status: se calculan aquí)
        $request->validate([
            'customer_name'    => 'required|string|max:100',
            'customer_number'  => 'required|string|max:20',
            'delivery_address' => 'required|string|max:200',
            'order_datetime'   => 'required|date',
            'fiscal_data'      => 'required|string|max:255',
            'notes'            => 'nullable|string|max:1000',
        ]);

        // Generación automática del número de factura consecutivo (CU-08).
        // Se usa el máximo ID existente para calcular el siguiente número.
        // Formato: HAL-000001, HAL-000002, etc.
        $lastId   = Order::withoutGlobalScopes()->max('id') ?? 0;
        $nextNum  = $lastId + 1;
        $invoiceNumber = 'HAL-' . str_pad($nextNum, 6, '0', STR_PAD_LEFT);

        // El estado inicial SIEMPRE es "Ordered", el usuario no puede modificarlo (CU-07).
        Order::create([
            'invoice_number'   => $invoiceNumber,
            'customer_name'    => $request->customer_name,
            'customer_number'  => $request->customer_number,
            'delivery_address' => $request->delivery_address,
            'order_datetime'   => $request->order_datetime,
            'fiscal_data'      => $request->fiscal_data,
            'notes'            => $request->notes,
            'status'           => 'Ordered',  // forzado, nunca tomado del request
            'is_deleted'       => false,
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Pedido registrado correctamente.');
    }

    /**
     * Muestra el detalle de un pedido.
     */
    public function show(string $id)
    {
        $order = Order::with(['items.product', 'photos'])->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Muestra el formulario de edición de un pedido.
     * Solo Admin puede editar datos generales del pedido.
     * Almacén y Ruta solo pueden cambiar el estado.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);

        return view('orders.edit', compact('order'));
    }

    /**
     * Actualiza un pedido existente.
     * - Valida todos los campos antes de guardar (faltaba antes).
     * - Respeta el flujo de estados sin permitir saltos (CU-12).
     *   Flujo válido: Ordered → In process → In route → Delivered
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:100',
            'customer_number'  => 'required|string|max:20',
            'delivery_address' => 'required|string|max:200',
            'order_datetime'   => 'required|date',
            'notes'            => 'nullable|string|max:1000',
            'status'           => 'required|in:Ordered,In process,In route,Delivered',
        ]);

        // Verificación del flujo de estados (CU-12).
        // Si el estado cambia, debe ser una transición válida.
        if ($validated['status'] !== $order->status) {
            if (!$order->canTransitionTo($validated['status'])) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'status' => 'Cambio de estado no permitido. '
                            . 'El flujo válido es: Ordered → In process → In route → Delivered.',
                    ]);
            }
        }

        $order->update($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    /**
     * Muestra el formulario de subida de fotos de evidencia.
     * Solo accesible al rol Ruta (CU-13).
     */
    public function showUploadPhotos(string $id)
    {
        if (!Auth::user()->hasRole('Route') && !Auth::user()->hasRole('Admin')) {
            abort(403, 'Solo el rol Ruta puede subir fotos de evidencia.');
        }

        $order = Order::findOrFail($id);

        return view('orders.upload_photos', compact('order'));
    }

    /**
     * Procesa y guarda las dos fotos de evidencia en el pedido.
     * Guarda las rutas en orders.photo_loaded y orders.photo_delivered (CU-13).
     */
    public function uploadPhotos(Request $request, string $id)
    {
        if (!Auth::user()->hasRole('Route') && !Auth::user()->hasRole('Admin')) {
            abort(403, 'Solo el rol Ruta puede subir fotos de evidencia.');
        }

        $order = Order::findOrFail($id);

        $request->validate([
            'photo_loaded'    => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'photo_delivered' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'photo_loaded.required'    => 'La foto de unidad cargada es obligatoria.',
            'photo_delivered.required' => 'La foto de material descargado es obligatoria.',
            'photo_loaded.max'         => 'La foto de unidad cargada no puede superar 5 MB.',
            'photo_delivered.max'      => 'La foto de material descargado no puede superar 5 MB.',
        ]);

        // Guardar foto 1 (unidad cargada)
        $pathLoaded = $request->file('photo_loaded')
            ->storeAs('evidencias', $id . '_cargada.' . $request->file('photo_loaded')->extension(), 'public');

        // Guardar foto 2 (material descargado)
        $pathDelivered = $request->file('photo_delivered')
            ->storeAs('evidencias', $id . '_descargada.' . $request->file('photo_delivered')->extension(), 'public');

        $order->update([
            'photo_loaded'    => $pathLoaded,
            'photo_delivered' => $pathDelivered,
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Fotos de evidencia subidas correctamente.');
    }

    /**
     * Eliminación lógica: marca el pedido como eliminado (is_deleted = true).
     * NO borra el registro de la base de datos para poder restaurarlo (CU-16).
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        // Eliminación lógica: el pedido queda en BD pero oculto del listado principal.
        $order->update(['is_deleted' => true]);

        return redirect()->route('orders.index')
            ->with('success', 'Pedido archivado correctamente. Puede restaurarlo desde Pedidos Archivados.');
    }

    /**
     * API pública de rastreo: devuelve el estado de un pedido por número de cliente y factura.
     * No requiere autenticación (acceso público). Consumido por el frontend Vue.
     */
    public function trackOrder(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'customer_number' => 'required|string|max:50',
            'invoice_number'  => 'required|string|max:50',
        ]);

        $order = Order::where('customer_number', $request->customer_number)
            ->where('invoice_number', $request->invoice_number)
            ->where('is_deleted', false)
            ->first();

        if (!$order) {
            return response()->json(['found' => false], 404);
        }

        return response()->json([
            'found' => true,
            'order' => [
                'invoice_number'          => $order->invoice_number,
                'customer_name'           => $order->customer_name,
                'customer_number'         => $order->customer_number,
                'status'                  => $order->status,
                'delivery_address'        => $order->delivery_address,
                'order_datetime'          => $order->order_datetime?->format('d/m/Y H:i'),
                'scheduled_delivery_date' => $order->scheduled_delivery_date?->format('d/m/Y'),
                'notes'                   => $order->notes,
                'photos'                  => [
                    'loaded'    => $order->photo_loaded
                        ? asset('storage/' . $order->photo_loaded)
                        : null,
                    'delivered' => $order->photo_delivered
                        ? asset('storage/' . $order->photo_delivered)
                        : null,
                ],
            ],
        ]);
    }
}
