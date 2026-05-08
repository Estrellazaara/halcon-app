@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Pedidos</h1>
                    </div>
                    {{-- Solo Sales y Admin pueden crear pedidos (CU-06) --}}
                    @if(auth()->user()->hasRole('Sales') || auth()->user()->hasRole('Admin'))
                        <a href="{{ route('orders.create') }}" class="btn-primary">+ Crear Pedido</a>
                    @endif
                </div>
            </div>

            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">

                    {{-- Mensajes de éxito --}}
                    @if(session('success'))
                        <div class="mb-4 rounded-xl bg-green-50 border border-green-300 px-4 py-3 text-green-700 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ===== FILTROS DE BÚSQUEDA (CU-15) ===== --}}
                    <form method="GET" action="{{ route('orders.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                            {{-- Filtro por número de factura --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Número de Factura</label>
                                <input
                                    type="text"
                                    name="invoice_number"
                                    value="{{ request('invoice_number') }}"
                                    placeholder="HAL-000001"
                                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400">
                            </div>

                            {{-- Filtro por número de cliente --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Número de Cliente</label>
                                <input
                                    type="text"
                                    name="customer_number"
                                    value="{{ request('customer_number') }}"
                                    placeholder="CL-001"
                                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400">
                            </div>

                            {{-- Filtro por fecha --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Fecha del Pedido</label>
                                <input
                                    type="date"
                                    name="order_date"
                                    value="{{ request('order_date') }}"
                                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400">
                            </div>

                            {{-- Filtro por estado --}}
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Estado</label>
                                <select
                                    name="status"
                                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400">
                                    <option value="">— Todos —</option>
                                    <option value="Ordered"    {{ request('status') === 'Ordered'    ? 'selected' : '' }}>Ordered</option>
                                    <option value="In process" {{ request('status') === 'In process' ? 'selected' : '' }}>In process</option>
                                    <option value="In route"   {{ request('status') === 'In route'   ? 'selected' : '' }}>In route</option>
                                    <option value="Delivered"  {{ request('status') === 'Delivered'  ? 'selected' : '' }}>Delivered</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-4 flex gap-3">
                            <button type="submit" class="btn-primary text-sm">Buscar</button>
                            <a href="{{ route('orders.index') }}" class="btn-secondary text-sm">Limpiar filtros</a>
                        </div>
                    </form>
                    {{-- ===== FIN FILTROS ===== --}}

                    <table class="panel-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Número de Factura</th>
                                <th>Cliente</th>
                                <th>Núm. Cliente</th>
                                <th>Estado</th>
                                <th>Fecha del Pedido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->invoice_number }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->customer_number }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->order_datetime?->format('d/m/Y H:i') }}</td>
                                    <td>
                                        {{-- Ver → TODOS los roles --}}
                                        <a href="{{ route('orders.show', $order->id) }}" class="page-action-link">Ver</a>

                                        {{-- Editar → Solo Admin (CU-12) --}}
                                        @if(auth()->user()->hasRole('Admin'))
                                            | <a href="{{ route('orders.edit', $order->id) }}" class="page-action-link">Editar</a>
                                        @endif

                                        {{-- Archivar → Solo Admin (CU-16: eliminación lógica) --}}
                                        @if(auth()->user()->hasRole('Admin'))
                                            | <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;"
                                                onsubmit="return confirm('¿Archivar este pedido? Podrás restaurarlo después.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="page-action-link text-amber-600">Archivar</button>
                                            </form>
                                        @endif

                                        {{-- Subir foto → Solo Ruta (CU-13) --}}
                                        @if(auth()->user()->hasRole('Route'))
                                            | <a href="{{ route('order-photos.create') }}?order_id={{ $order->id }}" class="page-action-link">Subir Foto</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-slate-500 py-6">
                                        No se encontraron pedidos con esos filtros.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
