<?php

namespace App\Http\Controllers\Api\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\StoreRegisterFormRequest;
use App\Http\Resources\Customers\CustomerResource;
use App\Models\User;


class RegisterController extends Controller
{
    public function register(StoreRegisterFormRequest $request)
    {

        $user = User::create($request->validated());
        if ($request->hasFile('user_image')) {
            $user->addMediaFromRequest('user_image')->toMediaCollection('user_image');
        }
        $token = $user->createToken('user_token')->accessToken;
        return response()->json(['user' => CustomerResource::make($user), 'access_token' => $token], 200);
    }
}
