<?php

// app/Models/BusType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }
}
