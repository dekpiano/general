<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --warning-gradient: linear-gradient(135deg, #ffab00 0%, #d48b00 100%);
        --info-gradient: linear-gradient(135deg, #03c3ec 0%, #0289a6 100%);
        --success-gradient: linear-gradient(135deg, #71dd37 0%, #4ca71f 100%);
        --danger-gradient: linear-gradient(135deg, #ff3e1d 0%, #c4260b 100%);
        --glass-bg: rgba(255, 255, 255, 0.92);
        --glass-border: rgba(255, 255, 255, 0.6);
    }

    /* Hero Banner Header */
    .hero-approve-banner {
        background: linear-gradient(135deg, #696cff 0%, #4648a8 50%, #2f3175 100%);
        border-radius: 1.5rem;
        color: white;
        padding: 2.2rem 2rem;
        box-shadow: 0 12px 30px rgba(105, 108, 255, 0.28);
        position: relative;
        overflow: hidden;
        margin-bottom: 1.75rem;
    }
    .hero-approve-banner::before {
        content: '';
        position: absolute;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
        top: -100px;
        right: -60px;
        border-radius: 50%;
    }
    .hero-approve-banner::after {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(255, 171, 0, 0.18) 0%, rgba(255, 255, 255, 0) 70%);
        bottom: -80px;
        left: 20%;
        border-radius: 50%;
    }

    /* KPI / Stats Cards */
    .kpi-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: 1.5px solid rgba(220, 224, 235, 0.6);
        border-radius: 1.25rem;
        padding: 1.25rem 1.25rem;
        transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        height: 100%;
        text-decoration: none;
        display: block;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }
    .kpi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.08);
    }
    .kpi-card.active {
        border-color: #696cff;
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(105, 108, 255, 0.18);
    }
    .kpi-card.active::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }
    .kpi-card .kpi-icon {
        width: 52px;
        height: 52px;
        border-radius: 1.15rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
        transition: transform 0.3s ease;
        color: #ffffff !important;
        flex-shrink: 0;
    }
    .kpi-card:hover .kpi-icon {
        transform: scale(1.1) rotate(5deg);
    }
    .kpi-icon-warning {
        background: linear-gradient(135deg, #ffab00 0%, #ff8c00 100%) !important;
        box-shadow: 0 6px 16px rgba(255, 171, 0, 0.4) !important;
    }
    .kpi-icon-info {
        background: linear-gradient(135deg, #03c3ec 0%, #0099cc 100%) !important;
        box-shadow: 0 6px 16px rgba(3, 195, 236, 0.4) !important;
    }
    .kpi-icon-primary {
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%) !important;
        box-shadow: 0 6px 16px rgba(105, 108, 255, 0.4) !important;
    }
    .kpi-icon-success {
        background: linear-gradient(135deg, #71dd37 0%, #4ca71f 100%) !important;
        box-shadow: 0 6px 16px rgba(113, 221, 55, 0.4) !important;
    }
    .kpi-card .kpi-icon i {
        color: #ffffff !important;
        font-size: 1.65rem !important;
    }

    /* Filter & Search Bar */
    .filter-card {
        background: white;
        border-radius: 1.25rem;
        border: 1px solid rgba(67, 89, 113, 0.08);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .status-pill-link {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.84rem;
        font-weight: 600;
        color: #697a8d;
        background: #f5f5f9;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid transparent;
    }
    .status-pill-link:hover {
        color: #696cff;
        background: rgba(105, 108, 255, 0.08);
    }
    .status-pill-link.active {
        background: #696cff;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(105, 108, 255, 0.35);
    }
    .status-pill-link.active .badge-count {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }
    .badge-count {
        font-size: 0.72rem;
        padding: 0.2rem 0.55rem;
        border-radius: 50px;
        background: rgba(67, 89, 113, 0.1);
        color: #566a7f;
        font-weight: 700;
    }

    /* Main Table Container */
    .table-container {
        background: white;
        border-radius: 1.25rem;
        border: 1px solid rgba(67, 89, 113, 0.08);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }
    .table-custom {
        margin-bottom: 0;
    }
    .table-custom thead th {
        background: #f8f9fc;
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #566a7f;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e7e7e7;
    }
    .table-custom tbody tr {
        transition: background-color 0.2s ease;
    }
    .table-custom tbody tr:hover {
        background-color: rgba(105, 108, 255, 0.025);
    }
    .table-custom tbody td {
        padding: 1.15rem 1.25rem;
        vertical-align: middle;
        font-size: 0.88rem;
    }

    /* Borrower Avatar */
    .borrower-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    }

    /* Code Pill Badge */
    .code-badge {
        font-family: var(--bs-font-monospace);
        font-size: 0.82rem;
        font-weight: 700;
        padding: 0.3rem 0.65rem;
        border-radius: 8px;
        background: rgba(105, 108, 255, 0.08);
        color: #696cff;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: 1px solid rgba(105, 108, 255, 0.15);
    }

    /* Status Capsule */
    .status-capsule {
        padding: 0.4rem 0.85rem;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-capsule.pending {
        background: rgba(255, 171, 0, 0.12);
        color: #d48b00;
        border: 1px solid rgba(255, 171, 0, 0.3);
    }
    .status-capsule.approved {
        background: rgba(3, 195, 236, 0.12);
        color: #0289a6;
        border: 1px solid rgba(3, 195, 236, 0.3);
    }
    .status-capsule.borrowed {
        background: rgba(105, 108, 255, 0.12);
        color: #696cff;
        border: 1px solid rgba(105, 108, 255, 0.3);
    }
    .status-capsule.returned {
        background: rgba(113, 221, 55, 0.14);
        color: #3b9e15;
        border: 1px solid rgba(113, 221, 55, 0.3);
    }
    .status-capsule.rejected {
        background: rgba(255, 62, 29, 0.12);
        color: #ff3e1d;
        border: 1px solid rgba(255, 62, 29, 0.3);
    }

    /* Action Buttons */
    .btn-action-round {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        padding: 0;
        font-size: 1.05rem;
    }
    .btn-action-round:hover {
        transform: scale(1.12);
        box-shadow: 0 4px 10px rgba(0,0,0,0.12);
    }

    /* Modal Styling High-End */
    .modal-pickup-header {
        background: linear-gradient(135deg, #696cff 0%, #4338ca 100%);
        padding: 1.5rem 1.75rem;
        position: relative;
        overflow: hidden;
    }
    .modal-pickup-header::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0) 70%);
        top: -40px;
        right: -30px;
        border-radius: 50%;
    }
    .modal-return-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        padding: 1.5rem 1.75rem;
        position: relative;
        overflow: hidden;
    }
    .modal-return-header::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0) 70%);
        top: -40px;
        right: -30px;
        border-radius: 50%;
    }

    .modal-order-summary {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1rem 1.25rem;
    }

    /* Enhanced Modal Dropzone */
    .modal-dropzone-pro {
        border: 2.5px dashed #696cff;
        border-radius: 1.25rem;
        background: #f8faff;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .modal-dropzone-pro:hover, .modal-dropzone-pro.dragover {
        border-color: #4338ca;
        background: rgba(105, 108, 255, 0.08);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(105, 108, 255, 0.15);
    }
    .modal-dropzone-warning {
        border-color: #f59e0b !important;
        background: #fffdf8 !important;
    }
    .modal-dropzone-warning:hover, .modal-dropzone-warning.dragover {
        border-color: #d97706 !important;
        background: rgba(245, 158, 11, 0.08) !important;
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.15);
    }

    .preview-card-pro {
        background: white;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        padding: 0.85rem;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
    }
    .preview-thumb-pro {
        width: 96px;
        height: 96px;
        border-radius: 0.85rem;
        object-fit: cover;
        border: 2px solid #696cff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Pulse Dot for Pending */
    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #ffab00;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(255, 171, 0, 0.7);
        animation: pulse-dot 1.5s infinite cubic-bezier(0.66, 0, 0, 1);
    }
    @keyframes pulse-dot {
        to {
            box-shadow: 0 0 0 8px rgba(255, 171, 0, 0);
        }
    }
    /* Mobile Card for Approve Portal */
    .approve-card-m {
        background: #ffffff;
        border-radius: 1.15rem;
        border: 1px solid rgba(67, 89, 113, 0.1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        padding: 1.15rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
    }
    .approve-card-m:hover {
        border-color: #696cff;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Hero Banner Header -->
    <div class="hero-approve-banner">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-white text-primary rounded-pill px-3 py-1 fw-bold shadow-sm" style="font-size: 0.78rem;">
                        <i class="bi bi-shield-lock me-1"></i> ระบบงานเจ้าหน้าที่ (Staff Portal)
                    </span>
                    <?php if ($countPending > 0): ?>
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-bold shadow-sm" style="font-size: 0.78rem;">
                            <span class="pulse-dot me-1"></span> มีคำขอรออนุมัติ <?= $countPending ?> รายการ
                        </span>
                    <?php endif; ?>
                </div>
                <h3 class="text-white fw-bold mb-2">
                    <i class="bi bi-shield-check me-2"></i>รายการอนุมัติ & รับ-ส่งคืนพัสดุอุปกรณ์
                </h3>
                <p class="text-white-50 mb-3 fs-6" style="max-width: 600px;">
                    ตรวจสอบคำขอยืมจากบุคลากรและหน่วยงานภายนอก พิจารณาอนุมัติ ถ่ายภาพส่งมอบพัสดุ และตรวจรับคืนเข้าสต็อก
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= base_url('Equipment/Add') ?>" class="btn btn-light text-primary fw-bold rounded-pill px-3 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> ยื่นคำขอยืมใหม่
                    </a>
                    <button type="button" class="btn btn-outline-danger text-white border-white rounded-pill px-3" onclick="cleanupOrphanImages()">
                        <i class="bi bi-trash3 me-1"></i> ล้างรูปภาพขยะ
                    </button>
                    <a href="<?= base_url('Equipment') ?>" class="btn btn-outline-light rounded-pill px-3">
                        <i class="bi bi-house-door me-1"></i> หน้าหลักพัสดุ
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <img src="https://cdn-icons-png.flaticon.com/512/3281/3281329.png" alt="Admin Badge" style="max-height: 130px; filter: drop-shadow(0 10px 18px rgba(0,0,0,0.25));">
            </div>
        </div>
    </div>

    <!-- 4 KPI Stat Cards (Clickable Quick Filters) -->
    <div class="row g-3 mb-4">
        <!-- 1. รออนุมัติ -->
        <div class="col-6 col-lg-3">
            <a href="<?= base_url('Equipment/Approve?status=pending&type=' . esc($selectedType)) ?>" 
               class="kpi-card <?= ($selectedStatus === 'pending') ? 'active' : '' ?>">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">⏳ รอพิจารณาอนุมัติ</div>
                        <h3 class="fw-bold mb-0 mt-1 text-warning"><?= number_format($countPending) ?></h3>
                        <small class="text-muted" style="font-size: 0.75rem;">คลิกเพื่อกรองคำขอใหม่</small>
                    </div>
                    <div class="kpi-icon kpi-icon-warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 2. อนุมัติแล้ว (รอจ่ายของ) -->
        <div class="col-6 col-lg-3">
            <a href="<?= base_url('Equipment/Approve?status=approved&type=' . esc($selectedType)) ?>" 
               class="kpi-card <?= ($selectedStatus === 'approved') ? 'active' : '' ?>">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">✅ อนุมัติแล้ว (รอจ่ายของ)</div>
                        <h3 class="fw-bold mb-0 mt-1 text-info"><?= number_format($countApproved) ?></h3>
                        <small class="text-muted" style="font-size: 0.75rem;">รอส่งมอบ & ถ่ายภาพ</small>
                    </div>
                    <div class="kpi-icon kpi-icon-info">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 3. กำลังใช้งาน (ยืมอยู่) -->
        <div class="col-6 col-lg-3">
            <a href="<?= base_url('Equipment/Approve?status=borrowed&type=' . esc($selectedType)) ?>" 
               class="kpi-card <?= ($selectedStatus === 'borrowed') ? 'active' : '' ?>">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">📦 กำลังยืมใช้งาน</div>
                        <h3 class="fw-bold mb-0 mt-1 text-primary"><?= number_format($countBorrowed) ?></h3>
                        <small class="text-muted" style="font-size: 0.75rem;">พัสดุอยู่นอกคลัง</small>
                    </div>
                    <div class="kpi-icon kpi-icon-primary">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 4. คืนแล้วเสร็จ -->
        <div class="col-6 col-lg-3">
            <a href="<?= base_url('Equipment/Approve?status=returned&type=' . esc($selectedType)) ?>" 
               class="kpi-card <?= ($selectedStatus === 'returned') ? 'active' : '' ?>">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">🎉 ตรวจรับคืนแล้วเสร็จ</div>
                        <h3 class="fw-bold mb-0 mt-1 text-success"><?= number_format($countReturned) ?></h3>
                        <small class="text-muted" style="font-size: 0.75rem;">ส่งคืนเข้าสต็อกครบ</small>
                    </div>
                    <div class="kpi-icon kpi-icon-success">
                        <i class="bi bi-check2-all"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Filter Control Bar -->
    <div class="filter-card">
        <form method="GET" action="<?= base_url('Equipment/Approve') ?>" id="filterForm">
            <div class="row g-3 align-items-center">
                <!-- Status Pills -->
                <div class="col-12 col-xl-7">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="text-muted small fw-bold me-1"><i class="bi bi-funnel-fill me-1"></i>สถานะ:</span>
                        <a href="<?= base_url('Equipment/Approve?status=all&type=' . esc($selectedType) . '&search=' . urlencode($search ?? '')) ?>" 
                           class="status-pill-link <?= ($selectedStatus === 'all' || empty($selectedStatus)) ? 'active' : '' ?>">
                            ทั้งหมด
                        </a>
                        <a href="<?= base_url('Equipment/Approve?status=pending&type=' . esc($selectedType) . '&search=' . urlencode($search ?? '')) ?>" 
                           class="status-pill-link <?= ($selectedStatus === 'pending') ? 'active' : '' ?>">
                            ⏳ รออนุมัติ <span class="badge-count"><?= $countPending ?></span>
                        </a>
                        <a href="<?= base_url('Equipment/Approve?status=approved&type=' . esc($selectedType) . '&search=' . urlencode($search ?? '')) ?>" 
                           class="status-pill-link <?= ($selectedStatus === 'approved') ? 'active' : '' ?>">
                            ✅ รอจ่ายของ <span class="badge-count"><?= $countApproved ?></span>
                        </a>
                        <a href="<?= base_url('Equipment/Approve?status=borrowed&type=' . esc($selectedType) . '&search=' . urlencode($search ?? '')) ?>" 
                           class="status-pill-link <?= ($selectedStatus === 'borrowed') ? 'active' : '' ?>">
                            📦 ยืมอยู่ <span class="badge-count"><?= $countBorrowed ?></span>
                        </a>
                        <a href="<?= base_url('Equipment/Approve?status=returned&type=' . esc($selectedType) . '&search=' . urlencode($search ?? '')) ?>" 
                           class="status-pill-link <?= ($selectedStatus === 'returned') ? 'active' : '' ?>">
                            🎉 คืนแล้ว <span class="badge-count"><?= $countReturned ?></span>
                        </a>
                        <a href="<?= base_url('Equipment/Approve?status=rejected&type=' . esc($selectedType) . '&search=' . urlencode($search ?? '')) ?>" 
                           class="status-pill-link <?= ($selectedStatus === 'rejected') ? 'active' : '' ?>">
                            ❌ ไม่อนุมัติ
                        </a>
                    </div>
                </div>

                <!-- Borrower Type & Search Input -->
                <div class="col-12 col-xl-5">
                    <div class="row g-2">
                        <div class="col-sm-5">
                            <input type="hidden" name="status" value="<?= esc($selectedStatus) ?>">
                            <select name="type" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                                <option value="all" <?= ($selectedType == 'all') ? 'selected' : '' ?>>👥 ผู้ยืมทุกประเภท</option>
                                <option value="internal" <?= ($selectedType == 'internal') ? 'selected' : '' ?>>🏫 บุคลากรภายใน</option>
                                <option value="external" <?= ($selectedType == 'external') ? 'selected' : '' ?>>🌐 บุคคล/หน่วยงานภายนอก</option>
                            </select>
                        </div>
                        <div class="col-sm-7">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-start-0 rounded-end-pill" placeholder="ค้นหาชื่อ, สังกัด, เลขคำขอ..." value="<?= esc($search ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Mobile View: Cards for Approval Portal -->
    <?php if (!empty($borrowList)): ?>
        <div class="d-block d-md-none mb-4">
            <?php foreach ($borrowList as $row): ?>
                <?php 
                    $isExternal = ($row['borrower_type'] === 'external');
                    $borrowDateStr = date('d/m/', strtotime($row['borrow_date'])) . (date('Y', strtotime($row['borrow_date'])) + 543);
                    $dueDateStr = date('d/m/', strtotime($row['due_date'])) . (date('Y', strtotime($row['due_date'])) + 543);
                ?>
                <div class="approve-card-m">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="code-badge"><i class="bi bi-hash"></i><?= esc($row['borrow_code']) ?></span>
                        <?php 
                        switch ($row['status']) {
                            case 'pending': echo '<span class="status-capsule pending"><i class="bi bi-clock-history"></i> รออนุมัติ</span>'; break;
                            case 'approved': echo '<span class="status-capsule approved"><i class="bi bi-check2-circle"></i> รอจ่ายของ</span>'; break;
                            case 'borrowed': echo '<span class="status-capsule borrowed"><i class="bi bi-box-seam"></i> กำลังยืม</span>'; break;
                            case 'returned': echo '<span class="status-capsule returned"><i class="bi bi-check2-all"></i> คืนแล้ว</span>'; break;
                            case 'rejected': echo '<span class="status-capsule rejected"><i class="bi bi-x-lg"></i> ไม่อนุมัติ</span>'; break;
                            case 'cancelled': echo '<span class="status-capsule rejected"><i class="bi bi-slash-circle"></i> ยกเลิก</span>'; break;
                        }
                        ?>
                    </div>

                    <div class="mb-2">
                        <div class="fw-bold text-dark d-flex align-items-center gap-1">
                            <?= esc($row['borrower_name']) ?>
                            <?php if ($isExternal): ?>
                                <span class="badge bg-label-info py-0 px-1 rounded-pill" style="font-size: 0.65rem;">ภายนอก</span>
                            <?php else: ?>
                                <span class="badge bg-label-success py-0 px-1 rounded-pill" style="font-size: 0.65rem;">บุคลากร</span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted d-block text-truncate"><?= esc($row['borrower_org']) ?></small>
                    </div>

                    <div class="bg-light rounded-3 p-2 mb-3 small text-dark">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="bi bi-calendar-event text-primary me-1"></i>ระยะเวลา:</span>
                            <span class="fw-semibold"><?= $borrowDateStr ?> - <?= $dueDateStr ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="bi bi-boxes text-primary me-1"></i>พัสดุ:</span>
                            <span class="badge bg-secondary rounded-pill"><?= $row['total_items'] ?> รายการ (<?= $row['total_qty'] ?> ชิ้น)</span>
                        </div>
                        <?php if (!empty($row['items_summary'])): ?>
                            <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">
                                <?= esc($row['items_summary']) ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- Action Controls for Mobile -->
                    <div class="d-flex flex-column gap-2">
                        <?php if ($row['status'] === 'pending'): ?>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-success rounded-pill w-100 py-2 fw-semibold" onclick="approveBorrow(<?= $row['borrow_id'] ?>)">
                                    <i class="bi bi-check-lg me-1"></i> อนุมัติคำขอ
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2" onclick="rejectBorrow(<?= $row['borrow_id'] ?>)">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        <?php elseif ($row['status'] === 'approved'): ?>
                            <button type="button" class="btn btn-sm btn-primary rounded-pill w-100 py-2 fw-semibold" onclick="openPickupModal(<?= $row['borrow_id'] ?>, '<?= esc($row['borrow_code']) ?>', '<?= esc($row['borrower_name']) ?>', '<?= esc($row['borrower_org']) ?>', '<?= esc($row['items_summary'] ?? '') ?>')">
                                <i class="bi bi-camera-fill me-1"></i> จ่ายของ / ถ่ายภาพมอบ
                            </button>
                        <?php elseif ($row['status'] === 'borrowed'): ?>
                            <button type="button" class="btn btn-sm btn-warning text-dark fw-bold rounded-pill w-100 py-2" onclick="openReturnModal(<?= $row['borrow_id'] ?>, '<?= esc($row['borrow_code']) ?>', '<?= esc($row['borrower_name']) ?>', '<?= esc($row['borrower_org']) ?>', '<?= esc($row['items_summary'] ?? '') ?>')">
                                <i class="bi bi-shield-check me-1"></i> ตรวจรับคืน & ถ่ายภาพ
                            </button>
                        <?php endif; ?>

                        <div class="d-flex gap-2">
                            <a href="<?= base_url('Equipment/StaffDetail/' . $row['borrow_id']) ?>" class="btn btn-sm btn-outline-secondary rounded-pill w-100 py-1">
                                <i class="bi bi-eye me-1"></i> รายละเอียด
                            </a>
                            <a href="<?= base_url('Equipment/Print/' . $row['borrow_id']) ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1" title="พิมพ์ใบยืม">
                                <i class="bi bi-printer"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" onclick="deleteBorrow(<?= $row['borrow_id'] ?>, '<?= esc($row['borrow_code']) ?>')" title="ลบคำขอ">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Table of Borrows (Desktop View) -->
    <div class="table-container d-none d-md-block mb-5">
        <div class="table-responsive text-nowrap">
            <table class="table table-custom align-middle">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 140px;">เลขที่คำขอ</th>
                        <th style="min-width: 240px;">ผู้ขอยืม & สังกัดหน่วยงาน</th>
                        <th style="min-width: 170px;">กำหนดระยะเวลายืม</th>
                        <th style="min-width: 220px;">รายการพัสดุอุปกรณ์</th>
                        <th style="width: 130px;">สถานะ</th>
                        <th class="text-center" style="width: 150px;">การดำเนินการ</th>
                        <th class="text-center pe-4" style="width: 60px;">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($borrowList)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="p-4">
                                    <div class="avatar bg-light text-muted rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 68px; height: 68px;">
                                        <i class="bi bi-folder2-open fs-1"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">ไม่พบข้อมูลคำขอยืมพัสดุ</h6>
                                    <p class="text-muted small mb-3">ลองปรับเปลี่ยนตัวกรองสถานะ หรือค้นหาด้วยคำค้นอื่น</p>
                                    <a href="<?= base_url('Equipment/Approve') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-arrow-clockwise me-1"></i> ล้างตัวกรองทั้งหมด
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($borrowList as $row): ?>
                            <?php 
                                $isExternal = ($row['borrower_type'] === 'external');
                                $borrowDateStr = date('d/m/', strtotime($row['borrow_date'])) . (date('Y', strtotime($row['borrow_date'])) + 543);
                                $dueDateStr = date('d/m/', strtotime($row['due_date'])) . (date('Y', strtotime($row['due_date'])) + 543);
                                
                                // เช็คเกินกำหนดคืน
                                $isOverdue = false;
                                if ($row['status'] === 'borrowed' && strtotime($row['due_date']) < strtotime(date('Y-m-d'))) {
                                    $isOverdue = true;
                                }

                                // สุ่ม/กำหนดสี Avatar
                                $avatarColor = $isExternal ? 'bg-info' : 'bg-primary';
                                $initial = mb_substr($row['borrower_name'], 0, 1, 'UTF-8');
                            ?>
                            <tr>
                                <!-- 1. รหัสคำขอ & วันที่สร้าง -->
                                <td class="ps-4">
                                    <div class="code-badge mb-1">
                                        <i class="bi bi-hash"></i><?= esc($row['borrow_code']) ?>
                                    </div>
                                    <div class="text-muted" style="font-size: 0.74rem;">
                                        <i class="bi bi-calendar-event me-1"></i><?= date('d/m/', strtotime($row['created_at'])) . (date('Y', strtotime($row['created_at'])) + 543) . ' ' . date('H:i', strtotime($row['created_at'])) ?> น.
                                    </div>
                                </td>

                                <!-- 2. ผู้ยืม & สังกัด -->
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="borrower-avatar <?= $avatarColor ?> text-white">
                                            <?= esc($initial) ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                                <?= esc($row['borrower_name']) ?>
                                                <?php if ($isExternal): ?>
                                                    <span class="badge bg-label-info py-0 px-2 rounded-pill" style="font-size: 0.68rem;">ภายนอก</span>
                                                <?php else: ?>
                                                    <span class="badge bg-label-success py-0 px-2 rounded-pill" style="font-size: 0.68rem;">บุคลากร</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-muted small">
                                                <span><?= esc($row['borrower_org']) ?></span>
                                                <?php if (!empty($row['borrower_tel'])): ?>
                                                    <span class="ms-1">| <a href="tel:<?= esc($row['borrower_tel']) ?>" class="text-muted text-decoration-none"><i class="bi bi-telephone-fill text-success"></i> <?= esc($row['borrower_tel']) ?></a></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- 3. กำหนดระยะเวลา -->
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <div class="d-flex align-items-center text-dark small fw-medium">
                                            <i class="bi bi-calendar-check text-primary me-2"></i>
                                            <span><?= $borrowDateStr ?></span>
                                            <i class="bi bi-arrow-right mx-1 text-muted"></i>
                                            <span class="<?= $isOverdue ? 'text-danger fw-bold' : '' ?>"><?= $dueDateStr ?></span>
                                        </div>
                                        <div>
                                            <?php if ($row['status'] === 'borrowed'): ?>
                                                <span class="badge bg-label-warning rounded-pill py-0 px-2" style="font-size: 0.65rem;">กำลังใช้งาน</span>
                                            <?php endif; ?>
                                            <?php if ($isOverdue): ?>
                                                <span class="badge bg-danger rounded-pill py-0 px-2 ms-1" style="font-size: 0.65rem;">เลยกำหนด</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- 4. รายการพัสดุ -->
                                <td>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-label-secondary rounded-pill px-2 py-1 fw-bold" style="font-size: 0.75rem;">
                                            <i class="bi bi-boxes me-1"></i><?= $row['total_items'] ?> รายการ (<?= $row['total_qty'] ?> ชิ้น)
                                        </span>
                                    </div>
                                    <div class="text-truncate text-muted small" style="max-width: 280px;" title="<?= esc($row['items_summary'] ?? '') ?>">
                                        <?= esc($row['items_summary'] ?: 'ไม่ได้ระบุรายละเอียด') ?>
                                    </div>
                                </td>

                                <!-- 5. สถานะ -->
                                <td>
                                    <?php 
                                    switch ($row['status']) {
                                        case 'pending':
                                            echo '<span class="status-capsule pending"><span class="pulse-dot"></span> รอพิจารณา</span>';
                                            break;
                                        case 'approved':
                                            echo '<span class="status-capsule approved"><i class="bi bi-check-circle"></i> รอจ่ายของ</span>';
                                            break;
                                        case 'borrowed':
                                            echo '<span class="status-capsule borrowed"><i class="bi bi-box-seam"></i> กำลังใช้งาน</span>';
                                            break;
                                        case 'returned':
                                            echo '<span class="status-capsule returned"><i class="bi bi-check2-all"></i> คืนเสร็จสิ้น</span>';
                                            break;
                                        case 'rejected':
                                            echo '<span class="status-capsule rejected"><i class="bi bi-x-lg"></i> ไม่อนุมัติ</span>';
                                            break;
                                        case 'cancelled':
                                            echo '<span class="status-capsule rejected"><i class="bi bi-slash-circle"></i> ยกเลิกแล้ว</span>';
                                            break;
                                    }
                                    ?>
                                </td>

                                <!-- 6. Action Buttons -->
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <!-- ดูรายละเอียด -->
                                        <a href="<?= base_url('Equipment/StaffDetail/' . $row['borrow_id']) ?>" 
                                           class="btn btn-sm btn-icon btn-outline-secondary btn-action-round" 
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="ดูรายละเอียดคำขอ">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- พิมพ์ใบยืม -->
                                        <a href="<?= base_url('Equipment/Print/' . $row['borrow_id']) ?>" target="_blank"
                                           class="btn btn-sm btn-icon btn-outline-primary btn-action-round" 
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="พิมพ์แบบฟอร์ม">
                                            <i class="bi bi-printer"></i>
                                        </a>

                                        <!-- ปุ่ม Action ตามสถานะ -->
                                        <?php if ($row['status'] === 'pending'): ?>
                                            <button type="button" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm ms-1" 
                                                    onclick="approveBorrow(<?= $row['borrow_id'] ?>)" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="อนุมัติคำขอ">
                                                <i class="bi bi-check-lg me-1"></i>อนุมัติ
                                            </button>
                                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-action-round ms-1" 
                                                    onclick="rejectBorrow(<?= $row['borrow_id'] ?>)" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ไม่อนุมัติ">
                                                <i class="bi bi-x-lg"></i>
                                            </button>

                                        <?php elseif ($row['status'] === 'approved'): ?>
                                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm ms-1" 
                                                    onclick="openPickupModal(<?= $row['borrow_id'] ?>, '<?= esc($row['borrow_code']) ?>', '<?= esc($row['borrower_name']) ?>', '<?= esc($row['borrower_org']) ?>', '<?= esc($row['items_summary'] ?? '') ?>')" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ส่งมอบพัสดุและถ่ายภาพหลักฐาน">
                                                <i class="bi bi-camera-fill me-1"></i>จ่ายของ
                                            </button>

                                        <?php elseif ($row['status'] === 'borrowed'): ?>
                                            <button type="button" class="btn btn-sm btn-warning text-dark fw-bold rounded-pill px-3 shadow-sm ms-1" 
                                                    onclick="openReturnModal(<?= $row['borrow_id'] ?>, '<?= esc($row['borrow_code']) ?>', '<?= esc($row['borrower_name']) ?>', '<?= esc($row['borrower_org']) ?>', '<?= esc($row['items_summary'] ?? '') ?>')" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="ตรวจรับของคืนและถ่ายภาพ">
                                                <i class="bi bi-shield-check me-1"></i>รับคืน
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- 7. ลบคำขอและรูปภาพทั้งหมด (Delete Column) -->
                                <td class="text-center pe-4">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-action-round" 
                                            onclick="deleteBorrow(<?= $row['borrow_id'] ?>, '<?= esc($row['borrow_code']) ?>')" 
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="ลบคำขอนี้และรูปภาพทั้งหมด">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- Modal 1: บันทึกการส่งมอบ / จ่ายพัสดุ (Multi-Photo Up to 5 Images) -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalPickup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <form id="formPickup" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="borrow_id" id="pickup_borrow_id">
                
                <!-- Modal Header -->
                <div class="modal-pickup-header text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar bg-white bg-opacity-20 text-white rounded-circle p-2 d-flex align-items-center justify-content-center shadow" style="width: 48px; height: 48px;">
                                <i class="bi bi-box-seam fs-2"></i>
                            </div>
                            <div>
                                <h5 class="modal-title text-white fw-bold mb-0 fs-5">บันทึกการส่งมอบ / จ่ายพัสดุอุปกรณ์</h5>
                                <div class="text-white-50 small mt-1">ถ่ายภาพหลักฐานผู้ขอยืมคู่กับสิ่งของที่มารับ ณ จุดส่งมอบ (สูงสุด 5 รูป)</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <!-- Order Detail Card Summary -->
                    <div class="modal-order-summary mb-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary rounded-pill px-3 py-1 font-monospace" id="pickupModalCode">EQ-0000</span>
                                <span class="badge bg-label-info rounded-pill" id="pickupModalType">รอส่งมอบ</span>
                            </div>
                            <span class="text-muted small"><i class="bi bi-info-circle me-1 text-primary"></i>ตรวจสอบความถูกต้องก่อนส่งมอบ</span>
                        </div>
                        <div class="row g-2 pt-2 border-top">
                            <div class="col-sm-6">
                                <small class="text-muted d-block">ผู้ขอรับพัสดุ:</small>
                                <strong class="text-dark" id="pickupModalBorrower">-</strong>
                                <div class="small text-muted" id="pickupModalOrg">-</div>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">รายการพัสดุที่ต้องจ่าย:</small>
                                <div class="small fw-semibold text-primary text-truncate" id="pickupModalItems">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Officer Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">
                            <i class="bi bi-person text-primary me-1"></i> ชื่อเจ้าหน้าที่ผู้ส่งมอบ / ผู้จ่ายของ <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-vcard text-muted"></i></span>
                            <input type="text" name="pickup_officer" class="form-control border-start-0" value="<?= esc(session()->get('fullname') ?? 'เจ้าหน้าที่งานพัสดุ') ?>" required placeholder="ระบุชื่อเจ้าหน้าที่ผู้จ่ายของ">
                        </div>
                    </div>

                    <!-- Step 2: Photo Upload Drag & Drop (Up to 5 Photos) -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-bold text-dark small mb-0">
                                <i class="bi bi-camera-fill text-primary me-1"></i> ภาพถ่ายผู้ยืมคู่กับพัสดุอุปกรณ์ที่มารับ (สูงสุด 5 รูป) <span class="text-danger">*</span>
                            </label>
                            <span class="badge bg-label-primary text-primary font-monospace" id="pickupPhotoCountBadge" style="font-size: 0.75rem;">0 / 5 รูป</span>
                        </div>
                        
                        <!-- Dropzone Box -->
                        <div class="modal-dropzone-pro" id="pickupDropzone" onclick="document.getElementById('pickup_photo').click()">
                            <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 58px; height: 58px;">
                                <i class="bi bi-camera-fill fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">คลิกเพื่อถ่ายภาพ / เลือกรูป หรือลากไฟล์มาวาง</h6>
                            <p class="text-muted small mb-2" style="font-size: 0.78rem;">
                                ถ่ายภาพผู้ขอยืมคู่กับพัสดุอุปกรณ์ ณ จุดส่งมอบเพื่อเป็นหลักฐานยืนยัน (เลือกได้สูงสุด 5 ภาพ)
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="event.stopPropagation(); document.getElementById('pickup_photo_camera').click();">
                                    <i class="bi bi-camera-fill me-1"></i> ถ่ายภาพด้วยกล้อง
                                </button>
                                <button type="button" class="btn btn-sm btn-light rounded-pill px-3" onclick="event.stopPropagation(); document.getElementById('pickup_photo').click();">
                                    <i class="bi bi-image me-1"></i> เลือกไฟล์รูป
                                </button>
                            </div>
                            <input type="file" name="pickup_photo[]" id="pickup_photo" class="d-none" accept="image/*" multiple>
                            <input type="file" id="pickup_photo_camera" class="d-none" accept="image/*" capture="environment">
                        </div>

                        <!-- Multi-Preview Gallery Container -->
                        <div id="pickupPreviewContainer" class="d-none mt-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <small class="fw-bold text-dark"><i class="bi bi-images me-1 text-primary"></i> รายการรูปถ่ายที่เลือก (<span id="pickupCountText">0</span>/5):</small>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill py-0 px-2" style="font-size: 0.72rem;" onclick="clearAllPickupPhotos()">
                                    <i class="bi bi-trash3 me-1"></i> ลบทั้งหมด
                                </button>
                            </div>
                            <div class="row g-2" id="pickupPreviewGrid">
                                <!-- Dynamic Thumbnail Cards -->
                            </div>
                            <div class="text-center mt-2" id="pickupAddMoreBox">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="document.getElementById('pickup_photo').click()">
                                    <i class="bi bi-plus-circle me-1"></i> เพิ่มรูปถ่ายอีก
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Remark -->
                    <div class="mb-0">
                        <label class="form-label fw-bold text-dark small">
                            <i class="bi bi-journal-text text-primary me-1"></i> หมายเหตุการส่งมอบ (ถ้ามี)
                        </label>
                        <textarea name="pickup_remark" class="form-control rounded-3" rows="2" placeholder="เช่น ผู้ยืมตรวจสอบสภาพอุปกรณ์ครบถ้วน ใช้งานได้ปกติก่อนรับของ"></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light px-4 py-3 border-top-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow" id="btnSubmitPickup">
                        <span class="btn-text"><i class="bi bi-check-lg me-1"></i> ยืนยันและบันทึกจ่ายของ</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-2"></span>กำลังอัปโหลด...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- Modal 2: บันทึกการตรวจรับคืนพัสดุ (Multi-Photo Up to 5 Images) -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalReturn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <form id="formReturn" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="borrow_id" id="return_borrow_id">

                <!-- Modal Header -->
                <div class="modal-return-header text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar bg-white bg-opacity-20 text-white rounded-circle p-2 d-flex align-items-center justify-content-center shadow" style="width: 48px; height: 48px;">
                                <i class="bi bi-shield-check fs-2"></i>
                            </div>
                            <div>
                                <h5 class="modal-title text-white fw-bold mb-0 fs-5">บันทึกการตรวจรับคืนพัสดุเข้าสต็อก</h5>
                                <div class="text-white-50 small mt-1">ตรวจสอบสภาพพัสดุอุปกรณ์และถ่ายภาพผู้ส่งคืน (สูงสุด 5 รูป)</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <!-- Order Detail Card Summary -->
                    <div class="modal-order-summary mb-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-1 font-monospace" id="returnModalCode">EQ-0000</span>
                                <span class="badge bg-label-warning rounded-pill" id="returnModalType">ตรวจรับคืน</span>
                            </div>
                            <span class="text-muted small"><i class="bi bi-shield-check me-1 text-warning"></i>ตรวจนับจำนวนและสภาพก่อนรับเข้า</span>
                        </div>
                        <div class="row g-2 pt-2 border-top">
                            <div class="col-sm-6">
                                <small class="text-muted d-block">ผู้ส่งคืนพัสดุ:</small>
                                <strong class="text-dark" id="returnModalBorrower">-</strong>
                                <div class="small text-muted" id="returnModalOrg">-</div>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">รายการพัสดุที่ต้องรับคืน:</small>
                                <div class="small fw-semibold text-warning text-truncate" id="returnModalItems">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Condition Select -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">
                            <i class="bi bi-check2-all text-warning me-1"></i> สภาพพัสดุอุปกรณ์ตอนส่งมอบคืน <span class="text-danger">*</span>
                        </label>
                        <select name="return_condition" class="form-select rounded-3 py-2" required>
                            <option value="normal">✅ สภาพปกติ สมบูรณ์พร้อมใช้งาน (ส่งคืนเข้าสต็อก)</option>
                            <option value="damaged">⚠️ ชำรุด / เสียหาย (ต้องส่งซ่อมบำรุง)</option>
                            <option value="lost">❌ สูญหาย / อุปกรณ์ไม่ครบ (ต้องดำเนินการติดตาม)</option>
                        </select>
                    </div>

                    <!-- Step 2: Officer Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">
                            <i class="bi bi-person-check text-warning me-1"></i> ชื่อเจ้าหน้าที่ผู้ตรวจรับคืน <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-vcard text-muted"></i></span>
                            <input type="text" name="return_officer" class="form-control border-start-0" value="<?= esc(session()->get('fullname') ?? 'เจ้าหน้าที่งานพัสดุ') ?>" required placeholder="ระบุชื่อเจ้าหน้าที่ผู้ตรวจรับ">
                        </div>
                    </div>

                    <!-- Step 3: Photo Upload Drag & Drop (Up to 5 Photos) -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label fw-bold text-dark small mb-0">
                                <i class="bi bi-camera-fill text-warning me-1"></i> ภาพถ่ายผู้คืนคู่กับสภาพพัสดุที่นำมาคืน (สูงสุด 5 รูป) <span class="text-danger">*</span>
                            </label>
                            <span class="badge bg-label-warning text-dark font-monospace" id="returnPhotoCountBadge" style="font-size: 0.75rem;">0 / 5 รูป</span>
                        </div>

                        <!-- Dropzone Box -->
                        <div class="modal-dropzone-pro modal-dropzone-warning" id="returnDropzone" onclick="document.getElementById('return_photo').click()">
                            <div class="avatar bg-warning bg-opacity-15 text-warning rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 58px; height: 58px;">
                                <i class="bi bi-camera-fill fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">คลิกเพื่อถ่ายภาพ / เลือกรูป หรือลากไฟล์มาวาง</h6>
                            <p class="text-muted small mb-2" style="font-size: 0.78rem;">
                                ถ่ายภาพผู้ส่งคืนและสภาพอุปกรณ์ที่นำมาส่งมอบคืนเพื่อเป็นหลักฐาน (เลือกได้สูงสุด 5 ภาพ)
                            </p>
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 text-dark" onclick="event.stopPropagation(); document.getElementById('return_photo_camera').click();">
                                    <i class="bi bi-camera-fill me-1"></i> ถ่ายภาพด้วยกล้อง
                                </button>
                                <button type="button" class="btn btn-sm btn-light rounded-pill px-3" onclick="event.stopPropagation(); document.getElementById('return_photo').click();">
                                    <i class="bi bi-image me-1"></i> เลือกไฟล์รูป
                                </button>
                            </div>
                            <input type="file" name="return_photo[]" id="return_photo" class="d-none" accept="image/*" multiple>
                            <input type="file" id="return_photo_camera" class="d-none" accept="image/*" capture="environment">
                        </div>

                        <!-- Multi-Preview Gallery Container -->
                        <div id="returnPreviewContainer" class="d-none mt-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <small class="fw-bold text-dark"><i class="bi bi-images me-1 text-warning"></i> รายการรูปถ่ายที่เลือก (<span id="returnCountText">0</span>/5):</small>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill py-0 px-2" style="font-size: 0.72rem;" onclick="clearAllReturnPhotos()">
                                    <i class="bi bi-trash3 me-1"></i> ลบทั้งหมด
                                </button>
                            </div>
                            <div class="row g-2" id="returnPreviewGrid">
                                <!-- Dynamic Thumbnail Cards -->
                            </div>
                            <div class="text-center mt-2" id="returnAddMoreBox">
                                <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 text-dark" onclick="document.getElementById('return_photo').click()">
                                    <i class="bi bi-plus-circle me-1"></i> เพิ่มรูปถ่ายอีก
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Remark -->
                    <div class="mb-0">
                        <label class="form-label fw-bold text-dark small">
                            <i class="bi bi-journal-text text-warning me-1"></i> หมายเหตุ / รายละเอียดความเสียหาย (ถ้ามี)
                        </label>
                        <textarea name="return_remark" class="form-control rounded-3" rows="2" placeholder="เช่น ตรวจนับอุปกรณ์ครบทุกชิ้น สภาพดีเยี่ยม พร้อมนำเข้าสต็อกใช้งานต่อ"></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light px-4 py-3 border-top-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow" id="btnSubmitReturn">
                        <span class="btn-text"><i class="bi bi-download me-1"></i> บันทึกตรวจรับคืน</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-2"></span>กำลังอัปโหลด...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('customJS') ?>
<script>
    // Global State for Multi-Image Upload (Up to 5 Photos)
    let pickupFilesList = [];
    let returnFilesList = [];
    let modalPickupInstance = null;
    let modalReturnInstance = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize Modals
        const modalPickupEl = document.getElementById('modalPickup');
        if (modalPickupEl) modalPickupInstance = new bootstrap.Modal(modalPickupEl);

        const modalReturnEl = document.getElementById('modalReturn');
        if (modalReturnEl) modalReturnInstance = new bootstrap.Modal(modalReturnEl);
    });

    // อนุมัติคำขอ (SweetAlert2 Confirmation)
    window.approveBorrow = function(borrowId) {
        Swal.fire({
            title: 'ยืนยันการอนุมัติคำขอยืม?',
            text: 'ระบบจะเปลี่ยนสถานะเป็นอนุมัติ และเตรียมพร้อมสำหรับการส่งมอบพัสดุ',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> ยืนยันอนุมัติ',
            confirmButtonColor: '#71dd37',
            cancelButtonText: 'ยกเลิก',
            cancelButtonColor: '#8592a3',
            customClass: {
                confirmButton: 'btn btn-success rounded-pill px-4',
                cancelButton: 'btn btn-outline-secondary rounded-pill px-4 ms-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังบันทึกข้อมูล...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch('<?= base_url('Admin/Equipment/approveBorrow') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'borrow_id=' + borrowId + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'อนุมัติสำเร็จ!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#696cff',
                            customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
                            buttonsStyling: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
                });
            }
        });
    };

    // ไม่อนุมัติคำขอ (SweetAlert2 with Reason Input)
    window.rejectBorrow = function(borrowId) {
        Swal.fire({
            title: 'ระบุเหตุผลที่ไม่อนุมัติ',
            input: 'textarea',
            inputPlaceholder: 'เช่น พัสดุถูกจองเต็มแล้ว หรืออยู่นอกช่วงเวลาให้บริการ...',
            inputAttributes: {
                'aria-label': 'ระบุเหตุผลที่ไม่อนุมัติ'
            },
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-x-lg me-1"></i> ยืนยันไม่อนุมัติ',
            confirmButtonColor: '#ff3e1d',
            cancelButtonText: 'ยกเลิก',
            cancelButtonColor: '#8592a3',
            customClass: {
                confirmButton: 'btn btn-danger rounded-pill px-4',
                cancelButton: 'btn btn-outline-secondary rounded-pill px-4 ms-2'
            },
            buttonsStyling: false,
            inputValidator: (value) => {
                if (!value || !value.trim()) {
                    return 'กรุณาระบุเหตุผลที่ไม่อนุมัติเพื่อให้ผู้ขอยืมทราบ';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังดำเนินการ...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch('<?= base_url('Admin/Equipment/rejectBorrow') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'borrow_id=' + borrowId + '&reject_reason=' + encodeURIComponent(result.value) + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'บันทึกเรียบร้อย!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#696cff',
                            customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
                            buttonsStyling: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
                });
            }
        });
    };

    // ลบคำขอยืมถาวร พร้อมรูปภาพทั้งหมด (SweetAlert2)
    window.deleteBorrow = function(borrowId, borrowCode) {
        Swal.fire({
            title: `ยืนยันลบคำขอ ${borrowCode}?`,
            text: 'ข้อมูลคำขอ รายการพัสดุ และไฟล์รูปภาพหลักฐานทั้งหมดจะถูกลบออกจากระบบอย่างถาวร (ไม่สามารถกู้คืนได้)',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash3 me-1"></i> ใช่, ยืนยันลบข้อมูล',
            confirmButtonColor: '#ff3e1d',
            cancelButtonText: 'ยกเลิก',
            cancelButtonColor: '#8592a3',
            customClass: {
                confirmButton: 'btn btn-danger rounded-pill px-4',
                cancelButton: 'btn btn-outline-secondary rounded-pill px-4 ms-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังลบข้อมูลและรูปภาพ...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch('<?= base_url('Admin/Equipment/deleteBorrow') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'borrow_id=' + borrowId + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'ลบข้อมูลสำเร็จ!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#696cff',
                            customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
                            buttonsStyling: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
                });
            }
        });
    };

    // ==========================================
    // MULTI-PHOTO HANDLER: PICKUP
    // ==========================================
    function addPickupFiles(newFiles) {
        if (!newFiles || newFiles.length === 0) return;
        const validImages = Array.from(newFiles).filter(file => file.type.startsWith('image/'));
        for (let i = 0; i < validImages.length; i++) {
            if (pickupFilesList.length >= 5) {
                Swal.fire('แจ้งเตือน', 'แนบรูปภาพได้สูงสุด 5 รูป', 'info');
                break;
            }
            pickupFilesList.push(validImages[i]);
        }
        syncPickupFilesAndRender();
    }

    function syncPickupFilesAndRender() {
        const pickupInput = document.getElementById('pickup_photo');
        const container = document.getElementById('pickupPreviewContainer');
        const grid = document.getElementById('pickupPreviewGrid');
        const countBadge = document.getElementById('pickupPhotoCountBadge');
        const countText = document.getElementById('pickupCountText');
        const addMoreBox = document.getElementById('pickupAddMoreBox');

        // Sync กับ input files ด้วย DataTransfer (มาตรฐานเดียวกับ UserEquipmentAdd)
        if (pickupInput) {
            const dt = new DataTransfer();
            pickupFilesList.forEach(file => dt.items.add(file));
            pickupInput.files = dt.files;
        }

        grid.innerHTML = '';
        if (countBadge) countBadge.textContent = `${pickupFilesList.length} / 5 รูป`;
        if (countText) countText.textContent = pickupFilesList.length;

        if (pickupFilesList.length === 0) {
            container.classList.add('d-none');
            return;
        }

        container.classList.remove('d-none');
        if (pickupFilesList.length >= 5) {
            addMoreBox.classList.add('d-none');
        } else {
            addMoreBox.classList.remove('d-none');
        }

        pickupFilesList.forEach((file, index) => {
            const col = document.createElement('div');
            col.className = 'col-6 col-sm-4 col-md-3';
            
            const card = document.createElement('div');
            card.className = 'position-relative border rounded-3 p-1 bg-white shadow-sm text-center h-100';

            const img = document.createElement('img');
            img.className = 'rounded-2 w-100';
            img.style.height = '85px';
            img.style.objectFit = 'cover';
            img.src = URL.createObjectURL(file);

            const badge = document.createElement('span');
            badge.className = 'position-absolute top-0 start-0 badge bg-primary rounded-pill m-1';
            badge.style.fontSize = '0.65rem';
            badge.textContent = `#${index + 1}`;

            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.className = 'position-absolute top-0 end-0 btn btn-sm btn-danger rounded-circle p-1 m-1 shadow-sm d-flex align-items-center justify-content-center';
            delBtn.style.width = '24px';
            delBtn.style.height = '24px';
            delBtn.innerHTML = '<i class="bi bi-x-lg" style="font-size: 11px;"></i>';
            delBtn.onclick = function(e) {
                e.stopPropagation();
                pickupFilesList.splice(index, 1);
                syncPickupFilesAndRender();
            };

            const fname = document.createElement('div');
            fname.className = 'text-truncate small text-muted mt-1 px-1';
            fname.style.fontSize = '0.7rem';
            fname.textContent = file.name;

            card.appendChild(badge);
            card.appendChild(delBtn);
            card.appendChild(img);
            card.appendChild(fname);
            col.appendChild(card);
            grid.appendChild(col);
        });
    }

    window.clearAllPickupPhotos = function() {
        pickupFilesList = [];
        syncPickupFilesAndRender();
    };

    // ==========================================
    // MULTI-PHOTO HANDLER: RETURN
    // ==========================================
    function addReturnFiles(newFiles) {
        if (!newFiles || newFiles.length === 0) return;
        const validImages = Array.from(newFiles).filter(file => file.type.startsWith('image/'));
        for (let i = 0; i < validImages.length; i++) {
            if (returnFilesList.length >= 5) {
                Swal.fire('แจ้งเตือน', 'แนบรูปภาพได้สูงสุด 5 รูป', 'info');
                break;
            }
            returnFilesList.push(validImages[i]);
        }
        syncReturnFilesAndRender();
    }

    function syncReturnFilesAndRender() {
        const returnInput = document.getElementById('return_photo');
        const container = document.getElementById('returnPreviewContainer');
        const grid = document.getElementById('returnPreviewGrid');
        const countBadge = document.getElementById('returnPhotoCountBadge');
        const countText = document.getElementById('returnCountText');
        const addMoreBox = document.getElementById('returnAddMoreBox');

        // Sync กับ input files ด้วย DataTransfer
        if (returnInput) {
            const dt = new DataTransfer();
            returnFilesList.forEach(file => dt.items.add(file));
            returnInput.files = dt.files;
        }

        grid.innerHTML = '';
        if (countBadge) countBadge.textContent = `${returnFilesList.length} / 5 รูป`;
        if (countText) countText.textContent = returnFilesList.length;

        if (returnFilesList.length === 0) {
            container.classList.add('d-none');
            return;
        }

        container.classList.remove('d-none');
        if (returnFilesList.length >= 5) {
            addMoreBox.classList.add('d-none');
        } else {
            addMoreBox.classList.remove('d-none');
        }

        returnFilesList.forEach((file, index) => {
            const col = document.createElement('div');
            col.className = 'col-6 col-sm-4 col-md-3';
            
            const card = document.createElement('div');
            card.className = 'position-relative border rounded-3 p-1 bg-white shadow-sm text-center h-100';

            const img = document.createElement('img');
            img.className = 'rounded-2 w-100';
            img.style.height = '85px';
            img.style.objectFit = 'cover';
            img.src = URL.createObjectURL(file);

            const badge = document.createElement('span');
            badge.className = 'position-absolute top-0 start-0 badge bg-warning text-dark rounded-pill m-1';
            badge.style.fontSize = '0.65rem';
            badge.textContent = `#${index + 1}`;

            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.className = 'position-absolute top-0 end-0 btn btn-sm btn-danger rounded-circle p-1 m-1 shadow-sm d-flex align-items-center justify-content-center';
            delBtn.style.width = '24px';
            delBtn.style.height = '24px';
            delBtn.innerHTML = '<i class="bi bi-x-lg" style="font-size: 11px;"></i>';
            delBtn.onclick = function(e) {
                e.stopPropagation();
                returnFilesList.splice(index, 1);
                syncReturnFilesAndRender();
            };

            const fname = document.createElement('div');
            fname.className = 'text-truncate small text-muted mt-1 px-1';
            fname.style.fontSize = '0.7rem';
            fname.textContent = file.name;

            card.appendChild(badge);
            card.appendChild(delBtn);
            card.appendChild(img);
            card.appendChild(fname);
            col.appendChild(card);
            grid.appendChild(col);
        });
    }

    window.clearAllReturnPhotos = function() {
        returnFilesList = [];
        syncReturnFilesAndRender();
    };

    // Open Modals
    window.openPickupModal = function(borrowId, code, borrower, org, items) {
        pickupFilesList = [];
        syncPickupFilesAndRender();
        document.getElementById('pickup_borrow_id').value = borrowId;
        document.getElementById('pickupModalCode').innerText = code;
        document.getElementById('pickupModalBorrower').innerText = borrower;
        document.getElementById('pickupModalOrg').innerText = org || 'ไม่ได้ระบุสังกัด';
        document.getElementById('pickupModalItems').innerText = items || 'รายการพัสดุตามคำขอ';
        
        if (!modalPickupInstance) {
            modalPickupInstance = new bootstrap.Modal(document.getElementById('modalPickup'));
        }
        modalPickupInstance.show();
    };

    window.openReturnModal = function(borrowId, code, borrower, org, items) {
        returnFilesList = [];
        syncReturnFilesAndRender();
        document.getElementById('return_borrow_id').value = borrowId;
        document.getElementById('returnModalCode').innerText = code;
        document.getElementById('returnModalBorrower').innerText = borrower;
        document.getElementById('returnModalOrg').innerText = org || 'ไม่ได้ระบุสังกัด';
        document.getElementById('returnModalItems').innerText = items || 'รายการพัสดุตามคำขอ';
        
        if (!modalReturnInstance) {
            modalReturnInstance = new bootstrap.Modal(document.getElementById('modalReturn'));
        }
        modalReturnInstance.show();
    };

    // Init Drag and Drop for Multi-Photo
    function initMultiDropzone(zoneId, inputId, cameraInputId, addFilesCallback) {
        const dropzone = document.getElementById(zoneId);
        const input = document.getElementById(inputId);
        const camInput = document.getElementById(cameraInputId);

        if (!dropzone || !input) return;

        ['dragenter', 'dragover'].forEach(name => {
            dropzone.addEventListener(name, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(name => {
            dropzone.addEventListener(name, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('dragover');
            });
        });

        dropzone.addEventListener('drop', (e) => {
            if (e.dataTransfer.files.length > 0) {
                addFilesCallback(e.dataTransfer.files);
            }
        });

        input.addEventListener('change', function() {
            if (this.files.length > 0) {
                addFilesCallback(this.files);
            }
        });

        if (camInput) {
            camInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    addFilesCallback(this.files);
                    this.value = '';
                }
            });
        }
    }

    // Submit Pickup Form (ใช้ FormData ตรงๆ เหมือนหน้าส่งคำขอ)
    document.getElementById('formPickup').addEventListener('submit', function(e) {
        e.preventDefault();
        if (pickupFilesList.length === 0) {
            Swal.fire('แจ้งเตือน', 'กรุณาถ่ายภาพหรือแนบรูปภาพผู้ยืมคู่กับพัสดุอย่างน้อย 1 รูป', 'warning');
            return;
        }

        const formData = new FormData(this);
        const submitBtn = document.getElementById('btnSubmitPickup');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        submitBtn.disabled = true;
        if (btnText) btnText.classList.add('d-none');
        if (btnLoading) btnLoading.classList.remove('d-none');

        fetch('<?= base_url('Admin/Equipment/savePickup') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                if (modalPickupInstance) modalPickupInstance.hide();
                Swal.fire({
                    title: 'บันทึกสำเร็จ!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#696cff',
                    customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
                    buttonsStyling: false
                }).then(() => location.reload());
            } else {
                Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                submitBtn.disabled = false;
                if (btnText) btnText.classList.remove('d-none');
                if (btnLoading) btnLoading.classList.add('d-none');
            }
        })
        .catch(err => {
            Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
            submitBtn.disabled = false;
            if (btnText) btnText.classList.remove('d-none');
            if (btnLoading) btnLoading.classList.add('d-none');
        });
    });

    // Submit Return Form (ใช้ FormData ตรงๆ เหมือนหน้าส่งคำขอ)
    document.getElementById('formReturn').addEventListener('submit', function(e) {
        e.preventDefault();
        if (returnFilesList.length === 0) {
            Swal.fire('แจ้งเตือน', 'กรุณาถ่ายภาพหรือแนบรูปภาพสภาพพัสดุตอนส่งคืนอย่างน้อย 1 รูป', 'warning');
            return;
        }

        const formData = new FormData(this);
        const submitBtn = document.getElementById('btnSubmitReturn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        submitBtn.disabled = true;
        if (btnText) btnText.classList.add('d-none');
        if (btnLoading) btnLoading.classList.remove('d-none');

        fetch('<?= base_url('Admin/Equipment/saveReturn') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                if (modalReturnInstance) modalReturnInstance.hide();
                Swal.fire({
                    title: 'บันทึกรับคืนสำเร็จ!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#696cff',
                    customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
                    buttonsStyling: false
                }).then(() => location.reload());
            } else {
                Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                submitBtn.disabled = false;
                if (btnText) btnText.classList.remove('d-none');
                if (btnLoading) btnLoading.classList.add('d-none');
            }
        })
        .catch(err => {
            Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
            submitBtn.disabled = false;
            if (btnText) btnText.classList.remove('d-none');
            if (btnLoading) btnLoading.classList.add('d-none');
        });
    });

    // ฟังก์ชันล้างไฟล์รูปภาพขยะที่ไม่มีอยู่ในฐานข้อมูล (Cleanup Orphan Images)
    function cleanupOrphanImages() {
        Swal.fire({
            title: 'ยืนยันการล้างไฟล์ขยะ?',
            text: 'ระบบจะตรวจสอบและลบไฟล์รูปภาพที่ไม่มีการอ้างอิงในฐานข้อมูลออกอย่างถาวร!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#8592a3',
            confirmButtonText: '<i class="bi bi-trash3 me-1"></i> ใช่, เริ่มล้างไฟล์ขยะ',
            cancelButtonText: 'ยกเลิก',
            customClass: {
                confirmButton: 'btn btn-danger rounded-pill px-4',
                cancelButton: 'btn btn-outline-secondary rounded-pill px-4'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังตรวจสอบและล้างไฟล์ขยะ...',
                    text: 'กรุณารอสักครู่ ระบบกำลังประมวลผล...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('<?= base_url('Equipment/cleanupOrphanImages') ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: '<?= csrf_token() ?>=<?= csrf_hash() ?>'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'สำเร็จ!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#696cff',
                            customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
                            buttonsStyling: false
                        });
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>
