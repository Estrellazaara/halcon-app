<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderPhotoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/track-order', function () {
    $order = null;

    if (request('invoice_number')) {
        $order = Order::with('photos')
            ->where('invoice_number', request('invoice_number'))
            ->where('customer_number', request('customer_number'))
            ->where('is_deleted', false)
            ->first();
    }

    return view('welcome', compact('order'));
})->name('public.track');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/

Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('order-items', OrderItemController::class);
Route::resource('order-photos', OrderPhotoController::class);

/*
|--------------------------------------------------------------------------
| Archived Orders
|--------------------------------------------------------------------------
*/

Route::get('/orders-archived', function () {
    $orders = Order::where('is_deleted', true)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('orders.archived', compact('orders'));
})->name('orders.archived');

Route::patch('/orders/{id}/restore', function ($id) {
    $order = Order::findOrFail($id);
    $order->update(['is_deleted' => false]);

    return redirect()->route('orders.archived');
})->name('orders.restore');