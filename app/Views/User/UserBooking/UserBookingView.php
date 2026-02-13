<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --bk-primary: #696cff;
        --bk-primary-light: #8385ff;
        --bk-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
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

    .premium-animate {
        animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Page Header (compact mobile) --- */
    .page-header-mobile {
        background: var(--bk-gradient);
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
        font-size: 1.05rem;
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
        border-color: var(--bk-primary);
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
        color: var(--bk-primary);
        font-size: 1.1rem;
        transition: all 0.2s;
        flex-shrink: 0;
        cursor: pointer;
    }
    .btn-refresh-mobile:hover { background: var(--bk-primary); color: #fff; }

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
        position: relative;
        overflow: hidden;
    }
    .booking-card:active { transform: scale(0.98); }

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

    /* Card Top Row */
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

    /* Location info row with image */
    .card-location-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.4rem;
    }
    .card-location-img {
        width: 48px;
        height: 36px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #eee;
        flex-shrink: 0;
    }
    .card-location-text {
        flex: 1;
        min-width: 0;
    }
    .card-location-text .loc-name {
        font-weight: 700;
        font-size: 0.78rem;
        color: var(--bk-primary);
        word-wrap: break-word;
        line-height: 1.25;
    }
    .card-location-text .book-title {
        font-size: 0.72rem;
        color: #555;
        word-wrap: break-word;
        line-height: 1.25;
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
        color: var(--bk-primary);
        font-size: 0.78rem;
    }
    .card-details-compact .cd-item span {
        font-weight: 600;
        color: #444;
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
    .card-actions .btn-card-action.disabled {
        opacity: 0.35;
        pointer-events: none;
    }
    .btn-card-edit { background: rgba(255,171,0,0.12); color: #c88600; }
    .btn-card-download { background: rgba(105,108,255,0.1); color: var(--bk-primary); }
    .btn-card-cancel { background: rgba(255,62,29,0.1); color: #e03517; }

    /* No data state */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #bbb;
    }
    .empty-state i { font-size: 3rem; margin-bottom: 0.75rem; display: block; color: #ddd; }
    .empty-state p { font-size: 0.85rem; margin: 0; }

    /* Hide cards via search/pagination */
    .booking-card.hidden-card { display: none; }

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
    .mobile-pagination .page-btn:hover { border-color: var(--bk-primary); color: var(--bk-primary); }
    .mobile-pagination .page-btn.active {
        background: var(--bk-primary);
        color: #fff;
        border-color: var(--bk-primary);
    }
    .mobile-pagination .page-btn:disabled { opacity: 0.4; cursor: not-allowed; }

    .page-info-text {
        font-size: 0.72rem;
        color: #999;
        text-align: center;
        margin-top: 0.5rem;
    }
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
                        <li class="breadcrumb-item"><a href="<?=base_url('Booking');?>">สถานที่</a></li>
                        <li class="breadcrumb-item active">ประวัติการจอง</li>
                    </ol>
                </nav>
                <h5>
                    <?php if($CheckAll == 1){ echo 'ข้อมูลการจองทั้งหมด'; }else{ echo 'การจอง: '.@$Booking[0]->location_name; }?>
                </h5>
            </div>
            <i class='bx bx-history' style="font-size:2rem; opacity:0.4;"></i>
        </div>
    </div>

    <!-- Search & Refresh -->
    <div class="controls-bar premium-animate" style="animation-delay: 0.05s">
        <div class="search-box">
            <i class='bx bx-search search-icon'></i>
            <input type="text" id="searchInput" placeholder="ค้นหา สถานที่, ผู้จอง, เรื่อง..." autocomplete="off">
        </div>
        <button class="btn-refresh-mobile" onclick="location.reload()" title="รีเฟรช">
            <i class='bx bx-refresh'></i>
        </button>
    </div>

    <!-- Cards Container -->
    <div id="bookingCardsContainer" class="booking-cards-container premium-animate" style="animation-delay: 0.1s">

        <?php if(empty($Booking)): ?>
            <div class="empty-state">
                <i class='bx bx-calendar-x'></i>
                <p>ไม่พบรายการจองสถานที่</p>
            </div>
        <?php else: ?>
            <?php foreach ($Booking as $idx => $v_Booking):
                // Status logic
                $status = $v_Booking->booking_admin_approve;
                $statusClass = 'pending';
                $pillClass = 'pending';
                $icon = 'bx-hourglass';
                if ($status == 'อนุมัติ') { $statusClass = 'approved'; $pillClass = 'approved'; $icon = 'bx-check-circle'; }
                elseif ($status == 'ไม่อนุมัติ' || $status == 'ยกเลิกโดยผู้จอง') { $statusClass = 'rejected'; $pillClass = 'rejected'; $icon = 'bx-x-circle'; }

                $isCancel = $status == "ยกเลิกโดยผู้จอง";
                $isApproved = $status == "อนุมัติ";
                $fullname = $v_Booking->pers_prefix . $v_Booking->pers_firstname . ' ' . $v_Booking->pers_lastname;
            ?>
            <div class="booking-card status-<?=$statusClass?>" data-search="<?= strtolower(
                $v_Booking->booking_title . ' ' .
                $v_Booking->location_name . ' ' .
                $fullname . ' ' .
                $v_Booking->booking_telephone . ' ' .
                $status
            ) ?>">

                <!-- Top Row: Status + Order -->
                <div class="card-top-row">
                    <span class="status-pill <?=$pillClass?>"><i class='bx <?=$icon?>'></i><?=$status?></span>
                    <span style="font-size:0.65rem; color:#aaa;"><?=$v_Booking->booking_order ?? ''?></span>
                </div>

                <!-- Location with Image -->
                <div class="card-location-row">
                    <img class="card-location-img" 
                         src="<?=base_url('uploads/admin/LocationRoom/'.($v_Booking->location_img ?? ''))?>" 
                         onerror="this.src='<?=base_url('assets/img/elements/1.jpg')?>'">
                    <div class="card-location-text">
                        <div class="loc-name"><?=$v_Booking->location_name?></div>
                        <div class="book-title"><?=$v_Booking->booking_title?></div>
                    </div>
                </div>

                <!-- Compact Details -->
                <div class="card-details-compact">
                    <div class="cd-item"><i class='bx bx-user'></i><span><?=$fullname?></span></div>
                    <div class="cd-item"><i class='bx bx-phone'></i><span><?=$v_Booking->booking_telephone?></span></div>
                    <div class="cd-item"><i class='bx bx-calendar'></i><span><?= $Datethai->thai_date_and_time_short(strtotime($v_Booking->booking_dateStart)) ?></span></div>
                    <div class="cd-item"><i class='bx bx-time'></i><span><?=date('H:i', strtotime($v_Booking->booking_timeStart))?>-<?=date('H:i', strtotime($v_Booking->booking_timeEnd))?> น.</span></div>
                </div>

                <!-- Actions -->
                <div class="card-actions">
                    <a target="_blank"
                       href="<?=base_url('Booking/Approve/File/Requestform/'.$v_Booking->booking_id)?>"
                       class="btn-card-action btn-card-download <?= $isApproved ? '' : 'disabled' ?>">
                        <i class='bx bx-download'></i>เอกสาร
                    </a>

                    <?php if(isset($_SESSION['username']) && !isset($All)) : ?>
                    <a href="<?=base_url('Booking/Edit/'.$v_Booking->booking_id)?>"
                       class="btn-card-action btn-card-edit <?= ($isCancel || $isApproved) ? 'disabled' : '' ?>">
                        <i class='bx bx-edit'></i>แก้ไข
                    </a>
                    <button type="button"
                            class="btn-card-action btn-card-cancel <?= $isApproved ? 'disabled' : '' ?> delete-btn"
                            key-id="<?=$v_Booking->booking_id?>">
                        <i class='bx bx-trash'></i>ยกเลิก
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <!-- Pagination -->
    <div id="paginationContainer" class="mobile-pagination"></div>
    <div id="pageInfoText" class="page-info-text"></div>

</div>
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
$(document).ready(function() {
    const perPage = 10;
    let currentPage = 1;
    let allCards = [];
    let filteredCards = [];

    // Collect all cards
    allCards = $('.booking-card').toArray();
    filteredCards = [...allCards];

    // Initial render
    renderPage();

    function renderPage() {
        // Hide all cards first
        $(allCards).addClass('hidden-card');
        $('#noSearchResult').remove();

        const totalItems = filteredCards.length;
        const totalPages = Math.ceil(totalItems / perPage) || 1;

        if (currentPage > totalPages) currentPage = totalPages;

        const startIdx = (currentPage - 1) * perPage;
        const endIdx = Math.min(startIdx + perPage, totalItems);

        if (totalItems === 0) {
            $('#paginationContainer').html('');
            $('#pageInfoText').html('');
            if ($('#noSearchResult').length === 0) {
                $('#bookingCardsContainer').append(`
                    <div class="empty-state" id="noSearchResult">
                        <i class='bx bx-search-alt'></i>
                        <p>ไม่พบผลลัพธ์</p>
                    </div>
                `);
            }
            return;
        }

        // Show only current page cards
        for (let i = startIdx; i < endIdx; i++) {
            $(filteredCards[i]).removeClass('hidden-card');
        }

        renderPagination(totalPages, totalItems, startIdx + 1, endIdx);
    }

    function renderPagination(totalPages, totalItems, from, to) {
        if (totalPages <= 1) {
            $('#paginationContainer').html('');
            $('#pageInfoText').html('แสดง ' + totalItems + ' รายการ');
            return;
        }

        let html = '';
        html += '<button class="page-btn" data-page="prev" ' + (currentPage === 1 ? 'disabled' : '') + '><i class="bx bx-chevron-left"></i></button>';

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

        pages.forEach(function(p) {
            if (p === '...') {
                html += '<span class="page-btn" style="border:none; cursor:default;">…</span>';
            } else {
                html += '<button class="page-btn ' + (p === currentPage ? 'active' : '') + '" data-page="' + p + '">' + p + '</button>';
            }
        });

        html += '<button class="page-btn" data-page="next" ' + (currentPage === totalPages ? 'disabled' : '') + '><i class="bx bx-chevron-right"></i></button>';

        $('#paginationContainer').html(html);
        $('#pageInfoText').html('แสดง ' + from + '–' + to + ' จาก ' + totalItems + ' รายการ');
    }

    // Pagination click
    $(document).on('click', '.page-btn:not(:disabled)', function() {
        const page = $(this).data('page');
        const totalPages = Math.ceil(filteredCards.length / perPage) || 1;
        if (page === 'prev') { currentPage = Math.max(1, currentPage - 1); }
        else if (page === 'next') { currentPage = Math.min(totalPages, currentPage + 1); }
        else if (typeof page === 'number') { currentPage = page; }
        else { return; }
        renderPage();
        document.getElementById('bookingCardsContainer').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    // Search filter
    let searchTimer;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            const query = $('#searchInput').val().toLowerCase().trim();
            if (query === '') {
                filteredCards = [...allCards];
            } else {
                filteredCards = allCards.filter(function(card) {
                    const searchData = $(card).attr('data-search') || '';
                    return searchData.includes(query);
                });
            }
            currentPage = 1;
            renderPage();
        }, 300);
    });
});
</script>
<?= $this->endSection() ?>
