<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    .stat-card {
        border-radius: 1.25rem;
        transition: transform 0.25s ease;
        border: none;
    }
    .stat-card:hover {
        transform: translateY(-4px);
    }
    .modal-dropzone {
        border: 2px dashed #b4b7ff;
        border-radius: 1rem;
        background: #fbfbfe;
        padding: 1.5rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .modal-dropzone:hover, .modal-dropzone.dragover {
        border-color: #696cff;
        background: rgba(105, 108, 255, 0.08);
    }
    .preview-thumb-admin {
        width: 80px;
        height: 80px;
        border-radius: 0.75rem;
        object-fit: cover;
        border: 2px solid #696cff;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">งานพัสดุและอุปกรณ์ /</span> รายการยืม-คืนพัสดุ</h4>
            <p class="text-muted mb-0">ตรวจสอบคำขอ พิจารณาอนุมัติ ส่งมอบพัสดุ และตรวจรับคืน</p>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-warning bg-opacity-10 border-start border-4 border-warning">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small d-block">รออนุมัติ</span>
                            <h3 class="fw-bold text-warning mb-0"><?= $countPending ?></h3>
                        </div>
                        <div class="avatar bg-warning text-white rounded-circle p-2 d-flex align-items-center justify-content-center">
                            <i class="bx bx-time fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-info bg-opacity-10 border-start border-4 border-info">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small d-block">อนุมัติแล้ว (รอรับของ)</span>
                            <h3 class="fw-bold text-info mb-0"><?= $countApproved ?></h3>
                        </div>
                        <div class="avatar bg-info text-white rounded-circle p-2 d-flex align-items-center justify-content-center">
                            <i class="bx bx-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-primary bg-opacity-10 border-start border-4 border-primary">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small d-block">กำลังใช้งาน (ยืมอยู่)</span>
                            <h3 class="fw-bold text-primary mb-0"><?= $countBorrowed ?></h3>
                        </div>
                        <div class="avatar bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center">
                            <i class="bx bx-box fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm bg-success bg-opacity-10 border-start border-4 border-success">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small d-block">คืนแล้วเสร็จ</span>
                            <h3 class="fw-bold text-success mb-0"><?= $countReturned ?></h3>
                        </div>
                        <div class="avatar bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center">
                            <i class="bx bx-check-double fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="<?= base_url('Admin/Equipment/Approve') ?>" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <select name="status" class="form-select rounded-pill" onchange="this.form.submit()">
                        <option value="all" <?= ($selectedStatus == 'all') ? 'selected' : '' ?>>-- สถานะทั้งหมด --</option>
                        <option value="pending" <?= ($selectedStatus == 'pending') ? 'selected' : '' ?>>⏳ รออนุมัติ</option>
                        <option value="approved" <?= ($selectedStatus == 'approved') ? 'selected' : '' ?>>✅ อนุมัติแล้ว (รอจ่ายของ)</option>
                        <option value="borrowed" <?= ($selectedStatus == 'borrowed') ? 'selected' : '' ?>>📦 กำลังยืมใช้งาน</option>
                        <option value="returned" <?= ($selectedStatus == 'returned') ? 'selected' : '' ?>>🎉 คืนเรียบร้อย</option>
                        <option value="rejected" <?= ($selectedStatus == 'rejected') ? 'selected' : '' ?>>❌ ไม่อนุมัติ</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select rounded-pill" onchange="this.form.submit()">
                        <option value="all" <?= ($selectedType == 'all') ? 'selected' : '' ?>>-- ผู้ยืมทั้งหมด (ภายใน/ภายนอก) --</option>
                        <option value="internal" <?= ($selectedType == 'internal') ? 'selected' : '' ?>>🏫 บุคลากรภายใน</option>
                        <option value="external" <?= ($selectedType == 'external') ? 'selected' : '' ?>>🌐 หน่วยงาน/บุคคลภายนอก</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control rounded-pill" placeholder="ค้นหาเลขที่คำขอ, ชื่อผู้ยืม, หน่วยงาน..." value="<?= esc($search ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100">ค้นหา</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table of Borrows -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">เลขที่คำขอ</th>
                        <th>ผู้ยืม / สังกัดหน่วยงาน</th>
                        <th>วันที่ยืม - ส่งคืน</th>
                        <th>รายการ</th>
                        <th>สถานะ</th>
                        <th class="text-center pe-4">การดำเนินการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($borrowList)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bx bx-folder-open fs-1 mb-2"></i>
                                <p class="mb-0">ไม่พบรายการคำขอยืมพัสดุ</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($borrowList as $row): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-primary font-monospace"><?= esc($row['borrow_code']) ?></span>
                                    <br><small class="text-muted"><?= date('d/m/', strtotime($row['created_at'])) . (date('Y', strtotime($row['created_at'])) + 543) . ' ' . date('H:i', strtotime($row['created_at'])) ?> น.</small>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= esc($row['borrower_name']) ?></div>
                                    <small class="text-muted">
                                        <?php if ($row['borrower_type'] === 'external'): ?>
                                            <span class="badge bg-label-info py-0">หน่วยงานภายนอก</span>
                                        <?php else: ?>
                                            <span class="badge bg-label-success py-0">บุคลากรภายใน</span>
                                        <?php endif; ?>
                                        <?= esc($row['borrower_org']) ?> | 📞 <?= esc($row['borrower_tel']) ?>
                                    </small>
                                </td>
                                <td>
                                    <div>ยืม: <?= date('d/m/', strtotime($row['borrow_date'])) . (date('Y', strtotime($row['borrow_date'])) + 543) ?></div>
                                    <small class="text-danger">คืน: <?= date('d/m/', strtotime($row['due_date'])) . (date('Y', strtotime($row['due_date'])) + 543) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-label-secondary rounded-pill">
                                        <?= $row['total_items'] ?> รายการ (<?= $row['total_qty'] ?> ชิ้น)
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    switch ($row['status']) {
                                        case 'pending':
                                            echo '<span class="badge bg-label-warning rounded-pill px-2 py-1"><i class="bx bx-time me-1"></i> รออนุมัติ</span>';
                                            break;
                                        case 'approved':
                                            echo '<span class="badge bg-label-info rounded-pill px-2 py-1"><i class="bx bx-check me-1"></i> อนุมัติ (รอจ่ายของ)</span>';
                                            break;
                                        case 'borrowed':
                                            echo '<span class="badge bg-label-primary rounded-pill px-2 py-1"><i class="bx bx-package me-1"></i> กำลังใช้งาน</span>';
                                            break;
                                        case 'returned':
                                            echo '<span class="badge bg-label-success rounded-pill px-2 py-1"><i class="bx bx-check-double me-1"></i> คืนแล้ว</span>';
                                            break;
                                        case 'rejected':
                                            echo '<span class="badge bg-label-danger rounded-pill px-2 py-1"><i class="bx bx-x me-1"></i> ไม่อนุมัติ</span>';
                                            break;
                                        case 'cancelled':
                                            echo '<span class="badge bg-label-secondary rounded-pill px-2 py-1"><i class="bx bx-block me-1"></i> ยกเลิก</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="btn-group">
                                        <a href="<?= base_url('Admin/Equipment/Detail/' . $row['borrow_id']) ?>" class="btn btn-sm btn-outline-secondary" title="ดูรายละเอียด">
                                            <i class="bx bx-show"></i>
                                        </a>

                                        <?php if ($row['status'] === 'pending'): ?>
                                            <button type="button" class="btn btn-sm btn-success" onclick="approveBorrow(<?= $row['borrow_id'] ?>)" title="อนุมัติคำขอ">
                                                <i class="bx bx-check"></i> อนุมัติ
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="rejectBorrow(<?= $row['borrow_id'] ?>)" title="ไม่อนุมัติ">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        <?php elseif ($row['status'] === 'approved'): ?>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="openPickupModal(<?= $row['borrow_id'] ?>, '<?= esc($row['borrow_code']) ?>', '<?= esc($row['borrower_name']) ?>')" title="จ่ายพัสดุ (ส่งมอบ)">
                                                <i class="bx bx-upload me-1"></i> จ่ายของ/ถ่ายรูป
                                            </button>
                                        <?php elseif ($row['status'] === 'borrowed'): ?>
                                            <button type="button" class="btn btn-sm btn-warning text-dark fw-semibold" onclick="openReturnModal(<?= $row['borrow_id'] ?>, '<?= esc($row['borrow_code']) ?>', '<?= esc($row['borrower_name']) ?>')" title="ตรวจรับคืน">
                                                <i class="bx bx-download me-1"></i> รับคืน/ถ่ายรูป
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal ส่งมอบพัสดุ (จ่ายของ + รูปถ่าย) -->
<div class="modal fade" id="modalPickup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form id="formPickup" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="borrow_id" id="pickup_borrow_id">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white fw-bold"><i class="bx bx-package me-2"></i>บันทึกการจ่ายของ / ส่งมอบพัสดุ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-primary mb-3 rounded-3" id="pickupInfo"></div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ชื่อเจ้าหน้าที่ผู้ส่งมอบ / จ่ายของ <span class="text-danger">*</span></label>
                        <input type="text" name="pickup_officer" class="form-control rounded-3" value="<?= esc(session()->get('fullname') ?? 'เจ้าหน้าที่งานพัสดุ') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-danger">📷 รูปภาพถ่ายหลักฐานผู้ยืมคู่กับพัสดุอุปกรณ์ที่ยืม <span class="text-danger">*</span></label>
                        <div class="modal-dropzone" id="pickupDropzone" onclick="document.getElementById('pickup_photo').click()">
                            <i class="bx bx-camera text-primary fs-1 mb-1"></i>
                            <div class="fw-bold text-dark small">คลิกเพื่อถ่ายภาพ / เลือกรูป หรือลากไฟล์มาวาง</div>
                            <small class="text-muted" style="font-size: 0.75rem;">ถ่ายรูปผู้ยืมคู่กับพัสดุอุปกรณ์ ณ จุดส่งมอบเพื่อเป็นหลักฐาน</small>
                            <input type="file" name="pickup_photo" id="pickup_photo" class="d-none" accept="image/*" capture="environment" required>
                        </div>
                        <div id="pickupPreviewContainer" class="d-none mt-2">
                            <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded-3 border">
                                <div class="d-flex align-items-center gap-3">
                                    <img id="pickupPreviewImg" class="preview-thumb-admin" src="" alt="Preview">
                                    <div>
                                        <div class="fw-bold text-dark small" id="pickupFileName">photo.jpg</div>
                                        <small class="text-success"><i class="bx bx-check-circle me-1"></i>พร้อมส่งมอบ</small>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="removePickupPhoto(event)">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">หมายเหตุการส่งมอบ (ถ้ามี)</label>
                        <textarea name="pickup_remark" class="form-control rounded-3" rows="2" placeholder="เช่น ผู้ยืมรับอุปกรณ์ครบถ้วนในสภาพสมบูรณ์"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSubmitPickup">
                        <span class="btn-text"><i class="bx bx-package me-1"></i> บันทึกจ่ายของ</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-2"></span>กำลังอัปโหลด...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal ตรวจรับคืนพัสดุ (รับคืน + ตรวจสภาพ + รูปถ่าย Drag & Drop) -->
<div class="modal fade" id="modalReturn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form id="formReturn" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="borrow_id" id="return_borrow_id">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold text-dark"><i class="bx bx-check-shield me-2"></i>บันทึกการตรวจรับคืนพัสดุ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-warning mb-3 rounded-3" id="returnInfo"></div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">สภาพพัสดุอุปกรณ์ตอนส่งคืน <span class="text-danger">*</span></label>
                        <select name="return_condition" class="form-select rounded-3" required>
                            <option value="normal">✅ สภาพปกติ สมบูรณ์พร้อมใช้งาน</option>
                            <option value="damaged">⚠️ ชำรุด / เสียหาย (ต้องซ่อม)</option>
                            <option value="lost">❌ สูญหาย / ขาดหาย</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ชื่อเจ้าหน้าที่ผู้ตรวจรับคืน <span class="text-danger">*</span></label>
                        <input type="text" name="return_officer" class="form-control rounded-3" value="<?= esc(session()->get('fullname') ?? 'เจ้าหน้าที่งานพัสดุ') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-danger">📷 รูปภาพถ่ายหลักฐานผู้คืนคู่กับสภาพพัสดุที่นำมาคืน <span class="text-danger">*</span></label>
                        <div class="modal-dropzone" id="returnDropzone" onclick="document.getElementById('return_photo').click()">
                            <i class="bx bx-camera text-warning fs-1 mb-1"></i>
                            <div class="fw-bold text-dark small">คลิกเพื่อถ่ายภาพ / เลือกรูป หรือลากไฟล์มาวาง</div>
                            <small class="text-muted" style="font-size: 0.75rem;">ถ่ายภาพผู้คืนและสภาพพัสดุที่นำมาคืนเพื่อเป็นหลักฐาน</small>
                            <input type="file" name="return_photo" id="return_photo" class="d-none" accept="image/*" capture="environment" required>
                        </div>
                        <div id="returnPreviewContainer" class="d-none mt-2">
                            <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded-3 border">
                                <div class="d-flex align-items-center gap-3">
                                    <img id="returnPreviewImg" class="preview-thumb-admin" src="" alt="Preview">
                                    <div>
                                        <div class="fw-bold text-dark small" id="returnFileName">photo.jpg</div>
                                        <small class="text-success"><i class="bx bx-check-circle me-1"></i>พร้อมตรวจรับ</small>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="removeReturnPhoto(event)">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">หมายเหตุ / รายละเอียดความเสียหาย (ถ้ามี)</label>
                        <textarea name="return_remark" class="form-control rounded-3" rows="2" placeholder="เช่น คืนอุปกรณ์ครบถ้วน สายไฟไม่มีรอยชำรุด"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-4" id="btnSubmitReturn">
                        <span class="btn-text"><i class="bx bx-download me-1"></i> บันทึกรับคืน</span>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const modalPickup = new bootstrap.Modal(document.getElementById('modalPickup'));
    const modalReturn = new bootstrap.Modal(document.getElementById('modalReturn'));

    function approveBorrow(borrowId) {
        Swal.fire({
            title: 'ยืนยันการอนุมัติคำขอ?',
            text: 'คุณต้องการอนุมัติคำขอยืมพัสดุนี้ใช่หรือไม่',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ใช่, อนุมัติ',
            confirmButtonColor: '#28c76f',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= base_url('Admin/Equipment/approveBorrow') ?>', {
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

    function rejectBorrow(borrowId) {
        Swal.fire({
            title: 'ระบุเหตุผลที่ไม่อนุมัติ',
            input: 'textarea',
            inputPlaceholder: 'เช่น พัสดุถูกจองเต็มแล้ว หรือไม่ตรงตามระเบียบ...',
            showCancelButton: true,
            confirmButtonText: 'ยืนยันไม่อนุมัติ',
            confirmButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            inputValidator: (value) => {
                if (!value) return 'กรุณาระบุเหตุผลที่ไม่อนุมัติ';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= base_url('Admin/Equipment/rejectBorrow') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'borrow_id=' + borrowId + '&reject_reason=' + encodeURIComponent(result.value) + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
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

    // Setup Drag & Drop สำหรับ Modal ในหน้า Admin
    setupAdminDropzone('pickupDropzone', 'pickup_photo', 'pickupPreviewContainer', 'pickupPreviewImg', 'pickupFileName');
    setupAdminDropzone('returnDropzone', 'return_photo', 'returnPreviewContainer', 'returnPreviewImg', 'returnFileName');

    function setupAdminDropzone(zoneId, inputId, containerId, imgId, nameId) {
        const dropzone = document.getElementById(zoneId);
        const input = document.getElementById(inputId);
        const container = document.getElementById(containerId);
        const img = document.getElementById(imgId);
        const nameEl = document.getElementById(nameId);

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
                input.files = e.dataTransfer.files;
                previewAdminFile(e.dataTransfer.files[0], dropzone, container, img, nameEl);
            }
        });

        input.addEventListener('change', function() {
            if (this.files.length > 0) {
                previewAdminFile(this.files[0], dropzone, container, img, nameEl);
            }
        });
    }

    function previewAdminFile(file, dropzone, container, img, nameEl) {
        if (!file) return;
        nameEl.textContent = file.name;
        const reader = new FileReader();
        reader.onload = (e) => {
            img.src = e.target.result;
            container.classList.remove('d-none');
            dropzone.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    }

    function removePickupPhoto(e) {
        if (e) e.stopPropagation();
        document.getElementById('pickup_photo').value = '';
        document.getElementById('pickupPreviewContainer').classList.add('d-none');
        document.getElementById('pickupDropzone').classList.remove('d-none');
    }

    function removeReturnPhoto(e) {
        if (e) e.stopPropagation();
        document.getElementById('return_photo').value = '';
        document.getElementById('returnPreviewContainer').classList.add('d-none');
        document.getElementById('returnDropzone').classList.remove('d-none');
    }

    function openPickupModal(borrowId, code, borrower) {
        removePickupPhoto();
        document.getElementById('pickup_borrow_id').value = borrowId;
        document.getElementById('pickupInfo').innerHTML = `<strong>รหัสคำขอ:</strong> ${code} | <strong>ผู้ยืม:</strong> ${borrower}`;
        modalPickup.show();
    }

    function openReturnModal(borrowId, code, borrower) {
        removeReturnPhoto();
        document.getElementById('return_borrow_id').value = borrowId;
        document.getElementById('returnInfo').innerHTML = `<strong>รหัสคำขอ:</strong> ${code} | <strong>ผู้ยืม:</strong> ${borrower}`;
        modalReturn.show();
    }

    document.getElementById('formPickup').addEventListener('submit', function(e) {
        e.preventDefault();
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
                modalPickup.hide();
                Swal.fire('สำเร็จ', data.message, 'success').then(() => location.reload());
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

    document.getElementById('formReturn').addEventListener('submit', function(e) {
        e.preventDefault();
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
                modalReturn.hide();
                Swal.fire('สำเร็จ', data.message, 'success').then(() => location.reload());
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
</script>
<?= $this->endSection() ?>
