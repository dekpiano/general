<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    /* --- Premium Variables --- */
    :root {
        --booking-primary: #696cff;
        --booking-secondary: #8592a3;
        --booking-success: #71dd37;
        --booking-warning: #ffab00;
        --booking-danger: #ff3e1d;
        --booking-info: #03c3ec;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.5);
        --booking-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --premium-shadow: 0 10px 30px -5px rgba(105, 108, 255, 0.15);
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .premium-animate {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Page Header --- */
    .page-header {
        background: var(--booking-gradient);
        border-radius: 20px;
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 15px 40px -10px rgba(105, 108, 255, 0.3);
    }

    .header-content { position: relative; z-index: 2; }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .page-header h2 {
        color: #fff;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 0.5rem;
    }

    .page-header p { color: rgba(255,255,255,0.8); margin-bottom: 0; }

    .btn-white {
        background-color: #ffffff !important;
        color: var(--booking-primary) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        transition: all 0.3s ease;
    }
    .btn-white:hover {
        background-color: #f8f9ff !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.2) !important;
    }

    /* --- Category Divider --- */
    .category-divider {
        display: flex;
        align-items: center;
        margin: 2.5rem 0 1.5rem;
    }

    .category-divider::after {
        content: "";
        flex: 1;
        height: 2px;
        background: linear-gradient(to right, rgba(105, 108, 255, 0.2), transparent);
        margin-left: 1.5rem;
    }

    .category-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #566a7f;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .category-title i {
        color: var(--booking-primary);
        background: rgba(105, 108, 255, 0.1);
        padding: 8px;
        border-radius: 10px;
    }

    /* --- Location Cards --- */
    .location-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: var(--premium-shadow);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .location-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(105, 108, 255, 0.25);
    }

    .location-img-wrapper {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .location-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .location-card:hover img {
        transform: scale(1.1);
    }

    .location-badge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(255, 255, 255, 0.9);
        color: var(--booking-primary);
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        backdrop-filter: blur(4px);
    }

    .card-body-premium {
        padding: 1.25rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .location-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: #32475c;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* --- Mini Calendar Styling Enhancements --- */
    .mini-calendar-container {
        background: #f8faff;
        border-radius: 15px;
        padding: 10px;
        border: 1px solid rgba(105, 108, 255, 0.05);
        margin-top: auto;
    }

    .month-selector, .year-selector {
        border-radius: 10px !important;
        border: 1px solid #e2e8f0 !important;
        font-size: 0.85rem !important;
        background-color: #fff !important;
    }

    /* Override mini-calendar.css for premium look */
    .calendar-grid { border: none !important; background: transparent !important; }
    .calendar-header-row { background: transparent !important; border-bottom: 2px solid rgba(105, 108, 255, 0.1) !important; }
    .calendar-header-cell { color: var(--booking-primary) !important; font-weight: 700 !important; font-size: 0.7rem !important; }
    .calendar-cell { 
        min-height: 32px !important; 
        border: none !important; 
        border-radius: 8px !important; 
        margin: 1px !important;
        background: #fff;
    }
    .calendar-cell:hover { background-color: rgba(105, 108, 255, 0.1) !important; }
    .calendar-cell.empty { background: transparent !important; }
    .calendar-cell.status-approved { background: linear-gradient(135deg, #71dd37 0%, #5bb82d 100%) !important; box-shadow: 0 4px 10px -2px rgba(113, 221, 55, 0.4); }
    .calendar-cell.status-pending { background: linear-gradient(135deg, #ffab00 0%, #e69a00 100%) !important; box-shadow: 0 4px 10px -2px rgba(255, 171, 0, 0.4); }

    /* --- Sidebar Actions --- */
    .action-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(105, 108, 255, 0.05);
        transition: all 0.3s ease;
        text-decoration: none !important;
        display: block;
    }

    .action-card:hover {
        background: var(--booking-primary);
        transform: translateX(-5px);
        box-shadow: 0 10px 20px -5px rgba(105, 108, 255, 0.3);
    }

    .action-card:hover .text-muted, 
    .action-card:hover .text-dark,
    .action-card:hover h5,
    .action-card:hover h6 { color: #fff !important; }

    .action-card:hover .bg-label-primary { background: rgba(255,255,255,0.2) !important; color: #fff !important; }
    .action-card:hover .bg-label-warning { background: rgba(255,255,255,0.2) !important; color: #fff !important; }
    .action-card:hover .bg-label-success { background: rgba(255,255,255,0.2) !important; color: #fff !important; }
    .action-card:hover .bg-label-info { background: rgba(255,255,255,0.2) !important; color: #fff !important; }

    .admin-stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 4px 0;
        border-bottom: 1px dashed rgba(0,0,0,0.05);
    }
    .action-card:hover .admin-stat-row { border-color: rgba(255,255,255,0.1); }
</style>
<link rel="stylesheet" href="<?= base_url('assets/css/User/UserBooking/mini-calendar.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Premium Page Header -->
    <div class="page-header premium-animate">
        <div class="header-content">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="d-flex align-items-center mb-2">
                        <i class='bx bxs-calendar-check fs-2 me-2'></i>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="<?=base_url()?>" class="text-white-50">หน้าแรก</a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">จองสถานที่</li>
                            </ol>
                        </nav>
                    </div>
                    <h2>ระบบจองห้องและสถานที่</h2>
                    <p>เลือกห้องที่ท่านต้องการ และตรวจสอบวันว่างในปฏิทินเพื่อเลือกวันเวลาปฏิบัติงาน</p>
                </div>
                <div class="col-md-3 text-md-end mt-3 mt-md-0">
                    <a target="_blank" href="<?=base_url('manual/booking') ?>" class="btn btn-white text-primary fw-bold shadow-sm rounded-pill px-4">
                        <i class='bx bx-book-content me-1'></i> คู่มือการใช้งาน
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content: Location List -->
        <div class="col-lg-9 order-2 order-lg-1">
            <?php 
            $categories = [];
            if(isset($LocationList) && !empty($LocationList)) {
                foreach($LocationList as $location) {
                    $cat = $location->location_category ?: 'สถานที่อื่นๆ';
                    if(!isset($categories[$cat])) {
                        $categories[$cat] = [];
                    }
                    $categories[$cat][] = $location;
                }
            }
            ?>

            <?php $delay = 0.2; ?>
            <?php foreach($categories as $categoryName => $locations): ?>
                <div class="category-divider premium-animate" style="animation-delay: <?= $delay ?>s">
                    <div class="category-title">
                        <i class='bx bxs-collection'></i>
                        <?= $categoryName ?>
                    </div>
                </div>
                <?php $delay += 0.1; ?>
                
                <div class="row g-4 mb-4">
                    <?php foreach($locations as $index => $location): ?>
                        <div class="col-md-6 col-xl-4 premium-animate" style="animation-delay: <?= $delay + ($index * 0.05) ?>s">
                            <div class="location-card shadow-sm">
                                <div class="location-img-wrapper">
                                    <img src="<?= base_url('uploads/admin/LocationRoom/'.$location->location_img) ?>" 
                                         alt="<?= $location->location_name ?>" 
                                         onerror="this.src='<?= base_url('assets/img/elements/1.jpg') ?>'">
                                    <div class="location-badge">
                                        <i class='bx bx-user me-1'></i> <?= $location->location_category ?>
                                    </div>
                                </div>
                                
                                <div class="card-body-premium">
                                    <h5 class="location-name">
                                        <i class='bx bxs-door-open text-primary'></i>
                                        <?= $location->location_name ?>
                                    </h5>

                                    <div class="mini-calendar-header-controls">
                                        <div class="row g-2 mb-3">
                                            <div class="col-7">
                                                <select class="form-select form-select-sm month-selector shadow-none" data-location-id="<?= $location->location_ID ?>">
                                                    <?php 
                                                    $months = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
                                                    foreach($months as $mIdx => $mName): ?>
                                                        <option value="<?= $mIdx + 1 ?>" <?= ($mIdx + 1) == date('n') ? 'selected' : '' ?>><?= $mName ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-5">
                                                <select class="form-select form-select-sm year-selector shadow-none" data-location-id="<?= $location->location_ID ?>">
                                                    <?php 
                                                    $currentYear = date('Y');
                                                    for($y = $currentYear; $y <= $currentYear + 1; $y++): ?>
                                                        <option value="<?= $y ?>" <?= $y == $currentYear ? 'selected' : '' ?>><?= $y + 543 ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mini-calendar-container">
                                        <div id="miniCalendar_<?= $location->location_ID ?>" class="mini-calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php $delay += 0.2; ?>
            <?php endforeach; ?>
        </div>

        <!-- Sidebar: Sticky Actions -->
        <div class="col-lg-3 order-1 order-lg-2">
            <div class="sticky-top" style="top: 100px; z-index: 10;">
                <h5 class="fw-bold mb-3 text-dark d-none d-lg-block">เครื่องมือจัดการ</h5>
                
                <div class="d-flex flex-column gap-3">
                    <!-- Status Count Room -->
                    <a href="#" class="action-card shadow-sm p-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-label-primary p-2 rounded-3 me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class='bx bx-building-house fs-3'></i>
                            </div>
                            <div>
                                <small class="text-muted d-block lh-1 mb-1">ห้องที่เปิดให้บริการ</small>
                                <h5 class="mb-0 fw-bold"><?= $CountLocationRoomAll ?> <small class="fw-normal fs-6">แห่ง</small></h5>
                            </div>
                        </div>
                    </a>

                    <!-- My Bookings -->
                    <a href="<?=base_url('Booking/View/All')?>" class="action-card shadow-sm p-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-label-warning p-2 rounded-3 me-3" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                <i class='bx bx-list-check fs-3'></i>
                            </div>
                            <div>
                                <small class="text-muted d-block lh-1 mb-1">รายการจองของฉัน</small>
                                <h5 class="mb-0 fw-bold text-dark"><?= $CountbookingAll ?> <small class="fw-normal fs-6">รายการ</small></h5>
                            </div>
                        </div>
                    </a>



                    <!-- Admin Section -->
                    <?php if(isset($_SESSION['username']) && (in_array("งานอาคารสถานที่", explode(',',@$_SESSION['rloes'])) || @$_SESSION['status'] =="ExecutiveGeneral")):?>
                        <div class="mt-2 mb-1 ps-2">
                            <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">ส่วนงานเจ้าหน้าที่</small>
                        </div>
                        <a href="<?=base_url('Booking/Approve/Admin')?>" class="action-card shadow-sm p-3 border-start border-info border-3">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar bg-label-info p-2 rounded-3 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class='bx bxs-user-badge fs-4'></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark">หน้าจัดการคำขอ</h6>
                            </div>
                            <div class="admin-stat-row">
                                <small class="text-muted">รอดำเนินการ</small>
                                <span class="badge bg-warning rounded-pill px-2"><?= $NumRowsWaitApprove ?></span>
                            </div>
                            <div class="admin-stat-row mt-2 border-0">
                                <small class="text-muted">อนุมัติแล้ววันนี้</small>
                                <span class="badge bg-success rounded-pill px-2"><?= $NumRowsApprove ?></span>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
    const CURRENT_USER_ID = '<?= $_SESSION['id'] ?? '' ?>';
</script>
<script src="<?= base_url('assets/js/User/UserBooking/UserBookingMiniCalendar.js') ?>"></script>
<?= $this->endSection() ?>
