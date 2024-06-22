<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JobLevel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function workInfos()
    {
        return $this->hasMany(WorkInfo::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
