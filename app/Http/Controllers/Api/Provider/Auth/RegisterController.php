<?php

namespace App\Http\Controllers\Api\Provider\Auth;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Providers\StoreRegisterFormRequest;
use App\Models\Provider;


class RegisterController extends Controller
{
    public function register(StoreRegisterFormRequest $request)
    {

        $user = Provider::create($request->validated());
        $token = $user->createToken('provider_token')->accessToken;
        return ApiResponse::success(['provider' => $user, 'access_token' => $token]);
    }
}
