<?php
// app/Models/Booking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'schedule_date_id',
        'total_passengers',
        'total_amount',
        'payment_status',
        'booking_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scheduleDate()
    {
        return $this->belongsTo(ScheduleDate::class);
    }

    public function seatBookings()
    {
        return $this->hasMany(SeatBooking::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}