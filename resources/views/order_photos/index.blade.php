<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>All Order Photos</h1>

    <br>

    <a href="{{ route('order-photos.create') }}">Create Order Photo</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Order</th>
                <th>Type</th>
                <th>Uploaded By</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($photos as $photo)
                <tr>
                    <td>{{ $photo->id }}</td>
                    <td>{{ $photo->order->invoice_number ?? '' }}</td>
                    <td>{{ $photo->type }}</td>
                    <td>{{ $photo->user->name ?? '' }}</td>
                    <td>
                        <a href="{{ route('order-photos.show', $photo->id) }}">View details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>