@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Pedidos Archivados</h1>
                        <p class="mt-2 text-sm text-slate-400">
                            Pedidos marcados como eliminados. Puedes restaurarlos al listado activo.
                        </p>
                    </div>
                    <a href="{{ route('orders.index') }}" class="btn-secondary">← Volver a Pedidos</a>
                </div>
            </div>

            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">

                    @if(session('success'))
                        <div class="mb-4 rounded-xl bg-green-50 border border-green-300 px-4 py-3 text-green-700 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($orders->isEmpty())
                        <p class="text-slate-500 text-center py-8">No hay pedidos archivados.</p>
                    @else
                        <table class="panel-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Número de Factura</th>
                                    <th>Cliente</th>
                                    <th>Núm. Cliente</th>
                                    <th>Estado</th>
                                    <th>Fecha del Pedido</th>
                                    <th>Restaurar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->invoice_number }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_number }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ $order->order_datetime?->format('d/m/Y H:i') }}</td>
                                        <td>
                                            {{-- Restaurar el pedido al listado activo (CU-17) --}}
                                            <form action="{{ route('orders.restore', $order->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-primary text-sm">
                                                    Restaurar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
