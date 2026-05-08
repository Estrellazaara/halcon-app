@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">

            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">

                <p class="text-sm uppercase tracking-[0.3em] text-sky-400">
                    Panel Administrativo
                </p>

                <h1 class="mt-3 text-3xl font-semibold text-white">
                    Edit Order
                </h1>

            </div>

            <div class="p-8 bg-slate-900">

                <div class="rounded-[28px] border border-slate-200 bg-white p-8 shadow-sm card-panel">

                    <form action="/orders/{{ $order->id }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Invoice Number
                                </label>

                                <input
                                    type="text"
                                    name="invoice_number"
                                    value="{{ $order->invoice_number }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Customer Name
                                </label>

                                <input
                                    type="text"
                                    name="customer_name"
                                    value="{{ $order->customer_name }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Customer Number
                                </label>

                                <input
                                    type="text"
                                    name="customer_number"
                                    value="{{ $order->customer_number }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Delivery Address
                                </label>

                                <input
                                    type="text"
                                    name="delivery_address"
                                    value="{{ $order->delivery_address }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Order Date
                                </label>

                                <input
                                    type="datetime-local"
                                    name="order_datetime"
                                    value="{{ \Carbon\Carbon::parse($order->order_datetime)->format('Y-m-d\TH:i') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm">

                                    <option value="Ordered" {{ $order->status == 'Ordered' ? 'selected' : '' }}>
                                        Ordered
                                    </option>

                                    <option value="In process" {{ $order->status == 'In process' ? 'selected' : '' }}>
                                        In process
                                    </option>

                                    <option value="In route" {{ $order->status == 'In route' ? 'selected' : '' }}>
                                        In route
                                    </option>

                                    <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>
                                        Delivered
                                    </option>

                                </select>

                            </div>

                            <div class="md:col-span-2">

                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Notes
                                </label>

                                <textarea
                                    name="notes"
                                    rows="5"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-4 shadow-sm">{{ $order->notes }}</textarea>

                            </div>

                        </div>

                        <div style="display:flex; justify-content:center; gap:40px; margin-top:40px; flex-wrap:wrap;">

                            <button
                                type="submit"
                                style="background-color:#7c3aed; color:white; padding:14px 40px; border:none; border-radius:16px; font-weight:600; font-size:20px; cursor:pointer;">

                                Save Changes

                            </button>

                            <a
                                href="/orders/{{ $order->id }}"
                                style="background-color:#334155; color:white; padding:14px 40px; border-radius:16px; text-decoration:none; font-weight:600; font-size:20px; display:inline-block;">

                                Cancel

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection