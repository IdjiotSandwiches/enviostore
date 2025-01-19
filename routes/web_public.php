<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\common\ProductController;
use App\Http\Controllers\user\CategoryController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\user\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest:admin'])->group(function () {
    Route::controller(HomeController::class)->group(function(){
        Route::get('/', 'index')->name('home');
        Route::get('/home-item', 'getHomeItems')->name('getHomeItems');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products/{product_serial}', 'getProduct')->name('getProduct');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/{category_serial}', 'index')->name('categoryPage');
    });
});

Route::middleware(['guest:web,admin'])->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login')->name('attemptLogin');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'index')->name('register');
        Route::post('/register', 'register')->name('attemptRegister');
    });
});

Route::controller(EmailVerificationController::class)->group(function () {
    Route::get('/email/verify', 'verificationNotice')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verifyEmail')->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', 'resendVerification')->middleware(['throttle:6,1'])->name('verification.send');
})->middleware(['auth']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware(['auth:web,admin']);
Route::get('/language/{locale}', [LocaleController::class, 'setLocale'])->name('toggleLanguage');

Route::fallback(function () {
    return view('errors.404');
})->middleware(['web','admin']);
