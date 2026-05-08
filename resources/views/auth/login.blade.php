@extends('layouts.app')

@section('content')
<div style="min-height:calc(100vh - 140px); display:flex; align-items:center; justify-content:center; padding:40px 16px;">

    <div class="hc-card" style="width:100%; max-width:420px; padding:0; overflow:hidden;">

        <!-- Encabezado verde -->
        <div class="hc-card-header" style="text-align:center; padding:28px 32px;">
            <div style="display:inline-flex; align-items:center; justify-content:center; width:56px; height:56px; background:rgba(255,255,255,0.15); border-radius:14px; margin-bottom:16px;">
                <i class="fa-solid fa-lock" style="font-size:24px; color:#ffffff;"></i>
            </div>
            <h2 style="font-size:22px; font-weight:700; color:#ffffff; margin:0 0 4px;">Acceso Administrativo</h2>
            <p style="font-size:13px; color:rgba(255,255,255,0.7); margin:0;">Ingresa tus credenciales para continuar</p>
        </div>

        <!-- Formulario -->
        <div class="hc-card-body" style="padding:32px;">

            @if ($errors->any())
                <div class="hc-alert-error" style="margin-bottom:20px;">
                    <p style="font-weight:700; margin:0 0 6px; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Error de acceso
                    </p>
                    @foreach ($errors->all() as $error)
                        <p style="margin:0; font-size:13px;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <!-- Email -->
                <div style="margin-bottom:18px;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                        <i class="fa-solid fa-envelope" style="margin-right:5px; color:var(--hc-green);"></i>
                        Correo Electrónico
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="correo@ejemplo.com"
                        required
                        autocomplete="email"
                        class="hc-input">
                </div>

                <!-- Password -->
                <div style="margin-bottom:24px;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                        <i class="fa-solid fa-key" style="margin-right:5px; color:var(--hc-green);"></i>
                        Contraseña
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                        class="hc-input">
                </div>

                <!-- Recordarme -->
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:24px;">
                    <input type="checkbox" name="remember" id="remember"
                           style="width:16px; height:16px; accent-color:var(--hc-green); cursor:pointer;">
                    <label for="remember" style="font-size:13px; color:#475569; cursor:pointer;">Mantener sesión iniciada</label>
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:13px; font-size:15px;">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Iniciar Sesión
                </button>
            </form>

            <div style="text-align:center; margin-top:20px;">
                <a href="{{ route('home') }}" style="font-size:13px; color:#94a3b8; display:inline-flex; align-items:center; gap:6px;">
                    <i class="fa-solid fa-arrow-left"></i> Volver al inicio
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
