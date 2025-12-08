<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="<?=base_url('Booking');?>" class="text-primary">สถานที่</a> /
        </span> 
        จองห้อง/สถานที่
    </h4>

    <div class="row">
        <!-- Left Column: Location Info -->
        <div class="col-lg-4 mb-4">
            <!-- Location Card -->
            <div class="card mb-4">
                <img class="card-img-top" style="height: 200px; object-fit: cover;"
                     src="<?=base_url('uploads/admin/LocationRoom/'.$loca->location_img)?>"
                     alt="<?=$loca->location_name?>">
                <div class="card-body">
                    <h5 class="card-title"><?=$loca->location_name?></h5>
                    <p class="card-text text-muted"><?=$loca->location_detail?></p>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0 text-white">
                        <i class='bx bx-calendar-event me-2'></i>
                        ตาราง <?=$Datethai->thai_date_fullmonth(strtotime(date('d-m-Y')))?>
                    </h6>
                </div>
                <div class="card-body">
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
                        <ul class="list-group list-group-flush">
                            <?php foreach ($BookignToday as $value):
                                if(date('Y-m-d') >= $value->booking_dateStart && date('Y-m-d') <= $value->booking_dateEnd): ?>
                                <li class="list-group-item px-0">
                                    <div class="fw-semibold"><?=$value->booking_title?></div>
                                    <small class="text-muted">
                                        <i class='bx bx-time'></i> <?=$value->booking_timeStart?> - <?=$value->booking_timeEnd?>
                                    </small>
                                </li>
                            <?php endif; endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center text-muted py-3">
                            <i class='bx bx-calendar-check fs-1 text-success mb-2 d-block'></i>
                            <span>ว่างตลอดวัน</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column: Booking Form -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-edit me-2'></i>แบบฟอร์มขอใช้สถานที่</h5>
                </div>
                <div class="card-body">
                    <form id="FormAddBooking" class="needs-validation" novalidate action="<?=base_url('Booking/DB/Insert')?>" method="POST">
                        
                        <input type="hidden" name="booking_order" value="<?=$BookLatest?>">
                        <input type="hidden" name="booking_locationroom" value="<?=$loca->location_ID?>">

                        <!-- Basic Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" value="<?=$BookLatest?>" readonly disabled>
                                    <label>เลขที่จอง</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" id="booking_number" name="booking_number" class="form-control" placeholder="จำนวนคน" required>
                                    <label for="booking_number">จำนวนผู้เข้าร่วม</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking_title" name="booking_title" placeholder="หัวข้อ" required>
                                    <label for="booking_title">หัวข้อการใช้งาน</label>
                                </div>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <h6 class="text-muted mb-3"><i class='bx bx-time me-1'></i> วัน-เวลา</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selector" type="text" id="booking_dateStart" name="booking_dateStart" placeholder="เริ่ม" required value="<?= isset($selectedDate) ? $selectedDate : '' ?>">
                                    <label>เริ่มวันที่</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selectorTime" type="text" id="booking_timeStart" name="booking_timeStart" placeholder="เวลา" required>
                                    <label>เวลา</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selector" type="text" id="booking_dateEnd" name="booking_dateEnd" placeholder="สิ้นสุด" required value="<?= isset($selectedDate) ? $selectedDate : '' ?>">
                                    <label>ถึงวันที่</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selectorTime" type="text" id="booking_timeEnd" name="booking_timeEnd" placeholder="เวลา" required>
                                    <label>เวลา</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-warning d-none" id="AlertMessage"></div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="mb-3 form-floating">
                            <select class="form-select" id="booking_typeuse" name="booking_typeuse" required>
                                <option value="" disabled selected>-- เลือกประเภท --</option>
                                <?php foreach (['ประชุม','อบรม','สัมนา','จัดเลี้ยง','จัดกิจกรรม'] as $type) : ?>
                                <option value="<?=$type?>"><?=$type?></option>
                                <?php endforeach; ?>
                            </select>
                            <label>ประเภทการใช้งาน</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">อุปกรณ์ที่ต้องการ</label>
                            <div class="row g-2">
                                <?php foreach(['เครื่องคอมพิวเตอร์', 'จอโปรเจ็คเตอร์', 'เครื่องฉายแผ่นใส', 'เครื่องขยายเสียง'] as $eq): ?>
                                <div class="col-6 col-sm-4 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="booking_equipment[]" id="eq_<?=$eq?>" value="<?=$eq?>">
                                        <label class="form-check-label" for="eq_<?=$eq?>"><?=$eq?></label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-4 form-floating">
                            <textarea id="booking_other" name="booking_other" class="form-control" style="height: 80px" placeholder="หมายเหตุ"></textarea>
                            <label>หมายเหตุ / คำขออื่นๆ</label>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label class="form-label"><i class='bx bx-image-add me-1'></i> รูปภาพประกอบ (ถ้ามี)</label>
                            <button type="button" class="btn btn-outline-primary d-block" data-bs-toggle="modal" data-bs-target="#imageModal">
                                <i class='bx bx-upload me-1'></i> เลือกรูปภาพ
                            </button>
                            <canvas id="croppedCanvas" style="display:none; margin-top: 1rem; max-width: 100%;"></canvas>
                            <input type="hidden" id="booking_imgWork" name="booking_imgWork">
                        </div>

                        <hr class="my-4">

                        <!-- Contact Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <?php 
                                $ExRloes = explode(",", @$_SESSION['rloes']);
                                if(!in_array('งานอาคารสถานที่', $ExRloes)) : ?>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" value="<?=$_SESSION['username']?>" readonly disabled>
                                        <label>ผู้จอง</label>
                                    </div>
                                    <input type="hidden" name="booking_Booker" value="<?=$_SESSION['id']?>">
                                <?php else: ?>
                                    <div class="form-floating">
                                        <select class="form-select select2Teach" id="booking_Booker" name="booking_Booker" required>
                                            <option value="">-- เลือกผู้จอง --</option>
                                            <?php foreach ($ListUser as $value): ?>
                                            <option value="<?=$value->pers_id?>">
                                                <?=$value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label>ผู้จอง (เจ้าหน้าที่แทน)</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" id="booking_telephone" name="booking_telephone" class="form-control" placeholder="เบอร์โทร" required>
                                    <label>เบอร์โทรศัพท์</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="BtnSubBooking" class="btn btn-primary btn-lg w-100">
                            <i class='bx bx-check-circle me-2'></i>ยืนยันการจอง
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เลือกรูปภาพ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted small">** ควรใช้รูปแนวนอน **</p>
                <input type="file" id="imageInput" accept="image/*" class="form-control mb-3">
                <div id="croppieContainer"></div>
                <div class="btn-group mt-3" role="group">
                    <button type="button" class="btn btn-outline-secondary" id="rotateLeftBtn"><i class='bx bx-rotate-left'></i></button>
                    <button type="button" class="btn btn-outline-secondary" id="rotateRightBtn"><i class='bx bx-rotate-right'></i></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" id="cropBtn">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize Plugins
    $('.select2Teach').select2();
    $('#booking_telephone').inputmask('99-9999-9999');

    flatpickr.localize(flatpickr.l10ns.th);
    
    flatpickr(".selector", {
        dateFormat: "Y-m-d",
        allowInput: false,
        altFormat: "d/m/Y", 
        formatDate: (date, format, locale) => {
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let year = date.getFullYear() + 543;
            return `${day}/${month}/${year}`;
        }
    });

    $(".selectorTime").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    // Check immediately if values are present (e.g. from URL)
    if($('#booking_dateStart').val()) {
        setTimeout(function() {
            $('#booking_dateStart').trigger('change');
        }, 500);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('FormAddBooking');
    const btnSubmit = document.getElementById('BtnSubBooking');

    btnSubmit.addEventListener('click', function(event) {
        event.preventDefault();

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

        Swal.fire({
            title: 'ยืนยันการจอง?',
            text: 'ตรวจสอบข้อมูลให้ถูกต้องก่อนยืนยัน',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'แก้ไข'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังบันทึก...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                fetch(form.action, {
                    method: form.method,
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'จองสำเร็จ!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = `<?=base_url('Booking/View/')?>${data.location_id}`;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Connection Error',
                        text: 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้'
                    });
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
