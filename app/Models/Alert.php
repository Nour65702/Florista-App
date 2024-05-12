<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'min_level',
        'triggered_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
