<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/

Route::controller(AdminController::class)
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/products', 'productIndex')->name('products');
        Route::get('/categories', 'categoryIndex')->name('categories'); 
        Route::get('/products/add', 'addProductIndex')->name('addProduct');
    });