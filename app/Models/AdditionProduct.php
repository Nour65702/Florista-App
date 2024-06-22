<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionProduct extends Model
{
    use HasFactory;

    protected $table = 'addition_products';

    protected $fillable = ['product_id', 'addition_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function addition()
    {
        return $this->belongsTo(Addition::class);
    }
}
