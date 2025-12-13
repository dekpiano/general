$("#TBShowDataBooking").DataTable({
  responsive: true,
  order: [[0, "desc"]],
});
$("#TBShowDataCarBooking").DataTable({
  responsive: true,
  serverMethod: "post",
  ajax: {
    url: "../CarBooking/DB/DataTable/View",
  },
  order: [[1, "desc"]],
  columns: [
    {
      data: "car_reserv_status",
      render: function (data, type, row) {
        if (data == "อนุมัติ") {
          return (
            '<span class="badge rounded-pill bg-success">' + data + "</span>"
          );
        } else if (data == "ไม่อนุมัติ") {
          return (
            '<span class="badge rounded-pill bg-danger">' + data + "</span>"
          );
        } else {
          return (
            '<span class="badge rounded-pill bg-warning">' + data + "</span>"
          );
        }
      },
    },
    { data: "car_reserv_order" },
    {
      data: "car_reserv_carID",
      render: function (data, type, row) {
        return (
          '<img class="img-fluid" style="width:150px;" src="../uploads/admin/Car/' +
          row.car_img +
          '">'
        );
      },
    },
    {
      data: "car_reserv_carID",
      render: function (data, type, row) {
        return (
          row.car_category +
          "<br>" +
          row.car_registration +
          " " +
          row.car_province
        );
      },
    },
    {
      data: "car_reserv_driver",
      render: function (data, type, row) {
        if (data == "") {
          return '<span class="badge bg-danger">รอเลือกคนขับรถ</span>';
        } else {
          return data;
        }
      },
    },
    {
      data: "car_reserv_location",
      render: function (data, type, row) {
        return data;
      },
    },
    { data: "Date" },
    { data: "car_reserv_detail" },
    {
      data: "car_reserv_memberID",
      render: function (data, type, row) {
        return row.Member;
      },
    },
  ],
});

