<?php

namespace App\Http\Controllers;

use App\Area;
use App\Government;
use App\Lead;
use App\Models\Booking;
use App\Models\Room;
use App\PaymentMethod;
use App\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller {

    public function __construct()
    {
        $this->middleware(['role:Admin'])->except(['roomsBooking', 'dynamicModal', 'roomBookingAction']);
    }

    protected $room;
    protected $discount;
    protected $count_days;


    public function index()
    {
        $rooms = Room::latest()->paginate(5);
        return view('rooms.index',compact('rooms'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function roomsBooking()
    {

        $rooms = Room::with('lastBooking')->latest()->paginate(5);
        return view('rooms.rooms-booking',compact('rooms'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function roomBookingAction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        if (!$validator->passes()) {
            return response()->json(['error'=>$validator->errors()]);
        }

        $this->room = Room::find(request()->room_id);

        $this->calcCountDays();

        $this->calcDiscount();

        $this->storeBooking();

        $this->changeStatusRoom();

        return response()->json(['success'=>'Added new Booking.']);
    }

    public function changeStatusRoom()
    {
      $this->room->status = Room::BOOKED;
      $this->room->booking_expiry_date = now();
      $this->room->save();
    }

    public function storeBooking()
    {

        $tottal_price = $this->room->price * $this->count_days;

        $price_after_discount = $tottal_price - ($tottal_price * ($this->discount / 100));

        return Booking::create([
            'user_id' => auth()->user()->id,
            'room_id' => request()->room_id,
            'start_date' => request()->start_date,
            'end_date' => request()->end_date,
            'price' => $price_after_discount,
        ]);
    }

    public function calcCountDays()
    {
        $start_date =  Carbon::parse(request()->start_date);
        $end_date =  Carbon::parse(request()->end_date);
        $this->count_days = $start_date->diffInDays($end_date);
    }

    public function calcDiscount()
    {
        // discount is 50% if days more than or equal 5 days
        $this->discount = $this->count_days >= 5 ? 50 : 0;
    }
    public function create()
    {
        return view('rooms.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|numeric|gt:0|unique:rooms',
            'number_of_beds' => 'required|numeric|gt:0',
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')
            ->with('success','Room created successfully.');
    }


    public function show(Room $room)
    {
        return view('rooms.show',compact('room'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit',compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|numeric|gt:0|unique:rooms,room_number,'.$room->id,
            'number_of_beds' => 'required|numeric|gt:0',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')
            ->with('success','Room updated successfully');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success','Room deleted successfully');
    }

    public function dynamicModal($id)
    {
        $room = Room::with('bookings')->where('id', $id)->first();
        $dates_booked = [];
        foreach ($room->bookings as $item) {
            array_push($dates_booked, ['from' => $item->start_date, 'to' => $item->end_date]);
        }
        return view('rooms.modal', compact('room', 'dates_booked'));
    }

    function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        $array = [];
        $interval = new \DateInterval('P1D');

        $realEnd = new \DateTime($end);
        $realEnd->add($interval);

        $period = new \DatePeriod(new \DateTime($start), $interval, $realEnd);

        foreach($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }

}
