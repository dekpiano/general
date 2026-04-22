<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --repair-primary: #696cff;
        --glass-bg: rgba(255, 255, 255, 0.9);
        --glass-border: rgba(255, 255, 255, 0.4);
    }

    .repair-add-container {
        padding-top: 1.5rem;
        padding-bottom: 4rem;
    }

    /* Premium Header */
    .premium-header {
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        border-radius: 1.5rem;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 10px 30px rgba(105, 108, 255, 0.2);
    }

    .form-glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .card-title-premium {
        background: rgba(105, 108, 255, 0.05);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(105, 108, 255, 0.1);
        color: var(--repair-primary);
        font-weight: 700;
        display: flex;
        align-items: center;
    }

    .card-body-premium {
        padding: 2rem;
    }

    /* Form Styling & Select2 Fix */
    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom .form-control,
    .form-floating-custom .form-select {
        height: calc(3.5rem + 2px) !important;
        padding: 1.625rem 0.75rem 0.625rem 0.75rem !important;
    }

    .form-floating-custom label {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding: 1rem 0.75rem;
        overflow: hidden;
        text-align: start;
        text-overflow: ellipsis;
        white-space: nowrap;
        pointer-events: none;
        border: 1px solid transparent;
        transform-origin: 0 0;
        transition: opacity .1s ease-in-out, transform .1s ease-in-out;
        color: rgba(67, 89, 113, 0.6);
        z-index: 5;
    }

    .form-floating-custom.is-filled label,
    .form-floating-custom.is-focused label {
        opacity: .65;
        transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
    }

    /* Select2 Specific Overrides */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: calc(3.5rem + 2px) !important;
        padding-top: 1.625rem !important;
        padding-left: 0.75rem !important;
        border: 1px solid #d9dee3 !important;
        border-radius: 0.375rem !important;
    }

    .form-floating-custom.is-focused .select2-container--bootstrap-5 .select2-selection {
        border-color: #696cff !important;
        box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.25) !important;
    }

    .select2-container--bootstrap-5 .select2-selection__placeholder {
        color: transparent !important;
    }
    
    .form-floating-custom:not(.is-filled):not(.is-focused) .select2-selection__rendered {
        opacity: 0 !important;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(to right, rgba(105, 108, 255, 0.2), transparent);
        margin: 2rem 0;
    }

    /* Signature & Image UI */
    .upload-zone {
        border: 2px dashed rgba(105, 108, 255, 0.2);
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #fcfcff;
        cursor: pointer;
    }

    .upload-zone:hover {
        border-color: var(--repair-primary);
        background: #f4f5ff;
    }

    .sig-canvas-wrapper {
        border: 1px solid #d9dee3;
        border-radius: 1rem;
        background: white;
        overflow: hidden;
    }

    #signature-pad {
        cursor: crosshair;
        background: #fff;
        display: block;
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        max-width: 100%;
        width: 100%;
        height: 150px;
    }

    /* Action Buttons */
    .btn-submit-premium {
        background: linear-gradient(135deg, #696cff 0%, #4345bb 100%);
        border: none;
        color: white;
        padding: 1rem;
        border-radius: 1rem;
        font-weight: 700;
        letter-spacing: 1px;
        box-shadow: 0 8px 20px rgba(105, 108, 255, 0.3);
        transition: all 0.3s ease;
    }

    .btn-submit-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(105, 108, 255, 0.4);
        color: white;
    }

    .captcha-badge {
        background: #f0f2ff;
        color: var(--repair-primary);
        font-size: 1.5rem;
        font-weight: 700;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        border: 1px solid rgba(105, 108, 255, 0.1);
    }
    /* Stepper UI */
    .repair-stepper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 3rem;
        padding: 0 1rem;
        position: relative;
    }

    .repair-stepper::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 10%;
        right: 10%;
        height: 2px;
        background: #e0e0e0;
        z-index: 1;
    }

    .step-item {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 25%;
    }

    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: white;
        border: 2px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        color: #888;
        font-weight: bold;
    }

    .step-item.active .step-icon {
        background: var(--repair-primary);
        border-color: var(--repair-primary);
        color: white;
        box-shadow: 0 0 15px rgba(105, 108, 255, 0.4);
    }

    .step-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #888;
        text-align: center;
    }

    .step-item.active .step-label {
        color: var(--repair-primary);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .premium-header {
            padding: 1.5rem;
            flex-direction: column;
            text-align: center;
        }
        .header-illu {
            display: none;
        }
        .step-label {
            font-size: 0.7rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 repair-add-container">
    
    <!-- Premium Header -->
    <div class="premium-header">
        <div>
            <h2 class="mb-1 text-white">บันทึกข้อมูลแจ้งซ่อม</h2>
            <p class="mb-0 text-white-50">แจ้งปัญหาของท่านเพื่อให้เจ้าหน้าที่เร่งดำเนินการแก้ไข</p>
        </div>
        <img src="<?=base_url('assets/img/illustrations/man-with-laptop-light.png')?>" alt="Repair" class="header-illu" style="height: 100px;">
    </div>

    <!-- Step Indicator -->
    <div class="repair-stepper">
        <div class="step-item active">
            <div class="step-icon">1</div>
            <div class="step-label">แจ้งปัญหา</div>
        </div>
        <div class="step-item active">
            <div class="step-icon">2</div>
            <div class="step-label">ระบุสถานที่</div>
        </div>
        <div class="step-item active">
            <div class="step-icon">3</div>
            <div class="step-label">ข้อมูลผู้แจ้ง</div>
        </div>
        <div class="step-item active">
            <div class="step-icon"><i class="bx bx-check"></i></div>
            <div class="step-label">หลักฐาน</div>
        </div>
    </div>

    <form id="FormAddRepair" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-4">
            <!-- Main Form Section -->
            <div class="col-lg-8">
                <div class="form-glass-card h-100">
                    <div class="card-title-premium">
                        <i class="bx bx-wrench me-2 fs-4"></i> ส่วนที่ 1 & 2: รายละเอียดปัญหาและสถานที่
                    </div>
                    <div class="card-body-premium">
                        <div class="row g-4">
                            <!-- Date Row (Top) -->
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="repair_date" value="<?=$Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')))?>" readonly style="background: rgba(105, 108, 255, 0.03); border-color: rgba(105, 108, 255, 0.1);">
                                    <label for="repair_date">วันที่ปัจจุบัน (แจ้งซ่อม)</label>
                                </div>
                            </div>

                            <div class="col-12"><div class="section-divider" style="margin: 1rem 0;"></div></div>

                            <!-- Step 1: Problem Details -->
                            <div class="col-12">
                                <label class="small text-primary fw-bold mb-2"><i class="bx bx-chevron-right"></i> ขั้นตอนที่ 1: แจ้งปัญหาที่พบ</label>
                                <div class="form-floating-custom mb-3">
                                    <select name="repair_caselist" id="repair_caselist" class="form-select" required>
                                        <option value="" selected disabled></option>
                                        <option value="คอมพิวเตอร์/โปรเจคเตอร์">คอมพิวเตอร์/โปรเจคเตอร์</option>
                                        <option value="ปริ้นเตอร์/สแกนเนอร์">ปริ้นเตอร์/สแกนเนอร์</option>
                                        <option value="ระบบเครือข่าย">ระบบเครือข่าย</option>
                                        <option value="โสตทัศนอุปกรณ์">โสตทัศนอุปกรณ์</option>
                                        <option value="งานอาคารสถานที่">งานอาคารสถานที่</option>
                                    </select>
                                    <label for="repair_caselist">ประเภทงานซ่อม <span class="text-danger">*</span></label>
                                </div>
                                <div class="form-floating">
                                    <textarea id="repair_detail" name="repair_detail" class="form-control" style="height: 100px" placeholder="อธิบายปัญหา" required></textarea>
                                    <label for="repair_detail">รายละเอียดอาการเสีย / ปัญหา <span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <!-- Step 2: Location -->
                            <div class="col-12">
                                <label class="small text-primary fw-bold mb-2"><i class="bx bx-chevron-right"></i> ขั้นตอนที่ 2: ระบุสถานที่</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating-custom">
                                            <select name="repair_building" id="repair_building" class="form-select" required>
                                                <option value="" selected disabled></option>
                                                <option value="อาคาร 1">อาคาร 1</option>
                                                <option value="อาคาร 2">อาคาร 2</option>
                                                <option value="อาคาร 3">อาคาร 3</option>
                                                <option value="อาคาร 4">อาคาร 4</option>
                                                <option value="อาคาร 5">อาคาร 5 โรงอาหาร</option>
                                                <option value="อาคาร 6">อาคาร 6</option>
                                                <option value="อาคาร 7">อาคาร 7</option>
                                                <option value="อาคาร 8">อาคาร 8</option>
                                                <option value="อาคาร 9">อาคาร 9</option>
                                                <option value="อาคารเจ้าพระยา">อาคารเจ้าพระยา</option>
                                                <option value="อาคารกีฬา">อาคารกีฬา</option>
                                                <option value="อาคารโดมเอนกประสงค์">อาคารโดมเอนกประสงค์</option>
                                                <option value="อาคารเอนกประสงค์">อาคารเอนกประสงค์</option>
                                            </select>
                                            <label for="repair_building">อาคาร <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating-custom">
                                            <select name="repair_class" id="repair_class" class="form-select" required>
                                                <option value="" selected disabled></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                            <label for="repair_class">ชั้นที่ <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="repair_room" id="repair_room" placeholder="Ex. 421">
                                            <label for="repair_room">ชื่อห้อง / เลขห้อง</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Requester Info -->
                            <div class="col-12">
                                <label class="small text-primary fw-bold mb-2"><i class="bx bx-chevron-right"></i> ขั้นตอนที่ 3: ข้อมูลผู้แจ้ง</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <select name="repair_posi" id="repair_posi" class="form-select" required>
                                                <option value="" selected disabled></option>
                                                <?php foreach ($Posi as $v_Posi) :?>
                                                <option value="<?=$v_Posi->posi_id?>"><?=$v_Posi->posi_name?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="repair_posi">ตำแหน่งผู้ใช้งาน <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <select name="repair_userID" id="repair_userID" class="form-select" required>
                                                <option value="" selected disabled></option>
                                            </select>
                                            <label for="repair_userID">รายชื่อผู้แจ้ง <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="repair_phone" id="repair_phone" placeholder="0123456789" required>
                                            <label for="repair_phone">เบอร์ติดต่อ <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Form Section -->
            <div class="col-lg-4">
                <div class="row g-4">
                    <!-- Photo Card -->
                    <div class="col-12">
                        <div class="form-glass-card">
                            <div class="card-title-premium">
                                <i class="bx bx-camera me-2 fs-4"></i> ขั้นตอนที่ 3: รูปภาพประกอบ
                            </div>
                            <div class="card-body-premium">
                                <p class="small text-muted mb-3">แนบรูปภาพประกอบ (สูงสุด 3 รูป)</p>
                                <div class="row g-2">
                                    <?php for($i=0; $i<3; $i++): ?>
                                    <div class="col-12">
                                        <div class="upload-zone p-2 h-100 d-flex flex-column align-items-center justify-content-center" onclick="triggerFileInput(<?=$i?>)">
                                            <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2216%22%20height%3D%229%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f8f9fa%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22sans-serif%22%20font-size%3D%221%22%20fill%3D%22%23dee2e6%22%20text-anchor%3D%22middle%22%20dy%3D%22.3em%22%3E16:9%3C/text%3E%3C/svg%3E" id="imageResult<?=$i?>" class="img-fluid rounded mb-1" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
                                            <span class="x-small text-muted" style="font-size: 0.6rem;">รูปที่ <?=$i+1?></span>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                                <input type="file" id="repair_imguser_input" class="d-none" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Signature Card -->
                    <div class="col-12">
                        <div class="form-glass-card">
                            <div class="card-title-premium">
                                <i class="bx bx-pencil me-2 fs-4"></i> ลายเซ็นผู้แจ้ง (ยืนยัน)
                            </div>
                            <div class="card-body-premium">
                                <div class="sig-canvas-wrapper mb-2">
                                    <canvas id="signature-pad" class="w-100" height="200" style="touch-action: none;"></canvas>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm w-100" id="clear">
                                    <i class="bx bx-refresh me-1"></i> รีเซ็ตลายเซ็น
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bot Protection & Submit -->
                    <div class="col-12">
                        <div class="form-glass-card">
                            <div class="card-body-premium pt-4">
                                <div class="text-center mb-4">
                                    <p class="small text-secondary fw-bold text-uppercase mb-2">ขั้นตอนที่ 4: เสร็จสิ้น</p>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <div class="captcha-badge" data-answer="<?=$num1 + $num2?>"><?=$num1?> + <?=$num2?></div>
                                        <div class="fs-4 fw-bold">=</div>
                                        <input type="number" class="form-control text-center fw-bold fs-4" id="captcha_input" name="captcha_input" required style="width: 100px; height: 58px;">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-submit-premium w-100 disabled" id="BtnSubRepair" disabled>
                                    <span id="btnSaveText"><i class="bx bx-paper-plane me-2"></i> บันทึกแจ้งซ่อม</span>
                                    <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status"></span>
                                </button>
                                <a href="<?=base_url('Repair')?>" class="btn btn-link w-100 mt-2 text-muted">ยกเลิกและย้อนกลับ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal for Cropping Image -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="cropModalLabel"><i class="bx bx-crop me-2"></i> ครอบตัดรูปภาพ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="croppie-container" style="height: 450px;"></div>
                </div>
                <div class="modal-footer bg-light d-flex justify-content-between">
                    <div class="rotation-controls">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-rotate-left">
                            <i class="bx bx-rotate-left"></i> หมุนซ้าย
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-rotate-right">
                            <i class="bx bx-rotate-right"></i> หมุนขวา
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" id="btn-crop">
                            <i class="bx bx-check me-1"></i> ตกลง และใช้รูปนี้
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('customCSS') ?>
<!-- Content here is handled in the style tag above for better maintainability -->
<?= $this->endSection() ?>


