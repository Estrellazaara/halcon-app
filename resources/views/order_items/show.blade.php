<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>Order Item Detail</h1>

    <table border="1" cellpadding="10">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $orderItem->id }}</td>
            </tr>
            <tr>
                <th>Order</th>
                <td>{{ $orderItem->order->invoice_number ?? '' }}</td>
            </tr>
            <tr>
                <th>Product</th>
                <td>{{ $orderItem->product->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td>{{ $orderItem->quantity }}</td>
            </tr>
            <tr>
                <th>Stock Impact</th>
                <td>{{ $orderItem->subtotalStockImpact() }}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <a href="{{ route('order-items.edit', $orderItem->id) }}">Edit Order Item</a>
    <br>
    <a href="{{ route('order-items.index') }}">Back to Order Items</a>

    <form action="{{ route('order-items.destroy', $orderItem->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Delete Order Item</button>
    </form>

</body>
</html>