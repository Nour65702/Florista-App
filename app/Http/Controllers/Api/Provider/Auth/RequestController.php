<?php

namespace App\Http\Controllers\Api\Provider\Auth;

use App\Http\Controllers\Controller;
use App\Models\Provider_licence;
use App\Http\Requests\Providers\StoreJoinProviderFormRequest;

class RequestController extends Controller
{
    public function join(StoreJoinProviderFormRequest $request)
    {

        $req = Provider_licence::create($request->validated());

        return response()->json(['message' => "your request has recivied "], 200);
    }
}
