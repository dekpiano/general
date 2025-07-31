<style>
.location-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid #eee; /* Light border for definition */
    border-radius: 10px;
    overflow: hidden;
    background-color: #fff; /* Ensure card background is white */
}

.location-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.location-card .card-img-top {
    height: 180px;
    object-fit: cover;
}

/* Pastel Border and Text Colors */
.border-pastel-blue {
    border-top: 5px solid #a7d9f0; /* A slightly darker pastel blue for the border */
}
.text-pastel-blue {
    color: #6bb2d1; /* A darker shade for text */
}

.border-pastel-green {
    border-top: 5px solid #b2e0b2; /* Pastel green for the border */
}
.text-pastel-green {
    color: #7ac17a; /* A darker shade for text */
}

.border-pastel-yellow {
    border-top: 5px solid #ffe0b2; /* Pastel yellow for the border */
}
.text-pastel-yellow {
    color: #d1a76b; /* A darker shade for text */
}

.location-card .card-text {
    color: #555;
}
</style>
<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
        <div class="row mb-5">
            <?php  $TypeLocation = ['ห้อง','อาคาร','สนาม'];
            foreach ($TypeLocation as $key => $v_TypeLocation) : ?>
                 <h4 class="mt-3"><i class='bx bx-door-open me-2'></i>ประเภท <?=$v_TypeLocation;?></h4>
                <hr>
            <?php foreach ($LocationRoomAll as $key => $v_LocationRoom): 
                if($v_LocationRoom->location_category == $v_TypeLocation):?>
               
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card location-card h-100 <?php
                        if ($v_LocationRoom->location_category == 'ห้อง') echo 'border-pastel-blue';
                        else if ($v_LocationRoom->location_category == 'อาคาร') echo 'border-pastel-green';
                        else if ($v_LocationRoom->location_category == 'สนาม') echo 'border-pastel-yellow';
                    ?>">
                        <img class="lazy-load card-img-top"
                        data-src="<?=base_url('uploads/admin/LocationRoom/'.$v_LocationRoom->location_img)?>"
                            alt="<?=$v_LocationRoom->location_name?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title <?php
                                if ($v_LocationRoom->location_category == 'ห้อง') echo 'text-pastel-blue';
                                else if ($v_LocationRoom->location_category == 'อาคาร') echo 'text-pastel-green';
                                else if ($v_LocationRoom->location_category == 'สนาม') echo 'text-pastel-yellow';
                            ?>"><?=$v_LocationRoom->location_name?></h5>
                            <p class="card-text flex-grow-1">
                                <?=$v_LocationRoom->location_detail;?>
                            </p>
                            <div class="d-flex justify-content-between mt-auto">
                                <div>
                                    <?php if(isset($_SESSION['username'])):?>
                                    <a href="<?=base_url('Booking/Add/'.$v_LocationRoom->location_ID)?>"
                                        class="btn btn-primary">
                                        <i class='bx bx-calendar-plus me-1'></i>จอง
                                    </a>
                                    <?php else: ?>
                                    <a href="#" data-url="<?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>"
                                        class="btn btn-primary CheckUserLogin">
                                        <i class='bx bx-calendar-plus me-1'></i> จอง
                                    </a>
                                    <?php endif;?>
                                </div>

                                <div>
                                    <a href="<?=base_url('Booking/View/'.$v_LocationRoom->location_ID)?>"
                                        class="btn btn-outline-secondary">
                                        ดูการจอง
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           
                <?php endif; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มการจอง</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="col-xl">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="booking_locationroom">ชื่อห้อง</label>
                                <input type="text" id="booking_locationroom" name="booking_locationroom"
                                    class="form-control" placeholder="ชื่อห้อง">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="booking_number">จำนวนผู้เข้าร่วม</label>
                                <div class="input-group input-group-merge">
                                    <input type="number" id="booking_number" name="booking_number" class="form-control"
                                        placeholder="ใส่จำนวนผู้เข้าร่วม">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="booking_title">หัวข้อ</label>
                            <input type="text" class="form-control" id="booking_title" name="booking_title"
                                placeholder="หัวข้อที่ใช้">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" for="booking_dateStart">วันที่เริ่มต้น</label>
                                <input class="form-control" type="date" value="<?=date("Y-m-d")?>"
                                    id="booking_dateStart" name="booking_dateStart">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="booking_timeStart">เวลาที่เริ่มต้น</label>
                                <input class="form-control" type="time" value="<?=date("H:i")?>" id="booking_timeStart"
                                    name="booking_timeStart">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="booking_dateEnd">วันสิ้นสุด</label>
                                <input class="form-control" type="date" value="<?=date("Y-m-d")?>" id="booking_dateEnd"
                                    name="booking_dateEnd">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="booking_timeEnd">เวลาที่สิ้นสุด</label>
                                <input class="form-control" type="time" value="<?=date("H:i")?>" id="booking_timeEnd"
                                    name="booking_timeEnd">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="booking_timeEnd">ใช้สำหรับ</label>
                            <select class="form-select" aria-label="Default select example" id="booking_timeEnd"
                                name="booking_timeEnd">
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
                                    <label class="form-check-label" for="booking_equipment1">เครื่องคอมพิวเตอร์</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="booking_equipment[]"
                                        id="booking_equipment2" value="option2">
                                    <label class="form-check-label" for="booking_equipment2">จอโปรเจ็คเตอร์</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="booking_equipment[]"
                                        id="booking_equipment3" value="option2">
                                    <label class="form-check-label" for="booking_equipment3">เครื่องฉายแผ่นใส</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="booking_equipment[]"
                                        id="booking_equipment4" value="option2">
                                    <label class="form-check-label" for="booking_equipment4">เครื่องขยายเสียง</label>
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
                                <label class="form-label" for="booking_other">ชื่อผู้จอง</label>
                                <input type="text" id="booking_other" name="booking_other" class="form-control"
                                    placeholder="ชื่อผู้จอง">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="booking_other">เบอร์โทรศัพท์</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" id="booking_other" name="booking_other" class="form-control"
                                        placeholder="ใส่เบอร์โทรศัพท์">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">จอง</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>