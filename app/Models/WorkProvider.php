<?php

namespace App\Models;

use App\Contracts\Images;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class WorkProvider extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'provider_id',
        'description'

    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }
    public function getImagesAttribute()
    {
        return $this->getMedia('images')->map->getUrl();
    }
}
