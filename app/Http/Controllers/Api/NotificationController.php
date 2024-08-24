<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }

    public function getNotifications(Request $request)
    {
        //dd($request->all());
        $user = $request->user();
        $notifications = $user->unreadNotifications;

        return response()->json([
            'notifications' => $notifications,
        ]);
    }
}
