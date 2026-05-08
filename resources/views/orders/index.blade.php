@extends('layouts.app')

@section('content')

@php
/* Mapeo de estados a clases CSS y etiquetas en español */
$statusMap = [
    'Ordered'    => ['class'=>'badge-ordered',    'label'=>'Ordenado',   'icon'=>'fa-box'],
    'In process' => ['class'=>'badge-in-process', 'label'=>'En proceso', 'icon'=>'fa-gear'],
    'In route'   => ['class'=>'badge-in-route',   'label'=>'En ruta',    'icon'=>'fa-truck'],
    'Delivered'  => ['class'=>'badge-delivered',  'label'=>'Entregado',  'icon'=>'fa-circle-check'],
];
@endphp

<div style="max-width:1280px; margin:0 auto; padding:0 24px;">

    <!-- ── HEADER ─────────────────────────────────────────────────────────── -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#f0f4ff; letter-spacing:-0.02em; margin:0 0 4px;">
                <i class="fa-solid fa-boxes-stacked" style="color:#3b82f6; margin-right:10px;"></i>
                Gestión de Pedidos
            </h1>
            <p style="font-size:13px; color:#93c5fd; margin:0;">
                Total activos:
                <span style="background:rgba(59,130,246,0.2); border:1px solid rgba(59,130,246,0.4); color:#3b82f6; border-radius:20px; padding:2px 10px; font-weight:700; font-size:12px; margin-left:4px;">
                    {{ $orders->count() }}
                </span>
            </p>
        </div>

        @if(auth()->user()->hasRole('Sales') || auth()->user()->hasRole('Admin'))
            <a href="{{ route('orders.create') }}" class="btn-primary">
                <i class="fa-solid fa-plus"></i> Nuevo Pedido
            </a>
        @endif
    </div>

    <!-- ── ALERTA DE ÉXITO ────────────────────────────────────────────────── -->
    @if(session('success'))
        <div class="hc-alert-success" style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <!-- ── FILTROS DE BÚSQUEDA ────────────────────────────────────────────── -->
    <div class="hc-card" style="padding:20px; margin-bottom:20px;">
        <form method="GET" action="{{ route('orders.index') }}">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:14px; align-items:end;">

                <!-- Número de factura -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#93c5fd; margin-bottom:6px; letter-spacing:0.06em;">
                        <i class="fa-solid fa-magnifying-glass" style="margin-right:4px;"></i> FACTURA
                    </label>
                    <input type="text" name="invoice_number" value="{{ request('invoice_number') }}"
                           placeholder="HAL-000001" class="hc-input">
                </div>

                <!-- Número de cliente -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#93c5fd; margin-bottom:6px; letter-spacing:0.06em;">
                        <i class="fa-solid fa-user" style="margin-right:4px;"></i> CLIENTE
                    </label>
                    <input type="text" name="customer_number" value="{{ request('customer_number') }}"
                           placeholder="Núm. cliente" class="hc-input">
                </div>

                <!-- Fecha -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#93c5fd; margin-bottom:6px; letter-spacing:0.06em;">
                        <i class="fa-solid fa-calendar" style="margin-right:4px;"></i> FECHA
                    </label>
                    <input type="date" name="order_date" value="{{ request('order_date') }}" class="hc-input">
                </div>

                <!-- Estado -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#93c5fd; margin-bottom:6px; letter-spacing:0.06em;">
                        <i class="fa-solid fa-filter" style="margin-right:4px;"></i> ESTADO
                    </label>
                    <select name="status" class="hc-input">
                        <option value="">— Todos —</option>
                        <option value="Ordered"    {{ request('status')==='Ordered'    ?'selected':'' }}>Ordenado</option>
                        <option value="In process" {{ request('status')==='In process' ?'selected':'' }}>En proceso</option>
                        <option value="In route"   {{ request('status')==='In route'   ?'selected':'' }}>En ruta</option>
                        <option value="Delivered"  {{ request('status')==='Delivered'  ?'selected':'' }}>Entregado</option>
                    </select>
                </div>

                <!-- Botones -->
                <div style="display:flex; gap:10px; align-items:flex-end;">
                    <button type="submit" class="btn-primary btn-sm" style="flex:1; justify-content:center;">
                        <i class="fa-solid fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn-secondary btn-sm" style="flex:1; justify-content:center;">
                        <i class="fa-solid fa-xmark"></i> Limpiar
                    </a>
                </div>

            </div>
        </form>
    </div>

    <!-- ── TABLA DE PEDIDOS ───────────────────────────────────────────────── -->
    <div class="hc-card" style="overflow:hidden; padding:0;">

        @if($orders->isEmpty())
            <!-- Estado vacío -->
            <div style="text-align:center; padding:64px 24px;">
                <div style="font-size:56px; color:#1e3a8a; margin-bottom:16px;">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <p style="font-size:16px; font-weight:600; color:#93c5fd; margin:0 0 8px;">No hay pedidos</p>
                <p style="font-size:14px; color:#3d5a99; margin:0 0 24px;">
                    {{ request()->hasAny(['invoice_number','customer_number','order_date','status'])
                        ? 'Ningún pedido coincide con los filtros aplicados.'
                        : 'Aún no hay pedidos registrados en el sistema.' }}
                </p>
                @if(auth()->user()->hasRole('Sales') || auth()->user()->hasRole('Admin'))
                    <a href="{{ route('orders.create') }}" class="btn-primary">
                        <i class="fa-solid fa-plus"></i> Crear primer pedido
                    </a>
                @endif
            </div>

        @else
            <div style="overflow-x:auto;">
                <table class="hc-table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag" style="margin-right:5px;"></i>Factura</th>
                            <th><i class="fa-solid fa-user" style="margin-right:5px;"></i>Cliente</th>
                            <th><i class="fa-solid fa-calendar" style="margin-right:5px;"></i>Fecha</th>
                            <th><i class="fa-solid fa-location-dot" style="margin-right:5px;"></i>Dirección</th>
                            <th><i class="fa-solid fa-circle-dot" style="margin-right:5px;"></i>Estado</th>
                            <th style="text-align:center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @php
                                $sc = $statusMap[$order->status] ?? ['class'=>'badge-archived','label'=>$order->status,'icon'=>'fa-circle'];
                            @endphp
                            <tr>
                                <td>
                                    <span style="font-weight:700; color:#93c5fd; font-size:13px;">
                                        {{ $order->invoice_number }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#f0f4ff;">{{ $order->customer_name }}</div>
                                    <div style="font-size:12px; color:#3d5a99;">{{ $order->customer_number }}</div>
                                </td>
                                <td style="font-size:13px; white-space:nowrap; color:#93c5fd;">
                                    {{ $order->order_datetime ? $order->order_datetime->format('d/m/Y') : '—' }}<br>
                                    <span style="font-size:11px; color:#3d5a99;">
                                        {{ $order->order_datetime ? $order->order_datetime->format('H:i') : '' }}
                                    </span>
                                </td>
                                <td style="font-size:13px; color:#93c5fd; max-width:180px;">
                                    {{ Str::limit($order->delivery_address, 45) }}
                                </td>
                                <td>
                                    <span class="badge {{ $sc['class'] }}">
                                        <i class="fa-solid {{ $sc['icon'] }}"></i>
                                        {{ $sc['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex; align-items:center; justify-content:center; gap:8px; flex-wrap:wrap;">

                                        <!-- Ver -->
                                        <a href="{{ route('orders.show', $order->id) }}"
                                           title="Ver detalle"
                                           style="width:32px;height:32px;background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.3);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#3b82f6;transition:all 0.2s;"
                                           onmouseover="this.style.background='rgba(59,130,246,0.3)'"
                                           onmouseout="this.style.background='rgba(59,130,246,0.15)'">
                                            <i class="fa-solid fa-eye" style="font-size:13px;"></i>
                                        </a>

                                        <!-- Editar (Admin) -->
                                        @if(auth()->user()->hasRole('Admin'))
                                            <a href="{{ route('orders.edit', $order->id) }}"
                                               title="Editar"
                                               style="width:32px;height:32px;background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.3);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#f59e0b;transition:all 0.2s;"
                                               onmouseover="this.style.background='rgba(245,158,11,0.25)'"
                                               onmouseout="this.style.background='rgba(245,158,11,0.12)'">
                                                <i class="fa-solid fa-pen" style="font-size:13px;"></i>
                                            </a>
                                        @endif

                                        <!-- Subir fotos (Ruta) -->
                                        @if(auth()->user()->hasRole('Route'))
                                            <a href="{{ route('orders.upload-photos.form', $order->id) }}"
                                               title="Subir fotos"
                                               style="width:32px;height:32px;background:rgba(139,92,246,0.12);border:1px solid rgba(139,92,246,0.3);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#8b5cf6;transition:all 0.2s;"
                                               onmouseover="this.style.background='rgba(139,92,246,0.25)'"
                                               onmouseout="this.style.background='rgba(139,92,246,0.12)'">
                                                <i class="fa-solid fa-camera" style="font-size:13px;"></i>
                                            </a>
                                        @endif

                                        <!-- Archivar (Admin) -->
                                        @if(auth()->user()->hasRole('Admin'))
                                            <button type="button"
                                               title="Archivar pedido"
                                               onclick="openArchiveModal({{ $order->id }}, '{{ $order->invoice_number }}')"
                                               style="width:32px;height:32px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#ef4444;cursor:pointer;transition:all 0.2s;"
                                               onmouseover="this.style.background='rgba(239,68,68,0.22)'"
                                               onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                                                <i class="fa-solid fa-box-archive" style="font-size:13px;"></i>
                                            </button>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div><!-- /hc-card tabla -->

</div><!-- /container -->


<!-- ── MODAL DE CONFIRMACIÓN DE ARCHIVADO ──────────────────────────────────── -->
<div id="archive-modal" style="display:none; position:fixed; inset:0; z-index:200; align-items:center; justify-content:center;">
    <!-- Backdrop -->
    <div onclick="closeArchiveModal()"
         style="position:absolute; inset:0; background:rgba(10,15,44,0.75); backdrop-filter:blur(8px);"></div>

    <!-- Caja del modal -->
    <div style="position:relative; z-index:201; background:#112266; border:1px solid #1e3a8a; border-radius:20px; padding:36px; max-width:420px; width:90%; box-shadow:0 32px 80px rgba(0,0,0,0.6); animation:fadeInUp 0.3s ease;">
        <div style="text-align:center; margin-bottom:24px;">
            <div style="font-size:48px; color:#f59e0b; margin-bottom:12px;">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <h3 style="font-size:20px; font-weight:700; color:#f0f4ff; margin:0 0 8px;">¿Archivar pedido?</h3>
            <p style="font-size:14px; color:#93c5fd; margin:0;">
                Pedido <strong id="modal-invoice" style="color:#f0f4ff;"></strong> se moverá a archivados.<br>
                Podrás restaurarlo cuando lo necesites.
            </p>
        </div>
        <div style="display:flex; gap:12px; justify-content:center;">
            <button type="button" onclick="closeArchiveModal()" class="btn-secondary" style="flex:1; justify-content:center;">
                <i class="fa-solid fa-xmark"></i> Cancelar
            </button>
            <form id="archive-form" method="POST" style="flex:1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger" style="width:100%; justify-content:center;">
                    <i class="fa-solid fa-box-archive"></i> Archivar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openArchiveModal(id, invoice) {
    document.getElementById('modal-invoice').textContent = invoice;
    document.getElementById('archive-form').action = '/orders/' + id;
    document.getElementById('archive-modal').style.display = 'flex';
}
function closeArchiveModal() {
    document.getElementById('archive-modal').style.display = 'none';
}
// Cerrar con Escape
document.addEventListener('keydown', e => { if(e.key === 'Escape') closeArchiveModal(); });
</script>

@endsection
