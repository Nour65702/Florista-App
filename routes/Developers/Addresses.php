<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\ContactUsController;
use Illuminate\Support\Facades\Route;



Route::prefix('address')->controller(AddressController::class)->group(function () {

    Route::post('create',  'store');
    Route::get('cities', 'allCities');
    Route::get('countries', 'allCountries');
});

Route::get('contact', [ContactUsController::class, 'index']);
