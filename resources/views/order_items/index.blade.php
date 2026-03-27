<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>All Order Items</h1>

    <br>

    <a href="{{ route('order-items.create') }}">Create Order Item</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($orderItems as $orderItem)
                <tr>
                    <td>{{ $orderItem->id }}</td>
                    <td>{{ $orderItem->order->invoice_number ?? '' }}</td>
                    <td>{{ $orderItem->product->name ?? '' }}</td>
                    <td>{{ $orderItem->quantity }}</td>
                    <td>
                        <a href="{{ route('order-items.show', $orderItem->id) }}">View details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>