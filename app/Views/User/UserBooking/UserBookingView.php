<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --bk-primary: #696cff;
        --bk-primary-light: #8385ff;
        --bk-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(105, 108, 255, 0.12);
        --card-shadow: 0 4px 20px -4px rgba(105, 108, 255, 0.12);
        --success: #71dd37;
        --danger: #ff3e1d;
        --warning: #ffab00;
        --info: #03c3ec;
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .premium-animate {
        animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Dashboard Header --- */
    .dashboard-header {
        background: var(--bk-gradient);
        border-radius: 20px;
        padding: 1.75rem 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 12px 35px -8px rgba(105, 108, 255, 0.35);
    }
    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -15%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    .dashboard-header .header-inner {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .dashboard-header h4 {
        margin: 0;
        font-weight: 800;
        color: #fff !important;
        letter-spacing: -0.5px;
    }
    .dashboard-header p {
        margin-bottom: 0;
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.88rem;
    }
    .dashboard-header .breadcrumb {
        margin-bottom: 0.35rem;
        font-size: 0.78rem;
        background: transparent !important;
    }
    .dashboard-header .breadcrumb a { color: rgba(255,255,255,0.7) !important; text-decoration: none; }
    .dashboard-header .breadcrumb-item.active { color: #fff !important; }
    .dashboard-header .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.4) !important; }

    .year-filter-box {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.4rem 0.8rem;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .year-filter-box label {
        color: #fff;
        font-weight: 700;
        font-size: 0.82rem;
        margin: 0;
        white-space: nowrap;
    }
    .year-filter-box select {
        border-radius: 10px;
        border: none;
        font-size: 0.85rem;
        font-weight: 700;
        color: #3f4191;
        padding: 0.35rem 0.75rem;
        background: #ffffff;
        cursor: pointer;
        outline: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* --- Stat Cards --- */
    .stat-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        padding: 1.2rem 1rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(105, 108, 255, 0.2);
    }
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
    }
    .stat-icon.total { background: rgba(105, 108, 255, 0.12); color: var(--bk-primary); }
    .stat-icon.approved { background: rgba(113, 221, 55, 0.12); color: var(--success); }
    .stat-icon.pending { background: rgba(255, 171, 0, 0.12); color: var(--warning); }
    .stat-icon.rejected { background: rgba(255, 62, 29, 0.12); color: var(--danger); }

    .stat-info h3 {
        margin: 0;
        font-weight: 800;
        font-size: 1.5rem;
        color: #32475c;
        line-height: 1.1;
    }
    .stat-info span {
        font-size: 0.78rem;
        color: #8592a3;
        font-weight: 600;
    }

    /* --- Chart Cards --- */
    .chart-card {
        background: #fff;
        border: 1px solid var(--glass-border);
        border-radius: 18px;
        padding: 1.25rem;
        box-shadow: var(--card-shadow);
        height: 100%;
    }
    .chart-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .chart-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #32475c;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .chart-card-title i {
        color: var(--bk-primary);
        font-size: 1.2rem;
    }

    /* --- Search & Controls --- */
    .controls-bar {
        display: flex;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
        align-items: center;
        flex-wrap: wrap;
    }
    .search-box {
        flex: 1;
        min-width: 240px;
        position: relative;
    }
    .search-box input {
        width: 100%;
        padding: 0.65rem 0.85rem 0.65rem 2.5rem;
        border: 2px solid var(--glass-border);
        border-radius: 12px;
        font-size: 0.88rem;
        background: #fff;
        transition: border-color 0.2s;
        outline: none;
    }
    .search-box input:focus {
        border-color: var(--bk-primary);
        box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.12);
    }
    .search-box .search-icon {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 1.1rem;
    }

    .filter-tabs {
        display: flex;
        gap: 0.35rem;
        background: rgba(105, 108, 255, 0.06);
        padding: 0.25rem;
        border-radius: 12px;
    }
    .filter-tab {
        border: none;
        background: transparent;
        padding: 0.4rem 0.85rem;
        border-radius: 9px;
        font-size: 0.78rem;
        font-weight: 700;
        color: #666;
        cursor: pointer;
        transition: all 0.2s;
    }
    .filter-tab.active {
        background: var(--bk-primary);
        color: #fff;
        box-shadow: 0 4px 10px rgba(105, 108, 255, 0.3);
    }

    /* --- Booking Cards --- */
    .booking-cards-container {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .booking-card {
        background: #fff;
        border: 1px solid var(--glass-border);
        border-radius: 14px;
        padding: 0.9rem 1rem;
        box-shadow: var(--card-shadow);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .booking-card:hover { transform: translateY(-2px); }

    .booking-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        border-radius: 14px 0 0 14px;
    }
    .booking-card.status-pending::before { background: var(--warning); }
    .booking-card.status-approved::before { background: var(--success); }
    .booking-card.status-rejected::before { background: var(--danger); }

    .card-top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .status-pill {
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.7rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .status-pill.pending { background: rgba(255,171,0,0.12); color: #c88600; }
    .status-pill.approved { background: rgba(113,221,55,0.12); color: #4a9c1a; }
    .status-pill.rejected { background: rgba(255,62,29,0.12); color: #cc2e13; }

    .card-location-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }
    .card-location-img {
        width: 56px;
        height: 42px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #eee;
        flex-shrink: 0;
    }
    .card-location-text {
        flex: 1;
        min-width: 0;
    }
    .card-location-text .loc-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--bk-primary);
        word-wrap: break-word;
        line-height: 1.25;
    }
    .card-location-text .book-title {
        font-size: 0.8rem;
        color: #555;
        word-wrap: break-word;
        line-height: 1.25;
    }

    .card-details-compact {
        display: flex;
        flex-wrap: wrap;
        gap: 0.3rem 1rem;
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
        color: #666;
    }
    .card-details-compact .cd-item {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .card-details-compact .cd-item i {
        color: var(--bk-primary);
        font-size: 0.85rem;
    }
    .card-details-compact .cd-item span {
        font-weight: 600;
        color: #444;
    }

    .card-actions {
        display: flex;
        gap: 0.4rem;
        padding-top: 0.5rem;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    .card-actions .btn-card-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.72rem;
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

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #bbb;
    }
    .empty-state i { font-size: 3rem; margin-bottom: 0.75rem; display: block; color: #ddd; }
    .empty-state p { font-size: 0.85rem; margin: 0; }

    .booking-card.hidden-card { display: none; }

    /* Pagination */
    .mobile-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.35rem;
        margin-top: 1.25rem;
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
        font-size: 0.75rem;
        color: #999;
        text-align: center;
        margin-top: 0.5rem;
    }

    /* Mobile UX/UI Optimization */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1.25rem 1rem;
            margin-bottom: 1.25rem;
            border-radius: 1.25rem;
        }
        .dashboard-header h4 {
            font-size: 1.15rem;
        }
        .dashboard-header p {
            font-size: 0.78rem;
        }
        .year-filter-box {
            width: 100%;
            justify-content: space-between;
            margin-top: 0.75rem;
        }
        .year-filter-box select {
            flex: 1;
            font-size: 0.8rem;
        }
        .stat-card {
            padding: 0.85rem 1rem;
            border-radius: 1rem;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1.25rem;
            border-radius: 0.75rem;
        }
        .stat-info h3 {
            font-size: 1.25rem;
        }
        .stat-info span {
            font-size: 0.7rem;
        }
        .status-filter-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 6px;
            gap: 0.35rem;
        }
        .status-tab {
            padding: 0.4rem 0.85rem;
            font-size: 0.75rem;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .search-filter-bar {
            flex-direction: column;
            gap: 0.75rem;
        }
        .search-box-wrapper {
            max-width: 100%;
            width: 100%;
        }
        .card-location-row {
            flex-direction: row;
            gap: 0.75rem;
        }
        .card-location-img {
            width: 70px;
            height: 60px;
            border-radius: 8px;
        }
        .card-location-text .loc-name {
            font-size: 0.9rem;
        }
        .card-location-text .book-title {
            font-size: 0.78rem;
        }
        .card-details-compact {
            grid-template-columns: 1fr 1fr;
            gap: 0.35rem 0.5rem;
        }
        .card-actions {
            flex-wrap: wrap;
            gap: 0.4rem;
        }
        .card-actions .btn-card-action {
            flex: 1;
            min-width: calc(50% - 0.2rem);
            padding: 0.45rem 0.5rem;
            font-size: 0.7rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Dashboard Header with Year Selector -->
    <div class="dashboard-header premium-animate">
        <div class="header-inner">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url('Booking');?>">ระบบจองสถานที่</a></li>
                        <li class="breadcrumb-item active">แดชบอร์ด & รายการจอง</li>
                    </ol>
                </nav>
                <h4>
                    <?php 
                    if($CheckAll == 1){ 
                        echo 'แดชบอร์ดรายการจองห้องและสถานที่ทั้งหมด'; 
                    } else if(isset($All) && $All == 'My') { 
                        echo 'แดชบอร์ดรายการจองของฉัน'; 
                    } else { 
                        echo 'แดชบอร์ด: '.(@$Booking[0]->location_name ?: 'ห้องประชุม/สถานที่'); 
                    }
                    ?>
                </h4>
                <p>สรุปภาพรวม สถิติ และรายการจองสำหรับการเข้าดูข้อมูลของบุคคลทั่วไป</p>
            </div>

            <!-- Filter Year Dropdown -->
            <div class="year-filter-box">
                <label for="selectYearFilter"><i class='bx bx-calendar me-1'></i>เลือกปี พ.ศ.:</label>
                <select id="selectYearFilter" onchange="changeYearFilter(this.value)">
                    <option value="all" <?= $selectedYear === 'all' ? 'selected' : '' ?>>ทุกปี (ทั้งหมด)</option>
                    <?php foreach($availableYears as $y): ?>
                        <option value="<?= $y ?>" <?= (string)$y === (string)$selectedYear ? 'selected' : '' ?>>
                            ปี พ.ศ. <?= $y + 543 ?> (<?= $y ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Stat Cards Row -->
    <div class="row g-3 mb-4 premium-animate" style="animation-delay: 0.05s">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon total"><i class='bx bx-calendar-event'></i></div>
                <div class="stat-info">
                    <h3><?= number_format($stats['total']) ?></h3>
                    <span>การจองทั้งหมด</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon approved"><i class='bx bx-check-circle'></i></div>
                <div class="stat-info">
                    <h3><?= number_format($stats['approved']) ?></h3>
                    <span>อนุมัติแล้ว</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon pending"><i class='bx bx-time-five'></i></div>
                <div class="stat-info">
                    <h3><?= number_format($stats['pending']) ?></h3>
                    <span>รอตรวจสอบ</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon rejected"><i class='bx bx-x-circle'></i></div>
                <div class="stat-info">
                    <h3><?= number_format($stats['rejected']) ?></h3>
                    <span>ไม่อนุมัติ / ยกเลิก</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4 premium-animate" style="animation-delay: 0.1s">
        <!-- Monthly Trend Chart -->
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h5 class="chart-card-title">
                        <i class='bx bx-bar-chart-alt-2'></i> สถิติการจองรายเดือน (ประจำปี <?= $selectedYear === 'all' ? 'ทุกปี' : ($selectedYear + 543) ?>)
                    </h5>
                </div>
                <div id="monthlyChart" style="min-height: 250px;"></div>
            </div>
        </div>

        <!-- Top Locations Chart -->
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h5 class="chart-card-title">
                        <i class='bx bx-pie-chart-alt-2'></i> 5 อันดับสถานที่จองสูงสุด
                    </h5>
                </div>
                <div id="locationChart" style="min-height: 250px;"></div>
            </div>
        </div>
    </div>

    <!-- Search, Filters and Refresh -->
    <div class="controls-bar premium-animate" style="animation-delay: 0.15s">
        <div class="search-box">
            <i class='bx bx-search search-icon'></i>
            <input type="text" id="searchInput" placeholder="ค้นหา สถานที่, ผู้จอง, เรื่อง, เลขคำขอ..." autocomplete="off">
        </div>

        <div class="filter-tabs">
            <button class="filter-tab active" data-status="all">ทั้งหมด</button>
            <button class="filter-tab" data-status="อนุมัติ">อนุมัติแล้ว</button>
            <button class="filter-tab" data-status="รอตรวจสอบ">รอตรวจสอบ</button>
            <button class="filter-tab" data-status="ไม่อนุมัติ">ไม่อนุมัติ/ยกเลิก</button>
        </div>
    </div>

    <!-- Cards Container -->
    <div id="bookingCardsContainer" class="booking-cards-container premium-animate" style="animation-delay: 0.2s">

        <?php if(empty($Booking)): ?>
            <div class="empty-state">
                <i class='bx bx-calendar-x'></i>
                <p>ไม่พบรายการจองสถานที่<?= $selectedYear !== 'all' ? ' ในปี พ.ศ. '.($selectedYear + 543) : '' ?></p>
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
            <div class="booking-card status-<?=$statusClass?>" 
                 data-status="<?=$status?>"
                 data-search="<?= strtolower(
                $v_Booking->booking_title . ' ' .
                $v_Booking->location_name . ' ' .
                $fullname . ' ' .
                $v_Booking->booking_telephone . ' ' .
                ($v_Booking->booking_order ?? '') . ' ' .
                $status
            ) ?>">

                <!-- Top Row: Status + Order -->
                <div class="card-top-row">
                    <span class="status-pill <?=$pillClass?>"><i class='bx <?=$icon?>'></i><?=$status?></span>
                    <span style="font-size:0.7rem; color:#888; font-weight:700;"><?=$v_Booking->booking_order ?? ''?></span>
                </div>

                <!-- Location with Image -->
                <div class="card-location-row">
                    <img class="card-location-img" 
                         src="<?=base_url('uploads/admin/LocationRoom/'.($v_Booking->location_img ?? ''))?>" 
                         onerror="this.onerror=null; this.src='<?=base_url('assets/img/no-image.svg')?>';">
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
                        <i class='bx bx-download'></i>พิมพ์เอกสารขอใช้
                    </a>

                    <?php if(isset($_SESSION['username']) && (!isset($All) || $All == 'My')) : ?>
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
function changeYearFilter(val) {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('year', val);
    window.location.href = currentUrl.toString();
}

$(document).ready(function() {
    // Render Monthly ApexChart
    const monthlyData = <?= json_encode($stats['monthly']) ?>;
    const monthlyOptions = {
        series: [{
            name: 'จำนวนการจอง',
            data: monthlyData
        }],
        chart: {
            type: 'bar',
            height: 250,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 6,
                columnWidth: '45%',
                distributed: true
            }
        },
        colors: ['#696cff', '#03c3ec', '#71dd37', '#ffab00', '#ff3e1d', '#6610f2', '#fd7e14', '#20c997', '#e83e8c', '#6c757d', '#17a2b8', '#28a745'],
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: {
            categories: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            axisBorder: { show: false }
        },
        yaxis: {
            labels: {
                formatter: function (val) { return Math.floor(val); }
            }
        }
    };
    const monthlyChart = new ApexCharts(document.querySelector("#monthlyChart"), monthlyOptions);
    monthlyChart.render();

    // Render Location ApexChart
    const locationLabels = <?= json_encode($stats['topLocations']['labels']) ?>;
    const locationSeries = <?= json_encode($stats['topLocations']['series']) ?>;
    const locationOptions = {
        series: locationSeries.length > 0 ? locationSeries : [1],
        labels: locationLabels.length > 0 ? locationLabels : ['ไม่มีข้อมูล'],
        chart: {
            type: 'donut',
            height: 250
        },
        colors: ['#696cff', '#71dd37', '#ffab00', '#03c3ec', '#ff3e1d'],
        legend: {
            position: 'bottom',
            fontSize: '12px'
        },
        dataLabels: { enabled: true }
    };
    const locationChart = new ApexCharts(document.querySelector("#locationChart"), locationOptions);
    locationChart.render();

    // Cards list pagination & search filter logic
    const perPage = 10;
    let currentPage = 1;
    let allCards = $('.booking-card').toArray();
    let filteredCards = [...allCards];
    let selectedStatusTab = 'all';

    renderPage();

    function renderPage() {
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
                        <p>ไม่พบรายการจองตรงกับเงื่อนไข</p>
                    </div>
                `);
            }
            return;
        }

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

    function filterData() {
        const query = $('#searchInput').val().toLowerCase().trim();

        filteredCards = allCards.filter(function(card) {
            const searchData = $(card).attr('data-search') || '';
            const status = $(card).attr('data-status') || '';

            const matchesQuery = query === '' || searchData.includes(query);
            let matchesStatus = true;

            if (selectedStatusTab !== 'all') {
                if (selectedStatusTab === 'ไม่อนุมัติ') {
                    matchesStatus = (status === 'ไม่อนุมัติ' || status === 'ยกเลิกโดยผู้จอง');
                } else {
                    matchesStatus = (status === selectedStatusTab);
                }
            }

            return matchesQuery && matchesStatus;
        });

        currentPage = 1;
        renderPage();
    }

    let searchTimer;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(filterData, 250);
    });

    $('.filter-tab').on('click', function() {
        $('.filter-tab').removeClass('active');
        $(this).addClass('active');
        selectedStatusTab = $(this).data('status');
        filterData();
    });

    // --- Cancel / Delete Booking ---
    $(document).on('click', '.delete-btn', function () {
        const keyId = $(this).attr('key-id');
        Swal.fire({
            title: 'ต้องการยกเลิกและลบการจองนี้หรือไม่?',
            text: 'การดำเนินการนี้จะลบข้อมูลการจองและไฟล์แนบทั้งหมดโดยถาวร!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#15a362',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ยืนยันลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังลบข้อมูล...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                $.post('<?= base_url('Booking/DB/Cancel') ?>', { KeyID: keyId }, function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบข้อมูลสำเร็จ!',
                        text: 'ลบรายการจองเรียบร้อยแล้ว',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }).fail(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถลบข้อมูลได้'
                    });
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
