<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

    <h1>Edit Order Photo</h1>

    <form action="{{ route('order-photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <label>Order:</label>
        <select name="order_id">
            @foreach ($orders as $order)
                <option value="{{ $order->id }}" @selected($photo->order_id == $order->id)>
                    {{ $order->invoice_number }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Type:</label>
        <select name="type">
            <option value="loaded" @selected($photo->type === 'loaded')>Loaded</option>
            <option value="delivered" @selected($photo->type === 'delivered')>Delivered</option>
        </select>
        <br><br>

        <label>New Photo:</label>
        <input type="file" name="photo" />
        <br><br>

        <input type="submit" value="Edit Order Photo" />

    </form>

</body>
</html>