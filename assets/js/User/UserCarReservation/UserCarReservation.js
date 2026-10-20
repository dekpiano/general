// Car Booking JS Module
$(document).ready(function() {
  const getUrl = (path) => BASE_URL + (BASE_URL.endsWith('/') ? '' : '/') + (path.startsWith('/') ? path.substring(1) : path);
  
  // 1. Room Booking Table (General)
  if ($("#TBShowDataBooking").length && !$.fn.DataTable.isDataTable('#TBShowDataBooking')) {
    $("#TBShowDataBooking").DataTable({
      responsive: true,
      order: [[0, "desc"]],
    });
  }

  // 2. User Car Booking History Table
  // Note: Only initialize if not already initialized by view-specific scripts
  if ($("#TBShowDataCarBooking").length && !$.fn.DataTable.isDataTable('#TBShowDataCarBooking')) {
    // This part is now handled mainly by inline scripts in UserCarBookingView.php 
    // to preserve the premium design. But we keep a check here just in case.
  }

  // 3. Admin Car Booking Management Table
  if ($("#TBShowDataCarBookingAdmin").length && !$.fn.DataTable.isDataTable('#TBShowDataCarBookingAdmin')) {
    $("#TBShowDataCarBookingAdmin").DataTable({
      responsive: true,
      serverMethod: "post",
      ajax: {
        url: getUrl("CarBooking/DB/DataTable/Approve/Admin"),
      },
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50],
      dom: '<"top"rt><"bottom d-none d-md-flex justify-content-between align-items-center mt-3"ip><"clear">',
      order: [[1, "desc"]],
      columns: [
        {
          data: "car_reserv_status",
          className: "align-middle",
          render: function (data, type, row) {
            if (data == "รอตรวจสอบ") {
              return `<span class="status-pill pending"><i class='bx bx-time-five'></i> ${data}</span>`;
            } else if (data == "ไม่อนุมัติ") {
              let approverHtml = row.car_reserv_approver 
                ? `<div class="mt-1 small text-muted" style="font-size: 0.72rem;"><i class='bx bx-user-x me-1 text-danger'></i>โดย: ${row.car_reserv_approver}</div>` 
                : '';
              return `<div><span class="status-pill rejected"><i class='bx bx-x-circle'></i> ${data}</span>${approverHtml}</div>`;
            } else if (data == "ยกเลิก" || data == "ยกเลิกการจอง") {
              return `<span class="status-pill text-secondary bg-label-secondary"><i class='bx bx-minus-circle'></i> ${data}</span>`;
            } else {
              let approverHtml = row.car_reserv_approver 
                ? `<div class="mt-1 small text-muted" style="font-size: 0.72rem;"><i class='bx bx-user-check me-1 text-success'></i>โดย: <span class="fw-semibold text-dark">${row.car_reserv_approver}</span></div>` 
                : '';
              return `<div><span class="status-pill approved"><i class='bx bx-check-circle'></i> ${data}</span>${approverHtml}</div>`;
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
            let isRejected = row.car_reserv_status == "ไม่อนุมัติ" || row.car_reserv_status == "ยกเลิก";
            let printUrl = getUrl("CarBooking/Approve/Admin/Print/" + row.car_reserv_id);
            
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
                <button type="button" class="btn btn-outline-warning btn-sm rounded-pill px-2 py-1 btn-disapprove-row" 
                        carbooking-id="${row.car_reserv_id}">
                    <i class="bx bx-error-circle"></i> ไม่อนุมัติ
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-2 py-1 btn-reject-row" 
                        carbooking-id="${row.car_reserv_id}">
                    <i class="bx bx-x"></i> ยกเลิก
                </button>
              </div>
            `;
          },
        },
      ],
      drawCallback: function(settings) {
        renderAdminMobileCards(this.api());
      }
    });
  }

  // Helper function to render admin mobile cards
  function renderAdminMobileCards(api) {
    const $container = $("#mobileBookingCardsContainer");
    if (!$container.length) return;

    const data = api.rows({ page: 'current' }).data();
    if (!data.length) {
      $container.html(`
        <div class="text-center py-4 text-muted">
          <i class='bx bx-car fs-1 mb-2 d-block text-secondary opacity-50'></i>
          <div>ไม่พบรายการจองยานพาหนะ</div>
        </div>
      `);
      return;
    }

    let cardsHtml = '';
    for (let i = 0; i < data.length; i++) {
      const row = data[i];
      let statusBorder = 'border-status-pending';
      let statusPill = `<span class="status-pill pending"><i class='bx bx-time-five'></i> ${row.car_reserv_status}</span>`;

      if (row.car_reserv_status === 'อนุมัติ') {
        statusBorder = 'border-status-approved';
        let approverHtml = row.car_reserv_approver 
          ? `<div class="small text-muted" style="font-size: 0.72rem;"><i class='bx bx-user-check me-1 text-success'></i>โดย: ${row.car_reserv_approver}</div>` 
          : '';
        statusPill = `<div><span class="status-pill approved"><i class='bx bx-check-circle'></i> ${row.car_reserv_status}</span>${approverHtml}</div>`;
      } else if (row.car_reserv_status === 'ไม่อนุมัติ') {
        statusBorder = 'border-status-rejected';
        let approverHtml = row.car_reserv_approver 
          ? `<div class="small text-muted" style="font-size: 0.72rem;"><i class='bx bx-user-x me-1 text-danger'></i>โดย: ${row.car_reserv_approver}</div>` 
          : '';
        statusPill = `<div><span class="status-pill rejected"><i class='bx bx-x-circle'></i> ${row.car_reserv_status}</span>${approverHtml}</div>`;
      } else if (row.car_reserv_status === 'ยกเลิก' || row.car_reserv_status === 'ยกเลิกการจอง') {
        statusBorder = 'border-status-rejected';
        statusPill = `<span class="status-pill text-secondary bg-label-secondary"><i class='bx bx-minus-circle'></i> ${row.car_reserv_status}</span>`;
      }

      // Actions
      let actionButtons = '';
      let printUrl = getUrl("CarBooking/Approve/Admin/Print/" + row.car_reserv_id);

      if (row.car_reserv_status === 'อนุมัติ') {
        actionButtons = `
          <a href="${printUrl}" target="_blank" class="btn btn-sm btn-info shadow-none" title="พิมพ์ใบงาน">
            <i class="bx bxs-printer"></i> พิมพ์
          </a>
          <button type="button" class="btn btn-outline-warning btn-sm btn-cancel-approve" 
                  carbooking-id="${row.car_reserv_id}" title="ยกเลิกอนุมัติ">
            <i class="bx bx-undo"></i> ย้อน
          </button>
        `;
      } else if (row.car_reserv_status === 'ไม่อนุมัติ' || row.car_reserv_status === 'ยกเลิก') {
        actionButtons = `
          <button type="button" class="btn btn-warning btn-sm btn-cancel-reject shadow-none" 
                  carbooking-id="${row.car_reserv_id}">
            <i class="bx bx-undo"></i> คืนสถานะ
          </button>
        `;
      } else {
        actionButtons = `
          <button type="button" class="btn btn-primary btn-sm btn-approve-row shadow-none" 
                  carbooking-id="${row.car_reserv_id}" 
                  data-bs-toggle="modal" 
                  data-bs-target="#ModalApproveAdmin">
            <i class="bx bx-check-shield"></i> อนุมัติ
          </button>
          <button type="button" class="btn btn-outline-warning btn-sm btn-disapprove-row" 
                  carbooking-id="${row.car_reserv_id}">
            <i class="bx bx-error-circle"></i> ไม่อนุมัติ
          </button>
          <button type="button" class="btn btn-outline-danger btn-sm btn-reject-row" 
                  carbooking-id="${row.car_reserv_id}">
            <i class="bx bx-x"></i> ยกเลิก
          </button>
        `;
      }

      let driverHtml = (row.car_reserv_status === 'อนุมัติ' && row.car_reserv_driver)
        ? `<div class="card-info-row text-primary fw-medium"><i class='bx bx-steering-wheel'></i> คนขับ: ${row.car_reserv_driver}</div>`
        : '';

      cardsHtml += `
        <div class="admin-mobile-card ${statusBorder}">
          <div class="card-head">
            ${statusPill}
            <span class="badge bg-label-secondary fw-bold" style="font-size: 0.75rem;">
              <i class='bx bx-hash'></i> ${row.car_reserv_order}
            </span>
          </div>

          <div class="card-destination">
            <i class='bx bxs-map-pin text-danger'></i>
            <span>${row.car_reserv_location || '-'}</span>
          </div>

          <div class="card-info-row">
            <i class='bx bx-user text-primary'></i>
            <span class="text-dark fw-medium">${row.Member || '-'}</span>
          </div>

          <div class="card-info-row">
            <i class='bx bx-time text-primary'></i>
            <span>${row.Date || '-'}</span>
          </div>

          ${row.car_reserv_detail ? `
          <div class="card-info-row">
            <i class='bx bx-note text-warning'></i>
            <span>${row.car_reserv_detail}</span>
          </div>` : ''}

          <div class="card-car-badge">
            <i class='bx bxs-car text-info'></i>
            <span class="fw-bold text-dark">${row.car_registration || ''}</span>
            <span class="text-muted small">(${row.car_category || ''})</span>
          </div>

          ${driverHtml}

          <div class="card-actions-wrapper">
            ${actionButtons}
          </div>
        </div>
      `;
    }

    // Mobile Pagination Controls
    const pageInfo = api.page.info();
    if (pageInfo && pageInfo.pages > 1) {
      let pageButtons = '';
      const currentPage = pageInfo.page; // 0-indexed
      const totalPages = pageInfo.pages;

      // Previous button
      pageButtons += `
        <button type="button" class="mobile-page-btn btn-admin-mobile-page" data-page="${currentPage - 1}" ${currentPage === 0 ? 'disabled' : ''}>
          <i class='bx bx-chevron-left'></i>
        </button>
      `;

      // Page numbers (smart window)
      let startPage = Math.max(0, currentPage - 1);
      let endPage = Math.min(totalPages - 1, currentPage + 1);

      if (startPage > 0) {
        pageButtons += `<button type="button" class="mobile-page-btn btn-admin-mobile-page ${currentPage === 0 ? 'active' : ''}" data-page="0">1</button>`;
        if (startPage > 1) {
          pageButtons += `<span class="px-1 text-muted small">...</span>`;
        }
      }

      for (let p = startPage; p <= endPage; p++) {
        pageButtons += `
          <button type="button" class="mobile-page-btn btn-admin-mobile-page ${p === currentPage ? 'active' : ''}" data-page="${p}">
            ${p + 1}
          </button>
        `;
      }

      if (endPage < totalPages - 1) {
        if (endPage < totalPages - 2) {
          pageButtons += `<span class="px-1 text-muted small">...</span>`;
        }
        pageButtons += `<button type="button" class="mobile-page-btn btn-admin-mobile-page ${currentPage === totalPages - 1 ? 'active' : ''}" data-page="${totalPages - 1}">${totalPages}</button>`;
      }

      // Next button
      pageButtons += `
        <button type="button" class="mobile-page-btn btn-admin-mobile-page" data-page="${currentPage + 1}" ${currentPage >= totalPages - 1 ? 'disabled' : ''}>
          <i class='bx bx-chevron-right'></i>
        </button>
      `;

      cardsHtml += `
        <div class="mobile-pagination-box">
          <div class="mobile-pagination-controls">
            ${pageButtons}
          </div>
          <div class="mobile-pagination-info">
            แสดงรายการที่ ${pageInfo.start + 1} - ${pageInfo.end} จากทั้งหมด ${pageInfo.recordsDisplay} รายการ
          </div>
        </div>
      `;
    }

    $container.html(cardsHtml);
  }

  // Handle Mobile Pagination clicks
  $(document).on("click", ".btn-admin-mobile-page", function() {
    const page = parseInt($(this).data("page"), 10);
    if (!isNaN(page) && $("#TBShowDataCarBookingAdmin").length) {
      $("#TBShowDataCarBookingAdmin").DataTable().page(page).draw('page');
      // Smooth scroll back to list top on mobile
      const listTop = $("#mobileBookingCardsContainer").offset().top - 80;
      if (window.scrollY > listTop) {
        window.scrollTo({ top: listTop, behavior: 'smooth' });
      }
    }
  });

  // Common UI Handlers
  $(document).on("keyup", "#tableSearch", function() {
    if ($("#TBShowDataCarBookingAdmin").length) {
      $("#TBShowDataCarBookingAdmin").DataTable().search($(this).val()).draw();
    }
  });

  $(document).on("click", ".btn-approve-row", function () {
    $("#carbookingID").val($(this).attr("carbooking-id"));
  });

  // Admin Actions Submissions
  $(document).on("submit", "#FormAppoveCarReservation", function (e) {
    e.preventDefault();
    const $form = $(this);
    const $btn = $form.find('button[type="submit"]');
    const originalHtml = $btn.html();

    $.ajax({
      url: getUrl("CarBooking/DB/AppoveCarReservationAdmin"),
      method: "POST",
      data: $(this).serialize(),
      beforeSend: function () {
        $btn.html('<div class="spinner-border spinner-border-sm text-white me-1" role="status"></div> บันทึก...').addClass("disabled");
      },
      success: function (res) {
        if (res.status === 'success') {
          $("#ModalApproveAdmin").modal("hide");
          Swal.fire({ title: "สำเร็จ", text: res.message, icon: "success" }).then(() => {
            $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
          });
        } else {
          Swal.fire('ผิดพลาด', res.message || 'ไม่สามารถบันทึกข้อมูลได้', 'error');
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
      url: getUrl("CarBooking/DB/NoAppoveCarReservationAdmin"),
      method: "POST",
      data: { carbookingID: $("#carbookingID").val() },
      beforeSend: function () {
        $btn.html('<div class="spinner-border spinner-border-sm text-white me-1" role="status"></div>').addClass("disabled");
      },
      success: function (res) {
        if (res.status === 'success') {
          $("#ModalApproveAdmin").modal("hide");
          Swal.fire({ title: "สำเร็จ", text: res.message, icon: "success" }).then(() => {
            $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
          });
        }
      },
      complete: function() {
        $btn.html(originalHtml).removeClass("disabled");
      }
    });
  });

  // Handle click on Cancel Booking from table row (ยกเลิก)
  $(document).on('click', '.btn-reject-row', function () {
    const $btn = $(this);
    const bookingId = $btn.attr('carbooking-id');
    const originalHtml = $btn.html();

    Swal.fire({
      title: 'ยกเลิกการจอง?',
      text: "คุณต้องการยกเลิกการจองยานพาหนะนี้ใช่หรือไม่?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ff3e1d',
      confirmButtonText: 'ใช่, ยกเลิกการจอง',
      cancelButtonText: 'ย้อนกลับ'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: getUrl("CarBooking/DB/NoAppoveCarReservationAdmin"),
          method: 'POST',
          data: { carbookingID: bookingId, status: 'ยกเลิก' },
          beforeSend: function() {
            $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>').addClass("disabled");
          },
          success: function(res) {
            if (res.status === 'success') {
              Swal.fire({
                title: 'สำเร็จ!',
                text: 'ดำเนินการเรียบร้อยแล้ว',
                icon: 'success'
              }).then(() => {
                $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
              });
            } else {
              Swal.fire("ผิดพลาด!", res.message || "ไม่สามารถดำเนินการได้", "error");
            }
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

  // Handle click on Disapprove Booking from table row (ไม่อนุมัติ)
  $(document).on('click', '.btn-disapprove-row', function () {
    const $btn = $(this);
    const bookingId = $btn.attr('carbooking-id');
    const originalHtml = $btn.html();

    Swal.fire({
      title: 'ไม่อนุมัติการจอง?',
      text: "คุณต้องการปฏิเสธหรือไม่อนุมัติการจองยานพาหนะนี้ใช่หรือไม่?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#fd7e14',
      confirmButtonText: 'ใช่, ไม่อนุมัติ',
      cancelButtonText: 'ย้อนกลับ'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: getUrl("CarBooking/DB/NoAppoveCarReservationAdmin"),
          method: 'POST',
          data: { carbookingID: bookingId, status: 'ไม่อนุมัติ' },
          beforeSend: function() {
            $btn.html('<span class="spinner-border spinner-border-sm me-1"></span>').addClass("disabled");
          },
          success: function(res) {
            if (res.status === 'success') {
              Swal.fire({
                title: 'สำเร็จ!',
                text: 'ดำเนินการเรียบร้อยแล้ว',
                icon: 'success'
              }).then(() => {
                $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
              });
            } else {
              Swal.fire("ผิดพลาด!", res.message || "ไม่สามารถดำเนินการได้", "error");
            }
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

  // Handle click on Reset status (คืนสถานะ / ย้อน)
  $(document).on("click", ".btn-cancel-reject, .btn-cancel-approve", function () {
    const $btn = $(this);
    const bookingId = $btn.attr("carbooking-id");
    const originalHtml = $btn.html();
    const isCancelApprove = $btn.hasClass("btn-cancel-approve");

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
          url: getUrl("CarBooking/DB/ResetAppoveCarReservationAdmin"),
          method: "POST",
          data: { carbookingID: bookingId },
          beforeSend: function() {
            $btn.html('<span class="spinner-border spinner-border-sm"></span>').addClass("disabled");
          },
          success: function(res) {
            if (res.status === 'success') {
              Swal.fire('สำเร็จ!', 'คืนสถานะเรียบร้อยแล้ว', 'success').then(() => {
                $("#TBShowDataCarBookingAdmin").DataTable().ajax.reload(null, false);
              });
            } else {
              Swal.fire("ผิดพลาด!", res.message || "ไม่สามารถดำเนินการได้", "error");
            }
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

  // FullCalendar Logic
  var calendarEl = document.getElementById("calendar");
  if (calendarEl) {
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: "prevYear,prev,next,nextYear today",
        center: "title",
        right: "dayGridMonth,dayGridWeek,dayGridDay",
      },
      navLinks: true,
      editable: false,
      locale: "th",
      eventSources: [{
        events: function (fetchInfo, successCallback, failureCallback) {
          $.ajax({
            url: getUrl("Booking/DB/ShowTimeCarBooking"),
            type: "POST",
            success: function (res) {
              var events = res.map(evt => ({
                id: evt.id,
                title: evt.title,
                start: evt.start,
                end: evt.end,
                backgroundColor: evt.approved == "รอตรวจสอบ" ? "#ffab00" : (evt.approved == "อนุมัติ" ? "#71dd37" : "#ff3e1d"),
                CarAppend: evt.approved,
              }));
              successCallback(events);
            },
          });
        }
      }],
      initialView: "dayGridMonth",
      eventClick: function (info) {
        let status = info.event.extendedProps.CarAppend;
        let icon = status == "อนุมัติ" ? "success" : (status == "รอตรวจสอบ" ? "warning" : "error");
        Swal.fire({
          title: `สถานะ : ${status}`,
          html: `<b>วันที่ใช้บริการ</b> : ${formatThaiDate(info.event.start)} <br><b>โดยใช้ :</b> ${info.event.title || "ไม่มีรายละเอียด"}<br>`,
          icon: icon,
        });
      },
    });
    calendar.render();
  }
});

function formatThaiDate(date) {
  return new Intl.DateTimeFormat("th-TH", {
    year: "numeric", month: "long", day: "numeric", weekday: "long",
  }).format(new Date(date));
}
