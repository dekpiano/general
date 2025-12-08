<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="<?=base_url('Repair')?>">งานแจ้งซ่อม</a> /</span> <?=$title?>
    </h4>

    <form id="FormAddRepair" enctype="multipart/form-data" class="needs-validation" novalidate>
        
        <!-- Card 1: Requester & Location -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">ข้อมูลผู้แจ้งและสถานที่</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">วันที่แจ้งซ่อม</label>
                        <p class="form-control-plaintext fw-bold"><?=$Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')))?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">ตำแหน่ง</label>
                        <select name="repair_posi" id="repair_posi" class="form-select" required>
                            <option value="" selected disabled>-- เลือกตำแหน่ง --</option>
                            <?php foreach ($Posi as $v_Posi) :?>
                            <option value="<?=$v_Posi->posi_id?>"><?=$v_Posi->posi_name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">ชื่อผู้แจ้งซ่อม</label>
                        <select name="repair_userID" id="repair_userID" class="form-select" required>
                            <option value="" selected disabled>-- เลือกผู้แจ้ง --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">อาคาร</label>
                        <select name="repair_building" id="repair_building" class="form-select" required>
                            <option value="" selected disabled>-- เลือก --</option>
                            <option value="อาคาร 1">อาคาร 1</option>
                            <option value="อาคาร 2">อาคาร 2</option>
                            <option value="อาคาร 3">อาคาร 3</option>
                            <option value="อาคาร 4">อาคาร 4</option>
                            <option value="อาคาร 5">อาคาร 5 โรงอาหาร</option>
                            <option value="อาคาร 6">อาคาร 6</option>
                            <option value="อาคาร 7">อาคาร 7</option>
                            <option value="อาคาร 8">อาคาร 8</option>
                            <option value="อาคาร 9">อาคาร 9</option>
                            <option value="อาคารเจ้าพระยา">อาคารเจ้าพระยา</option>
                            <option value="อาคารกีฬา">อาคารกีฬา</option>
                            <option value="อาคารโดมเอนกประสงค์">อาคารโดมเอนกประสงค์</option>
                            <option value="อาคารเอนกประสงค์">อาคารเอนกประสงค์</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">ชั้น</label>
                        <select name="repair_class" id="repair_class" class="form-select" required>
                            <option value="" selected disabled>-- เลือก --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">ห้อง</label>
                        <input type="text" class="form-control" name="repair_room" id="repair_room" placeholder="Ex. 421">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">เบอร์โทรติดต่อ</label>
                        <input type="text" class="form-control" name="repair_phone" id="repair_phone" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Problem Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">รายละเอียดปัญหา</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">รายการแจ้งซ่อม</label>
                        <select name="repair_caselist" id="repair_caselist" class="form-select" required>
                            <option value="" selected disabled>-- เลือกประเภท --</option>
                            <option value="คอมพิวเตอร์/โปรเจคเตอร์">คอมพิวเตอร์/โปรเจคเตอร์</option>
                            <option value="ปริ้นเตอร์/สแกนเนอร์">ปริ้นเตอร์/สแกนเนอร์</option>
                            <option value="ระบบเครือข่าย">ระบบเครือข่าย</option>
                            <option value="โสตทัศนอุปกรณ์">โสตทัศนอุปกรณ์</option>
                            <option value="งานอาคารสถานที่">งานอาคารสถานที่</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ปัญหา / อาการ / หมายเหตุ</label>
                        <textarea id="repair_detail" name="repair_detail" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Evidence -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">หลักฐานการแจ้งซ่อม</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">รูปภาพ (ถ้ามี)</label>
                        <input type="file" class="form-control" id="repair_imguser" name="repair_imguser" 
                               onchange="document.getElementById('imageResult').src = window.URL.createObjectURL(this.files[0])">
                        <div class="mt-2 text-center p-3 border rounded bg-light" style="min-height: 200px;">
                            <img src="" id="imageResult" class="img-fluid rounded" style="max-height: 180px;">
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

        <!-- Submit -->
        <div class="text-center">
            <div class="h-captcha mb-3" data-sitekey="d81a802c-de6b-4de5-8a61-a87205c2de0a"></div>
            <button type="submit" class="btn btn-primary btn-lg" id="BtnSubRepair">บันทึกแจ้งซ่อม</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
