<?php

namespace App\Http\Controllers\Api\Customer;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\StoreRegisterFormRequest;
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
            'users' => $users
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
            'user' => $user
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
    public function updateProfile(StoreRegisterFormRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validated();
        $user->update($validatedData);

        return ApiResponse::success([
            'message' => 'The Details Update Sucssesfully',
            'profile' => $user,
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
