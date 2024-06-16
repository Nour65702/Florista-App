<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function customBouquets()
    {
        return $this->belongsToMany(UserCustomBouquets::class, 'cart_user_custom_bouquets', 'cart_id', 'user_custom_bouquet_id');
    }
}
