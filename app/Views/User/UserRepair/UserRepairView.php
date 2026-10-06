<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<?php
// ประกาศตัวแปรสิทธิ์การใช้งาน
$checkRloes = explode(",", @$_SESSION['rloes']);
$isAdmin = (!empty($_SESSION['username']) && (in_array("งานแจ้งซ่อม", $checkRloes) || in_array("งานอาคารสถานที่", $checkRloes) || @$_SESSION['status'] == 'AdminGeneral' || @$_SESSION['status'] == 'superadmin'));

// ตรวจสอบว่าใบงานนี้มาจากระบบ IT Support API หรือไม่
$isITSupport = (strpos($Order[0]->repair_cause ?? '', 'IT Support') !== false || preg_match('/\[IT-\d{6}-\d{4}\]/', $Order[0]->repair_detail ?? ''));
$itTicketCode = null;
if (preg_match('/\[(IT-\d{6}-\d{4})\]/', $Order[0]->repair_detail ?? '', $m)) {
    $itTicketCode = $m[1];
} elseif (preg_match('/(IT-\d{6}-\d{4})/', $Order[0]->repair_cause ?? '', $m)) {
    $itTicketCode = $m[1];
}

// จัดการข้อความรายละเอียดงาน
$displayDetail = $Order[0]->repair_detail ?? '-';
if ($isITSupport && $itTicketCode) {
    $displayDetail = trim(str_replace("[$itTicketCode]", '', $displayDetail));
}

// จัดการสถานที่ให้สวยงาม (ซ่อน ชั้น/ห้อง หากไม่มีข้อมูล)
$locParts = [];
if (!empty($Order[0]->repair_building))
    $locParts[] = $Order[0]->repair_building;
if (!empty($Order[0]->repair_class))
    $locParts[] = 'ชั้น ' . $Order[0]->repair_class;
if (!empty($Order[0]->repair_room))
    $locParts[] = 'ห้อง ' . $Order[0]->repair_room;
$fullLocation = !empty($locParts) ? implode(' ', $locParts) : '-';

// ฟังก์ชันแยกรูปภาพรองรับทั้ง JSON Array URL และ Comma-separated
$parseImages = function ($raw) {
    if (empty($raw))
        return [];
    $raw = trim($raw);
    if (strpos($raw, '[') === 0) {
        $json = json_decode($raw, true);
        if (is_array($json)) {
            return array_values(array_filter(array_map('trim', $json)));
        }
    }
    return array_values(array_filter(array_map('trim', explode(',', $raw))));
};

$userImages = $parseImages($Order[0]->repair_imguser ?? '');
// สำหรับข้อมูลที่ดึงมาจาก IT Support API รูปภาพทั้งหมดเป็นภาพประกอบงาน (ภาพการดำเนินงานต้องไม่มี)
$workImages = $isITSupport ? [] : $parseImages($Order[0]->repair_imgwork ?? '');

// จัดการชื่อช่างผู้ดำเนินการ / ผู้รับเรื่อง ให้เป็นชื่อ-นามสกุลจริงเสมอ ไม่แสดงเป็น ID
$repairmanFullName = !empty($RepairmanName) ? $RepairmanName : ($Order[1]->Repairman ?? ($Order[0]->repair_RepairmanFullName ?? ''));
if (empty($repairmanFullName) || $repairmanFullName === '0000' || is_numeric($repairmanFullName)) {
    $rawMan = $Order[0]->repair_Repairman ?? '';
    if (empty($rawMan) || $rawMan === '0000' || is_numeric($rawMan)) {
        $repairmanFullName = $isITSupport ? 'ผู้ดูแลระบบ IT Support' : 'เจ้าหน้าที่ปฏิบัติงาน';
    } else {
        $repairmanFullName = $rawMan;
    }
}
?>

