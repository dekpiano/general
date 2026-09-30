<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --repair-primary: #696cff;
        --glass-bg: rgba(255, 255, 255, 0.92);
        --glass-border: rgba(255, 255, 255, 0.6);
        --repair-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
    }

    .repair-add-container {
        padding-top: 1.5rem;
        padding-bottom: 4rem;
    }

    /* Premium Header */
    .premium-header {
        background: var(--repair-gradient);
        border-radius: 1.5rem;
        padding: 2.25rem 2.5rem;
        margin-bottom: 2rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 10px 30px rgba(105, 108, 255, 0.25);
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
        background: rgba(105, 108, 255, 0.06);
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid rgba(105, 108, 255, 0.12);
        color: var(--repair-primary);
        font-weight: 800;
        display: flex;
        align-items: center;
        font-size: 1.1rem;
    }

    .card-body-premium {
        padding: 2rem;
    }

    /* Form Controls & Labels */
    .form-label-custom {
        font-size: 0.88rem;
        font-weight: 700;
        color: #435971;
        margin-bottom: 0.45rem;
        display: flex;
        align-items: center;
    }

    .form-label-custom i {
        font-size: 1.1rem;
        margin-right: 0.35rem;
        color: var(--repair-primary);
    }

    .form-control-custom {
        height: 48px;
        border-radius: 10px;
        border: 1px solid #d9dee3;
        padding: 0.55rem 1rem;
        font-size: 0.92rem;
        color: #435971;
        background-color: #ffffff;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .form-control-custom:focus {
        border-color: #696cff !important;
        box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.18) !important;
        background-color: #ffffff;
    }

    /* =========================================================
       --- SELECT2 THEME CUSTOMIZATION (Premium Sneat Look) ---
       ========================================================= */
    .select2-container {
        display: block !important;
        width: 100% !important;
    }

    .select2-container .select2-selection--single {
        height: 48px !important;
        min-height: 48px !important;
        border: 1px solid #d9dee3 !important;
        border-radius: 10px !important;
        background-color: #ffffff !important;
        padding: 0 1rem !important;
        display: flex !important;
        align-items: center !important;
        transition: all 0.2s ease-in-out !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
        position: relative !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #696cff !important;
        box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.18) !important;
        background-color: #ffffff !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        color: #435971 !important;
        font-size: 0.92rem !important;
        font-weight: 500 !important;
        padding-left: 0 !important;
        padding-right: 2rem !important;
        line-height: 46px !important;
        width: 100% !important;
        display: block !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .select2-container .select2-selection--single .select2-selection__placeholder {
        color: #a1acb8 !important;
        font-size: 0.9rem !important;
        font-weight: 400 !important;
    }

    /* Custom Dropdown Arrow */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        position: absolute !important;
        top: 0 !important;
        right: 12px !important;
        height: 48px !important;
        width: 20px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: transform 0.25s ease !important;
    }

    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow {
        transform: rotate(180deg) !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #696cff transparent transparent transparent !important;
        border-width: 6px 5px 0 5px !important;
        margin-left: -5px !important;
        margin-top: -3px !important;
    }

    /* Dropdown Popover */
    .select2-dropdown {
        border: 1px solid rgba(105, 108, 255, 0.25) !important;
        border-radius: 12px !important;
        background: #ffffff !important;
        box-shadow: 0 14px 35px rgba(67, 89, 113, 0.16) !important;
        overflow: hidden !important;
        z-index: 99999 !important;
        padding-top: 8px !important;
        padding-bottom: 8px !important;
        animation: select2DropdownIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }

    @keyframes select2DropdownIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Search Box in Dropdown */
    .select2-container .select2-search--dropdown {
        padding: 6px 12px 10px 12px !important;
    }

    .select2-container .select2-search--dropdown .select2-search__field {
        border: 1px solid #d9dee3 !important;
        border-radius: 8px !important;
        padding: 0.55rem 0.95rem !important;
        font-size: 0.88rem !important;
        outline: none !important;
        transition: all 0.2s ease !important;
        width: 100% !important;
    }

    .select2-container .select2-search--dropdown .select2-search__field:focus {
        border-color: #696cff !important;
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.15) !important;
    }

    /* Dropdown Options List */
    .select2-container--default .select2-results > .select2-results__options {
        max-height: 280px !important;
        overflow-y: auto !important;
        padding: 4px 8px !important;
    }

    .select2-container--default .select2-results__option {
        padding: 9px 14px !important;
        border-radius: 8px !important;
        margin-bottom: 3px !important;
        font-size: 0.9rem !important;
        color: #435971 !important;
        transition: all 0.15s ease !important;
        white-space: normal !important;
        word-break: break-word !important;
        line-height: 1.4 !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #f0f2ff !important;
        color: #696cff !important;
        font-weight: 600 !important;
    }

    .select2-container--default .select2-results__option[aria-selected="true"] {
        background: linear-gradient(135deg, #696cff 0%, #4345bb 100%) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }

    /* Disabled Select2 */
    .select2-container--default.select2-container--disabled .select2-selection--single {
        background-color: #f5f6f8 !important;
        border-color: #e4e6ea !important;
        cursor: not-allowed !important;
        opacity: 0.75 !important;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(to right, rgba(105, 108, 255, 0.2), transparent);
        margin: 1.75rem 0;
    }

    /* Upload & Signature UI */
    .upload-zone {
        border: 2px dashed rgba(105, 108, 255, 0.25);
        border-radius: 1rem;
        padding: 1.25rem;
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
        margin-bottom: 2.5rem;
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
            <div class="d-flex align-items-center mb-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url('Repair')?>" class="text-white-50">เลือกประเภท</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">แบบฟอร์มแจ้งซ่อม</li>
                    </ol>
                </nav>
            </div>
            <h2 class="mb-1 text-white fw-bold">บันทึกข้อมูลแจ้งซ่อมออนไลน์</h2>
            <p class="mb-0 text-white-50">แจ้งปัญหาที่พบเพื่อให้เจ้าหน้าที่ผู้รับผิดชอบเร่งดำเนินการแก้ไข</p>
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
            <div class="step-label">หลักฐาน & ยืนยัน</div>
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
                                <label class="form-label-custom" for="repair_date">
                                    <i class='bx bx-calendar-event'></i>วันที่แจ้งซ่อม (ปัจจุบัน)
                                </label>
                                <input type="text" class="form-control form-control-custom" id="repair_date" value="<?=$Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')))?>" readonly style="background: rgba(105, 108, 255, 0.04); font-weight: 600;">
                            </div>

                            <div class="col-12"><div class="section-divider" style="margin: 0.5rem 0;"></div></div>

                            <!-- Step 1: Problem Details -->
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label-custom mb-0" for="repair_caselist">
                                        <i class="bx bx-list-check"></i>ประเภทงานซ่อม <span class="text-danger ms-1">*</span>
                                    </label>
                                    <?php if(!empty($selectedCategory)): ?>
                                        <a href="<?=base_url('Repair')?>" class="small text-primary fw-bold text-decoration-none">
                                            <i class='bx bx-refresh me-1'></i>เปลี่ยนหมวดหมู่
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <select name="repair_caselist" id="repair_caselist" class="form-select" required>
                                    <option value="" <?= empty($selectedCategory) ? 'selected' : '' ?> disabled>-- กรุณาเลือกประเภทงานซ่อม --</option>
                                    <option value="คอมพิวเตอร์/โปรเจคเตอร์" <?= ($selectedCategory ?? '') === 'คอมพิวเตอร์/โปรเจคเตอร์' ? 'selected' : '' ?>>คอมพิวเตอร์/โปรเจคเตอร์</option>
                                    <option value="ปริ้นเตอร์/สแกนเนอร์" <?= ($selectedCategory ?? '') === 'ปริ้นเตอร์/สแกนเนอร์' ? 'selected' : '' ?>>ปริ้นเตอร์/สแกนเนอร์</option>
                                    <option value="ระบบเครือข่าย" <?= ($selectedCategory ?? '') === 'ระบบเครือข่าย' ? 'selected' : '' ?>>ระบบเครือข่าย</option>
                                    <option value="โสตทัศนอุปกรณ์" <?= ($selectedCategory ?? '') === 'โสตทัศนอุปกรณ์' ? 'selected' : '' ?>>โสตทัศนอุปกรณ์</option>
                                    <option value="งานอาคารสถานที่" <?= ($selectedCategory ?? '') === 'งานอาคารสถานที่' ? 'selected' : '' ?>>งานอาคารสถานที่</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label-custom" for="repair_detail">
                                    <i class="bx bx-message-square-detail"></i>รายละเอียดอาการเสีย / ปัญหาที่พบ <span class="text-danger ms-1">*</span>
                                </label>
                                <textarea id="repair_detail" name="repair_detail" class="form-control" style="height: 110px; border-radius: 10px; border-color: #d9dee3; padding: 0.75rem 1rem; font-size: 0.92rem;" placeholder="อธิบายอาการเสีย หรือปัญหาที่เกิดขึ้นอย่างละเอียด เพื่อให้เจ้าหน้าที่เตรียมเครื่องมือได้ตรงจุด..." required></textarea>
                            </div>

                            <div class="col-12"><div class="section-divider" style="margin: 0.5rem 0;"></div></div>

                            <!-- Step 2: Location -->
                            <div class="col-12">
                                <label class="small text-primary fw-bold mb-3 d-block"><i class="bx bx-map-pin me-1"></i>ระบุสถานที่และห้องที่เกิดปัญหา</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label-custom" for="repair_building">
                                            <i class="bx bx-building"></i>อาคาร <span class="text-danger ms-1">*</span>
                                        </label>
                                        <select name="repair_building" id="repair_building" class="form-select" required>
                                            <option value="" selected disabled>-- เลือกอาคาร --</option>
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
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-custom" for="repair_class">
                                            <i class="bx bx-layer"></i>ชั้นที่ <span class="text-danger ms-1">*</span>
                                        </label>
                                        <select name="repair_class" id="repair_class" class="form-select" required>
                                            <option value="" selected disabled>-- เลือกชั้น --</option>
                                            <option value="1">ชั้น 1</option>
                                            <option value="2">ชั้น 2</option>
                                            <option value="3">ชั้น 3</option>
                                            <option value="4">ชั้น 4</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-custom" for="repair_room">
                                            <i class="bx bx-door-open"></i>ชื่อห้อง / เลขห้อง
                                        </label>
                                        <input type="text" class="form-control form-control-custom" name="repair_room" id="repair_room" placeholder="เช่น 421 หรือ ห้องพักครู">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12"><div class="section-divider" style="margin: 0.5rem 0;"></div></div>

                            <!-- Step 3: Requester Info -->
                            <div class="col-12">
                                <label class="small text-primary fw-bold mb-3 d-block"><i class="bx bx-user-pin me-1"></i>ข้อมูลผู้แจ้งซ่อม</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-custom" for="repair_posi">
                                            <i class="bx bx-id-card"></i>กลุ่มสาระ / ตำแหน่งผู้ใช้งาน <span class="text-danger ms-1">*</span>
                                        </label>
                                        <select name="repair_posi" id="repair_posi" class="form-select" required>
                                            <option value="" selected disabled>-- เลือกกลุ่มสาระ/ตำแหน่ง --</option>
                                            <?php foreach ($Posi as $v_Posi) :?>
                                            <option value="<?=$v_Posi->posi_id?>"><?=$v_Posi->posi_name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-custom" for="repair_userID">
                                            <i class="bx bx-user"></i>รายชื่อผู้แจ้งซ่อม <span class="text-danger ms-1">*</span>
                                        </label>
                                        <select name="repair_userID" id="repair_userID" class="form-select" required disabled>
                                            <option value="" selected disabled>-- เลือกกลุ่มสาระ/ตำแหน่งก่อน --</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-custom" for="repair_phone">
                                            <i class="bx bx-phone"></i>เบอร์โทรศัพท์ติดต่อกลับ <span class="text-danger ms-1">*</span>
                                        </label>
                                        <input type="text" class="form-control form-control-custom" name="repair_phone" id="repair_phone" placeholder="เช่น 0812345678" required>
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
                                <i class="bx bx-camera me-2 fs-4"></i> ส่วนที่ 3: รูปภาพประกอบ
                            </div>
                            <div class="card-body-premium">
                                <p class="small text-muted mb-3">แนบรูปภาพเพื่อประกอบการพิจารณา (สูงสุด 3 รูป)</p>
                                <div class="row g-2">
                                    <?php for($i=0; $i<3; $i++): ?>
                                    <div class="col-12">
                                        <div class="upload-zone p-2 h-100 d-flex flex-column align-items-center justify-content-center" onclick="triggerFileInput(<?=$i?>)">
                                            <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2216%22%20height%3D%229%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f8f9fa%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22sans-serif%22%20font-size%3D%221%22%20fill%3D%22%23dee2e6%22%20text-anchor%3D%22middle%22%20dy%3D%22.3em%22%3E16:9%3C/text%3E%3C/svg%3E" id="imageResult<?=$i?>" class="img-fluid rounded mb-1" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
                                            <span class="x-small text-muted" style="font-size: 0.7rem;">รูปที่ <?=$i+1?> (คลิกเพื่อถ่ายภาพ / อัปโหลด)</span>
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
                                <i class="bx bx-pencil me-2 fs-4"></i> ส่วนที่ 4: ลายเซ็นผู้แจ้งซ่อม
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
                                    <p class="small text-secondary fw-bold text-uppercase mb-2">การยืนยันความถูกต้อง (Captcha)</p>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <div class="captcha-badge" data-answer="<?=$num1 + $num2?>"><?=$num1?> + <?=$num2?></div>
                                        <div class="fs-4 fw-bold text-muted">=</div>
                                        <input type="number" class="form-control text-center fw-bold fs-4" id="captcha_input" name="captcha_input" placeholder="?" required style="width: 90px; height: 56px; border-radius: 10px;">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-submit-premium w-100 disabled" id="BtnSubRepair" disabled>
                                    <span id="btnSaveText"><i class="bx bx-paper-plane me-2"></i> บันทึกแจ้งซ่อม</span>
                                    <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status"></span>
                                </button>
                                <a href="<?=base_url('Repair')?>" class="btn btn-link w-100 mt-2 text-muted">
                                    <i class='bx bx-arrow-back me-1'></i> ยกเลิกและย้อนกลับ
                                </a>
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

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#FormAddRepair select').select2({
            width: '100%'
        });
    });
</script>
<?= $this->endSection() ?>
