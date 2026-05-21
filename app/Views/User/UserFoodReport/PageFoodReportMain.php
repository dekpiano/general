<?php $isLoggedIn = session()->get('logged_in'); ?>
<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<style>
/* --- Core Premium Variables --- */
:root {
    --food-primary: #696cff; /* Sneat Indigo */
    --food-secondary: #8592a3; /* Gray */
    --food-accent: #ff3e1d; /* Sneat Danger as accent */
    --glass-bg: rgba(255, 255, 255, 0.85);
    --glass-border: rgba(255, 255, 255, 0.5);
    --premium-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.1);
}

/* --- Entrance Animations --- */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.premium-animate {
    animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* --- Premium Background & Header --- */
.container-p-y {
    background: radial-gradient(circle at 0% 0%, rgba(105, 108, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(105, 108, 255, 0.02) 0%, transparent 50%);
}

.page-header {
    background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
    border-radius: 24px;
    padding: 3rem 2.5rem;
    margin-bottom: 2.5rem;
    position: relative;
    overflow: hidden; /* Changed back to hidden to clip decorative orbs */
    color: #fff;
    box-shadow: 0 20px 50px -15px rgba(105, 108, 255, 0.3);
    z-index: 1;
}

.page-header * {
    position: relative;
    z-index: 2;
}

/* Decorative Orbs */
.page-header::before {
    content: '';
    position: absolute;
    top: -20%;
    right: 0;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -10%;
    left: 2%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    border-radius: 50%;
}

.page-header h4 {
    color: #fff;
    font-size: 2.25rem;
    font-weight: 800;
    letter-spacing: -0.5px;
    margin-bottom: 0.5rem;
}

.page-header p {
    color: rgba(255, 255, 255, 0.7);
    font-size: 1rem;
}

.page-header .breadcrumb-item,
.page-header .breadcrumb-item a {
    color: rgba(255,255,255,0.6);
    font-size: 0.9rem;
    font-weight: 500;
}

.page-header .breadcrumb-item.active {
    color: #fff;
}

/* --- Action Section Styling --- */
.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

@media (max-width: 767px) {
    .header-actions {
        width: 100%;
        justify-content: center;
        margin-top: 1.5rem;
    }
}

/* --- Enhanced Stats Cards --- */
.stats-card {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: var(--premium-shadow);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.stats-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
}

.stats-card .icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.85rem;
    margin-bottom: 1.25rem;
}

.stats-card.p-total .icon-circle { background: linear-gradient(135deg, #f0f2ff 0%, #e7eaff 100%); color: #696cff; }
.stats-card.p-morning .icon-circle { background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); color: #d97706; }
.stats-card.p-lunch .icon-circle { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); color: #2563eb; }
.stats-card.p-dinner .icon-circle { background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); color: #dc2626; }

.stats-title {
    color: #64748b;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.stats-value {
    color: #1e293b;
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0;
}

/* --- Premium Table Section --- */
.table-card {
    background: #fff;
    border-radius: 24px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    overflow: hidden;
}

.table-card .card-header {
    background: #fff;
    padding: 1.75rem 2rem;
    border-bottom: 1px solid #f1f5f9;
}

.table-card .card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
}

/* Custom DataTable Styling */
#food-reports-table thead th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 1px;
    padding: 1.25rem 1.5rem;
    border-bottom: 2px solid #f1f5f9;
}

#food-reports-table tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    color: #334155;
    font-weight: 500;
}

#food-reports-table tbody tr {
    transition: all 0.2s ease;
}

#food-reports-table tbody tr:hover {
    background-color: #fbfcfe !important;
}

/* --- Action Buttons --- */
.btn-premium-add {
    background: #fff !important;
    color: var(--food-primary) !important;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 700;
    border: none;
    box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    cursor: pointer !important;
    pointer-events: auto !important;
}

.btn-premium-add:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.3);
    background: #f8fafc !important;
}

/* Ensure all interactive header elements are clickable */
.header-actions .btn, 
.header-actions a, 
.header-actions select {
    position: relative;
    z-index: 10;
    pointer-events: auto !important;
}

.year-select-premium {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff !important;
    padding: 0.6rem 2.5rem 0.6rem 1.25rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    appearance: none;
    outline: none;
}

