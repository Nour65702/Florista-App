<?php

use App\Http\Controllers\Api\CollectionController;
use Illuminate\Support\Facades\Route;



Route::prefix('collection')->controller(CollectionController::class)->group(function () {

    Route::get('all', 'index');
    Route::get('show/{collection}', 'show');
});
