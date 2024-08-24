<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable =[
        'admin_panel_settings_id',
        'branch_name',
        'address',
        'phone_number',
        'email',
        'active'
    ];

    public function adminPanelSetting()
    {
        return $this->belongsTo(AdminPanelSetting::class);
    }
}
