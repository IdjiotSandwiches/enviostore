<?php

use App\Http\Controllers\user\CartController;
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

Route::controller(CartController::class)->group(function () {
    Route::post('/add-to-cart', 'addToCart')->name('addToCart');
});

Route::prefix('profile')
    ->name('profile.')
    ->controller(ProfileController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });