<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'pay_date',
        'amount',
    ];

    protected $appends = ['total_amount', 'total_bonus_amount', 'total_deduction_amount'];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function salaryRequest()
    {
        return $this->hasOne(SalaryRequest::class);
    }
    public function rewards()
    {
        return $this->hasMany(Reward::class, 'employee_id', 'employee_id');
    }

    public function bonuses()
    {
        return $this->rewards()->where('type', Reward::TYPE_BONUS);
    }

    public function deductions()
    {
        return $this->rewards()->where('type', Reward::TYPE_DEDUCTION);
    }

    public function getTotalAmountAttribute()
    {
        return $this->amount + $this->total_bonus_amount - $this->total_deduction_amount;
    }

    public function getTotalBonusAmountAttribute()
    {
        return $this->bonuses()->sum('amount');
    }

    public function getTotalDeductionAmountAttribute()
    {
        return $this->deductions()->sum('amount');
    }

    public function updateTotalAmount()
    {
        $this->amount = $this->getTotalAmountAttribute();
        $this->save();
    }

}
