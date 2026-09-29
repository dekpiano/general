<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --driver-primary: #696cff;
        --driver-primary-dark: #3f4191;
        --driver-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --primary-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(105, 108, 255, 0.15);
        --card-shadow: 0 4px 18px -4px rgba(105, 108, 255, 0.08), 0 2px 8px -2px rgba(0, 0, 0, 0.04);
        --hover-shadow: 0 12px 28px -6px rgba(105, 108, 255, 0.18);
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Page Header Banner --- */
    .driver-header {
        background: var(--driver-gradient) !important;
        border-radius: 1.15rem;
        padding: 1.35rem 1.5rem;
        color: #ffffff !important;
        margin-bottom: 1.5rem;
        box-shadow: 0 12px 30px -8px rgba(105, 108, 255, 0.35);
        position: relative;
        overflow: hidden;
    }

    .driver-header * {
        color: inherit;
    }

    .driver-header h4 {
        color: #ffffff !important;
        font-size: 1.35rem;
    }

    .driver-header p {
        color: rgba(255, 255, 255, 0.85) !important;
        font-size: 0.85rem;
    }

    .driver-header::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        border-radius: 50%;
    }

    .driver-header .header-inner {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    @media (min-width: 992px) {
        .driver-header {
            padding: 1.6rem 2rem;
            border-radius: 1.25rem;
        }

        .driver-header .header-inner {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .header-title-box {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon-circle {
        width: 52px;
        height: 52px;
        border-radius: 0.85rem;
        background: rgba(255, 255, 255, 0.25) !important;
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }

    .header-icon-circle i {
        color: #ffffff !important;
        font-size: 1.8rem;
        display: inline-block;
    }

    @media (min-width: 768px) {
        .header-icon-circle {
            width: 58px;
            height: 58px;
            font-size: 2.1rem;
        }

        .header-icon-circle i {
            font-size: 2.1rem;
        }
    }

    .driver-header .btn-header-action {
        background-color: #ffffff !important;
        color: #696cff !important;
        border: none !important;
        font-size: 0.85rem;
        padding: 0.45rem 1rem;
        border-radius: 50rem;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        white-space: nowrap;
    }

    .driver-header .btn-header-action:hover {
        background-color: #f8f9ff !important;
        color: #5659e5 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15) !important;
    }

    .driver-header .btn-header-action i {
        color: #696cff !important;
        font-size: 1.1rem;
    }

    /* --- Stats Cards --- */
    .stat-card {
        background: #ffffff;
        border-radius: 1rem;
        padding: 1.1rem 1.15rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: var(--card-shadow);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        gap: 0.85rem;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--hover-shadow);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        flex-shrink: 0;
    }

    .stat-icon.icon-blue {
        background: rgba(105, 108, 255, 0.12);
        color: #696cff;
    }

    .stat-icon.icon-green {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
    }

    .stat-icon.icon-amber {
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
    }

    .stat-icon.icon-purple {
        background: rgba(139, 92, 246, 0.12);
        color: #8b5cf6;
    }

    .stat-info .stat-value {
        font-size: 1.35rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }

    .stat-info .stat-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
        white-space: nowrap;
    }

    @media (min-width: 768px) {
        .stat-card {
            padding: 1.25rem 1.35rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 1.6rem;
        }

        .stat-info .stat-value {
            font-size: 1.5rem;
        }

        .stat-info .stat-label {
            font-size: 0.85rem;
        }
    }

    /* --- Filter Tabs Bar --- */
    .filter-wrapper-mobile {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    @media (min-width: 768px) {
        .filter-wrapper-mobile {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
    }

    .filter-tabs {
        display: flex;
        gap: 0.35rem;
        background: #f1f5f9;
        padding: 0.3rem;
        border-radius: 0.85rem;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .filter-tabs::-webkit-scrollbar {
        display: none;
    }

    @media (min-width: 768px) {
        .filter-tabs {
            width: fit-content;
        }
    }

    .filter-tab {
        padding: 0.45rem 1rem;
        border-radius: 0.65rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: #64748b;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        flex: 1;
        justify-content: center;
    }

    @media (min-width: 768px) {
        .filter-tab {
            flex: initial;
            padding: 0.5rem 1.25rem;
            font-size: 0.88rem;
        }
    }

    .filter-tab.active {
        background: #ffffff;
        color: #696cff;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(105, 108, 255, 0.18);
    }

    /* --- Balanced Trip Card --- */
    .trip-card {
        background: #ffffff;
        border-radius: 1.1rem;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: var(--card-shadow);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        margin-bottom: 1.25rem;
        overflow: hidden;
    }

    .trip-card:hover {
        border-color: rgba(105, 108, 255, 0.3);
        box-shadow: var(--hover-shadow);
    }

    .trip-card-header {
        padding: 0.9rem 1.25rem;
        background: #f8fafc;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.65rem;
    }

    .trip-card-body {
        padding: 1.25rem 1.25rem;
    }

    @media (min-width: 768px) {
        .trip-card-body {
            padding: 1.5rem 1.65rem;
        }
    }

    .car-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.3rem 0.75rem;
        background: #f3f0ff;
        color: #696cff;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.65rem;
        border-radius: 0.45rem;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .info-badge-success {
        background: #dcfce7;
        color: #15803d;
    }

    .info-badge-warning {
        background: #fef3c7;
        color: #b45309;
    }

    .info-badge-info {
        background: #e0f2fe;
        color: #0284c7;
    }

    .info-badge-purple {
        background: #f3e8ff;
        color: #7e22ce;
    }

    /* Mileage Box */
    .mileage-box {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 0.75rem;
        padding: 0.85rem 1rem;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
    }

    @media (min-width: 768px) {
        .mileage-box {
            grid-template-columns: repeat(4, 1fr);
            padding: 0.9rem 1.25rem;
            gap: 1rem;
        }
    }

    .mileage-item {
        display: flex;
        flex-direction: column;
    }

    .mileage-item .title {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 500;
        margin-bottom: 0.15rem;
    }

    .mileage-item .val {
        font-size: 0.98rem;
        font-weight: 700;
        color: #0f172a;
    }

    /* Trip Action Buttons */
    .trip-actions {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin-top: 1rem;
        width: 100%;
    }

    @media (min-width: 768px) {
        .trip-actions {
            width: auto;
            justify-content: flex-end;
        }
    }

    .btn-record-trip {
        flex: 1;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 0.55rem 1.15rem;
        border-radius: 50rem;
    }

    @media (min-width: 768px) {
        .btn-record-trip {
            flex: initial;
        }
    }

    .btn-print-doc {
        font-size: 0.88rem;
        font-weight: 600;
        padding: 0.55rem 1rem;
        border-radius: 50rem;
    }

    /* Modal Styling */
    .modal-lux .modal-content {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .modal-lux .modal-header {
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        color: #ffffff;
        padding: 1.15rem 1.5rem;
        border-bottom: none;
    }

    .modal-lux .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .form-section-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.45rem;
    }

    .distance-preview-badge {
        background: #f5f4fe;
        border: 1.5px solid #dcdcfe;
        color: #5659e5;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.92rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 0.75rem;
    }

    /* --- Custom Pagination --- */
    .pagination-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.85rem;
        margin-top: 1.25rem;
        padding: 0.5rem 0 1.5rem 0;
    }

    @media (min-width: 768px) {
        .pagination-wrapper {
            flex-direction: row;
            justify-content: space-between;
            margin-top: 1.5rem;
        }
    }

    .pagination-lux {
        display: flex;
        gap: 0.3rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination-lux .page-item .page-link {
        border-radius: 0.55rem;
        border: 1px solid rgba(0, 0, 0, 0.06);
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.4rem 0.75rem;
        background: #ffffff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        min-height: 36px;
    }

    .pagination-lux .page-item .page-link:hover {
        background: #f8f9ff;
        color: #696cff;
        border-color: rgba(105, 108, 255, 0.3);
    }

    .pagination-lux .page-item.active .page-link {
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 3px 8px rgba(105, 108, 255, 0.35);
    }

    /* --- Driver List Grid & Cards --- */
    .driver-roster-card {
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 1.15rem;
        background: #ffffff;
        box-shadow: 0 4px 16px -3px rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        text-align: center;
        overflow: hidden;
        position: relative;
    }

    .driver-roster-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 30px -6px rgba(105, 108, 255, 0.2);
        border-color: rgba(105, 108, 255, 0.3);
    }

    .driver-roster-card .card-top-bg {
        height: 60px;
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
    }

    .driver-roster-avatar {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #ffffff;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        margin: -42px auto 0.75rem auto;
        display: block;
        background: #fff;
    }

    .driver-roster-no-avatar {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        border: 4px solid #ffffff;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        margin: -42px auto 0.75rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 2.2rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header Banner -->
    <div class="driver-header animate-fadeInUp">
        <div class="header-inner">
            <div class="header-title-box">
                <div class="header-icon-circle">
                    <i class='bx bxs-car'></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-white">คนขับรถ & ภารกิจการเดินทาง</h4>
                    <p class="mb-0 text-white-50">
                        รายชื่อคนขับของระบบ ตรวจสอบภารกิจที่ได้รับมอบหมาย บันทึกเลขไมล์ & น้ำมัน
                    </p>
                </div>
            </div>

            <!-- Header Action Controls -->
            <div class="d-flex align-items-center gap-2 flex-wrap mt-2 mt-md-0">
                <?php if (empty($isLoggedIn)): ?>
                    <a href="<?= base_url('LoginOfficerGeneral?return_to=' . urlencode(current_url())) ?>"
                       class="btn btn-warning rounded-pill px-4 py-2 shadow-sm d-inline-flex align-items-center gap-2 fw-bold text-dark">
                        <i class='bx bx-log-in fs-5'></i> เข้าสู่ระบบคนขับ / เจ้าหน้าที่
                    </a>
                <?php else: ?>
                    <?php if ($isAdmin): ?>
                        <div class="bg-white bg-opacity-20 p-1 px-2 rounded-pill d-flex align-items-center gap-1 backdrop-blur w-100 w-md-auto">
                            <i class='bx bx-user text-white' style="font-size: 0.85rem;"></i>
                            <span class="fw-bold text-dark" style="font-size: 0.75rem;">เลือกคนขับ:</span>
                            <select id="selectDriverFilter"
                                class="form-select form-select-sm border-0 rounded-pill bg-white text-dark shadow-sm py-0"
                                style="font-size: 0.78rem; height: 28px;">
                                <option value="all">-- คนขับทุกคน --</option>
                                <?php foreach ($allDrivers as $drv): ?>
                                    <option value="<?= $drv->cardriver_userID ?>" <?= (!empty($currentUserId) && $drv->cardriver_userID == $currentUserId) ? 'selected' : '' ?>>
                                        <?= $drv->pers_prefix . $drv->pers_firstname . ' ' . $drv->pers_lastname ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <div class="bg-white bg-opacity-20 p-1 px-3 rounded-pill d-flex align-items-center gap-1 backdrop-blur text-white shadow-sm"
                            style="font-size: 0.78rem;">
                            <i class='bx bx-id-card'></i>
                            <span>พนักงานขับรถ: <strong><?= session()->get('fullname') ?: 'ผู้ได้รับมอบหมาย' ?></strong></span>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-between flex-wrap">
                        <button type="button" class="btn-header-action flex-grow-1 text-center justify-content-center" data-bs-toggle="modal" data-bs-target="#modalDriverList">
                            <i class='bx bxs-user-badge'></i> รายชื่อคนขับรถ (<?= count($allDrivers ?? []) ?>)
                        </button>
                        <a href="<?= base_url('CarBooking/View') ?>"
                            class="btn-header-action flex-grow-1 text-center justify-content-center">
                            <i class='bx bx-list-ul'></i> ดูการจองทั้งหมด
                        </a>
                        <?php if ($isAdmin): ?>
                            <a href="<?= base_url('CarBooking/Approve/Admin') ?>"
                                class="btn-header-action flex-grow-1 text-center justify-content-center">
                                <i class='bx bx-check-shield'></i> สำหรับเจ้าหน้าที่
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (!empty($isLoggedIn)): ?>
    <!-- Summary Widgets (Compact 2x2 on Mobile, 4 in row on Desktop) -->
    <div class="row g-2 g-md-3 mb-3 animate-fadeInUp">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class='bx bx-car'></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" id="summaryTotal">0</div>
                    <div class="stat-label">ภารกิจทั้งหมด</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class='bx bx-time-five'></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value text-success" id="summaryToday">0</div>
                    <div class="stat-label">ภารกิจวันนี้</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-amber">
                    <i class='bx bx-calendar-event'></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value text-warning" id="summaryUpcoming">0</div>
                    <div class="stat-label">รอเดินทาง</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon icon-purple">
                    <i class='bx bx-tachometer'></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value text-purple" id="summaryDistance">0 <span
                            style="font-size: 0.75rem; font-weight: normal;">กม.</span></div>
                    <div class="stat-label">ระยะทางสะสม</div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Filter Tabs & Search Bar (Mobile First) -->
    <div class="filter-wrapper-mobile">
        <?php if (!empty($isLoggedIn)): ?>
            <div class="filter-tabs">
                <button type="button" class="filter-tab active" data-status="drivers_roster">
                    <i class='bx bxs-user-badge'></i> รายชื่อคนขับ (<?= count($allDrivers ?? []) ?>)
                </button>
                <button type="button" class="filter-tab" data-status="all">
                    <i class='bx bx-grid-alt'></i> ภารกิจทั้งหมด
                </button>
                <button type="button" class="filter-tab" data-status="today">
                    <i class='bx bx-sun'></i> วันนี้
                </button>
                <button type="button" class="filter-tab" data-status="upcoming">
                    <i class='bx bx-time'></i> รอเดินทาง
                </button>
                <button type="button" class="filter-tab" data-status="completed">
                    <i class='bx bx-check-circle'></i> เสร็จสิ้น
                </button>
            </div>
        <?php else: ?>
            <div class="d-flex align-items-center gap-2 py-1">
                <div class="badge bg-label-primary px-3 py-2 rounded-pill fs-6 d-inline-flex align-items-center gap-1 shadow-sm">
                    <i class='bx bxs-user-badge fs-5'></i> 
                    <span>รายชื่อพนักงานขับรถของระบบ (<?= count($allDrivers ?? []) ?> ท่าน)</span>
                </div>
            </div>
        <?php endif; ?>

        <div class="d-flex align-items-center gap-2">
            <div class="input-group input-group-merge shadow-sm flex-grow-1" style="max-width: 100%;">
                <span class="input-group-text bg-white border-end-0 py-1 pe-1"><i class='bx bx-search text-muted'
                        style="font-size: 1rem;"></i></span>
                <input type="text" id="searchInput" class="form-control bg-white border-start-0 ps-1 py-1"
                    style="font-size: 0.85rem;" placeholder="ค้นหาชื่อคนขับ, เบอร์โทร...">
            </div>
            <button type="button" id="btnRefresh"
                class="btn btn-outline-secondary rounded-pill px-2 py-1 shadow-sm flex-shrink-0" title="รีเฟรช">
                <i class='bx bx-refresh fs-5'></i>
            </button>
        </div>
    </div>

    <!-- Drivers Roster Grid (Default Active View) -->
    <div id="driversRosterContainer">
        <div class="row g-3">
            <?php if (!empty($allDrivers)): ?>
                <?php foreach ($allDrivers as $driver): ?>
                    <?php 
                        $hasImg = !empty($driver->pers_img);
                        $fullName = trim(($driver->pers_prefix ?? '') . ($driver->pers_firstname ?? '') . ' ' . ($driver->pers_lastname ?? ''));
                        $phone = $driver->pers_phone ?: 'ไม่ระบุเบอร์โทร';
                    ?>
                    <div class="col-sm-6 col-lg-4 col-xl-3 driver-roster-item" data-name="<?= esc(strtolower($fullName)) ?>" data-phone="<?= esc($phone) ?>">
                        <div class="driver-roster-card h-100">
                            <div class="card-top-bg"></div>
                            <div class="p-3 pt-0">
                                <?php if ($hasImg): ?>
                                    <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= esc($driver->pers_img) ?>"
                                         class="driver-roster-avatar"
                                         alt="<?= esc($fullName) ?>"
                                         onerror="if(!this.dataset.retry){this.dataset.retry=1;this.src='https://personnel.skj.ac.th/uploads/admin/Person/<?= esc($driver->pers_img) ?>';}else{this.outerHTML='<div class=\'driver-roster-no-avatar\'><i class=\'bx bxs-user\'></i></div>';}">
                                <?php else: ?>
                                    <div class="driver-roster-no-avatar">
                                        <i class='bx bxs-user'></i>
                                    </div>
                                <?php endif; ?>

                                <h6 class="fw-bold mb-1 text-dark"><?= esc($fullName) ?></h6>
                                <p class="text-muted small mb-2">
                                    <i class='bx bx-id-card text-primary me-1'></i>พนักงานขับรถ
                                </p>

                                <div class="bg-light rounded-pill py-1 px-3 mb-3 d-inline-flex align-items-center gap-1 small">
                                    <i class='bx bx-phone text-success'></i>
                                    <span class="fw-semibold text-dark"><?= esc($phone) ?></span>
                                </div>

                                <div class="d-flex gap-2 justify-content-center">
                                    <?php if (!empty($driver->pers_phone)): ?>
                                    <a href="tel:<?= esc($driver->pers_phone) ?>" class="btn btn-sm btn-outline-success rounded-pill px-3 w-100">
                                        <i class='bx bx-phone-call me-1'></i>โทรออก
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($isAdmin): ?>
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 btn-filter-this-driver" data-driver-id="<?= esc($driver->cardriver_userID) ?>" title="ดูภารกิจของคนนี้">
                                        <i class='bx bx-filter-alt'></i> ดูงาน
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">ไม่พบข้อมูลพนักงานขับรถในระบบ</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Trips List Container -->
    <div id="tripsContainer" class="d-none">
        <!-- Rendered by JavaScript -->
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="text-muted mt-2">กำลังโหลดรายการงานคนขับรถ...</p>
        </div>
    </div>

    <!-- Pagination Container -->
    <div id="paginationContainer" class="d-none"></div>

</div>

<!-- Modal: บันทึกเลขไมล์ & ข้อมูลน้ำมัน -->
<div class="modal fade modal-lux" id="modalRecordTrip" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold text-white mb-0">
                        <i class='bx bx-edit-alt me-1'></i> บันทึกข้อมูลการเดินทางและเลขไมล์
                    </h5>
                    <small class="text-white-50" id="modalSubTitle">ใบงาน #</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formRecordTrip" novalidate>
                <div class="modal-body p-4">
                    <input type="hidden" name="car_reserv_id" id="field_car_reserv_id">

                    <!-- Recorder Status Notice -->
                    <div id="modalRecorderNotice"
                        class="alert alert-info py-2 px-3 small d-none mb-3 rounded-3 border-0 bg-label-info">
                        <div class="d-flex align-items-center gap-2">
                            <i class='bx bx-user-check fs-5'></i>
                            <div id="modalRecorderNoticeText"></div>
                        </div>
                    </div>

                    <!-- Acting On Behalf Notice (For Staff) -->
                    <div id="modalActingNotice"
                        class="alert alert-warning py-2 px-3 small d-none mb-3 rounded-3 border-0 bg-label-warning">
                        <div class="d-flex align-items-center gap-2">
                            <i class='bx bx-shield-quarter fs-5'></i>
                            <div id="modalActingNoticeText"></div>
                        </div>
                    </div>

                    <!-- Trip Info Card Preview -->
                    <div class="card bg-light border-0 rounded-3 p-3 mb-4">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-6">
                                <div class="text-muted small">ยานพาหนะ:</div>
                                <div class="fw-bold text-dark" id="modalCarInfo">-</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small">สถานที่ไปราชการ:</div>
                                <div class="fw-bold text-dark" id="modalLocationInfo">-</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small">ผู้ขอใช้รถ:</div>
                                <div class="text-dark" id="modalBookerInfo">-</div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small">กำหนดการเดินทาง:</div>
                                <div class="text-dark" id="modalDateInfo">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- ส่วนที่ 1: เลขไมล์กิโลเมตร -->
                    <div class="form-section-title">
                        <i class='bx bx-tachometer text-primary'></i> บันทึกระยะทาง (กิโลเมตร)
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                เลขไมล์เมื่อรถออกเดินทาง <span class="text-muted fw-normal">(กม.)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i
                                        class='bx bx-log-out-circle text-info'></i></span>
                                <input type="number" name="departure_mileage" id="field_departure_mileage"
                                    class="form-control form-control-lg" placeholder="เช่น 125400" min="0">
                            </div>
                            <small class="text-muted">บันทึกเมื่อนำรถออกจากโรงเรียน</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                เลขไมล์เมื่อกลับถึงสำนักงาน <span class="text-muted fw-normal">(กม.)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i
                                        class='bx bx-log-in-circle text-success'></i></span>
                                <input type="number" name="return_mileage" id="field_return_mileage"
                                    class="form-control form-control-lg" placeholder="เช่น 125680" min="0">
                            </div>
                            <small class="text-muted">บันทึกเมื่อนำรถกลับถึงโรงเรียน</small>
                        </div>
                    </div>

                    <!-- Live Preview Distance Badge -->
                    <div class="distance-preview-badge">
                        <div class="d-flex align-items-center gap-2">
                            <i class='bx bx-navigation fs-4'></i>
                            <span>ระยะทางรวมที่วิ่งจริงในภารกิจนี้:</span>
                        </div>
                        <span class="fs-5 fw-bold" id="liveDistanceText">0 กม.</span>
                    </div>

                    <hr class="my-4">

                    <!-- ส่วนที่ 2: ข้อมูลการใช้น้ำมันเชื้อเพลิง & ใบสั่งซื้อ -->
                    <div class="form-section-title">
                        <i class='bx bx-gas-pump text-warning'></i> ข้อมูลการเบิก / ใช้น้ำมันเชื้อเพลิง
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">การเบิกน้ำมันเชื้อเพลิงในภารกิจนี้:</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="fuel_request" id="modal_fuel_no" value="no" checked>
                                    <label class="form-check-label" for="modal_fuel_no">ไม่เบิกน้ำมัน</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="fuel_request" id="modal_fuel_yes" value="yes">
                                    <label class="form-check-label text-primary fw-bold" for="modal_fuel_yes">มีการเบิกน้ำมัน</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fuel Details (Shown when fuel_request is yes) -->
                    <div id="modal_fuel_details_section" class="p-3 border rounded-3 bg-light bg-opacity-50 mb-3" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">ชนิดน้ำมัน</label>
                                <select class="form-select" id="field_fuel_type" name="fuel_type">
                                    <option value="">-- เลือกชนิดน้ำมัน --</option>
                                    <option value="น้ำมันดีเซล B7">น้ำมันดีเซล B7</option>
                                    <option value="น้ำมันดีเซล B10">น้ำมันดีเซล B10</option>
                                    <option value="น้ำมันดีเซล">น้ำมันดีเซล</option>
                                    <option value="น้ำมันแก๊สโซฮอล์ 95">น้ำมันแก๊สโซฮอล์ 95</option>
                                    <option value="น้ำมันแก๊สโซฮอล์ 91">น้ำมันแก๊สโซฮอล์ 91</option>
                                    <option value="อื่นๆ">อื่นๆ (ระบุ)</option>
                                </select>
                            </div>
                            <div class="col-md-4" id="modal_fuel_other_section" style="display: none;">
                                <label class="form-label fw-bold">ระบุชนิดน้ำมัน</label>
                                <input type="text" class="form-control" id="field_fuel_other_desc" name="fuel_other_desc" placeholder="เช่น น้ำมันเครื่อง, แก๊ส E20">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">ปริมาณน้ำมัน (ลิตร)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" class="form-control" id="field_fuel_amount" name="fuel_amount" placeholder="เช่น 45.50">
                                    <span class="input-group-text">ลิตร</span>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-1 pt-2 border-top">
                            <div class="col-md-4">
                                <label class="form-label">ใบสั่งซื้อสินค้า เล่มที่</label>
                                <input type="text" name="fuel_po_book" id="field_fuel_po_book" class="form-control"
                                    placeholder="เช่น เล่มที่ 05">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">เลขที่</label>
                                <input type="text" name="fuel_po_number" id="field_fuel_po_number" class="form-control"
                                    placeholder="เช่น 0124">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ลงวันที่</label>
                                <input type="date" name="fuel_po_date" id="field_fuel_po_date" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-primary" id="btnSaveTrip">
                        <i class='bx bx-check-circle me-1'></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
<!-- Modal: รายชื่อคนขับรถทั้งหมด (Quick View Modal) -->
<div class="modal fade modal-lux" id="modalDriverList" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold text-white mb-0">
                        <i class='bx bxs-user-badge me-1'></i> พนักงานขับรถของระบบ (<?= count($allDrivers ?? []) ?> ท่าน)
                    </h5>
                    <small class="text-white-50">รายชื่อและข้อมูลติดต่อสำหรับประสานงาน</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="row g-3">
                    <?php if (!empty($allDrivers)): ?>
                        <?php foreach ($allDrivers as $driver): ?>
                            <?php 
                                $hasImg = !empty($driver->pers_img);
                                $fullName = trim(($driver->pers_prefix ?? '') . ($driver->pers_firstname ?? '') . ' ' . ($driver->pers_lastname ?? ''));
                                $phone = $driver->pers_phone ?: 'ไม่ระบุเบอร์โทร';
                            ?>
                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <div class="driver-roster-card h-100 bg-white">
                                    <div class="card-top-bg"></div>
                                    <div class="p-3 pt-0">
                                        <?php if ($hasImg): ?>
                                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= esc($driver->pers_img) ?>"
                                                 class="driver-roster-avatar"
                                                 alt="<?= esc($fullName) ?>"
                                                 onerror="if(!this.dataset.retry){this.dataset.retry=1;this.src='https://personnel.skj.ac.th/uploads/admin/Person/<?= esc($driver->pers_img) ?>';}else{this.outerHTML='<div class=\'driver-roster-no-avatar\'><i class=\'bx bxs-user\'></i></div>';}">
                                        <?php else: ?>
                                            <div class="driver-roster-no-avatar">
                                                <i class='bx bxs-user'></i>
                                            </div>
                                        <?php endif; ?>

                                        <h6 class="fw-bold mb-1 text-dark"><?= esc($fullName) ?></h6>
                                        <p class="text-muted small mb-2">
                                            <i class='bx bx-id-card text-primary me-1'></i>พนักงานขับรถ
                                        </p>

                                        <div class="bg-light rounded-pill py-1 px-3 mb-3 d-inline-flex align-items-center gap-1 small">
                                            <i class='bx bx-phone text-success'></i>
                                            <span class="fw-semibold text-dark"><?= esc($phone) ?></span>
                                        </div>

                                        <div class="d-flex gap-2 justify-content-center">
                                            <?php if (!empty($driver->pers_phone)): ?>
                                            <a href="tel:<?= esc($driver->pers_phone) ?>" class="btn btn-sm btn-outline-success rounded-pill px-3 w-100">
                                                <i class='bx bx-phone-call me-1'></i>โทรออก
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">ไม่พบข้อมูลพนักงานขับรถในระบบ</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer bg-light p-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    ปิดหน้าต่าง
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('customJS') ?>
<script>
    $(document).ready(function () {
        const currentUserId = '<?= $currentUserId ?? '' ?>';
        const isAdmin = <?= !empty($isAdmin) ? 'true' : 'false' ?>;
        let currentStatus = 'drivers_roster';
        let allTripsData = [];
        let currentPage = 1;
        const itemsPerPage = 5;

        // โหลดข้อมูลงาน
        function loadTrips() {
            const driverId = $('#selectDriverFilter').length ? $('#selectDriverFilter').val() : '';
            $('#tripsContainer').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2">กำลังโหลดข้อมูลงาน...</p>
                </div>
            `);
            $('#paginationContainer').html('');

            $.ajax({
                url: '<?= base_url("CarBooking/Driver/GetTrips") ?>',
                type: 'GET',
                data: {
                    status: currentStatus,
                    driver_id: driverId
                },
                dataType: 'json',
                success: function (res) {
                    if (res.status === 'success') {
                        allTripsData = res.data || [];
                        updateSummaryCounters(res.summary);
                        currentPage = 1;
                        renderTrips();
                    } else {
                        $('#tripsContainer').html(`
                            <div class="alert alert-danger text-center p-4">
                                <i class='bx bx-error-circle fs-3 mb-2'></i>
                                <div>${res.message || 'เกิดข้อผิดพลาดในการโหลดข้อมูล'}</div>
                            </div>
                        `);
                    }
                },
                error: function () {
                    $('#tripsContainer').html(`
                        <div class="alert alert-danger text-center p-4">
                            <i class='bx bx-wifi-off fs-3 mb-2'></i>
                            <div>ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง</div>
                        </div>
                    `);
                }
            });
        }

        // อัปเดตตัวเลขการ์ดสรุป
        function updateSummaryCounters(summary) {
            if (!summary) return;
            $('#summaryTotal').text(summary.total_trips || 0);
            $('#summaryToday').text(summary.count_today || 0);
            $('#summaryUpcoming').text(summary.count_upcoming || 0);
            $('#summaryDistance').html((summary.total_distance || 0).toLocaleString() + ' <span style="font-size: 0.9rem; font-weight: normal;">กม.</span>');
        }

        // กรองด้วยคำค้นหา
        function getFilteredData() {
            const query = ($('#searchInput').val() || '').toLowerCase().trim();
            if (!query) return allTripsData;
            return allTripsData.filter(function (t) {
                return (t.car_reserv_location || '').toLowerCase().includes(query) ||
                    (t.car_reserv_detail || '').toLowerCase().includes(query) ||
                    (t.booker_fullname || '').toLowerCase().includes(query) ||
                    (t.car_registration || '').toLowerCase().includes(query) ||
                    (t.car_brand || '').toLowerCase().includes(query);
            });
        }

        // แสดงผลการ์ดงานพร้อม Pagination
        function renderTrips() {
            const filteredTrips = getFilteredData();
            const totalItems = filteredTrips.length;

            if (totalItems === 0) {
                $('#tripsContainer').html(`
                    <div class="card border-0 shadow-sm text-center py-5 my-3 rounded-4">
                        <div class="card-body">
                            <div class="avatar avatar-xl bg-label-secondary mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%;">
                                <i class='bx bx-car fs-1 text-muted'></i>
                            </div>
                            <h5 class="fw-bold text-dark">ไม่พบรายการงานที่ได้รับมอบหมาย</h5>
                            <p class="text-muted small mb-0">ไม่มีภารกิจการขับรถในช่วงตัวกรองนี้ หรือยังไม่มีการมอบหมายงาน</p>
                        </div>
                    </div>
                `);
                $('#paginationContainer').html('');
                return;
            }

            const totalPages = Math.ceil(totalItems / itemsPerPage);
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
            const pagedTrips = filteredTrips.slice(startIndex, endIndex);

            let html = '';
            pagedTrips.forEach(function (t) {
                // Badge สถานะ
                let statusBadge = '';
                if (t.is_finished) {
                    statusBadge = '<span class="info-badge info-badge-success"><i class="bx bx-check-double"></i> เสร็จสิ้นภารกิจ</span>';
                } else if (t.is_today) {
                    statusBadge = '<span class="info-badge info-badge-warning animate-pulse"><i class="bx bx-play-circle"></i> ปฏิบัติงานวันนี้</span>';
                } else if (t.is_upcoming) {
                    statusBadge = '<span class="info-badge info-badge-info"><i class="bx bx-calendar"></i> งานรอเดินทาง</span>';
                }

                // Mileage status
                let depMile = t.departure_mileage ? parseInt(t.departure_mileage).toLocaleString() : '-';
                let retMile = t.return_mileage ? parseInt(t.return_mileage).toLocaleString() : '-';
                let distText = t.distance_km > 0 ? `<span class="text-success fw-bold">${t.distance_km.toLocaleString()} กม.</span>` : '<span class="text-muted">ยังไม่สรุป</span>';

                let fuelText = t.fuel_request === 'yes'
                    ? `<span class="badge bg-label-warning"><i class='bx bx-gas-pump'></i> ขอน้ำมัน ${t.fuel_type || ''} ${t.fuel_amount ? t.fuel_amount + ' ล.' : ''}</span>`
                    : '<span class="badge bg-label-secondary">ไม่เบิกน้ำมัน</span>';

                let printUrl = '<?= base_url("CarBooking/CarBookingPrint/") ?>/' + t.car_reserv_id;

                html += `
                <div class="trip-card">
                    <div class="trip-card-header">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="car-badge">
                                <i class='bx bxs-car'></i> ${t.car_registration || '-'} ${t.car_province || ''}
                            </span>
                            <span class="small text-muted fw-bold">${t.car_brand || ''} ${t.car_model || ''}</span>
                            ${fuelText}
                        </div>
                        <div class="ms-auto">
                            ${statusBadge}
                        </div>
                    </div>
                    <div class="trip-card-body">
                        <!-- Location & Detail -->
                        <div class="d-flex align-items-start gap-2 mb-2">
                            <i class='bx bxs-map-pin text-danger fs-5 mt-1 flex-shrink-0'></i>
                            <div class="w-100">
                                <div class="fw-bold text-dark fs-6 lh-sm">${t.car_reserv_location || 'ไม่ระบุสถานที่'}</div>
                                ${t.car_reserv_detail ? `<div class="text-muted small mt-1">${t.car_reserv_detail}</div>` : ''}
                            </div>
                        </div>

                        <!-- Info Grid: Date & Booker (Compact 2 cols on mobile) -->
                        <div class="row g-2 mb-2 pt-1">
                            <div class="col-12 col-md-6">
                                <div class="bg-light p-2 px-3 rounded-3 d-flex align-items-center gap-2">
                                    <i class='bx bx-calendar-star text-primary fs-5 flex-shrink-0'></i>
                                    <div class="small">
                                        <div class="fw-bold text-dark lh-sm">${t.date_range_thai}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">เวลา: ${t.time_range}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="bg-light p-2 px-3 rounded-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2 small">
                                        <i class='bx bx-user text-primary fs-5 flex-shrink-0'></i>
                                        <div>
                                            <div class="text-dark fw-bold lh-sm">${t.booker_fullname}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">ผู้โดยสาร: ${t.car_reserv_number || 0} คน</div>
                                        </div>
                                    </div>
                                    ${t.req_phone ? `
                                    <a href="tel:${t.req_phone}" class="btn btn-sm btn-outline-success rounded-pill px-2 py-1 shadow-none" title="โทรหาผู้ขอใช้รถ">
                                        <i class='bx bx-phone'></i> โทร
                                    </a>` : ''}
                                </div>
                            </div>
                        </div>

                        ${t.driver_fullname ? `
                        <div class="d-flex align-items-center gap-1 text-muted small mb-2 px-1" style="font-size: 0.8rem;">
                            <i class='bx bx-id-card text-success fs-6'></i>
                            <span>พนักงานขับรถ: <strong class="text-dark">${t.driver_fullname}</strong></span>
                        </div>` : ''}

                        <!-- Mileage & Fuel Summary Box -->
                        <div class="mileage-box">
                            <div class="mileage-item">
                                <span class="title">ไมล์ออก:</span>
                                <span class="val text-info">${depMile} <small style="font-size:0.7rem; font-weight:normal;">กม.</small></span>
                            </div>
                            <div class="mileage-item">
                                <span class="title">ไมล์กลับ:</span>
                                <span class="val text-success">${retMile} <small style="font-size:0.7rem; font-weight:normal;">กม.</small></span>
                            </div>
                            <div class="mileage-item">
                                <span class="title">ระยะทางจริง:</span>
                                <span class="val">${distText}</span>
                            </div>
                            <div class="mileage-item">
                                <span class="title">ใบสั่งซื้อน้ำมัน:</span>
                                <span class="val text-dark" style="font-size:0.8rem;">
                                    ${t.fuel_po_book || t.fuel_po_number ? `${t.fuel_po_book || '-'}/${t.fuel_po_number || '-'}` : '-'}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="trip-actions">
                            <button type="button" class="btn btn-primary btn-record-trip shadow-sm btn-edit-trip" data-trip='${JSON.stringify(t).replace(/'/g, "&#39;")}'>
                                <i class='bx bx-edit-alt me-1'></i> บันทึกเลขไมล์ / น้ำมัน
                            </button>
                            <a href="${printUrl}" target="_blank" class="btn btn-outline-info btn-print-doc shadow-none">
                                <i class='bx bx-printer me-1'></i> แบบ ๓
                            </a>
                        </div>

                        ${t.recorder_fullname ? `
                        <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-between flex-wrap gap-1 text-muted" style="font-size: 0.75rem;">
                            <div class="d-flex align-items-center flex-wrap gap-1">
                                <i class='bx bx-user-check text-primary'></i>
                                <span>โดย: <strong class="text-dark">${t.recorder_fullname}</strong></span>
                                ${t.is_recorded_by_staff
                            ? '<span class="badge bg-label-info ms-1" style="font-size: 0.65rem;">จนท. บันทึกแทน</span>'
                            : '<span class="badge bg-label-success ms-1" style="font-size: 0.65rem;">คนขับบันทึกเอง</span>'
                        }
                            </div>
                            ${t.mileage_recorded_at_thai ? `
                            <div>
                                <i class='bx bx-time-five me-1'></i>${t.mileage_recorded_at_thai}
                            </div>` : ''}
                        </div>` : ''}
                    </div>
                </div>`;
            });

            $('#tripsContainer').html(html);
            renderPagination(totalPages, totalItems, startIndex + 1, endIndex);
        }

        // สร้างตัวเลขหน้า Pagination
        function renderPagination(totalPages, totalItems, fromItem, toItem) {
            if (totalPages <= 1) {
                $('#paginationContainer').html(`
                    <div class="d-flex justify-content-between align-items-center text-muted small py-2">
                        <span>แสดงทั้งหมด ${totalItems} รายการ</span>
                    </div>
                `);
                return;
            }

            let pagHtml = `
            <div class="pagination-wrapper">
                <div class="text-muted small">
                    แสดงรายการที่ <strong class="text-dark">${fromItem}</strong> - <strong class="text-dark">${toItem}</strong> จากทั้งหมด <strong class="text-dark">${totalItems}</strong> รายการ
                </div>
                <ul class="pagination-lux">
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link btn-page-nav" href="javascript:void(0);" data-page="${currentPage - 1}" title="หน้าก่อนหน้า">
                            <i class='bx bx-chevron-left'></i>
                        </a>
                    </li>
            `;

            for (let p = 1; p <= totalPages; p++) {
                if (p === 1 || p === totalPages || (p >= currentPage - 1 && p <= currentPage + 1)) {
                    pagHtml += `
                        <li class="page-item ${p === currentPage ? 'active' : ''}">
                            <a class="page-link btn-page-nav" href="javascript:void(0);" data-page="${p}">${p}</a>
                        </li>
                    `;
                } else if (p === currentPage - 2 || p === currentPage + 2) {
                    pagHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }

            pagHtml += `
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link btn-page-nav" href="javascript:void(0);" data-page="${currentPage + 1}" title="หน้าถัดไป">
                            <i class='bx bx-chevron-right'></i>
                        </a>
                    </li>
                </ul>
            </div>
            `;

            $('#paginationContainer').html(pagHtml);
        }

        // จัดการคลิกเปลี่ยนหน้า Pagination
        $(document).on('click', '.btn-page-nav', function () {
            const page = parseInt($(this).data('page'));
            if (page && page !== currentPage) {
                currentPage = page;
                renderTrips();
                $('html, body').animate({
                    scrollTop: $("#tripsContainer").offset().top - 120
                }, 250);
            }
        });

        // Filter Tab Click
        $('.filter-tab').on('click', function () {
            $('.filter-tab').removeClass('active');
            $(this).addClass('active');
            currentStatus = $(this).data('status');
            
            if (currentStatus === 'drivers_roster') {
                $('#tripsContainer').addClass('d-none');
                $('#paginationContainer').addClass('d-none');
                $('#driversRosterContainer').removeClass('d-none');
                filterDriversRoster();
            } else {
                $('#driversRosterContainer').addClass('d-none');
                $('#tripsContainer').removeClass('d-none');
                $('#paginationContainer').removeClass('d-none');
                loadTrips();
            }
        });

        // Search Box Keyup for both Trips & Driver Roster
        function filterDriversRoster() {
            const query = ($('#searchInput').val() || '').toLowerCase().trim();
            $('.driver-roster-item').each(function () {
                const name = $(this).data('name') || '';
                const phone = $(this).data('phone') || '';
                if (!query || name.includes(query) || phone.includes(query)) {
                    $(this).removeClass('d-none');
                } else {
                    $(this).addClass('d-none');
                }
            });
        }

        // Driver Select change (for Admin)
        $('#selectDriverFilter').on('change', function () {
            if (currentStatus === 'drivers_roster') {
                $('.filter-tab[data-status="all"]').trigger('click');
            } else {
                loadTrips();
            }
        });

        // Click 'ดูงาน' on a driver card from Driver Roster
        $(document).on('click', '.btn-filter-this-driver', function () {
            const drvId = $(this).data('driver-id');
            if ($('#selectDriverFilter').length) {
                $('#selectDriverFilter').val(drvId);
            }
            $('.filter-tab[data-status="all"]').trigger('click');
        });

        // Search Box Keyup
        $('#searchInput').on('keyup', function () {
            if (currentStatus === 'drivers_roster') {
                filterDriversRoster();
            } else {
                currentPage = 1;
                renderTrips();
            }
        });

        // Refresh Button Click
        $('#btnRefresh').on('click', function () {
            if (currentStatus === 'drivers_roster') {
                $('#searchInput').val('');
                filterDriversRoster();
            } else {
                loadTrips();
            }
        });

        // Live Mileage Distance Calculation in Modal
        function calcLiveDistance() {
            const dep = parseInt($('#field_departure_mileage').val()) || 0;
            const ret = parseInt($('#field_return_mileage').val()) || 0;
            if (dep > 0 && ret > 0) {
                const diff = ret - dep;
                if (diff >= 0) {
                    $('#liveDistanceText').html(`<span class="text-success">${diff.toLocaleString()} กม.</span>`);
                } else {
                    $('#liveDistanceText').html(`<span class="text-danger">เลขไมล์กลับน้อยกว่าเลขไมล์ออก (${diff} กม.)</span>`);
                }
            } else {
                $('#liveDistanceText').text('0 กม.');
            }
        }

        $('#field_departure_mileage, #field_return_mileage').on('input', calcLiveDistance);

        const isLoggedIn = <?= !empty($isLoggedIn) ? 'true' : 'false' ?>;

        // Open Edit Modal
        $(document).on('click', '.btn-edit-trip', function () {
            if (!isLoggedIn) {
                Swal.fire({
                    icon: 'warning',
                    title: 'กรุณาเข้าสู่ระบบ',
                    text: 'คนขับรถหรือเจ้าหน้าที่ต้องเข้าสู่ระบบก่อนทำการบันทึกเลขไมล์และค่าน้ำมัน',
                    showCancelButton: true,
                    confirmButtonText: '<i class="bx bx-log-in me-1"></i> เข้าสู่ระบบ',
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonColor: '#696cff'
                }).then((res) => {
                    if (res.isConfirmed) {
                        window.location.href = '<?= base_url("LoginOfficerGeneral?return_to=" . urlencode(current_url())) ?>';
                    }
                });
                return;
            }

            const trip = $(this).data('trip');
            $('#field_car_reserv_id').val(trip.car_reserv_id);
            $('#modalSubTitle').text('ใบงาน #' + (trip.car_reserv_order || trip.car_reserv_id));

            // แสดงสถานะผู้บันทึกข้อมูลล่าสุด
            if (trip.recorder_fullname) {
                let roleTag = trip.is_recorded_by_staff
                    ? '<span class="badge bg-label-info ms-1">เจ้าหน้าที่บันทึกแทน</span>'
                    : '<span class="badge bg-label-success ms-1">คนขับบันทึกเอง</span>';
                let timeStr = trip.mileage_recorded_at_thai ? ' เมื่อ ' + trip.mileage_recorded_at_thai : '';
                $('#modalRecorderNoticeText').html(`บันทึกข้อมูลล่าสุดโดย: <strong>${trip.recorder_fullname}</strong> ${roleTag}${timeStr}`);
                $('#modalRecorderNotice').removeClass('d-none');
            } else {
                $('#modalRecorderNotice').addClass('d-none');
            }

            // กรณีเป็นเจ้าหน้าที่เข้ามาบันทึกแทนคนขับ
            if (isAdmin && trip.car_reserv_driver && trip.car_reserv_driver !== currentUserId) {
                let drvName = trip.driver_fullname || 'พนักงานขับรถ';
                $('#modalActingNoticeText').html(`ท่านกำลังบันทึกข้อมูล<strong>แทน</strong>: <strong>${drvName}</strong> (ระบบจะบันทึกชื่อท่านเป็นผู้ทำรายการในเรคอร์ดนี้)`);
                $('#modalActingNotice').removeClass('d-none');
            } else {
                $('#modalActingNotice').addClass('d-none');
            }

            $('#modalCarInfo').text((trip.car_registration || '-') + ' (' + (trip.car_brand || '') + ' ' + (trip.car_model || '') + ')');
            $('#modalLocationInfo').text(trip.car_reserv_location || '-');
            $('#modalBookerInfo').text(trip.booker_fullname + (trip.req_phone ? ' (โทร: ' + trip.req_phone + ')' : ''));
            $('#modalDateInfo').text(trip.date_range_thai + ' (' + trip.time_range + ')');

            $('#field_departure_mileage').val(trip.departure_mileage || '');
            $('#field_return_mileage').val(trip.return_mileage || '');

            // ตั้งค่าข้อมูลการเบิกน้ำมัน
            if (trip.fuel_request === 'yes') {
                $('#modal_fuel_yes').prop('checked', true);
                $('#modal_fuel_details_section').show();
            } else {
                $('#modal_fuel_no').prop('checked', true);
                $('#modal_fuel_details_section').hide();
            }

            const standardFuelTypes = ['น้ำมันดีเซล B7', 'น้ำมันดีเซล B10', 'น้ำมันดีเซล', 'น้ำมันแก๊สโซฮอล์ 95', 'น้ำมันแก๊สโซฮอล์ 91'];
            if (trip.fuel_type) {
                if (standardFuelTypes.includes(trip.fuel_type)) {
                    $('#field_fuel_type').val(trip.fuel_type);
                    $('#modal_fuel_other_section').hide();
                    $('#field_fuel_other_desc').val('');
                } else {
                    $('#field_fuel_type').val('อื่นๆ');
                    $('#modal_fuel_other_section').show();
                    $('#field_fuel_other_desc').val(trip.fuel_type);
                }
            } else {
                $('#field_fuel_type').val('');
                $('#modal_fuel_other_section').hide();
                $('#field_fuel_other_desc').val('');
            }

            $('#field_fuel_amount').val(trip.fuel_amount || '');
            $('#field_fuel_po_book').val(trip.fuel_po_book || '');
            $('#field_fuel_po_number').val(trip.fuel_po_number || '');
            $('#field_fuel_po_date').val(trip.fuel_po_date || '');

            calcLiveDistance();
            $('#modalRecordTrip').modal('show');
        });

        // Fuel Toggle in Modal
        $('input[name="fuel_request"]').on('change', function () {
            if ($(this).val() === 'yes') {
                $('#modal_fuel_details_section').slideDown();
            } else {
                $('#modal_fuel_details_section').slideUp();
                $('#field_fuel_type').val('');
                $('#field_fuel_amount').val('');
                $('#field_fuel_other_desc').val('');
                $('#modal_fuel_other_section').hide();
            }
        });

        $('#field_fuel_type').on('change', function () {
            if ($(this).val() === 'อื่นๆ') {
                $('#modal_fuel_other_section').slideDown();
            } else {
                $('#modal_fuel_other_section').slideUp();
                $('#field_fuel_other_desc').val('');
            }
        });

        // Submit Trip Form
        $('#formRecordTrip').on('submit', function (e) {
            e.preventDefault();
            const $btn = $('#btnSaveTrip');
            const originalHtml = $btn.html();

            const dep = parseInt($('#field_departure_mileage').val()) || 0;
            const ret = parseInt($('#field_return_mileage').val()) || 0;
            if (dep > 0 && ret > 0 && ret < dep) {
                Swal.fire({
                    icon: 'warning',
                    title: 'เลขไมล์ไม่ถูกต้อง',
                    text: 'เลขไมล์เมื่อกลับถึงสำนักงานต้องไม่น้อยกว่าเลขไมล์ออกเดินทาง'
                });
                return;
            }

            $btn.html('<div class="spinner-border spinner-border-sm text-white me-1"></div> กำลังบันทึก...').prop('disabled', true);

            $.ajax({
                url: '<?= base_url("CarBooking/Driver/UpdateTrip") ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    if (res.status === 'success') {
                        $('#modalRecordTrip').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadTrips();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด',
                            text: res.message || 'ไม่สามารถบันทึกข้อมูลได้'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อผิดพลาด',
                        text: 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์'
                    });
                },
                complete: function () {
                    $btn.html(originalHtml).prop('disabled', false);
                }
            });
        });

        // เริ่มต้นโหลดงาน (เฉพาะเมื่อล็อกอินแล้ว)
        if (isLoggedIn) {
            loadTrips();
        }
    });
</script>
<?= $this->endSection() ?>