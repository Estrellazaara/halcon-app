@extends('layouts.app')

@section('content')
<div style="max-width:800px; margin:0 auto; padding:0 24px;">

    <!-- ── HEADER ─────────────────────────────────────────────────────────── -->
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
        <div>
            <h1 style="font-size:26px; font-weight:700; color:#1e293b; letter-spacing:-0.02em; margin:0 0 4px;">
                <i class="fa-solid fa-user-pen" style="color:var(--hc-green); margin-right:10px;"></i>
                Editar Usuario
            </h1>
            <p style="font-size:13px; color:#64748b; margin:0;">{{ $user->name }}</p>
        </div>
        <a href="{{ route('users.index') }}" class="btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="hc-card" style="padding:0; overflow:hidden;">

        <div class="hc-card-header">
            <div style="display:flex; align-items:center; gap:12px;">
                <i class="fa-solid fa-id-badge" style="font-size:20px;"></i>
                <div>
                    <div style="font-size:16px; font-weight:700;">Datos del Usuario</div>
                    <div style="font-size:12px; opacity:0.8;">Deja la contraseña en blanco para no cambiarla</div>
                </div>
            </div>
        </div>

        <div class="hc-card-body">

            @if ($errors->any())
                <div class="hc-alert-error" style="margin-bottom:24px;">
                    <p style="font-weight:700; margin:0 0 8px; display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Por favor corrige los siguientes errores:
                    </p>
                    <ul style="margin:0; padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li style="font-size:13px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:20px;">

                    <!-- Nombre -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-user" style="margin-right:4px; color:var(--hc-green);"></i>
                            Nombre *
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="hc-input @error('name') border-red-400 @enderror">
                        @error('name')
                            <p style="color:#dc2626; font-size:12px; margin:5px 0 0;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-envelope" style="margin-right:4px; color:var(--hc-green);"></i>
                            Correo Electrónico *
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="hc-input @error('email') border-red-400 @enderror">
                        @error('email')
                            <p style="color:#dc2626; font-size:12px; margin:5px 0 0;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nueva contraseña -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-key" style="margin-right:4px; color:var(--hc-green);"></i>
                            Nueva Contraseña
                        </label>
                        <input type="password" name="password"
                               placeholder="Dejar en blanco para no cambiar"
                               class="hc-input @error('password') border-red-400 @enderror">
                        @error('password')
                            <p style="color:#dc2626; font-size:12px; margin:5px 0 0;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rol -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-shield-halved" style="margin-right:4px; color:var(--hc-green);"></i>
                            Rol *
                        </label>
                        <select name="role_id" required class="hc-input @error('role_id') border-red-400 @enderror">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p style="color:#dc2626; font-size:12px; margin:5px 0 0;"><i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Activo -->
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#475569; margin-bottom:8px; letter-spacing:0.06em; text-transform:uppercase;">
                            <i class="fa-solid fa-toggle-on" style="margin-right:4px; color:var(--hc-green);"></i>
                            Estado de la Cuenta
                        </label>
                        <select name="is_active" class="hc-input">
                            <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Activa</option>
                            <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactiva</option>
                        </select>
                    </div>

                </div>

                <hr class="hc-divider">

                <div style="display:flex; gap:14px; flex-wrap:wrap;">
                    <button type="submit" class="btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
