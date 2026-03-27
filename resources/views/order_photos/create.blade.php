<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

<h1>Create Order Photo</h1>

<form action="{{ route('order-photos.store') }}" method="POST" enctype="multipart/form-data">
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

    <label>Type *</label>
    <select name="type">
        <option value="loaded">Loaded</option>
        <option value="delivered">Delivered</option>
    </select>
    <br><br>

    <label>Photo *</label>
    <input type="file" name="photo" />
    <br><br>

    <input type="submit" value="Create Order Photo">
</form>

</body>
</html>