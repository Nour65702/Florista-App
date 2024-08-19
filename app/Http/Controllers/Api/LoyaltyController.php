<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyTransaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyController extends Controller
{
    // عرض نقاط الولاء للمستخدم الحالي
    public function index()
    {
        $loyaltyPoint = LoyaltyPoint::where('user_id', Auth::id())->first();
        return response()->json($loyaltyPoint);
    }

    // عرض سجل معاملات الولاء للمستخدم الحالي
    public function transactions()
    {
        $transactions = LoyaltyTransaction::where('user_id', Auth::id())->get();
        return response()->json($transactions);
    }

    // استبدال نقاط الولاء
   
    // public function redeemPoints(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'points' => 'required|integer|min:1',
    //     ]);

    //     $loyaltyPoint = LoyaltyPoint::where('user_id', Auth::id())->first();

    //     if ($loyaltyPoint && $loyaltyPoint->points >= $validatedData['points']) {
    //         $loyaltyPoint->points -= $validatedData['points'];
    //         $loyaltyPoint->save();

    //         // افتراض 100 نقطة = خصم 1 دولار
    //         $discountAmount = $validatedData['points'] / 100;

    //         // يمكن إنشاء كود خصم أو تطبيق الخصم مباشرة على حساب المستخدمL
    //         LoyaltyTransaction::create([
    //             'user_id' => Auth::id(),
    //             'points' => $validatedData['points'],
    //             'type' => 'redemption',
    //             'description' => 'Points redeemed for a discount of $' . $discountAmount,
    //         ]);

    //         return response()->json(['message' => 'تم استبدال النقاط بنجاح', 'discount' => $discountAmount]);
    //     }

    //     return response()->json(['message' => 'نقاط غير كافية'], 400);
    // }

    // استبدال نقاط الولاء وتطبيق الخصم على طلب محدد
    public function redeemPoints(Request $request)
    {
        $validatedData = $request->validate([
            'points' => 'required|integer|min:1',
            'order_id' => 'required|exists:orders,id', // Validate order_id
        ]);

        $loyaltyPoint = LoyaltyPoint::where('user_id', Auth::id())->first();

        if ($loyaltyPoint && $loyaltyPoint->points >= $validatedData['points']) {
            $loyaltyPoint->points -= $validatedData['points'];
            $loyaltyPoint->save();

            // افتراض 100 نقطة = خصم 1 دولار
            $discountAmount = $validatedData['points'] / 100;

            // جلب الطلب المحدد
            $order = Order::where('id', $validatedData['order_id'])->where('user_id', Auth::id())->first();

            if ($order) {
                // تطبيق الخصم على السعر الإجمالي
                $order->total_price = max($order->total_price - $discountAmount, 0);
                $order->save();

                // تسجيل المعاملة
                LoyaltyTransaction::create([
                    'user_id' => Auth::id(),
                    'points' => $validatedData['points'],
                    'type' => 'redemption',
                    'description' => 'Points redeemed for a discount of $' . $discountAmount . ' on Order ID: ' . $order->id,
                ]);

                return response()->json(['message' => 'تم استبدال النقاط بنجاح', 'discount' => $discountAmount, 'new_total_price' => $order->total_price]);
            } else {
                return response()->json(['message' => 'الطلب غير موجود أو لا ينتمي لهذا المستخدم'], 404);
            }
        }

        return response()->json(['message' => 'نقاط غير كافية'], 400);
    }
}
