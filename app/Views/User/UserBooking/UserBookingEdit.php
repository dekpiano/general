<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="<?=base_url('Booking');?>" class="text-primary">สถานที่</a> /
        </span> 
        แก้ไขการจองห้อง/สถานที่
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
        </div>

        <!-- Right Column: Booking Form -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-edit me-2'></i>แก้ไขแบบฟอร์มขอใช้สถานที่</h5>
                </div>
                <div class="card-body">
                    <form id="FormEditBooking" class="needs-validation" novalidate action="<?=base_url('Booking/DB/Update')?>" method="POST">
                        
                        <input type="hidden" name="booking_id" value="<?=$Booking[0]->booking_id?>">
                        <input type="hidden" name="booking_locationroom" value="<?=$Booking[0]->location_ID?>">

                        <!-- Basic Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" value="<?=$Booking[0]->booking_order?>" readonly disabled>
                                    <label>เลขที่จอง</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" id="booking_number" name="booking_number" class="form-control" placeholder="จำนวนคน" required value="<?=$Booking[0]->booking_number?>">
                                    <label for="booking_number">จำนวนผู้เข้าร่วม</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking_title" name="booking_title" placeholder="หัวข้อ" required value="<?=$Booking[0]->booking_title?>">
                                    <label for="booking_title">หัวข้อการใช้งาน</label>
                                </div>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <h6 class="text-muted mb-3"><i class='bx bx-time me-1'></i> วัน-เวลา</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selector" type="text" id="booking_dateStart" name="booking_dateStart" placeholder="เริ่ม" required value="<?=$Booking[0]->booking_dateStart?>">
                                    <label>เริ่มวันที่</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selectorTime" type="text" id="booking_timeStart" name="booking_timeStart" placeholder="เวลา" required value="<?=$Booking[0]->booking_timeStart?>">
                                    <label>เวลา</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selector" type="text" id="booking_dateEnd" name="booking_dateEnd" placeholder="สิ้นสุด" required value="<?=$Booking[0]->booking_dateEnd?>">
                                    <label>ถึงวันที่</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-floating">
                                    <input class="form-control selectorTime" type="text" id="booking_timeEnd" name="booking_timeEnd" placeholder="เวลา" required value="<?=$Booking[0]->booking_timeEnd?>">
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
                                <option value="" disabled>-- เลือกประเภท --</option>
                                <?php foreach (['ประชุม','อบรม','สัมนา','จัดเลี้ยง','จัดกิจกรรม'] as $type) : ?>
                                <option value="<?=$type?>" <?=$Booking[0]->booking_typeuse == $type ? 'selected' : ''?>><?=$type?></option>
                                <?php endforeach; ?>
                            </select>
                            <label>ประเภทการใช้งาน</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">อุปกรณ์ที่ต้องการ</label>
                            <div class="row g-2">
                                <?php 
                                $SubEquipment = explode("|",$Booking[0]->booking_equipment);
                                foreach(['เครื่องคอมพิวเตอร์', 'จอโปรเจ็คเตอร์', 'เครื่องฉายแผ่นใส', 'เครื่องขยายเสียง'] as $eq): 
                                    $checked = in_array($eq, $SubEquipment) ? 'checked' : '';
                                ?>
                                <div class="col-6 col-sm-4 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="booking_equipment[]" id="eq_<?=$eq?>" value="<?=$eq?>" <?=$checked?>>
                                        <label class="form-check-label" for="eq_<?=$eq?>"><?=$eq?></label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-4 form-floating">
                            <textarea id="booking_other" name="booking_other" class="form-control" style="height: 80px" placeholder="หมายเหตุ"><?=$Booking[0]->booking_other?></textarea>
                            <label>หมายเหตุ / คำขออื่นๆ</label>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label class="form-label"><i class='bx bx-image-add me-1'></i> รูปภาพประกอบ (ถ้ามี)</label>
                            <?php if($Booking[0]->booking_imgWork): ?>
                                <div class="mb-2">
                                    <img src="<?=base_url('uploads/User/Booking/'.$Booking[0]->booking_imgWork)?>" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            <?php endif; ?>
                            <button type="button" class="btn btn-outline-primary d-block" data-bs-toggle="modal" data-bs-target="#imageModal">
                                <i class='bx bx-upload me-1'></i> เลือกรูปภาพใหม่
                            </button>
                            <canvas id="croppedCanvas" style="display:none; margin-top: 1rem; max-width: 100%;"></canvas>
                            <input type="hidden" id="booking_imgWork" name="booking_imgWork" value="">
                        </div>

                        <hr class="my-4">

                        <!-- Contact Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" value="<?=$_SESSION['username']?>" readonly disabled>
                                    <label>ผู้จอง</label>
                                </div>
                                <input type="hidden" name="booking_Booker" value="<?=$Booking[0]->booking_Booker?>">
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" id="booking_telephone" name="booking_telephone" class="form-control" placeholder="เบอร์โทร" required value="<?=$Booking[0]->booking_telephone?>">
                                    <label>เบอร์โทรศัพท์</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="BtnSubBooking" class="btn btn-primary btn-lg w-100">
                            <i class='bx bx-save me-2'></i>บันทึกการแก้ไข
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
    const form = document.getElementById('FormEditBooking');
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
            title: 'ยืนยันการแก้ไข?',
            text: 'ตรวจสอบข้อมูลให้ถูกต้องก่อนบันทึก',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            cancelButtonText: 'ยกเลิก'
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
                            title: 'แก้ไขสำเร็จ!',
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
