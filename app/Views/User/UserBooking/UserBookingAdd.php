<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    /* --- Premium Variables --- */
    :root {
        --booking-primary: #696cff;
        --booking-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --glass-bg: rgba(255, 255, 255, 0.9);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .premium-animate {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Page Header --- */
    .page-header {
        background: var(--booking-gradient);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 15px 40px -10px rgba(105, 108, 255, 0.3);
    }
    .header-content { position: relative; z-index: 2; }
    .page-header::before {
        content: ''; position: absolute; top: -50%; right: -10%; width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* --- Layout Elements --- */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(105, 108, 255, 0.1);
        overflow: hidden;
    }

    .location-preview-img {
        height: 220px;
        object-fit: cover;
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 20px -10px rgba(0,0,0,0.2);
    }

    .section-title {
        font-weight: 700;
        color: #32475c;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .section-title i { color: var(--booking-primary); }

    .schedule-item {
        padding: 12px;
        border-radius: 12px;
        background: #fff;
        margin-bottom: 10px;
        border: 1px solid rgba(105, 108, 255, 0.05);
        transition: transform 0.2s ease;
    }
    .schedule-item:hover { transform: scale(1.02); background: #f8faff; }

    /* --- Form Styling --- */
    .form-floating > .form-control:focus, 
    .form-floating > .form-select:focus {
        border-color: var(--booking-primary);
        box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1);
    }

    .btn-submit-booking {
        background: var(--booking-gradient);
        border: none;
        padding: 1rem;
        border-radius: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-submit-booking:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(105, 108, 255, 0.4);
        opacity: 0.9;
    }

    .equipment-check {
        background: #f8faff;
        border-radius: 10px;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .equipment-check:hover { background: #eff3ff; }

    /* --- Upload Zone --- */
    .upload-preview-container {
        border: 2px dashed var(--booking-primary);
        border-radius: 15px;
        padding: 1rem;
        text-align: center;
        background: rgba(105, 108, 255, 0.02);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .upload-preview-container:hover { background: rgba(105, 108, 255, 0.05); }
    #croppedCanvas { border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); max-width: 100%; }

    .alert-premium { border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Premium Header -->
    <div class="page-header premium-animate">
        <div class="header-content d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="<?=base_url('Booking');?>" class="text-white-50">สถานที่</a></li>
                        <li class="breadcrumb-item active text-white">แบบฟอร์มการจอง</li>
                    </ol>
                </nav>
                <h3 class="mb-0 fw-bold text-white">ขอใช้สถานที่: <?=$loca->location_name?></h3>
            </div>
            <i class='bx bxs-edit fs-1 text-white-50'></i>
        </div>
    </div>

    <div class="row g-4">
        <!-- Info Column -->
        <div class="col-lg-4 mb-4">
            <div class="glass-card p-3 premium-animate" style="animation-delay: 0.1s">
                <img src="<?=base_url('uploads/admin/LocationRoom/'.$loca->location_img)?>" 
                     class="location-preview-img mb-3" alt="<?=$loca->location_name?>"
                     onerror="this.src='<?= base_url('assets/img/elements/1.jpg') ?>'">
                
                <h5 class="fw-bold mb-2"><?=$loca->location_name?></h5>
                <p class="text-muted small mb-0"><?=$loca->location_detail?></p>

                <hr class="my-3 opacity-50">

                <div class="schedule-section">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <i class='bx bx-time-five me-2 text-primary'></i>
                        ตารางการจองวันนี้
                    </h6>
                    
                    <?php 
                    $hasBooking = false;
                    foreach ($BookignToday as $value) {
                        if(date('Y-m-d') >= $value->booking_dateStart && date('Y-m-d') <= $value->booking_dateEnd) {
                            $hasBooking = true;
                            break;
                        }
                    }
                    ?>

                    <?php if($hasBooking): ?>
                        <?php foreach ($BookignToday as $value):
                            if(date('Y-m-d') >= $value->booking_dateStart && date('Y-m-d') <= $value->booking_dateEnd): ?>
                            <div class="schedule-item">
                                <div class="fw-bold text-dark mb-1"><?=$value->booking_title?></div>
                                <div class="small text-primary">
                                    <i class='bx bx-time'></i> <?=$value->booking_timeStart?> - <?=$value->booking_timeEnd?> น.
                                </div>
                            </div>
                        <?php endif; endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-4 bg-light rounded-3 bg-opacity-50">
                            <i class='bx bx-calendar-check fs-1 text-success mb-2'></i>
                            <div class="text-muted small">ห้องว่าง สามารถจองได้ตลอดทั้งวัน</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="glass-card premium-animate" style="animation-delay: 0.2s">
                <div class="card-body p-lg-4 p-3">
                    <form id="FormAddBooking" class="needs-validation" novalidate action="<?=base_url('Booking/DB/Insert')?>" method="POST">
                        <input type="hidden" name="booking_order" value="<?=$BookLatest?>">
                        <input type="hidden" name="booking_locationroom" id="booking_locationroom" value="<?=$loca->location_ID?>">
                        <input type="hidden" id="booking_imgWork" name="booking_imgWork">

                        <h5 class="section-title"><i class='bx bx-detail'></i> ข้อมูลพื้นฐาน</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="form-floating h-100">
                                    <input type="text" class="form-control bg-light h-100" value="<?=$BookLatest?>" readonly disabled>
                                    <label>เลขที่การจอง</label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking_title" name="booking_title" placeholder="หัวข้อ" required>
                                    <label for="booking_title">หัวข้อการเข้าใช้งาน / วัตถุประสงค์</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" id="booking_number" name="booking_number" class="form-control" placeholder="จำนวนคน" required>
                                    <label for="booking_number">จำนวนผู้เข้าร่วม (ประมาณการ)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select" id="booking_typeuse" name="booking_typeuse" required>
                                        <option value="" disabled selected>-- เลือกประเภท --</option>
                                        <?php foreach (['ประชุม','อบรม','สัมนา','จัดเลี้ยง','จัดกิจกรรม'] as $type) : ?>
                                        <option value="<?=$type?>"><?=$type?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>ลักษณะงาน</label>
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title"><i class='bx bx-calendar'></i> วันและเวลา</h5>
                        <div class="row g-3 mb-2">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light bg-opacity-25">
                                    <label class="form-label text-primary fw-bold small">เริ่มปฏิบัติงาน</label>
                                    <div class="row g-2">
                                        <div class="col-7">
                                            <input class="form-control selector border-0 shadow-sm check-time" type="text" id="booking_dateStart" name="booking_dateStart" placeholder="วันที่" required value="<?= $selectedDate ?? '' ?>">
                                        </div>
                                        <div class="col-5">
                                            <input class="form-control selectorTime border-0 shadow-sm check-time" type="text" id="booking_timeStart" name="booking_timeStart" placeholder="เวลา" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light bg-opacity-25">
                                    <label class="form-label text-danger fw-bold small">สิ้นสุดปฏิบัติงาน</label>
                                    <div class="row g-2">
                                        <div class="col-7">
                                            <input class="form-control selector border-0 shadow-sm check-time" type="text" id="booking_dateEnd" name="booking_dateEnd" placeholder="วันที่" required value="<?= $selectedDate ?? '' ?>">
                                        </div>
                                        <div class="col-5">
                                            <input class="form-control selectorTime border-0 shadow-sm check-time" type="text" id="booking_timeEnd" name="booking_timeEnd" placeholder="เวลา" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Availability Display -->
                        <div id="AlertMessage" class="alert-premium d-none mb-4 p-3 animate__animated animate__fadeIn"></div>

                        <h5 class="section-title"><i class='bx bx-cog'></i> อุปกรณ์เพิ่มเติม</h5>
                        <div class="row g-2 mb-4">
                            <?php foreach(['เครื่องคอมพิวเตอร์', 'จอโปรเจ็คเตอร์', 'เครื่องฉายแผ่นใส', 'เครื่องขยายเสียง'] as $eq): ?>
                            <div class="col-6 col-md-3">
                                <label class="equipment-check" for="eq_<?=$eq?>">
                                    <input class="form-check-input me-2" type="checkbox" name="booking_equipment[]" id="eq_<?=$eq?>" value="<?=$eq?>">
                                    <span class="small"><?=$eq?></span>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="form-floating mb-4">
                            <textarea id="booking_other" name="booking_other" class="form-control" style="height: 100px" placeholder="อื่นๆ"></textarea>
                            <label>ข้อความระบุถึงเจ้าหน้าที่ / คำขอเพิ่มเติม</label>
                        </div>

                        <h5 class="section-title"><i class='bx bx-image-add'></i> รูปภาพประกอบ หรือ ผังงานจัดสถานที่ (ถ้ามี)</h5>
                        <div class="mb-4">
                            <div class="upload-preview-container" data-bs-toggle="modal" data-bs-target="#imageModal">
                                <div id="uploadPlaceholder">
                                    <i class='bx bx-cloud-upload fs-1 text-primary mb-2'></i>
                                    <p class="mb-0 text-muted small">คลิกเพื่ออัปโหลดรูปภาพประกอบโครงการหรือกิจกรรม</p>
                                </div>
                                <canvas id="croppedCanvas" class="d-none"></canvas>
                            </div>
                        </div>

                        <h5 class="section-title"><i class='bx bx-phone'></i> ข้อมูลการติดต่อ</h5>
                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <?php if(!in_array('งานอาคารสถานที่', explode(",", @$_SESSION['rloes']))) : ?>
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-light" value="<?=@$_SESSION['username']?>" readonly disabled>
                                        <label>ชื่อผู้จอง</label>
                                    </div>
                                    <input type="hidden" name="booking_Booker" value="<?=@$_SESSION['id']?>">
                                <?php else: ?>
                                    <div class="form-floating">
                                        <select class="form-select select2Teach" id="booking_Booker" name="booking_Booker" required>
                                            <option value="">-- เลือกผู้จอง --</option>
                                            <?php foreach ($ListUser as $value): ?>
                                            <option value="<?=$value->pers_id?>" data-phone="<?=$value->pers_phone?>"><?=$value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>บันทึกในนามเจ้าหน้าที่</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" id="booking_telephone" name="booking_telephone" class="form-control" placeholder="เบอร์โทร" required>
                                    <label>เบอร์โทรศัพท์สำหรับติดต่อกลับ</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="BtnSubBooking" class="btn btn-primary btn-submit-booking w-100 text-white">
                            <i class='bx bx-check-double me-2'></i>ส่งคำขอการจองสถานที่
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Upload Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold"><i class='bx bx-image me-1'></i> จัดการรูปภาพ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="file" id="imageInput" accept="image/*" class="form-control mb-3">
                <div class="d-flex justify-content-center gap-2 mt-2 mb-3">
                    <button type="button" class="btn btn-sm btn-outline-primary active" id="setPortraitBtn">
                        <i class='bx bx-mobile-v me-1'></i>แนวตั้ง (A4)
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="setLandscapeBtn">
                        <i class='bx bx-window-alt me-1'></i>แนวนอน (A4)
                    </button>
                </div>
                <div id="croppieContainer"></div>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <button type="button" class="btn btn-outline-secondary" id="rotateLeftBtn"><i class='bx bx-rotate-left'></i></button>
                    <button type="button" class="btn btn-outline-secondary" id="rotateRightBtn"><i class='bx bx-rotate-right'></i></button>
                </div>
            </div>
            <div class="modal-footer border-top">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="cropBtn">ยืนยันรูปภาพ</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
$(document).ready(function() {
    $('.select2Teach').select2();
    $('#booking_telephone').inputmask('99-9999-9999');

    // Auto-fill phone number when booker is selected
    $('#booking_Booker').on('change', function() {
        const phone = $(this).find(':selected').data('phone');
        if (phone) {
            $('#booking_telephone').val(phone).trigger('input');
        } else {
            $('#booking_telephone').val('').trigger('input');
        }
    });

    // If session user is booking (not admin view), try to find their phone if possible
    // Note: ConUserBooking currently doesn't pass the logged-in user's phone separately, 
    // but the logic below covers the admin selection.

    flatpickr.localize(flatpickr.l10ns.th);
    const dateConfig = {
        dateFormat: "Y-m-d",
        altFormat: "d/m/Y",
        formatDate: (date, format, locale) => {
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let year = date.getFullYear() + 543;
            return `${day}/${month}/${year}`;
        }
    };
    
    flatpickr(".selector", dateConfig);
    $(".selectorTime").flatpickr({
        enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true
    });

    // --- Availability Check Logic ---
    $('.check-time').on('change', function() {
        const data = {
            booking_locationroom: $('#booking_locationroom').val(),
            booking_dateStart: $('#booking_dateStart').val(),
            booking_timeStart: $('#booking_timeStart').val(),
            booking_dateEnd: $('#booking_dateEnd').val(),
            booking_timeEnd: $('#booking_timeEnd').val()
        };

        // แจ้งเตือนถ้าข้อมูลไม่ครบ
        if (!data.booking_dateStart || !data.booking_timeStart || !data.booking_dateEnd || !data.booking_timeEnd) {
            let missingFields = [];
            if(!data.booking_dateStart) missingFields.push('วันที่เริ่ม');
            if(!data.booking_timeStart) missingFields.push('เวลาเริ่ม');
            if(!data.booking_dateEnd) missingFields.push('วันที่สิ้นสุด');
            if(!data.booking_timeEnd) missingFields.push('เวลาสิ้นสุด');

            $('#AlertMessage').removeClass('d-none alert-success alert-danger alert-warning').addClass('alert-warning d-block').html('🕐 กรุณาเลือก <b>' + missingFields.join(', ') + '</b> ให้ครบถ้วนเพื่อตรวจสอบสถานะห้องว่าง');
            $('#BtnSubBooking').addClass('disabled').prop('disabled', true);
            return;
        }

        $.ajax({
            url: "<?=base_url('Booking/DB/CheckDate')?>",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(res) {
                $('#AlertMessage').removeClass('d-none alert-success alert-danger alert-warning')
                                .addClass(res.class)
                                .html(res.message);
                
                if(res.status === 0) {
                    $('#BtnSubBooking').addClass('disabled').prop('disabled', true);
                } else {
                    $('#BtnSubBooking').removeClass('disabled').prop('disabled', false);
                }
            },
            error: function() {
                $('#AlertMessage').removeClass('d-none alert-success alert-danger alert-warning').addClass('alert-danger d-block').html('❌ ไม่สามารถเชื่อมต่อระบบตรวจสอบวันว่างได้ กรุณาลองใหม่อีกครั้ง');
                $('#BtnSubBooking').addClass('disabled').prop('disabled', true);
            }
        });
    });

    // Trigger check if date is pre-filled
    if($('#booking_dateStart').val()) {
        // ตั้งเวลาเริ่มต้นให้เพื่อให้ระบบตรวจสอบได้ทันที (ถ้ายังไม่ได้เลือก)
        if(!$('#booking_timeStart').val()){
            $("#booking_timeStart").val("08:30");
        }
        if(!$('#booking_timeEnd').val()){
            $("#booking_timeEnd").val("16:30");
        }
        $('.check-time').first().trigger('change');
    }

    // --- Croppie Initialization ---
    let croppieInstance;
    function initCroppie(w, h) {
        if(croppieInstance) croppieInstance.destroy();
        croppieInstance = new Croppie(document.getElementById('croppieContainer'), {
            viewport: { width: w, height: h, type: 'square' },
            boundary: { width: '100%', height: 450 },
            enableOrientation: true
        });
        // Re-bind image if input has file
        const input = document.getElementById('imageInput');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) { croppieInstance.bind({ url: e.target.result }); }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#imageModal').on('shown.bs.modal', function() {
        if (!croppieInstance) {
            initCroppie(248, 350); // Default Portrait A4
        }
    });

    $('#setPortraitBtn').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        initCroppie(248, 350);
    });

    $('#setLandscapeBtn').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        initCroppie(350, 248);
    });

    $('#imageInput').on('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                croppieInstance.bind({ url: e.target.result });
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#rotateLeftBtn').on('click', () => croppieInstance.rotate(-90));
    $('#rotateRightBtn').on('click', () => croppieInstance.rotate(90));

    $('#cropBtn').on('click', function() {
        croppieInstance.result({ type: 'canvas', size: 'original', format: 'png', quality: 1 }).then(function(base64) {
            $('#booking_imgWork').val(base64);
            const canvas = document.getElementById('croppedCanvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                $('#croppedCanvas').removeClass('d-none');
                $('#uploadPlaceholder').addClass('d-none');
            };
            img.src = base64;
            bootstrap.Modal.getInstance(document.getElementById('imageModal')).hide();
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('FormAddBooking');
    const btnSubmit = document.getElementById('BtnSubBooking');

    btnSubmit.addEventListener('click', function(event) {
        event.preventDefault();

        // ตรวจสอบทั้ง class และ property disabled
        if ($('#BtnSubBooking').hasClass('disabled') || $('#BtnSubBooking').is(':disabled')) {
            Swal.fire({ icon: 'warning', title: 'ไม่สามารถดำเนินการได้', text: 'กรุณาตรวจสอบวันและเวลาที่ว่างก่อนส่งข้อมูล' });
            return;
        }

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            Swal.fire({ icon: 'warning', title: 'ข้อมูลไม่ครบถ้วน', text: 'กรุณากรอกข้อมูลที่จำเป็น (*) ทั้งหมด' });
            return;
        }

        Swal.fire({
            title: 'ยืนยันการจอง?',
            text: 'คำขอจะถูกส่งไปยังเจ้าหน้าที่เพื่อตรวจสอบและอนุมัติ',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ยืนยันส่งข้อมูล',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#696cff'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'กำลังบันทึก...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                fetch(form.action, { method: form.method, body: new FormData(form) })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({ icon: 'success', title: 'บันทึกคำขอจองสำเร็จ!', text: 'เจ้าหน้าที่จะตรวจสอบข้อมูลให้เร็วที่สุดครับ', timer: 2000, showConfirmButton: false })
                        .then(() => window.location.href = `<?=base_url('Booking/View/')?>${data.location_id}`);
                    } else {
                        Swal.fire({ icon: 'error', title: 'ไม่สามารถบันทึกได้', text: data.message });
                    }
                })
                .catch(err => {
                    Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้ หรือไฟล์มีขนาดใหญ่เกินไป' });
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
