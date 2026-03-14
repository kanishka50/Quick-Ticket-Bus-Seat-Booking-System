<?php
// app/Models/ScheduleDate.php - Add to existing model
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'departure_date',
        'available_seats',
        'status',
        'actual_departure_time',
        'actual_arrival_time',
        'delay_reason',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'actual_departure_time' => 'datetime',
        'actual_arrival_time' => 'datetime',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function driverAssignment()
    {
        return $this->hasOne(DriverAssignment::class);
    }

    public function busLocation()
    {
        return $this->hasOne(BusLocation::class);
    }
}