document.querySelectorAll('.CheckUserLogin').forEach(btn => {
    btn.onclick = e => {
        e.preventDefault();
        Swal.fire({
            title: 'เข้าสู่ระบบก่อนจอง?',
            html: "คุณต้องเป็นบุคลากรเท่านั้นที่มี มีอีเมล @skj.ac.th <br> ถ้าไม่ใช่บุคลากรให้ติดต่อเจ้าหน้าที่ฝ่ายอาคารสถานที่",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then(r => {
            if (r.isConfirmed) location.href = btn.dataset.url;
        });
    };
});

$('#TBShowDataBooking').DataTable({
    responsive: true,
    order: [
        [1, 'desc']
    ],
});
// Custom Search for Booking Admin
$(document).on("keyup", "#tableSearch", function () {
    $("#TBShowDataBookingAdmin").DataTable().search($(this).val()).draw();
});

$('#TBShowDataBookingAdmin').DataTable({
    responsive: true,
    serverMethod: "post",
    ajax: {
        url: BASE_URL + "Booking/DB/DataTable/Approve/Admin",
    },
    dom: '<"top"rt><"bottom"ip><"clear">',
    order: [[0, "desc"]],
    columns: [
        {
            data: null,
            className: "align-middle text-nowrap",
            render: function (data, type, row) {
                return `
                    <div class="d-flex flex-column gap-0">
                        <div class="d-flex align-items-center mb-1">
                            <div class="bg-label-secondary p-1 rounded-circle me-1" style="width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                                <i class='bx bx-hash' style="font-size: 0.75rem;"></i>
                            </div>
                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">${row.booking_order}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-label-primary p-1 rounded-circle me-1" style="width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                                <i class='bx bx-user' style="font-size: 0.75rem;"></i>
                            </div>
                            <span class="text-body fw-medium small">${row.booker}</span>
                        </div>
                    </div>
                `;
            }
        },
        {
            data: null,
            className: "align-middle",
            render: function (data, type, row) {
                return `
                    <div class="d-flex flex-column gap-1">
                        <div class="fw-bold text-dark" style="font-size: 0.95rem; line-height: 1.2;">${row.booking_title}</div>
                        <div class="d-flex align-items-center gap-2">
                             <div class="text-muted small"><i class='bx bx-phone me-1'></i>${row.booking_telephone}</div>
                             ${row.booking_imgWork ? `<a href="${BASE_URL}uploads/User/Booking/${row.booking_imgWork}" class="open-popup text-info small" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class='bx bx-paperclip me-1'></i>ผังงาน
                             </a>` : ''}
                        </div>
                    </div>
                `;
            }
        },
        {
            data: null,
            className: "align-middle",
            render: function (data, type, row) {
                return `
                    <div class="d-flex flex-column gap-1 py-1">
                        <div class="d-flex align-items-center text-nowrap">
                            <i class='bx bxs-map text-danger me-1' style="font-size: 1rem;"></i>
                            <span class="text-dark fw-bold" style="font-size: 0.9rem;">${row.location_name}</span>
                        </div>
                        <div class="d-flex align-items-center text-muted small" style="font-size: 0.75rem;">
                            <i class='bx bx-calendar me-1'></i>
                            <span>${row.booking_dateStart} - ${row.booking_dateEnd}</span>
                        </div>
                    </div>
                `;
            }
        },
        {
            data: "booking_admin_approve",
            className: "align-middle",
            render: function (data, type, row) {
                if (data === "อนุมัต" || data === "อนุมัติ") {
                    return `<span class="status-pill approved text-nowrap"><i class="bx bxs-check-circle"></i> อนุมัติแล้ว</span>`;
                } else if (data === "ไม่อนุมัติ") {
                    return `<span class="status-pill rejected text-nowrap"><i class="bx bx-x-circle"></i> ไม่อนุมัติ</span>`;
                } else {
                    return `<span class="status-pill pending text-nowrap"><i class="bx bx-time-five"></i> รอตรวจสอบ</span>`;
                }
            }
        },
        {
            data: "booking_admin_reason",
            className: "align-middle",
            render: function (data, type, row) {
                return data ? `<span class="small text-muted text-truncate" style="max-width: 150px; display: block;">${data}</span>` : "-";
            }
        },
        {
            data: null,
            className: "align-middle text-end",
            render: function (data, type, row) {
                const isApproved = row.booking_admin_approve === "อนุมัต" || row.booking_admin_approve === "อนุมัติ";
                const isRejected = row.booking_admin_approve === "ไม่อนุมัติ";
                const printUrl = `${BASE_URL}Booking/Approve/File/Requestform/${row.booking_id}`;

                if (isApproved) {
                    return `
                        <div class="d-flex align-items-center justify-content-end gap-1 text-nowrap">
                            <a href="${printUrl}" target="_blank" class="btn btn-sm btn-info rounded-pill px-2 py-1" title="พิมพ์เอกสาร">
                                <i class="bx bxs-printer"></i> พิมพ์
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" data-bs-toggle="modal" data-bs-target="#ModalSignatureAdmin" id="FormSignatureAdmin" data-idBooking="${row.booking_id}" title="ลายเซ็น">
                                <i class="bx bx-edit"></i>
                            </a>
                            <button type="button" class="btn btn-outline-warning btn-sm rounded-pill px-2 py-1 btn-cancel-approve-room" 
                                    booking-id="${row.booking_id}" title="ยกเลิกอนุมัติ">
                                <i class="bx bx-undo"></i> ย้อน
                            </button>
                        </div>`;
                } else if (isRejected) {
                    return `
                        <div class="d-flex align-items-center justify-content-end gap-1 text-nowrap">
                            <button type="button" class="btn btn-warning btn-sm rounded-pill px-2 py-1 btn-cancel-reject-room" 
                                    booking-id="${row.booking_id}">
                                <i class="bx bx-undo"></i> คืนสถานะ
                            </button>
                        </div>`;
                }

                return `
                    <div class="d-flex align-items-center justify-content-end gap-1 text-nowrap">
                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 py-1" id="BtnApproveBooking" booking-id="${row.booking_id}">
                            <i class="bx bx-check-shield"></i> อนุมัติ
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-1" id="BtnNoApproveBooking" booking-id="${row.booking_id}">
                            <i class="bx bx-x"></i> ไม่รับ
                        </button>
                    </div>`;
            }
        }
    ]
});

// Event Handlers for Room Booking Admin
$(document).on('click', '#BtnApproveBooking', function () {
    const $btn = $(this);
    const bookingId = $btn.attr('booking-id');
    const originalHtml = $btn.html();

    Swal.fire({
        title: 'ยืนยันการอนุมัติ?',
        text: "คุณต้องการอนุมัติการจองสถานที่นี้หรือไม่!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#696cff',
        confirmButtonText: 'ใช่, อนุมัติ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + 'Booking/DB/BookingApproveAdmin',
                method: 'POST',
                data: { BookingID: bookingId },
                beforeSend: function() {
                    $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>').addClass("disabled");
                },
                success: function(data) {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'ดำเนินการอนุมัติเรียบร้อยแล้ว',
                        icon: 'success'
                    }).then(() => {
                        $('#TBShowDataBookingAdmin').DataTable().ajax.reload(null, false);
                    });
                },
                error: function() {
                    Swal.fire("เกิดข้อผิดพลาด!", "ไม่สามารถดำเนินการได้", "error");
                },
                complete: function() {
                    $btn.html(originalHtml).removeClass("disabled");
                }
            });
        }
    });
});

