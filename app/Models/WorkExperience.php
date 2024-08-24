<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkExperience extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'from_date',
        'to_date',
        'company',
        'position'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function workInfo()
    {
        return $this->belongsTo(WorkInfo::class);
    }
}
