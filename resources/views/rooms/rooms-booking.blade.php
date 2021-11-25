@extends('layouts.app')

@section('content')

@section('style')

    <style type="text/css">
        .datepicker {
            font-size: 0.875em;
        }
        /* solution 2: the original datepicker use 20px so replace with the following:*/

        .datepicker td, .datepicker th {
            width: 1.5em;
            height: 1.5em;
        }
        .modal-dialog.modal-xl {
            /*height: 100% !important;*/
        }
    </style>

@endsection

@include('rooms.add-edit-modal')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Rooms</h2>
            </div>
            <div class="pull-right">
{{--                <a class="btn btn-success" href="{{ route('rooms.create') }}"> Create New Room</a>--}}
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
                <td><span class="@if($room->status == \App\Models\Room::AVAILABLE) badge badge-success @else badge badge-secondary @endif ">{{ $room->status }}</span></td>
                <td>{{ $room->lastBooking->end_date ?? '' }}</td>
                <td>
                    <button class="btn btn-success" onclick="viewRoomBooking({{$room->id}}, {{auth()->user()->id}})">Booking</button>
                </td>
            </tr>
        @endforeach
    </table>


    {!! $rooms->links() !!}

@endsection

@section('script')

    <script>
        var ustartDate = '';
        var uendDate = '';

        //Updated At
        $('#lead_updated_date').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: '{{ trans("Clear") }}'
            }
        }, function (start, end) {
            $('#lead_updated_date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            ustartDate = start.format('Y-MM-DD');
            uendDate = end.format('Y-MM-DD');
        });
        $('#lead_updated_date').on('cancel.daterangepicker', function(ev, picker) {
            ustartDate = '';
            uendDate = '';
            $('#lead_updated_date').val('');
        });
        $('#lead_updated_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        function viewRoomBooking(room_id) {
            var url = '/api/:id/dynamic-modal';
            url = url.replace(':id',room_id);
            $("#dynamicModal").find(".modal-content").load(url);
            $("#dynamicModal").modal();
        }
    </script>
@endsection
