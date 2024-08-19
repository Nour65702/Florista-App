<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'delivery_to',
        'payment_method',
        'payment_status',
        'shipping_method',
        'notes'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function orderCustomBouquets()
    {
        return $this->hasMany(OrderCustomBouquet::class);
    }

    // طريقة جديدة لإضافة نقاط الولاء
    protected static function booted()
    {
        static::created(function ($order) {
            $order->addLoyaltyPoints();
        });
    }

    public function addLoyaltyPoints()
    {
        // حساب النقاط بناءً على السعر الإجمالي
        $points = $this->calculatePoints($this->total_price);

        if ($points > 0) {
            $loyaltyPoint = LoyaltyPoint::firstOrCreate(['user_id' => $this->user_id]);
            $loyaltyPoint->points += $points;
            $loyaltyPoint->save();

            LoyaltyTransaction::create([
                'user_id' => $this->user_id,
                'points' => $points,
                'type' => 'earning',
                'description' => 'Points earned from Order ID: ' . $this->id,
            ]);
        }
    }

    protected function calculatePoints($amount)
    {
        // 1 نقطة لكل 10 وحدات نقدية
        $points = floor($amount / 10);
        return $points;
    }
}
