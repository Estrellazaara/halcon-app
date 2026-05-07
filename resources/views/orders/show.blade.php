@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Order Detail</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<table class="panel-table">
        <tbody>
            <tr>
                <th>Invoice Number</th>
                <td>{{ $order->invoice_number }}</td>
            </tr>
            <tr>
                <th>Customer Name</th>
                <td>{{ $order->customer_name }}</td>
            </tr>
            <tr>
                <th>Customer Number</th>
                <td>{{ $order->customer_number }}</td>
            </tr>
            <tr>
                <th>Delivery Address</th>
                <td>{{ $order->delivery_address }}</td>
            </tr>
            <tr>
                <th>Notes</th>
                <td>{{ $order->notes }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $order->status }}</td>
            </tr>
            <tr>
                <th>Order Date</th>
                <td>{{ $order->order_datetime }}</td>
            </tr>
        </tbody>
    </table>

    <br>

    <h2>Products</h2>
    <table class="panel-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->product->name ?? '' }}</td>
                    <td>{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <h2>Photos</h2>
    @foreach($order->photos as $photo)
        <div>
            <p><strong>Type:</strong> {{ $photo->type }}</p>
            <img src="{{ asset('storage/' . $photo->photo_path) }}" width="250">
        </div>
        <br>
    @endforeach

    <br>

    <a href="{{ route('orders.edit', $order->id) }}">Edit Order</a>
    <br>
    <a href="{{ route('orders.index') }}" class="btn-secondary">Back to Orders</a>

    <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Delete Order</button>
    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
