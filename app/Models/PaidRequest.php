<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidRequest extends Model
{
    use HasFactory;


    protected $fillable = [
        'salary_request_id',
    ];

    public function salaryRequest()
    {
        return $this->belongsTo(SalaryRequest::class);
    }
}
