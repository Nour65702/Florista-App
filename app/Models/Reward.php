<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;


    const TYPE_BONUS = 'bonus';
    const TYPE_DEDUCTION = 'deduction';

    protected $fillable = [
        'employee_id',
        'amount',
        'reward_date',
        'status',
        'type',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->reward_date = now();
    //     });

    //     static::saved(function ($reward) {
    //         $salary = Salary::where('employee_id', $reward->employee_id)->first();
    //         if ($salary) {
    //             $salary->amount += $reward->amount;
    //             $salary->save();
    //         }
    //     });

    //     static::updated(function ($reward) {
    //         $salary = Salary::where('employee_id', $reward->employee_id)->first();
    //         if ($salary) {
    //             $salary->amount += $reward->amount;
    //             $salary->save();
    //         }
    //     });
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->reward_date = now();
        });

        static::saved(function ($reward) {
            $salary = Salary::where('employee_id', $reward->employee_id)->first();
            if ($salary) {
                $salary->updateTotalAmount();
            }
        });

        static::deleted(function ($reward) {
            $salary = Salary::where('employee_id', $reward->employee_id)->first();
            if ($salary) {
                $salary->updateTotalAmount();
            }
        });
    }

    private static function updateSalaryPayDate($salary)
    {
        $rewardPaid = $salary->rewards()->where('status', 'paid')->exists();
        $salaryRequestPaid = $salary->salaryRequest()->where('status', 'paid')->exists();

        if ($rewardPaid && $salaryRequestPaid) {
            $salary->update(['pay_date' => now()]);
        }
    }

}
