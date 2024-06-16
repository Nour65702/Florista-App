<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemAddition extends Model
{
    use HasFactory;

    protected $fillable = ['cart_item_id', 'addition_id', 'quantity'];

    public function cartItem()
    {
        return $this->belongsTo(CartItem::class, 'cart_item_id');
    }

    public function addition()
    {
        return $this->belongsTo(Addition::class);
    }
}
