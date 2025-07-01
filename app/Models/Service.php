<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
    'name',
    'description',
    'price',
    'duration_minutes',
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
