<?php


use App\Http\Controllers\Api\Provider\Auth\LoginController;
use App\Http\Controllers\Api\Provider\Auth\RegisterController;
use App\Http\Controllers\Api\Provider\Auth\RequestController;
use App\Http\Controllers\Api\Provider\ProviderController;
use Illuminate\Support\Facades\Route;




Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::post('request-join', [RequestController::class, 'join']);

Route::controller(ProviderController::class)->group(function () {
    Route::get('all', 'index');
    Route::get('profile/{provider}', 'myProfile');
    Route::get('posts', 'posts');
    Route::put('update/{provider}', 'updateProfile');
    Route::get('show/{provider}', 'show');
    Route::get('search', 'search');
  
});

Route::middleware('auth:provider')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:provider');
    Route::post('add-post',[ProviderController::class,'store'] );

});
