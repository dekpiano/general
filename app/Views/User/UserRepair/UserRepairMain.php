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
        --glass-bg: rgba(255, 255, 255, 0.8);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    .repair-container {
        padding-top: 1.5rem;
        padding-bottom: 3rem;
    }

    /* Premium Header */
    .glass-header {
        background: linear-gradient(135deg, rgba(105, 108, 255, 0.9) 0%, rgba(63, 65, 145, 0.9) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 2rem;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(105, 108, 255, 0.2);
    }

    .glass-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .glass-header h2 {
        color: white;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    /* Glass Stats Cards */
    .glass-stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 1.5rem;
        padding: 1.5rem;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .glass-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-right: 1.25rem;
        flex-shrink: 0;
    }

    .stat-info h6 {
        font-size: 0.85rem;
        color: var(--repair-secondary);
        margin-bottom: 0.25rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-info h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0;
        color: #566a7f;
    }

    /* Table Glass Card */
    .table-glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .card-header-premium {
        padding: 1.75rem 2rem;
        background: rgba(255, 255, 255, 0.5);
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
        padding: 0.75rem 1.5rem;
        border-radius: 1rem;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease;
    }

    .btn-glass-primary:hover {
        background: #f8f9ff !important;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2) !important;
        color: var(--repair-primary) !important;
    }

    .btn-add-repair {
        background: linear-gradient(135deg, #ff8a00 0%, #ff5e3a 100%);
        color: white !important;
        border: none;
        padding: 0.85rem 2.25rem;
        border-radius: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 25px rgba(255, 94, 58, 0.4);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        animation: pulse-repair 2s infinite;
        position: relative;
        overflow: hidden;
    }

    .btn-add-repair::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: rotate(45deg);
        transition: 0.5s;
        display: block;
        animation: shine-repair 3s infinite;
    }

    .btn-add-repair:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 30px rgba(255, 94, 58, 0.5);
        color: white !important;
    }

    @keyframes pulse-repair {
        0% { box-shadow: 0 0 0 0 rgba(255, 94, 58, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(255, 94, 58, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 94, 58, 0); }
    }

    @keyframes shine-repair {
        0% { left: -100%; transition-property: left; }
        20% { left: 100%; transition-property: left; }
        100% { left: 100%; transition-property: left; }
    }

    /* Status Badges Premium */
    .badge-premium {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    /* Filter Styling */
    .year-select {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        padding: 0.5rem 1rem;
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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
    }

    .repair-list-item:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        background: white;
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
        font-size: 0.8rem;
        color: var(--repair-secondary);
        font-weight: 600;
        white-space: nowrap;
    }

    .repair-list-item .list-order i {
        color: var(--repair-primary);
    }

    .repair-list-item .list-caselist {
        font-size: 1rem;
        font-weight: 700;
        color: #32475c;
        margin-bottom: 0.35rem;
        line-height: 1.4;
    }

    .repair-list-item .list-caselist i {
        color: var(--repair-primary);
    }

    .repair-list-item .list-detail {
        font-size: 0.82rem;
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
        font-size: 0.78rem;
        color: var(--repair-secondary);
    }

    .repair-list-item .list-meta-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .repair-list-item .list-meta-item i {
        color: var(--repair-primary);
        font-size: 0.9rem;
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

    /* Loading More Spinner */
    .repair-loading-more {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Scroll Hint */
    .repair-scroll-hint {
        animation: bounce-down 1.5s infinite;
    }

    @keyframes bounce-down {
        0%, 100% { transform: translateY(0); opacity: 0.6; }
        50% { transform: translateY(6px); opacity: 1; }
    }

    /* Loaded All */
    .repair-loaded-all {
        text-align: center;
        padding: 1.5rem 0;
        color: var(--repair-secondary);
        font-size: 0.8rem;
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
            padding: 1.25rem 1rem;
            border-radius: 1.25rem;
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .glass-header h2 {
            font-size: 1.2rem;
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
            font-size: 0.8rem;
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
            font-size: 0.9rem;
        }
        .repair-list-item .list-detail {
            font-size: 0.78rem;
        }
        .repair-list-item .list-meta {
            font-size: 0.72rem;
            gap: 0.25rem 0.75rem;
        }
        .table-glass-card {
            padding: 1rem !important;
            border-radius: 1.25rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 repair-container">
    
    <!-- Premium Header -->
    <div class="glass-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="display-6"><i class='bx bxs-wrench me-3'></i>แดชบอร์ด & ระบบแจ้งซ่อมออนไลน์</h2>
                <div class="d-flex align-items-center mt-2">
                    <span class="badge bg-white text-primary rounded-pill px-3 me-2">Repair Dashboard</span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?=base_url('Repair')?>" class="text-white-50">หน้าแรก</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">แดชบอร์ด & รายการแจ้งซ่อม</li>
                        </ol>
                    </nav>
                </div>
                <!-- ปุ่มคู่มือและตัวเลือกปี -->
                <div class="d-flex align-items-center gap-2 mt-4 flex-wrap">
                    <a target="_blank" href="<?=base_url('manual/repair') ?>" class="btn btn-glass-primary py-2">
                        <i class='bx bx-book-content me-1'></i> คู่มือการใช้งาน
                    </a>
                    <select class="year-select shadow-sm" id="yearFilter" onchange="window.location.href='<?=base_url('Repair')?>?year='+this.value">
                        <option value="all" <?= $selectedYear === 'all' ? 'selected' : '' ?>>ทุกปี (ทั้งหมด)</option>
                        <?php foreach($availableYears as $y): ?>
                        <option value="<?=$y?>" <?=(string)$y === (string)$selectedYear ? 'selected' : ''?>>ปี พ.ศ. <?=$y+543?> (<?=$y?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-md-end header-actions align-items-center mt-3 mt-md-0">
                <a href="<?=base_url('Repair/Add')?>" class="btn btn-add-repair">
                    <i class="bx bx-plus-circle me-1"></i> แจ้งซ่อมใหม่
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-2 g-md-3 mb-3">
        <div class="col-6 col-xl-3">
            <div class="glass-stat-card py-2 px-3">
                <div class="stat-icon bg-label-primary" style="width: 44px; height: 44px; font-size: 1.3rem; margin-right: 0.85rem; border-radius: 0.75rem;">
                    <i class='bx bxs-briefcase-alt-2'></i>
                </div>
                <div class="stat-info">
                    <h6 class="mb-0 text-muted" style="font-size: 0.72rem; font-weight: 700;">งานทั้งหมด</h6>
                    <h3 class="mb-0" style="font-size: 1.4rem; font-weight: 700;"><?= number_format($TotalRepair ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="glass-stat-card py-2 px-3">
                <div class="stat-icon bg-label-warning" style="width: 44px; height: 44px; font-size: 1.3rem; margin-right: 0.85rem; border-radius: 0.75rem;">
                    <i class='bx bxs-time-five'></i>
                </div>
                <div class="stat-info">
                    <h6 class="mb-0 text-muted" style="font-size: 0.72rem; font-weight: 700;">รอดำเนินการ</h6>
                    <h3 class="mb-0" style="font-size: 1.4rem; font-weight: 700;"><?= number_format($StatusPending ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="glass-stat-card py-2 px-3">
                <div class="stat-icon bg-label-info" style="width: 44px; height: 44px; font-size: 1.3rem; margin-right: 0.85rem; border-radius: 0.75rem;">
                    <i class='bx bxs-cog bxs-spin'></i>
                </div>
                <div class="stat-info">
                    <h6 class="mb-0 text-muted" style="font-size: 0.72rem; font-weight: 700;">กำลังดำเนินการ</h6>
                    <h3 class="mb-0" style="font-size: 1.4rem; font-weight: 700;"><?= number_format($StatusProcess ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="glass-stat-card py-2 px-3">
                <div class="stat-icon bg-label-success" style="width: 44px; height: 44px; font-size: 1.3rem; margin-right: 0.85rem; border-radius: 0.75rem;">
                    <i class='bx bxs-check-circle'></i>
                </div>
                <div class="stat-info">
                    <h6 class="mb-0 text-muted" style="font-size: 0.72rem; font-weight: 700;">เสร็จสิ้นแล้ว</h6>
                    <h3 class="mb-0" style="font-size: 1.4rem; font-weight: 700;"><?= number_format($StatusSuccess ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row (Compact) -->
    <div class="row g-2 g-md-3 mb-3">
        <!-- Monthly Trend Chart -->
        <div class="col-lg-7 col-xl-8">
            <div class="card border-0 shadow-sm rounded-3 p-2.5 p-md-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">
                        <i class='bx bx-bar-chart-alt-2 text-primary me-1'></i> สถิติงานซ่อมรายเดือน (<?= $selectedYear === 'all' ? 'ทุกปี' : ($selectedYear + 543) ?>)
                    </h6>
                </div>
                <div id="repairMonthlyChart" style="min-height: 180px;"></div>
            </div>
        </div>

        <!-- Category Breakdown Chart -->
        <div class="col-lg-5 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 p-2.5 p-md-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">
                        <i class='bx bx-pie-chart-alt-2 text-primary me-1'></i> ประเภทงานซ่อมยอดนิยม
                    </h6>
                </div>
                <div id="repairCategoryChart" style="min-height: 180px;"></div>
            </div>
        </div>
    </div>

    <!-- List View Section -->
    <div class="table-glass-card p-4">
        <div class="card-header-premium border-0 p-0 mb-4">
            <h5 class="mb-0 fw-bold">
                <i class="bx bx-list-check me-2 text-primary"></i>
                รายการแจ้งซ่อม (ประจำปี <?= $selectedYear === 'all' ? 'ทุกปี' : ($selectedYear + 543) ?>)
            </h5>
            <button type="button" class="btn btn-link text-secondary p-0" onclick="reloadCards()">
                <i class='bx bx-refresh fs-4'></i>
            </button>
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
        loadRepairCards();
    }

    $(document).ready(function() {
        $('.btn-add-repair').on('click', function() {
            $(this).html('<span class="spinner-border spinner-border-sm me-2"></span> กำลังไป...');
            $(this).addClass('disabled');
        });

        // Render Monthly ApexChart
        const monthlyData = <?= json_encode($stats['monthly']) ?>;
        const monthlyOptions = {
            series: [{
                name: 'จำนวนงานแจ้งซ่อม',
                data: monthlyData
            }],
            chart: {
                type: 'bar',
                height: 190,
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
                height: 190
            },
            colors: ['#696cff', '#71dd37', '#ffab00', '#03c3ec', '#ff3e1d'],
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
<?php if(file_exists(FCPATH . 'assets/js/User/UserRepair/UserRepairMain.js')): ?>
<script src="<?=base_url('assets/js/User/UserRepair/UserRepairMain.js?v='.time())?>"></script>
<?php endif; ?>
<?= $this->endSection() ?>


