@extends('layouts.app')

@section('content')

@php
$statusFlow = [
    'Ordered'    => ['next'=>'In process', 'label'=>'Ordenado',   'nextLabel'=>'En proceso', 'color'=>'#f59e0b', 'icon'=>'fa-gear'],
    'In process' => ['next'=>'In route',   'label'=>'En proceso', 'nextLabel'=>'En ruta',    'color'=>'#8b5cf6', 'icon'=>'fa-truck'],
    'In route'   => ['next'=>'Delivered',  'label'=>'En ruta',    'nextLabel'=>'Entregado',  'color'=>'#10b981', 'icon'=>'fa-circle-check'],
    'Delivered'  => ['next'=>null,         'label'=>'Entregado',  'nextLabel'=>null,         'color'=>'#10b981', 'icon'=>null],
];

$statusOrder  = ['Ordered', 'In process', 'In route', 'Delivered'];
$statusLabels = ['Ordenado', 'En proceso', 'En ruta', 'Entregado'];
$statusIcons  = ['fa-box', 'fa-gear', 'fa-truck', 'fa-circle-check'];
$statusColors = ['#3b82f6', '#f59e0b', '#8b5cf6', '#10b981'];

$currentIdx   = array_search($order->status, $statusOrder);
$flow         = $statusFlow[$order->status] ?? null;
@endphp

