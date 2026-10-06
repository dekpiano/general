<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('customCSS') ?>
<style>
    :root {
        --repair-primary: #696cff;
        --repair-secondary: #8592a3;
        --repair-success: #71dd37;
        --repair-info: #03c3ec;
        --repair-warning: #ffab00;
        --repair-danger: #ff3e1d;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    .repair-container {
        padding-top: 1.5rem;
        padding-bottom: 3rem;
    }

    /* Premium Hero Header (Ultra Contrast & Crisp Typography) */
    .glass-header {
        background: linear-gradient(135deg, #2e288a 0%, #3730a3 45%, #1e1b4b 100%);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 2rem;
        padding: 2.25rem 2.5rem;
        margin-bottom: 2rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 45px -10px rgba(46, 40, 138, 0.5);
    }

    .glass-header::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(165, 180, 252, 0.3) 0%, rgba(99, 102, 241, 0.05) 60%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .glass-header::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: 30%;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(244, 114, 182, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-title {
        color: #ffffff !important;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.25;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);
    }

    .hero-subtitle {
        color: #f1f5f9 !important;
        font-size: 0.95rem;
        font-weight: 400;
        max-width: 620px;
        line-height: 1.5;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }

    .hero-badge-pill {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #ffffff !important;
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.35rem 0.9rem;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .hero-badge-pill .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.45);
        animation: pulseAnimation 2s infinite;
    }

    @keyframes pulseAnimation {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { box-shadow: 0 0 0 9px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* Action Buttons with Crisp Solid Contrast */
    .btn-hero-action {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        color: #1e1b4b !important;
        padding: 0.65rem 1.25rem;
        border-radius: 0.85rem;
        font-weight: 800;
        font-size: 0.85rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
    }

    .btn-hero-action i {
        color: #4338ca !important;
        font-size: 1.1rem;
    }

    .btn-hero-action:hover {
        background: #f8faff !important;
        color: #312e81 !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-hero-sync {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        color: #ffffff !important;
        padding: 0.8rem 1.5rem;
        border-radius: 1rem;
        font-weight: 800;
        font-size: 0.9rem;
        box-shadow: 0 8px 24px rgba(2, 132, 199, 0.45);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .btn-hero-sync i {
        color: #ffffff !important;
    }

    .btn-hero-sync:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 30px rgba(2, 132, 199, 0.6);
        color: #ffffff !important;
    }

    .btn-hero-primary {
        background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
        color: #ffffff !important;
        padding: 0.8rem 1.75rem;
        border-radius: 1rem;
        font-weight: 800;
        font-size: 0.92rem;
        box-shadow: 0 8px 25px rgba(234, 88, 12, 0.45);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .btn-hero-primary i {
        color: #ffffff !important;
    }

    .btn-hero-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 32px rgba(234, 88, 12, 0.6);
        color: #ffffff !important;
    }

    .hero-year-select {
        background: #ffffff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23334155' stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") no-repeat right 0.85rem center/11px 11px;
        border: 1px solid #e2e8f0;
        color: #0f172a !important;
        font-weight: 800;
        font-size: 0.85rem;
        padding: 0.65rem 2.4rem 0.65rem 1.1rem;
        border-radius: 0.85rem;
        outline: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        transition: all 0.2s ease;
    }

    .hero-year-select option {
        background-color: #ffffff;
        color: #0f172a;
    }

    .hero-year-select:hover, .hero-year-select:focus {
        background-color: #f8faff;
        border-color: #cbd5e1;
        color: #0f172a !important;
    }

    /* Glass Stats Cards */
    .glass-stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 1.25rem;
        padding: 1.25rem 1.5rem;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    }

    .glass-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
        background: #ffffff;
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-right: 1.15rem;
        flex-shrink: 0;
    }

    .stat-info h6 {
        font-size: 0.8rem;
        color: var(--repair-secondary);
        margin-bottom: 0.2rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-info h3 {
        font-size: 1.65rem;
        font-weight: 800;
        margin-bottom: 0;
        color: #435971;
    }

    /* Table Glass Card */
    .table-glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 1.75rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .card-header-premium {
        padding: 1.5rem 2rem;
        background: rgba(255, 255, 255, 0.6);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Premium Buttons */
    .btn-glass-primary {
        background: #ffffff !important;
        color: var(--repair-primary) !important;
        border: none !important;
        padding: 0.65rem 1.25rem;
        border-radius: 0.85rem;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        transition: all 0.3s ease;
    }

    .btn-glass-primary:hover {
        background: #f8f9ff !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        color: var(--repair-primary) !important;
    }

    .btn-add-repair {
        background: linear-gradient(135deg, #ff8a00 0%, #ff5e3a 100%);
        color: white !important;
        border: none;
        padding: 0.85rem 2rem;
        border-radius: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 8px 20px rgba(255, 94, 58, 0.35);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-add-repair:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 12px 25px rgba(255, 94, 58, 0.45);
        color: white !important;
    }

    /* Filter Styling */
    .year-select {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        padding: 0.55rem 1rem;
        font-weight: 600;
        color: var(--repair-primary);
        cursor: pointer;
        outline: none;
    }

    /* List View Styling */
    .repair-list-item {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 1.25rem;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .repair-list-item:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        background: white;
        border-color: rgba(105, 108, 255, 0.25);
    }

    .repair-list-item .list-main {
        display: flex;
        gap: 1.25rem;
        align-items: flex-start;
    }

    .repair-list-item .list-images {
        flex-shrink: 0;
        width: 120px;
    }

    .repair-list-item .list-images .main-img {
        width: 120px;
        height: 90px;
        border-radius: 0.75rem;
        object-fit: cover;
        border: 2px solid rgba(105, 108, 255, 0.15);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .repair-list-item .list-images .main-img:hover {
        border-color: var(--repair-primary);
        transform: scale(1.03);
    }

    .repair-list-item .list-images .img-count-badge {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: rgba(0, 0, 0, 0.65);
        color: white;
        font-size: 0.65rem;
        padding: 0.15rem 0.45rem;
        border-radius: 0.5rem;
        line-height: 1.3;
    }

    .repair-list-item .list-images .no-image {
        width: 120px;
        height: 90px;
        border-radius: 0.75rem;
        background: #f0f2f5;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--glass-border);
        border: 2px dashed var(--glass-border);
    }

    .repair-list-item .list-images .no-image i {
        font-size: 1.75rem;
        margin-bottom: 0.25rem;
    }

    .repair-list-item .list-images .no-image span {
        font-size: 0.65rem;
    }

    .repair-list-item .list-content {
        flex: 1;
        min-width: 0;
    }

    .repair-list-item .list-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.4rem;
        gap: 0.75rem;
    }

    .repair-list-item .list-order {
        font-size: 0.82rem;
        color: var(--repair-secondary);
        font-weight: 700;
        white-space: nowrap;
    }

    .repair-list-item .list-order i {
        color: var(--repair-primary);
    }

    .repair-list-item .list-caselist {
        font-size: 1.05rem;
        font-weight: 700;
        color: #32475c;
        margin-bottom: 0.35rem;
        line-height: 1.4;
    }

    .repair-list-item .list-caselist i {
        color: var(--repair-primary);
    }

    .repair-list-item .list-detail {
        font-size: 0.85rem;
        color: var(--repair-secondary);
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.5;
    }

    .repair-list-item .list-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem 1.25rem;
        font-size: 0.8rem;
        color: var(--repair-secondary);
    }

    .repair-list-item .list-meta-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .repair-list-item .list-meta-item i {
        color: var(--repair-primary);
        font-size: 0.95rem;
    }

    .repair-list-item .list-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.6rem;
        padding-top: 0.6rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .repair-list-item .list-date {
        font-size: 0.75rem;
        color: var(--repair-secondary);
    }

    .repair-list-item .list-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* Image Preview Modal */
    .repair-img-preview-modal .modal-body {
        text-align: center;
        padding: 1rem;
    }

    .repair-img-preview-modal .modal-body img {
        max-width: 100%;
        max-height: 70vh;
        border-radius: 0.75rem;
    }

    /* Loading Spinner */
    .repair-loading {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 4rem 0;
    }

    .repair-loading .spinner-border {
        width: 3rem;
        height: 3rem;
        color: var(--repair-primary);
    }

    /* Empty State */
    .repair-empty {
        text-align: center;
        padding: 4rem 1rem;
        color: var(--repair-secondary);
    }

    .repair-empty i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    @media (max-width: 768px) {
        .repair-container {
            padding-top: 1rem;
            padding-bottom: 2rem;
        }
        .glass-header {
            padding: 1.5rem 1.25rem;
            border-radius: 1.25rem;
            margin-bottom: 1.5rem;
        }
        .glass-header h2 {
            font-size: 1.35rem;
        }
        .header-actions {
            margin-top: 1rem;
            justify-content: flex-start !important;
        }
        .btn-add-repair {
            width: 100%;
            text-align: center;
            padding: 0.75rem 1rem;
        }
        .year-select {
            width: 100%;
            font-size: 0.85rem;
        }
        .glass-stat-card {
            padding: 1rem;
            border-radius: 1rem;
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            font-size: 1.35rem;
            border-radius: 0.75rem;
            margin-right: 0.85rem;
        }
        .stat-info h3 {
            font-size: 1.35rem;
        }
        .stat-info h6 {
            font-size: 0.72rem;
        }
        .repair-list-item {
            padding: 1rem;
            border-radius: 1rem;
        }
        .repair-list-item .list-main {
            flex-direction: row;
            gap: 0.85rem;
        }
        .repair-list-item .list-images {
            width: 85px;
        }
        .repair-list-item .list-images .main-img,
        .repair-list-item .list-images .no-image {
            width: 85px;
            height: 80px;
            border-radius: 0.65rem;
        }
        .repair-list-item .list-caselist {
            font-size: 0.95rem;
        }
        .repair-list-item .list-detail {
            font-size: 0.78rem;
        }
        .repair-list-item .list-meta {
            font-size: 0.72rem;
            gap: 0.25rem 0.75rem;
        }
        .table-glass-card {
            padding: 1.25rem !important;
            border-radius: 1.25rem;
        }
    }

    /* SweetAlert2 Always on Top of Everything (Modals & Backdrops) */
    .swal2-container {
        z-index: 9999999 !important;
    }
    .swal2-popup {
        z-index: 10000000 !important;
    }
    .swal2-backdrop-show {
        z-index: 9999999 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$isLoggedIn = !empty($_SESSION['username']) || !empty($_SESSION['id']) || session()->get('logged_in') || session()->get('isLoggedIn') || session()->get('staffLogin');
?>
<div class="container-xxl flex-grow-1 repair-container">
    
    <!-- Premium Hero Header -->
    <div class="glass-header">
        <div class="row align-items-center g-4">
            <!-- Left Info Column -->
            <div class="col-lg-7">
                <!-- Badges & Breadcrumb -->
                <div class="d-flex align-items-center gap-2 mb-2.5 flex-wrap">
                    <span class="hero-badge-pill">
                        <span class="pulse-dot"></span>
                        ระบบบริหารงานแจ้งซ่อมบำรุง
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 py-0" style="font-size: 0.78rem;">
                            <li class="breadcrumb-item"><a href="<?=base_url()?>" class="text-white text-opacity-75 text-decoration-none">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="<?=base_url('Repair')?>" class="text-white text-opacity-75 text-decoration-none">ระบบแจ้งซ่อม</a></li>
                            <li class="breadcrumb-item active text-white fw-bold" aria-current="page">แดชบอร์ด</li>
                        </ol>
                    </nav>
                </div>

                <!-- Main Title & Subtitle -->
                <h1 class="hero-title h2 mb-2 d-flex align-items-center gap-2">
                    <i class='bx bx-pie-chart-alt-2 text-warning fs-2'></i>
                    ศูนย์วิเคราะห์และติดตามงานแจ้งซ่อม
                </h1>
                <p class="hero-subtitle mb-3.5">
                    สรุปภาพรวมสถิติการซ่อมบำรุง ติดตามสถานะงานแบบเรียลไทม์ และเชื่อมโยงข้อมูลกับระบบสารสนเทศ
                </p>

                <!-- Navigation Tools -->
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="<?=base_url('Repair')?>" class="btn-hero-action">
                        <i class='bx bx-grid-alt fs-6'></i> รายการแจ้งซ่อมทั้งหมด
                    </a>
                    <a target="_blank" href="<?=base_url('manual/repair') ?>" class="btn-hero-action">
                        <i class='bx bx-book-content fs-6'></i> คู่มือการใช้งาน
                    </a>
                    <select class="hero-year-select" id="yearFilter" onchange="window.location.href='<?=base_url('Repair/Dashboard')?>?year='+this.value">
                        <option value="all" <?= $selectedYear === 'all' ? 'selected' : '' ?>>แสดงทุกปี (สะสม)</option>
                        <?php foreach($availableYears as $y): ?>
                        <option value="<?=$y?>" <?=(string)$y === (string)$selectedYear ? 'selected' : ''?>>ปี พ.ศ. <?=$y+543?> (<?=$y?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Right Action Buttons Column -->
            <div class="col-lg-5">
                <div class="d-flex flex-column flex-sm-row justify-content-lg-end align-items-stretch align-items-sm-center gap-2.5">
                    <!-- API Sync Button (แสดงเฉพาะผู้ที่เข้าสู่ระบบแล้ว) -->
                    <?php if ($isLoggedIn): ?>
                    <button type="button" class="btn-hero-sync justify-content-center" onclick="openITSupportSyncModal()" title="ดึงข้อมูลงานบริการจากระบบ IT Support">
                        <i class='bx bx-cloud-download fs-4'></i>
                        <span>ดึงข้อมูล IT Support</span>
                    </button>
                    <?php endif; ?>

                    <!-- New Repair Request Button -->
                    <a href="<?=base_url('Repair/Add')?>" class="btn-hero-primary justify-content-center">
                        <i class="bx bx-plus-circle fs-4"></i>
                        <span>แจ้งซ่อมใหม่</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-2 g-md-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="glass-stat-card py-3 px-3">
                <div class="stat-icon bg-label-primary">
                    <i class='bx bxs-briefcase-alt-2'></i>
                </div>
                <div class="stat-info">
                    <h6>งานทั้งหมด</h6>
                    <h3><?= number_format($TotalRepair ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="glass-stat-card py-3 px-3">
                <div class="stat-icon bg-label-warning">
                    <i class='bx bxs-time-five'></i>
                </div>
                <div class="stat-info">
                    <h6>รอดำเนินการ</h6>
                    <h3><?= number_format($StatusPending ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="glass-stat-card py-3 px-3">
                <div class="stat-icon bg-label-info">
                    <i class='bx bxs-cog bxs-spin'></i>
                </div>
                <div class="stat-info">
                    <h6>กำลังดำเนินการ</h6>
                    <h3><?= number_format($StatusProcess ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="glass-stat-card py-3 px-3">
                <div class="stat-icon bg-label-success">
                    <i class='bx bxs-check-circle'></i>
                </div>
                <div class="stat-info">
                    <h6>เสร็จสิ้นแล้ว</h6>
                    <h3><?= number_format($StatusSuccess ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <!-- Monthly Trend Chart -->
        <div class="col-lg-7 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 h-100" style="background: var(--glass-bg); backdrop-filter: blur(15px); border: 1px solid var(--glass-border) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class='bx bx-bar-chart-alt-2 text-primary me-2'></i> สถิติงานแจ้งซ่อมรายเดือน (<?= $selectedYear === 'all' ? 'ทุกปี' : ($selectedYear + 543) ?>)
                    </h6>
                    <span class="badge bg-label-primary rounded-pill px-3">Monthly Trends</span>
                </div>
                <div id="repairMonthlyChart" style="min-height: 220px;"></div>
            </div>
        </div>

        <!-- Category Breakdown Chart -->
        <div class="col-lg-5 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 h-100" style="background: var(--glass-bg); backdrop-filter: blur(15px); border: 1px solid var(--glass-border) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class='bx bx-pie-chart-alt-2 text-primary me-2'></i> สัดส่วนตามประเภทงานซ่อม
                    </h6>
                    <span class="badge bg-label-info rounded-pill px-3">Category Share</span>
                </div>
                <div id="repairCategoryChart" style="min-height: 220px;"></div>
            </div>
        </div>
    </div>

    <!-- List View Section -->
    <div class="table-glass-card p-4">
        <div class="card-header-premium border-0 p-0 mb-4">
            <div>
                <h5 class="mb-1 fw-bold text-dark">
                    <i class="bx bx-list-check me-2 text-primary"></i>
                    รายการแจ้งซ่อมทั้งหมด (ประจำปี <?= $selectedYear === 'all' ? 'ทุกปี' : ($selectedYear + 543) ?>)
                </h5>
                <p class="text-muted small mb-0">แสดงรายการแจ้งซ่อมพร้อมสถานะและรูปภาพประกอบ</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="reloadCards()">
                    <i class='bx bx-refresh me-1'></i> รีเฟรชข้อมูล
                </button>
            </div>
        </div>
        <div id="repairListContainer">
            <!-- List items loaded via AJAX -->
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade repair-img-preview-modal" id="repairImgPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: transparent; border: none;">
            <div class="modal-body p-0 text-center">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                <img id="repairImgPreview" src="" alt="Preview">
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const SESSION_PERS_ID = '<?= session()->get('id') ?? '' ?>';

    function reloadCards() {
        if (typeof loadRepairCards === 'function') {
            loadRepairCards();
        }
    }

    $(document).ready(function() {
        // Render Monthly ApexChart
        const monthlyData = <?= json_encode($stats['monthly']) ?>;
        const monthlyOptions = {
            series: [{
                name: 'จำนวนงานแจ้งซ่อม',
                data: monthlyData
            }],
            chart: {
                type: 'bar',
                height: 220,
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
        const monthlyChart = new ApexCharts(document.querySelector("#repairMonthlyChart"), monthlyOptions);
        monthlyChart.render();

        // Render Category Donut ApexChart
        const caselistLabels = <?= json_encode($stats['topCaselists']['labels']) ?>;
        const caselistSeries = <?= json_encode($stats['topCaselists']['series']) ?>;
        const caselistOptions = {
            series: caselistSeries.length > 0 ? caselistSeries : [1],
            labels: caselistLabels.length > 0 ? caselistLabels : ['ไม่มีข้อมูล'],
            chart: {
                type: 'donut',
                height: 220
            },
            colors: ['#696cff', '#03c3ec', '#71dd37', '#ffab00', '#ff3e1d'],
            legend: {
                position: 'bottom',
                fontSize: '12px'
            },
            dataLabels: { enabled: true }
        };
        const categoryChart = new ApexCharts(document.querySelector("#repairCategoryChart"), caselistOptions);
        categoryChart.render();
    });
</script>

<!-- Modal: Sync IT Support API Data (Ultra Contrast Edition) -->
<style>
    #modalSyncITSupport .modal-content {
        border-radius: 1.75rem;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.45);
        overflow: hidden;
    }
    #modalSyncITSupport .modal-header {
        background: linear-gradient(135deg, #2e288a 0%, #3730a3 50%, #1e1b4b 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
    }
    #modalSyncITSupport .modal-header::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 160px;
        height: 160px;
        background: radial-gradient(circle, rgba(165, 180, 252, 0.25) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .it-sync-filter-card {
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid #cbd5e1;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }
    .it-filter-tab-btn {
        border: 1px solid transparent;
        background: #e2e8f0;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.82rem;
        font-weight: 800;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .it-filter-tab-btn.active {
        background: #3730a3 !important;
        color: #ffffff !important;
        border-color: #3730a3;
        box-shadow: 0 4px 12px rgba(55, 48, 163, 0.35);
    }
    .it-filter-tab-btn:hover:not(.active) {
        background: #cbd5e1;
        color: #0f172a;
    }
    .it-sync-table th {
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #0f172a;
        background: #e2e8f0;
        border-bottom: 2px solid #cbd5e1;
        padding: 0.9rem 0.75rem;
    }
    .it-sync-table td {
        padding: 0.9rem 0.75rem;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.88rem;
        color: #0f172a;
        vertical-align: middle;
    }
    .it-sync-table tr:hover:not(.is-disabled-row) {
        background-color: #f1f5f9;
    }
    .it-sync-table tr.is-selected-row {
        background-color: #e0e7ff !important;
    }
    .it-sync-table tr.is-disabled-row {
        background-color: #f8fafc;
        opacity: 0.75;
    }
    .it-badge-ticket {
        background: #f1f5f9;
        color: #0f172a !important;
        border: 1px solid #94a3b8;
        font-weight: 800;
    }
    .it-badge-cat {
        background: #e0e7ff;
        color: #1e1b4b !important;
        border: 1px solid #818cf8;
        font-weight: 800;
    }
    .it-badge-new {
        background: #d1fae5;
        color: #065f46 !important;
        border: 1px solid #34d399;
        font-weight: 800;
    }
    .it-badge-imported {
        background: #e2e8f0;
        color: #1e293b !important;
        border: 1px solid #94a3b8;
        font-weight: 800;
    }
    .it-badge-img {
        background: #cffafe;
        color: #0e7490 !important;
        border: 1px solid #22d3ee;
        font-weight: 800;
    }
    .btn-sync-submit-main {
        background: linear-gradient(135deg, #3730a3 0%, #2e288a 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        color: #ffffff !important;
        padding: 0.75rem 1.8rem;
        border-radius: 0.9rem;
        font-weight: 800;
        font-size: 0.92rem;
        box-shadow: 0 6px 22px rgba(46, 40, 138, 0.45);
        transition: all 0.25s ease;
    }
    .btn-sync-submit-main:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(46, 40, 138, 0.6);
        color: #ffffff !important;
    }
    .btn-sync-submit-main:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        box-shadow: none;
    }
</style>

<?php if ($isLoggedIn): ?>
<div class="modal fade" id="modalSyncITSupport" tabindex="-1" aria-labelledby="modalSyncITSupportLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-white p-3.5 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white bg-opacity-20 rounded-3 p-2.5 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; border: 1px solid rgba(255,255,255,0.35);">
                        <i class="bx bx-cloud-download text-info fs-2"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-0.5">
                            <h5 class="modal-title fw-bold text-white mb-0" id="modalSyncITSupportLabel">
                                ดึงและนำเข้าข้อมูลจากระบบ IT Support API
                            </h5>
                            <span class="badge bg-emerald-500 bg-opacity-25 text-white border border-emerald-400 rounded-pill px-2.5 py-0.5 fw-bold" style="font-size: 0.72rem;">
                                <i class="bx bx-check-circle me-1 text-emerald-300"></i>PAO-ERC REST API
                            </span>
                        </div>
                        <p class="text-white mb-0" style="font-size: 0.85rem; color: #e2e8f0 !important;">
                            ดึงประวัติการปฏิบัติงาน IT Support มาบันทึกเป็นใบงานซ่อมบำรุงในระบบ พร้อมนำเข้าภาพถ่ายอัตโนมัติ
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-3 p-md-4" style="background-color: #f8fafc;">
                <!-- Filter Control Card -->
                <div class="it-sync-filter-card p-3 mb-3">
                    <div class="row g-2 align-items-center">
                        <!-- Search Box -->
                        <div class="col-lg-4 col-md-6">
                            <label class="small fw-bold text-dark mb-1 d-block"><i class="bx bx-search text-primary me-1"></i>ค้นหาคำสำคัญ</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-dark"><i class="bx bx-search"></i></span>
                                <input type="text" id="itSyncSearch" class="form-control bg-white border-start-0 text-dark fw-semibold" placeholder="ค้นหารายละเอียด, รหัส Ticket, สถานที่..." onkeyup="handleITSyncSearch(event)" style="color: #0f172a !important;">
                            </div>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="col-lg-3 col-md-6">
                            <label class="small fw-bold text-dark mb-1 d-block"><i class="bx bx-category text-primary me-1"></i>หมวดหมู่งาน IT</label>
                            <select id="itSyncCategory" class="form-select bg-white text-dark fw-semibold" onchange="fetchITSupportData()" style="color: #0f172a !important; border-color: #cbd5e1;">
                                <option value="">-- ทุกหมวดหมู่ IT --</option>
                                <option value="🛠️ IT Support & Service">🛠️ IT Support & Service</option>
                                <option value="🎤 งานโสตทัศนศึกษา">🎤 งานโสตทัศนศึกษา</option>
                                <option value="💻 พัฒนาและบำรุงรักษาระบบสารสนเทศ">💻 พัฒนาระบบสารสนเทศ</option>
                                <option value="🏛️ งานอื่นๆ ตามคำสั่ง">🏛️ งานอื่นๆ ตามคำสั่ง</option>
                                <option value="📚 การอบรม/พัฒนาตนเอง">📚 การอบรม/พัฒนาตนเอง</option>
                                <option value="👥 งานประชุม">👥 งานประชุม</option>
                            </select>
                        </div>

                        <!-- Limit Selector -->
                        <div class="col-lg-2 col-6">
                            <label class="small fw-bold text-dark mb-1 d-block"><i class="bx bx-list-ol text-primary me-1"></i>จำนวนที่ดึง</label>
                            <select id="itSyncLimit" class="form-select bg-white text-dark fw-semibold" onchange="fetchITSupportData()" style="color: #0f172a !important; border-color: #cbd5e1;">
                                <option value="20">20 รายการ</option>
                                <option value="50" selected>50 รายการ</option>
                                <option value="100">100 รายการ</option>
                            </select>
                        </div>

                        <!-- Refresh Button -->
                        <div class="col-lg-3 col-6 d-flex flex-column justify-content-end">
                            <label class="small fw-bold text-transparent mb-1 d-none d-lg-block">โหลด</label>
                            <button type="button" class="btn btn-primary w-100 fw-bold d-flex align-items-center justify-content-center gap-1.5 shadow-sm py-2" onclick="fetchITSupportData()" style="background-color: #3730a3; border-color: #3730a3;">
                                <i class="bx bx-refresh fs-5 text-white"></i> <span class="text-white">โหลดข้อมูลใหม่</span>
                            </button>
                        </div>
                    </div>

                    <!-- Quick Filter Tabs & Summary Row -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 pt-3 mt-3 border-top" style="border-color: #e2e8f0 !important;">
                        <!-- Quick View Tabs -->
                        <div class="d-flex align-items-center gap-1.5 p-1 rounded-3" style="background: #f1f5f9; width: fit-content; border: 1px solid #cbd5e1;">
                            <button type="button" class="it-filter-tab-btn active" id="tabFilterAll" onclick="setITFilterTab('all')">
                                ทั้งหมด (<span id="countTabAll">0</span>)
                            </button>
                            <button type="button" class="it-filter-tab-btn" id="tabFilterNew" onclick="setITFilterTab('new')">
                                ✨ เฉพาะรายการใหม่ (<span id="countTabNew">0</span>)
                            </button>
                            <button type="button" class="it-filter-tab-btn" id="tabFilterImported" onclick="setITFilterTab('imported')">
                                ✔ นำเข้าแล้ว (<span id="countTabImported">0</span>)
                            </button>
                        </div>

                        <!-- Batch Select Controls -->
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3 shadow-sm" onclick="selectAllNewTickets()" style="border-color: #3730a3; color: #3730a3;">
                                <i class="bx bx-check-double me-1"></i>เลือกรายการใหม่ทั้งหมด
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5" onclick="deselectAllTickets()" title="ล้างการเลือก">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Card Container -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white" style="border: 1px solid #cbd5e1 !important;">
                    <div class="table-responsive" style="max-height: 440px;">
                        <table class="table it-sync-table align-middle mb-0" id="tableITSync">
                            <thead class="sticky-top" style="z-index: 5;">
                                <tr>
                                    <th width="45" class="text-center">
                                        <input type="checkbox" class="form-check-input" id="checkAllITSync" onchange="toggleMasterCheckbox(this)" title="เลือกทั้งหมด" style="border-color: #64748b; cursor: pointer;">
                                    </th>
                                    <th width="130">วันที่ปฏิบัติงาน</th>
                                    <th width="140">รหัส Ticket</th>
                                    <th width="160">หมวดหมู่ IT</th>
                                    <th>รายละเอียดงาน & สถานที่</th>
                                    <th width="85" class="text-center">รูปภาพ</th>
                                    <th width="135" class="text-center">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody id="itSyncTableBody">
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-dark fw-bold">
                                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div> กำลังเชื่อมต่อและดึงข้อมูลจาก IT Support API...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-white border-top p-3.5 px-4 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3" style="border-color: #e2e8f0 !important;">
                <div class="small fw-semibold text-dark d-flex align-items-center gap-1.5 text-center text-sm-start" style="color: #1e293b !important;">
                    <i class="bx bx-info-circle text-primary fs-5"></i>
                    <span>ระบบจะดาวน์โหลดรูปภาพและบันทึกสถานะเป็น <b class="text-primary">"ดำเนินการเรียบร้อย"</b> ให้อัตโนมัติ</span>
                </div>
                <div class="d-flex align-items-center gap-2.5 w-100 w-sm-auto justify-content-end">
                    <button type="button" class="btn btn-light px-4 rounded-3 fw-bold border text-dark" data-bs-dismiss="modal" style="background-color: #f1f5f9; border-color: #cbd5e1; color: #334155 !important;">
                        ปิด
                    </button>
                    <button type="button" id="btnSubmitSync" class="btn btn-sync-submit-main d-flex align-items-center gap-2" onclick="submitSyncITSupport()" disabled>
                        <i class="bx bx-download fs-5 text-white"></i>
                        <span>นำเข้าข้อมูลที่เลือก (<span id="btnSyncCount">0</span>)</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let rawITTickets = [];
    let currentITFilterTab = 'all';

    function openITSupportSyncModal() {
        const modalEl = document.getElementById('modalSyncITSupport');
        if (modalEl) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
            fetchITSupportData();
        }
    }

    function handleITSyncSearch(e) {
        if (e.key === 'Enter') {
            fetchITSupportData();
        }
    }

    function setITFilterTab(tab) {
        currentITFilterTab = tab;
        document.querySelectorAll('.it-filter-tab-btn').forEach(btn => btn.classList.remove('active'));
        if (tab === 'all') document.getElementById('tabFilterAll')?.classList.add('active');
        if (tab === 'new') document.getElementById('tabFilterNew')?.classList.add('active');
        if (tab === 'imported') document.getElementById('tabFilterImported')?.classList.add('active');
        applyFilterAndRender();
    }

    function fetchITSupportData() {
        const search = document.getElementById('itSyncSearch')?.value || '';
        const category = document.getElementById('itSyncCategory')?.value || '';
        const limit = document.getElementById('itSyncLimit')?.value || 50;
        const tbody = document.getElementById('itSyncTableBody');

        if (tbody) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-5 text-dark fw-bold">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div> กำลังดึงข้อมูลจาก IT Support API...
                    </td>
                </tr>
            `;
        }

        const formData = new FormData();
        formData.append('search', search);
        formData.append('category', category);
        formData.append('limit', limit);

        fetch('<?= base_url("Repair/Api/FetchITSupport") ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(result => {
            if (result.status === 'success') {
                rawITTickets = result.data || [];
                updateTabCounts();
                applyFilterAndRender();
            } else {
                if (tbody) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="text-center py-5 text-danger fw-bold">
                                <i class="bx bx-error-circle fs-3 d-block mb-1 text-danger"></i> ${result.message || 'ไม่สามารถดึงข้อมูลได้'}
                            </td>
                        </tr>
                    `;
                }
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-5 text-danger fw-bold">
                            <i class="bx bx-wifi-off fs-3 d-block mb-1 text-danger"></i> การเชื่อมต่อขัดข้อง: ${err.message}
                        </td>
                    </tr>
                `;
            }
        });
    }

    function updateTabCounts() {
        const total = rawITTickets.length;
        const newCount = rawITTickets.filter(t => !t.is_imported).length;
        const importedCount = rawITTickets.filter(t => t.is_imported).length;

        const elAll = document.getElementById('countTabAll');
        const elNew = document.getElementById('countTabNew');
        const elImp = document.getElementById('countTabImported');

        if (elAll) elAll.textContent = total;
        if (elNew) elNew.textContent = newCount;
        if (elImp) elImp.textContent = importedCount;
    }

    function applyFilterAndRender() {
        let filtered = rawITTickets;
        if (currentITFilterTab === 'new') {
            filtered = rawITTickets.filter(t => !t.is_imported);
        } else if (currentITFilterTab === 'imported') {
            filtered = rawITTickets.filter(t => t.is_imported);
        }

        renderITTable(filtered);
    }

    function renderITTable(tickets) {
        const tbody = document.getElementById('itSyncTableBody');
        const checkAll = document.getElementById('checkAllITSync');
        if (checkAll) checkAll.checked = false;
        updateSelectedCount();

        if (!tbody) return;

        if (tickets.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted fw-bold">
                        <i class="bx bx-inbox fs-2 d-block mb-1 text-secondary"></i> ไม่พบรายการข้อมูลในหมวดนี้
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        tickets.forEach((t) => {
            const origIndex = rawITTickets.indexOf(t);
            const isImported = t.is_imported === true;
            const disabledAttr = isImported ? 'disabled' : '';
            const rowClass = isImported ? 'is-disabled-row' : '';

            const badgeStatus = isImported 
                ? `<span class="badge it-badge-imported px-2.5 py-1" title="รหัสใบงาน: ${t.matched_repair_order || ''}"><i class="bx bx-check-double me-1 text-dark"></i>นำเข้าแล้ว</span>`
                : `<span class="badge it-badge-new px-2.5 py-1"><i class="bx bx-plus-circle me-1 text-success"></i>พร้อมนำเข้า</span>`;

            const imgCount = t.image_count || (t.images ? t.images.length : 0);
            let imgBadge = '<span class="text-muted small fw-bold">-</span>';
            if (imgCount > 0) {
                imgBadge = `<span class="badge it-badge-img px-2.5 py-1 rounded-pill" title="${imgCount} รูปภาพ"><i class="bx bx-image me-1"></i>${imgCount}</span>`;
            }

            html += `
                <tr class="${rowClass}" id="it-row-${origIndex}">
                    <td class="text-center">
                        <input type="checkbox" class="form-check-input it-sync-chk" value="${origIndex}" ${disabledAttr} onchange="handleRowCheckboxChange(this, ${origIndex})" style="border-color: #64748b; cursor: pointer;">
                    </td>
                    <td class="small fw-bold text-nowrap" style="color: #0f172a;">
                        <i class="bx bx-calendar text-primary me-1"></i>${t.date_formatted || t.date || '-'}
                    </td>
                    <td>
                        <span class="badge it-badge-ticket font-monospace px-2.5 py-1" style="font-size: 0.8rem;">
                            ${t.ticket_code || '-'}
                        </span>
                    </td>
                    <td>
                        <span class="badge it-badge-cat text-wrap text-start px-2.5 py-1.5" style="font-size: 0.76rem; line-height: 1.3;">
                            ${t.category || '-'}
                        </span>
                    </td>
                    <td>
                        <div class="fw-bold mb-1" style="font-size: 0.9rem; color: #0f172a; max-width: 380px; line-height: 1.45;">
                            ${escapeHtml(t.task || '')}
                        </div>
                        ${t.location ? `<div class="small d-flex align-items-center gap-1" style="color: #475569;"><i class="bx bx-map-pin text-danger"></i><span class="fw-semibold">${escapeHtml(t.location)}</span></div>` : ''}
                    </td>
                    <td class="text-center">${imgBadge}</td>
                    <td class="text-center">${badgeStatus}</td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
    }

    function handleRowCheckboxChange(chk, idx) {
        const row = document.getElementById(`it-row-${idx}`);
        if (row) {
            if (chk.checked) {
                row.classList.add('is-selected-row');
            } else {
                row.classList.remove('is-selected-row');
            }
        }
        updateSelectedCount();
    }

    function toggleMasterCheckbox(master) {
        const checkboxes = document.querySelectorAll('.it-sync-chk:not([disabled])');
        checkboxes.forEach(chk => {
            chk.checked = master.checked;
            const idx = chk.value;
            const row = document.getElementById(`it-row-${idx}`);
            if (row) {
                if (master.checked) row.classList.add('is-selected-row');
                else row.classList.remove('is-selected-row');
            }
        });
        updateSelectedCount();
    }

    function selectAllNewTickets() {
        const checkboxes = document.querySelectorAll('.it-sync-chk:not([disabled])');
        checkboxes.forEach(chk => {
            chk.checked = true;
            const idx = chk.value;
            const row = document.getElementById(`it-row-${idx}`);
            if (row) row.classList.add('is-selected-row');
        });
        const master = document.getElementById('checkAllITSync');
        if (master) master.checked = true;
        updateSelectedCount();
    }

    function deselectAllTickets() {
        const checkboxes = document.querySelectorAll('.it-sync-chk');
        checkboxes.forEach(chk => {
            chk.checked = false;
            const idx = chk.value;
            const row = document.getElementById(`it-row-${idx}`);
            if (row) row.classList.remove('is-selected-row');
        });
        const master = document.getElementById('checkAllITSync');
        if (master) master.checked = false;
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const checked = document.querySelectorAll('.it-sync-chk:checked');
        const count = checked.length;
        const btnCountEl = document.getElementById('btnSyncCount');
        const btnSubmit = document.getElementById('btnSubmitSync');

        if (btnCountEl) btnCountEl.textContent = count;
        if (btnSubmit) btnSubmit.disabled = (count === 0);
    }

    function submitSyncITSupport() {
        const checked = document.querySelectorAll('.it-sync-chk:checked');
        if (checked.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกรายการ',
                text: 'โปรดเลือกรายการงาน IT Support ที่ต้องการนำเข้าอย่างน้อย 1 รายการ'
            });
            return;
        }

        const selectedTickets = [];
        checked.forEach(chk => {
            const idx = parseInt(chk.value);
            if (rawITTickets[idx]) {
                selectedTickets.push(rawITTickets[idx]);
            }
        });

        Swal.fire({
            title: 'ยืนยันการนำเข้าข้อมูล?',
            text: `คุณต้องการนำเข้ารายการที่เลือกจำนวน ${selectedTickets.length} รายการ เข้าสู่ระบบแจ้งซ่อมใช่หรือไม่?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3730a3',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'ยืนยันนำเข้าข้อมูล',
            cancelButtonText: 'ยกเลิก'
        }).then((res) => {
            if (res.isConfirmed) {
                Swal.fire({
                    title: 'กำลังนำเข้าข้อมูล...',
                    text: 'ระบบกำลังบันทึกลงฐานข้อมูลและดาวน์โหลดรูปภาพประกอบ กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const formData = new FormData();
                formData.append('tickets', JSON.stringify(selectedTickets));

                fetch('<?= base_url("Repair/Api/SyncITSupport") ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(result => {
                    if (result.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'นำเข้าข้อมูลสำเร็จ!',
                            text: result.message || `นำเข้าสำเร็จ ${result.imported_count} รายการ`,
                            confirmButtonColor: '#3730a3'
                        }).then(() => {
                            const modalEl = document.getElementById('modalSyncITSupport');
                            if (modalEl) {
                                const modal = bootstrap.Modal.getInstance(modalEl);
                                if (modal) modal.hide();
                            }
                            if (typeof reloadCards === 'function') {
                                reloadCards();
                            } else {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: result.message || 'ไม่สามารถนำเข้าข้อมูลได้'
                        });
                    }
                })
                .catch(err => {
                    console.error('Sync error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                        text: err.message
                    });
                });
            }
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
    }
</script>
<?php endif; ?>

<?= $this->endSection() ?>