<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'provider_id',
        'department_id',
        'country_id',
        'city',
        'business_email',
        'business_number'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
