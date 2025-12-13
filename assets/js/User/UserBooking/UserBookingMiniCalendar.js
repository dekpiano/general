class MiniCalendar {
    constructor(locationId, containerEl) {
        this.locationId = locationId;
        this.containerEl = containerEl;
        this.currentMonth = new Date().getMonth() + 1; // 1-12
        this.currentYear = new Date().getFullYear();
        this.bookings = [];
        
        this.init();
    }

    init() {
        this.monthSelector = document.querySelector(`.month-selector[data-location-id="${this.locationId}"]`);
        this.yearSelector = document.querySelector(`.year-selector[data-location-id="${this.locationId}"]`);

        if (this.monthSelector) this.monthSelector.value = this.currentMonth;
        if (this.yearSelector) this.yearSelector.value = this.currentYear;

        if (this.monthSelector) {
            this.monthSelector.addEventListener('change', () => this.onDateChange());
        }
        if (this.yearSelector) {
            this.yearSelector.addEventListener('change', () => this.onDateChange());
        }

        this.render();
        this.fetchBookings();
    }

    onDateChange() {
        if (this.monthSelector) this.currentMonth = parseInt(this.monthSelector.value);
        if (this.yearSelector) this.currentYear = parseInt(this.yearSelector.value);
        this.render();
        this.fetchBookings();
    }

    fetchBookings() {
        fetch(`${BASE_URL}Booking/getBookingCalendarJson?month=${this.currentMonth}&year=${this.currentYear}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    this.bookings = data.bookings[this.locationId] || [];
                    this.updateEvents();
                }
            })
            .catch(err => console.error('Error fetching bookings:', err));
    }

    render() {
        const daysInMonth = new Date(this.currentYear, this.currentMonth, 0).getDate();
        const firstDayIndex = new Date(this.currentYear, this.currentMonth - 1, 1).getDay(); // 0 = Sunday

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
                    const dateStr = `${this.currentYear}-${String(this.currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
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
        this.containerEl.querySelectorAll('.calendar-cell.day').forEach(cell => {
            cell.addEventListener('click', () => this.onDayClick(cell.dataset.date));
        });
    }

    updateEvents() {
        // Clear previous statuses
        this.containerEl.querySelectorAll('.calendar-cell.day').forEach(cell => {
            cell.classList.remove('status-approved', 'status-pending', 'status-rejected');
        });

        this.bookings.forEach(booking => {
            let startDate = new Date(booking.booking_dateStart);
            let endDate = new Date(booking.booking_dateEnd);
            
            startDate.setHours(0,0,0,0);
            endDate.setHours(0,0,0,0);

            let loopDate = new Date(startDate);
            while (loopDate <= endDate) {
                if (loopDate.getMonth() + 1 === this.currentMonth && loopDate.getFullYear() === this.currentYear) {
                    const dateStr = `${loopDate.getFullYear()}-${String(loopDate.getMonth() + 1).padStart(2, '0')}-${String(loopDate.getDate()).padStart(2, '0')}`;
                    const cell = this.containerEl.querySelector(`.calendar-cell[data-date="${dateStr}"]`);
                    
                    if (cell) {
                        // Determine priority: Approved > Pending > Rejected
                        let currentStatus = null;
                        if (cell.classList.contains('status-approved')) currentStatus = 'approved';
                        else if (cell.classList.contains('status-pending')) currentStatus = 'pending';
                        else if (cell.classList.contains('status-rejected')) currentStatus = 'rejected';

                        let newStatus = 'rejected';
                        if (booking.booking_admin_approve === 'อนุมัติ') newStatus = 'approved';
                        else if (booking.booking_admin_approve === 'รอตรวจสอบ') newStatus = 'pending';

                        // Apply logic
                        if (newStatus === 'approved') {
                            cell.classList.remove('status-pending', 'status-rejected');
                            cell.classList.add('status-approved');
                        } else if (newStatus === 'pending') {
                            if (currentStatus !== 'approved') {
                                cell.classList.remove('status-rejected');
                                cell.classList.add('status-pending');
                            }
                        } else if (newStatus === 'rejected') {
                            if (!currentStatus) {
                                cell.classList.add('status-rejected');
                            }
                        }
                    }
                }
                loopDate.setDate(loopDate.getDate() + 1);
            }
        });
    }

    onDayClick(dateStr) {
        // Find bookings for this day
        const dayBookings = this.bookings.filter(booking => {
            const start = new Date(booking.booking_dateStart);
            const end = new Date(booking.booking_dateEnd);
            const check = new Date(dateStr);
            start.setHours(0,0,0,0);
            end.setHours(0,0,0,0);
            check.setHours(0,0,0,0);
            return check >= start && check <= end;
        });

        if (dayBookings.length > 0) {
            let html = '<div class="text-start">';
            dayBookings.forEach(b => {
                let statusColor = 'text-secondary';
                let statusText = b.booking_admin_approve;
                if (b.booking_admin_approve === 'อนุมัติ') {
                    statusColor = 'text-success';
                    statusText = '<i class="bx bx-check-circle"></i> อนุมัติแล้ว';
                } else if (b.booking_admin_approve === 'รอตรวจสอบ') {
                    statusColor = 'text-warning';
                    statusText = '<i class="bx bx-time"></i> รอตรวจสอบ';
                } else if (b.booking_admin_approve === 'ไม่อนุมัติ') {
                    statusColor = 'text-danger';
                    statusText = '<i class="bx bx-x-circle"></i> ไม่อนุมัติ';
                }

                let equipmentHtml = '';
                if(b.booking_equipment) {
                    equipmentHtml = `<div class="mt-1"><small class="text-muted"><i class='bx bx-devices'></i> ${b.booking_equipment.replace(/\|/g, ', ')}</small></div>`;
                }
                
                let noteHtml = '';
                if(b.booking_other) {
                    noteHtml = `<div class="mt-1"><small class="text-muted"><i class='bx bx-note'></i> ${b.booking_other}</small></div>`;
                }

                let editButton = '';
                // Check if current user is the booker
                if (typeof CURRENT_USER_ID !== 'undefined' && CURRENT_USER_ID && String(b.booking_Booker) === String(CURRENT_USER_ID)) {
                    editButton = `
                        <div class="mt-2 text-end border-top pt-2">
                            <a href="${BASE_URL}Booking/Edit/${b.booking_id}" class="btn btn-sm btn-outline-primary">
                                <i class='bx bx-edit'></i> แก้ไข
                            </a>
                        </div>
                    `;
                }

                html += `
                    <div class="card mb-3 border shadow-none">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-1 text-primary">${b.booking_title}</h6>
                            <div class="mb-2">
                                <span class="badge bg-label-secondary me-1"><i class='bx bx-time'></i> ${b.booking_timeStart.substring(0,5)} - ${b.booking_timeEnd.substring(0,5)}</span>
                                <span class="${statusColor} fw-bold">${statusText}</span>
                            </div>
                            <div class="small text-muted mb-1">
                                <i class='bx bx-user'></i> ${b.pers_prefix}${b.pers_firstname} ${b.pers_lastname}
                                <span class="ms-2"><i class='bx bx-phone'></i> ${b.booking_telephone}</span>
                            </div>
                            <div class="small text-muted">
                                <i class='bx bx-category'></i> ${b.booking_typeuse}
                            </div>
                            ${equipmentHtml}
                            ${noteHtml}
                            ${editButton}
                        </div>
                    </div>
                `;
            });
            html += '</div>';

            Swal.fire({
                title: `รายการจองวันที่ ${this.formatThaiDate(dateStr)}`,
                html: html,
                showCancelButton: true,
                confirmButtonText: 'จองวันนี้',
                cancelButtonText: 'ปิด',
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3'
            }).then((result) => {
                if (result.isConfirmed) {
                     // Check Login first before redirecting to Add
                     if (!CURRENT_USER_ID || CURRENT_USER_ID === '') {
                        this.showLoginPrompt();
                     } else {
                        window.location.href = `${BASE_URL}Booking/Add/${this.locationId}?date=${dateStr}`;
                     }
                }
            });
        } else {
            // No bookings, go to booking form (Check login first)
            if (!CURRENT_USER_ID || CURRENT_USER_ID === '') {
                this.showLoginPrompt();
            } else {
                window.location.href = `${BASE_URL}Booking/Add/${this.locationId}?date=${dateStr}`;
            }
        }
    }

    showLoginPrompt() {
        Swal.fire({
            title: 'กรุณาเข้าสู่ระบบ',
            text: "ท่านต้องเข้าสู่ระบบก่อนใช้งานระบบจอง",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'เข้าสู่ระบบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                 window.location.href = BASE_URL + 'LoginOfficerGeneral?return_to=' + encodeURIComponent(window.location.href);
            }
        });
    }

    formatThaiDate(dateStr) {
        const date = new Date(dateStr);
        const months = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const miniCalendarContainers = document.querySelectorAll('.mini-calendar');
    miniCalendarContainers.forEach(container => {
        const locationId = container.id.replace('miniCalendar_', '');
        new MiniCalendar(locationId, container);
    });
});
