<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

<h1>Create Role</h1>

<form action="{{ route('roles.store') }}" method="POST">
    @csrf

    <label>Name *</label>
    <input type="text" name="name" />
    <br><br>

    <input type="submit" value="Create Role">
</form>

</body>
</html>