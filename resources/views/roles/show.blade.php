<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>Role Detail</h1>

    <table border="1" cellpadding="10">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $role->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $role->name }}</td>
            </tr>
        </tbody>
    </table>

    <br>

    <h2>Users with this role</h2>
    <ul>
        @foreach($role->users as $user)
            <li>{{ $user->name }} - {{ $user->email }}</li>
        @endforeach
    </ul>

    <br>
    <a href="{{ route('roles.edit', $role->id) }}">Edit Role</a>
    <br>
    <a href="{{ route('roles.index') }}">Back to Roles</a>

    <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Delete Role</button>
    </form>

</body>
</html>