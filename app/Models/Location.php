<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'locations';

    // Define the fillable attributes
    protected $fillable = [
        'name',
        'district',
        'province',
        'latitude',
        'longitude',
        'status',
    ];

    // Define the casts for specific attributes
    protected $casts = [
        'latitude' => 'decimal:6', // Adjust the scale (6 decimal places) as needed
        'longitude' => 'decimal:6', // Adjust the scale (6 decimal places) as needed
    ];

    // Define the default values for attributes
    protected $attributes = [
        'status' => 'active',
    ];

    // Relationship: A location can be the origin of many routes
    public function originRoutes()
    {
        return $this->hasMany(Route::class, 'origin_id');
    }

    // Relationship: A location can be the destination of many routes
    public function destinationRoutes()
    {
        return $this->hasMany(Route::class, 'destination_id');
    }
}