<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemAddition;
use App\Models\Order;
use App\Models\OrderCustomBouquet;
use App\Models\OrderItem;
use App\Models\UserCustomBouquets;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with([
                'items.additions',   'customBouquets.products', 
                'customBouquets.userCustomBouquetAdditions'
            ])
            ->first();
        // return response()->json($cart);
        return ApiResponse::success(['my_cart' => CartResource::make($cart)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'required|array',
            'items.*.size.*' => 'string|in:small,medium,big',
            'items.*.additions' => 'array',
            'items.*.additions.*.addition_id' => 'exists:additions,id',
            'items.*.additions.*.quantity' => 'integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        foreach ($request->items as $itemData) {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $itemData['product_id'],
                'quantity' => $itemData['quantity'],
                'size' => $itemData['size'],
            ]);

            if (isset($itemData['additions'])) {
                foreach ($itemData['additions'] as $additionData) {
                    CartItemAddition::create([
                        'cart_item_id' => $cartItem->id,
                        'addition_id' => $additionData['addition_id'],
                        'quantity' => $additionData['quantity'],
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Items added to cart successfully']);
    }

    public function addBouquetToCart(Request $request)
    {
        $request->validate([
            'bouquet_id' => 'required|exists:user_custom_bouquets,id',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $bouquet = UserCustomBouquets::with('products.additions')->findOrFail($request->bouquet_id);

        // $cart->customBouquets()->attach($request->bouquet_id);
        foreach ($bouquet->products as $bouquetProduct) {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $bouquetProduct->product_id,
                'quantity' => $bouquetProduct->quantity,
                'size' => $bouquetProduct->size,
            ]);

            foreach ($bouquetProduct->additions as $addition) {
                CartItemAddition::create([
                    'cart_item_id' => $cartItem->id,
                    'addition_id' => $addition->addition_id,
                    'quantity' => $addition->quantity,
                ]);
            }
        }
        $cart->customBouquets()->attach($bouquet);


        $bouquet = $bouquet->fresh();

        return response()->json(['message' => 'Bouquet added to cart successfully', 'bouquet' => $bouquet]);
    }
}
