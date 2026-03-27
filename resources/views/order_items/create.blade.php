<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

<h1>Create Order Item</h1>

<form action="{{ route('order-items.store') }}" method="POST">
    @csrf

    <label>Order *</label>
    <select name="order_id">
        @foreach ($orders as $order)
            <option value="{{ $order->id }}">
                {{ $order->invoice_number }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Product *</label>
    <select name="product_id">
        @foreach ($products as $product)
            <option value="{{ $product->id }}">
                {{ $product->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Quantity *</label>
    <input type="number" name="quantity" min="1" />
    <br><br>

    <input type="submit" value="Create Order Item">
</form>

</body>
</html>