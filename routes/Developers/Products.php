<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;



Route::prefix('product')->controller(ProductController::class)->group(function () {
    Route::get('all-products', 'index');
    Route::get('show/{product}', 'show');
});


Route::prefix('product')->controller(ReviewController::class)->group(function () {
    Route::post('add-review', 'store');
    Route::get('all', 'index');
});
Route::post('addition',[ProductController::class, 'storeAddition']);
Route::get('all-additions',[ProductController::class, 'getAllAdditions']);
Route::post('products',[ProductController::class, 'store']);
