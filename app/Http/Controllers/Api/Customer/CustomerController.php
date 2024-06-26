<?php

namespace App\Http\Controllers\Api\Customer;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\StoreReportFormRequest;
use App\Http\Requests\Customers\UpdateProfileFormRequest;
use App\Http\Resources\Customers\CustomerResource;
use App\Http\Resources\Customers\ReportResource;
use App\Models\Report;
use App\Models\User;

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

   
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return ApiResponse::success([
            'user' => CustomerResource::make($user)
        ]);
    }

   
    public function myProfile(string $id)
    {
        $user = User::with('address')->findOrFail($id);
        return ApiResponse::success([
            'profile' => CustomerResource::make($user)
        ]);
    }

   
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

    public function sendReport(StoreReportFormRequest $request)
    {
        $userId = auth()->id();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $userId;

        $report = Report::create($validatedData);

        return ApiResponse::success([
            'message' => 'Report submitted successfully',
            'report' => ReportResource::make($report),
        ]);
    }
}
