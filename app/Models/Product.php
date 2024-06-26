<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
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
        'on_sale',
        'min_level',
        'triggered_at'
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
    public function alerts()
    {
        return $this->hasMany(Alert::class);
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
    public function getProfileImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('product_image');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->triggered_at = now();
        });
    }
   
}
