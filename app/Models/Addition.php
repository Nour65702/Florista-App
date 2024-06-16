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
        'price'
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'addition_products');
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
}
