<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Addresses\AddressResource;
use App\Http\Resources\Order\OrderResource;
use App\Models\Addition;
use App\Models\Address;
use App\Models\Alert;
use App\Models\Cart;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyTransaction;
use App\Models\Order;
use App\Models\OrderCustomBouquet;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserCustomBouquets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_method' => 'nullable|string',
            'delivery_to' => 'nullable|string',
            'shipping_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);


        $cart = Cart::where('user_id', $request->user_id)->first();
        if (!$cart) {
            return ApiResponse::notFound('No cart found for the user');
        }

        $cartItems = $cart->items;
        if ($cartItems->isEmpty()) {
            return ApiResponse::error('Cart is empty');
        }


        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;


            if ($product->quantity < $cartItem->quantity) {

                $cartItem->quantity = $product->quantity;
            }

            $product->quantity -= $cartItem->quantity;
            $product->save();

            // if ($product->quantity <= $product->min_level) {

            //     if (!Alert::where('product_id', $product->id)->exists()) {
            //         Alert::create(['product_id' => $product->id]);
            //     }
            // }
            if ($product->quantity <= $product->min_level) {
                Alert::firstOrCreate(['product_id' => $product->id]);
            }

            $totalPrice += $product->price * $cartItem->quantity;
        }


        if ($request->filled('custom_bouquet_id')) {
            $bouquet = UserCustomBouquets::findOrFail($request->custom_bouquet_id);
            $totalPrice += $bouquet->total_price;
        }

        $orderData = [
            'user_id' => $request->user_id,
            'total_price' => $totalPrice,
            'payment_method' => $request->input('payment_method', null),
            'payment_status' => $request->input('payment_status', 'pending'),
            'delivery_to' => $request->input('delivery_to', null),
            'shipping_method' => $request->input('shipping_method', null),
            'notes' => $request->input('notes', null),
        ];

        $order = Order::create($orderData);


        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'unit_amount' => $product->price,
                'total_amount' => $product->price * $cartItem->quantity,
                'quantity' => $cartItem->quantity,
            ]);
        }


        if ($request->filled('custom_bouquet_id')) {
            OrderCustomBouquet::create([
                'order_id' => $order->id,
                'user_custom_bouquet_id' => $request->custom_bouquet_id,
            ]);
        }

        return ApiResponse::success(['message' => 'Order created successfully', 'order' => OrderResource::make($order)]);
    }

    // public function createOrder(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'payment_method' => 'nullable|string',
    //         'delivery_to' => 'nullable|string',
    //         'shipping_method' => 'nullable|string',
    //         'notes' => 'nullable|string',
    //         'redeem_points' => 'nullable|integer|min:0', // New validation rule for points
    //     ]);

    //     $cart = Cart::where('user_id', $request->user_id)->first();
    //     if (!$cart || $cart->items->isEmpty()) {
    //         return ApiResponse::notFound('No items found in the cart for the user');
    //     }

    //     $cartItems = $cart->items;
    //     $totalPrice = 0;

    //     foreach ($cartItems as $cartItem) {
    //         $product = $cartItem->product;

    //         if ($product->quantity < $cartItem->quantity) {
    //             $cartItem->quantity = $product->quantity;
    //         }

    //         $product->quantity -= $cartItem->quantity;
    //         $product->save();

    //         if ($product->quantity <= $product->min_level) {
    //             if (!Alert::where('product_id', $product->id)->exists()) {
    //                 Alert::create(['product_id' => $product->id]);
    //             }
    //         }

    //         $totalPrice += $product->price * $cartItem->quantity;
    //     }

    //     if ($request->filled('custom_bouquet_id')) {
    //         $bouquet = UserCustomBouquets::findOrFail($request->custom_bouquet_id);
    //         $totalPrice += $bouquet->total_price;
    //     }

    //     // Applying discount from loyalty points
    //     $discountAmount = 0;
    //     if ($request->filled('redeem_points')) {
    //         $loyaltyPoint = LoyaltyPoint::where('user_id', $request->user_id)->first();
    //         $pointsToRedeem = min($loyaltyPoint->points, $request->redeem_points);

    //         // Assuming 100 points = $1 discount
    //         $discountAmount = $pointsToRedeem / 100;
    //         $totalPrice -= $discountAmount;

    //         // Update loyalty points and save the transaction
    //         $loyaltyPoint->points -= $pointsToRedeem;
    //         $loyaltyPoint->save();

    //         LoyaltyTransaction::create([
    //             'user_id' => $request->user_id,
    //             'points' => $pointsToRedeem,
    //             'type' => 'redemption',
    //             'description' => 'Points redeemed for a discount of $' . $discountAmount,
    //         ]);
    //     }

    //     // Ensure the total price doesn't go below zero
    //     $totalPrice = max($totalPrice, 0);

    //     $orderData = [
    //         'user_id' => $request->user_id,
    //         'total_price' => $totalPrice,
    //         'payment_method' => $request->input('payment_method', null),
    //         'payment_status' => $request->input('payment_status', 'pending'),
    //         'delivery_to' => $request->input('delivery_to', null),
    //         'shipping_method' => $request->input('shipping_method', null),
    //         'notes' => $request->input('notes', null),
    //     ];

    //     $order = Order::create($orderData);

    //     foreach ($cartItems as $cartItem) {
    //         $product = $cartItem->product;
    //         OrderItem::create([
    //             'order_id' => $order->id,
    //             'product_id' => $product->id,
    //             'unit_amount' => $product->price,
    //             'total_amount' => $product->price * $cartItem->quantity,
    //             'quantity' => $cartItem->quantity,
    //         ]);
    //     }

    //     if ($request->filled('custom_bouquet_id')) {
    //         OrderCustomBouquet::create([
    //             'order_id' => $order->id,
    //             'user_custom_bouquet_id' => $request->custom_bouquet_id,
    //         ]);
    //     }

    //     $cart->items()->delete(); // Delete all items from the cart
    //     $cart->customBouquets()->detach(); // Detach any custom bouquets from the cart

    //     return ApiResponse::success([
    //         'message' => 'Order created successfully',
    //         'order' => OrderResource::make($order),
    //         'discount_applied' => $discountAmount
    //     ]);
    // }

    public function getMyOrders(Request $request)
    {
        $userId = Auth::id(); 

        $orders = Order::where('user_id', $userId)->get();

        return ApiResponse::success([
            'orders' => OrderResource::collection($orders),
        ]);
    }
}
