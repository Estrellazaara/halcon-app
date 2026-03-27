<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>Order Photo Detail</h1>

    <table border="1" cellpadding="10">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $photo->id }}</td>
            </tr>
            <tr>
                <th>Order</th>
                <td>{{ $photo->order->invoice_number ?? '' }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ $photo->type }}</td>
            </tr>
            <tr>
                <th>Uploaded By</th>
                <td>{{ $photo->user->name ?? '' }}</td>
            </tr>
            <tr>
                <th>Photo</th>
                <td>
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" width="300">
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <a href="{{ route('order-photos.edit', $photo->id) }}">Edit Order Photo</a>
    <br>
    <a href="{{ route('order-photos.index') }}">Back to Order Photos</a>

    <form action="{{ route('order-photos.destroy', $photo->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit">Delete Order Photo</button>
    </form>

</body>
</html>