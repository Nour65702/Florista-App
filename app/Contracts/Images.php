<?php

namespace App\Contracts;

use App\Models\Image;
use Illuminate\Support\Facades\URL;

trait Images
{
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function storeImage($imageName, $path)
    {
        $image = $this->image()->create(['image_name' => $imageName, 'path' => $path]);
        return $image;
    }

    public function updateImage($path)
    {
        if ($this->image) {
            $this->image->delete();
        }
    }
    public function deleteImage($imageName, $path)
    {
        if ($this->image) {
            $this->image->delete();
        }
        $this->storeImage($imageName, $path);
    }
    public function getImageUrlAttribute()
    {
        $image = $this->image;
        if (!$image) {
            return null;
        }
        if ($image->path) {
            return URL::to('/storage/' . $image->path);
        }

        return null;
    }
}
