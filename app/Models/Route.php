<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $table = 'routes';

    protected $fillable = [
        'origin_id',
        'destination_id',
        'distance',
        'estimated_duration',
        'status',
    ];

    protected $casts = [
        'distance' => 'decimal:2', // Corrected cast
        'estimated_duration' => 'integer',
    ];

    protected $attributes = [
        'status' => 'active',
    ];

    public function origin()
    {
        return $this->belongsTo(Location::class, 'origin_id');
    }

    public function destination()
    {
        return $this->belongsTo(Location::class, 'destination_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}