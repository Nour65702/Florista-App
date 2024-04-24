<?php

namespace App\Models;

use App\Contracts\Images;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkProvider extends Model
{
    use HasFactory;
    use Images;
    protected $fillable = [
        'provider_id',
        'description'

    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'id');
    }
}
