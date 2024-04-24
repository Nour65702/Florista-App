<?php

use App\Http\Controllers\Api\Customer\Auth\LoginController;
use App\Http\Controllers\Api\Customer\Auth\RegisterController;
use App\Http\Controllers\Api\Customer\CustomerController;
use Illuminate\Support\Facades\Route;
use OpenSpout\Common\Entity\Row;

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::prefix('customer')->controller(CustomerController::class)->group(function(){
     Route::get('users','index');
     Route::get('profile/{user}','myProfile');
     Route::get('show/{user}','show');
     Route::put('update/{user}','updateProfile');
});
Route::middleware('auth:user')->group(function () {
   Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:user');
});