$(document).on('click', '#BtnNoApproveBooking', function () {
    const $btn = $(this);
    const bookingId = $btn.attr('booking-id');
    const originalHtml = $btn.html();

    Swal.fire({
        title: 'ไม่อนุมัติการจอง',
        text: 'กรุณาระบุเหตุผลที่ไม่สามารถอนุญาตได้:',
        input: 'textarea',
        inputPlaceholder: 'ระบุเหตุผลที่นี่...',
        showCancelButton: true,
        confirmButtonColor: '#ff3e1d',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
        inputValidator: (value) => {
            if (!value) return 'กรุณาระบุเหตุผล!';
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + 'Booking/DB/BookingNoApproveAdmin',
                method: 'POST',
                data: { 
                    BookingID: bookingId,
                    booking_admin_reason: result.value
                },
                beforeSend: function() {
                    $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>').addClass("disabled");
                },
                success: function() {
                    Swal.fire('เรียบร้อย!', 'บันทึกสถานะไม่อนุมัติสำเร็จ', 'success').then(() => {
                        $('#TBShowDataBookingAdmin').DataTable().ajax.reload(null, false);
                    });
                },
                complete: function() {
                    $btn.html(originalHtml).removeClass("disabled");
                }
            });
        }
    });
});

$(document).on("click", ".btn-cancel-reject-room, .btn-cancel-approve-room", function () {
    const $btn = $(this);
    const originalHtml = $btn.html();
    const bookingId = $btn.attr("booking-id");
    const isCancelApprove = $btn.hasClass("btn-cancel-approve-room");

    Swal.fire({
        title: isCancelApprove ? 'ยกเลิกการอนุมัติ?' : 'คืนสถานะการจอง?',
        text: isCancelApprove ? "คุณต้องการยกเลิกการอนุมัติและเปลี่ยนสถานะกลับเป็น 'รอตรวจสอบ' ใช่หรือไม่?" : "ต้องการเปลี่ยนสถานะกลับเป็น 'รอตรวจสอบ' ใช่หรือไม่?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffab00',
        confirmButtonText: 'ใช่, เปลี่ยนสถานะ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + "Booking/DB/ResetAppoveBookingAdmin",
                method: "POST",
                data: { BookingID: bookingId },
                beforeSend: function() {
                    $btn.html('<span class="spinner-border spinner-border-sm"></span>').addClass("disabled");
                },
                success: function(data) {
                    if (parseInt(data) > 0) {
                        Swal.fire('สำเร็จ!', 'คืนสถานะเรียบร้อยแล้ว', 'success').then(() => {
                            $('#TBShowDataBookingAdmin').DataTable().ajax.reload(null, false);
                        });
                    }
                },
                complete: function() {
                    $btn.html(originalHtml).removeClass("disabled");
                }
            });
        }
    });
});




