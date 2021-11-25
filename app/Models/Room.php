<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public const AVAILABLE = 'available';
    public const BOOKED = 'booked';

    public function lastBooking()
    {
        return $this->hasOne(Booking::class)->whereDate('end_date', '>=', now())->orderBy('created_at', 'desc');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class)->whereDate('end_date', '>=', now());
    }

    public function dates()
    {
        return $this->hasMany(Booking::class);
    }
}
