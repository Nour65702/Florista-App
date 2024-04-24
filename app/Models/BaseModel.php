<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model
};

class BaseModel extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    // images attribute
    
}
