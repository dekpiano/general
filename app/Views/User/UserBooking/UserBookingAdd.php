<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

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
                            <form id="FormAddBooking" class="needs-validation" novalidate>
                                <div class="row mb-3">
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
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" id="" name="" class="form-control"
                                                placeholder="ชื่อผู้จอง" value="<?=$_SESSION['username']?>" readonly>
                                            <label for="">ชื่อผู้จอง</label>
                                        </div>
                                        <input type="hidden" id="booking_Booker" name="booking_Booker"
                                            class="form-control" value="<?=$_SESSION['id']?>" readonly required>
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
</div>
<!-- / Layout page -->