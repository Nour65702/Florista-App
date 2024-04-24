<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;



Route::prefix('category')->controller(CategoryController::class)->group(function () {

    Route::get('all', 'index');
    Route::get('show/{category}', 'show');
});
