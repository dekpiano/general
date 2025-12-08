<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="<?=base_url('CarBooking')?>">หน้าหลักจองยานพาหนะ</a> /
        </span>
        จองยานพาหนะ
    </h4>

    <?php  
    $Type = explode(',', $_SESSION['rloes']);
    $CheckWho = in_array('งานยานพาหนะ', $Type) ? 1 : 0;
    ?>

    <div class="row">
        <!-- Left: Car Info -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <img class="card-img-top" 
                     src="<?=base_url('uploads/admin/Car/'.$Car->car_img)?>"
                     alt="<?=$Car->car_category?>"
                     style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?=$Car->car_category?></h5>
                    <p class="card-text">
                        <i class='bx bx-id-card me-1'></i>
                        <?=$Car->car_registration?> <?=$Car->car_province?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right: Booking Form -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-edit me-2'></i>แบบฟอร์มจองยานพาหนะ</h5>
                </div>
                <div class="card-body">
                    <form id="FormAddCarReservation" class="needs-validation" novalidate>
                        <input type="hidden" name="car_reserv_carID" value="<?=$uri->getSegment(3)?>">

                        <!-- Basic Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="car_reserv_order" value="<?=$car_reserv_order?>" readonly>
                                    <label>เลขที่จอง</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" id="car_reserv_number" name="car_reserv_number" class="form-control" placeholder="จำนวนคน" required>
                                    <label for="car_reserv_number">จำนวนผู้ไปปฏิบัติงาน (คน)</label>
                                </div>
                            </div>
                        </div>

                        <?php if(!$CheckWho) : ?>
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control" value="<?=$_SESSION['username']?>" readonly disabled>
                                <label>ผู้จอง</label>
                            </div>
                            <input type="hidden" name="car_reserv_memberID" value="<?=$_SESSION['id']?>">
                        <?php else: ?>
                            <div class="form-floating mb-4">
                                <select class="form-select select2Teach" id="car_reserv_memberID" name="car_reserv_memberID" required>
                                    <option value="">-- เลือกผู้จอง --</option>
                                    <?php foreach($SelPres as $r_SelPres):?>
                                    <option value="<?=$r_SelPres->pers_id?>">
                                        <?=$r_SelPres->pers_prefix.$r_SelPres->pers_firstname.' '.$r_SelPres->pers_lastname?>
                                    </option>
                                    <?php endforeach;?>
                                </select>
                                <label>ผู้จอง (เจ้าหน้าที่แทน)</label>
                            </div>
                        <?php endif; ?>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="car_reserv_location" name="car_reserv_location" placeholder="สถานที่" required>
                            <label for="car_reserv_location">ขออนุญาตใช้รถไปที่</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="car_reserv_detail" name="car_reserv_detail" placeholder="ภารกิจ" required>
                            <label for="car_reserv_detail">เพื่อปฏิบัติงานเรื่อง</label>
                        </div>

                        <!-- Date & Time -->
                        <h6 class="text-muted mb-3"><i class='bx bx-time me-1'></i> วัน-เวลา เดินทาง</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selector" type="text" id="car_reserv_StartDate" name="car_reserv_StartDate" placeholder="เริ่ม" required>
                                    <label>ออกเดินทางวันที่</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selectorTime" type="text" id="car_reserv_StartTime" name="car_reserv_StartTime" placeholder="เวลา" required>
                                    <label>เวลา</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selector" type="text" id="car_reserv_EndDate" name="car_reserv_EndDate" placeholder="สิ้นสุด" required>
                                    <label>เดินทางกลับวันที่</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selectorTime" type="text" id="car_reserv_EndTime" name="car_reserv_EndTime" placeholder="เวลา" required>
                                    <label>เวลา</label>
                                </div>
                            </div>
                        </div>

                        <div id="AlertMessage" class="alert alert-warning d-none mb-3"></div>

                        <div class="form-floating mb-4">
                            <input type="tel" class="form-control" id="car_reserv_phone" name="car_reserv_phone" placeholder="เบอร์โทร" required>
                            <label for="car_reserv_phone">เบอร์โทรศัพท์</label>
                        </div>

                        <button type="submit" id="BtnSubBooking" class="btn btn-primary btn-lg w-100">
                            <i class='bx bx-check-circle me-1'></i>ยืนยันการจองยานพาหนะ
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
        // Initialize Plugins
        $('.select2Teach').select2();
        $('#car_reserv_phone').inputmask('99-9999-9999');

        flatpickr.localize(flatpickr.l10ns.th);
        
        const checkTime = () => {
             const formData = new FormData($('#FormAddCarReservation')[0]);
             $.ajax({
                url: '<?= base_url('Booking/DB/CheckDateCarBooking') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#AlertMessage').removeClass('d-none alert-success alert-danger alert-warning').addClass(res.class).html(res.message);
                    if (res.status == 1) {
                         $('#BtnSubBooking').prop('disabled', false);
                    } else {
                         $('#BtnSubBooking').prop('disabled', true);
                    }
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
            onChange: checkTime
        };

        const fpStartDate = $("#car_reserv_StartDate").flatpickr(datePickerConfig);
        const fpEndDate = $("#car_reserv_EndDate").flatpickr(datePickerConfig);

        $(".selectorTime").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            onClose: checkTime
        });
        
        // Bind generic change event for robust checking mechanism
        $('#car_reserv_StartDate, #car_reserv_EndDate, #car_reserv_StartTime, #car_reserv_EndTime').on('input change', checkTime);

        // Handle URL Date Param
        const urlParams = new URLSearchParams(window.location.search);
        const dateParam = urlParams.get('date');
        if (dateParam) {
            // Fix: Parse YYYY-MM-DD manually to Date Object to avoid Format mismatches
            const [y, m, d] = dateParam.split('-').map(Number);
            const dObj = new Date(y, m - 1, d);
            
            fpStartDate.setDate(dObj, true); // true = trigger change
            fpEndDate.setDate(dObj, true);
        }

        // Submit Handler via Click
        $('#BtnSubBooking').click(function(e) {
            e.preventDefault();
            
            // Check if alert message indicates error (Secondary check besides disabled button)
            if ($('#AlertMessage').hasClass('alert-danger')) {
                 Swal.fire({
                    icon: 'warning',
                    title: 'ไม่สามารถจองได้',
                    text: 'วัน-เวลาที่เลือกมีการจองแล้ว กรุณาเลือกใหม่'
                });
                return;
            }

            const form = $('#FormAddCarReservation')[0];
             if (!form.checkValidity()) {
                form.classList.add('was-validated');
                Swal.fire({
                    icon: 'warning',
                    title: 'ข้อมูลไม่ครบ',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน'
                });
                return;
            }

            const formData = new FormData(form);

            $('#BtnSubBooking').prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> กำลังบันทึก...');

            $.ajax({
                url: '<?= base_url('CarBooking/DB/Insert') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                   if(response == 1 || response.status === 'success'){
                       Swal.fire({
                           icon: 'success',
                           title: 'สำเร็จ',
                           text: 'จองยานพาหนะเรียบร้อยแล้ว',
                           showConfirmButton: false,
                           timer: 1500
                       }).then(() => {
                           window.location.href = '<?=base_url('CarBooking')?>';
                       });
                   } else {
                       Swal.fire({
                           icon: 'error',
                           title: 'ผิดพลาด',
                           text: 'เกิดข้อผิดพลาดในการบันทึก (ข้อมูลไม่ครบหรือซ้ำ)'
                       });
                       $('#BtnSubBooking').prop('disabled', false).html('<i class="bx bx-check-circle me-1"></i>ยืนยันการจองยานพาหนะ');
                   }
                },
                error: function() {
                     Swal.fire({
                           icon: 'error',
                           title: 'ผิดพลาด',
                           text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ'
                       });
                     $('#BtnSubBooking').prop('disabled', false).html('<i class="bx bx-check-circle me-1"></i>ยืนยันการจองยานพาหนะ');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
