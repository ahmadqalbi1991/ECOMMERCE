<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showLoginForm']);
Auth::routes();

// Auth routes
Route::group(['prefix' => 'auth/', 'as' => 'auth.', 'middleware' => 'auth'], function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('home')->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/save-setting', [SettingController::class, 'store'])->name('store');
        Route::post('/save-banner-images', [SettingController::class, 'saveBannerImages'])->name('save-banners');
        Route::get('/change-banner-home-status/{id}', [SettingController::class, 'changeStatus'])->name('change-banner-status');
        Route::get('/delete-banner/{id}', [SettingController::class, 'deleteBanner'])->name('delete-banner');
        Route::post('save-city', [SettingController::class, 'saveCity'])->name('save-city');
        Route::get('/delete-city/{id}', [SettingController::class, 'deleteCity'])->name('delete-city');
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/add', [CategoryController::class, 'add'])->name('create');
        Route::post('/save', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
        Route::post('/get-parent-categories', [CategoryController::class, 'getParentCategories'])->name('get-parent-category');
    });

    Route::group(['prefix' => 'brands', 'as' => 'brands.'], function () {
        Route::get('/', [BrandsController::class, 'index'])->name('index');
        Route::post('/save', [BrandsController::class, 'store'])->name('store');
        Route::get('/delete/{id}', [BrandsController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'units', 'as' => 'units.'], function () {
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::post('/save', [UnitController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'attributes', 'as' => 'attributes.'], function () {
        Route::get('/', [AttributeController::class, 'index'])->name('index');
        Route::post('/save', [AttributeController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AttributeController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AttributeController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [AttributeController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/add', [ProductController::class, 'add'])->name('add');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::post('/getVariationDiv', [ProductController::class, 'getVariations'])->name('getVariations');
        Route::get('/edit/{slug}', [ProductController::class, 'edit'])->name('edit');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::post('/update/{slug}', [ProductController::class, 'update'])->name('update');
        Route::get('/delete/{slug}', [ProductController::class, 'delete'])->name('delete');
        Route::get('/delete/image/{id}', [ProductController::class, 'deleteImage'])->name('delete-image');
    });

    Route::group(['prefix' => 'promo-codes', 'as' => 'promo-codes.'], function () {
        Route::get('/', [PromoCodeController::class, 'index'])->name('index');
        Route::get('/add', [PromoCodeController::class, 'create'])->name('create');
        Route::post('/save-promo-code', [PromoCodeController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PromoCodeController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PromoCodeController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [PromoCodeController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'faqs', 'as' => 'faqs.'], function () {
        Route::get('/', [FaqController::class, 'index'])->name('index');
        Route::get('/add', [FaqController::class, 'create'])->name('create');
        Route::post('/save', [FaqController::class, 'store'])->name('save');
        Route::get('/edit/{id}', [FaqController::class, 'edit'])->name('edit');
        Route::get('/delete/{id}', [FaqController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
       Route::get('/', [OrderController::class, 'index'])->name('index');
       Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('detail');
       Route::get('/pdf', [OrderController::class, 'PDF'])->name('pdf');
       Route::post('/change-status', [OrderController::class, 'changeStatus'])->name('change-status');
    });

    Route::group(['prefix' => 'feedbacks', 'as' => 'feedbacks.'], function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('index');
        Route::get('/published/{id}/{status}', [FeedbackController::class, 'handlePublished'])->name('published');
        Route::get('/delete/{id}', [FeedbackController::class, 'delete'])->name('delete');
    });
});

Route::get('/test-email-temp', function () {
   return view('email-templates.register-success');
});

Route::get('/update-admin-pass', function () {
   \App\Models\User::where('id', 1)->update(['password' => bcrypt('123456789')]);
});



