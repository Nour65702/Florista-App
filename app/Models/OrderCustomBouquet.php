<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCustomBouquet extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_custom_bouquet_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function userCustomBouquet()
    {
        return $this->belongsTo(UserCustomBouquets::class);
    }
}
