<?php
// app/Models/SeatBooking.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'seat_number',
        'ticket_number',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}