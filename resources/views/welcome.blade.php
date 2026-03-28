@extends('layouts.app')

@section('content')

    <h2>Track Order</h2>

    <form action="{{ route('public.track') }}" method="GET">
        
        <label>Invoice Number:</label><br>
        <input type="text" name="invoice_number" required><br><br>

        <label>Customer Number:</label><br>
        <input type="text" name="customer_number" required><br><br>

        <button type="submit">Search</button>

    </form>

    @isset($order)
        <hr>
        <h3>Order Information</h3>

        <p><strong>Invoice Number:</strong> {{ $order->invoice_number }}</p>
        <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <p><strong>Date:</strong> {{ $order->order_datetime }}</p>

        @if($order->status === 'Delivered')
            <h4>Delivered Photo</h4>

            @php
                $deliveredPhoto = $order->photos->where('type', 'delivered')->first();
            @endphp

            @if($deliveredPhoto)
                <img src="{{ asset('storage/' . $deliveredPhoto->photo_path) }}" width="300">
            @else
                <p>No delivered photo available.</p>
            @endif
        @endif

        @if($order->status === 'In process')
            <p><strong>Process:</strong> Order is currently being prepared.</p>
            <p><strong>Updated:</strong> {{ $order->updated_at }}</p>
        @endisset

    @elseif(request('invoice_number'))
        <hr>
        <p>No order found with those details.</p>
    @endif

@endsection