<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --car-primary: #696cff;
        --car-primary-light: #8385ff;
        --car-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(105, 108, 255, 0.1);
        --card-shadow: 0 4px 20px -4px rgba(105, 108, 255, 0.12);
        --success: #71dd37;
        --danger: #ff3e1d;
        --warning: #ffab00;
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    .premium-animate {
        animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Page Header (compact for mobile) --- */
    .page-header-mobile {
        background: var(--car-gradient);
        border-radius: 16px;
        padding: 1.25rem 1rem;
        margin-bottom: 1rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 10px 30px -8px rgba(105, 108, 255, 0.35);
    }
    .page-header-mobile::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -15%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
        border-radius: 50%;
    }
    .page-header-mobile .header-inner {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .page-header-mobile h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff !important;
    }
    .page-header-mobile .breadcrumb {
        margin-bottom: 0.25rem;
        font-size: 0.75rem;
        background: transparent !important;
    }
    .page-header-mobile .breadcrumb a { color: rgba(255,255,255,0.6) !important; text-decoration: none; }
    .page-header-mobile .breadcrumb-item.active { color: #fff !important; }
    .page-header-mobile .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.4) !important; }

    /* --- Search & Controls --- */
    .controls-bar {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        align-items: center;
    }
    .search-box {
        flex: 1;
        position: relative;
    }
    .search-box input {
        width: 100%;
        padding: 0.6rem 0.75rem 0.6rem 2.5rem;
        border: 2px solid var(--glass-border);
        border-radius: 12px;
        font-size: 0.85rem;
        background: var(--glass-bg);
        transition: border-color 0.2s;
        outline: none;
    }
    .search-box input:focus {
        border-color: var(--car-primary);
        box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.12);
    }
    .search-box .search-icon {
        position: absolute;
        left: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 1rem;
    }
    .btn-refresh-mobile {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--glass-border);
        background: var(--glass-bg);
        color: var(--car-primary);
        font-size: 1.1rem;
        transition: all 0.2s;
        flex-shrink: 0;
        cursor: pointer;
    }
    .btn-refresh-mobile:hover { background: var(--car-primary); color: #fff; }

    /* --- Booking Cards --- */
    .booking-cards-container {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .booking-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 0.7rem;
        box-shadow: var(--card-shadow);
        transition: all 0.25s ease;
        animation: fadeInUp 0.4s ease forwards;
        position: relative;
        overflow: hidden;
    }
    .booking-card:active {
        transform: scale(0.98);
    }

    /* Status stripe on left */
    .booking-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        border-radius: 12px 0 0 12px;
    }
    .booking-card.status-pending::before { background: var(--warning); }
    .booking-card.status-approved::before { background: var(--success); }
    .booking-card.status-rejected::before { background: var(--danger); }

    /* Card Top Row: status + order number */
    .card-top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.4rem;
    }

    .status-pill {
        padding: 3px 8px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.65rem;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    .status-pill.pending { background: rgba(255,171,0,0.12); color: #c88600; }
    .status-pill.approved { background: rgba(113,221,55,0.12); color: #4a9c1a; }
    .status-pill.rejected { background: rgba(255,62,29,0.12); color: #cc2e13; }

    .card-order-no {
        font-size: 0.65rem;
        color: #aaa;
        font-weight: 500;
    }

    /* Card Body: car info row */
    .card-car-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.4rem;
    }
    .card-car-img {
        width: 48px;
        height: 36px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eee;
        flex-shrink: 0;
    }
    .card-car-text {
        flex: 1;
        min-width: 0;
    }
    .card-car-text .car-name {
        font-weight: 700;
        font-size: 0.78rem;
        color: var(--car-primary);
        word-wrap: break-word;
        overflow-wrap: break-word;
        line-height: 1.25;
    }
    .card-car-text .car-plate {
        font-size: 0.7rem;
        color: #555;
        font-weight: 600;
    }

    /* Card compact details */
    .card-details-compact {
        display: flex;
        flex-wrap: wrap;
        gap: 0.15rem 0.75rem;
        margin-bottom: 0.4rem;
        font-size: 0.7rem;
        color: #666;
    }
    .card-details-compact .cd-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .card-details-compact .cd-item i {
        color: var(--car-primary);
        font-size: 0.78rem;
    }
    .card-details-compact .cd-item span {
        font-weight: 600;
        color: #444;
    }
    .card-details-compact .cd-full {
        width: 100%;
    }

    /* Card actions */
    .card-actions {
        display: flex;
        gap: 0.4rem;
        padding-top: 0.4rem;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    .card-actions .btn-card-action {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
        padding: 0.35rem 0.4rem;
        border-radius: 8px;
        font-size: 0.68rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    .card-actions .btn-card-action:active { transform: scale(0.96); }
    .btn-card-edit { background: rgba(255,171,0,0.12); color: #c88600; }
    .btn-card-print { background: rgba(3,195,236,0.12); color: #03a9cc; }
    .btn-card-cancel { background: rgba(255,62,29,0.1); color: #e03517; }

    /* Pagination */
    .mobile-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.35rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }
    .mobile-pagination .page-btn {
        min-width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1px solid var(--glass-border);
        background: #fff;
        color: #666;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .mobile-pagination .page-btn:hover { border-color: var(--car-primary); color: var(--car-primary); }
    .mobile-pagination .page-btn.active {
        background: var(--car-primary);
        color: #fff;
        border-color: var(--car-primary);
    }
    .mobile-pagination .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

    .page-info-text {
        font-size: 0.72rem;
        color: #999;
        text-align: center;
        margin-top: 0.5rem;
    }

    /* Loading skeleton */
    .skeleton-card {
        background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 14px;
        height: 140px;
        margin-bottom: 0.75rem;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #bbb;
    }
    .empty-state i { font-size: 3rem; margin-bottom: 0.75rem; display: block; color: #ddd; }
    .empty-state p { font-size: 0.85rem; margin: 0; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Compact Mobile Header -->
    <div class="page-header-mobile premium-animate">
        <div class="header-inner">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="<?=base_url('CarBooking');?>">จองยานพาหนะ</a></li>
                        <li class="breadcrumb-item active">ตารางการใช้รถ</li>
                    </ol>
                </nav>
                <h5>ตารางจองยานพาหนะ</h5>
            </div>
            <i class='bx bxs-car' style="font-size:2rem; opacity:0.4;"></i>
        </div>
    </div>

    <!-- Search & Refresh -->
    <div class="controls-bar premium-animate" style="animation-delay: 0.05s">
        <div class="search-box">
            <i class='bx bx-search search-icon'></i>
            <input type="text" id="searchInput" placeholder="ค้นหา เลขที่จอง, ปลายทาง, ทะเบียน..." autocomplete="off">
        </div>
        <button class="btn-refresh-mobile" id="btnRefresh" title="รีเฟรช">
            <i class='bx bx-refresh'></i>
        </button>
    </div>

    <!-- Cards Container -->
    <div id="bookingCardsContainer" class="booking-cards-container premium-animate" style="animation-delay: 0.1s">
        <!-- Loading skeletons -->
        <div class="skeleton-card"></div>
        <div class="skeleton-card"></div>
        <div class="skeleton-card"></div>
    </div>

    <!-- Pagination -->
    <div id="paginationContainer" class="mobile-pagination"></div>
    <div id="pageInfoText" class="page-info-text"></div>

</div>
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
$(document).ready(function() {
    const CURRENT_USER_ID = '<?= @$_SESSION['id'] ?? '' ?>';
    const BASE_URL_EDIT = '<?= base_url('CarBooking/Edit/') ?>';
    const BASE_URL_PRINT = '<?= base_url('CarBooking/Approve/Admin/Print/') ?>';
    const BASE_URL_CANCEL = '<?= base_url('CarBooking/Cancel') ?>';
    const BASE_URL_CAR_IMG = '<?= base_url('uploads/admin/Car/') ?>';
    const FALLBACK_IMG = '<?= base_url('assets/img/elements/1.jpg') ?>';
    const DATA_URL = '<?= base_url('CarBooking/DB/DataTable/View') ?>';

    let allData = [];
    let filteredData = [];
    let currentPage = 1;
    const perPage = 10;

    // Load data
    function loadData() {
        $('#bookingCardsContainer').html(`
            <div class="skeleton-card"></div>
            <div class="skeleton-card"></div>
            <div class="skeleton-card"></div>
        `);
        $('#paginationContainer').html('');
        $('#pageInfoText').html('');

        $.ajax({
            url: DATA_URL,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                allData = response.aaData || response.data || [];
                currentPage = 1;
                applyFilter();
            },
            error: function() {
                $('#bookingCardsContainer').html(`
                    <div class="empty-state">
                        <i class='bx bx-error-circle'></i>
                        <p>ไม่สามารถโหลดข้อมูลได้ กรุณาลองใหม่</p>
                    </div>
                `);
            }
        });
    }

    // Search filter
    function applyFilter() {
        const query = $('#searchInput').val().toLowerCase().trim();
        if (query === '') {
            filteredData = [...allData];
        } else {
            filteredData = allData.filter(row => {
                return (row.car_reserv_order || '').toLowerCase().includes(query) ||
                       (row.Member || '').toLowerCase().includes(query) ||
                       (row.car_registration || '').toLowerCase().includes(query) ||
                       (row.car_reserv_location || '').toLowerCase().includes(query) ||
                       (row.car_reserv_detail || '').toLowerCase().includes(query) ||
                       (row.car_reserv_status || '').toLowerCase().includes(query) ||
                       (row.car_category || '').toLowerCase().includes(query) ||
                       (row.Date || '').toLowerCase().includes(query);
            });
        }
        currentPage = 1;
        renderCards();
    }

    // Render cards
    function renderCards() {
        const container = $('#bookingCardsContainer');
        const totalItems = filteredData.length;
        const totalPages = Math.ceil(totalItems / perPage) || 1;
        const startIdx = (currentPage - 1) * perPage;
        const endIdx = Math.min(startIdx + perPage, totalItems);
        const pageData = filteredData.slice(startIdx, endIdx);

        if (pageData.length === 0) {
            container.html(`
                <div class="empty-state">
                    <i class='bx bx-car'></i>
                    <p>ไม่พบรายการจองยานพาหนะ</p>
                </div>
            `);
            $('#paginationContainer').html('');
            $('#pageInfoText').html('');
            return;
        }

        let html = '';
        pageData.forEach((row, idx) => {
            const status = row.car_reserv_status || '';
            let statusClass = 'pending';
            let pillClass = 'pending';
            let icon = 'bx-hourglass';
            if (status === 'อนุมัติ') { statusClass = 'approved'; pillClass = 'approved'; icon = 'bx-check-circle'; }
            else if (status === 'ไม่อนุมัติ') { statusClass = 'rejected'; pillClass = 'rejected'; icon = 'bx-x-circle'; }

            const isApproved = status === 'อนุมัติ';
            const isPending = status === 'รอตรวจสอบ';
            const isOwner = row.car_reserv_memberID == CURRENT_USER_ID;

            // Build action buttons
            let actions = '';
            if (isPending && isOwner) {
                actions += `<a href="${BASE_URL_EDIT}${row.car_reserv_id}" class="btn-card-action btn-card-edit"><i class='bx bx-edit'></i>แก้ไข</a>`;
            }
            if (isApproved) {
                actions += `<a href="${BASE_URL_PRINT}${row.car_reserv_id}" target="_blank" class="btn-card-action btn-card-print"><i class='bx bx-printer'></i>พิมพ์ใบงาน</a>`;
            }
            if (isPending && isOwner) {
                actions += `<button type="button" class="btn-card-action btn-card-cancel btn-cancel-car" data-id="${row.car_reserv_id}"><i class='bx bx-trash'></i>ยกเลิก</button>`;
            }

            html += `
            <div class="booking-card status-${statusClass}" style="animation-delay:${idx * 0.04}s">
                <!-- Top Row: Status + Order -->
                <div class="card-top-row">
                    <span class="status-pill ${pillClass}"><i class='bx ${icon}'></i>${status}</span>
                    <span class="card-order-no">${row.car_reserv_order || ''}</span>
                </div>

                <!-- Car Info -->
                <div class="card-car-info">
                    <img class="card-car-img" src="${BASE_URL_CAR_IMG}${row.car_img}" onerror="this.src='${FALLBACK_IMG}'">
                    <div class="card-car-text">
                        <div class="car-name">${row.car_category || ''}</div>
                        <div class="car-plate">${row.car_registration || ''}</div>
                    </div>
                </div>

                <!-- Compact Details -->
                <div class="card-details-compact">
                    <div class="cd-item"><i class='bx bx-user'></i><span>${row.Member || '-'}</span></div>
                    <div class="cd-item"><i class='bx bx-calendar'></i><span>${row.Date || '-'}</span></div>
                    <div class="cd-item cd-full"><i class='bx bx-map'></i><span>${row.car_reserv_location || '-'}${row.car_reserv_detail ? ' — ' + row.car_reserv_detail : ''}</span></div>
                </div>

                ${actions ? '<div class="card-actions">' + actions + '</div>' : ''}
            </div>`;
        });

        container.html(html);

        // Render pagination
        renderPagination(totalPages, totalItems, startIdx + 1, endIdx);
    }

    // Render pagination
    function renderPagination(totalPages, totalItems, from, to) {
        if (totalPages <= 1) {
            $('#paginationContainer').html('');
            $('#pageInfoText').html(`แสดง ${totalItems} รายการ`);
            return;
        }

        let html = '';
        html += `<button class="page-btn" data-page="prev" ${currentPage === 1 ? 'disabled' : ''}><i class='bx bx-chevron-left'></i></button>`;

        // Smart page numbers
        let pages = [];
        if (totalPages <= 5) {
            for (let i = 1; i <= totalPages; i++) pages.push(i);
        } else {
            pages.push(1);
            if (currentPage > 3) pages.push('...');
            for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
                pages.push(i);
            }
            if (currentPage < totalPages - 2) pages.push('...');
            pages.push(totalPages);
        }

        pages.forEach(p => {
            if (p === '...') {
                html += `<span class="page-btn" style="border:none; cursor:default;">…</span>`;
            } else {
                html += `<button class="page-btn ${p === currentPage ? 'active' : ''}" data-page="${p}">${p}</button>`;
            }
        });

        html += `<button class="page-btn" data-page="next" ${currentPage === totalPages ? 'disabled' : ''}><i class='bx bx-chevron-right'></i></button>`;

        $('#paginationContainer').html(html);
        $('#pageInfoText').html(`แสดง ${from}–${to} จาก ${totalItems} รายการ`);
    }

    // Events
    let searchTimer;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(applyFilter, 300);
    });

    $('#btnRefresh').on('click', function() {
        $(this).find('i').addClass('bx-spin');
        loadData();
        setTimeout(() => $(this).find('i').removeClass('bx-spin'), 800);
    });

    $(document).on('click', '.page-btn:not(:disabled)', function() {
        const page = $(this).data('page');
        const totalPages = Math.ceil(filteredData.length / perPage) || 1;
        if (page === 'prev') { currentPage = Math.max(1, currentPage - 1); }
        else if (page === 'next') { currentPage = Math.min(totalPages, currentPage + 1); }
        else if (typeof page === 'number') { currentPage = page; }
        else { return; }
        renderCards();
        // Scroll to top of cards
        document.getElementById('bookingCardsContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // Cancel booking
    $(document).on('click', '.btn-cancel-car', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ยกเลิกการจอง?',
            text: "ท่านต้องการยกเลิกคำขอจองยานพาหนะนี้ใช่หรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ยืนยันยกเลิก',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL_CANCEL,
                    type: 'POST',
                    data: { car_reserv_id: id },
                    success: function(response) {
                        if (response.status === 'success' || response == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'ยกเลิกสำเร็จ',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                loadData();
                            });
                        } else {
                            Swal.fire('ผิดพลาด', 'ไม่สามารถยกเลิกได้ กรุณาลองใหม่', 'error');
                        }
                    }
                });
            }
        });
    });

    // Initial load
    loadData();
});
</script>
<?= $this->endSection() ?>
