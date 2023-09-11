$('#TBShowDataBooking').DataTable();

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
            });
        }
    })
});

// var calendarEl = document.getElementById('calendar');

// var calendar = new FullCalendar.Calendar(calendarEl, {
//     headerToolbar: {
//         left: 'prevYear,prev,next,nextYear today',
//         center: 'title',
//         right: 'dayGridMonth,dayGridWeek,dayGridDay'
//     },
//     navLinks: true, // can click day/week names to navigate views
//     editable: false,
//     locale: 'th',
//     dayMaxEvents: true, // allow "more" link when too many events
//     events: []
// });

// calendar.render();