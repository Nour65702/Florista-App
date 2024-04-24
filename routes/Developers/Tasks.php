<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('task')->controller(TaskController::class)->group(function () {
    Route::post('create', 'store');
    Route::get('all', 'index');
    Route::get('show/{task}', 'show');
    Route::get('my-tasks/{provider}', 'myTasks');
});
