<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    .proof-box {
        background: #f8f9fa;
        border-radius: 1rem;
        padding: 1rem;
        text-align: center;
        border: 2px dashed #e2e8f0;
    }
    .proof-img {
        max-height: 220px;
        width: 100%;
        object-fit: cover;
        border-radius: 0.75rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">งานพัสดุและอุปกรณ์ /</span> รายละเอียดคำขอยืมเลขที่ <?= esc($borrow['borrow_code']) ?></h4>
            <p class="text-muted mb-0">ตรวจสอบข้อมูลผู้ยืม รายการพัสดุ และหลักฐานภาพถ่าย</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('Equipment/Print/' . $borrow['borrow_id']) ?>" target="_blank" class="btn btn-outline-primary rounded-pill px-3">
                <i class="bx bx-printer me-1"></i> พิมพ์ใบคำขอยืม
            </a>
            <a href="<?= base_url('Admin/Equipment/Approve') ?>" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bx bx-arrow-back me-1"></i> กลับหน้ารายการ
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">ข้อมูลคำขอและผู้ขอยืม</h5>
                    <span class="badge bg-label-primary px-3 py-2 rounded-pill"><?= esc(strtoupper($borrow['status'])) ?></span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">ชื่อผู้ขอยืม</small>
                            <span class="fw-bold text-dark"><?= esc($borrow['borrower_name']) ?></span>
                            <?= ($borrow['borrower_type'] === 'external') ? '<span class="badge bg-label-info ms-1">บุคคล/หน่วยงานภายนอก</span>' : '<span class="badge bg-label-success ms-1">บุคลากรภายใน</span>' ?>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">หน่วยงาน / สังกัด</small>
                            <span class="fw-bold text-dark"><?= esc($borrow['borrower_org']) ?></span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">เบอร์โทรศัพท์</small>
                            <span class="fw-bold text-dark"><?= esc($borrow['borrower_tel']) ?></span>
                        </div>
                        <?php if (!empty($borrow['borrower_idcard'])): ?>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">เลขประจำตัวประชาชน</small>
                            <span class="fw-bold text-dark"><?= esc($borrow['borrower_idcard']) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">วันที่ยืม (เริ่มใช้)</small>
                            <span class="fw-bold text-success"><?= date('d/m/', strtotime($borrow['borrow_date'])) . (date('Y', strtotime($borrow['borrow_date'])) + 543) ?></span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">กำหนดวันที่ส่งคืน</small>
                            <span class="fw-bold text-danger"><?= date('d/m/', strtotime($borrow['due_date'])) . (date('Y', strtotime($borrow['due_date'])) + 543) ?></span>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">วัตถุประสงค์การใช้งาน</small>
                            <div class="p-3 bg-light rounded-3 mt-1"><?= nl2br(esc($borrow['purpose'])) ?></div>
                        </div>
                        <?php if (!empty($borrow['doc_ref_file'])): ?>
                        <div class="col-12">
                            <small class="text-muted d-block mb-2">📷 รูปภาพถ่ายประกอบคำขอยืม</small>
                            <div class="d-flex flex-wrap gap-2">
                                <?php 
                                $docImgs = explode(',', $borrow['doc_ref_file']);
                                foreach ($docImgs as $idx => $imgName):
                                    $imgName = trim($imgName);
                                    if (empty($imgName)) continue;
                                    $imgUrl = \App\Libraries\RemoteUploadService::getUrl($imgName, 'Equipment/docs');
                                ?>
                                    <a href="<?= $imgUrl ?>" target="_blank" class="d-inline-block shadow-sm rounded-3 overflow-hidden border" style="width: 80px; height: 80px;">
                                        <img src="<?= $imgUrl ?>" alt="Attached Photo <?= $idx + 1 ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2897/2897785.png'">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Table Items -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="fw-bold mb-0">รายการพัสดุที่ขอยืม</h5>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ลำดับ</th>
                                <th>พัสดุ</th>
                                <th>รหัสพัสดุ</th>
                                <th class="text-center">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($borrow['items'] as $item): ?>
                                <tr>
                                    <td class="ps-4"><?= $i++ ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['display_name'] ?? ($item['item_name'] ?? ($item['eq_name'] ?? '-'))) ?></div>
                                        <small class="text-muted"><?= esc($item['item_condition_before']) ?></small>
                                    </td>
                                    <td><span class="font-monospace text-muted"><?= esc($item['eq_code'] ?: '-') ?></span></td>
                                    <td class="text-center">
                                        <span class="badge bg-label-success fs-6 rounded-pill px-3">
                                            <?= $item['qty'] ?> <?= esc($item['display_unit'] ?? ($item['item_unit'] ?? ($item['eq_unit'] ?? 'ชิ้น'))) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- กล่องรูปถ่ายตอนยืมและตอนคืน -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bx bx-camera text-primary me-2"></i>รูปถ่ายผู้ยืมคู่กับพัสดุตอนส่งมอบ (จ่ายของ)</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($borrow['pickup_photo'])): ?>
                        <?php $pickupUrl = \App\Libraries\RemoteUploadService::getUrl($borrow['pickup_photo'], 'Equipment/pickup'); ?>
                        <div class="proof-box">
                            <a href="<?= $pickupUrl ?>" target="_blank">
                                <img src="<?= $pickupUrl ?>" class="proof-img" alt="Pickup Photo" onerror="this.src='<?= base_url('uploads/equipment/pickup/' . $borrow['pickup_photo']) ?>'">
                            </a>
                            <div class="text-start mt-3">
                                <small class="text-muted d-block">วันที่ส่งมอบ: <?= date('d/m/', strtotime($borrow['pickup_date'])) . (date('Y', strtotime($borrow['pickup_date'])) + 543) . ' ' . date('H:i', strtotime($borrow['pickup_date'])) ?> น.</small>
                                <small class="text-muted d-block">ผู้จ่ายของ: <?= esc($borrow['pickup_officer']) ?></small>
                                <?php if (!empty($borrow['pickup_remark'])): ?>
                                    <small class="text-dark d-block mt-1">หมายเหตุ: <?= esc($borrow['pickup_remark']) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="proof-box py-4 text-muted">
                            <i class="bx bx-image-alt fs-1"></i>
                            <p class="small mb-0 mt-2">ยังไม่มีการบันทึกภาพถ่ายตอนจ่ายของ</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent py-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bx bx-check-shield text-success me-2"></i>รูปถ่ายผู้คืนคู่กับสภาพพัสดุตอนรับคืน</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($borrow['return_photo'])): ?>
                        <?php $returnUrl = \App\Libraries\RemoteUploadService::getUrl($borrow['return_photo'], 'Equipment/return'); ?>
                        <div class="proof-box">
                            <a href="<?= $returnUrl ?>" target="_blank">
                                <img src="<?= $returnUrl ?>" class="proof-img" alt="Return Photo" onerror="this.src='<?= base_url('uploads/equipment/return/' . $borrow['return_photo']) ?>'">
                            </a>
                            <div class="text-start mt-3">
                                <small class="text-muted d-block">วันที่คืน: <?= date('d/m/', strtotime($borrow['return_date'])) . (date('Y', strtotime($borrow['return_date'])) + 543) . ' ' . date('H:i', strtotime($borrow['return_date'])) ?> น.</small>
                                <small class="text-muted d-block">ผู้รับคืน: <?= esc($borrow['return_officer']) ?></small>
                                <div class="mt-1">
                                    <small class="text-muted">สภาพพัสดุ: </small>
                                    <?php 
                                    if ($borrow['return_condition'] === 'normal') {
                                        echo '<span class="badge bg-success">สภาพปกติ</span>';
                                    } elseif ($borrow['return_condition'] === 'damaged') {
                                        echo '<span class="badge bg-warning">ชำรุดเสียหาย</span>';
                                    } else {
                                        echo '<span class="badge bg-danger">สูญหาย</span>';
                                    }
                                    ?>
                                </div>
                                <?php if (!empty($borrow['return_remark'])): ?>
                                    <small class="text-dark d-block mt-1">หมายเหตุ: <?= esc($borrow['return_remark']) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="proof-box py-4 text-muted">
                            <i class="bx bx-check-circle fs-1"></i>
                            <p class="small mb-0 mt-2">ยังไม่มีการบันทึกภาพถ่ายตอนรับคืน</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