.year-select-premium option {
    color: #334155 !important;
    background: #fff;
    font-weight: 400;
}

.year-select-premium:focus {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
}

.btn-white-premium {
    background: #ffffff !important;
    color: var(--food-primary) !important;
    border: none !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    transition: all 0.3s ease !important;
}

.btn-white-premium:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2) !important;
    background: #f8f9ff !important;
}

/* --- Floating Labels & Forms --- */
.form-floating-premium .form-control {
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    padding: 1.25rem 1rem;
    transition: all 0.2s ease;
}

.form-floating-premium .form-control:focus {
    border-color: var(--food-primary);
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

/* --- Image Gallery Miniatures --- */
.img-mini {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.img-stack {
    display: flex;
    align-items: center;
}

.img-stack .img-mini:not(:first-child) {
    margin-left: -15px;
}

/* Responsive */
/* --- Modal Enhancements --- */
#modalAddFoodReport .modal-header {
    background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
    padding: 1.5rem 2rem;
}

#modalAddFoodReport .section-title {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--food-primary);
    display: flex;
    align-items: center;
    margin-bottom: 1.25rem;
    margin-top: 0.5rem;
}

#modalAddFoodReport .section-title i {
    font-size: 1.25rem;
    margin-right: 0.5rem;
}

#modalAddFoodReport .section-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 1.5rem 0;
}

.upload-zone {
    border: 2px dashed #d1d5db;
    background: #f8fafc;
    border-radius: 16px;
    padding: 2rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-zone:hover {
    border-color: var(--food-primary);
    background: #eff6ff;
}

.upload-zone i {
    font-size: 2.5rem;
    color: #94a3b8;
    margin-bottom: 1rem;
}

.upload-zone.dragover {
    border-color: var(--food-primary);
    background: rgba(105, 108, 255, 0.1);
}

#image-preview {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 10px;
    margin-top: 1rem;
}

