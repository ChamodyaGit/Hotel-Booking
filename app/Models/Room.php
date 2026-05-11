<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'room_number',
        'room_type',
        'floor',
        'capacity',
        'price_per_night',
        'status',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
