<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>Dashboard</h1>

    <p>Welcome to Halcon admin panel.</p>

    <ul>
        <li><a href="{{ route('users.index') }}">Manage Users</a></li>
        <li><a href="{{ route('roles.index') }}">Manage Roles</a></li>
        <li><a href="{{ route('products.index') }}">Manage Products</a></li>
        <li><a href="{{ route('orders.index') }}">Manage Orders</a></li>
        <li><a href="{{ route('order-items.index') }}">Manage Order Items</a></li>
        <li><a href="{{ route('order-photos.index') }}">Manage Order Photos</a></li>
    </ul>

</body>
</html>