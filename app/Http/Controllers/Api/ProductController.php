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


    public function updateAddition(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type_addition_id' => 'sometimes|required|exists:type_additions,id',
            'description' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'addition_image' => 'sometimes|image|max:2048', // Validate the image if provided
        ]);
    
        $addition = Addition::findOrFail($id);
    
        // Update the addition details
        if ($request->has('name')) {
            $addition->name = $request->name;
        }
        if ($request->has('type_addition_id')) {
            $addition->type_addition_id = $request->type_addition_id;
        }
        if ($request->has('description')) {
            $addition->description = $request->description;
        }
        if ($request->has('price')) {
            $addition->price = $request->price;
        }
    
        // Check if a new image is being uploaded
        if ($request->hasFile('addition_image')) {
            // Remove old image if exists
            // $addition->clearMediaCollection('images');
            
            // Add new image
            $addition->addMedia($request->file('addition_image'))->toMediaCollection('images');
            
            // Retrieve the URL of the newly added image
            $imageUrl = $addition->getFirstMediaUrl('images');
        } else {
            // If no new image was uploaded, retain the existing image URL
            $imageUrl = $addition->getFirstMediaUrl('images');
        }
    
        $addition->save();
    
        return ApiResponse::success([
            'message' => 'Addition updated successfully',
            'addition' => [
                'id' => $addition->id,
                'type_addition_id' => $addition->type_addition_id,
                'name' => $addition->name,
                'description' => $addition->description,
                'price' => $addition->price,
                'image_url' => $imageUrl,
            ],
        ]);
    }
    
}
