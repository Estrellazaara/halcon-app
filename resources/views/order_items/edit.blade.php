@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen card-panel">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="rounded-[32px] bg-slate-900 shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-950 border-b border-slate-800 px-8 py-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-sky-400">Panel Administrativo</p>
                        <h1 class="mt-3 text-3xl font-semibold text-white">Edit Order Item</h1>
                    </div>
                </div>
            </div>
            <div class="p-8 bg-slate-900">
                <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm card-panel">
<form action="{{ route('order-items.update', $orderItem->id) }}" method="POST">
        @csrf
        @method('patch')

        <label>Order:</label>
        <select name="order_id">
            @foreach ($orders as $order)
                <option value="{{ $order->id }}" @selected($orderItem->order_id == $order->id)>
                    {{ $order->invoice_number }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Product:</label>
        <select name="product_id">
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected($orderItem->product_id == $product->id)>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="{{ $orderItem->quantity }}" min="1" />
        <br><br>

        <input type="submit" value="Edit Order Item" />

    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
