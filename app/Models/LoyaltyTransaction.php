<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'points', 'type', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
