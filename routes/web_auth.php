<?php

use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\CheckoutController;
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

Route::prefix('cart')
    ->name('cart.')
    ->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/cart-items', 'getCartItems')->name('getCartItems');
        Route::post('/add-to-cart', 'addToCart')->name('addToCart');
        Route::delete('/delete/{id}', 'delete')->name('deleteItem');
        Route::get('/checkout', 'checkout')->name('checkout');
    });

Route::prefix('checkout')
    ->name('checkout.')
    ->controller(CheckoutController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });