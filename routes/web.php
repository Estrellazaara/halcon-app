<?php

use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

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
    return redirect('/login');
})->name('logout');

// Protected admin routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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