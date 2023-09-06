<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> <a href="<?=base_url('Booking/Select');?>">สถานที่</a>  /</span> จองห้องสถานที่</h4>

            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card">
                        <img class="card-img-top" src="<?=base_url('uploads/admin/LocationRoom/'.$loca->location_img)?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?=$loca->location_name?></h5>
                            <p class="card-text">
                                <?=$loca->location_detail?>
                            </p>                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-8 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="FormAddBooking">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="">ชื่อห้อง</label>
                                        <input type="text" id="" name=""
                                            class="form-control" placeholder="ชื่อห้อง" value="<?=$loca->location_name?>" readonly>
                                            <input type="hidden" id="booking_locationroom" name="booking_locationroom"
                                            class="form-control" placeholder="ชื่อห้อง" value="<?=$loca->location_ID?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_number">จำนวนผู้เข้าร่วม</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" id="booking_number" name="booking_number"
                                                class="form-control" placeholder="ใส่จำนวนผู้เข้าร่วม">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="booking_title">หัวข้อ</label>
                                    <input type="text" class="form-control" id="booking_title" name="booking_title"
                                        placeholder="หัวข้อที่ใช้">
                                </div>
                                <style>
                                .active{
                                    background-color: transparent;
                                }
                                </style>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_dateStart">วันที่เริ่มต้น</label>
                                        <input class="form-control selector" type="date" value=""
                                            id="booking_dateStart" name="booking_dateStart" placeholder="เลือกวันที่เริ่มต้น" >
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_timeStart">เวลาที่เริ่มต้น</label>
                                        <input class="form-control" type="time" value=""
                                            id="booking_timeStart" name="booking_timeStart" placeholder="เลือกเวลาที่เริ่มต้น">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_dateEnd">วันสิ้นสุด</label>
                                        <input class="form-control selector" type="date" value=""
                                            id="booking_dateEnd" name="booking_dateEnd" placeholder="เลือกวันสิ้นสุด">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_timeEnd">เวลาที่สิ้นสุด</label>
                                        <input class="form-control" type="time" value=""
                                            id="booking_timeEnd" name="booking_timeEnd" placeholder="เลือกเวลาที่สิ้นสุด">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="booking_timeEnd">ใช้สำหรับ</label>
                                    <select class="form-select" aria-label="Default select example" id="booking_typeuse"
                                        name="booking_typeuse">
                                        <option value="ประชุม">ประชุม</option>
                                        <option value="อบรม">อบรม</option>
                                        <option value="สัมนา">สัมนา</option>
                                        <option value="จัดเลี้ยง">จัดเลี้ยง</option>
                                    </select>
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
                                <div class="mb-3">
                                    <label class="form-label" for="booking_other">อื่น ๆ</label>
                                    <textarea id="booking_other" name="booking_other" class="form-control"
                                        placeholder=""></textarea>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="">ชื่อผู้จอง</label>
                                        <input type="text" id="" name="" class="form-control"
                                            placeholder="ชื่อผู้จอง" value="<?=$_SESSION['username']?>" readonly>
                                            <input type="hidden" id="booking_Booker" name="booking_Booker" class="form-control"
                                            placeholder="ชื่อผู้จอง" value="<?=$_SESSION['id']?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_telephone">เบอร์โทรศัพท์</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" id="booking_telephone" name="booking_telephone"
                                                class="form-control" placeholder="ใส่เบอร์โทรศัพท์">
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