<style>
.tl-step { display:flex; flex-direction:column; align-items:center; flex:1; position:relative; }
.tl-step:not(:last-child)::after {
    content:''; position:absolute;
    top:19px; left:calc(50% + 22px);
    width:calc(100% - 44px); height:2px;
    background:#e2e8f0;
}
.tl-step.done:not(:last-child)::after  { background:var(--hc-green-light); }
.tl-step.active:not(:last-child)::after { background:linear-gradient(90deg,var(--hc-green),#e2e8f0); }
.tl-dot {
    width:38px; height:38px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    border:2px solid #cbd5e1; background:#f1f5f9; color:#94a3b8;
    font-size:14px; transition:all 0.3s; position:relative; z-index:1;
}
.tl-step.done  .tl-dot { background:var(--hc-green); border-color:var(--hc-green); color:#fff; }
.tl-step.active .tl-dot {
    background:var(--hc-green-mid); border-color:var(--hc-green-mid); color:#fff;
    box-shadow:0 0 0 4px rgba(22,101,52,0.2);
    animation:pulseGlow 2s infinite;
}
.tl-label { margin-top:8px; font-size:10px; font-weight:700; text-align:center;
    text-transform:uppercase; letter-spacing:0.06em; color:#94a3b8; }
.tl-step.done   .tl-label  { color:var(--hc-green); }
.tl-step.active .tl-label  { color:var(--hc-green-mid); }
</style>

<div style="max-width:900px; margin:0 auto; padding:0 24px;">

    <!-- ── HEADER ─────────────────────────────────────────────────────────── -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#1e293b; letter-spacing:-0.02em; margin:0 0 6px;">
                <i class="fa-solid fa-pen-to-square" style="color:var(--hc-green); margin-right:10px;"></i>
                Editar Pedido
            </h1>
            <p style="font-size:15px; color:#64748b; margin:0;">
                Factura:
                <strong style="color:#1e293b;">{{ $order->invoice_number }}</strong>
            </p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- ── TIMELINE DE ESTADOS ────────────────────────────────────────────── -->
    <div class="hc-card" style="padding:24px; margin-bottom:24px;">
        <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#64748b; margin:0 0 16px;">
            <i class="fa-solid fa-route" style="margin-right:6px; color:var(--hc-green);"></i>Flujo del pedido
        </p>
        <div style="display:flex; align-items:flex-start;">
            @foreach($statusOrder as $i => $st)
                @php
                    $cls = '';
                    if ($i < $currentIdx)       $cls = 'done';
                    elseif ($i === $currentIdx)  $cls = 'active';
                @endphp
                <div class="tl-step {{ $cls }}">
                    <div class="tl-dot">
                        @if($i < $currentIdx)
                            <i class="fa-solid fa-check"></i>
                        @else
                            <i class="fa-solid {{ $statusIcons[$i] }}"></i>
                        @endif
                    </div>
                    <span class="tl-label">{{ $statusLabels[$i] }}</span>
                </div>
            @endforeach
        </div>

        <!-- Botón de avance de estado (si no es el final) -->
        @if($flow && $flow['next'])
            <div style="margin-top:20px; padding:16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                <div>
                    <p style="font-size:13px; color:#64748b; margin:0 0 2px;">Siguiente paso disponible:</p>
                    <p style="font-size:15px; font-weight:700; color:#1e293b; margin:0;">
                        <i class="fa-solid {{ $flow['icon'] }}" style="color:{{ $flow['color'] }}; margin-right:8px;"></i>
                        Cambiar a <strong style="color:{{ $flow['color'] }};">{{ $flow['nextLabel'] }}</strong>
                    </p>
                </div>
                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                    @csrf @method('PUT')
                    <!-- Se envían los mismos datos del pedido + el nuevo estado -->
                    <input type="hidden" name="customer_name"    value="{{ $order->customer_name }}">
                    <input type="hidden" name="customer_number"  value="{{ $order->customer_number }}">
                    <input type="hidden" name="delivery_address" value="{{ $order->delivery_address }}">
                    <input type="hidden" name="order_datetime"   value="{{ $order->order_datetime }}">
                    <input type="hidden" name="notes"            value="{{ $order->notes }}">
                    <input type="hidden" name="status"           value="{{ $flow['next'] }}">
                    <button type="submit"
                            style="background:linear-gradient(135deg,{{ $flow['color'] }}99,{{ $flow['color'] }});color:#fff;border:none;border-radius:12px;padding:12px 28px;font-size:15px;font-weight:700;cursor:pointer;transition:all 0.3s;display:inline-flex;align-items:center;gap:8px;"
                            onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px {{ $flow['color'] }}55'"
                            onmouseout="this.style.transform='';this.style.boxShadow=''">
                        <i class="fa-solid {{ $flow['icon'] }}"></i>
                        Cambiar a {{ $flow['nextLabel'] }}
                    </button>
                </form>
            </div>
        @else
            <div style="margin-top:16px; padding:12px 18px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; font-size:14px; color:var(--hc-green);">
                <i class="fa-solid fa-circle-check" style="margin-right:8px;"></i>
                Este pedido ya fue entregado. Estado final alcanzado.
            </div>
        @endif
    </div>

    <!-- ── FORMULARIO DATOS DEL PEDIDO ───────────────────────────────────── -->
    <div class="hc-card" style="padding:32px;">
        <p style="font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#64748b; margin:0 0 24px;">
            <i class="fa-solid fa-file-lines" style="margin-right:6px; color:var(--hc-green);"></i>Datos del pedido
        </p>

        <!-- Errores de validación -->
        @if($errors->any())
            <div class="hc-alert-error" style="margin-bottom:20px;">
                <p style="font-weight:700; margin:0 0 8px; display:flex; align-items:center; gap:8px;">
                    <i class="fa-solid fa-triangle-exclamation"></i> Corrige los siguientes errores:
                </p>
                <ul style="margin:0; padding-left:20px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf @method('PUT')

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:20px;">

                <!-- Número de factura (solo lectura) -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                        <i class="fa-solid fa-hashtag" style="margin-right:4px;"></i>NÚMERO DE FACTURA
                    </label>
                    <input type="text" value="{{ $order->invoice_number }}" readonly
                           class="hc-input" style="opacity:0.5; cursor:not-allowed;">
                </div>

                <!-- Nombre del cliente -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                        <i class="fa-solid fa-user" style="margin-right:4px;"></i>NOMBRE / RAZÓN SOCIAL *
                    </label>
                    <input type="text" name="customer_name" required
                           value="{{ old('customer_name', $order->customer_name) }}" class="hc-input">
                    @error('customer_name')<p style="color:#ef4444; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>

                <!-- Número de cliente -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                        <i class="fa-solid fa-id-card" style="margin-right:4px;"></i>NÚMERO DE CLIENTE *
                    </label>
                    <input type="text" name="customer_number" required
                           value="{{ old('customer_number', $order->customer_number) }}" class="hc-input">
                    @error('customer_number')<p style="color:#ef4444; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>

                <!-- Dirección -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                        <i class="fa-solid fa-location-dot" style="margin-right:4px;"></i>DIRECCIÓN DE ENTREGA *
                    </label>
                    <input type="text" name="delivery_address" required
                           value="{{ old('delivery_address', $order->delivery_address) }}" class="hc-input">
                    @error('delivery_address')<p style="color:#ef4444; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>

                <!-- Fecha y hora -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                        <i class="fa-solid fa-clock" style="margin-right:4px;"></i>FECHA Y HORA *
                    </label>
                    <input type="datetime-local" name="order_datetime" required
                           value="{{ old('order_datetime', \Carbon\Carbon::parse($order->order_datetime)->format('Y-m-d\TH:i')) }}"
                           class="hc-input">
                    @error('order_datetime')<p style="color:#ef4444; font-size:12px; margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>

                <!-- Estado (solo informativo, no se puede cambiar desde aquí) -->
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                        <i class="fa-solid fa-circle-dot" style="margin-right:4px;"></i>ESTADO ACTUAL
                    </label>
                    @php $sc = ['Ordered'=>['badge-ordered','Ordenado'],'In process'=>['badge-in-process','En proceso'],'In route'=>['badge-in-route','En ruta'],'Delivered'=>['badge-delivered','Entregado']][$order->status] ?? ['badge-archived','—']; @endphp
                    <div class="hc-input" style="display:flex; align-items:center; background:#f8fafc; cursor:not-allowed;">
                        <span class="badge {{ $sc[0] }}">{{ $sc[1] }}</span>
                        <span style="font-size:12px; color:#94a3b8; margin-left:10px;">Usa el botón de arriba para avanzar</span>
                    </div>
                    <!-- Campo oculto para no romper la validación del controlador -->
                    <input type="hidden" name="status" value="{{ $order->status }}">
                </div>

                <!-- Notas (ancho completo) -->
                <div style="grid-column: 1 / -1;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                        <i class="fa-solid fa-note-sticky" style="margin-right:4px;"></i>NOTAS
                    </label>
                    <textarea name="notes" rows="4" class="hc-input" style="resize:vertical;">{{ old('notes', $order->notes) }}</textarea>
                </div>

            </div>

            <hr class="hc-divider">

            <div style="display:flex; gap:14px; justify-content:flex-end; flex-wrap:wrap;">
                <a href="{{ route('orders.show', $order->id) }}" class="btn-secondary">
                    <i class="fa-solid fa-xmark"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar cambios
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
