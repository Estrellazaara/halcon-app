<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Halcon') }}</title>

    <!-- Inter font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite (CSS compilado de Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Navbar glassmorphism */
        .hc-navbar {
            background: rgba(13,27,75,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #1e3a8a;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .hc-nav-link {
            color: #93c5fd;
            font-size: 14px;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .hc-nav-link:hover, .hc-nav-link.active {
            color: #f0f4ff;
            background: rgba(59,130,246,0.15);
        }
        .hc-user-badge {
            background: rgba(59,130,246,0.15);
            border: 1px solid rgba(59,130,246,0.3);
            border-radius: 8px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #93c5fd;
        }
        .hc-logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white;
            box-shadow: 0 4px 12px rgba(59,130,246,0.4);
        }
        /* Hamburger menu mobile */
        #mobile-menu { display: none; }
        @media (max-width: 768px) {
            #nav-links { display: none; }
            #nav-links.open { display: flex; flex-direction: column; }
        }
        /* Footer */
        .hc-footer {
            margin-top: auto;
            border-top: 1px solid transparent;
            border-image: linear-gradient(90deg, transparent, #3b82f6, transparent) 1;
            text-align: center;
            padding: 18px;
            font-size: 12px;
            color: #3d5a99;
        }
    </style>
</head>

<body style="display:flex; flex-direction:column; min-height:100vh;">

    <!-- ── NAVBAR ─────────────────────────────────────────────────────────── -->
    <nav class="hc-navbar">
        <div style="max-width:1280px; margin:0 auto; padding:0 24px; display:flex; align-items:center; justify-content:space-between; height:64px;">

            <!-- Logo -->
            <a href="{{ Auth::check() ? route('dashboard') : route('home') }}"
               style="display:flex; align-items:center; gap:12px; text-decoration:none;">
                <div class="hc-logo-icon">
                    <i class="fa-solid fa-dove"></i>
                </div>
                <span style="font-size:18px; font-weight:700; color:#f0f4ff; letter-spacing:-0.02em;">
                    Halcon
                </span>
            </a>

            <!-- Links de navegación (autenticado) -->
            @auth
            <div id="nav-links" style="display:flex; align-items:center; gap:4px;">
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
                        <i class="fa-solid fa-archive"></i> Archivados
                    </a>
                @endif
            </div>
            @endauth

            <!-- Usuario + logout -->
            <div style="display:flex; align-items:center; gap:12px;">
                @auth
                    <div style="display:flex; flex-direction:column; align-items:flex-end; gap:2px;">
                        <span style="font-size:13px; font-weight:600; color:#f0f4ff;">{{ Auth::user()->name }}</span>
                        <span class="hc-user-badge">{{ Auth::user()->role->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-secondary btn-sm" style="gap:6px;">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden sm:inline">Salir</span>
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn-primary btn-sm">
                        <i class="fa-solid fa-right-to-bracket"></i> Ingresar
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- ── CONTENIDO ──────────────────────────────────────────────────────── -->
    <main style="flex:1; padding: 32px 0;">
        @yield('content')
    </main>

    <!-- ── FOOTER ─────────────────────────────────────────────────────────── -->
    <footer class="hc-footer">
        Halcon App &copy; {{ date('Y') }} &mdash; Sistema de Seguimiento de Pedidos
    </footer>

</body>
</html>
