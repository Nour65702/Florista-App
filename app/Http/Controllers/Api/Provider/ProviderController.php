<?php

namespace App\Http\Controllers\Api\Provider;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StoreAddWorkFormRequest;
use App\Http\Requests\Providers\StoreRegisterFormRequest;
use App\Http\Requests\Providers\UpdateProfileFormRequest;
use App\Http\Resources\Providers\PostResource;
use App\Http\Resources\Providers\ProviderResource;
use App\Models\Provider;
use App\Models\WorkProvider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{

    public function index()
    {
        $provider = Provider::all();

        return ApiResponse::success([
            'providers' => ProviderResource::collection($provider)
        ]);
    }

    public function store(StoreAddWorkFormRequest $request)
    {

        $providerId = auth()->id();

        $provider = Provider::with('licence')->findOrFail($providerId);

        if (!$provider->licence || $provider->licence->is_active !== 1) {
            return ApiResponse::error('You are not authorized to add a post. Please wait for admin approval.', 403);
        }

        $validatedData = $request->validated();
        $validatedData['provider_id'] = $providerId;

        $post = WorkProvider::create($validatedData);


        if ($request->hasFile('post_images')) {
            foreach ($request->file('post_images') as $image) {
                $post->addMedia($image)->toMediaCollection('images');
            }
        }

        $imageUrls = [];
        foreach ($post->getMedia('images') as $media) {
            $imageUrl = $media->getUrl();
            $imageUrl = str_replace('http://localhost:8000', '', $imageUrl);
            $imageUrls[] = $imageUrl;
        }

        return ApiResponse::success([
            'post' => PostResource::make($post),
        ]);
    }

    public function show(string $id)
    {
        $provider = Provider::with('licence')->findOrFail($id);
        return ApiResponse::success([
            'provider' => ProviderResource::make($provider)
        ]);
    }


    public function myProfile(string $id)
    {
        $provider = Provider::with('posts')->findOrFail($id);
        return ApiResponse::success([
            'profile' => ProviderResource::make($provider)
        ]);
    }


    public function updateProfile(UpdateProfileFormRequest $request, string $id)
    {
        $provider = Provider::findOrFail($id);
        $validatedData = $request->validated();
        if ($request->hasFile('profile_image')) {
            $provider->clearMediaCollection('profile_image');
            $provider->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }
        $provider->update($validatedData);


        return ApiResponse::success([
            'message' => 'The Details Update Sucssesfully',
            'provider' => ProviderResource::make($provider)
        ]);
    }


    public function posts()
    {
        $posts = WorkProvider::all();
        return ApiResponse::success(['posts' => PostResource::collection($posts)]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $providers = Provider::where('name', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->get();

        return ApiResponse::success([
            'providers' => ProviderResource::collection($providers),
        ]);
    }
}
