<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "auth" middleware group. Make something great!
|
*/

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart');
});