$(document).on('submit', '#FormAddBooking', function (e) {
    e.preventDefault();
    $.ajax({
        url: BASE_URL + "Booking/DB/Insert",
        method: "POST",
        data: $(this).serialize(),
        beforeSend: function () {
            $('#BtnSubBooking').html('<div id="spinner" class="spinner-border spinner-border-sm text-white" role="status"></div> <span class="">กำลังบันทึก...</span>');
            $('#BtnSubBooking').addClass("disabled");
        },
        success: function (data) {
            console.log(data);
            if (data > 0) {
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
        },error: function (xhr, status, error) {  
                console.log(xhr.responseText); // Log the error response for debugging                
            }
    });
});

$(document).on('submit', '#FormEditBooking', function (e) {
    e.preventDefault();
    $.ajax({
        url: BASE_URL + "Booking/DB/Update",
        method: "POST",
        data: $(this).serialize(),
        beforeSend: function () {
            $('#BtnSubBooking').html('<div id="spinner" class="spinner-border spinner-border-sm text-white" role="status"></div> <span class="">กำลังบันทึก...</span>');
            $('#BtnSubBooking').addClass("disabled");
        },
        success: function (data) {
            //console.log(data);
            if (data > 0) {
                Swal.fire({
                    title: 'แจ้งเตือน?',
                    text: "แก้ไขการจองสำเร็จ!",
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

$(document).on('click', '#BtnCancelBooking', function () {
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

            $.post(BASE_URL + 'Booking/DB/Cancel', { KeyID: $(this).attr('key-id') }, function (data) {
                console.log(data);
                // $('#TBShowDataBooking').DataTable().ajax.reload();
                location.reload(true);
            });
        }
    })
});

$('#BtnSubBooking').prop('disabled', true);
$(document).on('change', '#booking_dateStart, #booking_timeStart, #booking_dateEnd, #booking_timeEnd', function () {

    let requestData = {
        booking_locationroom: $('#booking_locationroom').val(),
        booking_dateStart: $('#booking_dateStart').val(),
        booking_timeStart: $('#booking_timeStart').val(),
        booking_dateEnd: $('#booking_dateEnd').val(),
        booking_timeEnd: $('#booking_timeEnd').val()
    };

    // Add booking_id if it exists (for edit mode)
    if ($('#booking_id').length) {
        requestData.exclude_booking_id = $('#booking_id').val();
    }

    $.post(BASE_URL + 'Booking/CheckDateBooking', requestData, function (data) {
       // console.log(data);
        $('#AlertMessage').html(data.message);
        $('#AlertMessage').removeClass().addClass(data.class);
        if (data.status == 1) {
            $('#BtnSubBooking').prop('disabled', false);
        } else {
            $('#BtnSubBooking').prop('disabled', true);
        }

    });
});


function formatThaiDate(date) {
    let thaiDate = new Intl.DateTimeFormat('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long'
    }).format(new Date(date));

    return thaiDate;
}


$(document).on('click', 'a.open-popup', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $('#modalBody').html('<div class="text-center py-3">กำลังโหลด...</div>');
    $('#myModal').modal('show');
    //$.get(url, function(data) {
        $('#modalBody').html('<img src="' + url + '" class="img-fluid" alt="Image">');
    //});
});

var calendarEl = document.getElementById('CalendarBooking');
if (calendarEl) {
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prevYear,prev,next,nextYear',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,dayGridDay'
        },
        navLinks: true, // can click day/week names to navigate views
        editable: false,
        locale: 'th',
        dayHeaderFormat: {
            weekday: 'long'
        },
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
                                allDay: true,
                                backgroundColor: evt.backgroundColor,
                                borderColor: evt.backgroundColor,
                                bookingApprove: evt.booking_admin_approve,
                                bookingAdminReason: evt.booking_admin_reason,
                            });
                        });
                        successCallback(events);

                    },
                });
            },
            eventColor: '#378006',


        }, ],
        initialView: 'dayGridMonth',
        eventClick: function(info) {
            if (info.event.extendedProps.bookingApprove == "อนุมัติ") {
                var Icon = "success";
            } else if (info.event.extendedProps.bookingApprove == "รอตรวจสอบ") {
                var Icon = "warning";
            } else if (info.event.extendedProps.bookingApprove == "ไม่อนุมัติ") {
                var Icon = "error";
            }
            Swal.fire({
                title: `สถานะ : ${info.event.extendedProps.bookingApprove}`,
                html: `<b>วันเข้าใช้บริการ</b> : ${formatThaiDate(info.event.start)} <br>
                       <b>เวลา:</b> ${info.event.title || "ไม่มีรายละเอียด"}<br>
                       <b>หมายเหตุ :</b> ${info.event.extendedProps.bookingAdminReason || "-"}<br>`,
                icon: Icon
            });


        }
    });
    calendar.render();
}

