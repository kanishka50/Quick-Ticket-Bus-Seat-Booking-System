<?php

// app/Models/Bus.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'bus_type_id',
        'registration_number',
        'name',
        'total_seats',
        'seat_layout',
        'amenities',
        'status',
    ];

    protected $casts = [
        'seat_layout' => 'json',
        'amenities' => 'json',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function busType()
    {
        return $this->belongsTo(BusType::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
