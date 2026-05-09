<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Halcón') }} — Paquetería</title>

    <!-- Inter font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* ── Navbar interior ─────────────────────────────────────────────── */
    .nav-inner {
        max-width: 1280px; margin: 0 auto; padding: 0 24px;
        display: flex; align-items: center; justify-content: space-between;
        height: 68px; gap: 20px;
    }
    /* Logo contenedor */
    .nav-logo-wrap {
        display: flex; align-items: center; gap: 10px;
        text-decoration: none; flex-shrink: 0;
    }
    .nav-logo-img {
        height: 52px; width: auto;
        filter: drop-shadow(0 2px 8px rgba(234,88,12,0.4));
    }
    .nav-logo-text {
        display: flex; flex-direction: column;
    }
    .nav-logo-title {
        font-size: 20px; font-weight: 800; color: #ffffff;
        letter-spacing: -0.02em; line-height: 1;
    }
    .nav-logo-sub {
        font-size: 10px; font-weight: 600; color: #86efac;
        text-transform: uppercase; letter-spacing: 0.12em;
    }
    /* Links de navegación */
    .nav-links { display: flex; align-items: center; gap: 4px; }
    /* Info del usuario */
    .nav-user {
        display: flex; align-items: center; gap: 12px; flex-shrink: 0;
    }
    .nav-user-info { display: flex; flex-direction: column; align-items: flex-end; gap: 2px; }
    .nav-user-name { font-size: 13px; font-weight: 600; color: #f1f5f9; line-height:1; }
    /* Línea de acento naranja bajo el navbar */
    .nav-orange-bar {
        height: 3px;
        background: linear-gradient(90deg, var(--hc-orange), #fbbf24, var(--hc-orange));
    }
    /* ── Page wrapper ────────────────────────────────────────────────── */
    .page-wrap {
        min-height: calc(100vh - 71px);
        background: var(--hc-page-bg);
    }
    /* ── Footer ──────────────────────────────────────────────────────── */
    .site-footer {
        background: #0f172a;
        border-top: 3px solid var(--hc-orange);
        text-align: center;
        padding: 16px 24px;
        font-size: 12px;
        color: #64748b;
    }
    .site-footer span { color: #86efac; }
    /* Mobile */
    @media (max-width: 768px) {
        .nav-links { display: none; }
        .nav-logo-text { display: none; }
    }
    </style>
</head>

<body style="display:flex;flex-direction:column;min-height:100vh;background:var(--hc-page-bg);">

    <!-- ══ NAVBAR ════════════════════════════════════════════════════════════ -->
    <nav class="hc-navbar">
        <div class="nav-inner">

            <!-- Logo -->
            <a href="{{ Auth::check() ? route('dashboard') : route('home') }}" class="nav-logo-wrap">
                <img src="{{ asset('logo.png') }}" alt="Halcón Paquetería" class="nav-logo-img">
                <div class="nav-logo-text">
                    <span class="nav-logo-title">Halcón</span>
                    <span class="nav-logo-sub">Paquetería</span>
                </div>
            </a>

            <!-- Links por rol -->
            @auth
            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="hc-nav-link">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
                @if(in_array(Auth::user()->role->name, ['Admin','Sales','Warehouse','Route','Purchasing']))
                    <a href="{{ route('orders.index') }}" class="hc-nav-link">
                        <i class="fa-solid fa-box"></i> Pedidos
                    </a>
                @endif
                @if(in_array(Auth::user()->role->name, ['Admin','Sales','Purchasing','Warehouse']))
                    <a href="{{ route('products.index') }}" class="hc-nav-link">
                        <i class="fa-solid fa-tags"></i> Productos
                    </a>
                @endif
                @if(Auth::user()->role->name === 'Admin')
                    <a href="{{ route('users.index') }}" class="hc-nav-link">
                        <i class="fa-solid fa-users"></i> Usuarios
                    </a>
                    <a href="{{ route('orders.archived') }}" class="hc-nav-link">
                        <i class="fa-solid fa-box-archive"></i> Archivados
                    </a>
                @endif
            </div>
            @endauth

            <!-- Usuario + logout -->
            <div class="nav-user">
                @auth
                    <div class="nav-user-info">
                        <span class="nav-user-name">{{ Auth::user()->name }}</span>
                        <span class="hc-role-badge">{{ Auth::user()->role->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-secondary btn-sm"
                                style="color:#f1f5f9!important;border-color:#334155;background:transparent;">
                            <i class="fa-solid fa-right-from-bracket"></i> Salir
                        </button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn-orange btn-sm">
                        <i class="fa-solid fa-right-to-bracket"></i> Ingresar
                    </a>
                @endguest
            </div>

        </div>
        <div class="nav-orange-bar"></div>
    </nav>

    <!-- ══ CONTENIDO ═════════════════════════════════════════════════════════ -->
    <div class="page-wrap">
        <main style="padding:32px 0;">
            @yield('content')
        </main>
    </div>

    <!-- ══ FOOTER ════════════════════════════════════════════════════════════ -->
    <footer class="site-footer">
        <span>Halcón Paquetería</span> &copy; {{ date('Y') }} &mdash; Sistema de Seguimiento de Pedidos
    </footer>

</body>
</html>
