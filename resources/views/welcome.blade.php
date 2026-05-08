<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halcon — Rastrea tu Pedido</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #0a0f2c 0%, #0d1b4b 100%);
        }

        /* Partículas decorativas de fondo */
        .bg-particles {
            position: fixed; inset: 0; pointer-events: none; overflow: hidden; z-index: 0;
        }
        .particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.06;
            background: #3b82f6;
        }

        /* Tarjeta central con glassmorphism */
        .glass-card {
            background: rgba(17, 34, 102, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(59, 130, 246, 0.25);
            border-radius: 24px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255,255,255,0.04);
            animation: fadeInUp 0.5s ease forwards;
        }

        /* Gradiente en el texto del título */
        .gradient-text {
            background: linear-gradient(135deg, #f0f4ff, #93c5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Timeline ─────────────────────────────────────────────── */
        .timeline-wrap {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 0;
            width: 100%;
            margin: 32px 0 24px;
        }
        .timeline-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
        }
        /* Línea conectora */
        .timeline-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: calc(50% + 20px);
            width: calc(100% - 40px);
            height: 2px;
            background: #1e3a8a;
            transition: background 0.3s;
        }
        .timeline-step.done:not(:last-child)::after  { background: #10b981; }
        .timeline-step.active:not(:last-child)::after { background: linear-gradient(90deg, #3b82f6, #1e3a8a); }

        .timeline-dot {
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            border: 2px solid #1e3a8a;
            background: #0d1b4b;
            color: #3d5a99;
            transition: all 0.3s;
            position: relative; z-index: 1;
        }
        .timeline-step.done  .timeline-dot { background:#10b981; border-color:#10b981; color:#fff; }
        .timeline-step.active .timeline-dot {
            background: #1e40af;
            border-color: #3b82f6;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.3);
            animation: pulseGlow 2s infinite;
        }
        .timeline-label {
            margin-top: 10px;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            color: #3d5a99;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .timeline-step.done   .timeline-label  { color: #10b981; }
        .timeline-step.active .timeline-label  { color: #3b82f6; }

        /* ── Card de resultado ────────────────────────────────────── */
        .result-card {
            background: rgba(17,34,102,0.5);
            border: 1px solid rgba(59,130,246,0.2);
            border-radius: 16px;
            padding: 24px;
            margin-top: 24px;
            animation: fadeInUp 0.4s ease forwards;
        }
        .result-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid rgba(30,58,138,0.5);
            font-size: 14px;
        }
        .result-row:last-child { border-bottom: none; }
        .result-label { color: #93c5fd; font-weight: 500; }
        .result-value { color: #f0f4ff; font-weight: 600; text-align: right; max-width: 60%; }

        /* ── Galería de fotos ─────────────────────────────────────── */
        .photo-gallery {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 20px;
        }
        .photo-item {
            border: 1px solid rgba(59,130,246,0.35);
            border-radius: 12px;
            overflow: hidden;
            background: rgba(13,27,75,0.7);
        }
        .photo-item-label {
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #93c5fd;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid rgba(59,130,246,0.2);
            display: flex; align-items: center; gap: 8px;
        }
        .photo-item img { width: 100%; display: block; }

        @media (max-width: 520px) {
            .photo-gallery { grid-template-columns: 1fr; }
            .timeline-label { font-size: 9px; }
        }
    </style>
</head>

<body>
    <!-- Partículas decorativas -->
    <div class="bg-particles">
        <div class="particle" style="width:500px;height:500px;top:-120px;right:-100px;"></div>
        <div class="particle" style="width:350px;height:350px;bottom:-80px;left:-80px;"></div>
        <div class="particle" style="width:200px;height:200px;top:40%;left:10%;opacity:0.04;"></div>
    </div>

    <!-- ── CONTENIDO PRINCIPAL ───────────────────────────────────────────── -->
    <main style="flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:40px 16px; position:relative; z-index:1;">

        <!-- Logo / título -->
        <div style="text-align:center; margin-bottom:32px;">
            <div style="display:inline-flex; align-items:center; justify-content:center; width:72px; height:72px; background:linear-gradient(135deg,#1e40af,#3b82f6); border-radius:20px; box-shadow:0 12px 32px rgba(59,130,246,0.4); margin-bottom:20px;">
                <i class="fa-solid fa-dove" style="font-size:32px; color:white;"></i>
            </div>
            <h1 style="font-size:32px; font-weight:700; letter-spacing:-0.02em; margin:0 0 8px;" class="gradient-text">
                Halcon
            </h1>
            <p style="font-size:14px; color:#3d5a99; margin:0;">Sistema de Seguimiento de Pedidos</p>
        </div>

        <!-- ── Tarjeta de búsqueda ─────────────────────────────────────── -->
        <div class="glass-card" style="width:100%; max-width:480px; padding:36px;">

            <h2 style="font-size:22px; font-weight:700; color:#f0f4ff; margin:0 0 6px; text-align:center;">
                Rastrea tu pedido
            </h2>
            <p style="font-size:14px; color:#93c5fd; text-align:center; margin:0 0 28px;">
                Ingresa tus datos para ver el estado de tu entrega
            </p>

            <form action="{{ route('public.track') }}" method="GET">
                <!-- Número de cliente -->
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#93c5fd; margin-bottom:8px; letter-spacing:0.04em;">
                        <i class="fa-solid fa-user" style="margin-right:6px; opacity:0.7;"></i>
                        NÚMERO DE CLIENTE
                    </label>
                    <div style="position:relative;">
                        <input
                            type="text"
                            name="customer_number"
                            value="{{ request('customer_number') }}"
                            placeholder="Ej: CL-00123"
                            required
                            class="hc-input"
                            style="padding-left:44px;">
                        <i class="fa-solid fa-id-card" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#3b82f6; font-size:16px;"></i>
                    </div>
                </div>

                <!-- Número de factura -->
                <div style="margin-bottom:24px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#93c5fd; margin-bottom:8px; letter-spacing:0.04em;">
                        <i class="fa-solid fa-file-invoice" style="margin-right:6px; opacity:0.7;"></i>
                        NÚMERO DE FACTURA
                    </label>
                    <div style="position:relative;">
                        <input
                            type="text"
                            name="invoice_number"
                            value="{{ request('invoice_number') }}"
                            placeholder="Ej: HAL-000001"
                            required
                            class="hc-input"
                            style="padding-left:44px;">
                        <i class="fa-solid fa-receipt" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#3b82f6; font-size:16px;"></i>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:14px; font-size:15px; border-radius:12px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Buscar pedido
                </button>
            </form>

            <!-- ── Link admin ──────────────────────────────────────────── -->
            <div style="text-align:center; margin-top:20px;">
                <a href="{{ route('login') }}" style="font-size:13px; color:#3d5a99; transition:color 0.2s;" onmouseover="this.style.color='#93c5fd'" onmouseout="this.style.color='#3d5a99'">
                    <i class="fa-solid fa-lock" style="margin-right:5px;"></i>
                    Acceso administrativo
                </a>
            </div>

        </div><!-- /glass-card búsqueda -->


        @php
            /* Helper de estados para el timeline */
            $statusOrder = ['Ordered', 'In process', 'In route', 'Delivered'];
            $statusLabels = ['Ordenado', 'En proceso', 'En ruta', 'Entregado'];
            $statusIcons  = ['fa-box', 'fa-gear', 'fa-truck', 'fa-circle-check'];
        @endphp

        <!-- ── Resultado ─────────────────────────────────────────────────── -->
        @isset($order)
            @php
                $currentIdx = array_search($order->status, $statusOrder);
            @endphp

            <div style="width:100%; max-width:560px; margin-top:32px;">

                <!-- Timeline visual -->
                <div class="glass-card" style="padding:28px 20px;">
                    <p style="font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.12em; color:#93c5fd; margin:0 0 4px;">Estado del pedido</p>
                    <p style="font-size:22px; font-weight:700; color:#f0f4ff; margin:0 0 20px;">
                        {{ $order->invoice_number }}
                    </p>

                    <!-- Timeline de 4 pasos -->
                    <div class="timeline-wrap">
                        @foreach($statusOrder as $i => $st)
                            @php
                                $stepClass = '';
                                if ($i < $currentIdx)      $stepClass = 'done';
                                elseif ($i === $currentIdx) $stepClass = 'active';
                            @endphp
                            <div class="timeline-step {{ $stepClass }}">
                                <div class="timeline-dot">
                                    @if($i < $currentIdx)
                                        <i class="fa-solid fa-check"></i>
                                    @else
                                        <i class="fa-solid {{ $statusIcons[$i] }}"></i>
                                    @endif
                                </div>
                                <span class="timeline-label">{{ $statusLabels[$i] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Datos del pedido -->
                    <div class="result-card">
                        <div class="result-row">
                            <span class="result-label"><i class="fa-solid fa-receipt" style="margin-right:6px;"></i>Factura</span>
                            <span class="result-value">{{ $order->invoice_number }}</span>
                        </div>
                        <div class="result-row">
                            <span class="result-label"><i class="fa-solid fa-user" style="margin-right:6px;"></i>Cliente</span>
                            <span class="result-value">{{ $order->customer_name }}</span>
                        </div>
                        <div class="result-row">
                            <span class="result-label"><i class="fa-solid fa-calendar" style="margin-right:6px;"></i>Fecha</span>
                            <span class="result-value">{{ $order->order_datetime ? $order->order_datetime->format('d/m/Y H:i') : '—' }}</span>
                        </div>
                        <div class="result-row">
                            <span class="result-label"><i class="fa-solid fa-location-dot" style="margin-right:6px;"></i>Dirección</span>
                            <span class="result-value">{{ $order->delivery_address }}</span>
                        </div>
                    </div>

                    <!-- Fotos de evidencia si está Entregado -->
                    @if($order->status === 'Delivered')
                        <div style="margin-top:24px;">
                            <p style="font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#10b981; margin:0 0 14px;">
                                <i class="fa-solid fa-camera" style="margin-right:6px;"></i>
                                Evidencia de entrega
                            </p>

                            <div class="photo-gallery">
                                @if($order->photo_loaded)
                                    <div class="photo-item">
                                        <div class="photo-item-label">
                                            <i class="fa-solid fa-truck-loading"></i> Unidad cargada
                                        </div>
                                        <img src="{{ asset('storage/' . $order->photo_loaded) }}" alt="Unidad cargada">
                                    </div>
                                @endif

                                @if($order->photo_delivered)
                                    <div class="photo-item">
                                        <div class="photo-item-label">
                                            <i class="fa-solid fa-box-open"></i> Material entregado
                                        </div>
                                        <img src="{{ asset('storage/' . $order->photo_delivered) }}" alt="Material entregado">
                                    </div>
                                @endif

                                @if(!$order->photo_loaded && !$order->photo_delivered)
                                    {{-- Fallback: fotos de la tabla order_photos --}}
                                    @php $deliveredPhoto = $order->photos->where('type','delivered')->first(); @endphp
                                    @if($deliveredPhoto)
                                        <div class="photo-item" style="grid-column:1/-1;">
                                            <div class="photo-item-label">
                                                <i class="fa-solid fa-box-open"></i> Material entregado
                                            </div>
                                            <img src="{{ asset('storage/' . $deliveredPhoto->photo_path) }}" alt="Entregado">
                                        </div>
                                    @else
                                        <p style="color:#3d5a99; font-size:13px; grid-column:1/-1;">
                                            <i class="fa-solid fa-image-slash" style="margin-right:6px;"></i>
                                            Las fotos de evidencia aún no han sido subidas.
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($order->status === 'In process')
                        <div style="margin-top:20px; padding:14px 18px; background:rgba(245,158,11,0.1); border:1px solid rgba(245,158,11,0.3); border-radius:12px; font-size:13px; color:#f59e0b;">
                            <i class="fa-solid fa-gear fa-spin" style="margin-right:8px;"></i>
                            Tu pedido está siendo preparado en almacén.
                        </div>
                    @elseif($order->status === 'In route')
                        <div style="margin-top:20px; padding:14px 18px; background:rgba(139,92,246,0.1); border:1px solid rgba(139,92,246,0.3); border-radius:12px; font-size:13px; color:#8b5cf6;">
                            <i class="fa-solid fa-truck fa-bounce" style="margin-right:8px;"></i>
                            Tu pedido está en camino a tu dirección.
                        </div>
                    @endif

                </div><!-- /glass-card resultado -->
            </div>

        @elseif(request('invoice_number') || request('customer_number'))
            <!-- Pedido no encontrado -->
            <div class="glass-card" style="width:100%; max-width:480px; margin-top:24px; padding:32px; text-align:center;">
                <div style="font-size:48px; color:#1e3a8a; margin-bottom:16px;">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 style="font-size:18px; font-weight:700; color:#ef4444; margin:0 0 8px;">Pedido no encontrado</h3>
                <p style="font-size:14px; color:#93c5fd; margin:0;">
                    No encontramos ningún pedido con esos datos.<br>Verifica el número de factura y de cliente.
                </p>
            </div>
        @endif

    </main>

    <!-- ── FOOTER ─────────────────────────────────────────────────────────── -->
    <footer style="text-align:center; padding:20px; font-size:12px; color:#1e3a8a; position:relative; z-index:1;">
        Halcon &copy; {{ date('Y') }} &mdash; Sistema de Seguimiento de Pedidos
    </footer>

</body>
</html>
