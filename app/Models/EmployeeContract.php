<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'contract_id',
        'start_date',
        'end_date'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
