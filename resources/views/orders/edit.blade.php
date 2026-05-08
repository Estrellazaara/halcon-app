@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">

            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                <h1 class="mt-3 text-3xl font-semibold text-white">Editar Pedido</h1>
            </div>

            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-8 shadow-sm card-panel">

                    {{-- Mensajes de error de validación --}}
                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-300 bg-red-50 p-4 text-sm text-red-700">
                            <p class="font-semibold mb-2">Por favor corrige los siguientes errores:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Número de factura (no editable, fue generado automáticamente) --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">Número de Factura</label>
                                <input
                                    type="text"
                                    value="{{ $order->invoice_number }}"
                                    readonly
                                    class="w-full rounded-xl border border-slate-200 px-4 py-4 bg-slate-100 text-slate-500 cursor-not-allowed">
                            </div>

                            {{-- Nombre del cliente --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">Nombre / Razón Social *</label>
                                <input
                                    type="text"
                                    name="customer_name"
                                    value="{{ old('customer_name', $order->customer_name) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm @error('customer_name') border-red-400 @enderror">
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Número de cliente --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">Número de Cliente *</label>
                                <input
                                    type="text"
                                    name="customer_number"
                                    value="{{ old('customer_number', $order->customer_number) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm @error('customer_number') border-red-400 @enderror">
                                @error('customer_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Dirección de entrega --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">Dirección de Entrega *</label>
                                <input
                                    type="text"
                                    name="delivery_address"
                                    value="{{ old('delivery_address', $order->delivery_address) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm @error('delivery_address') border-red-400 @enderror">
                                @error('delivery_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fecha del pedido --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">Fecha y Hora *</label>
                                <input
                                    type="datetime-local"
                                    name="order_datetime"
                                    value="{{ old('order_datetime', \Carbon\Carbon::parse($order->order_datetime)->format('Y-m-d\TH:i')) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm @error('order_datetime') border-red-400 @enderror">
                                @error('order_datetime')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Estado: muestra solo la transición válida siguiente (CU-12) --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">Estado</label>

                                @php
                                    // Flujo de estados: solo se puede avanzar al siguiente
                                    $flujo = [
                                        'Ordered'    => 'In process',
                                        'In process' => 'In route',
                                        'In route'   => 'Delivered',
                                        'Delivered'  => null,
                                    ];
                                    $siguiente = $flujo[$order->status] ?? null;
                                @endphp

                                <select
                                    name="status"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm @error('status') border-red-400 @enderror">

                                    {{-- Siempre muestra el estado actual --}}
                                    <option value="{{ $order->status }}" selected>
                                        {{ $order->status }} (actual)
                                    </option>

                                    {{-- Solo muestra el siguiente paso si existe --}}
                                    @if($siguiente)
                                        <option value="{{ $siguiente }}">
                                            {{ $siguiente }} → siguiente paso
                                        </option>
                                    @endif

                                </select>

                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                @if(!$siguiente)
                                    <p class="mt-1 text-xs text-slate-500">El pedido ya está en el estado final (Delivered).</p>
                                @else
                                    <p class="mt-1 text-xs text-slate-500">
                                        Flujo: Ordered → In process → In route → Delivered
                                    </p>
                                @endif
                            </div>

                            {{-- Notas --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-600 mb-2">Notas</label>
                                <textarea
                                    name="notes"
                                    rows="5"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm">{{ old('notes', $order->notes) }}</textarea>
                            </div>

                        </div>

                        <div class="mt-8 flex gap-4 justify-center flex-wrap">
                            <button type="submit" class="btn-primary">Guardar Cambios</button>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn-secondary">Cancelar</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
