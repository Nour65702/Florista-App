<?php

namespace App\Http\Controllers\Api\Provider\Auth;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Providers\StoreLoginFormRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(StoreLoginFormRequest $request)
    {

        $credential = $request->only('email', 'password');
        $user = Auth::guard('provider-api')->attempt($credential);
        if (!$user)
            return ApiResponse::error(['message' => 'Invalid login or password.']);

        $user = auth('provider-api')->user();
        $token = $user->createToken('user_token')->accessToken;
        $user->api_token = $token;
        return ApiResponse::success(['data' => $user]);
    }


    public function logout()
    {
        auth()->guard('user')->user()->token()->revoke();
        return ApiResponse::success(['message' => 'logout successfully']);
    }
}
