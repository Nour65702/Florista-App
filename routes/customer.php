<?php

use App\Http\Controllers\Api\BouquetController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\Customer\Auth\LoginController;
use App\Http\Controllers\Api\Customer\Auth\RegisterController;
use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;
use OpenSpout\Common\Entity\Row;

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


    
     // Cart routes
     Route::get('/cart', [CartController::class, 'index']);
     Route::post('/cart', [CartController::class, 'store']);
     Route::post('/cart/bouquet', [CartController::class, 'addBouquetToCart']);

});
  Route::post('store',[BouquetController::class, 'storeDesgin']);

  
