@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Rooms</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('rooms.create') }}"> Create New Room</a>
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
            <th>Status</th>
            <th>Booking Expiry Date</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($rooms as $room)
            <tr>
                <td>{{ $room->id }}</td>
                <td>{{ $room->room_number }}</td>
                <td>{{ $room->number_of_beds }}</td>
                <td>{{ $room->price }}</td>
                <td><span class="@if($room->status == \App\Models\Room::AVAILABLE) badge badge-success @else badge badge-warning @endif ">{{ $room->status }}</span></td>
                <td>{{ $room->booking_expiry_date }}</td>
                <td>
                    <form action="{{ route('rooms.destroy',$room->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('rooms.show',$room->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('rooms.edit',$room->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $rooms->links() !!}

@endsection
