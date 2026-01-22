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

    .car-preview-img {
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
    
    .alert-premium { border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }

    /* Note: Select2 styling is handled by global user-repair.css to match Room Booking form */
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
                        <li class="breadcrumb-item"><a href="<?=base_url('CarBooking');?>" class="text-white-50">ยานพาหนะ</a></li>
                        <li class="breadcrumb-item active text-white">แบบฟอร์มการจอง</li>
                    </ol>
                </nav>
                <h3 class="mb-0 fw-bold text-white">จองยานพาหนะ: <?=$Car->car_registration?></h3>
            </div>
            <i class='bx bxs-car fs-1 text-white-50'></i>
        </div>
    </div>

    <?php  
    $Type = isset($_SESSION['rloes']) ? explode(',', $_SESSION['rloes']) : [];
    $CheckWho = (in_array('งานยานพาหนะ', $Type) || @$_SESSION['status'] == "AdminGeneral") ? 1 : 0;
    ?>

    <div class="row g-4">
        <!-- Info Column -->
        <div class="col-lg-4 mb-4">
            <div class="glass-card p-3 premium-animate" style="animation-delay: 0.1s">
                <img src="<?=base_url('uploads/admin/Car/'.$Car->car_img)?>" 
                     class="car-preview-img mb-3" alt="<?=$Car->car_category?>"
                     onerror="this.src='<?= base_url('assets/img/elements/1.jpg') ?>'">
                
                <h5 class="fw-bold mb-2"><?=$Car->car_registration?></h5>
                <p class="text-muted small mb-0"><?=$Car->car_province?> - <?=$Car->car_category?></p>

                <hr class="my-3 opacity-50">

                <div class="info-section">
                    <h6 class="fw-bold mb-3 d-flex align-items-center text-primary">
                        <i class='bx bx-info-circle me-2'></i>
                        คำแนะนำการจอง
                    </h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2"><i class='bx bx-check-circle me-1 text-success'></i> กรุณาจองล่วงหน้าอย่างน้อย 3 วัน</li>
                        <li class="mb-2"><i class='bx bx-check-circle me-1 text-success'></i> ตรวจสอบวันและเวลาให้ถูกต้อง</li>
                        <li class="mb-2"><i class='bx bx-check-circle me-1 text-success'></i> ข้อมูลการจองต้องผ่านการอนุมัติ</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="glass-card premium-animate" style="animation-delay: 0.2s">
                <div class="card-body p-lg-4 p-3">
                    <form id="FormAddCarReservation" class="needs-validation" novalidate>
                        <input type="hidden" name="car_reserv_carID" value="<?=$uri->getSegment(3)?>">

                        <h5 class="section-title"><i class='bx bx-detail'></i> ข้อมูลการจอง</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control bg-light" value="<?=$car_reserv_order?>" readonly disabled>
                                    <label>เลขที่การจอง</label>
                                </div>
                                <input type="hidden" name="car_reserv_order" value="<?=$car_reserv_order?>">
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="car_reserv_location" name="car_reserv_location" placeholder="สถานที่" required>
                                    <label for="car_reserv_location">สถานที่ที่จะเดินทางไป (ปลายทางการเดินทาง)</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control h-px-100" id="car_reserv_detail" name="car_reserv_detail" placeholder="ภารกิจ" required></textarea>
                                    <label for="car_reserv_detail">วัตถุประสงค์ในการเดินทาง / ภารกิจ</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" id="car_reserv_number" name="car_reserv_number" class="form-control" placeholder="จำนวนคน" required min="1">
                                    <label for="car_reserv_number">จำนวนผู้ร่วมเดินทาง (คน)</label>
                                </div>
                            </div>
                        </div>

                        <h5 class="section-title"><i class='bx bx-calendar'></i> วันและเวลา</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light bg-opacity-25">
                                    <label class="form-label text-primary fw-bold small">เริ่มเดินทาง (ขาไป)</label>
                                    <div class="row g-2">
                                        <div class="col-7">
                                            <input class="form-control check-time" type="text" id="car_reserv_StartDate" name="car_reserv_StartDate" placeholder="วันที่" required>
                                        </div>
                                        <div class="col-5">
                                            <input class="form-control check-time selectorTime" type="text" id="car_reserv_StartTime" name="car_reserv_StartTime" placeholder="เวลา" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light bg-opacity-25">
                                    <label class="form-label text-danger fw-bold small">สิ้นสุดเดินทาง (ขากลับ)</label>
                                    <div class="row g-2">
                                        <div class="col-7">
                                            <input class="form-control check-time" type="text" id="car_reserv_EndDate" name="car_reserv_EndDate" placeholder="วันที่" required>
                                        </div>
                                        <div class="col-5">
                                            <input class="form-control check-time selectorTime" type="text" id="car_reserv_EndTime" name="car_reserv_EndTime" placeholder="เวลา" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Availability Display -->
                        <div id="AlertMessage" class="alert-premium d-none mb-4 p-3 animate__animated animate__fadeIn"></div>

                        <h5 class="section-title"><i class='bx bx-phone'></i> ข้อมูลการติดต่อ</h5>
                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <?php if(!$CheckWho) : ?>
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-light" value="<?=@$_SESSION['username']?>" readonly disabled>
                                        <label>ชื่อผู้จอง</label>
                                    </div>
                                    <input type="hidden" name="car_reserv_memberID" value="<?=@$_SESSION['id']?>">
                                <?php else: ?>
                                    <div class="form-floating">
                                        <select class="form-select select2Teach" id="car_reserv_memberID" name="car_reserv_memberID" required>
                                            <option value="">-- เลือกผู้ปฏิบัติหน้าที่ --</option>
                                            <?php foreach($SelPres as $r_SelPres):?>
                                            <option value="<?=$r_SelPres->pers_id?>" data-phone="<?=$r_SelPres->pers_phone?>">
                                                <?=$r_SelPres->pers_prefix.$r_SelPres->pers_firstname.' '.$r_SelPres->pers_lastname?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                        <label>บันทึกในนามเจ้าหน้าที่</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" id="car_reserv_phone" name="car_reserv_phone" class="form-control" placeholder="เบอร์โทร" required>
                                    <label>เบอร์โทรศัพท์สำหรับติดต่อกลับ</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="BtnSubBooking" class="btn btn-primary btn-submit-booking w-100 text-white disabled">
                            <i class='bx bx-check-double me-2'></i>ส่งคำขอการจองยานพาหนะ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
    $(document).ready(function() {
        // --- Plugins Initialization ---
        $('.select2Teach').select2(); // Match Room Booking style (simple initialization)

        $('#car_reserv_phone').inputmask('99-9999-9999');
        flatpickr.localize(flatpickr.l10ns.th);

        // --- Auto-fill Phone Number for Admin ---
        $('#car_reserv_memberID').on('change', function() {
            const phone = $(this).find(':selected').data('phone');
            if (phone) {
                $('#car_reserv_phone').val(phone).trigger('input');
            } else {
                $('#car_reserv_phone').val('');
            }
        });

        // --- Availability Check ---
        const checkAvailability = () => {
            const formData = {
                car_reserv_carID: $('input[name="car_reserv_carID"]').val(),
                car_reserv_StartDate: $('#car_reserv_StartDate').val(),
                car_reserv_StartTime: $('#car_reserv_StartTime').val(),
                car_reserv_EndDate: $('#car_reserv_EndDate').val(),
                car_reserv_EndTime: $('#car_reserv_EndTime').val()
            };

            // แจ้งเตือนถ้าข้อมูลไม่ครบ
            if (!formData.car_reserv_StartDate || !formData.car_reserv_StartTime || 
                !formData.car_reserv_EndDate || !formData.car_reserv_EndTime) {
                
                let missingFields = [];
                if(!formData.car_reserv_StartDate) missingFields.push('วันที่ไป');
                if(!formData.car_reserv_StartTime) missingFields.push('เวลาไป');
                if(!formData.car_reserv_EndDate) missingFields.push('วันที่กลับ');
                if(!formData.car_reserv_EndTime) missingFields.push('เวลากลับ');

                $('#AlertMessage').removeClass('d-none alert-success alert-danger alert-warning').addClass('alert-warning d-block').html('🕐 กรุณาเลือก <b>' + missingFields.join(', ') + '</b> ให้ครบถ้วนเพื่อตรวจสอบสถานะห้องว่าง');
                $('#BtnSubBooking').addClass('disabled').prop('disabled', true);
                return;
            }

            $.ajax({
                url: '<?= base_url('Booking/DB/CheckDateCarBooking') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    $('#AlertMessage').removeClass('d-none alert-success alert-danger alert-warning').addClass('d-block ' + res.class).html(res.message);
                    if (res.status == 1) {
                         $('#BtnSubBooking').removeClass('disabled').prop('disabled', false);
                    } else {
                         $('#BtnSubBooking').addClass('disabled').prop('disabled', true);
                    }
                },
                error: function() {
                    $('#AlertMessage').removeClass('d-none alert-success alert-danger alert-warning').addClass('alert-danger d-block').html('❌ ไม่สามารถเชื่อมต่อระบบตรวจสอบวันว่างได้ กรุณาลองใหม่อีกครั้ง');
                    $('#BtnSubBooking').addClass('disabled').prop('disabled', true);
                }
            });
        };

        const datePickerConfig = {
            dateFormat: "d/m/Y",
            allowInput: false,
            formatDate: (date, format, locale) => {
                let day = String(date.getDate()).padStart(2, '0');
                let month = String(date.getMonth() + 1).padStart(2, '0');
                let year = date.getFullYear() + 543;
                return `${day}/${month}/${year}`;
            },
            onChange: checkAvailability
        };

        const fpStartDate = $("#car_reserv_StartDate").flatpickr(datePickerConfig);
        const fpEndDate = $("#car_reserv_EndDate").flatpickr(datePickerConfig);

        $(".selectorTime").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            onClose: checkAvailability
        });

        // Handle URL Parameters
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('date')) {
            const [y, m, d] = urlParams.get('date').split('-').map(Number);
            const dObj = new Date(y, m - 1, d);
            fpStartDate.setDate(dObj);
            fpEndDate.setDate(dObj);
            
            // ตั้งเวลาเริ่มต้นให้เพื่อให้ระบบตรวจสอบได้ทันที (ถ้ายังไม่ได้เลือก)
            if(!$('#car_reserv_StartTime').val()){
                $("#car_reserv_StartTime").val("08:30");
            }
            if(!$('#car_reserv_EndTime').val()){
                $("#car_reserv_EndTime").val("16:30");
            }

            checkAvailability();
        }

        // --- Form Submission ---
        $('#FormAddCarReservation').on('submit', function(e) {
            e.preventDefault();
            
            // ตรวจสอบทั้ง class และ property disabled
            if ($('#BtnSubBooking').hasClass('disabled') || $('#BtnSubBooking').is(':disabled')) {
                Swal.fire({ icon: 'warning', title: 'ไม่สามารถดำเนินการได้', text: 'กรุณาตรวจสอบวันและเวลาที่ว่างก่อนส่งข้อมูล' });
                return;
            }

            const form = this;
            if (!form.checkValidity()) {
                $(form).addClass('was-validated');
                return;
            }

            Swal.fire({
                title: 'ยืนยันการจอง?',
                text: "ท่านต้องการบันทึกข้อมูลการจองยานพาหนะใช่หรือไม่",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'ยืนยันบันทึก',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData(form);
                    $('#BtnSubBooking').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังบันทึก...');

                    $.ajax({
                        url: '<?= base_url('CarBooking/DB/Insert') ?>',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response == 1 || response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'สำเร็จ!',
                                    text: 'บันทึกข้อมูลการจองเรียบร้อยแล้ว',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '<?= base_url('CarBooking') ?>';
                                });
                            } else {
                                Swal.fire({ icon: 'error', title: 'พบข้อผิดพลาด', text: 'ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบอีกครั้ง' });
                                $('#BtnSubBooking').prop('disabled', false).html('<i class="bx bx-check-double me-2"></i>ส่งคำขอการจองยานพาหนะ');
                            }
                        },
                        error: function() {
                            Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้' });
                            $('#BtnSubBooking').prop('disabled', false).html('<i class="bx bx-check-double me-2"></i>ส่งคำขอการจองยานพาหนะ');
                        }
                    });
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
