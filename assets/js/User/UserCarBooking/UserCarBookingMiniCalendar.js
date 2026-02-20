class MiniCalendar {
  constructor(locationId, containerEl) {
    this.locationId = locationId; // This corresponds to car_id
    this.containerEl = containerEl;
    this.currentMonth = new Date().getMonth() + 1; // 1-12
    this.currentYear = new Date().getFullYear();
    this.bookings = [];

    this.init();
  }

  init() {
    this.monthSelector = document.querySelector(
      `.month-selector[data-location-id="${this.locationId}"]`,
    );
    this.yearSelector = document.querySelector(
      `.year-selector[data-location-id="${this.locationId}"]`,
    );

    if (this.monthSelector) this.monthSelector.value = this.currentMonth;
    if (this.yearSelector) this.yearSelector.value = this.currentYear;

    if (this.monthSelector) {
      this.monthSelector.addEventListener("change", () => this.onDateChange());
    }
    if (this.yearSelector) {
      this.yearSelector.addEventListener("change", () => this.onDateChange());
    }

    this.render();
    this.fetchBookings();
  }

  onDateChange() {
    if (this.monthSelector)
      this.currentMonth = parseInt(this.monthSelector.value);
    if (this.yearSelector) this.currentYear = parseInt(this.yearSelector.value);
    this.render();
    this.fetchBookings(); // Re-fetch or re-filter? ShowTimeCarBooking returns ALL, so maybe just re-render events. But for consistency, let's fetch.
    // Actually ShowTimeCarBooking returns everything. We could cache it. But for now let's just fetch.
  }

  static sharedBookings = null;
  static fetchPromise = null;

  fetchBookings() {
    if (MiniCalendar.sharedBookings) {
      this.bookings = MiniCalendar.sharedBookings.filter(
        (b) => String(b.car_id).trim() === String(this.locationId).trim(),
      );
      this.updateEvents();
      return;
    }

    if (MiniCalendar.fetchPromise) {
      MiniCalendar.fetchPromise.then(() => {
        this.bookings = MiniCalendar.sharedBookings.filter(
          (b) => String(b.car_id).trim() === String(this.locationId).trim(),
        );
        this.updateEvents();
      });
      return;
    }

    const url = `${BASE_URL}Booking/DB/ShowTimeCarBooking?v=${new Date().getTime()}`;
    MiniCalendar.fetchPromise = fetch(url)
      .then((res) => res.json())
      .then((data) => {
        MiniCalendar.sharedBookings = data;
        this.bookings = data.filter(
          (b) => String(b.car_id).trim() === String(this.locationId).trim(),
        );
        this.updateEvents();
        MiniCalendar.fetchPromise = null;
      })
      .catch((err) => {
        console.error("Error fetching bookings:", err);
        MiniCalendar.fetchPromise = null;
      });
  }

  render() {
    const daysInMonth = new Date(
      this.currentYear,
      this.currentMonth,
      0,
    ).getDate();
    const firstDayIndex = new Date(
      this.currentYear,
      this.currentMonth - 1,
      1,
    ).getDay(); // 0 = Sunday

    let html = `
            <div class="calendar-grid">
                <div class="calendar-header-row">
                    <div class="calendar-header-cell">อา</div>
                    <div class="calendar-header-cell">จ</div>
                    <div class="calendar-header-cell">อ</div>
                    <div class="calendar-header-cell">พ</div>
                    <div class="calendar-header-cell">พฤ</div>
                    <div class="calendar-header-cell">ศ</div>
                    <div class="calendar-header-cell">ส</div>
                </div>
                <div class="calendar-body-rows">
        `;

    let day = 1;
    // 6 rows max to cover all possibilities
    for (let i = 0; i < 6; i++) {
      html += `<div class="calendar-row">`;
      for (let j = 0; j < 7; j++) {
        if (i === 0 && j < firstDayIndex) {
          html += `<div class="calendar-cell empty"></div>`;
        } else if (day > daysInMonth) {
          html += `<div class="calendar-cell empty"></div>`;
        } else {
          const dateStr = `${this.currentYear}-${String(this.currentMonth).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
          html += `
                        <div class="calendar-cell day" data-date="${dateStr}">
                            <span class="day-number">${day}</span>
                            <div class="events-container"></div>
                        </div>
                    `;
          day++;
        }
      }
      html += `</div>`;
      if (day > daysInMonth) break;
    }

    html += `
                </div>
            </div>
        `;

    this.containerEl.innerHTML = html;

    // Add click listeners to days
    this.containerEl.querySelectorAll(".calendar-cell.day").forEach((cell) => {
      cell.addEventListener("click", () => this.onDayClick(cell.dataset.date));
    });
  }

  updateEvents() {
    // Clear previous statuses
    this.containerEl.querySelectorAll(".calendar-cell.day").forEach((cell) => {
      cell.classList.remove(
        "status-approved",
        "status-pending",
        "status-rejected",
      );
    });

    this.bookings.forEach((booking) => {
      if (!booking.start || !booking.end) return;

      // booking.start is "YYYY-MM-DD HH:mm:ss"
      let startDate = new Date(booking.start.replace(" ", "T"));
      let endDate = new Date(booking.end.replace(" ", "T"));

      // Check for Invalid Date
      if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
        console.warn("Invalid booking dates:", booking);
        return;
      }

      startDate.setHours(0, 0, 0, 0);
      endDate.setHours(0, 0, 0, 0);

      let loopDate = new Date(startDate);
      while (loopDate <= endDate) {
        if (
          loopDate.getMonth() + 1 === this.currentMonth &&
          loopDate.getFullYear() === this.currentYear
        ) {
          const dateStr = `${loopDate.getFullYear()}-${String(loopDate.getMonth() + 1).padStart(2, "0")}-${String(loopDate.getDate()).padStart(2, "0")}`;
          const cell = this.containerEl.querySelector(
            `.calendar-cell[data-date="${dateStr}"]`,
          );

          if (cell) {
            let newStatus = "pending";
            if (booking.approved === "อนุมัติ") {
              newStatus = "approved";
            } else if (booking.approved === "ไม่อนุมัติ") {
              newStatus = "rejected";
            }

            // Apply priority logic
            if (newStatus === "approved") {
              cell.classList.remove("status-pending", "status-rejected");
              cell.classList.add("status-approved");
            } else if (newStatus === "pending") {
              // Don't overwrite Approved with Pending
              if (!cell.classList.contains("status-approved")) {
                cell.classList.remove("status-rejected");
                cell.classList.add("status-pending");
              }
            } else if (newStatus === "rejected") {
              // Only show Rejected if no other status is present
              if (
                !cell.classList.contains("status-approved") &&
                !cell.classList.contains("status-pending")
              ) {
                cell.classList.add("status-rejected");
              }
            }
          }
        }
        loopDate.setDate(loopDate.getDate() + 1);
      }
    });
  }

  onDayClick(dateStr) {
    // Find bookings for this day (Safer Date Parsing)
    const [cy, cm, cd] = dateStr.split("-").map(Number);
    const clickDate = new Date(cy, cm - 1, cd);
    clickDate.setHours(0, 0, 0, 0);

    const dayBookings = this.bookings.filter((booking) => {
      if (!booking.start || !booking.end) return false;

      // Extract YMD part only
      const sParts = booking.start.split(" ")[0].split("-");
      const eParts = booking.end.split(" ")[0].split("-");

      const bStart = new Date(
        Number(sParts[0]),
        Number(sParts[1]) - 1,
        Number(sParts[2]),
      );
      const bEnd = new Date(
        Number(eParts[0]),
        Number(eParts[1]) - 1,
        Number(eParts[2]),
      );

      bStart.setHours(0, 0, 0, 0);
      bEnd.setHours(0, 0, 0, 0);

      return (
        clickDate.getTime() >= bStart.getTime() &&
        clickDate.getTime() <= bEnd.getTime()
      );
    });

    console.log(
      `Date: ${dateStr}, BookingsFound: ${dayBookings.length}`,
      dayBookings,
    );

    if (dayBookings.length > 0) {
      let html = '<div class="text-start">';
      dayBookings.forEach((b) => {
        let statusColor = "text-secondary";
        let statusText = b.approved;
        let bgClass = "bg-label-secondary";

        if (b.approved === "อนุมัติ") {
          statusColor = "text-success";
          bgClass = "bg-label-success";
          statusText = '<i class="bx bx-check-circle"></i> อนุมัติ';
        } else if (b.approved === "รอตรวจสอบ") {
          statusColor = "text-warning";
          bgClass = "bg-label-warning";
          statusText = '<i class="bx bx-time"></i> รอตรวจสอบ';
        } else if (b.approved === "ไม่อนุมัติ") {
          statusColor = "text-danger";
          bgClass = "bg-label-danger";
          statusText = '<i class="bx bx-x-circle"></i> ไม่อนุมัติ';
        }

        let editButton = "";
        const currentIdStr = String(
          typeof CURRENT_USER_ID !== "undefined" ? CURRENT_USER_ID : "",
        ).trim();
        const ownerIdStr = String(b.member_id || "").trim();
        const isAdmin =
          typeof IS_ADMIN !== "undefined" &&
          (IS_ADMIN === true || String(IS_ADMIN) === "true");

        // Show button if Admin OR (Owner AND Not Approved)
        const isApproved = b.approved === "อนุมัติ";

        if (
          isAdmin ||
          (currentIdStr !== "" && currentIdStr === ownerIdStr && !isApproved)
        ) {
          editButton = `
                        <div class="mt-2 text-end border-top pt-2">
                            <a href="${BASE_URL}CarBooking/Edit/${b.id}" class="btn btn-sm btn-outline-primary">
                                <i class='bx bx-edit'></i> แก้ไขข้อมูล
                            </a>
                        </div>
                    `;
        }

        html += `
                    <div class="card mb-3 border shadow-sm">
                        <div class="card-body p-3 text-start">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge ${bgClass}">${statusText}</span>
                                <span class="badge bg-label-secondary"><i class='bx bx-time'></i> ${b.start.split(" ")[1].substring(0, 5)} - ${b.end.split(" ")[1].substring(0, 5)}</span>
                            </div>

                            <h6 class="card-title text-primary mb-1 fw-bold"><i class='bx bxs-pin'></i> ${b.location}</h6>
                            <p class="mb-2 text-dark" style="font-size: 0.9rem;">
                                <span class="fw-semibold">ภารกิจ:</span> ${b.detail}
                            </p>

                            <div class="bg-light p-2 rounded mb-2" style="font-size: 0.85rem;">
                                <div class="mb-1"><i class='bx bxs-car text-muted'></i> ${b.car_info || "-"}</div>
                                <div class="d-flex justify-content-between">
                                    <span><i class='bx bxs-user-circle text-muted'></i> ${b.booker_name || "-"}</span>
                                    <span><i class='bx bxs-group text-muted'></i> ${b.passenger || "0"} คน</span>
                                </div>
                            </div>
                           
                            ${editButton}
                        </div>
                    </div>
                `;
      });
      html += "</div>";

      Swal.fire({
        title: `รายการจองวันที่ ${this.formatThaiDate(dateStr)}`,
        html: html,
        showCancelButton: true,
        confirmButtonText: "จองวันนี้",
        cancelButtonText: "ปิด",
        confirmButtonColor: "#696cff",
        cancelButtonColor: "#8592a3",
      }).then((result) => {
        if (result.isConfirmed) {
          // Check Login first before redirecting to Add
          if (!CURRENT_USER_ID || CURRENT_USER_ID === "") {
            this.showLoginPrompt();
          } else {
            window.location.href = `${BASE_URL}CarBooking/Add/${this.locationId}?date=${dateStr}`;
          }
        }
      });
    } else {
      // No bookings, go to booking form (Check Login First)
      if (!CURRENT_USER_ID || CURRENT_USER_ID === "") {
        this.showLoginPrompt();
      } else {
        window.location.href = `${BASE_URL}CarBooking/Add/${this.locationId}?date=${dateStr}`;
      }
    }
  }

  showLoginPrompt() {
    Swal.fire({
      title: "กรุณาเข้าสู่ระบบ",
      text: "ท่านต้องเข้าสู่ระบบก่อนใช้งานระบบจอง",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "เข้าสู่ระบบ",
      cancelButtonText: "ยกเลิก",
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href =
          BASE_URL +
          "LoginOfficerGeneral?return_to=" +
          encodeURIComponent(window.location.href);
      }
    });
  }

  formatThaiDate(dateStr) {
    const date = new Date(dateStr);
    const months = [
      "ม.ค.",
      "ก.พ.",
      "มี.ค.",
      "เม.ย.",
      "พ.ค.",
      "มิ.ย.",
      "ก.ค.",
      "ส.ค.",
      "ก.ย.",
      "ต.ค.",
      "พ.ย.",
      "ธ.ค.",
    ];
    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const miniCalendarContainers = document.querySelectorAll(".mini-calendar");
  miniCalendarContainers.forEach((container) => {
    const locationId = container.id.replace("miniCalendar_", "");
    new MiniCalendar(locationId, container);
  });
});
