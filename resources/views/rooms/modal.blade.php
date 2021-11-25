<!-- Modal -->
<div class="modal-header">
    <h5 class="modal-title" id="staticBackdropLabel">Booking Room: {{ $room->room_number }}</h5>

    <button type="button" id="roomModalClose-{{$room->id}}" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

</div>


<div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
</div>

<div id="alert-error" class="d-none">
</div>

<form name="ajax-contact-form" id="ajax-contact-form" method="post" action="javascript:void(0)">
    @csrf
    <div class="modal-body" style="height: 200px">

        <div class="row">

            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <div class="col-md-3">
                <label for="booking_date-{{$room->id}}">Select Date</label>
                <div class="input-group date datepicker mb-2 mb-md-0 d-md-none d-xl-flex" id="">
                    <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
                    <input type="date" name="booking_date" class="form-control" id="booking_date-{{$room->id}}" placeholder="Select Date" autocomplete="off" required>
                </div>
            </div>

            <div class="col-md-3">
                <label for="total_price-{{$room->id}}">Tottal Price</label>
                <div class="input-group date datepicker mb-2 mb-md-0 d-md-none d-xl-flex" id="">
                    <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
                    <input type="number" name="total_price" class="form-control" id="total_price-{{$room->id}}" placeholder="0" disabled>
                </div>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
    </div>
</form>

<script>
    var bStartDate = '';
    var bEndDate = '';
    var bookingDate = $('#booking_date-{{ $room->id }}');

    flatpickr(bookingDate, {
        mode: "range",
        minDate: "today",
        dateFormat: "Y-m-d",
        disable: @json($dates_booked),
        onChange: function(dates, dateString) {
            if (dates.length == 2) {
                var date = dateString.split(" to ");
                bStartDate = date[0];
                bEndDate = date[1];
            }
        },
        onClose: function(dates, dateString){
            var date = dateString.split(" to ");
            if (dates.length == 2) {

                var countDays = getDates(new Date(date[0]), new Date(date[1])),
                    price = parseInt( {{ $room->price }});

                countDays = countDays.length;
                var discount = countDays >= 5 ? 50 : 0;

                var tottal_price = price * countDays;
                var price_after_discount = tottal_price - (tottal_price * (discount / 100));

                $('#total_price-{{$room->id}}').val(price_after_discount);
            }
        }
    });

    $("#submit").click(function(e) {
        e.preventDefault();

        var _token = $("input[name='_token']").val();
        var room_id = $("input[name='room_id']").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#submit').html('Please Wait...');
        $("#submit"). attr("disabled", true);
        $.ajax({
            url: "{{ route('rooms.room-booking-action')  }}",
            type: "POST",
            data: {
                _token:_token,
                start_date:bStartDate,
                end_date:bEndDate,
                room_id:room_id,
            },
            success: function( response ) {
                $('#submit').html('Submit');
                $("#submit"). attr("disabled", false);

                if($.isEmptyObject(response.error)){
                    $('#alert-error').addClass('d-none');
                    $('#successMsg').text(response.success).show();
                    document.getElementById("ajax-contact-form").reset();
                    setTimeout(function(){
                        {{--$('#roomModalClose-{{$room->id}}').click();--}}
                        location.reload();
                    }, 1500);


                } else {
                    printErrorMsg(response.error);
                }
            },
            error: function(response) {
                console.log(response.responseJSON);
            },
        });

    });


    function printErrorMsg (msg) {
        $('#successMsg').hide();
        $('#alert-error').removeClass('d-none');
        var dataErrors = '';
        $.each( msg, function( key, value ) {
            console.log(key);
            dataErrors = dataErrors + `
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <span>${value}</span>
                </div>
            `;
        });

        $('#alert-error').html(dataErrors);
    }

    // Returns an array of dates between the two dates
    function getDates (startDate, endDate) {
        const dataDates = []
        let currentDate = startDate
        const addDays = function (days) {
            const date = new Date(this.valueOf())
            date.setDate(date.getDate() + days)
            return date
        }
        while (currentDate <= endDate) {
            dataDates.push(currentDate)
            currentDate = addDays.call(currentDate, 1)
        }
        return dataDates
    }
</script>