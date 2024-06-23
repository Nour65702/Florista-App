<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Addresses\AddressResource;
use App\Http\Resources\Order\OrderResource;
use App\Models\Addition;
use App\Models\Address;
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
        // Validate request data
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_method' => 'nullable|string',
            'delivery_to' => 'nullable|string',
            'shipping_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Fetch the user's cart items
        $cart = Cart::where('user_id', $request->user_id)->first();
        if (!$cart) {
            return response()->json(['message' => 'No cart found for the user'], 404);
        }

        $cartItems = $cart->items;

        // Calculate total price
        $totalPrice = 0;

        // Calculate total price for cart items
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $totalPrice += $product->price * $cartItem->quantity;
        }

        // Add price for custom bouquet if provided
        if ($request->filled('custom_bouquet_id')) {
            $bouquet = UserCustomBouquets::findOrFail($request->custom_bouquet_id);
            $totalPrice += $bouquet->total_price;
        }

        // Create the order
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

        // Attach order items from the cart
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

        // Attach order custom bouquet if provided
        if ($request->filled('custom_bouquet_id')) {
            OrderCustomBouquet::create([
                'order_id' => $order->id,
                'user_custom_bouquet_id' => $request->custom_bouquet_id,
            ]);
        }
        // $order = Order::with('orderItems', 'orderCustomBouquets')->find($order->id);
        return response()->json(['message' => 'Order created successfully', 'order' => OrderResource::make($order)]);
    }

    //     public function createOrder(Request $request)
    //     {
    //         // Validate request data
    //         $request->validate([
    //             'user_id' => 'required|exists:users,id',
    //             'payment_method' => 'nullable|string',
    //             'delivery_to' => 'required|array',
    //             'delivery_to.*.city' => 'required|string',
    //             'delivery_to.*.country_id' => 'required|exists:countries,id',
    //             'delivery_to.*.line_one' => 'required|string',
    //             'delivery_to.*.line_two' => 'nullable|string',
    //             'delivery_to.*.street' => 'nullable|string',
    //             'shipping_method' => 'nullable|string',
    //             'notes' => 'nullable|string',
    //         ]);

    //         // Fetch the user's cart items
    //         $cart = Cart::where('user_id', $request->user_id)->first();
    //         if (!$cart) {
    //             return response()->json(['message' => 'No cart found for the user'], 404);
    //         }

    //         $cartItems = $cart->items;

    //         // Calculate total price
    //         $totalPrice = 0;

    //         // Calculate total price for cart items
    //         foreach ($cartItems as $cartItem) {
    //             $product = $cartItem->product;
    //             $totalPrice += $product->price * $cartItem->quantity;
    //         }

    //         // Add price for custom bouquet if provided
    //         if ($request->filled('custom_bouquet_id')) {
    //             $bouquet = UserCustomBouquets::findOrFail($request->custom_bouquet_id);
    //             $totalPrice += $bouquet->total_price;
    //         }

    //         // Create the order
    //         $orderData = [
    //             'user_id' => $request->user_id,
    //             'total_price' => $totalPrice,
    //             'payment_method' => $request->input('payment_method', null),
    //             'payment_status' => $request->input('payment_status', 'pending'),
    //             'shipping_method' => $request->input('shipping_method', null),
    //             'notes' => $request->input('notes', null),
    //         ];

    //         $order = Order::create($orderData);

    //         // Attach order items from the cart
    //         foreach ($cartItems as $cartItem) {
    //             $product = $cartItem->product;
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $product->id,
    //                 'unit_amount' => $product->price,
    //                 'total_amount' => $product->price * $cartItem->quantity,
    //                 'quantity' => $cartItem->quantity,
    //             ]);
    //         }

    //         // Attach order custom bouquet if provided
    //         if ($request->filled('custom_bouquet_id')) {
    //             OrderCustomBouquet::create([
    //                 'order_id' => $order->id,
    //                 'user_custom_bouquet_id' => $request->custom_bouquet_id,
    //             ]);
    //         }

    //         // Create and attach multiple addresses to the order
    //         $addresses = $request->input('delivery_to');
    //         $addressModels = [];
    //         foreach ($addresses as $addressData) {
    //             $addressData['user_id'] = $request->user_id;
    //             $addressData['order_id'] = $order->id;
    //             $addressModel = Address::create($addressData);
    //             $addressModels[] = $addressModel;
    //         }
    //         return response()->json(['message' => 'Order created successfully', 'order' => $order,'delivery_to' => AddressResource::collection($addressModels)]);
    //     }

}
