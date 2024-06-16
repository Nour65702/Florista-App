<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCustomBouquetProducts extends Model
{
    use HasFactory;

    protected $fillable = ['user_custom_bouquet_id', 'product_id', 'quantity'];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bouquet()
    {
        return $this->belongsTo(UserCustomBouquets::class, 'user_custom_bouquet_id');
    }

    public function additions()
    {
        return $this->hasMany(UserCustomBouquetProductAddition::class, 'bouquet_product_id');
    }
}
