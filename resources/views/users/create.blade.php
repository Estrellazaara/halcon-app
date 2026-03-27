<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

<h1>Create User</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf

    <label>Name *</label>
    <input type="text" name="name" />
    <br><br>

    <label>Email *</label>
    <input type="email" name="email" />
    <br><br>

    <label>Password *</label>
    <input type="password" name="password" />
    <br><br>

    <label>Fiscal Data</label>
    <input type="text" name="fiscal_data" />
    <br><br>

    <label>Delivery Address</label>
    <input type="text" name="delivery_address" />
    <br><br>

    <label>Role *</label>
    <select name="role_id">
        @foreach ($roles as $role)
            <option value="{{ $role->id }}">
                {{ $role->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Active</label>
    <select name="is_active">
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>
    <br><br>

    <input type="submit" value="Create User">
</form>

</body>
</html>