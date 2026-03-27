<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

    <h1>Edit Product</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('patch')

        <label>Name:</label>
        <input type="text" name="name" value="{{ $product->name }}" />
        <br><br>

        <label>Description:</label>
        <input type="text" name="description" value="{{ $product->description }}" />
        <br><br>

        <label>Current Stock:</label>
        <input type="number" name="current_stock" value="{{ $product->current_stock }}" />
        <br><br>

        <label>Minimum Stock:</label>
        <input type="number" name="minimum_stock" value="{{ $product->minimum_stock }}" />
        <br><br>

        <input type="submit" value="Edit Product" />

    </form>

</body>
</html>