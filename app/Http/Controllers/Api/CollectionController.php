<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Categories\CollectionResource;
use App\Http\Resources\Products\ProductResource;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;

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

    public function searchCollection(Request $request)
    {
        $query = $request->input('query');

        $collections = Collection::with(['products'])
            ->where('name', 'like', '%' . $query . '%')
            ->orWhereHas('products', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->get();

        return ApiResponse::success([
            'collections' => CollectionResource::collection($collections),
        ]);
    }

    public function searchProduct(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->with('collection')
            ->get();

        return ApiResponse::success([

            'products' => ProductResource::collection($products),
        ]);
    }
}
