<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function employeeContracts()
    {
        return $this->hasMany(EmployeeContract::class);
    }
}
