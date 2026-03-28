<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>Order Detail</h1>

    <table border="1" cellpadding="10">
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
    <table border="1" cellpadding="10">
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
    <a href="{{ route('orders.index') }}">Back to Orders</a>

    <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Delete Order</button>
    </form>

</body>
</html>