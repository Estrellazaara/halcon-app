<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\OrderPhotoController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

// Public route — track order status
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

// Protected user routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware('role:Sales,Warehouse,Route,Purchasing')->group(function () {
        Route::resource('orders', OrderController::class);
    });

    Route::middleware('role:Route')->group(function () {
        Route::get('/orders/{id}/upload-photos',  [OrderController::class, 'showUploadPhotos'])->name('orders.upload-photos.form');
        Route::post('/orders/{id}/upload-photos', [OrderController::class, 'uploadPhotos'])->name('orders.upload-photos');
    });

    Route::middleware('role:Sales,Purchasing,Warehouse')->group(function () {
        Route::resource('products', ProductController::class);
    });

    Route::middleware('role:Sales,Warehouse')->group(function () {
        Route::resource('order-items', OrderItemController::class);
    });

    Route::resource('order-photos', OrderPhotoController::class)->middleware('role:Route');
});