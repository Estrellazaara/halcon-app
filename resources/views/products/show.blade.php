<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>Product Detail</h1>

    <table border="1" cellpadding="10">
        <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $product->description }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>${{ number_format($product->price, 2) }}</td>
            </tr>
            <tr>
                <th>Current Stock</th>
                <td>{{ $product->current_stock }}</td>
            </tr>
            <tr>
                <th>Minimum Stock</th>
                <td>{{ $product->minimum_stock }}</td>
            </tr>
            <tr>
                <th>Low Stock?</th>
                <td>{{ $product->isLowStock() ? 'Yes' : 'No' }}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <a href="{{ route('products.edit', $product->id) }}">Edit Product</a>
    <br>
    <a href="{{ route('products.index') }}">Back to Products</a>

    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Delete Product</button>
    </form>

</body>
</html>