<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

    <h1>All Orders</h1>

    <br>

    {{-- Crear pedido → SOLO Sales --}}
    @if(auth()->check() && auth()->user()->hasRole('Sales'))
        <a href="{{ route('orders.create') }}">Create Order</a>
    @endif

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Customer Number</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->invoice_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_number }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->order_datetime }}</td>
                    <td>

                        {{-- Ver → TODOS --}}
                        <a href="{{ route('orders.show', $order->id) }}">View</a>

                        {{-- Editar → SOLO Admin --}}
                        @if(auth()->check() && auth()->user()->hasRole('Admin'))
                            | <a href="{{ route('orders.edit', $order->id) }}">Edit</a>
                        @endif

                        {{-- Eliminar → SOLO Admin --}}
                        @if(auth()->check() && auth()->user()->hasRole('Admin'))
                            | <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        @endif

                        {{-- Subir foto → SOLO Route --}}
                        @if(auth()->check() && auth()->user()->hasRole('Route'))
                            | <a href="{{ route('order-photos.create') }}">Upload Photo</a>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>