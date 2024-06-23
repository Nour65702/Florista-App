<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Addition extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'name',
        'type_addition_id',
        'description',
        'price',
        'quantity'
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'addition_products');
    }
    public function productAdditions()
    {
        return $this->hasMany(AdditionProduct::class);
    }
    public function bouquetAdditions()
    {
        return $this->hasMany(UserCustomBouquetProductAddition::class);
    }

    public function typeAddition()
    {
        return $this->belongsTo(TypeAddition::class);
    }
    public function createManyImages($images)
    {
        foreach ($images as $image) {
            $this->images()->create(['image_name' => $image]);
        }
    }
    public function userCustomBouquet()
    {
        return $this->belongsTo(UserCustomBouquets::class);
    }
    public function userCustomBouquetProduct()
    {
        return $this->belongsTo(UserCustomBouquetProducts::class, 'bouquet_product_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('addition_image')->singleFile();
    }
    public function getProfileImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('addition_image');
    }
    public function userCustomBouquets()
    {
        return $this->belongsToMany(UserCustomBouquets::class, 'addition_user_custom_bouquet')->withPivot('quantity');
    }
}
