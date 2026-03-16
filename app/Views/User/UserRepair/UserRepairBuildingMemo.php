<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    .memo-container {
        padding-top: 1.5rem;
        padding-bottom: 4rem;
    }
    .memo-header {
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
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .card-title-premium {
        background: rgba(105, 108, 255, 0.05);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(105, 108, 255, 0.1);
        color: var(--bs-primary);
        font-weight: 700;
        display: flex;
        align-items: center;
    }
    .card-body-premium {
        padding: 2rem;
    }
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

    /* A4 Preview Styles */
    .a4-preview-container {
        background-color: #e2e8f0;
        padding: 2rem;
        border-radius: 1.5rem;
        display: flex;
        justify-content: center;
        overflow-y: auto;
        max-height: 1200px;
    }

    /* Select2 Fixes */
    .select2-container--bootstrap-5 .select2-selection {
        min-height: calc(1.5em + 1rem + 2px) !important;
        padding: 0.5rem 0.875rem !important;
        border: 1px solid #d9dee3 !important;
        border-radius: 0.375rem !important;
        display: flex;
        align-items: center;
    }
    .select2-container--bootstrap-5 .select2-selection__rendered {
        padding: 0 !important;
        line-height: inherit !important;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #696cff !important;
        box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1) !important;
    }
    
    .a4-page {
        background: white;
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        color: #000;
        font-family: 'K2D', 'thsarabun', sans-serif;
        position: relative;
    }

    .a4-logo {
        width: 15mm;
        position: absolute;
        top: 20mm;
        left: 20mm;
    }

    .a4-title {
        text-align: center;
        font-size: 24pt;
        font-weight: bold;
        margin-bottom: 2rem;
    }

    .a4-content-table {
        width: 100%;
        margin-bottom: 0.5rem;
        font-size: 14pt;
    }

    .a4-content-table td {
        vertical-align: top;
        padding-bottom: 0.5rem;
        line-height: 1.5;
    }

    .a4-bold {
        font-weight: bold;
    }

    .a4-divider {
        border-bottom: 1px solid #000;
        margin: 1rem 0;
    }

    .a4-paragraph {
        text-indent: 40px;
        font-size: 14pt;
        margin-bottom: 1rem;
        line-height: 1.6;
        text-align: justify;
    }
    
    .a4-value {
        color: var(--bs-primary);
        font-style: italic;
        border-bottom: 1px dotted rgba(105, 108, 255, 0.5);
        padding: 0 5px;
    }

    .a4-signature-box {
        margin-top: 3rem;
        text-align: center;
        font-size: 14pt;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .a4-page {
            max-width: 100%;
            min-height: auto;
            transform: scale(0.9);
            transform-origin: top center;
        }
    }

