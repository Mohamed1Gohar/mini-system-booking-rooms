@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>My Bookings</h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Room Number</th>
            <th>Number Of Beds</th>
            <th>Price</th>
            <th>Start Date</th>
            <th>End Date</th>
        </tr>
        @foreach ($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->room->room_number }}</td>
                <td>{{ $booking->room->number_of_beds }}</td>
                <td>{{ $booking->price }}</td>
                <td>{{ $booking->start_date }}</td>
                <td>{{ $booking->end_date }}</td>
            </tr>
        @endforeach
    </table>

    {!! $bookings->links() !!}

@endsection