$("#TBShowDataCarBookingAdmin").DataTable({
  responsive: true,
  serverMethod: "post",
  ajax: {
    url: "../../CarBooking/DB/DataTable/Approve/Admin",
  },

  order: [[1, "desc"]],
    columns: [
        {
          data: "car_reserv_status",
          render: function (data, type, row) {
            if (data == "รอตรวจสอบ") {
              return '<span class="badge bg-warning">' + data + "</span>";
            } else if (data == "ไม่อนุมัติ") {
              return '<span class="badge bg-danger">' + data + "</span>";
            } else {
              return '<span class="badge bg-success">' + data + "</span>";
            }
          },
        },
        { data: "car_reserv_order" },
        { 
            data: null, // Combined column
            render: function(data, type, row) {
                // Construct Modal Content
                let carImgStr = '<img class="img-fluid rounded mb-3" style="max-width:100%; height:auto;" src="../../uploads/admin/Car/'+(row.car_img || '')+'">';
                let driverStr = (row.car_reserv_driver == '') ? '<span class="badge bg-warning">รอเลือกคนขับรถ</span>' : row.car_reserv_driver;
                let carInfoStr = row.car_category + '<br>' + row.car_registration + ' ' + row.car_province;
                let detailText = row.car_reserv_detail ? row.car_reserv_detail : '-';
                
                let statusBadge = '';
                if(row.car_reserv_status == 'รอตรวจสอบ'){
                    statusBadge = '<span class="badge bg-warning">รอตรวจสอบ</span>';
                } else if(row.car_reserv_status == 'อนุมัติ'){
                    statusBadge = '<span class="badge bg-success">อนุมัติ</span>';
                } else {
                    statusBadge = '<span class="badge bg-danger">ไม่อนุมัติ</span>';
                }
                
                let printBtnDisabled = row.car_reserv_status != "อนุมัติ" ? "disabled" : "";
                
                let modalContent = `
                    <div class="row">
                        <div class="col-md-5 text-center">
                            ${carImgStr}
                            <div class="bg-light p-2 rounded mt-2">
                                <small class="text-muted d-block">รถที่จอง</small>
                                <span class="fw-bold text-primary">${carInfoStr}</span>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0 pb-1">
                                    <span class="text-muted"><i class='bx bx-hash me-2'></i>เลขที่จอง:</span>
                                    <span class="fw-bold text-primary">${row.car_reserv_order}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0 pb-1">
                                    <span class="text-muted"><i class='bx bx-info-circle me-2'></i>สถานะ:</span>
                                    ${statusBadge}
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0 pb-1">
                                    <span class="text-muted"><i class='bx bxs-user-voice me-2'></i>ผู้จอง:</span>
                                    <span class="fw-medium">${row.Member}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0 pb-1">
                                    <span class="text-muted"><i class='bx bx-calendar-event me-2'></i>วันที่:</span>
                                    <span class="fw-medium">${row.Date}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0 pb-1">
                                    <span class="text-muted"><i class='bx bx-map me-2'></i>สถานที่ไป:</span>
                                    <span class="fw-medium text-end w-50">${row.car_reserv_location}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0 pb-1">
                                    <span class="text-muted"><i class='bx bx-id-card me-2'></i>คนขับรถ:</span>
                                    <span>${driverStr}</span>
                                </li>
                                <hr class="my-2">
                                <li class="list-group-item border-0 px-0 pt-0">
                                    <span class="text-muted d-block mb-1"><i class='bx bx-notepad me-2'></i>รายละเอียด/หัวเรื่อง:</span>
                                    <p class="mb-0 bg-lighter p-2 rounded text-secondary" style="background-color: #f8f9fa;">${detailText}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between gap-2">
                        <button type="button" class="btn btn-danger btn-modal-reject flex-fill" data-id="${row.car_reserv_id}">
                            <i class="bx bx-x-circle me-1"></i> ไม่อนุมัติ
                        </button>
                        <button type="button" class="btn btn-success btn-modal-approve flex-fill" data-id="${row.car_reserv_id}">
                            <i class="bx bx-check-circle me-1"></i> อนุมัติ
                        </button>
                        <a href="Admin/Print/${row.car_reserv_id}" target="_blank" class="btn btn-info flex-fill ${printBtnDisabled}">
                            <i class="bx bxs-printer me-1"></i> พิมพ์
                        </a>
                    </div>
                `;
                
                // Escape simple quotes for data attribute
                const safeData = modalContent.replace(/"/g, '&quot;');
                
                return `
                    <div class="d-flex flex-column gap-1">
                        <span class="fw-medium"><i class='bx bxs-user me-1 text-muted'></i>${row.Member}</span>
                        <small class="text-muted text-truncate" style="max-width: 250px;"><i class='bx bx-map-pin me-1'></i>${row.car_reserv_location}</small>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill btn-view-detail mt-1 w-100" data-detail="${safeData}" data-booking-id="${row.car_reserv_id}">
                            <i class='bx bx-search-alt me-1'></i> ดูรายละเอียด
                        </button>
                    </div>
                `;
            }
        },
        {
          data: "car_reserv_status",
          render: function (data, type, row) {
            if (row.car_reserv_status != "อนุมัติ") {
              var disab = "disabled";
            }
            return (
              '<div class="d-flex flex-column gap-2"> <button type="button" data-bs-toggle="modal" data-bs-target="#ModalApproveAdmin" class="btn btn-sm btn-primary w-100" id="BtnApproveCarBooking" carbooking-id="' +
              row.car_reserv_id +
              '"><i class="bx bx-check-shield me-1"></i> อนุมัติ </button> <div class="d-flex gap-1"> <button type="button" id="BtnClaseBooking" class="btn btn-sm btn-outline-danger flex-fill" booking-id="' +
              row.car_reserv_id +
              '"><i class="bx bx-x"></i></button> <a href="Admin/Print/' +
              row.car_reserv_id +
              '" target="_blank"  id="BtnClaseBooking" class="btn btn-sm btn-outline-info flex-fill ' +
              disab +
              '"><i class="bx bxs-printer" ></i></a> </div> </div>'
            );
          },
        },
      ],
});

// Event listener for View Detail button
$(document).on("click", ".btn-view-detail", function () {
  const detail = $(this).data("detail");
  $("#ViewDetailModal .modal-body").html(detail);
  $("#ViewDetailModal").modal("show");
});

// Event listener for Approve button inside ViewDetailModal
$(document).on("click", ".btn-modal-approve", function () {
  const bookingId = $(this).data("id");
  $("#ViewDetailModal").modal("hide");
  $("#carbookingID").val(bookingId);
  $("#ModalApproveAdmin").modal("show");
});

// Event listener for Reject button inside ViewDetailModal
$(document).on("click", ".btn-modal-reject", function () {
  const bookingId = $(this).data("id");
  Swal.fire({
    title: 'ยืนยันไม่อนุมัติ?',
    text: "ต้องการไม่อนุมัติการจองนี้หรือไม่?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'ไม่อนุมัติ',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../CarBooking/DB/NoAppoveCarReservationAdmin",
        method: "POST",
        data: { carbookingID: bookingId },
        success: function(data) {
          if (data > 0) {
            $("#ViewDetailModal").modal("hide");
            Swal.fire({
              title: 'สำเร็จ!',
              text: 'ไม่อนุมัติการจองยานพาหนะเรียบร้อย',
              icon: 'success',
              confirmButtonText: 'ตกลง'
            }).then(() => {
              location.reload();
            });
          }
        }
      });
    }
  });
});

