@extends('layouts.app')

@section('content')

@php
$statusMap = [
    'Ordered'    => ['class'=>'badge-ordered',    'label'=>'Ordenado',   'icon'=>'fa-box'],
    'In process' => ['class'=>'badge-in-process', 'label'=>'En proceso', 'icon'=>'fa-gear'],
    'In route'   => ['class'=>'badge-in-route',   'label'=>'En ruta',    'icon'=>'fa-truck'],
    'Delivered'  => ['class'=>'badge-delivered',  'label'=>'Entregado',  'icon'=>'fa-circle-check'],
];
$statusOrder  = ['Ordered', 'In process', 'In route', 'Delivered'];
$statusLabels = ['Ordenado', 'En proceso', 'En ruta', 'Entregado'];
$statusIcons  = ['fa-box', 'fa-gear', 'fa-truck', 'fa-circle-check'];
$currentIdx   = array_search($order->status, $statusOrder);
$sc           = $statusMap[$order->status] ?? ['class'=>'badge-archived','label'=>$order->status,'icon'=>'fa-circle'];
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

<div style="max-width:960px; margin:0 auto; padding:0 24px;">

    <!-- ── HEADER ─────────────────────────────────────────────────────────── -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#1e293b; letter-spacing:-0.02em; margin:0 0 4px;">
                <i class="fa-solid fa-file-lines" style="color:var(--hc-green); margin-right:10px;"></i>
                Detalle del Pedido
            </h1>
            <p style="font-size:14px; color:#64748b; margin:0;">
                Factura: <strong style="color:#1e293b;">{{ $order->invoice_number }}</strong>
            </p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            @if(auth()->user()->hasRole('Admin'))
                <a href="{{ route('orders.edit', $order->id) }}" class="btn-warning btn-sm">
                    <i class="fa-solid fa-pen"></i> Editar
                </a>
            @endif
            <a href="{{ route('orders.index') }}" class="btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="hc-alert-success" style="margin-bottom:20px; display:flex; align-items:center; gap:10px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <!-- ── TIMELINE ───────────────────────────────────────────────────────── -->
    <div class="hc-card" style="padding:24px; margin-bottom:24px;">
        <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#64748b; margin:0 0 20px;">
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
        <div style="margin-top:16px; display:flex; align-items:center; gap:10px;">
            <span class="badge {{ $sc['class'] }}">
                <i class="fa-solid {{ $sc['icon'] }}"></i> {{ $sc['label'] }}
            </span>
            <span style="font-size:13px; color:#64748b;">— Estado actual</span>
        </div>
    </div>

    <!-- ── DATOS DEL PEDIDO ───────────────────────────────────────────────── -->
    <div class="hc-card" style="padding:0; overflow:hidden; margin-bottom:24px;">
        <div class="hc-card-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-circle-info"></i>
                <span style="font-size:15px; font-weight:700;">Información del Pedido</span>
            </div>
        </div>
        <div class="hc-card-body">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:20px;">

                <div class="hc-section">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 6px;">
                        <i class="fa-solid fa-hashtag" style="margin-right:4px;"></i>Número de Factura
                    </p>
                    <p style="font-size:16px; font-weight:700; color:var(--hc-green); margin:0;">{{ $order->invoice_number }}</p>
                </div>

                <div class="hc-section">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 6px;">
                        <i class="fa-solid fa-user" style="margin-right:4px;"></i>Cliente
                    </p>
                    <p style="font-size:15px; font-weight:600; color:#1e293b; margin:0 0 3px;">{{ $order->customer_name }}</p>
                    <p style="font-size:13px; color:#64748b; margin:0;">{{ $order->customer_number }}</p>
                </div>

                <div class="hc-section">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 6px;">
                        <i class="fa-solid fa-calendar" style="margin-right:4px;"></i>Fecha del Pedido
                    </p>
                    <p style="font-size:15px; font-weight:600; color:#1e293b; margin:0;">
                        {{ $order->order_datetime ? $order->order_datetime->format('d/m/Y H:i') : '—' }}
                    </p>
                </div>

                <div class="hc-section">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 6px;">
                        <i class="fa-solid fa-file-invoice" style="margin-right:4px;"></i>Datos Fiscales
                    </p>
                    <p style="font-size:14px; color:#1e293b; margin:0;">{{ $order->fiscal_data }}</p>
                </div>

                <div class="hc-section" style="grid-column: 1 / -1;">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 6px;">
                        <i class="fa-solid fa-location-dot" style="margin-right:4px;"></i>Dirección de Entrega
                    </p>
                    <p style="font-size:14px; color:#1e293b; margin:0;">{{ $order->delivery_address }}</p>
                </div>

                @if($order->notes)
                <div class="hc-section" style="grid-column: 1 / -1;">
                    <p style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.08em; margin:0 0 6px;">
                        <i class="fa-solid fa-note-sticky" style="margin-right:4px;"></i>Notas
                    </p>
                    <p style="font-size:14px; color:#1e293b; margin:0;">{{ $order->notes }}</p>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!-- ── PRODUCTOS ─────────────────────────────────────────────────────── -->
    <div class="hc-card" style="padding:0; overflow:hidden; margin-bottom:24px;">
        <div class="hc-card-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-boxes-stacked"></i>
                <span style="font-size:15px; font-weight:700;">Productos del Pedido</span>
            </div>
        </div>
        @if($order->items->isEmpty())
            <div class="hc-card-body" style="text-align:center; padding:40px;">
                <i class="fa-solid fa-box-open" style="font-size:40px; color:#cbd5e1; display:block; margin-bottom:12px;"></i>
                <p style="color:#94a3b8; font-size:14px; margin:0;">Sin productos asignados a este pedido.</p>
            </div>
        @else
            <table class="hc-table">
                <thead>
                    <tr>
                        <th><i class="fa-solid fa-hashtag" style="margin-right:5px;"></i>ID</th>
                        <th><i class="fa-solid fa-tag" style="margin-right:5px;"></i>Producto</th>
                        <th><i class="fa-solid fa-cubes" style="margin-right:5px;"></i>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td style="font-size:13px; color:#94a3b8;">{{ $item->id }}</td>
                            <td style="font-weight:600; color:#1e293b;">{{ $item->product->name ?? '—' }}</td>
                            <td>
                                <span style="background:#f0fdf4; color:var(--hc-green); padding:3px 10px; border-radius:20px; font-size:13px; font-weight:600; border:1px solid #bbf7d0;">
                                    {{ $item->quantity }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- ── FOTOS ─────────────────────────────────────────────────────────── -->
    <div class="hc-card" style="padding:0; overflow:hidden; margin-bottom:24px;">
        <div class="hc-card-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <i class="fa-solid fa-camera"></i>
                <span style="font-size:15px; font-weight:700;">Fotos de Evidencia</span>
            </div>
        </div>
        <div class="hc-card-body">
            @php
                $hasNewPhotos = $order->photo_loaded || $order->photo_delivered;
                $hasOldPhotos = $order->photos->isNotEmpty();
            @endphp

            @if($hasNewPhotos || $hasOldPhotos)
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:16px;">

                    @if($order->photo_loaded)
                        <div class="hc-section" style="padding:0; overflow:hidden;">
                            <div style="padding:12px 16px; font-size:12px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.08em; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; gap:8px;">
                                <i class="fa-solid fa-truck" style="color:var(--hc-green);"></i> Unidad Cargada
                            </div>
                            <img src="{{ asset('storage/' . $order->photo_loaded) }}" alt="Unidad cargada"
                                 style="width:100%; display:block; max-height:280px; object-fit:cover;">
                        </div>
                    @endif

                    @if($order->photo_delivered)
                        <div class="hc-section" style="padding:0; overflow:hidden;">
                            <div style="padding:12px 16px; font-size:12px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.08em; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; gap:8px;">
                                <i class="fa-solid fa-box-open" style="color:var(--hc-green);"></i> Material Entregado
                            </div>
                            <img src="{{ asset('storage/' . $order->photo_delivered) }}" alt="Material entregado"
                                 style="width:100%; display:block; max-height:280px; object-fit:cover;">
                        </div>
                    @endif

                    @if(!$hasNewPhotos)
                        @foreach($order->photos as $photo)
                            <div class="hc-section" style="padding:0; overflow:hidden;">
                                <div style="padding:12px 16px; font-size:12px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.08em; border-bottom:1px solid #e2e8f0;">
                                    <i class="fa-solid fa-image" style="color:var(--hc-green); margin-right:6px;"></i>{{ $photo->type }}
                                </div>
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ $photo->type }}"
                                     style="width:100%; display:block; max-height:280px; object-fit:cover;">
                            </div>
                        @endforeach
                    @endif

                </div>
            @else
                <div style="text-align:center; padding:40px;">
                    <i class="fa-solid fa-image-slash" style="font-size:40px; color:#cbd5e1; display:block; margin-bottom:12px;"></i>
                    <p style="color:#94a3b8; font-size:14px; margin:0 0 16px;">Sin fotos de evidencia todavía.</p>
                    @if(auth()->user()->hasRole('Route') || auth()->user()->hasRole('Admin'))
                        <a href="{{ route('orders.upload-photos.form', $order->id) }}" class="btn-primary btn-sm">
                            <i class="fa-solid fa-camera"></i> Subir Fotos
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- ── ACCIONES ───────────────────────────────────────────────────────── -->
    @if(auth()->user()->hasRole('Admin') && !$order->is_deleted)
        <div style="display:flex; justify-content:flex-end; margin-bottom:24px;">
            <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                  onsubmit="return confirm('¿Archivar este pedido? Podrás restaurarlo después.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fa-solid fa-box-archive"></i> Archivar Pedido
                </button>
            </form>
        </div>
    @endif

</div>
@endsection