.preview-item {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.btn-premium-shadow {
    box-shadow: 0 10px 20px -5px rgba(105, 108, 255, 0.4) !important;
}

@media (max-width: 991px) {
    .page-header { padding: 2rem 1.5rem; text-align: center; }
    .page-header h4 { font-size: 1.75rem; }
    .page-header .d-flex { justify-content: center !important; flex-wrap: wrap; }
}
@media (max-width: 576px) {
    .stats-row-container {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow: hidden !important;
        padding-bottom: 0.5rem !important;
        gap: 0.35rem !important;
        margin-bottom: 1rem !important;
    }
    .stats-col-mobile {
        flex: 1 1 0 !important;
        width: 25% !important;
        min-width: 0 !important;
        padding: 0 !important;
    }
    .stats-card {
        padding: 0.35rem !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
        gap: 0.2rem !important;
        border-radius: 8px !important;
        min-height: auto !important;
    }
    .stats-card .icon-circle {
        width: 20px !important;
        height: 20px !important;
        font-size: 0.65rem !important;
        margin-bottom: 0 !important;
        border-radius: 5px !important;
    }
    .stats-card .stats-info {
        min-width: 0;
        width: 100%;
    }
    .stats-card .stats-title {
        font-size: 0.5rem !important;
        margin-bottom: 0 !important;
        line-height: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .stats-card .stats-value {
        font-size: 0.75rem !important;
        line-height: 1;
        white-space: nowrap;
    }
    .stats-card .stats-value small {
        display: none !important;
    }
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Page Header (Sneat Redesigned) -->
    <div class="page-header premium-animate">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="header-left">
                <div class="d-flex align-items-center mb-1">
                    <div class="bg-opacity-25 p-2 rounded-3 me-3">
                        <i class='bx bxs-dish fs-3 text-white'></i>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?=base_url('FoodReport')?>">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">รายงานอาหาร</li>
                        </ol>
                    </nav>
                </div>
                <h4 class="mb-0 fw-bold text-white">รายงานอาหารโรงเรียน</h4>
                <p class="mb-0 text-white-50">ระบบติดตามและบันทึกข้อมูลโภชนาการรายวัน</p>
            </div>
            
            <div class="header-actions flex-wrap">
                <a target="_blank" href="<?=base_url('manual/food-report') ?>" class="btn btn-white-premium rounded-pill px-4 me-md-2">
                    <i class='bx bx-book-content me-1'></i> คู่มือการใช้งาน
                </a>
                <div class="position-relative me-md-2" style="min-width: 160px;">
                    <select class="year-select-premium w-100" id="yearFilter" onchange="window.location.href='<?=base_url('FoodReport')?>?year='+this.value">
                        <?php foreach($years as $y): ?>
                        <option value="<?=$y?>" <?=$y == $selectedYear ? 'selected' : ''?>>ปีการศึกษา <?=$y+543?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class='bx bx-chevron-down position-absolute top-50 end-0 translate-middle-y me-3 text-white-50 pointer-events-none'></i>
                </div>
                
                <?php if ($isLoggedIn && in_array('งานรายงานอาหาร', array_map('trim', explode(',', (string)session()->get('rloes'))))): ?>
                <button type="button" class="btn btn-premium-add rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalAddFoodReport">
                    <i class="bx bx-plus-circle me-1"></i> เพิ่มรายงาน
                </button>
                <?php elseif (!$isLoggedIn): ?>
                <a href="<?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>" class="btn btn-outline-light rounded-pill px-4">
                    <i class="bx bx-log-in-circle me-1"></i> เข้าสู่ระบบ
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-5 g-3 stats-row-container">
        <div class="col-6 col-sm-6 col-xl-3 stats-col-mobile">
            <div class="stats-card p-total premium-animate" style="animation-delay: 0.1s">
                <div class="icon-circle">
                    <i class='bx bxs-file-find'></i>
                </div>
                <div class="stats-info">
                    <h6 class="stats-title">รายงานทั้งหมด</h6>
                    <h3 class="stats-value"><?= number_format($TotalReports ?? 0) ?> <small class="fw-normal">ฉบับ</small></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-xl-3 stats-col-mobile">
            <div class="stats-card p-morning premium-animate" style="animation-delay: 0.2s">
                <div class="icon-circle">
                    <i class='bx bxs-coffee-togo'></i>
                </div>
                <div class="stats-info">
                    <h6 class="stats-title">มื้อเช้า</h6>
                    <h3 class="stats-value"><?= number_format($BreakfastCount ?? 0) ?> <small class="fw-normal">วัน</small></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-xl-3 stats-col-mobile">
            <div class="stats-card p-lunch premium-animate" style="animation-delay: 0.3s">
                <div class="icon-circle">
                    <i class='bx bxs-bowl-hot'></i>
                </div>
                <div class="stats-info">
                    <h6 class="stats-title">มื้อกลางวัน</h6>
                    <h3 class="stats-value"><?= number_format($LunchCount ?? 0) ?> <small class="fw-normal">วัน</small></h3>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-xl-3 stats-col-mobile">
            <div class="stats-card p-dinner premium-animate" style="animation-delay: 0.4s">
                <div class="icon-circle">
                    <i class='bx bxs-moon'></i>
                </div>
                <div class="stats-info">
                    <h6 class="stats-title">มื้อเย็น</h6>
                    <h3 class="stats-value"><?= number_format($DinnerCount ?? 0) ?> <small class="fw-normal">วัน</small></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card premium-animate" style="animation-delay: 0.5s">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">
                <i class="bx bx-list-ul me-2 text-primary fs-4"></i> รายการอาหารล่าสุด
            </h5>
            <div class="card-actions">
                <button type="button" class="btn btn-sm btn-label-secondary rounded-pill px-3" onclick="$('#food-reports-table').DataTable().ajax.url('<?= base_url('FoodReport/getFoodReportsJson') ?>?year=<?= $selectedYear ?>').load(null, false)">
                    <i class='bx bx-refresh me-1'></i> รีโหลดข้อมูล
                </button>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover nowrap" style="width:100%" id="food-reports-table">
                <thead>
                    <tr>
                        <th>วันที่บันทึก</th>
                        <th>มื้ออาหาร</th>
                        <th>รายการเมนูอาหาร</th>
                        <th>รูปภาพประกอบ</th>
                        <?php if ($isLoggedIn && in_array('งานรายงานอาหาร', array_map('trim', explode(',', (string)session()->get('rloes'))))): ?>
                        <th>ผู้บันทึก</th>
                        <th>พิมพ์</th>
                        <th>Word</th>
                        <th>จัดการ</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit Modal (Premium Styling Applied via Custom Classes) -->
<div class="modal fade" id="modalAddFoodReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white d-flex align-items-center" id="addReportModalLabel">
                    <i class="bx bx-plus-circle me-2 fs-3"></i>
                    <span>เพิ่มรายงานอาหารใหม่</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addReportForm" action="<?= base_url('FoodReport/insert') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" id="food_id" name="food_id">
                <div class="modal-body p-4 p-lg-5">
                    
                    <!-- Section 1: Basic Info -->
                    <div class="section-title">
                        <i class='bx bx-info-square'></i> ข้อมูลเบื้องต้น
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-premium">
                                <input type="date" class="form-control" id="food_date" name="food_date" value="<?=date("Y-m-d")?>" required>
                                <label for="food_date"><i class="bx bx-calendar me-1"></i>วันที่รายงาน</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-premium">
                                <select class="form-select" id="food_meal" name="food_meal" required>
                                    <option selected disabled value="">ระบุมื้ออาหาร...</option>
                                    <option value="มื้อเช้า">มื้อเช้า (07:00 - 08:30)</option>
                                    <option value="มื้อกลางวัน">มื้อกลางวัน (11:00 - 13:00)</option>
                                    <option value="มื้อเย็น">มื้อเย็น (16:30 - 18:00)</option>
                                </select>
                                <label for="food_meal"><i class="bx bx-time me-1"></i>มื้ออาหาร</label>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Section 2: Menu & Media -->
                    <div class="section-title">
                        <i class='bx bx-list-check'></i> รายการอาหารและรูปภาพ
                    </div>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-floating form-floating-premium">
                                <textarea class="form-control h-px-100" id="food_menu" name="food_menu" required placeholder="เช่น ผัดไทย, ข้าวผัดไข่, ส้มตำ"></textarea>
                                <label for="food_menu"><i class="bx bx-restaurant me-1"></i>รายการเมนูอาหาร (ระบุแต่ละเมนูคั่นด้วยจุลภาค)</label>
                            </div>
                            <div class="mt-2 text-muted" style="font-size: 0.75rem;">
                                <i class="bx bx-help-circle me-1"></i> ตัวอย่าง: ข้าวสวย, ต้มจืดวุ้นเส้น, ไก่ทอด, ผลไม้ตามฤดูกาล
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="upload-zone text-center" onclick="document.getElementById('food_images').click()">
                                <i class="bx bx-cloud-upload"></i>
                                <h6 class="mb-1 fw-bold">อัปโหลดรูปภาพอาหาร</h6>
                                <p class="text-muted small mb-0">คลิกเพื่อเลือกไฟล์ หรือลากไฟล์มาวาง (รองรับ JPEG, PNG)</p>
                                <input class="form-control d-none" type="file" id="food_images" name="food_images[]" multiple accept="image/*">
                            </div>
                        </div>

                        <div class="col-12">
                            <div id="image-preview">
                                <!-- Previews go here as .preview-item -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-label-secondary border-0 px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary px-5 btn-premium-shadow" id="btnSaveReport">
                        <span class="btn-text fw-bold"><i class="bx bx-save me-1"></i> บันทึกข้อมูลรายงาน</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            กำลังประมวลผล...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Viewer Modal (Premium) -->
<div class="modal fade" id="imageViewerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0">
            <div class="modal-header border-0 bg-dark text-white">
                <h5 class="modal-title text-white">
                    <i class="bx bx-images me-2 text-info"></i>
                    อัลบั้มรูปภาพอาหาร
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-dark p-4 p-md-5">
                <div id="image-gallery-in-modal" class="row g-3 justify-content-center"></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
    const canManage = <?= ($isLoggedIn && in_array('งานรายงานอาหาร', array_map('trim', explode(',', session()->get('rloes') ?? '')))) ? 'true' : 'false' ?>;
    const loggedInUserId = '<?= session()->get('id') ?? '' ?>';

    function formatThaiDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const months = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
    }

    // 1. Image Preview for Upload
    const foodImagesInput = document.getElementById('food_images');
    if (foodImagesInput) {
        foodImagesInput.addEventListener('change', function(event) {
            const previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = '';
            Array.from(event.target.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'preview-item';
                        wrapper.innerHTML = `<img src="${e.target.result}" loading="lazy">`;
                        previewContainer.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    }

    // 2. DataTable Initialization
    let columns = [
        { 
            "data": "food_date", 
            "render": (data, type) => (type === 'display' || type === 'filter') 
                ? `<div class="d-flex align-items-center"><i class='bx bx-calendar-event me-2 text-primary fs-5'></i><span class="fw-bold text-dark">${formatThaiDate(data)}</span></div>` 
                : data
        },
        { 
            "data": "food_meal",
            "render": data => {
                const config = {
                    'มื้อเช้า': { class: 'bg-label-warning', icon: 'bx-sun' },
                    'มื้อกลางวัน': { class: 'bg-label-info', icon: 'bx-cloud' },
                    'มื้อเย็น': { class: 'bg-label-danger', icon: 'bx-moon' }
                };
                const c = config[data] || { class: 'bg-label-primary', icon: 'bx-time-five' };
                return `<span class="badge ${c.class} text-uppercase px-2 rounded-pill"><i class="bx ${c.icon} me-1"></i>${data}</span>`;
            }
        },
        { 
            "data": "food_menu",
            "render": data => data ? `<div style="white-space:normal; min-width:250px;">${data.split(',').map(m => `<span class="badge bg-light text-dark fw-medium border me-1 mb-1">${m.trim()}</span>`).join('')}</div>` : ''
        },
        {
            "data": "food_images",
            "render": function(data, type, row) {
                let images = [];
                try { images = JSON.parse(data) || []; } catch (e) {}
                if (images.length === 0) return '<span class="text-muted small italic">ไม่มีรูปภาพ</span>';
                
                let stackHtml = '<div class="img-stack">';
                images.slice(0, 3).forEach((img, idx) => {
                    const url = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(`<?=env('upload.server.baseurl')?>${row.food_date}/${img}`)}`;
                    stackHtml += `<img src="${url}" class="img-mini shadow-sm" style="z-index: ${5-idx}" loading="lazy">`;
                });
                if (images.length > 3) stackHtml += `<div class="img-mini bg-dark text-white d-flex align-items-center justify-content-center fw-bold" style="z-index: 1; font-size: 10px;">+${images.length - 3}</div>`;
                stackHtml += '</div>';
                
                return `<div class="d-flex align-items-center gap-3">${stackHtml}<button class="btn btn-icon btn-sm btn-label-primary rounded-circle view-images-btn" data-bs-toggle="modal" data-bs-target="#imageViewerModal" data-images='${data}' data-food-date="${row.food_date}"><i class="bx bx-show"></i></button></div>`;
            },
            "orderable": false
        }
    ];

    if (canManage) {
        columns.push({ "data": "recorder_full_name", "render": d => d ? `<div class="d-flex align-items-center"><div class="avatar avatar-xs me-2"><span class="avatar-initial rounded-circle bg-label-secondary" style="font-size:10px">${d.charAt(0)}</span></div><span class="small fw-medium">${d}</span></div>` : '<span class="text-muted">-</span>' });
        columns.push({ "data": "food_id", "render": d => `<a href="<?= base_url('FoodReport/print/') ?>${d}" target="_blank" class="btn btn-sm btn-icon btn-label-info rounded-pill" title="พิมพ์"><i class="bx bx-printer"></i></a>`, "orderable": false });
        columns.push({ "data": "food_id", "render": d => `<a href="<?= base_url('FoodReport/word/') ?>${d}" class="btn btn-sm btn-icon btn-label-primary rounded-pill" title="ดาวน์โหลด Word"><i class="bx bxs-file-doc"></i></a>`, "orderable": false });
        columns.push({
            "data": "food_id",
            "render": (data, type, row) => row.food_admin == loggedInUserId 
                ? `<div class="d-inline-flex gap-1"><a href="javascript:void(0)" class="btn btn-sm btn-icon btn-label-warning rounded-pill item-edit" data-bs-toggle="modal" data-bs-target="#modalAddFoodReport" data-id="${data}"><i class="bx bx-edit-alt"></i></a><button class="btn btn-sm btn-icon btn-label-danger rounded-pill delete-btn" data-id="${data}"><i class="bx bx-trash"></i></button></div>` 
                : `<i class='bx bx-lock-alt text-muted' title="ไม่มีสิทธิ์จัดการ"></i>`,
            "orderable": false
        });
    }

    const table = $('#food-reports-table').DataTable({
        "responsive": true,
        "ajax": { "url": `<?= base_url('FoodReport/getFoodReportsJson') ?>?year=<?= $selectedYear ?>` },
        "columns": columns,
        "order": [[0, "desc"]],
        "language": {
            "search": "", "searchPlaceholder": "ค้นหาวันที่, เมนู...", "lengthMenu": "_MENU_",
            "info": "แสดง _START_ - _END_ จาก _TOTAL_", "emptyTable": "ไม่พบข้อมูลรายการอาหาร",
            "paginate": { "next": '<i class="bx bx-chevron-right"></i>', "previous": '<i class="bx bx-chevron-left"></i>' }
        },
        "dom": '<"card-header d-flex flex-wrap border-bottom-0 pt-0"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-3 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-3 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        "displayLength": 10
    });

    // 3. Image Compression Function
    async function compressImage(file) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (event) => {
                const img = new Image();
                img.src = event.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;
                    const max_size = 1280; // Max width/height

                    if (width > height) {
                        if (width > max_size) {
                            height *= max_size / width;
                            width = max_size;
                        }
                    } else {
                        if (height > max_size) {
                            width *= max_size / height;
                            height = max_size;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    canvas.toBlob((blob) => {
                        // Strictly allow only English alphanumeric characters, dashes and underscores
                        let safeName = file.name.split('.').slice(0, -1).join('.') // Get name without extension
                            .replace(/[^\w-]/g, "_") // Replace non-alphanumeric/underscore/dash with _
                            .replace(/_+/g, "_") // Consolidate multiple underscores
                            .trim();
                        
                        safeName = (safeName || 'image') + '.jpg';

                        resolve(new File([blob], safeName, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        }));
                    }, 'image/jpeg', 0.7); // 0.7 quality
                };
            };
        });
    }

    // 4. Form Submission (Add/Edit)
    const addForm = document.getElementById('addReportForm');
    if (addForm) {
        addForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const $btn = $('#btnSaveReport');
            const $btnText = $btn.find('.btn-text');
            const $btnLoading = $btn.find('.btn-loading');
            
            $btn.prop('disabled', true);
            $btnText.addClass('d-none');
            $btnLoading.removeClass('d-none');

            try {
                const formData = new FormData(this);
                const fileInput = document.getElementById('food_images');
                const files = fileInput.files;
                
                // Clear existing files from formData
                formData.delete('food_images[]');

                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        $btnLoading.html(`<span class="spinner-border spinner-border-sm me-1"></span> กำลังย่อรูปที่ ${i + 1}/${files.length}...`);
                        
                        // Compress only if it's an image
                        if (file.type.startsWith('image/')) {
                            const compressedFile = await compressImage(file);
                            formData.append('food_images[]', compressedFile);
                        } else {
                            formData.append('food_images[]', file);
                        }
                    }
                }

                $btnLoading.html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึกข้อมูล...');
                
                const response = await fetch(this.action, { 
                    method: 'POST', 
                    body: formData 
                }).then(r => r.json());

                $btn.prop('disabled', false);
                $btnText.removeClass('d-none');
                $btnLoading.addClass('d-none').html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังประมวลผล...');

                if (response.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('modalAddFoodReport')).hide();
                    Swal.fire({ icon: 'success', title: 'บันทึกสำเร็จ!', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                    table.ajax.reload();
                } else {
                    Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: response.message });
                }

            } catch (err) {
                console.error(err);
                $btn.prop('disabled', false);
                $btnText.removeClass('d-none');
                $btnLoading.addClass('d-none').html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังประมวลผล...');
                Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: "เกิดข้อผิดพลาดในการส่งข้อมูล: " + err.message });
            }
        });
    }

    // 4. Modal Setup (Edit Load Data)
    const addModalEl = document.getElementById('modalAddFoodReport');
    if (addModalEl) {
        addModalEl.addEventListener('show.bs.modal', function(event) {
            const btn = event.relatedTarget;
            const form = document.getElementById('addReportForm');
            const title = document.getElementById('addReportModalLabel');
            const preview = document.getElementById('image-preview');
            form.reset();
            preview.innerHTML = '';

            if (btn && btn.classList.contains('item-edit')) {
                const id = btn.getAttribute('data-id');
                title.innerHTML = '<span class="badge bg-white bg-opacity-25 p-2 me-2"><i class="bx bx-edit text-white fs-4"></i></span> แก้ไขรายงานอาหาร';
                form.action = '<?= base_url('FoodReport/update') ?>';
                document.getElementById('food_id').value = id;
                
                fetch(`<?= base_url('FoodReport/getReportById/') ?>${id}`).then(r => r.json()).then(data => {
                    if (data.status === 'success' && data.report) {
                        document.getElementById('food_date').value = data.report.food_date;
                        document.getElementById('food_meal').value = data.report.food_meal;
                        document.getElementById('food_menu').value = data.report.food_menu;
                        let images = []; try { images = JSON.parse(data.report.food_images) || []; } catch (e) {}
                        images.forEach(img => {
                            const url = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(`<?=env('upload.server.baseurl')?>${data.report.food_date}/${img}`)}`;
                            const w = document.createElement('div');
                            w.className = 'preview-item';
                            w.innerHTML = `<img src="${url}" loading="lazy">`;
                            preview.appendChild(w);
                        });
                    }
                });
            } else {
                title.innerHTML = '<span class="badge bg-white bg-opacity-25 p-2 me-2"><i class="bx bx-plus-circle text-white fs-4"></i></span> เพิ่มรายงานอาหารใหม่';
                form.action = '<?= base_url('FoodReport/insert') ?>';
                document.getElementById('food_id').value = '';
                document.getElementById('food_date').value = '<?= date("Y-m-d") ?>';
            }
        });
    }

    // 5. Delete Action
    $('#food-reports-table tbody').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบ?', text: "ข้อมูลนี้จะถูกลบถาวร!", icon: 'warning',
            showCancelButton: true, confirmButtonText: 'ลบข้อมูล', cancelButtonText: 'ยกเลิก',
            customClass: { confirmButton: 'btn btn-danger me-3', cancelButton: 'btn btn-label-secondary' },
            buttonsStyling: false
        }).then(async result => {
            if (result.isConfirmed) {
                const res = await fetch('<?= base_url('FoodReport/delete') ?>', {
                    method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ 'id': id })
                }).then(r => r.json());
                if (res.status === 'success') {
                    Swal.fire({ icon: 'success', title: 'ลบสำเร็จ!', toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                    table.ajax.reload();
                } else Swal.fire({ icon: 'error', title: 'ผิดพลาด!', text: res.message });
            }
        });
    });

    // 6. Image Gallery Viewer
    const imageViewerModal = document.getElementById('imageViewerModal');
    if (imageViewerModal) {
        imageViewerModal.addEventListener('show.bs.modal', function(event) {
            const btn = event.relatedTarget;
            const gallery = document.getElementById('image-gallery-in-modal');
            gallery.innerHTML = '';
            let images = []; try { images = JSON.parse(btn.getAttribute('data-images')); } catch (e) {}
            const foodDate = btn.getAttribute('data-food-date');
            
            if (images.length === 0) { gallery.innerHTML = '<div class="text-center text-white py-5 opacity-50">ไม่พบรูปภาพ</div>'; return; }

            images.forEach(img => {
                const rawUrl = `<?=env('upload.server.baseurl')?>${foodDate}/${img}`;
                const proxy = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(rawUrl)}`;
                const col = document.createElement('div');
                col.className = 'col-6 col-md-4';
                col.innerHTML = `<a href="${rawUrl}" target="_blank" class="d-block shadow-lg rounded-4 overflow-hidden border border-secondary" style="height:180px; transition: 0.3s transform;">
                                    <img src="${proxy}" class="w-100 h-100 object-fit-cover" loading="lazy">
                                 </a>`;
                col.querySelector('a').onmouseover = function() { this.style.transform = "scale(1.03)"; };
                col.querySelector('a').onmouseout = function() { this.style.transform = "scale(1)"; };
                gallery.appendChild(col);
            });
        });
    }
});
</script>
<?= $this->endSection() ?>
