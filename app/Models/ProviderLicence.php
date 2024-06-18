<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderLicence extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'is_active'
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
