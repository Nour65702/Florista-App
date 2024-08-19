<?php

use App\Http\Controllers\Api\BouquetController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\Customer\Auth\LoginController;
use App\Http\Controllers\Api\Customer\Auth\RegisterController;
use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\Api\LoyaltyController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductLikeController;
use Illuminate\Support\Facades\Route;


Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::prefix('customer')->controller(CustomerController::class)->group(function () {
    Route::get('users', 'index');
    Route::get('profile/{user}', 'myProfile');
    Route::get('show/{user}', 'show');
    Route::put('update/{user}', 'updateProfile');
});
Route::middleware('auth:user')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:user');
    Route::get('/products', [BouquetController::class, 'getProducts']);
    Route::get('/designs', [BouquetController::class, 'getDesigns']);
    Route::get('/colors', [BouquetController::class, 'getColors']);
    Route::post('/custom-bouquet', [BouquetController::class, 'createCustomBouquet']);
    Route::get('/custom-bouquets', [BouquetController::class, 'getUserCustomBouquets']);
    Route::post('/order', [OrderController::class, 'createOrder']);
    Route::get('/my-orders', [OrderController::class, 'getMyOrders']);



    // Cart routes
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::post('/cart/bouquet', [CartController::class, 'addBouquetToCart']);
    Route::delete('/cart/item/{id}', [CartController::class, 'deleteCartItem']);
    Route::delete('/cart/bouquet/{id}', [CartController::class, 'deleteBouquetFromCart']);

    //Send reports
    Route::post('/report', [CustomerController::class, 'sendReport']);

    //Like Product
    Route::post('products/{id}/like-or-unlike', [ProductLikeController::class, 'likeOrUnlike']);
    Route::get('products/{id}', [ProductLikeController::class, 'isProductLiked']);
    Route::get('liked-products', [ProductLikeController::class, 'getLikedProducts']);

    //loyalty points 
    Route::get('/loyalty', [LoyaltyController::class, 'index']);
    Route::get('/loyalty/transactions', [LoyaltyController::class, 'transactions']);
    Route::post('/loyalty/redeem', [LoyaltyController::class, 'redeemPoints']);
});
Route::post('store', [BouquetController::class, 'storeDesgin']);
