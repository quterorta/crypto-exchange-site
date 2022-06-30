<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductSpecificationController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CurrencyRateController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProductController as UserProductController;
use App\Http\Controllers\CategoryController as UserCategoryController;

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
Route::get('/reviews', [BaseController::class, 'reviewsPageView'])->name('reviews');
Route::get('/faq', [BaseController::class, 'faqPageView'])->name('faq');
Route::get('/contacts', [BaseController::class, 'contactsPageView'])->name('contacts');
Route::get('/wishlist', [BaseController::class, 'wishlistPageView'])->name('wishlist');
Route::post('/set-wishlist', [BaseController::class, 'setWishlist'])->name('set-wishlist');
Route::get('/all-products', [BaseController::class, 'allProductsPageView'])->name('all-products');
Route::post('/product-contact-form', [MailController::class, 'productDetailContactForm'])->name('product-contact-form');
Route::post('/page-contact-form', [MailController::class, 'pageContactForm'])->name('page-contact-form');
Route::post('/footer-contact-form', [MailController::class, 'footerContactForm'])->name('footer-contact-form');
Route::get('/search', [BaseController::class, 'searchView'])->name('search');
Route::get('/product/{slug}', [UserProductController::class, 'productDetailView'])->name('product-detail');
Route::get('/category/{slug}/products', [UserCategoryController::class, 'categoryDetailView'])->name('category-detail');
Route::get('/account/{id}', [BaseController::class, 'accountPageView'])->name('account');

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
