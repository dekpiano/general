<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"> <a
                        href="<?=base_url('Booking/Select');?>">สถานที่</a> /</span> แก้ไขการจองห้องสถานที่</h4>

            <div class="row">               
                <div class="col-md-12 col-lg-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="FormEditBooking" class="needs-validation" novalidate>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input type="hidden" name="booking_id" id="booking_id" value="<?=$Booking[0]->booking_id?>">
                                        <label class="form-label" for="">ชื่อห้อง</label>
                                        <select class="form-select" name="booking_locationroom" id="booking_locationroom">
                                            <?php foreach ($LocationList as $key => $v_LocationList) :?>
                                            <option <?=$Booking[0]->location_ID == $v_LocationList->location_ID ?"selected":""?> value="<?=$v_LocationList->location_ID?>"><?=$v_LocationList->location_name?></option>
                                            <?php endforeach; ?>
                                        </select>   

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_number">จำนวนผู้เข้าร่วม</label>
                                        <div class="input-group input-group-merge">
                                            <input type="number" id="booking_number" name="booking_number"
                                                class="form-control" placeholder="ใส่จำนวนผู้เข้าร่วม" required value="<?=$Booking[0]->booking_number?>">
                                        </div>
                                        <div class="invalid-feedback">
                                            ใส่จำนวนผู้เข้าร่วม
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="booking_title">หัวข้อ</label>
                                    <input type="text" class="form-control" id="booking_title" name="booking_title"
                                        placeholder="หัวข้อที่ใช้" required value="<?=$Booking[0]->booking_title?>">
                                    <div class="invalid-feedback">
                                        ใส่หัวข้อที่ใช้
                                    </div>
                                </div>
                                <style>
                                .active {
                                    background-color: transparent;
                                }
                                </style>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_dateStart">วันที่เริ่มต้น</label>
                                        <input class="form-control selectorEdit" type="text" value="<?=$Booking[0]->booking_dateStart?>" id="booking_dateStart"
                                            name="booking_dateStart" placeholder="เลือกวันที่เริ่มต้น" required>
                                        <div class="invalid-feedback">
                                            เลือกวันที่เริ่มต้น
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_timeStart">เวลาที่เริ่มต้น</label>
                                        <input class="form-control selectorTime" type="text" value="<?=$Booking[0]->booking_timeStart?>"
                                            id="booking_timeStart" name="booking_timeStart"
                                            placeholder="เลือกเวลาที่เริ่มต้น" required>
                                        <div class="invalid-feedback">
                                            เลือกเวลาที่เริ่มต้น
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_dateEnd">วันสิ้นสุด</label>
                                        <input class="form-control selectorEdit" type="text" value="<?=$Booking[0]->booking_dateEnd?>" id="booking_dateEnd"
                                            name="booking_dateEnd" placeholder="เลือกวันสิ้นสุด" required>
                                        <div class="invalid-feedback">
                                            เลือกวันสิ้นสุด
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_timeEnd">เวลาที่สิ้นสุด</label>
                                        <input class="form-control selectorTime" type="text" value="<?=$Booking[0]->booking_timeEnd?>"
                                            id="booking_timeEnd" name="booking_timeEnd"
                                            placeholder="เลือกเวลาที่สิ้นสุด" required>
                                        <div class="invalid-feedback">
                                            เลือกเวลาที่สิ้นสุด
                                        </div>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="booking_typeuse">ใช้สำหรับ</label>
                                    <select class="form-select" aria-label="Default select example" id="booking_typeuse"
                                        name="booking_typeuse" required>
                                        <?php $typeuse = array('ประชุม','อบรม','สัมนา','จัดเลี้ยง','จัดกิจกรรม');
                                        foreach ($typeuse as $key => $v_typeuse) : ?>
                                        <option <?=$Booking[0]->booking_typeuse == $typeuse ?"selected":""?> value="<?=$v_typeuse?>"><?=$v_typeuse?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        เลือกประเภทการใช้ห้อง
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company">อุปกรณ์ที่ใช้</label>
                                    <div>
                                        <?php $equipment = array('เครื่องคอมพิวเตอร์','จอโปรเจ็คเตอร์','เครื่องฉายแผ่นใส','เครื่องขยายเสียง');?>
                                        <?php $SubEquipment = explode("|",$Booking[0]->booking_equipment); 
                                        //print_r($SubEquipment);?>
                                        <?php foreach ($equipment as $key => $v_equipment) :?>
                                           <?php if(in_array($v_equipment,$SubEquipment)){ $checked = "checked"; }else{ $checked = "";} ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="booking_equipment[]" <?=$checked;?>
                                                id="booking_equipment<?=$key?>" value="<?=$v_equipment?>">
                                            <label class="form-check-label"
                                                for="booking_equipment<?=$key?>"><?=$v_equipment?></label>
                                        </div>

                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="booking_other">อื่น ๆ</label>
                                    <textarea id="booking_other" name="booking_other" class="form-control"
                                        placeholder=""><?=$Booking[0]->booking_other?></textarea>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="">ชื่อผู้จอง</label>
                                        <input type="text" id="" name="" class="form-control" placeholder="ชื่อผู้จอง"
                                            value="<?=$_SESSION['username']?>" readonly>
                                        <input type="hidden" id="booking_Booker" name="booking_Booker"
                                            class="form-control" placeholder="ชื่อผู้จอง" value="<?=$_SESSION['id']?>"
                                            readonly required>
                                        <div class="invalid-feedback">
                                            ใส่ชื่อผู้จอง
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="booking_telephone">เบอร์โทรศัพท์</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" id="booking_telephone" name="booking_telephone" value="<?=$Booking[0]->booking_telephone?>"
                                                class="form-control" placeholder="ใส่เบอร์โทรศัพท์" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            ใส่เบอร์โทรศัพท์
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="BtnSubBooking" class="btn btn-primary">แก้ไขการจอง</button>
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