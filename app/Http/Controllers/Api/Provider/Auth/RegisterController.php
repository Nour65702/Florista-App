<?php

namespace App\Http\Controllers\Api\Provider\Auth;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Providers\StoreRegisterFormRequest;
use App\Http\Resources\Providers\ProviderResource;
use App\Models\Provider;


class RegisterController extends Controller
{
    public function register(StoreRegisterFormRequest $request)
    {

        $user = Provider::create($request->validated());
        if ($request->hasFile('profile_image')) {
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }
        $token = $user->createToken('provider_token')->accessToken;
        return ApiResponse::success([
            'provider' => ProviderResource::make($user),
            'access_token' => $token,
        ]);
    }
}
