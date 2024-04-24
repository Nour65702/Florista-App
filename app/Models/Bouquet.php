<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bouquet extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bouquet_products')->withPivot('quantity');
    }
}