$(document).on("submit", "#FormAddCarReservation", function (e) {
  e.preventDefault();
  $.ajax({
    url: "../../CarBooking/DB/Insert",
    method: "POST",
    data: $(this).serialize(),
    beforeSend: function () {
      $("#BtnSubBooking").html(
        '<div id="spinner" class="spinner-border spinner-border-sm text-white" role="status"></div> <span class="">กำลังบันทึก...</span>'
      );
      $("#BtnSubBooking").addClass("disabled");
    },
    success: function (data) {
      console.log(data);
      if (data > 0) {
        Swal.fire({
          title: "แจ้งเตือน?",
          text: "บันทึกการจองสำเร็จ!",
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ตกลง!",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "../../CarBooking/View";
          }
        });
      }
      $("#BtnSubBooking").removeClass("disabled");
      $("#spinner").remove();
      $("#BtnSubBooking").html("จอง");
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText); // Log the error response to the console
    },
  });
});

$(document).on("click", "#BtnApproveCarBooking", function () {
  $("#carbookingID").val($(this).attr("carbooking-id"));
});

$(document).on("submit", "#FormAppoveCarReservation", function (e) {
  e.preventDefault();
  $.ajax({
    url: "../../CarBooking/DB/AppoveCarReservationAdmin",
    method: "POST",
    data: $(this).serialize(),
    beforeSend: function () {
      $("#BtnSubBooking").html(
        '<div id="spinner" class="spinner-border spinner-border-sm text-white" role="status"></div> <span class="">กำลังบันทึก...</span>'
      );
      $("#BtnSubBooking").addClass("disabled");
    },
    success: function (data) {
      console.log(data);
      if (data > 0) {
        Swal.fire({
          title: "แจ้งเตือน?",
          text: "อนุมัติการจองยานพาหนะสำเร็จ!",
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ตกลง!",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "../../CarBooking/Approve/Admin";
          }
        });
      }
      //$('.modal-backdrop').removeClass
      $("#ModalApproveAdmin").modal("hide");
      $("#BtnSubBooking").removeClass("disabled");
      $("#spinner").remove();
    },
  });
});

$(document).on("click", "#BtnNoAppoveCarBooking", function (e) {
  e.preventDefault();
  //console.log($('#carbookingID').val());

  $.ajax({
    url: "../../CarBooking/DB/NoAppoveCarReservationAdmin",
    method: "POST",
    data: { carbookingID: $("#carbookingID").val() },
    beforeSend: function () {
      $("#BtnNoAppoveCarBooking").html(
        '<div id="spinner" class="spinner-border spinner-border-sm text-white" role="status"></div> <span class="">กำลังบันทึก...</span>'
      );
      $("#BtnNoAppoveCarBooking").addClass("disabled");
    },
    success: function (data) {
      console.log(data);
      if (data > 0) {
        Swal.fire({
          title: "แจ้งเตือน?",
          text: "ไม่อนุมัติการจองยานพาหนะสำเร็จ!",
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ตกลง!",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "../../CarBooking/Approve/Admin";
          }
        });
      }
      $("#ModalApproveAdmin").modal("hide");
      $("#BtnNoAppoveCarBooking").removeClass("disabled");
      $("#spinner").remove();
      $("#BtnNoAppoveCarBooking").html("ไม่อนุมัติ");
    },
  });
});

$(document).on("click", "#BtnCancelBooking", function () {
  //alert($(this).attr('key-id'));
  Swal.fire({
    title: "ต้องการยกเลิกการจองหรือไม่?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ตกลง",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "../../Booking/DB/Cancel",
        { KeyID: $(this).attr("key-id") },
        function (data) {
          console.log(data);
          // $('#TBShowDataBooking').DataTable().ajax.reload();
          location.reload(true);
        }
      );
    }
  });
});

