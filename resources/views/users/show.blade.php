<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>User Detail</h1>

    <table border="1" cellpadding="10">
        <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Fiscal Data</th>
                <td>{{ $user->fiscal_data }}</td>
            </tr>
            <tr>
                <th>Delivery Address</th>
                <td>{{ $user->delivery_address }}</td>
            </tr>
            <tr>
                <th>Role</th>
                <td>{{ $user->role->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Active</th>
                <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
            </tr>
        </tbody>
    </table>

    <br>
    <a href="{{ route('users.edit', $user->id) }}">Edit User</a>
    <br>
    <a href="{{ route('users.index') }}">Back to Users</a>

    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Deactivate User</button>
    </form>

</body>
</html>