<?= $this->extend('User/UserLeyout/user_layout') ?>
<?= $this->section('content') ?>

<!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> <a
                        href="<?=base_url('Booking/Select');?>">สถานที่</a> /</span> จองห้องสถานที่</h4>

            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card mb-3">
                        <img class="card-img-top" src="<?=base_url('uploads/admin/LocationRoom/'.$loca->location_img)?>"
                            alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?=$loca->location_name?></h5>
                            <p class="card-text">
                                <?=$loca->location_detail?>
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-header">การจองวันนี้
                            <?=$Datethai->thai_date_fullmonth(strtotime(date('d-m-Y')))?></h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>หัวข้อ</th>
                                        <th>เวลา</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    <?php foreach ($BookignToday as $key => $value):
                                        if(date('Y-m-d') >= $value->booking_dateStart && date('Y-m-d') <= $value->booking_dateEnd): ?>
                                    <tr>
                                        <td><?=$value->booking_title?></td>
                                        <td><?=$value->booking_timeStart.' ถึง '.$value->booking_timeEnd?></td>
                                    </tr>
                                    <?php 
                                        endif;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-lg-8 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="FormAddBooking" class="needs-validation" novalidate
                                action="<?=base_url('Booking/DB/Insert')?>" method="POST">
                                <div class="row mb-3 g-3">
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" id="" name="" class="form-control" placeholder="ชื่อห้อง"
                                                value="<?=$BookLatest?>" readonly>
                                            <label for="">เลขที่จอง</label>
                                        </div>
                                        <input type="text" id="booking_order" name="booking_order"
                                            class="form-control-plaintext" value="<?=$BookLatest?>" hidden>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" id="" name="" class="form-control" placeholder="ชื่อห้อง"
                                                value="<?=$loca->location_name?>" readonly>
                                            <label for="">ชื่อห้อง</label>
                                        </div>
                                        <input type="hidden" id="booking_locationroom" name="booking_locationroom"
                                            class="form-control" value="<?=$loca->location_ID?>" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="number" id="booking_number" name="booking_number"
                                                class="form-control" placeholder="ใส่จำนวนผู้เข้าร่วม" required>
                                            <label for="booking_number">จำนวนผู้เข้าร่วม</label>
                                            <div class="invalid-feedback">
                                                ใส่จำนวนผู้เข้าร่วม
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="mb-3 form-floating">
                                    <input type="text" class="form-control" id="booking_title" name="booking_title"
                                        placeholder="หัวข้อที่ใช้" required>
                                    <label for="booking_title">หัวข้อ</label>
                                    <div class="invalid-feedback">
                                        ใส่หัวข้อที่ใช้
                                    </div>
                                </div>

                                <div class="row mb-3 g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control selector" type="text" id="booking_dateStart"
                                                name="booking_dateStart" placeholder="เลือกวันที่เริ่มต้น" required>
                                            <label for="booking_dateStart">วันที่เริ่มต้น</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            เลือกวันที่เริ่มต้น
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control selectorTime" type="text" id="booking_timeStart"
                                                name="booking_timeStart" placeholder="เลือกเวลาที่เริ่มต้น" required>
                                            <label for="booking_timeStart">เวลาที่เริ่มต้น</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            เลือกเวลาที่เริ่มต้น
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control selector" type="text" id="booking_dateEnd"
                                                name="booking_dateEnd" placeholder="เลือกวันสิ้นสุด" required>
                                            <label for="booking_dateEnd">วันสิ้นสุด</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            เลือกวันสิ้นสุด
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control selectorTime" type="text" id="booking_timeEnd"
                                                name="booking_timeEnd" placeholder="เลือกเวลาที่สิ้นสุด" required>
                                            <label for="booking_timeEnd">เวลาที่สิ้นสุด</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            เลือกเวลาที่สิ้นสุด
                                        </div>
                                    </div>
                                    <div class="alert-warning" id="AlertMessage"></div>

                                </div>

                                <div class="mb-3 form-floating">
                                    <select class="form-select" id="booking_typeuse" name="booking_typeuse" required>
                                        <?php $typeuse = array('ประชุม','อบรม','สัมนา','จัดเลี้ยง','จัดกิจกรรม');
                                        foreach ($typeuse as $key => $v_typeuse) : ?>
                                        <option value="<?=$v_typeuse?>"><?=$v_typeuse?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="booking_typeuse">ใช้สำหรับ</label>
                                    <div class="invalid-feedback">
                                        เลือกประเภทการใช้ห้อง
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company">อุปกรณ์ที่ใช้</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="booking_equipment[]"
                                                id="booking_equipment1" value="เครื่องคอมพิวเตอร์">
                                            <label class="form-check-label"
                                                for="booking_equipment1">เครื่องคอมพิวเตอร์</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="booking_equipment[]"
                                                id="booking_equipment2" value="จอโปรเจ็คเตอร์">
                                            <label class="form-check-label"
                                                for="booking_equipment2">จอโปรเจ็คเตอร์</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="booking_equipment[]"
                                                id="booking_equipment3" value="เครื่องฉายแผ่นใส">
                                            <label class="form-check-label"
                                                for="booking_equipment3">เครื่องฉายแผ่นใส</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="booking_equipment[]"
                                                id="booking_equipment4" value="เครื่องขยายเสียง">
                                            <label class="form-check-label"
                                                for="booking_equipment4">เครื่องขยายเสียง</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 form-floating">
                                    <textarea id="booking_other" name="booking_other" class="form-control"
                                        placeholder=""></textarea>
                                    <label for="booking_other">คำขออื่น ๆ</label>
                                </div>

                                <h6>📷 เลือกรูปภาพ สำหรับผังงาน หรือรายละเอียดอื่น ๆ : (แนบรูปหรือไม่แนบก็ได้)</h6>
                                <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#imageModal">เลือกรูปภาพ</a>

                                <!-- Bootstrap Modal -->
                                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">เลือกรูปภาพ</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ** กรุณาถ่ายรูปเป็นแนวนอน **
                                                <input type="file" id="imageInput" accept="image/*"
                                                    class="form-control">
                                                <div id="croppieContainer" class="mt-3"></div>
                                                <button type="button" class="btn btn-warning" id="rotateLeftBtn">⟲
                                                    หมุนซ้าย</button>
                                                <button type="button" class="btn btn-warning" id="rotateRightBtn">⟳
                                                    หมุนขวา</button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">ปิด</button>
                                                <button type="button" class="btn btn-success" id="cropBtn">✅
                                                    ครอบรูป</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <canvas id="croppedCanvas" width="100%" style="display:none;"></canvas>
                                <input type="hidden" id="booking_imgWork" name="booking_imgWork" class="form-control">
                                <hr>
                                <div class="row mb-3 g-3">
                                    <div class="col-md-6">
                                        <?php   
                                           $ExRloes = explode(",",$_SESSION['rloes']);                                           
                                           if(!in_array('งานอาคารสถานที่', $ExRloes)) : ?>
                                        <div class="form-floating">
                                            <input type="text" id="" name="" class="form-control"
                                                placeholder="ชื่อผู้จอง" value="<?=$_SESSION['username']?>" readonly>
                                            <label for="">ชื่อผู้จอง </label>
                                        </div>
                                        <input type="hidden" id="booking_Booker" name="booking_Booker"
                                            class="form-control" value="<?=$_SESSION['id']?>" readonly required>
                                        <?php else: ?>
                                        <style>
                                        .form-floating .select2-container+.hidden-label {
                                            display: none;
                                        }
                                        </style>
                                        <div class="form-floating">
                                            <select class="form-select select2Teach" id="booking_Booker"
                                                name="booking_Booker" required>
                                                <option value="">-- เลือกผู้จอง --</option>
                                                <?php foreach ($ListUser as $key => $value): ?>
                                                <option value="<?=$value->pers_id?>">
                                                    <?=$value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="">ชื่อผู้จอง </label>
                                        </div>

                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" id="booking_telephone" name="booking_telephone"
                                                class="form-control" placeholder="ใส่เบอร์โทรศัพท์">
                                            <label for="booking_telephone">เบอร์โทรศัพท์</label>
                                        </div>
                                        <div class="invalid-feedback">
                                            ใส่เบอร์โทรศัพท์
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="BtnSubBooking" class="btn btn-primary">จอง</button>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- Content wrapper -->
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('FormAddBooking');
    const btnSubmit = document.getElementById('BtnSubBooking');

    btnSubmit.addEventListener('click', function(event) {
        event
            .preventDefault(); // Prevent default form submission

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        const formData = new FormData(form);
        let tableRows = '';

        const bookingOrder = "<?=$BookLatest?>";
        const locationName = "<?=$loca->location_name?>";
        const bookerName =
            "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>";

        tableRows +=
            `<tr><td><b>เลขที่จอง</b></td><td>${bookingOrder}</td></tr>`;
        tableRows +=
            `<tr><td><b>ชื่อห้อง</b></td><td>${locationName}</td></tr>`;
        tableRows +=
            `<tr><td><b>ชื่อผู้จอง</b></td><td>${bookerName}</td></tr>`;

        // Create a temporary object to hold all form data, handling multiple values for the same key
        const tempFormData = {};
        for (let [key, value] of formData.entries()) {
            if (key.endsWith(
                    '[]')) { // Handle array-like inputs (e.g., checkboxes)
                if (!tempFormData[key]) {
                    tempFormData[key] = [];
                }
                tempFormData[key].push(value);
            } else {
                tempFormData[key] = value;
            }
        }

        // Now iterate through the collected data to build table rows
        for (const key in tempFormData) {
            // Skip keys that are already displayed as static data or are internal
            if (key === 'booking_order' || key ===
                'booking_locationroom' || key ===
                'booking_imgWork' || key ===
                'booking_Booker') {
                continue;
            }

            let value = tempFormData[key];
            let label = '';

            if (key === 'booking_equipment[]') {
                label = 'อุปกรณ์ที่ใช้';
                value = value.join(
                    ', '); // Join array values with comma
            } else {
                switch (key) {
                    case 'booking_number':
                        label = 'จำนวนผู้เข้าร่วม';
                        break;
                    case 'booking_title':
                        label = 'หัวข้อ';
                        break;
                    case 'booking_dateStart':
                        label = 'วันที่เริ่มต้น';
                        break;
                    case 'booking_timeStart':
                        label = 'เวลาที่เริ่มต้น';
                        break;
                    case 'booking_dateEnd':
                        label = 'วันสิ้นสุด';
                        break;
                    case 'booking_timeEnd':
                        label = 'เวลาที่สิ้นสุด';
                        break;
                    case 'booking_typeuse':
                        label = 'ใช้สำหรับ';
                        break;
                    case 'booking_other':
                        label = 'คำขออื่น ๆ';
                        break;
                    case 'booking_telephone':
                        label = 'เบอร์โทรศัพท์';
                        break;
                    default:
                        label = key;
                }
            }
            tableRows +=
                `<tr><td><b>${label}</b></td><td>${value}</td></tr>`;
        }

        let imageHtml = '';
        const bookingImgWork = formData.get(
            'booking_imgWork');
        if (bookingImgWork) {
            imageHtml =
                `<p><b>รูปภาพประกอบ:</b></p><img src="${bookingImgWork}" style="max-width: 100%; height: auto; display: block; margin: 10px auto;">`;
        }

        Swal.fire({
            title: 'ยืนยันการจองสถานที่?',
            html: `<p style="font-size: 0.9em;">โปรดตรวจสอบข้อมูลให้ถูกต้องก่อนยืนยัน:</p>
                       <div style="overflow-x: auto;">
                           <table class="table table-bordered table-striped" style="font-size: 0.85em;">
                               <tbody>
                                   ${tableRows}
                               </tbody>
                           </table>
                       </div>
                       ${imageHtml}`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ยืนยันการจอง!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form via AJAX
                fetch(form.action, {
                        method: form.method,
                        body: formData
                    })
                    .then(response => response
                        .json())
                    .then(data => {
                        if (data.status ===
                            'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: data
                                    .message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window
                                    .location
                                    .href =
                                    `<?=base_url('Booking/View/')?>${data.location_id}`;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                text: data
                                    .message,
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:',
                            error);
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                        });
                    });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>