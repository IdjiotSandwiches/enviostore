<?php

use App\Http\Controllers\ProfilePictureController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\CheckoutController;
use App\Http\Controllers\user\ProfileController;
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
Route::prefix('profile')
    ->name('profile.')
    ->controller(ProfileController::class)
    ->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::get('/change-password', 'changePassword')->name('changePassword');
        Route::put('/change-password', 'attemptChangePassword')->name('attemptChangePassword');
        Route::put('/update', 'update')->name('update');
        Route::get('/profile-picture', 'getProfilePicture')->name('getProfilePicture');
    });

Route::prefix('cart')
    ->name('cart.')
    ->controller(CartController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/cart-items', 'getCartItems')->name('getCartItems');
        Route::post('/add-to-cart', 'addToCart')->name('addToCart');
        Route::delete('/delete/{id}', 'delete')->name('deleteItem');
        Route::post('/checkout', 'checkout')->name('checkout');
    });

Route::prefix('checkout')
    ->name('checkout.')
    ->controller(CheckoutController::class)
    ->group(function () {
        
    });