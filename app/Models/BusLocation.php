<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusLocation extends Model
{
    protected $fillable = ['driver_id', 'schedule_date_id', 'latitude', 'longitude', 'location_name', 'speed', 'recorded_at'];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'speed' => 'decimal:1',
        'recorded_at' => 'datetime',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function scheduleDate()
    {
        return $this->belongsTo(ScheduleDate::class);
    }
}
