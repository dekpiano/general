<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .proof-img-box {
        border-radius: 1rem;
        overflow: hidden;
        border: 2px dashed #d9dee3;
        background: #f8f9fa;
        text-align: center;
        padding: 1rem;
        height: 100%;
    }
    .proof-img {
        max-height: 220px;
        width: 100%;
        object-fit: cover;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        cursor: pointer;
        transition: transform 0.25s ease;
    }
    .proof-img:hover {
        transform: scale(1.03);
    }
    /* Dropzone Area & Preview Grid (แบบเดียวกับหน้าขอยืม UserEquipmentAdd) */
    .dropzone-area {
        border: 2px dashed #d9dee3;
        border-radius: 1rem;
        background: #f8f9fa;
        padding: 1.8rem 1.2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .dropzone-area:hover, .dropzone-area.dragover {
        border-color: #696cff;
        background: #f4f5fb;
    }
    .upload-icon {
        font-size: 2.8rem;
        color: #696cff;
        margin-bottom: 0.4rem;
        display: block;
    }
    .upload-text {
        font-weight: 600;
        color: #566a7f;
        margin-bottom: 0.2rem;
    }
    .upload-hint {
        font-size: 0.8rem;
        color: #a1acb8;
    }
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: 10px;
        margin-top: 0.85rem;
    }
    .preview-item {
        position: relative;
        border-radius: 0.75rem;
        overflow: hidden;
        aspect-ratio: 1/1;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        border: 2px solid #fff;
    }
    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .preview-remove-btn {
        position: absolute;
        top: 3px;
        right: 3px;
        background: rgba(255, 62, 29, 0.85);
        color: white;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .preview-remove-btn:hover {
        background: #ff3e1d;
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
    
    // ตรวจสอบว่าเป็นเจ้าหน้าที่/ผู้ดูแลระบบที่เข้าสู่ระบบแล้วหรือไม่
    $isStaff = $isLoggedIn && (
        in_array($userStatus, ['superadmin', 'admin', 'AdminGeneral', 'ManagerGeneral', 'ExecutiveGeneral']) ||
        in_array('งานพัสดุและอุปกรณ์', $userRoles) ||
        !empty($session->get('is_admin'))
    );
?>

<div class="container-xxl flex-grow-1 container-p-y px-3 px-md-4">
    <!-- Header with Action Buttons (Mobile-First) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 fs-5 fs-md-4">
                <span class="text-muted fw-light">พัสดุอุปกรณ์ /</span> คำขอยืมเลขที่ <span class="text-primary font-monospace"><?= esc($borrow['borrow_code']) ?></span>
            </h4>
            <p class="text-muted mb-0 small">รายละเอียดคำขอยืม ข้อมูลพัสดุ และภาพถ่ายหลักฐาน</p>
        </div>

        <div class="d-flex flex-wrap gap-2 align-items-center w-100 w-md-auto">
            <!-- ปุ่มเข้าสู่ระบบสำหรับเจ้าหน้าที่ (เมื่อยังไม่ได้ Login) -->
            <?php if (!$isStaff): ?>
                <a href="<?= base_url('LoginOfficerGeneral?return_to=' . urlencode(current_url())) ?>" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm flex-fill flex-md-grow-0">
                    <i class="bi bi-box-arrow-in-right me-1"></i> เข้าสู่ระบบเจ้าหน้าที่
                </a>
            <?php endif; ?>

            <!-- ปุ่มดำเนินการของเจ้าหน้าที่ (เฉพาะผู้ที่ Login และมีสิทธิ์เท่านั้น) -->
            <?php if ($isStaff): ?>
                <?php if ($borrow['status'] === 'pending'): ?>
                    <button type="button" class="btn btn-success rounded-pill px-3 shadow-sm flex-fill flex-md-grow-0" onclick="approveBorrow(<?= $borrow['borrow_id'] ?>)">
                        <i class="bi bi-check-lg me-1"></i> อนุมัติคำขอนี้
                    </button>
                    <button type="button" class="btn btn-outline-danger rounded-pill px-3 flex-fill flex-md-grow-0" onclick="rejectBorrow(<?= $borrow['borrow_id'] ?>)">
                        <i class="bi bi-x-lg me-1"></i> ไม่อนุมัติ
                    </button>

                <?php elseif ($borrow['status'] === 'approved'): ?>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm flex-fill flex-md-grow-0" onclick="openPickupModal()">
                        <i class="bi bi-camera-fill me-1"></i> จ่ายของ / ส่งมอบ
                    </button>

                <?php elseif ($borrow['status'] === 'borrowed'): ?>
                    <button type="button" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm flex-fill flex-md-grow-0" onclick="openReturnModal()">
                        <i class="bi bi-shield-check me-1"></i> ตรวจรับคืน & ถ่ายภาพ
                    </button>
                <?php endif; ?>

                <!-- ปุ่มลบคำขอนี้ (เฉพาะเจ้าหน้าที่) -->
                <button type="button" class="btn btn-outline-danger rounded-pill px-3" onclick="deleteThisBorrow()" title="ลบคำขอนี้">
                    <i class="bi bi-trash3"></i>
                </button>
            <?php endif; ?>

            <!-- ปุ่มพิมพ์ใบยืม (สำหรับทุกคน) -->
            <a href="<?= base_url('Equipment/Print/' . $borrow['borrow_id']) ?>" target="_blank" class="btn btn-outline-primary rounded-pill px-3 flex-fill flex-md-grow-0">
                <i class="bi bi-printer me-1"></i> พิมพ์ใบยืม
            </a>

            <!-- ปุ่มกลับ -->
            <a href="<?= $isStaff ? base_url('Equipment/Approve') : base_url('Equipment/History') ?>" class="btn btn-outline-secondary rounded-pill px-3 flex-fill flex-md-grow-0">
                <i class="bi bi-arrow-left me-1"></i> กลับ
            </a>
        </div>
    </div>

    <div class="row g-3 g-md-4">
        <!-- ข้อมูลคำขอและสถานะ -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-3 mb-md-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                    <h5 class="fw-bold text-dark mb-0 fs-6 fs-md-5"><i class="bi bi-info-circle text-primary me-2"></i>ข้อมูลการขอยืม</h5>
                    <?php 
                    switch ($borrow['status']) {
                        case 'pending':
                            echo '<span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-clock me-1"></i> รอพิจารณาอนุมัติ</span>';
                            break;
                        case 'approved':
                            echo '<span class="badge bg-info px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> อนุมัติแล้ว (รอจ่ายของ)</span>';
                            break;
                        case 'borrowed':
                            echo '<span class="badge bg-primary px-3 py-2 rounded-pill"><i class="bi bi-box-seam me-1"></i> กำลังยืมใช้งาน</span>';
                            break;
                        case 'returned':
                            echo '<span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check2-all me-1"></i> คืนเรียบร้อยแล้ว</span>';
                            break;
                        case 'rejected':
                            echo '<span class="badge bg-danger px-3 py-2 rounded-pill"><i class="bi bi-x-lg me-1"></i> ไม่อนุมัติ</span>';
                            break;
                        case 'cancelled':
                            echo '<span class="badge bg-secondary px-3 py-2 rounded-pill"><i class="bi bi-slash-circle me-1"></i> ยกเลิกแล้ว</span>';
                            break;
                    }
                    ?>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">ชื่อผู้ขอยืม</small>
                            <span class="fw-bold text-dark fs-6"><?= esc($borrow['borrower_name']) ?></span>
                            <?php if ($borrow['borrower_type'] === 'external'): ?>
                                <span class="badge bg-label-info ms-1">บุคคลภายนอก</span>
                            <?php else: ?>
                                <span class="badge bg-label-success ms-1">บุคลากรภายใน</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">หน่วยงาน / สังกัด</small>
                            <span class="fw-bold text-dark"><?= esc($borrow['borrower_org']) ?></span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">เบอร์โทรศัพท์ติดต่อ</small>
                            <span class="fw-bold text-dark">
                                <a href="tel:<?= esc($borrow['borrower_tel']) ?>" class="text-decoration-none text-dark">
                                    <i class="bi bi-telephone-fill text-success me-1"></i><?= esc($borrow['borrower_tel']) ?>
                                </a>
                            </span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">วันที่ยื่นคำขอ</small>
                            <span class="text-dark"><?= date('d/m/', strtotime($borrow['created_at'])) . (date('Y', strtotime($borrow['created_at'])) + 543) . ' ' . date('H:i', strtotime($borrow['created_at'])) ?> น.</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">วันที่ขอยืม (เริ่มใช้)</small>
                            <span class="fw-bold text-success"><i class="bi bi-calendar-event me-1"></i> <?= date('d/m/', strtotime($borrow['borrow_date'])) . (date('Y', strtotime($borrow['borrow_date'])) + 543) ?></span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">กำหนดวันที่ส่งคืน</small>
                            <span class="fw-bold text-danger"><i class="bi bi-calendar-check me-1"></i> <?= date('d/m/', strtotime($borrow['due_date'])) . (date('Y', strtotime($borrow['due_date'])) + 543) ?></span>
                        </div>
                        <div class="col-12">
                            <small class="text-muted d-block">วัตถุประสงค์การใช้งาน</small>
                            <div class="p-3 bg-light rounded-3 mt-1 text-dark fw-medium"><?= nl2br(esc($borrow['purpose'])) ?></div>
                        </div>
                        <?php if (!empty($borrow['location'])): ?>
                        <div class="col-12">
                            <small class="text-muted d-block">สถานที่นำไปใช้งาน</small>
                            <span class="text-dark"><?= esc($borrow['location']) ?></span>
                        </div>
                        <?php endif; ?>

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
                                        <img src="<?= $imgUrl ?>" alt="Doc Photo <?= $idx + 1 ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2897/2897785.png'">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($borrow['status'] === 'rejected' && !empty($borrow['reject_reason'])): ?>
                        <div class="col-12">
                            <div class="alert alert-danger rounded-3 mb-0">
                                <strong><i class="bi bi-exclamation-triangle me-1"></i> เหตุผลที่ไม่อนุมัติ:</strong>
                                <p class="mb-0 mt-1"><?= esc($borrow['reject_reason']) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Items Section (Mobile Cards + Desktop Table) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="fw-bold mb-0 fs-6 fs-md-5"><i class="bi bi-boxes text-primary me-2"></i>รายการพัสดุอุปกรณ์ที่ขอยืม</h5>
                </div>
                
                <!-- Mobile List (d-block d-md-none) -->
                <div class="d-block d-md-none p-3 pt-0">
                    <?php $i = 1; foreach ($borrow['items'] as $item): ?>
                        <div class="p-3 bg-light rounded-3 mb-2 border">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="badge bg-primary rounded-circle" style="width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center;"><?= $i++ ?></span>
                                <span class="badge bg-label-success fs-6 rounded-pill px-3">
                                    <?= $item['qty'] ?> <?= esc($item['display_unit'] ?? ($item['item_unit'] ?? ($item['eq_unit'] ?? 'ชิ้น'))) ?>
                                </span>
                            </div>
                            <div class="fw-bold text-dark mt-1"><?= esc($item['display_name'] ?? ($item['item_name'] ?? ($item['eq_name'] ?? '-'))) ?></div>
                            <?php if (!empty($item['eq_brand_model'])): ?>
                                <small class="text-muted d-block"><?= esc($item['eq_brand_model']) ?></small>
                            <?php endif; ?>
                            <?php if (!empty($item['eq_code'])): ?>
                                <small class="text-muted font-monospace d-block mt-1"><i class="bi bi-tag me-1"></i>รหัส: <?= esc($item['eq_code']) ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Desktop Table (d-none d-md-block) -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 60px;">#</th>
                                <th>ชื่อพัสดุ / อุปกรณ์</th>
                                <th>รหัสพัสดุ</th>
                                <th class="text-center">จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($borrow['items'] as $item): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted"><?= $i++ ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= esc($item['display_name'] ?? ($item['item_name'] ?? ($item['eq_name'] ?? '-'))) ?></div>
                                        <?php if (!empty($item['eq_brand_model'])): ?>
                                            <small class="text-muted"><?= esc($item['eq_brand_model']) ?></small>
                                        <?php endif; ?>
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

        <!-- กล่องภาพถ่ายหลักฐาน (ตอนจ่ายของ & ตอนคืน) -->
        <div class="col-lg-4">
            <!-- 1. ภาพถ่ายตอนส่งมอบ (จ่ายของ) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-camera-fill text-primary me-2"></i>หลักฐานตอนส่งมอบพัสดุ</h6>
                    <?php if ($isStaff && $borrow['status'] === 'approved'): ?>
                        <button class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2" onclick="openPickupModal()">บันทึกภาพ</button>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (!empty($borrow['pickup_photo'])): ?>
                        <?php 
                        $pickupList = array_filter(explode(',', $borrow['pickup_photo']));
                        $firstPickup = reset($pickupList);
                        $firstPickupUrl = \App\Libraries\RemoteUploadService::getUrl($firstPickup, 'Equipment/docs');
                        ?>
                        <div class="proof-img-box">
                            <a href="<?= $firstPickupUrl ?>" target="_blank">
                                <img src="<?= $firstPickupUrl ?>" class="proof-img mb-2" alt="Pickup Photo" onerror="this.src='<?= base_url('uploads/equipment/pickup/' . $firstPickup) ?>'">
                            </a>

                            <?php if (count($pickupList) > 1): ?>
                            <div class="d-flex flex-wrap gap-2 justify-content-center mb-2">
                                <?php foreach ($pickupList as $pIdx => $pImg): 
                                    $pUrl = \App\Libraries\RemoteUploadService::getUrl($pImg, 'Equipment/docs');
                                ?>
                                    <a href="<?= $pUrl ?>" target="_blank" class="border rounded-2 overflow-hidden shadow-sm d-inline-block" style="width: 50px; height: 50px;">
                                        <img src="<?= $pUrl ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Pickup <?= $pIdx+1 ?>">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <div class="text-start mt-3">
                                <small class="text-muted d-block">วันที่ส่งมอบ: <?= date('d/m/', strtotime($borrow['pickup_date'])) . (date('Y', strtotime($borrow['pickup_date'])) + 543) . ' ' . date('H:i', strtotime($borrow['pickup_date'])) ?> น.</small>
                                <small class="text-muted d-block">ผู้ส่งมอบ: <?= esc($borrow['pickup_officer']) ?></small>
                                <?php if (!empty($borrow['pickup_remark'])): ?>
                                    <small class="text-dark d-block mt-1">หมายเหตุ: <?= esc($borrow['pickup_remark']) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="proof-img-box py-4 text-muted">
                            <i class="bi bi-image fs-1 text-muted"></i>
                            <p class="small mb-0 mt-2">ยังไม่มีการบันทึกภาพถ่ายตอนส่งมอบ</p>
                            <?php if ($isStaff && $borrow['status'] === 'approved'): ?>
                                <button class="btn btn-sm btn-primary rounded-pill mt-3 px-3" onclick="openPickupModal()">
                                    <i class="bi bi-camera me-1"></i> จ่ายของ & ถ่ายภาพ
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 2. ภาพถ่ายตอนตรวจรับคืน -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-shield-check text-success me-2"></i>หลักฐานตอนตรวจรับคืน</h6>
                    <?php if ($isStaff && $borrow['status'] === 'borrowed'): ?>
                        <button class="btn btn-sm btn-outline-warning rounded-pill py-0 px-2 text-dark" onclick="openReturnModal()">บันทึกรับคืน</button>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (!empty($borrow['return_photo'])): ?>
                        <?php 
                        $returnList = array_filter(explode(',', $borrow['return_photo']));
                        $firstReturn = reset($returnList);
                        $firstReturnUrl = \App\Libraries\RemoteUploadService::getUrl($firstReturn, 'Equipment/docs');
                        ?>
                        <div class="proof-img-box">
                            <a href="<?= $firstReturnUrl ?>" target="_blank">
                                <img src="<?= $firstReturnUrl ?>" class="proof-img mb-2" alt="Return Photo" onerror="this.src='<?= base_url('uploads/equipment/return/' . $firstReturn) ?>'">
                            </a>

                            <?php if (count($returnList) > 1): ?>
                            <div class="d-flex flex-wrap gap-2 justify-content-center mb-2">
                                <?php foreach ($returnList as $rIdx => $rImg): 
                                    $rUrl = \App\Libraries\RemoteUploadService::getUrl($rImg, 'Equipment/docs');
                                ?>
                                    <a href="<?= $rUrl ?>" target="_blank" class="border rounded-2 overflow-hidden shadow-sm d-inline-block" style="width: 50px; height: 50px;">
                                        <img src="<?= $rUrl ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Return <?= $rIdx+1 ?>">
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

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
                        <div class="proof-img-box py-4 text-muted">
                            <i class="bi bi-shield-check fs-1 text-muted"></i>
                            <p class="small mb-0 mt-2">ยังไม่มีการบันทึกภาพถ่ายตอนรับคืน</p>
                            <?php if ($isStaff && $borrow['status'] === 'borrowed'): ?>
                                <button class="btn btn-sm btn-warning text-dark fw-bold rounded-pill mt-3 px-3" onclick="openReturnModal()">
                                    <i class="bi bi-camera me-1"></i> รับคืน & ถ่ายภาพ
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($isStaff): ?>
<!-- ========================================== -->
<!-- MODAL 1: ส่งมอบพัสดุ (Pickup Modal) แบบเดียวกับหน้าขอยืม -->
<!-- ========================================== -->
<div class="modal fade" id="modalPickup" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-primary text-white py-3 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-camera-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0">บันทึกการส่งมอบ / จ่ายพัสดุอุปกรณ์</h5>
                        <small class="text-white-50">ถ่ายภาพผู้ยืมคู่กับพัสดุเพื่อเป็นหลักฐาน</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formPickup" enctype="multipart/form-data">
                <input type="hidden" name="borrow_id" value="<?= $borrow['borrow_id'] ?>">
                <?= csrf_field() ?>

                <div class="modal-body p-4">
                    <!-- Dropzone Area แบบเดียวกับ UserEquipmentAdd -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold mb-0 text-dark">
                                <i class="bi bi-camera me-1 text-primary"></i> แนบรูปถ่ายผู้ยืมคู่กับพัสดุ (สูงสุด 5 รูป) <span class="text-danger">*</span>
                            </label>
                            <span class="badge bg-label-primary rounded-pill" id="pickupPhotoCountBadge">0 / 5 รูป</span>
                        </div>

                        <div class="dropzone-area" id="pickupDropzone">
                            <i class="bx bx-cloud-upload upload-icon"></i>
                            <div class="upload-text">คลิกเพื่อเลือกไฟล์ / ถ่ายภาพ หรือลากไฟล์มาวางที่นี่</div>
                            <div class="upload-hint">รองรับไฟล์ภาพ JPG, PNG, JPEG, WEBP (สูงสุด 5 รูป)</div>
                            <input type="file" name="pickup_photo[]" id="pickup_photo" class="d-none" accept="image/*" multiple>
                        </div>
                        
                        <!-- Multi-Image Preview Grid -->
                        <div id="pickupPreviewGrid" class="preview-grid d-none"></div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">เจ้าหน้าที่ผู้จ่ายของ / ส่งมอบ</label>
                            <input type="text" name="pickup_officer" class="form-control rounded-3" value="<?= esc(session()->get('fullname') ?? 'เจ้าหน้าที่งานพัสดุ') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">วันเวลาที่ส่งมอบ</label>
                            <input type="text" name="pickup_date" class="form-control rounded-3" value="<?= date('Y-m-d H:i:s') ?>" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">หมายเหตุการส่งมอบ (ถ้ามี)</label>
                            <input type="text" name="pickup_remark" class="form-control rounded-3" placeholder="เช่น ส่งมอบพร้อมอุปกรณ์ต่อพ่วงครบชุด">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light py-3 px-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm" id="btnSubmitPickup">
                        <span class="btn-text"><i class="bi bi-check-circle me-1"></i> ยืนยันการส่งมอบ</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-2"></span>กำลังอัปโหลด...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL 2: ตรวจรับคืนพัสดุ (Return Modal) แบบเดียวกับหน้าขอยืม -->
<!-- ========================================== -->
<div class="modal fade" id="modalReturn" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 bg-warning text-dark py-3 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar bg-white text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-dark">บันทึกการตรวจรับคืนพัสดุอุปกรณ์</h5>
                        <small class="text-dark opacity-75">ถ่ายภาพผู้คืนและสภาพพัสดุเพื่อเป็นหลักฐาน</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formReturn" enctype="multipart/form-data">
                <input type="hidden" name="borrow_id" value="<?= $borrow['borrow_id'] ?>">
                <?= csrf_field() ?>

                <div class="modal-body p-4">
                    <!-- Dropzone Area แบบเดียวกับ UserEquipmentAdd -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold mb-0 text-dark">
                                <i class="bi bi-camera me-1 text-warning"></i> แนบรูปถ่ายผู้คืนและสภาพพัสดุ (สูงสุด 5 รูป) <span class="text-danger">*</span>
                            </label>
                            <span class="badge bg-label-warning text-dark rounded-pill" id="returnPhotoCountBadge">0 / 5 รูป</span>
                        </div>

                        <div class="dropzone-area" id="returnDropzone">
                            <i class="bx bx-cloud-upload upload-icon text-warning"></i>
                            <div class="upload-text">คลิกเพื่อเลือกไฟล์ / ถ่ายภาพ หรือลากไฟล์มาวางที่นี่</div>
                            <div class="upload-hint">รองรับไฟล์ภาพ JPG, PNG, JPEG, WEBP (สูงสุด 5 รูป)</div>
                            <input type="file" name="return_photo[]" id="return_photo" class="d-none" accept="image/*" multiple>
                        </div>
                        
                        <!-- Multi-Image Preview Grid -->
                        <div id="returnPreviewGrid" class="preview-grid d-none"></div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">สภาพพัสดุอุปกรณ์ที่ตรวจรับคืน</label>
                            <select name="return_condition" class="form-select rounded-3" required>
                                <option value="normal">✅ สภาพปกติ สมบูรณ์ครบถ้วน</option>
                                <option value="damaged">⚠️ ชำรุด / เสียหายบางส่วน</option>
                                <option value="lost">❌ สูญหาย / ไม่ครบจำนวน</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-dark">เจ้าหน้าที่ผู้รับคืน</label>
                            <input type="text" name="return_officer" class="form-control rounded-3" value="<?= esc(session()->get('fullname') ?? 'เจ้าหน้าที่งานพัสดุ') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-dark">หมายเหตุการตรวจรับคืน (ถ้ามี)</label>
                            <input type="text" name="return_remark" class="form-control rounded-3" placeholder="เช่น ตรวจสอบสายไฟและรีโมทครบถ้วน">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light py-3 px-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-5 shadow-sm" id="btnSubmitReturn">
                        <span class="btn-text"><i class="bi bi-check-circle me-1"></i> ยืนยันการตรวจรับคืน</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-2"></span>กำลังอัปโหลด...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<?php if ($isStaff): ?>
<script>
    let pickupSelectedFiles = [];
    let returnSelectedFiles = [];
    let modalPickupInstance = null;
    let modalReturnInstance = null;

    document.addEventListener('DOMContentLoaded', function() {
        initDropzoneEngine('pickupDropzone', 'pickup_photo', pickupSelectedFiles, syncPickupRender);
        initDropzoneEngine('returnDropzone', 'return_photo', returnSelectedFiles, syncReturnRender);
    });

    // เครื่องมือจัดการ Dropzone แบบเดียวกับ UserEquipmentAdd เป๊ะๆ
    function initDropzoneEngine(zoneId, inputId, filesArray, syncCallback) {
        const dropzone = document.getElementById(zoneId);
        const input = document.getElementById(inputId);
        if (!dropzone || !input) return;

        dropzone.addEventListener('click', (e) => {
            if (e.target !== input) {
                input.click();
            }
        });

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            if (e.dataTransfer.files.length > 0) {
                handleIncomingFiles(Array.from(e.dataTransfer.files), filesArray, syncCallback);
            }
        });

        input.addEventListener('change', function() {
            handleIncomingFiles(Array.from(this.files), filesArray, syncCallback);
            this.value = ''; // Reset to allow selecting the same file again
        });
    }

    function handleIncomingFiles(newFiles, filesArray, syncCallback) {
        const validImages = newFiles.filter(f => f.type.startsWith('image/'));
        if (validImages.length < newFiles.length) {
            Swal.fire('แจ้งเตือน', 'ระบบรองรับเฉพาะไฟล์รูปภาพเท่านั้น (JPG, PNG, JPEG, WEBP)', 'warning');
        }

        if (filesArray.length + validImages.length > 5) {
            Swal.fire('แจ้งเตือน', 'คุณสามารถเพิ่มรูปภาพได้สูงสุด 5 รูปเท่านั้น', 'warning');
        }

        validImages.forEach(file => {
            if (filesArray.length < 5) {
                filesArray.push(file);
            }
        });

        syncCallback();
    }

    // 1. Pickup Sync
    function syncPickupRender() {
        const input = document.getElementById('pickup_photo');
        const badge = document.getElementById('pickupPhotoCountBadge');
        const grid = document.getElementById('pickupPreviewGrid');

        const dt = new DataTransfer();
        pickupSelectedFiles.forEach(f => dt.items.add(f));
        if (input) input.files = dt.files;

        if (badge) badge.textContent = `${pickupSelectedFiles.length} / 5 รูป`;
        if (!grid) return;

        grid.innerHTML = '';
        if (pickupSelectedFiles.length === 0) {
            grid.classList.add('d-none');
            return;
        }

        grid.classList.remove('d-none');
        pickupSelectedFiles.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'preview-item';
                itemDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Pickup Preview ${idx + 1}">
                    <button type="button" class="preview-remove-btn" onclick="removePickupAt(${idx})" title="ลบรูปนี้">
                        <i class="bx bx-x"></i>
                    </button>
                `;
                grid.appendChild(itemDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    function removePickupAt(idx) {
        pickupSelectedFiles.splice(idx, 1);
        syncPickupRender();
    }

    // 2. Return Sync
    function syncReturnRender() {
        const input = document.getElementById('return_photo');
        const badge = document.getElementById('returnPhotoCountBadge');
        const grid = document.getElementById('returnPreviewGrid');

        const dt = new DataTransfer();
        returnSelectedFiles.forEach(f => dt.items.add(f));
        if (input) input.files = dt.files;

        if (badge) badge.textContent = `${returnSelectedFiles.length} / 5 รูป`;
        if (!grid) return;

        grid.innerHTML = '';
        if (returnSelectedFiles.length === 0) {
            grid.classList.add('d-none');
            return;
        }

        grid.classList.remove('d-none');
        returnSelectedFiles.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'preview-item';
                itemDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Return Preview ${idx + 1}">
                    <button type="button" class="preview-remove-btn" onclick="removeReturnAt(${idx})" title="ลบรูปนี้">
                        <i class="bx bx-x"></i>
                    </button>
                `;
                grid.appendChild(itemDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeReturnAt(idx) {
        returnSelectedFiles.splice(idx, 1);
        syncReturnRender();
    }

    // Open Modals
    function openPickupModal() {
        pickupSelectedFiles.length = 0;
        syncPickupRender();
        if (!modalPickupInstance) {
            modalPickupInstance = new bootstrap.Modal(document.getElementById('modalPickup'));
        }
        modalPickupInstance.show();
    }

    function openReturnModal() {
        returnSelectedFiles.length = 0;
        syncReturnRender();
        if (!modalReturnInstance) {
            modalReturnInstance = new bootstrap.Modal(document.getElementById('modalReturn'));
        }
        modalReturnInstance.show();
    }

    // อนุมัติคำขอ
    function approveBorrow(borrowId) {
        Swal.fire({
            title: 'ยืนยันการอนุมัติคำขอ?',
            text: 'เมื่ออนุมัติแล้ว ผู้ยืมจะสามารถติดต่อรับพัสดุอุปกรณ์ได้',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> ใช่, อนุมัติคำขอ',
            confirmButtonColor: '#696cff',
            cancelButtonText: 'ยกเลิก',
            cancelButtonColor: '#8592a3',
            customClass: {
                confirmButton: 'btn btn-primary rounded-pill px-4',
                cancelButton: 'btn btn-outline-secondary rounded-pill px-4 ms-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'กำลังดำเนินการ...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
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
                });
            }
        });
    }

    // ไม่อนุมัติคำขอ
    function rejectBorrow(borrowId) {
        Swal.fire({
            title: 'ระบุเหตุผลที่ไม่อนุมัติ',
            input: 'textarea',
            inputPlaceholder: 'เช่น พัสดุถูกจองเต็มแล้ว หรืออยู่นอกช่วงเวลาให้บริการ...',
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
                if (!value || !value.trim()) return 'กรุณาระบุเหตุผลที่ไม่อนุมัติ';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'กำลังดำเนินการ...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                fetch('<?= base_url('Admin/Equipment/rejectBorrow') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'borrow_id=' + borrowId + '&reject_reason=' + encodeURIComponent(result.value) + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'บันทึกสำเร็จ',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#696cff',
                            customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
                            buttonsStyling: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                    }
                });
            }
        });
    }

    // ลบคำขอยืมนี้ถาวร
    function deleteThisBorrow() {
        Swal.fire({
            title: 'ยืนยันลบคำขอนี้?',
            text: 'ข้อมูลคำขอ รายการพัสดุ และไฟล์รูปภาพหลักฐานทั้งหมดจะถูกลบออกจากระบบอย่างถาวร',
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
                Swal.fire({ title: 'กำลังลบข้อมูลและรูปภาพ...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                fetch('<?= base_url('Admin/Equipment/deleteBorrow') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'borrow_id=<?= $borrow['borrow_id'] ?>&<?= csrf_token() ?>=<?= csrf_hash() ?>'
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
                        }).then(() => {
                            window.location.href = '<?= base_url('Equipment/Approve') ?>';
                        });
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                    }
                });
            }
        });
    }

    // ฟังก์ชันย่อขนาดภาพแบบเดียวกับ Food Report
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
                    const max_size = 1280;

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
                        let safeName = file.name.split('.').slice(0, -1).join('.')
                            .replace(/[^\w-]/g, "_")
                            .replace(/_+/g, "_")
                            .trim();
                        safeName = (safeName || 'image') + '.jpg';

                        resolve(new File([blob], safeName, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        }));
                    }, 'image/jpeg', 0.7);
                };
            };
        });
    }

    // Submit Pickup Form
    document.getElementById('formPickup').addEventListener('submit', async function(e) {
        e.preventDefault();
        if (pickupSelectedFiles.length === 0) {
            Swal.fire('แจ้งเตือน', 'กรุณาถ่ายภาพหรือแนบรูปภาพผู้ยืมคู่กับพัสดุอย่างน้อย 1 รูป', 'warning');
            return;
        }

        const submitBtn = document.getElementById('btnSubmitPickup');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        submitBtn.disabled = true;
        if (btnText) btnText.classList.add('d-none');
        if (btnLoading) btnLoading.classList.remove('d-none');

        const formData = new FormData(this);
        formData.delete('pickup_photo[]');
        
        for (let i = 0; i < pickupSelectedFiles.length; i++) {
            const file = pickupSelectedFiles[i];
            if (btnLoading) btnLoading.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>กำลังย่อรูป ${i + 1}/${pickupSelectedFiles.length}...`;
            
            if (file.type.startsWith('image/')) {
                const compressed = await compressImage(file);
                formData.append('pickup_photo[]', compressed);
            } else {
                formData.append('pickup_photo[]', file);
            }
        }
        
        if (btnLoading) btnLoading.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>กำลังบันทึกข้อมูล...`;

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

    // Submit Return Form
    document.getElementById('formReturn').addEventListener('submit', async function(e) {
        e.preventDefault();
        if (returnSelectedFiles.length === 0) {
            Swal.fire('แจ้งเตือน', 'กรุณาถ่ายภาพหรือแนบรูปภาพสภาพพัสดุตอนส่งคืนอย่างน้อย 1 รูป', 'warning');
            return;
        }

        const submitBtn = document.getElementById('btnSubmitReturn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        submitBtn.disabled = true;
        if (btnText) btnText.classList.add('d-none');
        if (btnLoading) btnLoading.classList.remove('d-none');

        const formData = new FormData(this);
        formData.delete('return_photo[]');
        
        for (let i = 0; i < returnSelectedFiles.length; i++) {
            const file = returnSelectedFiles[i];
            if (btnLoading) btnLoading.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>กำลังย่อรูป ${i + 1}/${returnSelectedFiles.length}...`;
            
            if (file.type.startsWith('image/')) {
                const compressed = await compressImage(file);
                formData.append('return_photo[]', compressed);
            } else {
                formData.append('return_photo[]', file);
            }
        }
        
        if (btnLoading) btnLoading.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>กำลังบันทึกข้อมูล...`;

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
</script>
<?php endif; ?>
<?= $this->endSection() ?>
