<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Addresses\AddressResource;
use App\Http\Resources\Order\OrderResource;
use App\Models\Addition;
use App\Models\Address;
use App\Models\Alert;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderCustomBouquet;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserCustomBouquets;
use Illuminate\Http\Request;

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
            return response()->json(['message' => 'No cart found for the user'], 404);
        }

        $cartItems = $cart->items;


        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;


            if ($product->quantity < $cartItem->quantity) {

                $cartItem->quantity = $product->quantity;
            }

            $product->quantity -= $cartItem->quantity;
            $product->save();

            if ($product->quantity <= $product->min_level) {

                if (!Alert::where('product_id', $product->id)->exists()) {
                    Alert::create(['product_id' => $product->id]);
                }
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

        return response()->json(['message' => 'Order created successfully', 'order' => OrderResource::make($order)]);
    }
}
