<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;

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
    });

Route::controller(ProductController::class)
    ->group(function(){
        Route::get('/products', 'productIndex')->name('products');
        Route::get('/products/add', 'addProductIndex')->name('addProductIndex');
        Route::get('/products/{id}/edit', 'editProductIndex')->name('editProduct');
        Route::post('/products/add', 'addProduct')->name('addProduct');
        Route::post('/products/add/images/{id}', 'addProductImages')->name('addProductImage');
        Route::put('/products/{id}', 'updateProduct')->name('updateProduct');
        Route::delete('/products/{id}', 'deleteProduct')->name('deleteProduct');
        Route::delete('/product/image/{id}', 'deleteProductImage')->name('deleteProductImage'); 
    });

Route::controller(CategoryController::class)
    ->group(function(){
        Route::get('/categories', 'categoryIndex')->name('categories');
        Route::get('/categories/add', 'addCategoryIndex')->name('addCategoryIndex');
        Route::get('/categories/{id}/edit', 'editCategoryIndex')->name('editCategory');
        Route::post('/categories/add', 'addCategory')->name('addCategory');
        Route::put('/categories/{id}','updateCategory')->name('updateCategory');
        Route::delete('/categories/{id}', 'deleteCategory')->name('deleteCategory');
    });