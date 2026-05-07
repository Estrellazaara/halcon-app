@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Halcon</h1>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="rounded-2xl bg-slate-900/80 px-4 py-2 text-sm text-white">Rol: {{ Auth::user()->role->name }}</span>
                        <span class="rounded-2xl bg-slate-900/80 px-4 py-2 text-sm text-white">Usuario: {{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-slate-900">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    @if(Auth::user()->role->name === 'Admin')
                        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
                            <h2 class="text-xl font-semibold text-slate-950 mb-4">Gestión de Usuarios</h2>
                            <ul class="space-y-3 text-slate-900">
                                <li><a href="{{ route('users.index') }}" class="text-sky-600 hover:text-slate-700">Ver Usuarios</a></li>
                                <li><a href="{{ route('users.create') }}" class="text-sky-600 hover:text-slate-700">Crear Usuario</a></li>
                                <li><a href="{{ route('roles.index') }}" class="text-sky-600 hover:text-slate-700">Ver Roles</a></li>
                            </ul>
                        </div>
                    @endif

                    @if(in_array(Auth::user()->role->name, ['Admin', 'Sales']))
                        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
                            <h2 class="text-xl font-semibold text-slate-950 mb-4">Ventas</h2>
                            <ul class="space-y-3 text-slate-900">
                                <li><a href="{{ route('orders.create') }}" class="text-sky-600 hover:text-slate-700">Crear Pedido</a></li>
                                <li><a href="{{ route('orders.index') }}" class="text-sky-600 hover:text-slate-700">Ver Pedidos</a></li>
                                <li><a href="{{ route('products.index') }}" class="text-sky-600 hover:text-slate-700">Ver Productos</a></li>
                            </ul>
                        </div>
                    @endif

                    @if(in_array(Auth::user()->role->name, ['Admin', 'Purchasing']))
                        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
                            <h2 class="text-xl font-semibold text-slate-950 mb-4">Compras</h2>
                            <ul class="space-y-3 text-slate-900">
                                <li><a href="{{ route('products.index') }}" class="text-sky-600 hover:text-slate-700">Ver Productos</a></li>
                                <li><a href="#" class="text-sky-600 hover:text-slate-700">Solicitudes de Compra</a></li>
                            </ul>
                        </div>
                    @endif

                    @if(in_array(Auth::user()->role->name, ['Admin', 'Warehouse']))
                        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
                            <h2 class="text-xl font-semibold text-slate-950 mb-4">Almacén</h2>
                            <ul class="space-y-3 text-slate-900">
                                <li><a href="{{ route('orders.index') }}" class="text-sky-600 hover:text-slate-700">Ver Pedidos</a></li>
                                <li><a href="{{ route('products.index') }}" class="text-sky-600 hover:text-slate-700">Ver Productos</a></li>
                                <li><a href="{{ route('order-items.index') }}" class="text-sky-600 hover:text-slate-700">Ver Items de Pedido</a></li>
                            </ul>
                        </div>
                    @endif

                    @if(in_array(Auth::user()->role->name, ['Admin', 'Route']))
                        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
                            <h2 class="text-xl font-semibold text-slate-950 mb-4">Ruta</h2>
                            <ul class="space-y-3 text-slate-900">
                                <li><a href="{{ route('orders.index') }}" class="text-sky-600 hover:text-slate-700">Ver Pedidos</a></li>
                                <li><a href="{{ route('order-photos.index') }}" class="text-sky-600 hover:text-slate-700">Ver Fotos de Entrega</a></li>
                            </ul>
                        </div>
                    @endif

                    @if(Auth::user()->role->name === 'Admin')
                        <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
                            <h2 class="text-xl font-semibold text-slate-950 mb-4">Archivados</h2>
                            <ul class="space-y-3 text-slate-900">
                                <li><a href="{{ route('orders.archived') }}" class="text-sky-600 hover:text-slate-700">Pedidos Archivados</a></li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection