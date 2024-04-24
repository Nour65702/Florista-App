<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BouquetProduct extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'bouquet_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bouquet()
    {
        return $this->belongsTo(Bouquet::class);
    }
}
