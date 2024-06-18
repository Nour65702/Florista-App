<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'provider_id',
        'city',
        'country_id',
        'line_one',
        'line_two',
        'street'
    ];
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}
