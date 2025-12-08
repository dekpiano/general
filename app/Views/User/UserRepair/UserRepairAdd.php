<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-label-primary border-0 text-white overflow-hidden wave-bg">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-0 text-primary"><i class="bx bx-wrench me-2"></i>แจ้งซ่อม/แจ้งปัญหา</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-style1 mb-0 mt-2">
                                    <li class="breadcrumb-item">
                                        <a href="<?=base_url('Repair')?>" class="text-primary">หน้าหลัก</a>
                                    </li>
                                    <li class="breadcrumb-item active text-muted">บันทึกข้อมูล</li>
                                </ol>
                            </nav>
                        </div>
                        <img src="<?=base_url('assets/img/illustrations/man-with-laptop-light.png')?>" alt="Repair" class="d-none d-md-block" style="height: 100px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="FormAddRepair" enctype="multipart/form-data" class="needs-validation" novalidate>
        
        <div class="row">
            <!-- Left Column: Form Data -->
            <div class="col-lg-8">
                
                <!-- Card 1: Requester & Location -->
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <h5 class="card-title text-primary mb-0"><i class="bx bx-user-pin me-2"></i>ข้อมูลผู้แจ้งและสถานที่</h5>
                    </div>
                    <div class="card-body pt-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="repair_date" value="<?=$Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')))?>" readonly>
                                    <label for="repair_date">วันที่แจ้งซ่อม</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="repair_phone" id="repair_phone" placeholder="เบอร์โทรติดต่อ" required>
                                    <label for="repair_phone">เบอร์โทรติดต่อ <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating form-floating-custom">
                                    <select name="repair_posi" id="repair_posi" class="form-select" required>
                                        <option value="" selected disabled></option>
                                        <?php foreach ($Posi as $v_Posi) :?>
                                        <option value="<?=$v_Posi->posi_id?>"><?=$v_Posi->posi_name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="repair_posi">ตำแหน่ง <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-custom">
                                    <select name="repair_userID" id="repair_userID" class="form-select" required>
                                        <option value="" selected disabled></option>
                                    </select>
                                    <label for="repair_userID">ชื่อผู้แจ้งซ่อม <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            
                            <hr class="my-4 text-muted">
                            
                            <div class="col-md-4">
                                <div class="form-floating form-floating-custom">
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
                                <div class="form-floating form-floating-custom">
                                    <select name="repair_class" id="repair_class" class="form-select" required>
                                        <option value="" selected disabled></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                    <label for="repair_class">ชั้น <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="repair_room" id="repair_room" placeholder="Ex. 421">
                                    <label for="repair_room">ห้อง (ระบุหมายเลข)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Problem Details -->
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <h5 class="card-title text-primary mb-0"><i class="bx bx-error-circle me-2"></i>รายละเอียดปัญหา</h5>
                    </div>
                    <div class="card-body pt-4">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-custom">
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
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea id="repair_detail" name="repair_detail" class="form-control" style="height: 100px" placeholder="ระบุอาการ" required></textarea>
                                    <label for="repair_detail">ปัญหา / อาการ / หมายเหตุ <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- Right Column: Evidence & Actions -->
            <div class="col-lg-4">
                
                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <h5 class="card-title text-primary mb-0"><i class="bx bx-camera me-2"></i>รูปภาพ (ถ้ามี)</h5>
                    </div>
                    <div class="card-body pt-4">
                         <div class="bg-label-secondary rounded p-3 text-center mb-3">
                            <img src="<?=base_url('assets/img/icons/uni-comp.png')?>" id="imageResult" class="img-fluid rounded" style="max-height: 150px; opacity: 0.8;">
                        </div>
                        <input type="file" class="form-control mb-2" id="repair_imguser" name="repair_imguser" 
                               onchange="document.getElementById('imageResult').src = window.URL.createObjectURL(this.files[0])">
                       <small class="text-muted d-block text-center">*รองรับไฟล์ jpg, png, jpeg</small>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <h5 class="card-title text-primary mb-0"><i class="bx bx-pen me-2"></i>ลายเซ็นผู้แจ้ง</h5>
                    </div>
                    <div class="card-body pt-4">
                        <div class="border rounded p-0 text-center bg-white mb-2 overflow-hidden">
                            <canvas id="signature-pad" class="w-100" style="touch-action: none;"></canvas>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger w-100" id="clear">
                            <i class="bx bx-refresh me-1"></i>ล้างลายเซ็น
                        </button>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-bottom-0 pb-0">
                        <h5 class="card-title text-primary mb-0"><i class="bx bx-shield-quarter me-2"></i>ตรวจสอบความปลอดภัย</h5>
                    </div>
                    <div class="card-body pt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-label-primary p-3 rounded me-3 text-center" style="min-width: 120px;">
                                <span class="fw-bold fs-4 text-nowrap"><?=$num1?> + <?=$num2?> = ?</span>
                            </div>
                            <div class="form-floating flex-grow-1">
                                <input type="number" class="form-control" id="captcha_input" name="captcha_input" placeholder="คำตอบ" required>
                                <label for="captcha_input">กรอกผลลัพธ์ตัวเลข</label>
                            </div>
                        </div>
                        <div class="form-text">กรุณาบวกเลขที่เห็นและกรอกคำตอบลงในช่องว่าง</div>
                    </div>
                </div>

                 <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" id="BtnSubRepair">
                            <span id="btnSaveText"><i class="bx bx-save me-1"></i> บันทึกแจ้งซ่อม</span>
                            <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('customCSS') ?>