<style>
    /* SweetAlert2 Always on Top */
    .swal2-container {
        z-index: 9999999 !important;
    }

    .swal2-popup {
        z-index: 10000000 !important;
    }

    .swal2-backdrop-show {
        z-index: 9999999 !important;
    }

    /* Star Rating CSS - Mobile Friendly */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 15px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 2.5rem;
        color: #e9ecef;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        padding: 5px;
    }

    .star-rating label:active {
        transform: scale(1.2);
    }

    .star-rating label:hover,
    .star-rating label:hover~label,
    .star-rating input:checked~label {
        color: #ffc107;
    }

    .star-rating label:hover:before,
    .star-rating label:hover~label:before,
    .star-rating input:checked~label:before {
        content: "\ea83";
        font-family: 'boxicons';
    }

    .star-display {
        color: #ffc107;
        letter-spacing: 2px;
    }

    /* Premium Card & Integration Badges */
    .it-origin-card {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #1e1b4b 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.25rem;
        color: #ffffff;
        box-shadow: 0 15px 35px -10px rgba(49, 46, 129, 0.45);
        position: relative;
        overflow: hidden;
    }

    .it-origin-card::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .it-info-chip {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 0.85rem;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }

    .it-info-chip:hover {
        background: rgba(255, 255, 255, 0.18);
        transform: translateY(-2px);
    }

    .gallery-card {
        border-radius: 1rem;
        overflow: hidden;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .gallery-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.12);
        border-color: #6366f1;
    }

    .gallery-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .gallery-card:hover img {
        transform: scale(1.05);
    }

    .gallery-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(15, 23, 42, 0.75);
        color: #ffffff;
        backdrop-filter: blur(6px);
        font-size: 0.75rem;
        padding: 3px 8px;
        border-radius: 6px;
        font-weight: 600;
    }

    @media (max-width: 576px) {
        .star-rating label {
            font-size: 2.2rem;
            gap: 10px;
        }

        .gallery-card img {
            height: 160px;
        }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header Navigation -->
    <div class="row mb-4">
        <div class="col-12 <?php if ($isAdmin) {
            echo "col-md-8";
        } ?>">
            <div class="card bg-label-primary border-0 text-white overflow-hidden wave-bg">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-0 text-primary d-flex align-items-center gap-2">
                                <i class="bx bx-file"></i> รายละเอียดการแจ้งซ่อม
                                <?php if ($isITSupport): ?>
                                    <span class="badge bg-indigo text-white fw-bold px-2.5 py-1"
                                        style="background-color: #4f46e5; font-size: 0.75rem;">
                                        <i class="bx bx-sync me-1"></i> IT Support API
                                    </span>
                                <?php endif; ?>
                            </h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-style1 mb-0 mt-2">
                                    <li class="breadcrumb-item">
                                        <a href="<?= base_url('Repair') ?>" class="text-primary">งานแจ้งซ่อม</a>
                                    </li>
                                    <li class="breadcrumb-item active text-muted"><?= $Order[0]->repair_order ?></li>
                                    <?php if ($itTicketCode): ?>
                                        <li class="breadcrumb-item text-indigo fw-bold" style="color: #4f46e5;">
                                            (<?= $itTicketCode ?>)</li>
                                    <?php endif; ?>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <?php if ($Order[0]->repair_caselist === 'งานอาคารสถานที่' && session()->get('id') == $Order[0]->repair_userID): ?>
                                <a href="<?= base_url('Repair/BuildingMemo?order=') . $Order[0]->repair_order ?>"
                                    class="btn btn-outline-warning shadow-sm fw-bold btn-sm">
                                    <i class="bx bx-file me-1"></i> บันทึกข้อความ
                                </a>
                            <?php endif; ?>

                            <a href="<?= base_url('Repair/PrintOrder/') . $Order[0]->repair_order ?>" target="_blank"
                                class="btn btn-primary shadow-sm fw-bold PrintOrder btn-sm">
                                <i class="bx bx-printer me-1"></i> พิมพ์
                            </a>

                            <button type="button" class="btn btn-outline-danger shadow-sm fw-bold btn-sm"
                                id="BtnDeleteOrder" data-order="<?= $Order[0]->repair_order ?>">
                                <i class="bx bx-trash me-1"></i> ลบข้อมูล
                            </button>

                            <?php if (!$isAdmin): ?>
                                <button type="button" class="btn btn-dark shadow-sm fw-bold btn-sm" id="BtnStaffLogin">
                                    <i class="bx bx-shield-quarter me-1"></i> เจ้าหน้าที่รับงาน
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Control Panel (Horizontal Bar) -->
        <?php if ($isAdmin): ?>
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm bg-label-warning overflow-hidden h-100">
                    <div class="card-body py-2 px-3 d-flex flex-column justify-content-center">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div class="d-flex align-items-center text-warning">
                                <i class="bx bx-shield-quarter fs-4 me-2"></i>
                                <span class="fw-bold">แผงควบคุมเจ้าหน้าที่:</span>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-warning btn-sm fw-bold px-3 shadow-sm"
                                    id="ModalFormAdmin">
                                    <i class="bx bx-wrench me-1"></i> รับงาน/บันทึกการซ่อม
                                </button>

                                <?php if (!empty($MemoData)): ?>
                                    <a href="<?= base_url('Repair/BuildingMemo/Print?order=') . $Order[0]->repair_order ?>"
                                        target="_blank" class="btn btn-outline-primary btn-sm fw-bold px-3">
                                        <i class="bx bx-file me-1"></i> บันทึกข้อความ
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($isITSupport): ?>
        <!-- ========================================== -->
        <!-- SPECIAL BANNER: IT SUPPORT API INTEGRATION -->
        <!-- ========================================== -->
        <div class="it-origin-card p-4 mb-4">
            <div
                class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3 pb-3 border-bottom border-white border-opacity-20">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-12 h-12 rounded-xl d-flex align-items-center justify-content-center text-white shadow-lg"
                        style="width: 48px; height: 48px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 12px;">
                        <i class="bx bx-cloud-download fs-2"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="mb-0 fw-bold text-white">ข้อมูลเชื่อมโยงจากระบบ IT Support</h5>
                            <span
                                class="badge bg-success bg-opacity-25 text-emerald-300 border border-success border-opacity-50 px-2 py-0.5"
                                style="color: #000000ff; font-size: 0.72rem;">
                                <i class="bx bx-check-double me-1"></i>ซิงค์สมบูรณ์
                            </span>
                        </div>
                        <p class="mb-0 text-indigo-200 small" style="color: #c7d2fe;">ระบบบริหารจัดการกองการศึกษา ศาสนา
                            และวัฒนธรรม อบจ.นครสวรรค์ (PAO-Erc)</p>
                    </div>
                </div>
                <div>
                    <a href="https://localhost:9443/itsupport" target="_blank"
                        class="btn btn-sm btn-light fw-bold px-3 text-indigo-950 shadow-sm"
                        style="color: #1e1b4b; border-radius: 8px;">
                        <i class="bx bx-link-external me-1 text-primary"></i> เปิดดูระบบ IT Support
                    </a>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-sm-6 col-lg-3">
                    <div class="it-info-chip h-100">
                        <small class="d-block text-indigo-200 mb-1" style="color: #c7d2fe;"><i
                                class="bx bx-purchase-tag-alt me-1"></i>รหัส Ticket Code ต้นทาง</small>
                        <div class="fw-bold font-monospace fs-5 text-warning"><?= $itTicketCode ?: '-' ?></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="it-info-chip h-100">
                        <small class="d-block text-indigo-200 mb-1" style="color: #c7d2fe;"><i
                                class="bx bx-category me-1"></i>หมวดหมู่งาน IT</small>
                        <div class="fw-bold text-white text-truncate">
                            <?= $Order[0]->repair_caselist ?: 'ระบบคอมพิวเตอร์/เครือข่าย' ?></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="it-info-chip h-100">
                        <small class="d-block text-indigo-200 mb-1" style="color: #c7d2fe;"><i
                                class="bx bx-user-pin me-1"></i>ผู้บันทึก / ช่างผู้ปฏิบัติงาน</small>
                        <div class="fw-bold text-white text-truncate">
                            <?= $repairmanFullName ?></div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="it-info-chip h-100">
                        <small class="d-block text-indigo-200 mb-1" style="color: #c7d2fe;"><i
                                class="bx bx-map-pin me-1"></i>สถานที่ปฏิบัติงาน</small>
                        <div class="fw-bold text-white text-truncate"><?= $Order[0]->repair_building ?: 'อบจ.นครสวรรค์' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- ========================================== -->
        <!-- LEFT: REPAIR INFO & IMAGES                -->
        <!-- ========================================== -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div
                    class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-primary mb-0 d-flex align-items-center">
                        <i class="bx bx-info-circle me-2"></i>ข้อมูลการแจ้งปัญหา
                    </h5>
                    <span class="badge bg-label-secondary font-monospace"><?= $Order[0]->repair_order ?></span>
                </div>

                <div class="card-body pt-4">
                    <div class="p-3 bg-light rounded-3 mb-4 border">
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <small class="text-muted d-block text-uppercase fw-semibold"
                                    style="font-size: 0.72rem;">เลขที่ใบงาน</small>
                                <span class="fw-bold text-dark fs-5 font-monospace"
                                    id="show_repair_order"><?= $Order[0]->repair_order ?></span>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block text-uppercase fw-semibold"
                                    style="font-size: 0.72rem;">วันเวลาที่แจ้ง/บันทึก</small>
                                <span class="fw-bold text-dark" id="show_repair_datetime">
                                    <i class="bx bx-calendar text-primary me-1"></i>
                                    <?= $Datethai->thai_date_and_time(strtotime($Order[0]->repair_datetime)) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <dl class="row mb-4">
                        <?php if (!$isITSupport): ?>
                            <dt class="col-sm-4 fw-medium text-muted">ผู้แจ้งซ่อม:</dt>
                            <dd class="col-sm-8 fw-semibold text-dark" id="show_repair_userID">
                                <?= ($Order[0]->pers_prefix ?? '') . ($Order[0]->pers_firstname ?? 'เจ้าหน้าที่') . ' ' . ($Order[0]->pers_lastname ?? '') ?>
                            </dd>

                            <dt class="col-sm-4 fw-medium text-muted">ตำแหน่ง:</dt>
                            <dd class="col-sm-8" id="show_repair_posi">
                                <?= $Order[0]->posi_name ?: ($Order[0]->repair_posi ?: '-') ?></dd>
                        <?php else: ?>
                            <dt class="col-sm-4 fw-medium text-muted">ผู้บันทึกข้อมูล:</dt>
                            <dd class="col-sm-8 fw-bold text-dark d-flex align-items-center gap-1">
                                <i class="bx bx-user-check text-success"></i>
                                <?= $repairmanFullName ?>
                            </dd>

                            <dt class="col-sm-4 fw-medium text-muted">ตำแหน่ง:</dt>
                            <dd class="col-sm-8 fw-bold text-dark" id="show_repair_posi">
                                <span class="badge bg-label-primary font-monospace px-2.5 py-1" style="font-size: 0.85rem;">
                                    <i class="bx bx-id-card me-1"></i><?= $Order[0]->repair_posi ?: ($Order[0]->posi_name ?: 'ผู้ช่วยนักวิชาการคอมพิวเตอร์') ?>
                                </span>
                            </dd>

                            <dt class="col-sm-4 fw-medium text-muted">สังกัด/หน่วยงาน:</dt>
                            <dd class="col-sm-8 text-primary fw-semibold">กองการศึกษา ศาสนา และวัฒนธรรม</dd>
                        <?php endif; ?>

                        <dt class="col-sm-4 fw-medium text-muted">สถานที่:</dt>
                        <dd class="col-sm-8 fw-semibold text-dark" id="show_repair_location">
                            <i class="bx bx-map-pin text-danger me-1"></i><?= $fullLocation ?>
                        </dd>

                        <dt class="col-sm-4 fw-medium text-muted">ประเภทงาน:</dt>
                        <dd class="col-sm-8">
                            <span
                                class="badge bg-label-info px-2.5 py-1.5 fw-bold"><?= $Order[0]->repair_caselist ?></span>
                        </dd>
                    </dl>

                    <h6 class="mb-2 fw-bold text-dark d-flex align-items-center">
                        <i class="bx bx-detail me-2 text-primary"></i>รายละเอียดงาน
                    </h6>
                    <div class="p-3 bg-light rounded-3 mb-4 border" style="line-height: 1.6;">
                        <p class="mb-0 text-dark fw-medium" id="show_repair_detail" style="white-space: pre-line;">
                            <?= $displayDetail ?></p>
                    </div>

                    <!-- Image Gallery Section -->
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            <i class="bx bx-images me-2 text-primary"></i>ภาพประกอบงาน
                        </h6>
                        <?php if (!empty($userImages)): ?>
                            <span class="badge bg-label-primary px-2.5 py-1">
                                ทั้งหมด <?= count($userImages) ?> รูป
                            </span>
                        <?php endif; ?>
                    </div>

                    <div id="show_repair_imguser" class="p-3 border rounded-3 bg-light">
                        <?php if (!empty($userImages)): ?>
                            <div class="row g-3">
                                <?php
                                $imgIdx = 1;
                                foreach ($userImages as $img):
                                    $img = trim($img);
                                    if (empty($img))
                                        continue;
                                    $imgSrc = (filter_var($img, FILTER_VALIDATE_URL) || strpos($img, 'http://') === 0 || strpos($img, 'https://') === 0)
                                        ? $img
                                        : base_url('uploads/user/Repair/' . $img);
                                    ?>
                                    <div class="col-6 col-md-4">
                                        <div class="gallery-card">
                                            <a href="<?= $imgSrc ?>" target="_blank" title="คลิกเพื่อดูรูปขนาดเต็ม">
                                                <img src="<?= $imgSrc ?>" alt="ภาพประกอบงาน <?= $imgIdx ?>"
                                                    onerror="this.onerror=null; this.src='<?= base_url('assets/img/no-image.svg') ?>';">
                                                <span class="gallery-badge"><i
                                                        class="bx bx-zoom-in me-1"></i><?= $imgIdx ?>/<?= count($userImages) ?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    $imgIdx++;
                                endforeach;
                                ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <img src="<?= base_url('assets/img/no-image.svg') ?>"
                                    class="img-fluid rounded border shadow-sm mb-2" style="max-height: 120px;"
                                    alt="ไม่มีรูปภาพประกอบ">
                                <div class="text-muted small">ไม่มีรูปภาพประกอบสำหรับรายการนี้</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- RIGHT: OPERATION INFO & STATUS            -->
        <!-- ========================================== -->
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="card-title text-primary mb-0 d-flex align-items-center">
                        <i class="bx bx-cog me-2"></i>ข้อมูลการดำเนินการ
                    </h5>
                </div>

                <div class="card-body pt-4">
                    <div class="mb-4 text-center">
                        <small class="text-muted d-block mb-2 text-uppercase fw-semibold"
                            style="font-size: 0.72rem;">สถานะปัจจุบัน</small>
                        <?php
                        $status = $Order[0]->repair_status ?? 'รอดำเนินการ';
                        $badge_class = 'bg-label-secondary';
                        $icon_class = 'bx-time';
                        if ($status == 'กำลังดำเนินการ') {
                            $badge_class = 'bg-label-info';
                            $icon_class = 'bx-loader-circle bx-spin';
                        }
                        if ($status == 'ดำเนินการเรียบร้อย') {
                            $badge_class = 'bg-label-success';
                            $icon_class = 'bx-check-circle';
                        }
                        if ($status == 'ยกเลิก') {
                            $badge_class = 'bg-label-danger';
                            $icon_class = 'bx-x-circle';
                        }
                        ?>
                        <span class="badge <?= $badge_class ?> fs-5 py-2.5 px-4 rounded-pill shadow-sm">
                            <i class="bx <?= $icon_class ?> me-2"></i><?= $status ?>
                        </span>
                    </div>

                    <!-- Evaluation Section (สำหรับงานทั่วไป) -->
                    <?php if (!$isITSupport): ?>
                        <div class="mt-4 mb-4">
                            <?php
                            $isOwner = (session()->get('id') == $Order[0]->repair_userID);
                            if (trim($status) == 'ดำเนินการเรียบร้อย' && ($isOwner || $isAdmin)):
                                ?>
                                <?php if (empty($Evaluation)): ?>
                                    <div class="alert alert-primary d-flex align-items-center border-0 shadow-sm" role="alert">
                                        <i class="bx bx-star fs-3 me-3"></i>
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">ประเมินความพึงพอใจ</div>
                                            <div class="small">งานซ่อมเสร็จสิ้นแล้ว รบกวนคุณสละเวลาสักครู่เพื่อประเมินการทำงานครับ
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-sm ms-2" id="BtnOpenEvaluation">ประเมิน</button>
                                    </div>
                                <?php else: ?>
                                    <div class="card bg-label-success border-0 shadow-none mb-0">
                                        <div class="card-body p-3">
                                            <div class="fw-bold mb-2 text-success"><i class="bx bxs-check-shield me-1"></i>
                                                ประเมินแล้ว</div>
                                            <div class="row g-2 small text-dark">
                                                <div class="col-6">ความรวดเร็ว:</div>
                                                <div class="col-6 star-display">
                                                    <?= str_repeat('<i class="bx bxs-star"></i>', $Evaluation->eval_score_speed) ?>
                                                </div>
                                                <div class="col-6">คุณภาพ:</div>
                                                <div class="col-6 star-display">
                                                    <?= str_repeat('<i class="bx bxs-star"></i>', $Evaluation->eval_score_quality) ?>
                                                </div>
                                                <div class="col-6">การบริการ:</div>
                                                <div class="col-6 star-display">
                                                    <?= str_repeat('<i class="bx bxs-star"></i>', $Evaluation->eval_score_service) ?>
                                                </div>
                                            </div>
                                            <?php if (!empty($Evaluation->eval_comment)): ?>
                                                <div class="mt-2 p-2 bg-white rounded-3 small border border-success border-opacity-25">
                                                    <strong>ความเห็น:</strong> <?= $Evaluation->eval_comment ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <ul class="list-unstyled mb-4">
                        <li class="d-flex mb-3 pb-2 border-bottom">
                            <i class="bx bx-calendar me-3 text-primary fs-3"></i>
                            <div>
                                <small class="text-muted d-block">วันที่ดำเนินการ</small>
                                <div class="fw-bold text-dark">
                                    <?php
                                    if (empty($Order[0]->repair_datework) || $Order[0]->repair_datework == '0000-00-00 00:00:00') {
                                        echo "<span class='text-muted'>-</span>";
                                    } else {
                                        echo $Datethai->thai_date_and_time(strtotime($Order[0]->repair_datework));
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-3 pb-2 border-bottom">
                            <i class="bx bx-user-voice me-3 text-primary fs-3"></i>
                            <div>
                                <small class="text-muted d-block">ช่างผู้ดำเนินการ / ผู้รับเรื่อง</small>
                                <div class="fw-bold text-dark" id="show_repair_Repairman">
                                    <?= $repairmanFullName ?>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-3">
                            <i class="bx bx-info-circle me-3 text-primary fs-3"></i>
                            <div>
                                <small class="text-muted d-block">สาเหตุ / ที่มาข้อมูล</small>
                                <div class="fw-medium text-dark" id="show_repair_cause">
                                    <?= $Order[0]->repair_cause ?: '-' ?>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <?php if (!$isITSupport && !empty($workImages)): ?>
                        <h6 class="mb-2 fw-bold text-dark d-flex align-items-center">
                            <i class="bx bx-check-circle me-2 text-success"></i>ภาพการดำเนินงาน
                        </h6>
                        <div id="show_repair_imgwork" class="p-3 border rounded-3 bg-light mb-4">
                            <div class="row g-2 justify-content-center">
                                <?php
                                foreach ($workImages as $img_w):
                                    $img_w = trim($img_w);
                                    if (empty($img_w))
                                        continue;
                                    $imgSrcWork = (filter_var($img_w, FILTER_VALIDATE_URL) || strpos($img_w, 'http://') === 0 || strpos($img_w, 'https://') === 0)
                                        ? $img_w
                                        : base_url('uploads/admin/Repair/' . $img_w);
                                    ?>
                                    <div class="col-6">
                                        <div class="gallery-card">
                                            <a href="<?= $imgSrcWork ?>" target="_blank">
                                                <img src="<?= $imgSrcWork ?>" alt="ภาพการดำเนินงาน"
                                                    onerror="this.onerror=null; this.src='<?= base_url('assets/img/no-image.svg') ?>';">
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="p-3 rounded-3 bg-light border text-center">
                        <small class="text-muted d-block mb-1">ลายมือชื่อผู้ดำเนินการ / ผู้รับเรื่อง</small>
                        <?php if (!empty($Order[0]->repair_adminsignature)): ?>
                            <div class="mb-2">
                                <img src="<?= $Order[0]->repair_adminsignature ?>"
                                    class="img-fluid rounded bg-white border p-1" style="max-height: 80px;"
                                    alt="ลายมือชื่อ">
                            </div>
                            <div class="fw-bold text-dark">
                                ( <?= $repairmanFullName ?> )
                            </div>
                        <?php else: ?>
                            <div class="fw-bold text-dark mt-2">
                                ( <?= $repairmanFullName ?> )
                            </div>
                            <small class="text-muted">ผู้บันทึกงานในระบบ</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- ADMIN MODAL: RECEIVE & UPDATE WORK        -->
<!-- ========================================== -->
<div class="modal fade" id="ModalAdmin" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark"><i class="bx bx-wrench me-2"></i>รับงาน / บันทึกการซ่อม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <form id="FormAdmin">
                    <input type="hidden" name="repair_order" value="<?= $Order[0]->repair_order ?>">

                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white pb-0">
                            <h6 class="card-title text-primary py-2 mb-0">สถานะและผู้ดำเนินการ</h6>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="repair_status" class="form-label">สถานะการซ่อม</label>
                                    <select class="form-select" name="repair_status" id="repair_status">
                                        <option <?= $Order[0]->repair_status == "รอดำเนินการ" ? "selected" : "" ?>
                                            value="รอดำเนินการ">รอดำเนินการ</option>
                                        <option <?= $Order[0]->repair_status == "กำลังดำเนินการ" ? "selected" : "" ?>
                                            value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                                        <option <?= $Order[0]->repair_status == "ดำเนินการเรียบร้อย" ? "selected" : "" ?>
                                            value="ดำเนินการเรียบร้อย">ดำเนินการเรียบร้อย</option>
                                        <option <?= $Order[0]->repair_status == "ยกเลิก" ? "selected" : "" ?> value="ยกเลิก">
                                            ยกเลิก</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_Repairman" class="form-label">ผู้รับผิดชอบ</label>
                                    <select class="form-select" name="repair_Repairman" id="repair_Repairman">
                                        <option value="">เลือกช่างผู้รับผิดชอบ</option>
                                        <?php if (isset($Personnel) && is_array($Personnel)): ?>
                                            <?php foreach ($Personnel as $key => $value): ?>
                                                <option <?= $Order[0]->repair_Repairman == $value->pers_id ? 'selected' : '' ?>
                                                    value="<?= $value->pers_id ?>">
                                                    <?= $value->pers_prefix . $value->pers_firstname . ' ' . $value->pers_lastname ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white pb-0">
                            <h6 class="card-title text-primary py-2 mb-0">รายละเอียดการซ่อม</h6>
                        </div>
                        <div class="card-body pt-3">
                            <div class="mb-3">
                                <label for="repair_cause" class="form-label">สาเหตุ / วิธีแก้ไข</label>
                                <textarea class="form-control" name="repair_cause" id="repair_cause"
                                    rows="3"><?= $Order[0]->repair_cause; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white pb-0">
                            <h6 class="card-title text-primary py-2 mb-0">ลายเซ็นช่างซ่อม/ผู้รับเรื่อง</h6>
                        </div>
                        <div class="card-body pt-3">
                            <div class="border rounded p-0 text-center bg-white mb-2 overflow-hidden">
                                <canvas id="signature-pad" class="w-100" style="touch-action: none;"></canvas>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger w-100 mb-3" id="clear">
                                <i class="bx bx-refresh me-1"></i> ล้างลายเซ็น
                            </button>

                            <button type="submit" id="BtnSave" class="btn btn-primary w-100 py-2 fw-bold">
                                <span id="btnSaveText"><i class="bx bx-save me-1"></i> บันทึกการซ่อม</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2"
                                    style="display:none;" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Evaluation Modal -->
<div class="modal fade" id="ModalEvaluation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white"><i class="bx bx-star me-2"></i>ประเมินความพึงพอใจ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="FormEvaluation">
                <div class="modal-body p-4">
                    <input type="hidden" name="repair_order" value="<?= $Order[0]->repair_order ?>">

                    <div class="text-center mb-4">
                        <p class="text-muted">ความพึงพอใจของคุณช่วยให้เราพัฒนาการบริการให้ดียิ่งขึ้น</p>
                    </div>

                    <div class="mb-4">
                        <label class="d-block text-center fw-bold mb-2">1. ความรวดเร็วในการให้บริการ</label>
                        <div class="star-rating">
                            <input type="radio" id="speed-5" name="score_speed" value="5" required /><label
                                for="speed-5"><i class="bx bx-star"></i></label>
                            <input type="radio" id="speed-4" name="score_speed" value="4" /><label for="speed-4"><i
                                    class="bx bx-star"></i></label>
                            <input type="radio" id="speed-3" name="score_speed" value="3" /><label for="speed-3"><i
                                    class="bx bx-star"></i></label>
                            <input type="radio" id="speed-2" name="score_speed" value="2" /><label for="speed-2"><i
                                    class="bx bx-star"></i></label>
                            <input type="radio" id="speed-1" name="score_speed" value="1" /><label for="speed-1"><i
                                    class="bx bx-star"></i></label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="d-block text-center fw-bold mb-2">2. คุณภาพการซ่อมแซม</label>
                        <div class="star-rating">
                            <input type="radio" id="quality-5" name="score_quality" value="5" required /><label
                                for="quality-5"><i class="bx bx-star"></i></label>
                            <input type="radio" id="quality-4" name="score_quality" value="4" /><label
                                for="quality-4"><i class="bx bx-star"></i></label>
                            <input type="radio" id="quality-3" name="score_quality" value="3" /><label
                                for="quality-3"><i class="bx bx-star"></i></label>
                            <input type="radio" id="quality-2" name="score_quality" value="2" /><label
                                for="quality-2"><i class="bx bx-star"></i></label>
                            <input type="radio" id="quality-1" name="score_quality" value="1" /><label
                                for="quality-1"><i class="bx bx-star"></i></label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="d-block text-center fw-bold mb-2">3. มารยาทและการให้บริการของเจ้าหน้าที่</label>
                        <div class="star-rating">
                            <input type="radio" id="service-5" name="score_service" value="5" required /><label
                                for="service-5"><i class="bx bx-star"></i></label>
                            <input type="radio" id="service-4" name="score_service" value="4" /><label
                                for="service-4"><i class="bx bx-star"></i></label>
                            <input type="radio" id="service-3" name="score_service" value="3" /><label
                                for="service-3"><i class="bx bx-star"></i></label>
                            <input type="radio" id="service-2" name="score_service" value="2" /><label
                                for="service-2"><i class="bx bx-star"></i></label>
                            <input type="radio" id="service-1" name="score_service" value="1" /><label
                                for="service-1"><i class="bx bx-star"></i></label>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label for="comment" class="form-label fw-bold">ข้อเสนอแนะเพิ่มเติม (ถ้ามี)</label>
                        <textarea class="form-control bg-light border-0" id="comment" name="comment" rows="3"
                            placeholder="เขียนความเห็นของคุณที่นี่..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm" id="BtnSaveEvaluation">
                        <i class="bx bx-check-circle me-1"></i> ส่งผลการประเมิน
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).on('click', '#BtnStaffLogin', function () {
        $('#ModalStaffLogin').modal('show');
    });

    // Toggle password visibility
    $(document).on('click', '#toggleStaffPassword', function () {
        const $input = $('#staff_password');
        const $icon = $(this).find('i');
        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('bx-show').addClass('bx-hide');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('bx-hide').addClass('bx-show');
        }
    });

    // Staff Login Form Submit
    $(document).on('submit', '#FormStaffLogin', function (e) {
        e.preventDefault();
        const $btn = $('#BtnStaffLoginSubmit');
        const $btnText = $('#staffLoginBtnText');
        const $spinner = $('#staffLoginSpinner');
        const $error = $('#staffLoginError');

        $error.hide();
        $btn.prop('disabled', true);
        $btnText.text('กำลังเข้าสู่ระบบ...');
        $spinner.show();

        $.ajax({
            url: '<?= base_url("Repair/DB/StaffLogin") ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'เข้าสู่ระบบสำเร็จ!',
                        text: 'กำลังเปลี่ยนหน้า...',
                        timer: 1200,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    }).then(function () {
                        window.location.href = res.redirect;
                    });
                } else {
                    $('#staffLoginErrorMsg').text(res.message);
                    $error.show();
                    $btn.prop('disabled', false);
                    $btnText.html('<i class="bx bx-log-in me-1"></i> เข้าสู่ระบบ');
                    $spinner.hide();
                }
            },
            error: function () {
                $('#staffLoginErrorMsg').text('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
                $error.show();
                $btn.prop('disabled', false);
                $btnText.html('<i class="bx bx-log-in me-1"></i> เข้าสู่ระบบ');
                $spinner.hide();
            }
        });
    });

    $(document).on('click', '#ModalFormAdmin', function () {
        $('#ModalAdmin').modal('show');
    });

    $(document).on('click', '#BtnOpenEvaluation', function () {
        $('#ModalEvaluation').modal('show');
    });
    // Delete Order Confirmation & Handler
    $(document).on('click', '#BtnDeleteOrder', function () {
        const orderNumber = $(this).data('order') || '<?= $Order[0]->repair_order ?>';

        Swal.fire({
            title: 'ยืนยันการลบข้อมูล?',
            text: `คุณต้องการลบข้อมูลการแจ้งซ่อมเลขที่ ${orderNumber} พร้อมรูปภาพและประวัติที่เกี่ยวข้องทั้งหมดใช่หรือไม่? (การกระทำนี้ไม่สามารถย้อนกลับได้)`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="bx bx-trash me-1"></i> ยืนยันลบข้อมูล',
            cancelButtonText: 'ยกเลิก',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังลบข้อมูล...',
                    text: 'ระบบกำลังลบข้อมูลและไฟล์ที่เกี่ยวข้อง กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '<?= base_url("Repair/DB/DeleteOrder") ?>',
                    method: 'POST',
                    data: { repair_order: orderNumber },
                    dataType: 'json',
                    success: function (res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบข้อมูลสำเร็จ!',
                                text: res.message || 'ลบข้อมูลการแจ้งซ่อมเรียบร้อยแล้ว',
                                confirmButtonColor: '#3730a3'
                            }).then(() => {
                                window.location.href = res.redirect || '<?= base_url("Repair/Dashboard") ?>';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ไม่สามารถลบข้อมูลได้',
                                text: res.message || 'เกิดข้อผิดพลาดในการลบข้อมูล'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดในการเชื่อมต่อ',
                            text: 'ไม่สามารถส่งคำขอลบข้อมูลไปยังเซิร์ฟเวอร์ได้'
                        });
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>