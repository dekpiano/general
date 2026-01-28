$(document).ready(function() {
    function fetchNotifications() {
        const list = $('#notification-list');
        const badge = $('#notification-badge');

        if (!list.length) return; 

        // Detect current system from URL
        let currentSystem = '';
        const path = window.location.pathname;
        if (path.includes('CarBooking')) {
            currentSystem = 'car';
        } else if (path.includes('Booking')) {
            currentSystem = 'room';
        } else if (path.includes('Repair')) {
            currentSystem = 'repair';
        }

        $.ajax({
            url: BASE_URL + '/Admin/Notifications/getPending',
            method: 'GET',
            data: { system: currentSystem },
            dataType: 'json',
            cache: false, // Prevent caching issues on mobile
            success: function(response) {
                list.empty();
                if (response.status === 'success') {
                    const data = response.data;
                    const totalCount = response.totalCount;

                    // Update all badge instances (ID and Class)
                    const allBadges = $('#notification-badge, .badge-notifications');
                    if (totalCount > 0) {
                        allBadges.text(totalCount).fadeIn(200);
                        
                        // Set App Badge (PWA Icon Badge)
                        if ('setAppBadge' in navigator) {
                            navigator.setAppBadge(totalCount).catch((error) => {
                                console.error('App badge error:', error);
                            });
                        }
                    } else {
                        allBadges.hide();
                        
                        // Clear App Badge
                        if ('clearAppBadge' in navigator) {
                            navigator.clearAppBadge().catch((error) => {
                                console.error('App badge clear error:', error);
                            });
                        }
                    }

                    // Update dropdown header if exists
                    const header = $('.dropdown-notifications-all-count');
                    if (header.length) header.text(totalCount);

                    let hasData = false;
                    
                    const systems = [
                        { key: 'car', label: 'งานยานพาหนะ', icon: 'bi-truck' },
                        { key: 'room', label: 'งานอาคารสถานที่', icon: 'bi-building' },
                        { key: 'repair', label: 'งานแจ้งซ่อม', icon: 'bi-tools' }
                    ];

                    systems.forEach(sys => {
                        const items = data[sys.key];
                        if (items && items.length > 0) {
                            hasData = true;
                            list.append(`
                                <li class="dropdown-header d-flex align-items-center py-2 bg-light">
                                    <i class="bi ${sys.icon} me-2 text-primary"></i>
                                    <span class="text-uppercase fw-bold small text-primary">${sys.label}</span>
                                </li>
                            `);

                            items.forEach(noti => {
                                let iconClass = noti.icon || 'bi-info-circle';
                                let colorClass = noti.color || 'bg-primary';
                                
                                let item = `
                                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                        <a class="d-flex align-items-center py-2" href="${noti.link}">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <span class="avatar-initial rounded-circle ${colorClass}">
                                                        <i class="bi ${iconClass}"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold text-wrap" style="max-width: 250px; font-size: 0.85rem;">${noti.title}</h6>
                                                <small class="text-muted d-block" style="font-size: 0.75rem;">${noti.time}</small>
                                            </div>
                                        </a>
                                    </li>
                                `;
                                list.append(item);
                            });
                        }
                    });

                    if (!hasData) {
                        list.append('<li><div class="dropdown-item text-center py-4"><i class="bi bi-check2-circle fs-2 text-success d-block mb-2"></i>ไม่มีรายการรออนุมัติ</div></li>');
                    } else {
                        list.append(`
                            <li class="dropdown-menu-footer border-top">
                                <a class="dropdown-item text-center text-primary fw-bold py-3" href="javascript:void(0);">
                                    ดูทั้งหมด (${totalCount})
                                </a>
                            </li>
                        `);
                    }
                } else {
                    allBadges.hide();
                    list.append(`<li><div class="dropdown-item text-center text-danger py-3">เกิดข้อผิดพลาด: ${response.message}</div></li>`);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching notifications:', error);
                badge.hide();
                list.empty();
                list.append(`<li><a class="dropdown-item text-center text-danger py-3" href="javascript:void(0);">ไม่สามารถโหลดแจ้งเตือนได้ (HTTP ${xhr.status})</a></li>`);
            }
        });
    }

    // Initial fetch
    fetchNotifications();

    // Polling every 1 minute
    setInterval(fetchNotifications, 60000);
});
