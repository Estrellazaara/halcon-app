<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

    <h1>Edit Order</h1>

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

</body>
</html>