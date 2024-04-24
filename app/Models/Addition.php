<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Addition extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type_addition_id',
        'order_id'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function typeAddition()
    {
        return $this->belongsTo(TypeAddition::class);
    }
    public function createManyImages($images)
    {
        foreach ($images as $image) {
            $this->images()->create(['image_name' => $image]);
        }
    }
}
