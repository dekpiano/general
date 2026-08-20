<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    /* Mobile-First Hero Banner */
    .hero-banner {
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        border-radius: 1.25rem;
        color: white;
        padding: 1.5rem 1.25rem;
        box-shadow: 0 10px 25px rgba(105, 108, 255, 0.22);
        position: relative;
        overflow: hidden;
    }

    @media (min-width: 768px) {
        .hero-banner {
            border-radius: 1.75rem;
            padding: 2.2rem 2rem;
        }
    }

    .hero-banner::after {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -60px;
        right: -60px;
        pointer-events: none;
    }

    /* Quick Action Buttons for Mobile */
    .hero-btn {
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    @media (max-width: 575.98px) {
        .hero-btn-group {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 0.6rem !important;
        }
        .hero-btn {
            width: 100%;
        }
    }

    /* Mobile Stat Cards */
    .stat-card-m {
        border-radius: 1rem;
        background: #ffffff;
        border: 1px solid rgba(67, 89, 113, 0.08);
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        transition: transform 0.2s ease;
        padding: 1rem 0.75rem;
    }
    .stat-card-m:hover {
        transform: translateY(-2px);
    }

    /* Mobile Request Card List */
    .borrow-card-m {
        background: #ffffff;
        border-radius: 1rem;
        border: 1px solid rgba(67, 89, 113, 0.1);
        box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        padding: 1rem;
        margin-bottom: 0.85rem;
        transition: all 0.2s ease;
    }
    .borrow-card-m:active {
        background: #f8f9fa;
        transform: scale(0.99);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y px-3 px-md-4">
    <!-- Hero Banner (Theme Sneat Purple) -->
    <div class="hero-banner mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-primary rounded-pill px-3 py-1 fw-bold mb-2 shadow-sm" style="font-size: 0.75rem;">
                    ระบบบริการส่วนกลาง สกจ.
                </span>
                <h3 class="text-white fw-bold mb-2 fs-4 fs-md-2">
                    📦 ระบบยืม-คืนพัสดุและอุปกรณ์
                </h3>
                <p class="text-white-50 mb-3 fs-6" style="font-size: 0.92rem !important; line-height: 1.5;">
                    บริการยืมพัสดุ อุปกรณ์โสตทัศนูปกรณ์ เครื่องมือช่าง โต๊ะ-เก้าอี้ สำหรับบุคลากรและหน่วยงานภายนอก
                </p>
                <div class="hero-btn-group d-flex flex-wrap gap-2 align-items-center">
                    <a href="<?= base_url('Equipment/Add') ?>" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm hero-btn">
                        <i class="bx bx-plus-circle me-1 fs-5"></i> ยื่นคำขอยืมพัสดุ
                    </a>
                    <a href="<?= base_url('Equipment/History') ?>" class="btn btn-outline-light rounded-pill px-4 hero-btn">
                        <i class="bx bx-list-ul me-1 fs-5"></i> ติดตามคำขอทั้งหมด
                    </a>
                    <a href="<?= base_url('manual/equipment') ?>" class="btn btn-outline-light rounded-pill px-4 hero-btn">
                        <i class="bx bx-book-open me-1 fs-5"></i> คู่มือการใช้งาน
                    </a>
                    <?php 
                        $session = session();
                        $rawRoles = $session->get('rloes') ?? '';
                        $userRoles = is_string($rawRoles) ? array_map('trim', explode(',', $rawRoles)) : (json_decode($rawRoles, true) ?: []);
                        $userStatus = $session->get('status') ?? '';
                        $isLoggedIn = $session->has('id') || $session->has('username');
                        $isStaff = $isLoggedIn && (
                            in_array($userStatus, ['superadmin', 'admin', 'AdminGeneral', 'ManagerGeneral', 'ExecutiveGeneral']) ||
                            in_array('งานพัสดุและอุปกรณ์', $userRoles) ||
                            !empty($session->get('is_admin'))
                        );
                        if ($isStaff):
                    ?>
                        <a href="<?= base_url('Equipment/Approve') ?>" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm hero-btn">
                            <i class="bx bx-shield-quarter me-1 fs-5"></i> 🛡️ เมนูเจ้าหน้าที่ / อนุมัติยืม-คืน
                        </a>
                    <?php elseif (!$isLoggedIn): ?>
                        <a href="<?= base_url('LoginOfficerGeneral?return_to=' . urlencode(base_url('Equipment/Approve'))) ?>" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm hero-btn">
                            <i class="bx bx-log-in-circle me-1 fs-5"></i> เข้าสู่ระบบเจ้าหน้าที่
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <img src="https://cdn-icons-png.flaticon.com/512/2897/2897785.png" alt="Equipment" style="max-height: 135px; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));">
            </div>
        </div>
    </div>

    <!-- Stats Summary Cards (Mobile-First 2x2 Grid) -->
    <div class="row g-2 g-md-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card-m text-center h-100">
                <div class="avatar bg-label-warning rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bx bx-time-five fs-4 text-warning"></i>
                </div>
                <h4 class="fw-bold mb-0 text-dark"><?= $countPending ?? 0 ?></h4>
                <small class="text-muted" style="font-size: 0.75rem;">รอพิจารณาอนุมัติ</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card-m text-center h-100">
                <div class="avatar bg-label-info rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bx bx-check-circle fs-4 text-info"></i>
                </div>
                <h4 class="fw-bold mb-0 text-dark"><?= $countApproved ?? 0 ?></h4>
                <small class="text-muted" style="font-size: 0.75rem;">อนุมัติแล้ว (รอจ่าย)</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card-m text-center h-100">
                <div class="avatar bg-label-primary rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bx bx-package fs-4 text-primary"></i>
                </div>
                <h4 class="fw-bold mb-0 text-dark"><?= $countBorrowed ?? 0 ?></h4>
                <small class="text-muted" style="font-size: 0.75rem;">กำลังยืมใช้งาน</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card-m text-center h-100">
                <div class="avatar bg-label-success rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bx bx-check-double fs-4 text-success"></i>
                </div>
                <h4 class="fw-bold mb-0 text-dark"><?= $countReturned ?? 0 ?></h4>
                <small class="text-muted" style="font-size: 0.75rem;">ส่งคืนเสร็จสิ้น</small>
            </div>
        </div>
    </div>

    <!-- Live Recent Borrow Requests Feed -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0 text-dark fs-6 fs-md-5">
                <i class="bx bx-list-ul text-primary me-1"></i> รายการคำขอยืมล่าสุด
            </h5>
            <small class="text-muted d-none d-sm-inline">ตรวจสอบสถานะการอนุมัติและรับ-ส่งคืนพัสดุ</small>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('Equipment/Add') ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                <i class="bx bx-plus"></i> <span class="d-none d-sm-inline">ยื่นขอยืม</span>
            </a>
            <a href="<?= base_url('Equipment/History') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bx bx-search"></i> <span class="d-none d-sm-inline">ทั้งหมด</span>
            </a>
        </div>
    </div>

    <?php if (empty($recentBorrows)): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 text-muted mb-4">
            <i class="bx bx-folder-open mb-2 fs-1 text-secondary"></i>
            <p class="mb-0 fw-semibold">ยังไม่มีรายการคำขอยืมในระบบ</p>
        </div>
    <?php else: ?>
        <!-- Mobile View (Cards List) -->
        <div class="d-block d-md-none mb-4">
            <?php foreach (array_slice($recentBorrows, 0, 10) as $bRow): ?>
                <?php 
                    $isExt = ($bRow['borrower_type'] === 'external');
                    $bDateStr = date('d/m/', strtotime($bRow['borrow_date'])) . (date('Y', strtotime($bRow['borrow_date'])) + 543);
                    $dDateStr = date('d/m/', strtotime($bRow['due_date'])) . (date('Y', strtotime($bRow['due_date'])) + 543);
                ?>
                <div class="borrow-card-m">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold font-monospace text-primary fs-6"><?= esc($bRow['borrow_code']) ?></span>
                        <?php 
                        switch ($bRow['status']) {
                            case 'pending':
                                echo '<span class="badge bg-warning text-dark py-1 px-2"><i class="bx bx-time-five me-1"></i>รอพิจารณา</span>';
                                break;
                            case 'approved':
                                echo '<span class="badge bg-info py-1 px-2"><i class="bx bx-check-circle me-1"></i>รอจ่ายของ</span>';
                                break;
                            case 'borrowed':
                                echo '<span class="badge bg-primary py-1 px-2"><i class="bx bx-package me-1"></i>กำลังใช้งาน</span>';
                                break;
                            case 'returned':
                                echo '<span class="badge bg-success py-1 px-2"><i class="bx bx-check-double me-1"></i>คืนเสร็จสิ้น</span>';
                                break;
                            case 'rejected':
                                echo '<span class="badge bg-danger py-1 px-2"><i class="bx bx-x me-1"></i>ไม่อนุมัติ</span>';
                                break;
                            case 'cancelled':
                                echo '<span class="badge bg-secondary py-1 px-2"><i class="bx bx-block me-1"></i>ยกเลิกแล้ว</span>';
                                break;
                        }
                        ?>
                    </div>

                    <div class="mb-2">
                        <div class="fw-bold text-dark d-flex align-items-center gap-1">
                            <?= esc($bRow['borrower_name']) ?>
                            <?php if ($isExt): ?>
                                <span class="badge bg-label-info py-0 px-1 rounded-pill" style="font-size: 0.65rem;">ภายนอก</span>
                            <?php else: ?>
                                <span class="badge bg-label-success py-0 px-1 rounded-pill" style="font-size: 0.65rem;">บุคลากร</span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted d-block text-truncate"><?= esc($bRow['borrower_org']) ?></small>
                    </div>

                    <div class="bg-light rounded-3 p-2 mb-2">
                        <div class="d-flex justify-content-between small text-dark mb-1">
                            <span><i class="bx bx-calendar text-primary me-1"></i>ระยะเวลา:</span>
                            <span class="fw-semibold"><?= $bDateStr ?> - <?= $dDateStr ?></span>
                        </div>
                        <div class="d-flex justify-content-between small text-dark">
                            <span><i class="bx bx-box text-primary me-1"></i>พัสดุ:</span>
                            <span class="badge bg-secondary rounded-pill"><?= $bRow['total_items'] ?> รายการ (<?= $bRow['total_qty'] ?> ชิ้น)</span>
                        </div>
                        <?php if (!empty($bRow['items_summary'])): ?>
                            <small class="text-muted d-block mt-1 text-truncate" style="font-size: 0.75rem;">
                                <?= esc($bRow['items_summary']) ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?= base_url('Equipment/Detail/' . $bRow['borrow_id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill w-100 py-1">
                            <i class="bx bx-show me-1"></i> รายละเอียด
                        </a>
                        <a href="<?= base_url('Equipment/Print/' . $bRow['borrow_id']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1" data-bs-toggle="tooltip" title="พิมพ์ใบยืม">
                            <i class="bx bx-printer"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Desktop View (Full Responsive Table) -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 d-none d-md-block">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">เลขที่คำขอ</th>
                            <th>ผู้ขอยืม & สังกัด</th>
                            <th>กำหนดระยะเวลายืม</th>
                            <th>รายการพัสดุ</th>
                            <th>สถานะ</th>
                            <th class="text-center pe-4">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($recentBorrows, 0, 10) as $bRow): ?>
                            <?php 
                                $isExt = ($bRow['borrower_type'] === 'external');
                                $bDateStr = date('d/m/', strtotime($bRow['borrow_date'])) . (date('Y', strtotime($bRow['borrow_date'])) + 543);
                                $dDateStr = date('d/m/', strtotime($bRow['due_date'])) . (date('Y', strtotime($bRow['due_date'])) + 543);
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold font-monospace text-primary"><?= esc($bRow['borrow_code']) ?></span>
                                    <br><small class="text-muted"><?= date('d/m/', strtotime($bRow['created_at'])) . (date('Y', strtotime($bRow['created_at'])) + 543) ?></small>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($bRow['borrower_name']) ?></div>
                                    <small class="text-muted"><?= esc($bRow['borrower_org']) ?></small>
                                </td>
                                <td><?= $bDateStr ?> - <?= $dDateStr ?></td>
                                <td><?= $bRow['total_items'] ?> รายการ (<?= $bRow['total_qty'] ?> ชิ้น)</td>
                                <td>
                                    <?php 
                                    switch ($bRow['status']) {
                                        case 'pending': echo '<span class="badge bg-warning text-dark"><i class="bx bx-time-five me-1"></i> รอพิจารณา</span>'; break;
                                        case 'approved': echo '<span class="badge bg-info"><i class="bx bx-check-circle me-1"></i> รอจ่ายของ</span>'; break;
                                        case 'borrowed': echo '<span class="badge bg-primary"><i class="bx bx-package me-1"></i> กำลังใช้งาน</span>'; break;
                                        case 'returned': echo '<span class="badge bg-success"><i class="bx bx-check-double me-1"></i> คืนเสร็จสิ้น</span>'; break;
                                        case 'rejected': echo '<span class="badge bg-danger"><i class="bx bx-x me-1"></i> ไม่อนุมัติ</span>'; break;
                                        case 'cancelled': echo '<span class="badge bg-secondary"><i class="bx bx-block me-1"></i> ยกเลิกแล้ว</span>'; break;
                                    }
                                    ?>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?= base_url('Equipment/Detail/' . $bRow['borrow_id']) ?>" class="btn btn-sm btn-icon btn-outline-primary rounded-circle"><i class="bx bx-show"></i></a>
                                        <a href="<?= base_url('Equipment/Print/' . $bRow['borrow_id']) ?>" target="_blank" class="btn btn-sm btn-icon btn-outline-secondary rounded-circle"><i class="bx bx-printer"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
