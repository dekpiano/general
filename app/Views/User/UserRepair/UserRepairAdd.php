<style>
/* .fc-event-desc,
.fc-event-title {
    white-space: break-spaces;
} */
</style>
<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href="<?=base_url('Repair')?>">งานแจ้งซ่อม</a> /</span> <?=$title?>
            </h4>

            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">ข้อมูลทั่วไป</h5>
                </div>
                <div class="card-body">
                    <form id="FormAddRepair" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="col-form-label" for="basic-default-name">วันที่แจ้งซ่อม</label>
                                <div>
                                    <?php echo $Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')));?>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="repair_posi">ตำแหน่ง</label>
                                <select name="repair_posi" id="repair_posi" class="form-select" required>
                                    <option value="" selected="" disabled="">-- กรุณาเลือกตำแหน่ง --</option>
                                    <?php foreach ($Posi as $key => $v_Posi) :?>
                                    <option value="<?=$v_Posi->posi_id?>"> <?=$v_Posi->posi_name?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    กรุณาเลือกตำแหน่ง
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="repair_userID">ชื่อผู้แจ้งซ่อม</label>
                                <select name="repair_userID" id="repair_userID" class="form-select" required>
                                    <option value="" selected="" disabled="">-- กรุณาเลือกชื่อผู้แจ้งซ่อม --</option>
                                </select>
                                <div class="invalid-feedback">
                                กรุณาเลือกชื่อผู้แจ้งซ่อม
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label" for="repair_building">อาคาร</label>
                                <select name="repair_building" id="repair_building" class="form-select" required="">
                                    <option value="" selected="" disabled="">-- กรุณาเลือกอาคาร --</option>
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
                                <div class="invalid-feedback">
                                กรุณาเลือกอาคาร
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label" for="repair_class">ชั้น</label>
                                <select name="repair_class" id="repair_class" class="form-select" required>
                                    <option value="" selected="" disabled="">-- กรุณาเลือกชั้น --</option>
                                    <option value="1"> 1</option>
                                    <option value="2"> 2</option>
                                    <option value="3"> 3</option>
                                    <option value="4"> 4</option>
                                </select>
                                <div class="invalid-feedback">
                                กรุณาเลือกชั้น
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label" for="repair_room">ห้อง</label>
                                <input type="text" class="form-control" name="repair_room" id="repair_room"
                                    placeholder="Ex. 421 ">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label" for="repair_phone">เบอร์โทรติดต่อ</label>
                                <input type="text" class="form-control" name="repair_phone" id="repair_phone"
                                    placeholder="ระบุเบอร์โทรติดต่อได้" required>
                                    <div class="invalid-feedback">
                                กรุณากรอกเบอร์โทรติดต่อ
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="col-form-label" for="repair_caselist">รายการแจ้งซ่อม</label>
                                <select name="repair_caselist" id="repair_caselist" class="form-select" required="">
                                    <option value="" selected="" disabled="">-- กรุณาระบุรายการแจ้งซ่อม --</option>
                                    <option value="คอมพิวเตอร์/โปรเจคเตอร์"> คอมพิวเตอร์/โปรเจคเตอร์</option>
                                    <option value="ปริ้นเตอร์/สแกนเนอร์"> ปริ้นเตอร์/สแกนเนอร์</option>
                                    <option value="ระบบเครือข่าย"> ระบบเครือข่าย</option>
                                    <option value="โสตทัศนอุปกรณ์"> โสตทัศนอุปกรณ์</option>
                                    <option value="งานอาคารสถานที่"> งานอาคารสถานที่</option>
                                </select>
                                <div class="invalid-feedback">
                                กรุณาระบุรายการแจ้งซ่อม
                                </div>

                                <label class="col-form-label" for="repair_detail">ปัญหา /อาการ / หมายเหตุ</label>
                                <textarea id="repair_detail" name="repair_detail" class="form-control"
                                    placeholder="ปัญหา /อาการ / หมายเหตุ" required></textarea>
                                    <div class="invalid-feedback">
                                กรุณาระบุอาการเสีย
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="text-center">
                                    <h5 class="">รูปภาพแจ้งซ่อม <small>(อาการเสียหรือปัญหา)</small></h5>
                                    <small>** จะอัพโหลดไฟล์ภาพหรือไม่โหลดก็ได้ ** (ให้ถ่ายรูปแนวนอน)</small>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="repair_imguser"
                                            name="repair_imguser"
                                            onchange="document.getElementById('imageResult').src = window.URL.createObjectURL(this.files[0])">
                                        <label class="input-group-text" for="repair_imguser">เลือกรูปภาพ</label>
                                    </div>
                                    <img src="" id="imageResult" class="img-fluid" alt="">
                                </div>

                            </div>
                        </div>

                        <div class="row ">
                            <style>
                            canvas {
                                border: 2px solid #000;

                                max-width: 500px;
                                /* ป้องกันการขยายเกิน */
                                height: 200px;
                                background-color: #fff;
                            }
                            </style>
                            <center>
                                <div class="">
                                    <div>
                                        ลายมือชื่อผู้แจ้งซ่อม
                                    </div>
                                    <canvas id="signature-pad" width=350 height=200></canvas><br>
                                    <a href="javascript:;" class="btn btn-sm btn-warning" id="clear">ล้างลายเซ็น</a>
                                </div>
                            </center>


                            <div class="col-12 text-center mt-5">
                                <div class="h-captcha" data-sitekey="d81a802c-de6b-4de5-8a61-a87205c2de0a"></div>
                                <button type="submit" class="btn btn-primary" id="BtnSubRepair">บันทึกแจ้งซ่อม</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>