<style>
    /* Sneat Admin Pattern for Select2 Floating Label */
    
    .form-floating-custom {
        position: relative;
    }

    /* Reset Height & Padding for Base Select Element */
    .form-floating-custom .form-control,
    .form-floating-custom .form-select {
        height: calc(3.5rem + 2px) !important;
        padding: 0 !important;
    }

    /* Label Styling - Matching Sneat .form-floating > label */
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
        color: rgba(67, 89, 113, 0.6); /* Text Muted Color in Sneat */
        z-index: 2;
    }

    /* Floating State Transform */
    .form-floating-custom.is-filled label,
    .form-floating-custom.is-focused label {
        opacity: .65;
        transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
    }

    /* Select2 Selection Container */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: calc(3.5rem + 2px);
        padding-top: 1.625rem !important;
        padding-bottom: 0.625rem !important;
        padding-left: 0.75rem !important;
        background-color: #fff; /* Sneat uses white bg for inputs by default */
        border: 1px solid #d9dee3; /* Sneat Border Color */
        border-radius: 0.375rem;
        font-size: 1rem;
        font-weight: 400;
        color: #566a7f;
        display: block;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    /* Focus State - Sneat Primary Color Shadow */
    .form-floating-custom.is-focused .select2-container--bootstrap-5 .select2-selection {
        border-color: #696cff;
        box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.25);
    }

    /* Rendered Text */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        color: #566a7f; /* Sneat Body Text Color */
        padding: 0;
        line-height: 1.25;
        margin-top: 0;
        font-weight: 400;
    }

    /* Hide Default Placeholder */
    .select2-container--bootstrap-5 .select2-selection__placeholder {
        color: transparent !important;
    }
    
    /* Hide Text if Empty (Show only Label) */
    .form-floating-custom:not(.is-filled):not(.is-focused) .select2-selection__rendered {
        opacity: 0; 
    }
    
    /* Arrow Customization */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 50% !important;
        transform: translateY(-50%) !important;
        right: 0.75rem !important;
        height: auto;
        width: auto;
    }
    
    /* Arrow Icon (Sneat Style Chevron) - Optional Override */
    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow b {
        border-style: none; /* Remove default triangle */
        width: 1rem;
        height: 1rem;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23d9dee3' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 16px 12px;
        display: block;
        top: auto;
        left: auto;
        margin: 0;
    }
</style>
<?= $this->endSection() ?>