</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 memo-container">
    
    <div class="memo-header">
        <div>
            <h2 class="mb-1 text-white">สร้างบันทึกข้อความ (งานอาคารสถานที่)</h2>
            <p class="mb-0 text-white-50">กรอกข้อมูลเพื่อสร้างแบบฟอร์มบันทึกข้อความราชการ ขอซ่อมแซมอาคารสถานที่</p>
        </div>
        <i class="bx bx-file text-white opacity-50 display-1"></i>
    </div>

    <form action="<?= base_url('Repair/BuildingMemo/Print') ?>" method="post" enctype="multipart/form-data" target="_blank">
        <input type="hidden" name="repair_order" value="<?= $repair_order ?? '' ?>">
        <div class="row g-4">
            
            <!-- Left Column: Form Setup -->
            <div class="col-xl-5 col-lg-6">
                
                <div class="form-glass-card mb-4">
                    <div class="card-title-premium">
                        <i class="bx bx-edit-alt me-2 fs-4"></i> ข้อมูลบันทึกข้อความ
                    </div>
                    <div class="card-body-premium">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">ส่วนราชการ</label>
                                <input type="text" class="form-control" name="memo_agency" id="input_agency" value="<?= $memo_data_db['memo_agency'] ?? 'กลุ่มบริหารทั่วไป งานอาคารสถานที่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์' ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ที่ (เลขที่หนังสือ)</label>
                                <input type="text" class="form-control" name="memo_no" id="input_no" value="<?= $memo_data_db['memo_no'] ?? '' ?>" placeholder="เว้นว่างได้">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">วันที่</label>
                                <input type="text" class="form-control" name="memo_date" id="input_date" value="<?= $memo_data_db['memo_date'] ?? $Datethai->thai_date_fullmonth(strtotime(date('Y-m-d'))) ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">เรื่อง</label>
                                <input type="text" class="form-control" name="memo_subject" id="input_subject" value="<?= $memo_data_db['memo_subject'] ?? 'ขออนุมัติซ่อมแซมอาคารสถานที่' ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">เรียน</label>
                                <input type="text" class="form-control" name="memo_to" id="input_to" value="<?= $memo_data_db['memo_to'] ?? 'ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์' ?>" required>
                            </div>

                            <div class="col-12"><hr class="my-2"></div>

                            <div class="col-12">
                                <label class="form-label">สิ่งที่ต้องทำการซ่อมแซม / บริเวณสถานที่ <span class="text-danger">*</span></label>
                                <?php 
                                    $default_loc = '';
                                    if(isset($repair_info)) {
                                        $default_loc = ($repair_info['repair_building'] ?? '') . ' ชั้น ' . ($repair_info['repair_class'] ?? '') . ' ห้อง ' . ($repair_info['repair_room'] ?? '');
                                    }
                                ?>
                                <input type="text" class="form-control" name="memo_location" id="input_location" value="<?= $memo_data_db['memo_location'] ?? $default_loc ?>" placeholder="เช่น บริเวณห้องน้ำหญิง อาคาร 1 ชั้น 2" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">รายละเอียดปัญหา / สาเหตุความจำเป็น <span class="text-danger">*</span></label>
                                <textarea name="memo_reason" id="input_reason" class="form-control" rows="3" placeholder="ระบุอาการชำรุดเสียหาย และเหตุผลที่ต้องทำการซ่อมแซม" required><?= $memo_data_db['memo_reason'] ?? ($repair_info['repair_detail'] ?? '') ?></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">ประมาณการค่าใช้จ่าย (บาท)</label>
                                <input type="text" class="form-control" name="memo_budget" id="input_budget" value="<?= $memo_data_db['memo_budget'] ?? '' ?>" placeholder="หากยังไม่ทราบสามารถเว้นว่างได้ หรือระบุเป็นตัวเลข">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-glass-card mb-4">
                    <div class="card-title-premium">
                        <i class="bx bx-user me-2 fs-4"></i> ข้อมูลผู้แจ้งซ่อม
                    </div>
                    <div class="card-body-premium">
                        <div class="mb-3">
                            <label class="form-label">ตำแหน่ง <span class="text-danger">*</span></label>
                            <?php
                                $d_posi = $memo_data_db['memo_posi'] ?? ($repair_info['repair_posi'] ?? '');
                            ?>
                            <select name="memo_posi" id="input_posi" class="form-select" required>
                                <option value="" <?= empty($d_posi)?'selected':'' ?> disabled>-- เลือกตำแหน่ง --</option>
                                <?php foreach ($Posi as $v) :?>
                                <option value="<?=$v->posi_id?>" <?= ($d_posi==$v->posi_name || $d_posi==$v->posi_id)?'selected':'' ?> ><?=$v->posi_name?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">ชื่อ - นามสกุล ผู้แจ้ง <span class="text-danger">*</span></label>
                            <?php $d_fullname = $memo_data_db['memo_fullname'] ?? (isset($repair_pers) ? ($repair_pers['pers_prefix'].$repair_pers['pers_firstname'].' '.$repair_pers['pers_lastname']) : ''); ?>
                            <select name="memo_fullname" id="input_fullname" class="form-select" required <?= empty($d_fullname)?'disabled':'' ?>>
                                <?php if(empty($d_fullname)): ?>
                                    <option value="" selected disabled>-- กรุณาเลือกตำแหน่งก่อน --</option>
                                <?php else: ?>
                                    <option value="<?= $d_fullname ?>" selected><?= $d_fullname ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-glass-card mb-4">
                    <div class="card-title-premium">
                        <i class="bx bx-image me-2 fs-4"></i> รูปภาพประกอบ (ถ้ามี)
                    </div>
                    <div class="card-body-premium">
                        <div class="alert alert-warning mb-3" role="alert">
                            <i class="bx bx-info-circle me-1"></i> รูปภาพที่อัปโหลดจะถูกนำไปแสดงในหน้าถัดไปของ PDF โดยอัตโนมัติ
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รูปภาพที่ 1</label>
                            <input class="form-control" type="file" name="memo_image1" accept="image/*">
                        </div>
                        <div>
                            <label class="form-label">รูปภาพที่ 2</label>
                            <input class="form-control" type="file" name="memo_image2" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-submit-premium w-100 mb-2">
                        <i class="bx bxs-file-pdf me-2"></i> สร้างเอกสาร PDF พร้อมพิมพ์
                    </button>
                    <a href="<?= base_url('Repair/Add') ?>" class="btn btn-outline-secondary w-100">ย้อนกลับไปแจ้งซ่อมระบบปกติ</a>
                </div>

            </div>
            
            <!-- Right Column: Live A4 Preview -->
            <div class="col-xl-7 col-lg-6 d-none d-lg-block">
                <div class="a4-preview-container">
                    <div class="a4-page">
                        <img src="<?= base_url('uploads/krut/krut-1.5-cm.png') ?>" alt="Garuda Logo" class="a4-logo">
                        <div class="a4-title">บันทึกข้อความ</div>
                        
                        <table class="a4-content-table">
                            <tr>
                                <td width="15%" class="a4-bold">ส่วนราชการ</td>
                                <td width="85%" colspan="3" id="prev_agency" class="a4-value">กลุ่มบริหารทั่วไป งานอาคารสถานที่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</td>
                            </tr>
                            <tr>
                                <td class="a4-bold">ที่</td>
                                <td width="35%" id="prev_no" class="a4-value text-muted">.........................................................</td>
                                <td width="10%" class="a4-bold">วันที่</td>
                                <td width="40%" id="prev_date" class="a4-value"><?= $Datethai->thai_date_fullmonth(strtotime(date('Y-m-d'))) ?></td>
                            </tr>
                            <tr>
                                <td class="a4-bold">เรื่อง</td>
                                <td colspan="3" id="prev_subject" class="a4-value">ขออนุมัติซ่อมแซมอาคารสถานที่</td>
                            </tr>
                        </table>

                        <div class="a4-divider"></div>

                        <table class="a4-content-table">
                            <tr>
                                <td width="10%" class="a4-bold">เรียน</td>
                                <td width="90%" id="prev_to" class="a4-value">ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</td>
                            </tr>
                        </table>

                        <div class="mt-4">
                            <p class="a4-paragraph">
                                ด้วยงานอาคารสถานที่ กลุ่มบริหารทั่วไป ได้รับแจ้งปัญหา/ความชำรุดเสียหายบริเวณ 
                                <span id="prev_location" class="a4-value text-muted">................................................</span> 
                                เนื่องจาก <span id="prev_reason" class="a4-value text-muted">....................................................................................</span>
                            </p>

                            <p class="a4-paragraph">
                                ในการนี้ เพื่อให้การจัดการเรียนการสอนและกิจกรรมของโรงเรียนดำเนินไปได้ด้วยความเรียบร้อย และป้องกันไม่ให้เกิดความเสียหายมากขึ้น 
                                จึงขออนุมัติดำเนินการซ่อมแซมจุดดังกล่าว 
                                <span id="prev_budget_container" style="display: none;">
                                    โดยมีประมาณการค่าใช้จ่ายเบื้องต้นจำนวนทั้งสิ้น <span id="prev_budget" class="a4-value font-bold"></span> บาท
                                </span>
                            </p>
                            
                            <p class="a4-paragraph mt-4">
                                จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ
                            </p>
                        </div>

                        <div class="row mt-5">
                            <div class="col-6 offset-6 a4-signature-box">
                                <p>ลงชื่อ..............................................................</p>
                                <p>(<span id="prev_fullname" class="a4-value"><?= !empty($d_fullname) ? $d_fullname : '........................................' ?></span>)</p>
                                <p><span id="prev_posi" class="a4-value text-muted">ตำแหน่ง................................</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2
        $('#input_posi').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: "-- เลือกตำแหน่ง --"
        });
        
        $('#input_fullname').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: "-- กรุณาเลือกตำแหน่งก่อน --"
        });

        // Sync function helper
        // Sync function helper
        function syncInput(inputId, previewId, placeholderTxt) {
            const $input = $('#' + inputId);
            const $preview = $('#' + previewId);
            
            if(!$input.length || !$preview.length) return;

            const updatePreview = () => {
                let val = '';
                if($input.is('select')) {
                    const selectedText = $input.find('option:selected').text();
                    if(selectedText && $input.val() !== "" && !selectedText.includes('--')) {
                        val = selectedText;
                    }
                } else {
                    val = $input.val().trim();
                }

                if(val === '') {
                    $preview.text(placeholderTxt).addClass('text-muted');
                } else {
                    $preview.text(val).removeClass('text-muted');
                }
            };

            // Setup listeners using jQuery to catch Select2 changes
            $input.on('input change select2:select', updatePreview);
            
            // Initial call
            updatePreview();
        }

        // Sync standard fields
        syncInput('input_agency', 'prev_agency', '.........................................................');
        syncInput('input_no', 'prev_no', '.........................................................');
        syncInput('input_date', 'prev_date', '.........................................................');
        syncInput('input_subject', 'prev_subject', '.........................................................');
        syncInput('input_to', 'prev_to', '.........................................................');
        syncInput('input_location', 'prev_location', '................................................');
        syncInput('input_reason', 'prev_reason', '....................................................................................');
        syncInput('input_fullname', 'prev_fullname', '........................................');
        syncInput('input_posi', 'prev_posi', 'ตำแหน่ง................................');

        // Ajax load user by position
        $('#input_posi').on('change', function() {
            const posiId = $(this).val();
            const posiName = $(this).find('option:selected').text();
            
            if (!posiId) return;

            // Update disabled list
            $('#input_fullname').prop('disabled', true)
                .html('<option value="" selected disabled>กำลังโหลด...</option>')
                .trigger('change.select2');

            $.post(
                "../Repair/DB/CheckPosiUser",
                { repair_posi: posiId },
                function(data) {
                    $('#input_fullname').prop('disabled', false).empty().append('<option value="" selected disabled>-- เลือกรายชื่อ --</option>');
                    
                    $.each(data, function(key, val) {
                        const fullName = val.pers_prefix + val.pers_firstname + " " + val.pers_lastname;
                        // Select matched user session if possible
                        const isMatch = (fullName === '<?= $d_fullname ?>') ? 'selected' : '';
                        
                        var option = `<option value="${fullName}" ${isMatch}>${fullName}</option>`;
                        $('#input_fullname').append(option);
                    });
                    
                    // Trigger change to update preview and select2
                    $('#input_fullname').trigger('change').trigger('change.select2');
                },
                "json"
            );
        });

        // Trigger initial load if position is already selected
        if($('#input_posi').val()) {
            $('#input_posi').trigger('change');
        }

        // Special handler for budget
        const budgetInput = document.getElementById('input_budget');
        const budgetContainer = document.getElementById('prev_budget_container');
        const budgetPrev = document.getElementById('prev_budget');

        if(budgetInput && budgetContainer && budgetPrev) {
            budgetInput.addEventListener('input', function() {
                if(this.value.trim() !== '') {
                    budgetPrev.textContent = this.value;
                    budgetContainer.style.display = 'inline';
                } else {
                    budgetContainer.style.display = 'none';
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>
