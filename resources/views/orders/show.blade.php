@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">

            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">
                            Panel Administrativo
                        </p>

                        <h1 class="mt-3 text-3xl font-semibold text-white">
                            Order Detail
                        </h1>
                    </div>

                </div>

            </div>

            <div class="p-8 bg-slate-900">

                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500 mb-2">
                                Invoice Number
                            </p>

                            <div class="bg-slate-100 border border-slate-200 rounded-xl px-4 py-4 shadow-sm">
                                {{ $order->invoice_number }}
                            </div>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500 mb-2">
                                Customer Name
                            </p>

                            <div class="bg-slate-100 border border-slate-200 rounded-xl px-4 py-4 shadow-sm">
                                {{ $order->customer_name }}
                            </div>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500 mb-2">
                                Customer Number
                            </p>

                            <div class="bg-slate-100 border border-slate-200 rounded-xl px-4 py-4 shadow-sm">
                                {{ $order->customer_number }}
                            </div>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500 mb-2">
                                Fiscal Data
                            </p>

                            <div class="bg-slate-100 border border-slate-200 rounded-xl px-4 py-4 shadow-sm">
                                {{ $order->fiscal_data }}
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500 mb-2">
                                Delivery Address
                            </p>

                            <div class="bg-slate-100 border border-slate-200 rounded-xl px-4 py-4 shadow-sm">
                                {{ $order->delivery_address }}
                            </div>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500 mb-2">
                                Status
                            </p>

                            <div class="bg-purple-100 border border-purple-200 rounded-xl px-4 py-4 shadow-sm text-purple-700 font-semibold">
                                {{ $order->status }}
                            </div>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500 mb-2">
                                Order Date
                            </p>

                            <div class="bg-slate-100 border border-slate-200 rounded-xl px-4 py-4 shadow-sm">
                                {{ $order->order_datetime }}
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-xs uppercase tracking-[0.25em] text-slate-500 mb-2">
                                Notes
                            </p>

                            <div class="bg-slate-100 border border-slate-200 rounded-xl px-4 py-4 shadow-sm min-h-[100px]">
                                {{ $order->notes ?: 'No notes available.' }}
                            </div>
                        </div>

                    </div>

                    <div class="mt-10">

                        <h2 class="text-2xl font-semibold text-slate-800 mb-4">
                            Products
                        </h2>

                        <div class="overflow-hidden rounded-2xl border border-slate-200">

                            <table class="min-w-full">

                                <thead class="bg-slate-100">

                                    <tr>

                                        <th class="px-6 py-4 text-left text-sm uppercase tracking-[0.2em] text-slate-500">
                                            ID
                                        </th>

                                        <th class="px-6 py-4 text-left text-sm uppercase tracking-[0.2em] text-slate-500">
                                            Product
                                        </th>

                                        <th class="px-6 py-4 text-left text-sm uppercase tracking-[0.2em] text-slate-500">
                                            Quantity
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="bg-white">

                                    @forelse($order->items as $item)

                                        <tr class="border-t border-slate-200">

                                            <td class="px-6 py-4">
                                                {{ $item->id }}
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ $item->product->name ?? '' }}
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ $item->quantity }}
                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="3" class="px-6 py-6 text-center text-slate-500">
                                                No products assigned.
                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                    <div class="mt-10">

                        <h2 class="text-2xl font-semibold text-slate-800 mb-4">
                            Photos
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            @forelse($order->photos as $photo)

                                <div class="rounded-2xl border border-slate-200 p-4 bg-slate-50">

                                    <p class="font-semibold text-slate-700 mb-3">
                                        {{ $photo->type }}
                                    </p>

                                    <img
                                        src="{{ asset('storage/' . $photo->photo_path) }}"
                                        class="rounded-xl shadow-sm">

                                </div>

                            @empty

                                <p class="text-slate-500">
                                    No photos uploaded.
                                </p>

                            @endforelse

                        </div>

                    </div>

                    {{-- Botones de acción: protegidos por rol (CU-12, CU-16) --}}
                    <div style="margin-top:40px; display:flex; justify-content:center; gap:40px; flex-wrap:wrap;">

                        {{-- Editar solo Admin --}}
                        @if(auth()->user()->hasRole('Admin'))
                            <a
                                href="/orders/{{ $order->id }}/edit"
                                style="background-color:#7c3aed; color:white; padding:14px 40px; border-radius:16px; text-decoration:none; font-weight:600; font-size:20px; display:inline-block;">
                                Editar Pedido
                            </a>
                        @endif

                        {{-- Archivar (eliminación lógica) solo Admin (CU-16) --}}
                        @if(auth()->user()->hasRole('Admin') && !$order->is_deleted)
                            <form
                                action="{{ route('orders.destroy', $order->id) }}"
                                method="POST"
                                onsubmit="return confirm('¿Archivar este pedido? Podrás restaurarlo después.')">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    style="background-color:#f59e0b; color:white; padding:14px 40px; border:none; border-radius:16px; font-weight:600; font-size:20px; cursor:pointer;">
                                    Archivar Pedido
                                </button>

                            </form>
                        @endif

                    </div>

                    <div style="display:flex; justify-content:center; margin-top:35px;">

                        <a
                            href="{{ route('orders.index') }}"
                            style="background-color:#334155; color:white; padding:14px 40px; border-radius:16px; text-decoration:none; font-weight:600; font-size:20px; display:inline-block;">

                            Back to Orders

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection