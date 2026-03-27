<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

    <h1>Edit Role</h1>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('patch')

        <label>Role name:</label>
        <input type="text" name="name" value="{{ $role->name }}" />
        <br><br>

        <input type="submit" value="Edit Role" />

    </form>

</body>
</html>