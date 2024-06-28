<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'department_id',
        'job_level_id',
        'job_type_id',
        'country_id',
        'city',
        'business_email',
        'business_number'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function jobLevel()
    {
        return $this->belongsTo(JobLevel::class);
    }
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function experiences()
    {
        return $this->hasMany(WorkExperience::class);
    }
   
}
