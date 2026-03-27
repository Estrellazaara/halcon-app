<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

    <h1>Edit Order Item</h1>

    <form action="{{ route('order-items.update', $orderItem->id) }}" method="POST">
        @csrf
        @method('patch')

        <label>Order:</label>
        <select name="order_id">
            @foreach ($orders as $order)
                <option value="{{ $order->id }}" @selected($orderItem->order_id == $order->id)>
                    {{ $order->invoice_number }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Product:</label>
        <select name="product_id">
            @foreach ($products as $product)
                <option value="{{ $product->id }}" @selected($orderItem->product_id == $product->id)>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="{{ $orderItem->quantity }}" min="1" />
        <br><br>

        <input type="submit" value="Edit Order Item" />

    </form>

</body>
</html>