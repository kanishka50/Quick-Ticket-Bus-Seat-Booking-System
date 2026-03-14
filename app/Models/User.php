<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'profile_image',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function provider()
{
    return $this->hasOne(Provider::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}

public function notifications()
{
    return $this->hasMany(Notification::class);
}

public function driver()
{
    return $this->hasOne(Driver::class);
}

}