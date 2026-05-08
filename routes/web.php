<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderPhotoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $user = Auth::user();
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Tu cuenta está desactivada.',
            ]);
        }
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->name('login.store')->middleware('guest');

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin only routes
    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
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
    });

    // Sales, Warehouse, Route y Purchasing pueden ver pedidos.
    // La creación está restringida en el controlador a Sales/Admin (CU-06, CU-09).
    Route::middleware('role:Sales,Warehouse,Route,Purchasing')->group(function () {
        Route::resource('orders', OrderController::class);
    });

    // Subida de fotos de evidencia — solo Ruta (CU-13)
    Route::middleware('role:Route')->group(function () {
        Route::get('/orders/{id}/upload-photos',  [OrderController::class, 'showUploadPhotos'])->name('orders.upload-photos.form');
        Route::post('/orders/{id}/upload-photos', [OrderController::class, 'uploadPhotos'])->name('orders.upload-photos');
    });

    // Products are available to Sales, Purchasing and Warehouse
    Route::middleware('role:Sales,Purchasing,Warehouse')->group(function () {
        Route::resource('products', ProductController::class);
    });

    // Order items can be managed by Sales and Warehouse
    Route::middleware('role:Sales,Warehouse')->group(function () {
        Route::resource('order-items', OrderItemController::class);
    });

    // Only Route and Admin can manage order photos
    Route::resource('order-photos', OrderPhotoController::class)->middleware('role:Route');
});