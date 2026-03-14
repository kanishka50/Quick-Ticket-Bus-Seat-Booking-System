<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['user_id', 'provider_id', 'license_number', 'phone', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function assignments()
    {
        return $this->hasMany(DriverAssignment::class);
    }

    public function busLocation()
    {
        return $this->hasOne(BusLocation::class);
    }
}
