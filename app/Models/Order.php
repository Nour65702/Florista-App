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
}
