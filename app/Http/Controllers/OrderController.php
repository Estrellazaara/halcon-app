<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

// Cambios que realice solo para Order 
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('is_deleted', false)->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:20|unique:orders,invoice_number',
            'customer_name' => 'required|string|max:100',
            'customer_number' => 'required|string|max:20|unique:orders,customer_number',
            'delivery_address' => 'required|string|max:200',
            'order_datetime' => 'required|date',
            'fiscal_data' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'status' => 'nullable|in:Ordered,In process,In route,Delivered',
        ]);

        Order::create([
            'invoice_number' => $request->invoice_number,
            'customer_name' => $request->customer_name,
            'customer_number' => $request->customer_number,
            'delivery_address' => $request->delivery_address,
            'order_datetime' => $request->order_datetime,
            'fiscal_data' => $request->fiscal_data,
            'notes' => $request->notes,
            'status' => $request->status ?? 'Ordered',
            'is_deleted' => false,
        ]);

        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {

        $order->update($request->only([
            'invoice_number',
            'customer_name',
            'customer_number',
            'delivery_address',
            'order_datetime',
            'notes',
            'status',
        ]));

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        $order->items()->delete();
        $order->photos()->delete();

        $order->delete();


        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }
}
