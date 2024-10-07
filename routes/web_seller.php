<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Seller Routes
|--------------------------------------------------------------------------
|
| Here is where you can register seller routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "seller" middleware group. Make something great!
|
*/

Route::get('/seller', function () {
    return view('seller');
});
