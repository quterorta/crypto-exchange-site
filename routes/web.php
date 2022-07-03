<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CurrencyRateController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UserFrontendController;
use App\Http\Controllers\ReviewFrontendController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [BaseController::class, 'homePageView'])->name('home');
Route::get('/about-us', [BaseController::class, 'aboutUsPageView'])->name('about-us');
Route::get('/exchange', [BaseController::class, 'exchangePageView'])->name('exchange');
Route::get('/#reviews')->name('reviews');
Route::get('/faq', [BaseController::class, 'faqPageView'])->name('faq');
Route::get('/order-success', [BaseController::class, 'orderSuccessView'])->name('order-success');
Route::get('/account', [BaseController::class, 'accountPageView'])->name('account');
Route::get('/cancel-order/{id}', [UserOrderController::class, 'cancelOrder'])->name('user-order.cancel');
Route::get('/confirm-order/{id}', [UserOrderController::class, 'confirmOrder'])->name('user-order.confirm-payment');
Route::resource('user-order', UserOrderController::class);
Route::resource('user-frontend', UserFrontendController::class);
Route::resource('review-frontend', ReviewFrontendController::class);
Route::post('/get-rate-frontend', [BaseController::class, 'getRateFrontend'])->name('get-rate-frontend');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'adminBase'])->name('admin-home');
        Route::resource('currency', CurrencyController::class);
        Route::resource('currency-rate', CurrencyRateController::class);
        Route::post('/search-currency', [AdminController::class, 'searchCurrencyView'])->name('search-currency');
        Route::get('/update-currency-rates', [AdminController::class, 'updateCurrencyRates'])->name('update-currency-rates');
        Route::resource('review', ReviewController::class);
        Route::resource('order', OrderController::class);
        Route::resource('user', UserController::class);
    });
});

require __DIR__.'/auth.php';
