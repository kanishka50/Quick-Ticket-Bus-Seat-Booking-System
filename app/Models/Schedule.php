<?php

// app/Models/Schedule.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id',
        'bus_id',
        'departure_time',
        'arrival_time',
        'price',
        'status',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function dates()
    {
        return $this->hasMany(ScheduleDate::class);
    }
    
public function scheduleDates()
{
    return $this->hasMany(ScheduleDate::class);
}
}