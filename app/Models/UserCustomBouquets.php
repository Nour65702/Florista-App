<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCustomBouquets extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'total_price', 'design_id', 'color_id'];

    public function products()
    {
        return $this->hasMany(UserCustomBouquetProducts::class, 'user_custom_bouquet_id');
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function additions()
    {
        return $this->belongsToMany(Addition::class, 'addition_user_custom_bouquet')->withPivot('quantity');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_user_custom_bouquets', 'user_custom_bouquet_id', 'cart_id');
    }

    public function userCustomBouquetAdditions()
    {
        return $this->hasMany(UserCustomBouquetProductAddition::class, 'bouquet_product_id');
    }
}
