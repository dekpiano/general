<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href="<?=base_url('Repair')?>">งานแจ้งซ่อม</a> /</span> <?=$title?>
            </h4>

            <form id="FormAddRepair" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="row">
                    <!-- Card 1: Requester & Location -->
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            <h5 class="card-header">ข้อมูลผู้แจ้งและสถานที่</h5>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">วันที่แจ้งซ่อม</label>
                                        <p class="form-control-static fw-bold"><?php echo $Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')));?></p>
                                    </div>
                                    <div class="col-md-4 form-floating">
                                        <select name="repair_posi" id="repair_posi" class="form-select" required>
                                            <option value="" selected disabled>-- กรุณาเลือกตำแหน่ง --</option>
                                            <?php foreach ($Posi as $v_Posi) :?>
                                            <option value="<?=$v_Posi->posi_id?>"> <?=$v_Posi->posi_name?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="repair_posi">ตำแหน่ง</label>
                                        <div class="invalid-feedback">กรุณาเลือกตำแหน่ง</div>
                                    </div>
                                    <div class="col-md-4 form-floating">
                                        <select name="repair_userID" id="repair_userID" class="form-select" required>
                                            <option value="" selected disabled>-- กรุณาเลือกชื่อผู้แจ้งซ่อม --</option>
                                        </select>
                                        <label for="repair_userID">ชื่อผู้แจ้งซ่อม</label>
                                        <div class="invalid-feedback">กรุณาเลือกชื่อผู้แจ้งซ่อม</div>
                                    </div>
                                    <div class="col-md-3 form-floating">
                                        <select name="repair_building" id="repair_building" class="form-select" required>
                                            <option value="" selected disabled>-- เลือก --</option>
                                            <option value="อาคาร 1"> อาคาร 1</option>
                                            <option value="อาคาร 2"> อาคาร 2</option>
                                            <option value="อาคาร 3"> อาคาร 3</option>
                                            <option value="อาคาร 4"> อาคาร 4</option>
                                            <option value="อาคาร 5"> อาคาร 5 โรงอาหาร</option>
                                            <option value="อาคาร 6"> อาคาร 6</option>
                                            <option value="อาคาร 7"> อาคาร 7</option>
                                            <option value="อาคาร 8"> อาคาร 8</option>
                                            <option value="อาคาร 9"> อาคาร 9</option>
                                            <option value="อาคารเจ้าพระยา"> อาคารเจ้าพระยา</option>
                                            <option value="อาคารกีฬา"> อาคารกีฬา</option>
                                            <option value="อาคารโดมเอนกประสงค์"> อาคารโดมเอนกประสงค์</option>
                                            <option value="อาคารเอนกประสงค์"> อาคารเอนกประสงค์</option>
                                        </select>
                                        <label for="repair_building">อาคาร</label>
                                        <div class="invalid-feedback">กรุณาเลือกอาคาร</div>
                                    </div>
                                    <div class="col-md-2 form-floating">
                                        <select name="repair_class" id="repair_class" class="form-select" required>
                                            <option value="" selected disabled>-- เลือก --</option>
                                            <option value="1"> 1</option>
                                            <option value="2"> 2</option>
                                            <option value="3"> 3</option>
                                            <option value="4"> 4</option>
                                        </select>
                                        <label for="repair_class">ชั้น</label>
                                        <div class="invalid-feedback">กรุณาเลือกชั้น</div>
                                    </div>
                                    <div class="col-md-2 form-floating">
                                        <input type="text" class="form-control" name="repair_room" id="repair_room" placeholder="Ex. 421">
                                        <label for="repair_room">ห้อง</label>
                                    </div>
                                    <div class="col-md-5 form-floating">
                                        <input type="text" class="form-control" name="repair_phone" id="repair_phone" placeholder="ระบุเบอร์โทรติดต่อได้" required>
                                        <label for="repair_phone">เบอร์โทรติดต่อ</label>
                                        <div class="invalid-feedback">กรุณากรอกเบอร์โทรติดต่อ</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Repair Details -->
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            <h5 class="card-header">รายละเอียดปัญหา</h5>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6 form-floating">
                                        <select name="repair_caselist" id="repair_caselist" class="form-select" required>
                                            <option value="" selected disabled>-- กรุณาระบุรายการ --</option>
                                            <option value="คอมพิวเตอร์/โปรเจคเตอร์"> คอมพิวเตอร์/โปรเจคเตอร์</option>
                                            <option value="ปริ้นเตอร์/สแกนเนอร์"> ปริ้นเตอร์/สแกนเนอร์</option>
                                            <option value="ระบบเครือข่าย"> ระบบเครือข่าย</option>
                                            <option value="โสตทัศนอุปกรณ์"> โสตทัศนอุปกรณ์</option>
                                            <option value="งานอาคารสถานที่"> งานอาคารสถานที่</option>
                                        </select>
                                        <label for="repair_caselist">รายการแจ้งซ่อม</label>
                                        <div class="invalid-feedback">กรุณาระบุรายการแจ้งซ่อม</div>
                                    </div>
                                    <div class="col-md-6 form-floating">
                                        <textarea id="repair_detail" name="repair_detail" class="form-control" placeholder="ระบุรายละเอียดของปัญหา..." required rows="3"></textarea>
                                        <label for="repair_detail">ปัญหา /อาการ / หมายเหตุ</label>
                                        <div class="invalid-feedback">กรุณาระบุอาการเสีย</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Evidence -->
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            <h5 class="card-header">หลักฐานการแจ้งซ่อม</h5>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">รูปภาพแจ้งซ่อม <small class="text-muted">(ถ้ามี)</small></label>
                                        <input type="file" class="form-control" id="repair_imguser" name="repair_imguser" onchange="document.getElementById('imageResult').src = window.URL.createObjectURL(this.files[0])">
                                        <div class="mt-2 text-center p-3 border rounded bg-light" style="min-height: 220px;">
                                            <img src="" id="imageResult" class="img-fluid rounded" alt="" style="max-height: 200px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">ลายมือชื่อผู้แจ้งซ่อม</label>
                                        <div class="border rounded p-3 text-center bg-light">
                                            <canvas id="signature-pad" class="border bg-white"></canvas><br>
                                            <a href="javascript:;" class="btn btn-sm btn-outline-secondary mt-2" id="clear">ล้างลายเซ็น</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submission -->
                    <div class="col-12 text-center">
                        <div class="h-captcha mb-3" data-sitekey="d81a802c-de6b-4de5-8a61-a87205c2de0a"></div>
                        <button type="submit" class="btn btn-primary btn-lg" id="BtnSubRepair">บันทึกแจ้งซ่อม</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
</div>