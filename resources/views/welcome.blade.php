@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg card-panel">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold">Halcon - Seguimiento de Pedidos</h1>
                    <a href="{{ route('login') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Acceso Administrativo
                    </a>
                </div>

                <div class="max-w-md mx-auto">
                    <h2 class="text-2xl font-semibold mb-4">Rastrear Pedido</h2>

                    <form action="{{ route('public.track') }}" method="GET" class="space-y-4">
                        <div>
                            <label for="invoice_number" class="block text-sm font-medium text-slate-900">Número de Factura</label>
                            <input type="text" name="invoice_number" id="invoice_number" required class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="customer_number" class="block text-sm font-medium text-slate-900">Número de Cliente</label>
                            <input type="text" name="customer_number" id="customer_number" required class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Buscar
                        </button>
                    </form>
                </div>

                @isset($order)
                    <div class="mt-8 max-w-md mx-auto">
                        <hr class="mb-4">
                        <h3 class="text-xl font-semibold mb-4">Información del Pedido</h3>

                        <div class="space-y-2">
                            <p><strong>Número de Factura:</strong> {{ $order->invoice_number }}</p>
                            <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Estado:</strong> {{ $order->status }}</p>
                            <p><strong>Fecha:</strong> {{ $order->order_datetime }}</p>
                        </div>

                        @if($order->status === 'Delivered')
                            <h4 class="text-lg font-semibold mt-4 mb-2">Foto de Entrega</h4>

                            @php
                                $deliveredPhoto = $order->photos->where('type', 'delivered')->first();
                            @endphp

                            @if($deliveredPhoto)
                                <img src="{{ asset('storage/' . $deliveredPhoto->photo_path) }}" alt="Foto de entrega" class="max-w-full h-auto rounded-lg shadow-md">
                            @else
                                <p class="text-slate-700">No hay foto de entrega disponible.</p>
                            @endif
                        @endif

                        @if($order->status === 'In process')
                            <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                                <p><strong>Proceso:</strong> El pedido está siendo preparado.</p>
                                <p><strong>Actualizado:</strong> {{ $order->updated_at }}</p>
                            </div>
                        @endif
                    </div>
                @elseif(request('invoice_number'))
                    <div class="mt-8 max-w-md mx-auto">
                        <hr class="mb-4">
                        <p class="text-red-600">No se encontró ningún pedido con esos datos.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection