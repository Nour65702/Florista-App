<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Modify\ModifyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login',[LoginController::class,'login']);



Route::middleware('auth:Admin')->group(function(){
   Route::post('logout',[LoginController::class,'logout'])->middleware('auth:Admin');
   Route::get('show-requests',[ModifyController::class,'getRequests'])->middleware('auth:Admin');
   Route::post('modify-request/{id}',[ModifyController::class,'modify'])->middleware('auth:Admin');
});
