<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Admin'])->except(['roomsBookingToClint']);
    }

    public function roomsBookingToClint()
    {
        $bookings = Booking::with('user:id,name', 'room')->where('user_id', auth()->user()->id)->latest()->paginate(10);
        return view('bookings.client-booking',compact('bookings'));
    }

}
