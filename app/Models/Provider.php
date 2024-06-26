<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Provider as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Provider extends User implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;


    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
    ];



    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(WorkProvider::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'provider_id');
    }

    public function registerMediaCollections(): void
    {

        $this->addMediaCollection('profile_image')
            ->useDisk('public')
            ->singleFile();
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function licence()
    {
        return $this->hasOne(ProviderLicence::class);
    }
    public function getProfileImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('profile_image');
    }
}
