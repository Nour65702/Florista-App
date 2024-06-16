<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BouquetShapes extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function bouquets()
    {
        return $this->hasMany(UserCustomBouquets::class);
    }
}
