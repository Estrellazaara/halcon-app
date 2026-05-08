@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Crear Pedido</h1>
                    </div>
                    <a href="{{ route('orders.index') }}" class="btn-secondary">Volver</a>
                </div>
            </div>

            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">

                    {{-- Muestra errores de validación del backend (CU-06 corrección frontend) --}}
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

                    <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Número de factura: generado automáticamente, solo informativo (CU-08) --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Número de Factura
                                </label>
                                <input
                                    type="text"
                                    value="Se generará automáticamente (HAL-XXXXXX)"
                                    readonly
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-100 text-slate-500 cursor-not-allowed">
                                <p class="mt-1 text-xs text-slate-500">El sistema asigna el número consecutivo al guardar.</p>
                            </div>

                            {{-- Nombre del cliente --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Nombre / Razón Social del Cliente *
                                </label>
                                <input
                                    type="text"
                                    name="customer_name"
                                    required
                                    value="{{ old('customer_name') }}"
                                    class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('customer_name') border-red-400 @enderror">
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Número de cliente --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Número de Cliente *
                                </label>
                                <input
                                    type="text"
                                    name="customer_number"
                                    required
                                    value="{{ old('customer_number') }}"
                                    class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('customer_number') border-red-400 @enderror">
                                @error('customer_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Datos fiscales (RFC u equivalente) --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Datos Fiscales (RFC) *
                                </label>
                                <input
                                    type="text"
                                    name="fiscal_data"
                                    required
                                    value="{{ old('fiscal_data') }}"
                                    class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('fiscal_data') border-red-400 @enderror">
                                @error('fiscal_data')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fecha y hora del pedido --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Fecha y Hora del Pedido *
                                </label>
                                <input
                                    type="datetime-local"
                                    name="order_datetime"
                                    required
                                    value="{{ old('order_datetime', now()->format('Y-m-d\TH:i')) }}"
                                    class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-purple-500 @error('order_datetime') border-red-400 @enderror">
                                @error('order_datetime')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Dirección de entrega --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Dirección de Entrega *
                                </label>
                                <input
                                    type="text"
                                    name="delivery_address"
                                    required
                                    value="{{ old('delivery_address') }}"
                                    class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('delivery_address') border-red-400 @enderror">
                                @error('delivery_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Estado inicial: siempre "Ordenado", no editable (CU-07) --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Estado Inicial
                                </label>
                                <input
                                    type="text"
                                    value="Ordered"
                                    readonly
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-100 text-slate-600 cursor-not-allowed">
                                <p class="mt-1 text-xs text-slate-500">El sistema asigna este estado automáticamente.</p>
                            </div>

                            {{-- Notas adicionales --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Notas Adicionales
                                </label>
                                <textarea
                                    name="notes"
                                    rows="4"
                                    class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('notes') }}</textarea>
                            </div>

                        </div>

                        <div class="pt-4 flex gap-4">
                            <button type="submit" class="btn-primary">
                                Guardar Pedido
                            </button>
                            <a href="{{ route('orders.index') }}" class="btn-secondary">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
