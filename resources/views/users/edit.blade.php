<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('patch')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $user->name }}" />
        <br><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" />
        <br><br>

        <label>Password:</label>
        <input type="password" name="password" />
        <br><br>

        <label>Fiscal Data:</label>
        <input type="text" name="fiscal_data" value="{{ $user->fiscal_data }}" />
        <br><br>

        <label>Delivery Address:</label>
        <input type="text" name="delivery_address" value="{{ $user->delivery_address }}" />
        <br><br>

        <label>Role:</label>
        <select name="role_id">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Active:</label>
        <select name="is_active">
            <option value="1" @selected($user->is_active == 1)>Yes</option>
            <option value="0" @selected($user->is_active == 0)>No</option>
        </select>
        <br><br>

        <input type="submit" value="Edit User" />

    </form>

</body>
</html>