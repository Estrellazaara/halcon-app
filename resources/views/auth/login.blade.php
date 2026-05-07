@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-surface-soft border border-slate-800 shadow-lg shadow-slate-950/30 rounded-[32px] px-8 py-10">
        <div class="text-center mb-8">
            <p class="text-sm uppercase tracking-[0.3em] text-white">Panel administrativo</p>
            <h2 class="mt-4 text-3xl font-semibold text-white">Iniciar Sesión</h2>
            <p class="mt-2 text-sm text-white">Accede a tu cuenta administrativa</p>
        </div>

        <form class="space-y-6" method="POST" action="{{ route('login.store') }}">
            @csrf
            <input type="hidden" name="remember" value="true" />

            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-white">Correo electrónico</label>
                    <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="mt-2 block w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20" placeholder="correo@ejemplo.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-white">Contraseña</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="mt-2 block w-full rounded-2xl border border-slate-700 bg-slate-950/70 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between text-sm text-white">
                <label class="flex items-center gap-2">
                    <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-600 bg-slate-900 text-indigo-500 focus:ring-indigo-500">
                    Recordarme
                </label>
            </div>

            <div>
                <button type="submit" class="btn-primary w-full">Iniciar Sesión</button>
            </div>

            @if ($errors->any())
                <div class="rounded-3xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-100">
                    <p class="font-semibold">Hay errores en el formulario:</p>
                    <ul class="mt-2 list-disc pl-5 space-y-1 text-red-100/90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection