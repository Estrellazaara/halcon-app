<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Halcon') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-slate-900">
    <div class="min-h-screen">
        <nav class="bg-surface border-b border-slate-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-violet-500 to-indigo-500 flex items-center justify-center text-white font-bold shadow-lg shadow-violet-500/20">
                            H
                        </div>
                        <a href="{{ route('dashboard') }}" class="text-lg font-semibold tracking-wide text-white">
                            Halcon Admin
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        @auth
                            <div class="hidden sm:flex flex-col text-right">
                                <span class="text-sm text-white">Bienvenido, {{ Auth::user()->name }}</span>
                                <span class="text-xs text-white">{{ Auth::user()->role->name }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn-secondary">Cerrar Sesión</button>
                            </form>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="btn-secondary">Iniciar Sesión</a>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            @yield('content')
        </main>
    </div>
</body>
</html>