<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

<h1>Create Order</h1>

<form action="{{ route('orders.store') }}" method="POST">
    @csrf

    <label>Invoice Number *</label>
    <input type="text" name="invoice_number" />
    <br><br>

    <label>Customer Name *</label>
    <input type="text" name="customer_name" />
    <br><br>

    <label>Customer Number *</label>
    <input type="text" name="customer_number" />
    <br><br>

    <label>Fiscal Data</label>
    <input type="text" name="fiscal_data" />
    <br><br>

    <label>Delivery Address *</label>
    <input type="text" name="delivery_address" />
    <br><br>

    <label>Order Date</label>
    <input type="datetime-local" name="order_datetime" />
    <br><br>

    <label>Notes</label>
    <textarea name="notes"></textarea>
    <br><br>

    <label>Status *</label>
    <select name="status">
        <option value="Ordered">Ordered</option>
        <option value="In process">In process</option>
        <option value="In route">In route</option>
        <option value="Delivered">Delivered</option>
    </select>
    <br><br>

    <input type="submit" value="Create Order">
</form>

</body>
</html>