<?php

use App\Http\Controllers\Api\NotificationController;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

$dev_path = __DIR__ . '../Developers/';

Route::prefix('v1')->group(function () use ($dev_path) {

    // Address routes
    include "{$dev_path}Addresses.php";

    // // Products routes
    include "{$dev_path}Products.php";

    // Categories routes
    include "{$dev_path}Categories.php";

    // Collections routes
    include "{$dev_path}Collections.php";

    // Tasks routes
    include "{$dev_path}Tasks.php";

});

Route::get('/notifications', [NotificationController::class, 'getNotifications']);