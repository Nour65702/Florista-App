<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'employee_id',
        'type_id',
        'from_date',
        'to_date',
        'reason',
        'status',
       
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
        return $this->belongsTo(LeaveType::class,'type_id');
    }
}
