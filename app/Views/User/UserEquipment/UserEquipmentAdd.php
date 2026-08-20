<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
    }

    .form-glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(105, 108, 255, 0.08);
    }

    .type-select-btn {
        border: 2px solid #e7e7ff;
        border-radius: 1.25rem;
        padding: 1.25rem 1rem;
        cursor: pointer;
        transition: all 0.25s ease;
        text-align: center;
        background: #fff;
    }

    .type-select-btn.active, .type-select-btn:hover {
        border-color: #696cff;
        background: rgba(105, 108, 255, 0.06);
        box-shadow: 0 6px 20px rgba(105, 108, 255, 0.15);
    }

    .item-row {
        background: #f8f9fc;
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border: 1px solid #edf2f7;
    }

    .section-title {
        color: #696cff;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit-purple {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 700;
        box-shadow: 0 6px 20px rgba(105, 108, 255, 0.35);
        transition: all 0.3s ease;
    }

    .btn-submit-purple:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(105, 108, 255, 0.45);
    }

    .captcha-badge {
        background: #f0f2ff;
        color: #696cff;
        font-size: 1.4rem;
        font-weight: 800;
        padding: 0.5rem 1.25rem;
        border-radius: 0.75rem;
        border: 2px dashed rgba(105, 108, 255, 0.25);
        letter-spacing: 2px;
    }

    /* --- Drag and Drop Upload Zone --- */
    .dropzone-box {
        border: 2px dashed #b4b7ff;
        border-radius: 1.25rem;
        background: #fbfbfe;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative;
    }

    .dropzone-box:hover, .dropzone-box.dragover {
        border-color: #696cff;
        background: rgba(105, 108, 255, 0.05);
        box-shadow: 0 6px 20px rgba(105, 108, 255, 0.12);
        transform: translateY(-1px);
    }

    .dropzone-box .upload-icon {
        font-size: 3rem;
        color: #696cff;
        margin-bottom: 0.5rem;
        transition: transform 0.25s ease;
    }

    .dropzone-box:hover .upload-icon {
        transform: scale(1.1);
    }

    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 12px;
        margin-top: 1rem;
    }

    .preview-item {
        position: relative;
        border-radius: 1rem;
        overflow: hidden;
        aspect-ratio: 1/1;
        box-shadow: 0 4px 12px rgba(105, 108, 255, 0.12);
        border: 2px solid #e7e7ff;
        background: #fff;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-remove-btn {
        position: absolute;
        top: 6px;
        right: 6px;
        background: rgba(255, 62, 29, 0.85);
        color: #fff;
        border: none;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 1rem;
    }

    .preview-remove-btn:hover {
        background: #ff3e1d;
        transform: scale(1.15);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><span class="text-muted fw-light">พัสดุอุปกรณ์ /</span> ยื่นคำขอยืม</h4>
            <p class="text-muted mb-0">กรอกแบบฟอร์มเพื่อขอยืมอุปกรณ์สำหรับใช้งานภายในหรือหน่วยงานภายนอก</p>
        </div>
        <a href="<?= base_url('Equipment') ?>" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bx bx-arrow-back me-1"></i> กลับหน้ารายการ
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card form-glass-card p-4">
                <form id="formBorrowEquipment" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- 1. เลือกประเภทผู้ยืม -->
                    <?php 
                    $session = session();
                    $isLoggedIn = !empty($session->get('id')) || !empty($session->get('logged_in'));
                    
                    // ดึงข้อมูลบุคลากรจากฐานข้อมูล skjacth_personnel + skjacth_skj.tb_learning
                    $defaultName = $session->get('fullname') ?? '';
                    $defaultTel  = $userPersonnel['pers_phone'] ?? ($session->get('tel') ?? '');
                    $defaultOrg  = $userPersonnel['lear_namethai'] ?? ($userPersonnel['pers_learning'] ?? ($session->get('department') ?? ($session->get('group') ?? '')));
                    
                    if (!empty($userPersonnel)) {
                        $defaultName = $userPersonnel['pers_prefix'] . $userPersonnel['pers_firstname'] . ' ' . $userPersonnel['pers_lastname'];
                    }
                    ?>
                    
                    <h5 class="section-title mb-3"><i class="bx bx-user-pin"></i>1. ประเภทผู้ขอยืม</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="type-select-btn <?= $isLoggedIn ? 'active' : '' ?>" id="btnTypeInternal" onclick="selectBorrowerType('internal')">
                                <i class="bx bx-buildings text-primary" style="font-size: 2.5rem;"></i>
                                <h6 class="fw-bold mt-2 mb-1 text-dark">บุคลากรภายในโรงเรียน</h6>
                                <small class="text-muted">ครู, เจ้าหน้าที่, บุคลากรสังกัด สกจ. (ต้องเข้าสู่ระบบ)</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="type-select-btn <?= !$isLoggedIn ? 'active' : '' ?>" id="btnTypeExternal" onclick="selectBorrowerType('external')">
                                <i class="bx bx-world text-info" style="font-size: 2.5rem;"></i>
                                <h6 class="fw-bold mt-2 mb-1 text-dark">หน่วยงาน / บุคคลภายนอก</h6>
                                <small class="text-muted">ชุมชน, หน่วยงานราชการ, องค์กรภายนอก (ไม่ต้องล็อกอิน)</small>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="borrower_type" id="borrower_type" value="<?= $isLoggedIn ? 'internal' : 'external' ?>">

                    <?php if (!$isLoggedIn): ?>
                    <!-- กล่องแจ้งเตือนบุคลากรภายในที่ยังไม่ล็อกอิน -->
                    <div id="internalLoginAlert" class="alert alert-warning border-0 shadow-sm rounded-4 mb-4 p-3 <?= $isLoggedIn ? 'd-none' : '' ?>">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <i class="bx bx-lock-alt text-warning fs-2"></i>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">สำหรับบุคลากรภายในโรงเรียน</h6>
                                    <small class="text-muted">กรุณาเข้าสู่ระบบด้วยบัญชี Google โรงเรียน (@skj.ac.th) เพื่อยื่นคำขอยืม</small>
                                </div>
                            </div>
                            <a href="<?= base_url('Auth/login?return_to=' . urlencode(current_url())) ?>" class="btn btn-primary rounded-pill px-4">
                                <i class="bx bx-log-in me-1"></i> เข้าสู่ระบบบุคลากร
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- 2. ข้อมูลผู้ขอยืม -->
                    <h5 class="section-title mb-3"><i class="bx bx-id-card"></i>2. ข้อมูลผู้ยืมและหน่วยงาน</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">ชื่อ-นามสกุล ผู้ขอยืม <span class="text-danger">*</span></label>
                            <input type="text" name="borrower_name" id="borrower_name" class="form-control rounded-3" value="<?= esc($defaultName) ?>" <?= ($isLoggedIn ? 'readonly' : '') ?> required placeholder="ระบุชื่อ-นามสกุล">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" id="labelOrg"><?= $isLoggedIn ? 'กลุ่มสาระการเรียนรู้ / ฝ่ายงาน' : 'ชื่อหน่วยงาน / องค์กรภายนอก' ?> <span class="text-danger">*</span></label>
                            <input type="text" name="borrower_org" id="borrower_org" class="form-control rounded-3" value="<?= esc($defaultOrg) ?>" required placeholder="เช่น กลุ่มสาระฯ วิทยาศาสตร์ หรือ อบต. / เทศบาล">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">เบอร์โทรศัพท์ติดต่อ <span class="text-danger">*</span></label>
                            <input type="tel" name="borrower_tel" id="borrower_tel" class="form-control rounded-3" value="<?= esc($defaultTel) ?>" required placeholder="เช่น 0812345678">
                        </div>

                        <!-- ฟิลด์อัปโหลดภาพถ่ายประกอบการยืม (เฉพาะรูปภาพเท่านั้น สูงสุด 5 รูป) -->
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-semibold mb-0" id="labelDoc">📷 แนบรูปภาพประกอบการยืม (ถ้ามี)</label>
                                <span class="badge bg-label-primary rounded-pill" id="photoCountBadge">0 / 5 รูป</span>
                            </div>
                            <div class="dropzone-box" id="docDropzone" onclick="document.getElementById('doc_ref_file').click()">
                                <i class="bx bx-image-add upload-icon"></i>
                                <h6 class="fw-bold mb-1 text-dark">คลิกเพื่อเลือกรูปภาพ หรือลากรูปมาวางที่นี่</h6>
                                <p class="text-muted small mb-0">รองรับเฉพาะไฟล์รูปภาพ (JPG, PNG, JPEG, WEBP) สูงสุด 5 รูป</p>
                                <input type="file" name="doc_ref_file[]" id="doc_ref_file" class="d-none" accept="image/*" multiple>
                            </div>
                            
                            <!-- กล่องแสดงตัวอย่างรูปภาพหลายรูป (Multi-Image Preview Grid สูงสุด 5 รูป) -->
                            <div id="previewGrid" class="preview-grid d-none"></div>
                        </div>
                    </div>

                    <!-- 3. กำหนดวันและวัตถุประสงค์ (ปฏิทินไทย พ.ศ.) -->
                    <h5 class="section-title mb-3"><i class="bx bx-calendar-event"></i>3. วันเวลาและวัตถุประสงค์ (ปฏิทินไทย พ.ศ.)</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">วันที่ต้องการยืม (เริ่มใช้) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bx bx-calendar text-primary"></i></span>
                                <input type="text" name="borrow_date" id="borrow_date" class="form-control rounded-end-3 flatpickr-th" value="<?= date('Y-m-d') ?>" required placeholder="เลือกวันที่เริ่มยืม">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">กำหนดวันที่ส่งคืน <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bx bx-calendar-check text-danger"></i></span>
                                <input type="text" name="due_date" id="due_date" class="form-control rounded-end-3 flatpickr-th" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required placeholder="เลือกวันที่ส่งคืน">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">วัตถุประสงค์การใช้งาน <span class="text-danger">*</span></label>
                            <textarea name="purpose" class="form-control rounded-3" rows="2" required placeholder="ระบุกิจกรรมหรือโครงการที่นำไปใช้"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">สถานที่นำไปใช้งาน</label>
                            <textarea name="location" class="form-control rounded-3" rows="2" placeholder="เช่น หอประชุม อาคาร 2 หรือสถานที่จัดงาน"></textarea>
                        </div>
                    </div>

                    <!-- 4. รายการพัสดุอุปกรณ์ที่ต้องการยืม (พิมพ์ระบุได้เองอย่างอิสระ) -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="section-title mb-0 fs-6 fs-md-5"><i class="bx bx-cart"></i>4. รายการพัสดุ/อุปกรณ์ที่ต้องการยืม</h5>
                            <small class="text-muted d-none d-sm-inline">พิมพ์ระบุชื่อสิ่งของ จำนวน และหน่วยนับที่ต้องการยืม</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="addItemRow()">
                            <i class="bx bx-plus me-1"></i> เพิ่มรายการ
                        </button>
                    </div>

                    <div id="itemsContainer">
                        <?php if (!empty($preselectedItem)): ?>
                            <div class="item-row" id="row_0">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small fw-semibold">ชื่อพัสดุ / อุปกรณ์ <span class="text-danger">*</span></label>
                                        <input type="text" name="items[0][item_name]" class="form-control rounded-3" value="<?= esc($preselectedItem['eq_name']) ?>" required placeholder="เช่น โปรเจคเตอร์, โต๊ะพับ, ไมโครโฟนไร้สาย">
                                        <input type="hidden" name="items[0][eq_id]" value="<?= $preselectedItem['eq_id'] ?>">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small fw-semibold">จำนวน <span class="text-danger">*</span></label>
                                        <input type="number" name="items[0][qty]" class="form-control rounded-3" value="1" min="1" required>
                                    </div>
                                    <div class="col-4 col-md-2">
                                        <label class="form-label small fw-semibold">หน่วยนับ</label>
                                        <input type="text" name="items[0][item_unit]" class="form-control rounded-3" value="<?= esc($preselectedItem['eq_unit'] ?: 'ชิ้น') ?>" placeholder="เช่น ชิ้น, เครื่อง">
                                    </div>
                                    <div class="col-2 col-md-1 text-end">
                                        <label class="form-label d-block small">&nbsp;</label>
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle" onclick="removeRow(0)"><i class="bx bx-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="item-row" id="row_0">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label small fw-semibold">ชื่อพัสดุ / อุปกรณ์ <span class="text-danger">*</span></label>
                                        <input type="text" name="items[0][item_name]" class="form-control rounded-3" required placeholder="เช่น โปรเจคเตอร์, โต๊ะพับ, ไมค์ไร้สาย">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label class="form-label small fw-semibold">จำนวน <span class="text-danger">*</span></label>
                                        <input type="number" name="items[0][qty]" class="form-control rounded-3" value="1" min="1" required placeholder="จำนวน">
                                    </div>
                                    <div class="col-4 col-md-2">
                                        <label class="form-label small fw-semibold">หน่วยนับ</label>
                                        <input type="text" name="items[0][item_unit]" class="form-control rounded-3" value="ชิ้น" placeholder="เช่น ชิ้น, เครื่อง">
                                    </div>
                                    <div class="col-2 col-md-1 text-end">
                                        <label class="form-label d-block small">&nbsp;</label>
                                        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle" onclick="removeRow(0)"><i class="bx bx-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- 5. แคปช่ายืนยันความปลอดภัย (Math Captcha ป้องกันบอท) -->
                    <div class="card border-0 bg-light rounded-4 p-3 p-md-4 mt-4" id="captchaSection">
                        <div class="d-flex flex-column align-items-center text-center">
                            <span class="badge bg-white text-primary rounded-pill px-3 py-1 fw-bold mb-2 shadow-sm">
                                <i class="bx bx-shield-quarter me-1"></i> ระบบตรวจสอบความปลอดภัย
                            </span>
                            <h6 class="fw-bold text-dark mb-1">กรุณากรอกผลบวกตัวเลขเพื่อยืนยันตัวตน</h6>
                            <p class="text-muted small mb-3">คำนวณผลบวกตัวเลขด้านล่างเพื่อป้องกันการส่งข้อมูลอัตโนมัติ (บอท/สแปม)</p>
                            
                            <div class="d-flex align-items-center justify-content-center gap-2 gap-md-3 flex-wrap">
                                <div class="captcha-badge" id="captchaQuestion">
                                    <?= ($num1 ?? 3) ?> + <?= ($num2 ?? 4) ?>
                                </div>
                                <div class="fs-4 fw-bold text-dark">=</div>
                                <input type="number" class="form-control text-center fw-bold fs-5 rounded-3" 
                                       id="captcha_input" name="captcha_input" 
                                       placeholder="?" required style="width: 90px; height: 50px;">
                                <input type="hidden" name="captcha_answer" value="<?= (($num1 ?? 3) + ($num2 ?? 4)) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4 mt-md-5">
                        <button type="submit" class="btn btn-submit-purple btn-lg rounded-pill px-4 px-md-5 w-100 w-md-auto" id="btnSubmitBorrow">
                            <span class="btn-text"><i class="bx bx-paper-plane me-1"></i> ยืนยันการส่งคำขอยืม</span>
                            <span class="btn-loading d-none">
                                <span class="spinner-border spinner-border-sm me-2"></span>กำลังประมวลผล...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<!-- ใช้ทั้ง customScripts และ scripts เพื่อให้ตรงกับโครงสร้าง inc_scripts.php -->
<?= $this->section('customScripts') ?>
<script>
    let rowIndex = 1;
    const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
    const availableEquipments = <?= json_encode($equipments ?? []) ?>;

    // ตั้งค่า Flatpickr ปฏิทินภาษาไทย พ.ศ.
    if (typeof flatpickr !== 'undefined') {
        flatpickr.localize(flatpickr.l10ns.th);
        const thaiDateConfig = {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            formatDate: (date, format, locale) => {
                let day = String(date.getDate()).padStart(2, '0');
                let month = String(date.getMonth() + 1).padStart(2, '0');
                let year = date.getFullYear() + 543;
                return `${day}/${month}/${year}`;
            }
        };
        flatpickr(".flatpickr-th", thaiDateConfig);
    }

    // Multi-Image Drag & Drop Handlers (สูงสุด 5 รูป)
    const docDropzone = document.getElementById('docDropzone');
    const docInput = document.getElementById('doc_ref_file');
    const previewGrid = document.getElementById('previewGrid');
    const photoCountBadge = document.getElementById('photoCountBadge');
    let selectedImageFiles = [];

    if (docDropzone && docInput) {
        ['dragenter', 'dragover'].forEach(eventName => {
            docDropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                docDropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            docDropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                docDropzone.classList.remove('dragover');
            });
        });

        docDropzone.addEventListener('drop', (e) => {
            const files = Array.from(e.dataTransfer.files);
            handleIncomingImages(files);
        });

        docInput.addEventListener('change', function() {
            const files = Array.from(this.files);
            handleIncomingImages(files);
        });
    }

    function handleIncomingImages(files) {
        const validImages = files.filter(file => file.type.startsWith('image/'));
        
        if (validImages.length < files.length) {
            Swal.fire('แจ้งเตือน', 'ระบบรองรับเฉพาะไฟล์รูปภาพเท่านั้น (JPG, PNG, JPEG, WEBP)', 'warning');
        }

        if (selectedImageFiles.length + validImages.length > 5) {
            Swal.fire('แจ้งเตือน', 'คุณสามารถเพิ่มรูปภาพได้สูงสุด 5 รูปเท่านั้น', 'warning');
        }

        validImages.forEach(file => {
            if (selectedImageFiles.length < 5) {
                selectedImageFiles.push(file);
            }
        });

        syncInputFilesAndRender();
    }

    function removeImageAt(index) {
        selectedImageFiles.splice(index, 1);
        syncInputFilesAndRender();
    }

    function syncInputFilesAndRender() {
        // Sync กับ input files ด้วย DataTransfer
        const dt = new DataTransfer();
        selectedImageFiles.forEach(file => dt.items.add(file));
        docInput.files = dt.files;

        // อัปเดตตัวนับ Badge
        if (photoCountBadge) {
            photoCountBadge.textContent = `${selectedImageFiles.length} / 5 รูป`;
        }

        // Render Previews
        previewGrid.innerHTML = '';
        if (selectedImageFiles.length === 0) {
            previewGrid.classList.add('d-none');
            return;
        }

        previewGrid.classList.remove('d-none');
        selectedImageFiles.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'preview-item';
                itemDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${idx + 1}">
                    <button type="button" class="preview-remove-btn" onclick="removeImageAt(${idx})" title="ลบรูปนี้">
                        <i class="bx bx-x"></i>
                    </button>
                `;
                previewGrid.appendChild(itemDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    function selectBorrowerType(type) {
        document.getElementById('borrower_type').value = type;
        const loginAlert = document.getElementById('internalLoginAlert');

        if (type === 'internal') {
            document.getElementById('btnTypeInternal').classList.add('active');
            document.getElementById('btnTypeExternal').classList.remove('active');
            document.querySelectorAll('.field-external').forEach(el => el.classList.add('d-none'));
            document.getElementById('labelOrg').innerHTML = 'กลุ่มสาระการเรียนรู้ / ฝ่ายงาน <span class="text-danger">*</span>';
            const labelDoc = document.getElementById('labelDoc');
            if (labelDoc) labelDoc.innerHTML = '📷 แนบรูปภาพถ่ายประกอบการยืม (ถ้ามี)';

            if (!isLoggedIn) {
                if (loginAlert) loginAlert.classList.remove('d-none');
                Swal.fire({
                    icon: 'info',
                    title: 'กรุณาเข้าสู่ระบบ',
                    text: 'สำหรับบุคลากรภายในโรงเรียน กรุณาเข้าสู่ระบบด้วยบัญชี Google (@skj.ac.th) เพื่อดำเนินการยื่นขอยืม',
                    showCancelButton: true,
                    confirmButtonText: 'เข้าสู่ระบบตอนนี้',
                    confirmButtonColor: '#696cff',
                    cancelButtonText: 'ยืมในนามภายนอกแทน'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('Auth/login?return_to=' . urlencode(current_url())) ?>';
                    } else {
                        selectBorrowerType('external');
                    }
                });
            } else {
                if (loginAlert) loginAlert.classList.add('d-none');
            }
        } else {
            document.getElementById('btnTypeExternal').classList.add('active');
            document.getElementById('btnTypeInternal').classList.remove('active');
            document.querySelectorAll('.field-external').forEach(el => el.classList.remove('d-none'));
            document.getElementById('labelOrg').innerHTML = 'ชื่อหน่วยงาน / องค์กรภายนอก <span class="text-danger">*</span>';
            const labelDoc = document.getElementById('labelDoc');
            if (labelDoc) labelDoc.innerHTML = '📷 แนบรูปภาพหนังสือขอความอนุเคราะห์ / ภาพถ่ายประกอบ';
            if (loginAlert) loginAlert.classList.add('d-none');
        }
    }

    function addItemRow() {
        const rowHtml = `
            <div class="item-row" id="row_${rowIndex}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">ชื่อพัสดุ / อุปกรณ์ <span class="text-danger">*</span></label>
                        <input type="text" name="items[${rowIndex}][item_name]" class="form-control rounded-3" required placeholder="เช่น เก้าอี้พลาสติก, ลำโพงพกพา, เต็นท์">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">จำนวน <span class="text-danger">*</span></label>
                        <input type="number" name="items[${rowIndex}][qty]" class="form-control rounded-3" value="1" min="1" required placeholder="จำนวน">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">หน่วยนับ</label>
                        <input type="text" name="items[${rowIndex}][item_unit]" class="form-control rounded-3" value="ชิ้น" placeholder="เช่น ตัว, อัน, ชุด">
                    </div>
                    <div class="col-md-1 text-end">
                        <label class="form-label d-block small">&nbsp;</label>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle" onclick="removeRow(${rowIndex})"><i class="bx bx-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('itemsContainer').insertAdjacentHTML('beforeend', rowHtml);
        rowIndex++;
    }

    function removeRow(idx) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length <= 1) {
            Swal.fire('แจ้งเตือน', 'ต้องมีรายการพัสดุอย่างน้อย 1 รายการ', 'warning');
            return;
        }
        const row = document.getElementById(`row_${idx}`);
        if (row) row.remove();
    }

    function handleItemChange(selectEl, idx) {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const maxQty = selectedOption.getAttribute('data-max') || 1;
        const qtyInput = document.getElementById(`qty_${idx}`) || selectEl.closest('.item-row').querySelector('input[type="number"]');
        if (qtyInput) {
            qtyInput.max = maxQty;
            if (parseInt(qtyInput.value) > parseInt(maxQty)) {
                qtyInput.value = maxQty;
            }
        }
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

    document.getElementById('formBorrowEquipment').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('btnSubmitBorrow');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Loading State
        submitBtn.disabled = true;
        if (btnText) btnText.classList.add('d-none');
        if (btnLoading) btnLoading.classList.remove('d-none');

        const formData = new FormData(this);
        formData.delete('doc_ref_file[]');
        
        for (let i = 0; i < selectedImageFiles.length; i++) {
            const file = selectedImageFiles[i];
            if (btnLoading) btnLoading.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>กำลังย่อรูป ${i + 1}/${selectedImageFiles.length}...`;
            
            if (file.type.startsWith('image/')) {
                const compressed = await compressImage(file);
                formData.append('doc_ref_file[]', compressed);
            } else {
                formData.append('doc_ref_file[]', file);
            }
        }
        
        if (btnLoading) btnLoading.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>กำลังบันทึกข้อมูล...`;

        fetch('<?= base_url('Equipment/insert') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'ยื่นคำขอสำเร็จ!',
                    text: data.message,
                    confirmButtonText: 'ดูประวัติการยืม',
                    confirmButtonColor: '#696cff'
                }).then(() => {
                    window.location.href = '<?= base_url('Equipment/History') ?>';
                });
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
