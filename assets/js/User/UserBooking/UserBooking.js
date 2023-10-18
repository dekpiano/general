$('#TBShowDataBooking').DataTable({
    responsive: true
});

$(document).on('submit', '#FormAddBooking', function(e) {
    e.preventDefault();
    $.ajax({
        url: "../../Booking/DB/Insert",
        method: "POST",
        data: $(this).serialize(),
        beforeSend: function() {
            $('#BtnSubBooking').html('<div id="spinner" class="spinner-border spinner-border-sm text-white" role="status"></div> <span class="">กำลังบันทึก...</span>');
            $('#BtnSubBooking').addClass("disabled");
        },
        success: function(data) {
            console.log(data);
            if (data > 1) {
                Swal.fire({
                    title: 'แจ้งเตือน?',
                    text: "บันทึกการจองสำเร็จ!",
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'ตกลง!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../../Booking/View/" + data;
                    }
                })
            }
            $('#BtnSubBooking').removeClass("disabled");
            $('#spinner').remove();
            $('#BtnSubBooking').html("จอง");
        }
    });
});

$(document).on('click', '#BtnCancelBooking', function() {
    //alert($(this).attr('key-id'));
    Swal.fire({
        title: 'ต้องการยกเลิกการจองหรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง'
    }).then((result) => {
        if (result.isConfirmed) {

            $.post('../../Booking/DB/Cancel', { KeyID: $(this).attr('key-id') }, function(data) {
                console.log(data);
                // $('#TBShowDataBooking').DataTable().ajax.reload();
                location.reload(true);
            });
        }
    })
});


$(document).on('change', '#booking_timeStart', function() {
    $.post('../../Booking/DB/CheckDateBooking', {
        booking_dateStart: $('#booking_dateStart').val(),
        booking_timeStart: $('#booking_timeStart').val()
    }, function(data) {
        console.log(data);
        if (data > 0) {
            Swal.fire(
                'กรุณาเลือกใหม่',
                'ช่วงวัน หรือ เวลา มีผู้จองแล้ว!',
                'warning'
            )
            $('#booking_timeStart').val('');
        }

    });
});

$(document).on('change', '#booking_timeEnd', function() {
    $.post('../../Booking/DB/CheckTimeBooking', {
        booking_dateEnd: $('#booking_dateEnd').val(),
        booking_timeEnd: $('#booking_timeEnd').val()
    }, function(data) {
        console.log(data);
        if (data > 0) {
            Swal.fire(
                'กรุณาเลือกใหม่',
                'ช่วงวัน หรือ เวลา มีผู้จองแล้ว!',
                'warning'
            )
            $('#booking_timeEnd').val('');
        }
    });
});



var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
    },
    navLinks: true, // can click day/week names to navigate views
    editable: false,
    locale: 'th',
    eventSources: [{
        events: function(fetchInfo, successCallback, failureCallback) {
            jQuery.ajax({
                url: "Booking/DB/ShowTimeBooking",
                type: "POST",
                success: function(res) {
                    var events = [];
                    res.forEach(evt => {
                        events.push({
                            id: evt.id,
                            title: evt.title,
                            start: evt.start,
                            end: evt.end,
                            allDay: true
                        });
                    });
                    successCallback(events);
                },
            });
        },
        eventColor: '#378006',


    }, ],
    initialView: 'dayGridMonth'
});
calendar.render();