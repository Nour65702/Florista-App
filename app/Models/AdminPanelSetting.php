<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AdminPanelSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_name',
        'active',
        'general_alert',
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