// $(document).on('change', '#booking_timeStart', function() {
//     $.post('../../Booking/DB/CheckDateBooking', {
//         booking_dateStart: $('#booking_dateStart').val(),
//         booking_timeStart: $('#booking_timeStart').val()
//     }, function(data) {
//         console.log(data);
//         if (data > 0) {
//             Swal.fire(
//                 'กรุณาเลือกใหม่',
//                 'ช่วงวัน หรือ เวลา มีผู้จองแล้ว!',
//                 'warning'
//             )
//             $('#booking_timeStart').val('');
//         }

//     });
// });

// $(document).on('change', '#booking_timeEnd', function() {
//     $.post('../../Booking/DB/CheckTimeBooking', {
//         booking_dateEnd: $('#booking_dateEnd').val(),
//         booking_timeEnd: $('#booking_timeEnd').val()
//     }, function(data) {
//         console.log(data);
//         if (data > 0) {
//             Swal.fire(
//                 'กรุณาเลือกใหม่',
//                 'ช่วงวัน หรือ เวลา มีผู้จองแล้ว!',
//                 'warning'
//             )
//             $('#booking_timeEnd').val('');
//         }
//     });
// });

$("#BtnSubBooking").prop("disabled", true);
$(document).on(
  "change",
  "#car_reserv_StartDate, #car_reserv_StartTime, #car_reserv_EndDate, #car_reserv_EndTime",
  function () {
    $.post(
      "../../Booking/DB/CheckDateCarBooking",
      {
        car_reserv_carID: $("#car_reserv_carID").val(),
        car_reserv_StartDate: $("#car_reserv_StartDate").val(),
        car_reserv_StartTime: $("#car_reserv_StartTime").val(),
        car_reserv_EndDate: $("#car_reserv_EndDate").val(),
        car_reserv_EndTime: $("#car_reserv_EndTime").val(),
      },
      function (data) {
        console.log(data);
        $("#AlertMessage").html(data.message);
        $("#AlertMessage").removeClass().addClass(data.class);
        if (data.status == 0) {
          $("#BtnSubBooking").prop("disabled", true);
          //$('#booking_timeStart').val('');
        } else {
          $("#BtnSubBooking").prop("disabled", false);
        }
      }
    );
  }
);

function formatThaiDate(date) {
  let thaiDate = new Intl.DateTimeFormat("th-TH", {
    year: "numeric",
    month: "long",
    day: "numeric",
    weekday: "long",
  }).format(new Date(date));

  return thaiDate;
}

var calendarEl = document.getElementById("calendar");

if (calendarEl) {
  var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      left: "prevYear,prev,next,nextYear today",
      center: "title",
      right: "dayGridMonth,dayGridWeek,dayGridDay",
    },
    navLinks: true, // can click day/week names to navigate views
    editable: false,
    locale: "th",
    eventSources: [
      {
        events: function (fetchInfo, successCallback, failureCallback) {
          jQuery.ajax({
            url: "Booking/DB/ShowTimeCarBooking",
            type: "POST",
            success: function (res) {
              var events = [];
              res.forEach((evt) => {
                if (evt.approved == "รอตรวจสอบ") {
                  var Color = "#ffab00";
                } else if (evt.approved == "อนุมัติ") {
                  var Color = "#71dd37";
                } else {
                  var Color = "#ff3e1d";
                }
                events.push({
                  id: evt.id,
                  title: evt.title,
                  start: evt.start,
                  end: evt.end,
                  backgroundColor: Color,
                  CarAppend: evt.approved,
                });
              });
              successCallback(events);
            },
          });
        },
        eventColor: "#378006",
      },
    ],
    initialView: "dayGridMonth",
    eventClick: function (info) {
      // alert("วันที่: " + info.event.start.toLocaleDateString() + "\n"+
      //         "เวลา: " + info.event.title + "\n");

      if (info.event.extendedProps.CarAppend == "อนุมัติ") {
        var Icon = "success";
      } else if (info.event.extendedProps.CarAppend == "รอตรวจสอบ") {
        var Icon = "warning";
      } else if (info.event.extendedProps.CarAppend == "ไม่อนุมัติ") {
        var Icon = "error";
      }
      Swal.fire({
        title: `สถานะ : ${info.event.extendedProps.CarAppend}`,
        html: `<b>วันที่ใช้บริการ</b> : ${formatThaiDate(info.event.start)} <br>
                               <b>โดยใช้ :</b> ${
                                 info.event.title || "ไม่มีรายละเอียด"
                               }<br>
                               `,
        icon: Icon,
      });
    },
  });
  calendar.render();
}
