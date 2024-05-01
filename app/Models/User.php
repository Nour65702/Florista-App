<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasMedia, HasName
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user-profile')->useDisk('user_profile');
        $this->addMediaCollection('user-image')->useDisk('user_image');
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function address()
    {
        return $this->hasOne(Address::class);
    }
    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('Admin');
    }
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }
    
}
