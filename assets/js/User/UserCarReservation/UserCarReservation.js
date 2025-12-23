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
  dom: '<"top"rt><"bottom"ip><"clear">', // Custom layout for search integration
  order: [[1, "desc"]],
  columns: [
    {
      data: "car_reserv_status",
      className: "align-middle",
      render: function (data, type, row) {
        if (data == "รอตรวจสอบ") {
          return `<span class="status-pill pending"><i class='bx bx-time-five'></i> ${data}</span>`;
        } else if (data == "ไม่อนุมัติ") {
          return `<span class="status-pill rejected"><i class='bx bx-x-circle'></i> ${data}</span>`;
        } else {
          return `<span class="status-pill approved"><i class='bx bx-check-circle'></i> ${data}</span>`;
        }
      },
    },
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
                <span class="fw-bold text-dark" style="font-size: 0.85rem;">${row.car_reserv_order}</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="bg-label-primary p-1 rounded-circle me-1" style="width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                    <i class='bx bx-user' style="font-size: 0.75rem;"></i>
                </div>
                <span class="text-body fw-medium small">${row.Member}</span>
            </div>
          </div>
        `;
      }
    },
    {
      data: null,
      className: "align-middle",
      render: function (data, type, row) {
        let locationIcon = `<i class='bx bxs-map-pin text-danger me-1 flex-shrink-0' style="font-size: 1rem;"></i>`;
        let timeIcon = `<i class='bx bx-time text-primary me-1 flex-shrink-0' style="font-size: 0.85rem;"></i>`;
        
        return `
          <div class="d-flex flex-column gap-1 py-1">
            <div class="d-flex align-items-center text-nowrap">
                ${locationIcon}
                <span class="text-dark fw-bold" style="font-size: 0.95rem; letter-spacing: -0.2px;">${row.car_reserv_location}</span>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <div class="d-flex align-items-center px-1 text-nowrap">
                    ${timeIcon}
                    <span class="small text-muted fw-medium" style="font-size: 0.75rem;">${row.Date}</span>
                </div>
                ${row.car_reserv_detail ? `
                <div class="d-flex align-items-center px-1 text-nowrap">
                    <i class='bx bx-note text-warning me-1 flex-shrink-0' style="font-size: 0.85rem;"></i>
                    <span class="small text-muted text-truncate" style="max-width: 180px; font-size: 0.75rem;">${row.car_reserv_detail}</span>
                </div>` : ''}
            </div>
          </div>
        `;
      }
    },
    {
      data: null,
      className: "align-middle",
      render: function (data, type, row) {
        let driverInfo = (row.car_reserv_status == "อนุมัติ" && row.car_reserv_driver) 
          ? `<div class="mt-1 d-flex align-items-center text-primary" style="font-size: 0.75rem;">
               <i class='bx bx-steering-wheel me-1'></i>
               <span class="fw-medium">${row.car_reserv_driver}</span>
             </div>` 
          : '';
          
        return `
          <div class="d-flex flex-column align-items-start">
            <div class="car-info-badge p-1 px-2 rounded bg-label-info border border-info border-opacity-10 d-inline-block">
                <div class="d-flex align-items-center gap-1">
                <i class='bx bxs-car-garage fs-6'></i>
                <span class="fw-bold text-dark small">${row.car_registration}</span>
                <span class="small opacity-75" style="font-size: 0.7rem;">(${row.car_category})</span>
                </div>
            </div>
            ${driverInfo}
          </div>
        `;
      }
    },
    {
      data: null,
      className: "text-end align-middle",
      render: function (data, type, row) {
        let isApproved = row.car_reserv_status == "อนุมัติ";
        let isRejected = row.car_reserv_status == "ไม่อนุมัติ";
        let printUrl = BASE_URL + "/CarBooking/Approve/Admin/Print/" + row.car_reserv_id;
        
        if (isApproved) {
            return `
                <div class="d-flex align-items-center justify-content-end gap-1 text-nowrap">
                    <span class="badge bg-success shadow-none rounded-pill px-2 py-1 small" style="font-size: 0.75rem;"><i class="bx bx-check-circle"></i></span>
                    <a href="${printUrl}" target="_blank" class="btn btn-sm btn-info rounded-pill px-2 py-1 shadow-none" title="พิมพ์ใบงาน">
                        <i class="bx bxs-printer"></i> พิมพ์
                    </a>
                    <button type="button" class="btn btn-outline-warning btn-sm rounded-pill px-2 py-1 btn-cancel-approve" 
                            carbooking-id="${row.car_reserv_id}" title="ยกเลิกอนุมัติ">
                        <i class="bx bx-undo"></i> ย้อน
                    </button>
                </div>`;
        } else if (isRejected) {
            return `
                <div class="d-flex align-items-center justify-content-end gap-1 text-nowrap">
                    <button type="button" class="btn btn-warning btn-sm rounded-pill px-2 py-1 btn-cancel-reject shadow-none" 
                            carbooking-id="${row.car_reserv_id}">
                        <i class="bx bx-undo"></i> คืนสถานะ
                    </button>
                </div>`;
        }
        
        return `
          <div class="d-flex align-items-center justify-content-end gap-1 text-nowrap">
             <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 py-1 btn-approve-row shadow-none" 
                    carbooking-id="${row.car_reserv_id}" 
                    data-bs-toggle="modal" 
                    data-bs-target="#ModalApproveAdmin">
                <i class="bx bx-check-shield"></i> อนุมัติ
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-1 btn-reject-row" 
                    carbooking-id="${row.car_reserv_id}">
                <i class="bx bx-x"></i> ไม่รับ
            </button>
          </div>
        `;
      },
    },
  ],
});

// Sync custom search with DataTable
$(document).on("keyup", "#tableSearch", function() {
    $("#TBShowDataCarBookingAdmin").DataTable().search($(this).val()).draw();
});

// Simplified View Detail Listener
$(document).on("click", ".btn-view-detail", function() {
    const b64 = $(this).data("html");
    const html = decodeURIComponent(escape(atob(b64)));
    $("#ViewDetailModal #detailContentBody").html(html);
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
$(document).on("click", ".btn-modal-reject, .btn-reject-row", function () {
  const $btn = $(this);
  const originalHtml = $btn.html();
  const bookingId = $btn.attr("carbooking-id") || $btn.data("id");
  
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
        beforeSend: function() {
            $btn.html('<div class="spinner-border spinner-border-sm text-white me-1" role="status"></div> บันทึก...').addClass("disabled");
        },
        success: function(data) {
          if (data > 0) {
            Swal.fire({
              title: 'สำเร็จ!',
              text: 'ไม่อนุมัติการจองยานพาหนะเรียบร้อย',
              icon: 'success',
              confirmButtonText: 'ตกลง'
            }).then(() => {
              $("#ViewDetailModal").modal("hide");
              $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
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

$(document).on("click", ".btn-approve-row", function () {
  $("#carbookingID").val($(this).attr("carbooking-id"));
});

$(document).on("click", ".btn-cancel-reject, .btn-cancel-approve", function () {
  const $btn = $(this);
  const originalHtml = $btn.html();
  const bookingId = $btn.attr("carbooking-id");
  const isCancelApprove = $btn.hasClass("btn-cancel-approve");
  
  const title = isCancelApprove ? 'ต้องการยกเลิกการอนุมัติ?' : 'ยกเลิกสถานะไม่อนุมัติ?';
  const text = isCancelApprove ? "คุณต้องการยกเลิกการอนุมัติและเปลี่ยนสถานะกลับเป็น 'รอตรวจสอบ' ใช่หรือไม่?" : "คุณต้องการเปลี่ยนสถานะกลับเป็น 'รอตรวจสอบ' เพื่อให้สามารถอนุมัติได้อีกครั้งใช่หรือไม่?";

  Swal.fire({
    title: title,
    text: text,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#ffab00',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'ใช่, เปลี่ยนสถานะ',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: BASE_URL + "/CarBooking/DB/ResetAppoveCarReservationAdmin",
        method: "POST",
        data: { carbookingID: bookingId },
        beforeSend: function() {
            $btn.html('<div class="spinner-border spinner-border-sm text-white me-1" role="status"></div>').addClass("disabled");
        },
        success: function(data) {
          if (parseInt(data) > 0) {
            Swal.fire({
              title: 'สำเร็จ!',
              text: 'คืนสถานะเรียบร้อยแล้ว ท่านสามารถจัดการรายการนี้ได้ใหม่',
              icon: 'success',
              confirmButtonText: 'ตกลง'
            }).then(() => {
              $("#ViewDetailModal").modal("hide");
              $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
            });
          } else {
             Swal.fire('ผิดพลาด', 'ไม่สามารถบันทึกข้อมูลได้', 'error');
          }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            Swal.fire('เกิดข้อผิดพลาด', 'กรุณาลองใหม่อีกครั้ง หรือติดต่อผู้ดูแลระบบ', 'error');
        },
        complete: function() {
            $btn.html(originalHtml).removeClass("disabled");
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
  const $form = $(this);
  const $btn = $form.find('button[type="submit"]');
  const originalHtml = $btn.html();

  $.ajax({
    url: "../../CarBooking/DB/AppoveCarReservationAdmin",
    method: "POST",
    data: $(this).serialize(),
    beforeSend: function () {
      $btn.html('<div class="spinner-border spinner-border-sm text-white me-1" role="status"></div> บันทึกการอนุมัติ...').addClass("disabled");
    },
    success: function (data) {
      if (data > 0) {
        $("#ModalApproveAdmin").modal("hide");
        $(".modal-backdrop").remove();
        $("body").removeClass("modal-open").css("overflow", "");

        Swal.fire({
          title: "แจ้งเตือน",
          text: "อนุมัติการจองยานพาหนะสำเร็จ!",
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ตกลง!",
        }).then(() => {
          $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
        });
      } else {
        Swal.fire('ผิดพลาด', 'ไม่สามารถบันทึกข้อมูลได้', 'error');
      }
    },
    complete: function() {
      $btn.html(originalHtml).removeClass("disabled");
    }
  });
});

$(document).on("click", "#BtnNoAppoveCarBooking", function (e) {
  e.preventDefault();
  const $btn = $(this);
  const originalHtml = $btn.html();

  $.ajax({
    url: "../../CarBooking/DB/NoAppoveCarReservationAdmin",
    method: "POST",
    data: { carbookingID: $("#carbookingID").val() },
    beforeSend: function () {
      $btn.html('<div class="spinner-border spinner-border-sm text-white me-1" role="status"></div> กำลังบันทึก...').addClass("disabled");
    },
    success: function (data) {
      if (data > 0) {
        $("#ModalApproveAdmin").modal("hide");
        $(".modal-backdrop").remove();
        $("body").removeClass("modal-open").css("overflow", "");

        Swal.fire({
          title: "แจ้งเตือน",
          text: "ไม่อนุมัติการจองยานพาหนะสำเร็จ!",
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ตกลง!",
        }).then(() => {
          $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
        });
      }
    },
    complete: function() {
      $btn.html(originalHtml).removeClass("disabled");
    }
  });
});

$(document).on("click", "#BtnCancelBooking", function () {
  const $btn = $(this);
  const originalHtml = $btn.html();
  Swal.fire({
    title: "ต้องการยกเลิกการจองหรือไม่?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "ตกลง",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../Booking/DB/Cancel",
        method: "POST",
        data: { KeyID: $btn.attr("key-id") },
        beforeSend: function() {
            $btn.html('<div class="spinner-border spinner-border-sm text-white" role="status"></div>').addClass("disabled");
        },
        success: function(data) {
           Swal.fire('สำเร็จ', 'ยกเลิกการจองเรียบร้อย', 'success').then(() => {
              if ($("#TBShowDataCarBookingAdmin").length) {
                $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
              } else {
                location.reload();
              }
           });
        },
        complete: function() {
            $btn.html(originalHtml).removeClass("disabled");
        }
      });
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
