@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Create Order</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Invoice Number *
            </label>
            <input
                type="text"
                name="invoice_number"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Customer Name *
            </label>
            <input
                type="text"
                name="customer_name"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Customer Number *
            </label>
            <input
                type="text"
                name="customer_number"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Fiscal Data *
            </label>
            <input
                type="text"
                name="fiscal_data"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Delivery Address *
            </label>
            <input
                type="text"
                name="delivery_address"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Order Date
            </label>
            <input
                type="datetime-local"
                name="order_datetime"
                required
                value="{{ now()->format('Y-m-d\TH:i') }}"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-slate-100">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Initial Status
            </label>

            <input
                type="text"
                value="Ordered"
                readonly
                class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-slate-100 text-slate-600">

            <input type="hidden" name="status" value="Ordered">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Notes
            </label>

            <textarea
                name="notes"
                rows="4"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
        </div>

    </div>

    <div class="pt-4">
        <button type="submit" class="btn-primary">
            Create Order
        </button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
