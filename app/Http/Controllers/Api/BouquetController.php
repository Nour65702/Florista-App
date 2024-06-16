<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Addition\AdditionResource;
use App\Http\Resources\Bouquet\CustomBouquetResource;
use App\Http\Resources\Bouquet\DesignResource;
use App\Models\Addition;
use App\Models\BouquetShapes;
use App\Models\Color;
use App\Models\Design;
use App\Models\Product;
use App\Models\UserCustomBouquetProducts;
use App\Models\UserCustomBouquets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BouquetController extends Controller
{
    public function getAdditions()
    {
        $shapes = Addition::all();
        return ApiResponse::success(['additions'=> AdditionResource::collection($shapes)]);
    }

    public function getProducts()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function getDesigns()
    {
        $designs = Design::all();
        return ApiResponse::success([
            'boxes' => DesignResource::collection($designs)
        ]);
    }

    public function getColors()
    {
        $colors = Color::all();
        return response()->json($colors);
    }

    public function createCustomBouquet(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_id' => 'required|exists:colors,id',
            'design_id' => 'required|exists:designs,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'additions' => 'sometimes|array',
            'additions.*.type_addition_id' => 'required|exists:type_additions,id',
            'additions.*.name' => 'required|string|max:255',
        ]);

        $userId = auth()->id();
      //  $bouquetShapeId = $request->input('bouquet_shape_id');
        $colorId = $request->input('color_id');
        $designId = $request->input('design_id');
        $selectedProducts = $request->input('products');
        $selectedAdditions = $request->input('additions', []);
        $totalPrice = 0;

        // Calculate total price of products
        foreach ($selectedProducts as $selectedProduct) {
            $product = Product::find($selectedProduct['product_id']);
            $totalPrice += $product->price * $selectedProduct['quantity'];
        }

        // Calculate total price of additions if applicable
        foreach ($selectedAdditions as $selectedAddition) {
            // Assuming each addition has a fixed price, or you might need to calculate it based on type_addition_id
            $additionPrice = 10; // Replace with actual price calculation logic
            $totalPrice += $additionPrice;
        }

        // Create UserCustomBouquet
        $customBouquet = UserCustomBouquets::create([
            'user_id' => $userId,
           // 'bouquet_shape_id' => $bouquetShapeId,
            'color_id' => $colorId,
            'design_id' => $designId,
            'name' => $request->input('name'),
            'total_price' => $totalPrice,
        ]);


        // Create UserCustomBouquetProducts for each selected product
        foreach ($selectedProducts as $selectedProduct) {
            UserCustomBouquetProducts::create([
                'user_custom_bouquet_id' => $customBouquet->id,
                'product_id' => $selectedProduct['product_id'],
                'quantity' => $selectedProduct['quantity'],
            ]);
        }

        // Create Additions and associate them with the Order
        foreach ($selectedAdditions as $selectedAddition) {
            Addition::create([
                'type_addition_id' => $selectedAddition['type_addition_id'],
                'name' => $selectedAddition['name'],
                'description' => $selectedAddition['description'],
                'price' => $selectedAddition['price'],
            ]);
        }

        return response()->json(['success' => true, 'bouquet' => $customBouquet], 201);
    }

    // Get custom bouquets of the authenticated user
    public function getUserCustomBouquets()
    {
        $userId = auth()->id();
        $bouquets = UserCustomBouquets::where('user_id', $userId)
            ->with(['products.product', 'color', 'design', 'shape', 'userCustomBouquetAdditions.addition'])
            ->get();
        return ApiResponse::success(['bouqeuts' => CustomBouquetResource::collection($bouquets)]);
    }

    public function storeDesgin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'design_image' => 'required|image|max:2048', // Validate the image
        ]);

        $design = Design::create($request->only('name', 'description'));

        if ($request->hasFile('design_image')) {
            $design->addMedia($request->file('design_image'))->toMediaCollection('design_image');
        }

        $imageUrl = $design->media()->first()->getUrl(); 
        $imageUrl = str_replace('http://localhost:8000', '', $imageUrl);
        return response()->json([
            'message' => 'Design created successfully',
            'design' => $design,
            'image_url' => $imageUrl
        ]);
    }

    public function showDesign($id)
    {
        try {
            $design = Design::with('media')->findOrFail($id);
            $imageUrl = $design->getFirstMediaUrl('design_image');

            return response()->json(['design' => $design, 'image_url' => $imageUrl]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $provider = Design::all();
        return ApiResponse::success([
            'boxes' => DesignResource::collection($provider)
        ]);
    }
}
