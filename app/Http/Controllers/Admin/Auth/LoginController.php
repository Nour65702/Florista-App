<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Providers\StoreLoginFormRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(StoreLoginFormRequest $request)
    {

        $credential = $request->only('email', 'password');
        $user = Auth::guard('Admin-api')->attempt($credential);
        if (!$user)
            return response()->json(['message' => 'Invalid login or password.'], 401);

        $user = auth('Admin-api')->user();
        $user->api_token = $user->createToken('user_token')->accessToken;
        return response()->json(['data' => $user]);
    }

    public function logout()
    {
        auth()->guard('user')->user()->token()->revoke();
        return response()->json(['message' => 'logout successfully']);
    }
}
