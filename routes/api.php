<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Mail\HelloEmail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api', 'verify_api', 'throttle:10000000000000,1']], function () {
    Route::get('/site-setting', [SiteController::class, 'siteSetting']);
    Route::get('/homeFeeds', [SiteController::class, 'homeFeeds']);
    Route::get('/getProducts', [ProductController::class, 'getProducts']);
    Route::get('/getDealProducts/{id}', [ProductController::class, 'getDealProducts']);
    Route::get('/search', [ProductController::class, 'search']);
    Route::get('/getCategoryProducts', [ProductController::class, 'getCategoryProducts']);
    Route::get('/product/{slug}', [ProductController::class, 'getProduct']);
    Route::post('/get-recent-products', [ProductController::class, 'getRecentProducts']);
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/cities-options', [SiteController::class, 'getCities']);
    Route::post('/secure-key-generate', [SiteController::class, 'generateHMAC']);
    Route::post('/verify-token', [UserController::class, 'verifyUser']);
    Route::post('/sign-in', [UserController::class, 'userLogin']);
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/get-user-by-token', [UserController::class, 'getUserByToken']);
        Route::post('/save-address', [UserController::class, 'saveAddress']);
        Route::get('/get-addresses', [UserController::class, 'getAddress']);
        Route::post('/active-address', [UserController::class, 'activeAddress']);
        Route::get('/delete-address/{id}', [UserController::class, 'deleteAddress']);
        Route::post('/save-cart-session', [UserController::class, 'saveOrderSession']);
        Route::post('/apply-code', [UserController::class, 'applyCode']);
        Route::post('/save-review', [UserController::class, 'saveReview']);
        Route::get('/get-billu-points-history', [UserController::class, 'getPointsHistory']);
        Route::post('/update-profile', [UserController::class, 'updateProfile']);
        Route::get('/my-orders', [UserController::class, 'myOrders']);
        Route::get('/my-returns', [UserController::class, 'myReturns']);
        Route::get('/my-wishlist', [UserController::class, 'myWishList']);
        Route::post('/return-order', [UserController::class, 'returnOrder']);
        Route::post('/add-to-wishlist', [UserController::class, 'addToWishList']);
        Route::get('/logout', [UserController::class, 'logout']);
    });
});

Route::post('/login', [LoginController::class, 'login']);
