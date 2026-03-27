<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>All Orders</h1>

    <br>

    <a href="{{ route('orders.create') }}">Create Order</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Customer Number</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->invoice_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_number }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->order_datetime }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order->id) }}">View details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>