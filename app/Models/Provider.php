<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'company_logo',
        'business_registration_number',
        'contact_number',
        'address',
        'description',
        'status',
        'reason',
    ];

    /**
     * Get the user that owns the provider profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the buses for the provider.
     */
    public function buses()
    {
        return $this->hasMany(Bus::class);
    }

    public function schedules()
{
    return $this->hasManyThrough(Schedule::class, Bus::class);
}
}