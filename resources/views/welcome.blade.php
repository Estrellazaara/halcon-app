<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halcón Paquetería — Rastrea tu Pedido</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f0f4f8;
        }

        /* Panel izquierdo verde */
        .hero-split {
            display: flex;
            min-height: 100vh;
        }
        .hero-left {
            flex: 0 0 42%;
            background: linear-gradient(160deg, #166534 0%, #14532d 60%, #0f172a 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }
        .hero-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-left-content { position: relative; z-index: 1; text-align: center; }

        .hero-logo {
            height: 110px;
            width: auto;
            filter: drop-shadow(0 8px 24px rgba(0,0,0,0.4));
            margin-bottom: 24px;
        }
        .hero-title {
            font-size: 36px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.02em;
            line-height: 1;
            margin: 0 0 6px;
        }
        .hero-sub {
            font-size: 12px;
            font-weight: 700;
            color: #86efac;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            margin: 0 0 32px;
        }
        .hero-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.7);
            line-height: 1.7;
            max-width: 280px;
            margin: 0 auto 40px;
        }
        .hero-stats {
            display: flex;
            gap: 24px;
            justify-content: center;
        }
        .hero-stat {
            text-align: center;
        }
        .hero-stat-num {
            font-size: 28px;
            font-weight: 800;
            color: #86efac;
            line-height: 1;
        }
        .hero-stat-label {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .hero-divider {
            width: 1px;
            height: 40px;
            background: rgba(255,255,255,0.15);
        }

        /* Panel derecho — formulario */
        .hero-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
        }

        /* Card de búsqueda */
        .search-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            animation: fadeInUp 0.4s ease forwards;
        }
        .search-card-head {
            background: var(--hc-green);
            padding: 20px 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 3px solid var(--hc-orange);
        }

        /* Timeline */
        .tl-wrap { display:flex; align-items:flex-start; width:100%; margin:28px 0 20px; }
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
            border:2px solid #cbd5e1; background:#f8fafc; color:#94a3b8;
            font-size:14px; transition:all 0.3s; position:relative; z-index:1;
        }
        .tl-step.done  .tl-dot { background:var(--hc-green); border-color:var(--hc-green); color:#fff; }
        .tl-step.active .tl-dot {
            background:var(--hc-green-mid); border-color:var(--hc-green-mid); color:#fff;
            box-shadow:0 0 0 4px rgba(22,101,52,0.2);
            animation:pulseGlow 2s infinite;
        }
        .tl-label { margin-top:8px; font-size:9px; font-weight:700; text-align:center;
            text-transform:uppercase; letter-spacing:0.05em; color:#94a3b8; }
        .tl-step.done   .tl-label { color:var(--hc-green); }
        .tl-step.active .tl-label { color:var(--hc-green-mid); }

        /* Result rows */
        .result-row {
            display:flex; justify-content:space-between; align-items:center;
            padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:14px;
        }
        .result-row:last-child { border-bottom:none; }
        .result-label { color:#64748b; font-weight:500; display:flex; align-items:center; gap:6px; }
        .result-value { color:#1e293b; font-weight:600; text-align:right; max-width:60%; }

        @media (max-width: 768px) {
            .hero-split { flex-direction: column; }
            .hero-left  { flex: none; min-height: auto; padding: 40px 24px; }
            .hero-right { padding: 32px 20px; }
            .hero-logo  { height: 80px; }
            .hero-title { font-size: 28px; }
        }
    </style>
</head>

<body>
<div class="hero-split">

    <!-- ══ PANEL IZQUIERDO ════════════════════════════════════════════════════ -->
    <div class="hero-left">
        <div class="hero-left-content">
            <img src="{{ asset('logo.png') }}" alt="Halcón Paquetería" class="hero-logo">
            <h1 class="hero-title">Halcón</h1>
            <p class="hero-sub">Paquetería</p>
            <p class="hero-desc">
                Rastrea el estado de tu pedido en tiempo real. Solo necesitas tu número de cliente y número de factura.
            </p>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-num">4</div>
                    <div class="hero-stat-label">Estados</div>
                </div>
                <div class="hero-divider"></div>
                <div class="hero-stat">
                    <div class="hero-stat-num">24/7</div>
                    <div class="hero-stat-label">Disponible</div>
                </div>
                <div class="hero-divider"></div>
                <div class="hero-stat">
                    <div class="hero-stat-num">100%</div>
                    <div class="hero-stat-label">En línea</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ══ PANEL DERECHO ══════════════════════════════════════════════════════ -->
    <div class="hero-right">

        <!-- Tarjeta de búsqueda -->
        <div class="search-card">

            <div class="search-card-head">
                <div style="width:40px; height:40px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-magnifying-glass" style="font-size:18px; color:#fff;"></i>
                </div>
                <div>
                    <div style="font-size:16px; font-weight:700; color:#fff;">Rastrea tu pedido</div>
                    <div style="font-size:12px; color:rgba(255,255,255,0.7);">Ingresa tus datos de cliente</div>
                </div>
            </div>

            <div style="padding:28px;">

                <form action="{{ route('public.track') }}" method="GET">

                    <!-- Número de cliente -->
                    <div style="margin-bottom:16px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-id-card" style="margin-right:5px; color:var(--hc-green);"></i>
                            Número de Cliente
                        </label>
                        <input
                            type="text"
                            name="customer_number"
                            value="{{ request('customer_number') }}"
                            placeholder="Ej: CL-00123"
                            required
                            class="hc-input">
                    </div>

                    <!-- Número de factura -->
                    <div style="margin-bottom:24px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-receipt" style="margin-right:5px; color:var(--hc-green);"></i>
                            Número de Factura
                        </label>
                        <input
                            type="text"
                            name="invoice_number"
                            value="{{ request('invoice_number') }}"
                            placeholder="Ej: HAL-000001"
                            required
                            class="hc-input">
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:13px; font-size:15px;">
                        <i class="fa-solid fa-magnifying-glass"></i> Buscar pedido
                    </button>

                </form>

                <div style="text-align:center; margin-top:18px;">
                    <a href="{{ route('login') }}" style="font-size:13px; color:#94a3b8; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-lock"></i> Acceso administrativo
                    </a>
                </div>

            </div>
        </div><!-- /search-card -->


        @php
            $statusOrder  = ['Ordered', 'In process', 'In route', 'Delivered'];
            $statusLabels = ['Ordenado', 'En proceso', 'En ruta', 'Entregado'];
            $statusIcons  = ['fa-box', 'fa-gear', 'fa-truck', 'fa-circle-check'];
        @endphp

        <!-- ── Resultado ──────────────────────────────────────────────────── -->
        @isset($order)
            @php $currentIdx = array_search($order->status, $statusOrder); @endphp

            <div style="width:100%; max-width:500px; margin-top:24px; animation: fadeInUp 0.4s ease forwards;">

                <div class="hc-card" style="padding:0; overflow:hidden;">
                    <div class="hc-card-header">
                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            <div>
                                <div style="font-size:12px; opacity:0.8; margin-bottom:2px;">Estado del pedido</div>
                                <div style="font-size:18px; font-weight:700;">{{ $order->invoice_number }}</div>
                            </div>
                            <span class="badge
                                @if($order->status === 'Delivered') badge-delivered
                                @elseif($order->status === 'In route') badge-in-route
                                @elseif($order->status === 'In process') badge-in-process
                                @else badge-ordered @endif">
                                @if($order->status === 'Ordered')     <i class="fa-solid fa-box"></i> Ordenado
                                @elseif($order->status === 'In process') <i class="fa-solid fa-gear"></i> En proceso
                                @elseif($order->status === 'In route')   <i class="fa-solid fa-truck"></i> En ruta
                                @else <i class="fa-solid fa-circle-check"></i> Entregado
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="hc-card-body">

                        <!-- Timeline -->
                        <div class="tl-wrap">
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

                        <hr class="hc-divider">

                        <!-- Datos -->
                        <div class="result-row">
                            <span class="result-label"><i class="fa-solid fa-user"></i> Cliente</span>
                            <span class="result-value">{{ $order->customer_name }}</span>
                        </div>
                        <div class="result-row">
                            <span class="result-label"><i class="fa-solid fa-calendar"></i> Fecha</span>
                            <span class="result-value">{{ $order->order_datetime ? $order->order_datetime->format('d/m/Y H:i') : '—' }}</span>
                        </div>
                        <div class="result-row">
                            <span class="result-label"><i class="fa-solid fa-location-dot"></i> Dirección</span>
                            <span class="result-value">{{ $order->delivery_address }}</span>
                        </div>

                        @if($order->status === 'In process')
                            <div style="margin-top:16px; padding:12px 16px; background:#fef3c7; border:1px solid #fcd34d; border-radius:10px; font-size:13px; color:#92400e; display:flex; align-items:center; gap:8px;">
                                <i class="fa-solid fa-gear fa-spin"></i>
                                Tu pedido está siendo preparado en almacén.
                            </div>
                        @elseif($order->status === 'In route')
                            <div style="margin-top:16px; padding:12px 16px; background:#ede9fe; border:1px solid #c4b5fd; border-radius:10px; font-size:13px; color:#6d28d9; display:flex; align-items:center; gap:8px;">
                                <i class="fa-solid fa-truck fa-bounce"></i>
                                Tu pedido está en camino a tu dirección.
                            </div>
                        @elseif($order->status === 'Delivered')
                            <div style="margin-top:16px; padding:12px 16px; background:#dcfce7; border:1px solid #86efac; border-radius:10px; font-size:13px; color:#166534; display:flex; align-items:center; gap:8px;">
                                <i class="fa-solid fa-circle-check"></i>
                                ¡Tu pedido fue entregado exitosamente!
                            </div>

                            <!-- Fotos de evidencia -->
                            @if($order->photo_loaded || $order->photo_delivered)
                                <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#64748b; margin:20px 0 12px; display:flex; align-items:center; gap:6px;">
                                    <i class="fa-solid fa-camera" style="color:var(--hc-green);"></i> Evidencia de entrega
                                </p>
                                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                                    @if($order->photo_loaded)
                                        <div style="border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
                                            <div style="padding:8px 12px; font-size:11px; font-weight:700; color:#475569; background:#f8fafc; border-bottom:1px solid #e2e8f0; text-transform:uppercase; letter-spacing:0.06em;">
                                                <i class="fa-solid fa-truck" style="margin-right:4px; color:var(--hc-green);"></i> Cargada
                                            </div>
                                            <img src="{{ asset('storage/' . $order->photo_loaded) }}" alt="Unidad cargada" style="width:100%; display:block;">
                                        </div>
                                    @endif
                                    @if($order->photo_delivered)
                                        <div style="border:1px solid #e2e8f0; border-radius:10px; overflow:hidden;">
                                            <div style="padding:8px 12px; font-size:11px; font-weight:700; color:#475569; background:#f8fafc; border-bottom:1px solid #e2e8f0; text-transform:uppercase; letter-spacing:0.06em;">
                                                <i class="fa-solid fa-box-open" style="margin-right:4px; color:var(--hc-green);"></i> Entregada
                                            </div>
                                            <img src="{{ asset('storage/' . $order->photo_delivered) }}" alt="Material entregado" style="width:100%; display:block;">
                                        </div>
                                    @endif
                                </div>
                            @else
                                @php $fallback = $order->photos->where('type','delivered')->first(); @endphp
                                @if($fallback)
                                    <div style="border:1px solid #e2e8f0; border-radius:10px; overflow:hidden; margin-top:16px;">
                                        <div style="padding:8px 12px; font-size:11px; font-weight:700; color:#475569; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                                            <i class="fa-solid fa-box-open" style="margin-right:4px; color:var(--hc-green);"></i> Material entregado
                                        </div>
                                        <img src="{{ asset('storage/' . $fallback->photo_path) }}" alt="Entregado" style="width:100%; display:block;">
                                    </div>
                                @endif
                            @endif
                        @endif

                    </div>
                </div>

            </div>

        @elseif(request('invoice_number') || request('customer_number'))
            <div class="hc-card" style="width:100%; max-width:500px; margin-top:24px; padding:32px; text-align:center;">
                <i class="fa-solid fa-box-open" style="font-size:44px; color:#cbd5e1; display:block; margin-bottom:16px;"></i>
                <h3 style="font-size:18px; font-weight:700; color:var(--hc-danger); margin:0 0 8px;">Pedido no encontrado</h3>
                <p style="font-size:14px; color:#64748b; margin:0;">
                    No encontramos ningún pedido con esos datos.<br>Verifica el número de factura y de cliente.
                </p>
            </div>
        @endif

    </div><!-- /hero-right -->

</div><!-- /hero-split -->
</body>
</html>
