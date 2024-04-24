<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Categories\CollectionResource;
use App\Models\Collection;

class CollectionController extends Controller
{

    public function index()
    {
        $collections = Collection::with('products')->get();
        return ApiResponse::success([
            'collections' => CollectionResource::collection($collections),
        ]);
    }

    public function show(string $id)
    {
        $collection = Collection::findOrfail($id)->loadMissing('products');
        return ApiResponse::success([
            'Collection' => CollectionResource::make($collection),
        ]);
    }
}
