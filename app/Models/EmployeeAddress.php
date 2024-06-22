<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeAddress extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'employee_id',
        'city',
        'country_id',
        'line_one',
        'line_two',
        'street'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
