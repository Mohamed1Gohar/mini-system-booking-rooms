@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Room</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('rooms.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Room Number:</strong>
                    <input type="text" name="room_number" class="form-control" placeholder="Room Number">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Number Of Beds:</strong>
                    <input type="text" name="number_of_beds" class="form-control" placeholder="Number Of Beds">
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price:</strong>
                    <input type="number" name="price" class="form-control" placeholder="Price">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Custom Price:</strong>
                    <input type="number" name="custom_price" class="form-control" placeholder="Custom Price">
                </div>
            </div>

{{--            <div class="col-xs-12 col-sm-12 col-md-12">--}}
{{--                <div class="form-group">--}}
{{--                    <strong>Booking Expiry Date:</strong>--}}
{{--                    <input type="date" name="booking_expiry_date" class="form-control" placeholder="Booking Expiry Date">--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
@endsection
