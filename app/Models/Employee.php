<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'date_of_joining',
        'gender',
        'provider_id',
        'user_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function address()
    {
        return $this->hasOne(EmployeeAddress::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function performanceReviews()
    {
        return $this->hasMany(PerformanceReview::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
