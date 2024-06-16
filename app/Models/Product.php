<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia ;
    protected $fillable = [
        'collection_id',
        'name',
        'price',
        'description',
        'quantity',
        'size',
        'rate',
        'is_active',
        'in_stock',
        'on_sale'
    ];


    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
   
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    protected $casts = [
        'size' => 'array',
    ];

    public function additions()
    {
        return $this->belongsToMany(Addition::class, 'addition_products');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_image')->useDisk('public');

    }
}