// --- Room Booking Dashboard Charts ---
function initBookingCharts() {
    const pieEl = document.querySelector("#pie-chart");
    const barEl = document.querySelector("#bar-chart");
    const approveEl = document.querySelector("#chart-Approve");

    // Don't run if elements don't exist
    if (!pieEl && !barEl && !approveEl) return;

    $.getJSON(BASE_URL + 'Booking/DB/BookingChart', function(data) {
        // 1. Pie Chart: Location Usage Proportion
        if (pieEl && data.pie && data.pie.series && data.pie.series.length > 0) {
            const pieOptions = {
                series: data.pie.series,
                chart: { type: 'donut', height: 250 },
                labels: data.pie.labels,
                colors: ['#696cff', '#03c3ec', '#71dd37', '#ffab00', '#ff3e1d', '#8592a3'],
                legend: { position: 'bottom', fontSize: '11px' },
                dataLabels: { enabled: false },
                plotOptions: { pie: { donut: { size: '70%', labels: { show: true, total: { show: true, label: 'ครั้ง', fontSize: '12px' } } } } }
            };
            new ApexCharts(pieEl, pieOptions).render();
        }

        // 2. Bar Chart: Top 5 Bookers
        if (barEl && data.bar && data.bar.series && data.bar.series.length > 0) {
            const barOptions = {
                series: [{ name: 'จำนวนครั้ง', data: data.bar.series }],
                chart: { type: 'bar', height: 250, toolbar: { show: false } },
                plotOptions: { bar: { borderRadius: 4, horizontal: true, columnWidth: '40%' } },
                dataLabels: { enabled: false },
                colors: ['#696cff'],
                xaxis: { categories: data.bar.categories, labels: { style: { fontSize: '10px' } } },
                grid: { borderColor: '#f1f1f1', padding: { top: -15, bottom: -10 } }
            };
            new ApexCharts(barEl, barOptions).render();
        }

        // 3. Simple Pie: Approval Status
        if (approveEl && data.Approve && data.Approve.series && data.Approve.series.length > 0) {
            const approveOptions = {
                series: data.Approve.series,
                chart: { type: 'pie', height: 250 },
                labels: data.Approve.labels,
                colors: ['#71dd37', '#ffab00', '#ff3e1d'],
                legend: { position: 'bottom', fontSize: '11px' },
                dataLabels: { enabled: true, style: { fontSize: '10px' } }
            };
            new ApexCharts(approveEl, approveOptions).render();
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log('Chart data load failed:', textStatus);
    });
}

// Check if we are on the Admin page to init charts
if ($('#pie-chart').length) {
    initBookingCharts();
}


