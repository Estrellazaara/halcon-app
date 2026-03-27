<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>All Users</h1>

    <br>

    <a href="{{ route('users.create') }}">Create User</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name ?? '' }}</td>
                    <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}">View details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>