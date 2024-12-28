<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ProductController;
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
        Route::get('/categories', 'categoryIndex')->name('categories'); 
    });

Route::controller(ProductController::class)
    ->group(function(){
        Route::get('/products', 'productIndex')->name('products');
        Route::get('/products/add', 'addProductIndex')->name('addProductIndex');
        Route::post('/products/add', 'addProduct')->name('addProduct');
    });