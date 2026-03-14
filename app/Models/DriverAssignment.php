<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverAssignment extends Model
{
    protected $fillable = ['driver_id', 'schedule_date_id', 'status'];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function scheduleDate()
    {
        return $this->belongsTo(ScheduleDate::class);
    }
}
