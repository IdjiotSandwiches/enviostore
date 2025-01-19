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

Route::prefix('product')
    ->name('product.')
    ->controller(ProductController::class)
    ->group(function () {
        Route::get('/', 'productIndex')->name('index');
        Route::get('/add', 'addProductIndex')->name('addProductIndex');
        Route::get('/{id}/edit', 'editProductIndex')->name('editProduct');
        Route::post('/add', 'addProduct')->name('addProduct');
        Route::post('/add/images/{id}', 'addProductImages')->name('addProductImage');
        Route::put('/{id}', 'updateProduct')->name('updateProduct');
        Route::delete('/{id}', 'deleteProduct')->name('deleteProduct');
        Route::delete('/image/{id}', 'deleteProductImage')->name('deleteProductImage'); 
    });

Route::prefix('categories')
    ->name('categories.')
    ->controller(CategoryController::class)
    ->group(function () {
        Route::get('/', 'categoryIndex')->name('index');
        Route::get('/add', 'addCategoryIndex')->name('addCategoryIndex');
        Route::get('/{id}/edit', 'editCategoryIndex')->name('editCategory');
        Route::post('/add', 'addCategory')->name('addCategory');
        Route::put('/{id}','updateCategory')->name('updateCategory');
        Route::delete('/{id}', 'deleteCategory')->name('deleteCategory');
    });