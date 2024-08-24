<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartItemAddition;
use App\Models\Product;
use App\Models\UserCustomBouquets;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with([
                'items.additions',
                'customBouquets.products',
                'customBouquets.userCustomBouquetAdditions'
            ])
            ->first();

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

            $product = Product::find($itemData['product_id']);


            if ($product->quantity <= 0) {
                return response()->json(['message' => "The product '{$product->name}' is out of stock."], 400);
            }


            if ($product->quantity < $itemData['quantity']) {
                return response()->json(['message' => "The requested quantity for '{$product->name}' exceeds available stock. Available quantity: {$product->quantity}."], 400);
            }

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

        foreach ($bouquet->products as $bouquetProduct) {
            $product = Product::find($bouquetProduct->product_id);


            if ($product->quantity <= 0) {
                return response()->json(['message' => "The product '{$product->name}' in the bouquet is out of stock."], 400);
            }


            if ($product->quantity < $bouquetProduct->quantity) {
                return response()->json(['message' => "The requested quantity for '{$product->name}' in the bouquet exceeds available stock. Available quantity: {$product->quantity}."], 400);
            }
        }

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

    public function deleteCartItem($id)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)->find($id);

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Cart item deleted successfully']);
    }

    public function deleteBouquetFromCart($id)
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $bouquet = UserCustomBouquets::find($id);

        if (!$bouquet) {
            return response()->json(['message' => 'Bouquet not found'], 404);
        }

        $cart->customBouquets()->detach($bouquet->id);

        return response()->json(['message' => 'Bouquet removed from cart successfully']);
    }
}
