<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addresses\StoreAddressFormRequest;
use App\Http\Resources\Addresses\AddressResource;
use App\Models\Address;
use App\Http\Resources\Addresses\CountryResource;
use App\Models\Country;

class AddressController extends Controller
{
    public function store(StoreAddressFormRequest $request)
    {
        $validatedData = $request->validated();

        $address = Address::create($validatedData);

        return ApiResponse::success([
            'message' => 'Address created successfully',
            'data' => AddressResource::make($address)
        ]);
    }

    public function allCountries()
    {
        $country = Country::all();
        return ApiResponse::success([
            'countries' => CountryResource::collection($country)
        ]);
    }
}
