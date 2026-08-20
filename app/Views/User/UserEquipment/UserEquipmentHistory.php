<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    .status-badge {
        padding: 0.4rem 0.85rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.78rem;
    }
    .btn-purple {
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 12px rgba(105, 108, 255, 0.25);
    }
    .btn-purple:hover {
        color: white;
        box-shadow: 0 6px 18px rgba(105, 108, 255, 0.35);
        transform: translateY(-1px);
    }
    /* Mobile History Card */
    .history-card-m {
        background: #ffffff;
        border-radius: 1rem;
        border: 1px solid rgba(67, 89, 113, 0.1);
        box-shadow: 0 3px 12px rgba(0,0,0,0.04);
        padding: 1rem;
        margin-bottom: 0.85rem;
        transition: all 0.2s ease;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
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
?>

<div class="container-xxl flex-grow-1 container-p-y px-3 px-md-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 fs-5 fs-md-4"><span class="text-muted fw-light">พัสดุอุปกรณ์ /</span> รายการคำขอยืมทั้งหมด</h4>
            <p class="text-muted mb-0 small">ติดตามสถานะคำขอ ตรวจรับพัสดุ และประวัติการส่งคืนอุปกรณ์</p>
        </div>
        <div class="d-flex flex-wrap gap-2 w-100 w-md-auto">
            <?php if ($isStaff): ?>
                <a href="<?= base_url('Equipment/Approve') ?>" class="btn btn-warning text-dark fw-bold rounded-pill px-3 shadow-sm flex-fill flex-md-grow-0">
                    <i class="bx bx-shield-quarter me-1"></i> 🛡️ เมนูอนุมัติ
                </a>
            <?php endif; ?>
            <a href="<?= base_url('Equipment/Add') ?>" class="btn btn-purple rounded-pill px-4 flex-fill flex-md-grow-0">
                <i class="bx bx-plus-circle me-1"></i> ยื่นขอยืมใหม่
            </a>
        </div>
    </div>

    <!-- Filter Bar (Mobile-First) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="<?= base_url('Equipment/History') ?>" class="row g-2 align-items-center">
                <div class="col-12 col-md-3">
                    <select name="status" class="form-select rounded-pill" onchange="this.form.submit()">
                        <option value="all" <?= ($selectedStatus == 'all') ? 'selected' : '' ?>>-- สถานะทั้งหมด --</option>
                        <option value="pending" <?= ($selectedStatus == 'pending') ? 'selected' : '' ?>>⏳ รออนุมัติ</option>
                        <option value="approved" <?= ($selectedStatus == 'approved') ? 'selected' : '' ?>>✅ อนุมัติแล้ว (รอรับของ)</option>
                        <option value="borrowed" <?= ($selectedStatus == 'borrowed') ? 'selected' : '' ?>>📦 กำลังยืมใช้งาน</option>
                        <option value="returned" <?= ($selectedStatus == 'returned') ? 'selected' : '' ?>>🎉 คืนเรียบร้อยแล้ว</option>
                        <option value="rejected" <?= ($selectedStatus == 'rejected') ? 'selected' : '' ?>>❌ ไม่อนุมัติ</option>
                        <option value="cancelled" <?= ($selectedStatus == 'cancelled') ? 'selected' : '' ?>>🚫 ยกเลิกแล้ว</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select name="type" class="form-select rounded-pill" onchange="this.form.submit()">
                        <option value="all" <?= ($selectedType == 'all') ? 'selected' : '' ?>>-- ผู้ยืมทั้งหมด (ใน/นอก) --</option>
                        <option value="external" <?= ($selectedType == 'external') ? 'selected' : '' ?>>🌐 บุคคล/หน่วยงานภายนอก</option>
                        <option value="internal" <?= ($selectedType == 'internal') ? 'selected' : '' ?>>🏫 บุคลากรภายในโรงเรียน</option>
                        <?php if (session()->get('id')): ?>
                            <option value="my" <?= ($selectedType == 'my') ? 'selected' : '' ?>>👤 เฉพาะคำขอของฉัน</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 rounded-end-pill" placeholder="ค้นหาเลขที่คำขอ, ชื่อผู้ยืม, เบอร์โทร..." value="<?= esc($search ?? '') ?>">
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100">ค้นหา</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Borrow Cards / Table -->
    <?php if (empty($borrowList)): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 text-muted mb-4">
            <i class="bx bx-folder-open mb-2" style="font-size: 3rem;"></i>
            <p class="mb-0 fw-semibold">ยังไม่มีประวัติการยืมพัสดุอุปกรณ์</p>
        </div>
    <?php else: ?>
        <!-- Mobile View (Cards) -->
        <div class="d-block d-md-none mb-4">
            <?php foreach ($borrowList as $row): ?>
                <div class="history-card-m">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold font-monospace text-primary fs-6"><?= esc($row['borrow_code']) ?></span>
                        <?php 
                        switch ($row['status']) {
                            case 'pending': echo '<span class="badge bg-label-warning status-badge"><i class="bx bx-time-five me-1"></i>รออนุมัติ</span>'; break;
                            case 'approved': echo '<span class="badge bg-label-info status-badge"><i class="bx bx-check me-1"></i>อนุมัติ (รอรับของ)</span>'; break;
                            case 'borrowed': echo '<span class="badge bg-label-primary status-badge"><i class="bx bx-package me-1"></i>กำลังใช้งาน</span>'; break;
                            case 'returned': echo '<span class="badge bg-label-success status-badge"><i class="bx bx-check-double me-1"></i>คืนเรียบร้อย</span>'; break;
                            case 'rejected': echo '<span class="badge bg-label-danger status-badge"><i class="bx bx-x me-1"></i>ไม่อนุมัติ</span>'; break;
                            case 'cancelled': echo '<span class="badge bg-label-secondary status-badge"><i class="bx bx-block me-1"></i>ยกเลิกแล้ว</span>'; break;
                        }
                        ?>
                    </div>

                    <div class="mb-2">
                        <div class="fw-bold text-dark d-flex align-items-center gap-1">
                            <?= esc($row['borrower_name']) ?>
                            <?php if ($row['borrower_type'] === 'external'): ?>
                                <span class="badge bg-label-info py-0 px-1 rounded-pill" style="font-size: 0.65rem;">ภายนอก</span>
                            <?php else: ?>
                                <span class="badge bg-label-success py-0 px-1 rounded-pill" style="font-size: 0.65rem;">บุคลากร</span>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted d-block text-truncate"><?= esc($row['borrower_org']) ?></small>
                    </div>

                    <div class="bg-light rounded-3 p-2 mb-2 small text-dark">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="bx bx-calendar text-muted me-1"></i>ยืม:</span>
                            <span class="fw-semibold"><?= date('d/m/', strtotime($row['borrow_date'])) . (date('Y', strtotime($row['borrow_date'])) + 543) ?></span>
                        </div>
                        <div class="d-flex justify-content-between text-danger mb-1">
                            <span><i class="bx bx-time me-1"></i>กำหนดคืน:</span>
                            <span class="fw-semibold"><?= date('d/m/', strtotime($row['due_date'])) . (date('Y', strtotime($row['due_date'])) + 543) ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="bx bx-package text-muted me-1"></i>จำนวน:</span>
                            <span class="badge bg-secondary rounded-pill"><?= $row['total_items'] ?> รายการ (<?= $row['total_qty'] ?> ชิ้น)</span>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?= base_url('Equipment/Detail/' . $row['borrow_id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill w-100 py-1">
                            <i class="bx bx-show me-1"></i> รายละเอียด
                        </a>
                        <a href="<?= base_url('Equipment/Print/' . $row['borrow_id']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1" data-bs-toggle="tooltip" title="พิมพ์ใบยืม">
                            <i class="bx bx-printer"></i>
                        </a>
                        <?php if ($row['status'] === 'pending'): ?>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" onclick="cancelBorrow(<?= $row['borrow_id'] ?>)" title="ยกเลิก">
                                <i class="bx bx-trash"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Desktop View (Table) -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block mb-5">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">เลขที่คำขอ</th>
                            <th>ผู้ยืม / หน่วยงาน</th>
                            <th>วันที่ยืม - กำหนดคืน</th>
                            <th>จำนวนของ</th>
                            <th>สถานะ</th>
                            <th class="text-center pe-4">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($borrowList as $row): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold font-monospace text-primary"><?= esc($row['borrow_code']) ?></span>
                                    <br>
                                    <small class="text-muted">
                                        <?= date('d/m/', strtotime($row['created_at'])) . (date('Y', strtotime($row['created_at'])) + 543) . ' ' . date('H:i', strtotime($row['created_at'])) ?> น.
                                    </small>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($row['borrower_name']) ?></div>
                                    <small class="text-muted">
                                        <?= ($row['borrower_type'] === 'external') ? '<span class="badge bg-label-info py-0">ภายนอก</span> ' : '' ?>
                                        <?= esc($row['borrower_org']) ?>
                                    </small>
                                </td>
                                <td>
                                    <div><i class="bx bx-calendar text-muted me-1"></i> ยืม: <?= date('d/m/', strtotime($row['borrow_date'])) . (date('Y', strtotime($row['borrow_date'])) + 543) ?></div>
                                    <small class="text-danger"><i class="bx bx-time text-danger me-1"></i> คืน: <?= date('d/m/', strtotime($row['due_date'])) . (date('Y', strtotime($row['due_date'])) + 543) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-label-secondary rounded-pill px-2">
                                        <?= $row['total_items'] ?> รายการ (<?= $row['total_qty'] ?> ชิ้น)
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    switch ($row['status']) {
                                        case 'pending': echo '<span class="badge bg-label-warning status-badge"><i class="bx bx-time-five me-1"></i> รออนุมัติ</span>'; break;
                                        case 'approved': echo '<span class="badge bg-label-info status-badge"><i class="bx bx-check me-1"></i> อนุมัติ (รอรับของ)</span>'; break;
                                        case 'borrowed': echo '<span class="badge bg-label-primary status-badge"><i class="bx bx-package me-1"></i> กำลังใช้งาน</span>'; break;
                                        case 'returned': echo '<span class="badge bg-label-success status-badge"><i class="bx bx-check-double me-1"></i> คืนเรียบร้อย</span>'; break;
                                        case 'rejected': echo '<span class="badge bg-label-danger status-badge"><i class="bx bx-x me-1"></i> ไม่อนุมัติ</span>'; break;
                                        case 'cancelled': echo '<span class="badge bg-label-secondary status-badge"><i class="bx bx-block me-1"></i> ยกเลิกแล้ว</span>'; break;
                                    }
                                    ?>
                                </td>
                                <td class="text-center pe-4">
                                    <a href="<?= base_url('Equipment/Detail/' . $row['borrow_id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                        <i class="bx bx-show me-1"></i> ดูรายละเอียด
                                    </a>
                                    <?php if ($row['status'] === 'pending'): ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="cancelBorrow(<?= $row['borrow_id'] ?>)">
                                            <i class="bx bx-trash"></i> ยกเลิก
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
    function cancelBorrow(borrowId) {
        Swal.fire({
            title: 'ยืนยันการยกเลิกคำขอ?',
            text: 'คุณต้องการยกเลิกคำขอยืมพัสดุนี้ใช่หรือไม่',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ใช่, ยกเลิกคำขอ',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= base_url('Equipment/cancel') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'borrow_id=' + borrowId + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('สำเร็จ', data.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>
