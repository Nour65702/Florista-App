<?php

namespace App\Http\Controllers\Api\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\StoreRegisterFormRequest;
use App\Models\User;


class RegisterController extends Controller
{
    public function register(StoreRegisterFormRequest $request)
    {

        $user = User::create($request->validated());
        $token = $user->createToken('user_token')->accessToken;
        return response()->json(['user' => $user, 'access_token' => $token], 200);
    }
}
