<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

<h1>Create Product</h1>

<form action="{{ route('products.store') }}" method="POST">
    @csrf

    <label>Name *</label>
    <input type="text" name="name" />
    <br><br>

    <label>Description</label>
    <input type="text" name="description" />
    <br><br>

    <label>Price *</label>
    <input type="number" name="price" step="0.01" min="0" />
    <br><br>

    <label>Current Stock *</label>
    <input type="number" name="current_stock" />
    <br><br>

    <label>Minimum Stock *</label>
    <input type="number" name="minimum_stock" />
    <br><br>

    <input type="submit" value="Create Product">
</form>

</body>
</html>