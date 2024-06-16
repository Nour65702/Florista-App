<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Design extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'description'];

    public function bouquets()
    {
        return $this->hasMany(UserCustomBouquets::class);
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('design_image')->singleFile();
    }
}
