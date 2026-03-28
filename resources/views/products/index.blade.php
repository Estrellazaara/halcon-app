<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>All Products</h1>

    <br>

    <a href="{{ route('products.create') }}">Create Product</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Current Stock</th>
                <th>Minimum Stock</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->current_stock }}</td>
                    <td>{{ $product->minimum_stock }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}">View details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>