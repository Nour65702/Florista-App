<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'order_id',
        'unit_amount',
        'total_amount',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function additions()
    {
        return $this->belongsToMany(Addition::class, 'order_item_addition')
                    ->withPivot('quantity');
    }
}
