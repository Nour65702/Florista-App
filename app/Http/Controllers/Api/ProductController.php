<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Addition\AdditionResource;
use App\Http\Resources\Products\ProductResource;
use App\Models\Addition;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('reviews')->get();
        return ApiResponse::success([
            'products' => ProductResource::collection($products)
        ]);
    }


    public function create()
    {
        //
    }


    public function store(StoreProductRequest $request)
    {
        // Validate incoming request data
        $validatedData = $request->validated();

        // Create the product
        $product = Product::create($validatedData);
        $product->addMedia($request->image)->toMediaCollection('product_image');
        if ($request->has('additions')) {
            $product->additions()->attach($request->additions);
        }
        return ApiResponse::success([
            'product' => ProductResource::make($product),
            'message' => 'Product created successfully',
        ]);
    }


    public function show(string $id)
    {
        $product = Product::with(['reviews', 'additions'])->findOrFail($id);
        return ApiResponse::success([
            'product' =>  ProductResource::make($product)
        ]);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }

    public function storeAddition(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type_addition_id' => 'required|exists:type_additions,id',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'addition_image' => 'required|image|max:2048', // Validate the image
        ]);

        $addition = Addition::create([
            'name' => $request->name,
            'type_addition_id' => $request->type_addition_id,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // Store the addition image using Spatie Media Library
        if ($request->hasFile('addition_image')) {
            $addition->addMedia($request->file('addition_image'))->toMediaCollection('images');
        }

        // Retrieve image URL if it exists
        $imageUrl = null;
        $media = $addition->getFirstMedia('images');
        if ($media) {
            $imageUrl = $media->getUrl();
            $imageUrl = str_replace('http://localhost:8000', '', $imageUrl);
        }

        return ApiResponse::success([
            'message' => 'Addition created successfully',
            'addition' => AdditionResource::make($addition),

        ]);
    }

    public function getAllAdditions()
    {
        $additions = Addition::all();
        return ApiResponse::success([
            'additions' => AdditionResource::collection($additions)
        ]);
    }
}
