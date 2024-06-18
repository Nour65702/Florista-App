<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'type_id',
        'from_date',
        'to_date',
        'reason',
        'status',
        'provider_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
