<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/track-order', [OrderController::class, 'trackOrder']);
