<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
        'parent_id'
    ];


    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children.collections.products');
    }
}
