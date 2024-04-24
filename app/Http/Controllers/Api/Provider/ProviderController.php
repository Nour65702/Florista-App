<?php

namespace App\Http\Controllers\Api\Provider;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StoreAddWorkFormRequest;
use App\Http\Requests\Providers\StoreRegisterFormRequest;
use App\Http\Resources\Providers\PostResource;
use App\Http\Resources\Providers\ProviderResource;
use App\Models\Provider;
use App\Models\WorkProvider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provider = Provider::all();
        return ApiResponse::success([
            'providers' => ProviderResource::collection($provider)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddWorkFormRequest $request)
    {
        $validatedData = $request->validated();
        $post = WorkProvider::create($validatedData);

        return ApiResponse::success([
            'post' => PostResource::make($post)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $provider = Provider::findOrFail($id);
        return ApiResponse::success([
            'provider' => $provider
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function myProfile(string $id)
    {
        $provider = Provider::with('posts')->findOrFail($id);
        return ApiResponse::success([
            'profile' => ProviderResource::make($provider)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(StoreRegisterFormRequest $request, string $id)
    {
        $provider = Provider::findOrFail($id);
        $validatedData = $request->validated();
        $provider->update($validatedData);


        return ApiResponse::success([
            'message' => 'The Details Update Sucssesfully',
            'provider' => ProviderResource::make($provider)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
