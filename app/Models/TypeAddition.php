<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAddition extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function additions()
    {
        return $this->hasMany(Addition::class);
    }
}
