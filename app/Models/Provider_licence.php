<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider_licence extends Model
{
    use HasFactory;


    protected $table = 'provider_licences';

    protected $fillable = [
        'name',
        'phone',
        'email',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'email_verified_at',

    ];
}
