<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_id',
        'request_date',
        'status',
    ];

    public function salary()
    {
        return $this->belongsTo(Salary::class);
    }

    protected static function booted()
    {
        static::updated(function ($salaryRequest) {
            if ($salaryRequest->status === 'paid') {

                $salaryRequest->salary->update([
                    'pay_date' => $salaryRequest->updated_at,
                ]);
                self::updateSalaryPayDate($salaryRequest->salary);
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->request_date = now();
        });
    }
}
