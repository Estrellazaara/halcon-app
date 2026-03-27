<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderPhoto;
use App\Models\Order;

class OrderPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = OrderPhoto::with(['order', 'user'])->orderBy('created_at', 'desc')->get();

        return view('order_photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::where('is_deleted', false)->get();

        return view('order_photos.create', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'type' => 'required|in:loaded,delivered',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('photo')->store('order_photos', 'public');

        OrderPhoto::create([
            'order_id' => $request->order_id,
            'type' => $request->type,
            'photo_path' => $path,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('orders.show', $request->order_id)
            ->with('success', 'Photo uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $photo = OrderPhoto::with(['order', 'user'])->findOrFail($id);

        return view('order_photos.show', compact('photo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $photo = OrderPhoto::findOrFail($id);
        $orders = Order::where('is_deleted', false)->get();

        return view('order_photos.edit', compact('photo', 'orders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $photo = OrderPhoto::findOrFail($id);

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'type' => 'required|in:loaded,delivered',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'order_id' => $request->order_id,
            'type' => $request->type,
        ];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('order_photos', 'public');
            $data['photo_path'] = $path;
        }

        $photo->update($data);

        return redirect()->route('orders.show', $request->order_id)
            ->with('success', 'Photo updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = OrderPhoto::findOrFail($id);
        $orderId = $photo->order_id;
        $photo->delete();

        return redirect()->route('orders.show', $orderId)
            ->with('success', 'Photo deleted successfully.');
    }
}