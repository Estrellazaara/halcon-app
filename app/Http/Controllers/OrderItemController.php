<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])->get();

        return view('order_items.index', compact('orderItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::where('is_deleted', false)->get();
        $products = Product::all();

        return view('order_items.create', compact('orders', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->current_stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        OrderItem::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        $product->decrement('current_stock', $request->quantity);

        return redirect()->route('orders.show', $request->order_id)
            ->with('success', 'Product added to order successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);

        return view('order_items.show', compact('orderItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orders = Order::where('is_deleted', false)->get();
        $products = Product::all();

        return view('order_items.edit', compact('orderItem', 'orders', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $oldQuantity = $orderItem->quantity;
        $newQuantity = (int) $request->quantity;
        $difference = $newQuantity - $oldQuantity;

        $product = Product::findOrFail($request->product_id);

        if ($difference > 0 && $product->current_stock < $difference) {
            return back()->with('error', 'Not enough stock available for update.');
        }

        if ($difference > 0) {
            $product->decrement('current_stock', $difference);
        } elseif ($difference < 0) {
            $product->increment('current_stock', abs($difference));
        }

        $orderItem->update([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'quantity' => $newQuantity,
        ]);

        return redirect()->route('orders.show', $request->order_id)
            ->with('success', 'Order item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $product = Product::findOrFail($orderItem->product_id);
        $product->increment('current_stock', $orderItem->quantity);

        $orderId = $orderItem->order_id;
        $orderItem->delete();

        return redirect()->route('orders.show', $orderId)
            ->with('success', 'Order item removed successfully.');
    }
}