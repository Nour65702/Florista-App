<?php

namespace App\Http\Controllers\Api\Customer;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\StoreRegisterFormRequest;
use App\Http\Requests\Customers\UpdateProfileFormRequest;
use App\Http\Resources\Customers\CustomerResource;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return ApiResponse::success([
            'users' => CustomerResource::collection($users)
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return ApiResponse::success([
            'user' => CustomerResource::make($user)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function myProfile(string $id)
    {
        $user = User::with('address')->findOrFail($id);
        return ApiResponse::success([
            'profile' => CustomerResource::make($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(UpdateProfileFormRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validated();

        if ($request->hasFile('user_image')) {
            $user->clearMediaCollection('user_image');
            $user->addMediaFromRequest('user_image')->toMediaCollection('user_image');
        }
        $user->update($validatedData);

        return ApiResponse::success([
            'message' => 'The Details Update Sucssesfully',
            'profile' => CustomerResource::make($user),

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
