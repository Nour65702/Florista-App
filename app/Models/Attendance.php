<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
    ];

    protected $appends = ['duration'];

    public function getDurationAttribute()
    {
        if ($this->check_in && $this->check_out) {
            $checkIn = Carbon::parse($this->check_in);
            $checkOut = Carbon::parse($this->check_out);

            return $checkOut->diffForHumans($checkIn, true); 
        }

        return null;
    }

    public function checkInNow()
    {
        $this->update([
            'check_in' => now()->toTimeString(), 
        ]);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->date = now();
        });
    }
}
