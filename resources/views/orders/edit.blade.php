@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Edit Order</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('patch')

        <label>Invoice Number:</label>
        <input type="text" name="invoice_number" value="{{ $order->invoice_number }}" />
        <br><br>

        <label>Customer Name:</label>
        <input type="text" name="customer_name" value="{{ $order->customer_name }}" />
        <br><br>

        <label>Customer Number:</label>
        <input type="text" name="customer_number" value="{{ $order->customer_number }}" />
        <br><br>

        <label>Delivery Address:</label>
        <input type="text" name="delivery_address" value="{{ $order->delivery_address }}" />
        <br><br>

        <label>Order Date:</label>
        <input type="datetime-local" name="order_datetime" value="{{ $order->order_datetime ? \Carbon\Carbon::parse($order->order_datetime)->format('Y-m-d\TH:i') : '' }}" />
        <br><br>

        <label>Notes:</label>
        <textarea name="notes">{{ $order->notes }}</textarea>
        <br><br>

        <label>Status:</label>
        <select name="status">
            <option value="Ordered" @selected($order->status === 'Ordered')>Ordered</option>
            <option value="In process" @selected($order->status === 'In process')>In process</option>
            <option value="In route" @selected($order->status === 'In route')>In route</option>
            <option value="Delivered" @selected($order->status === 'Delivered')>Delivered</option>
        </select>
        <br><br>

        <input type="submit" value="Edit Order" />
    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
