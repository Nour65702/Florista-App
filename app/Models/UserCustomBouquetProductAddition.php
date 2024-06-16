<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCustomBouquetProductAddition extends Model
{
    use HasFactory;

    protected $fillable = ['bouquet_product_id', 'addition_id', 'quantity'];

    public function bouquetProduct()
    {
        return $this->belongsTo(UserCustomBouquetProducts::class, 'bouquet_product_id');
    }

    public function addition()
    {
        return $this->belongsTo(Addition::class, 'type_addition_id', 'id');
    }
}
