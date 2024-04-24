<?php


use App\Http\Controllers\Api\Provider\Auth\LoginController;
use App\Http\Controllers\Api\Provider\Auth\RegisterController;
use App\Http\Controllers\Api\Provider\Auth\RequestController;
use App\Http\Controllers\Api\Provider\ProviderController;
use Illuminate\Support\Facades\Route;




Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('request-join', [RequestController::class, 'join']);

Route::prefix('provider')->controller(ProviderController::class)->group(function () {
    Route::post('add-post', 'store');
    Route::get('all', 'index');
    Route::get('profile/{provider}', 'myProfile');
    Route::get('posts', 'posts');
    Route::put('update/{provider}', 'updateProfile');
    Route::get('show/{provider}', 'show');
});


Route::middleware('auth:provider')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:provider');
});
