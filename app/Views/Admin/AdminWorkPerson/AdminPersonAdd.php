<!-- Layout container -->
<div class="layout-page">
    <?php echo view('Admin/AdminLeyout/AdminNavbar'); ?>


    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo ">
            <div class="card">
                <div class="card-header d-flex justify-content-between flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0"><?=$title;?></h5>
                    </div>
                </div>
            </div>

            <style>
            .btn-file {
                position: relative;
                overflow: hidden;
            }

            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                cursor: inherit;
                display: block;
            }
            </style>

            <form class="needs-validation" novalidate="" id="FormPersonnalAdd">
                <div class="row mt-3">
                    <div class="col-lg-3">
                        <!-- Profile picture card-->
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                <!-- Profile picture image-->
                                <img class="rounded-circle mb-2 img-fluid"
                                    src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                <!-- Profile picture help block-->
                                <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                <!-- Profile picture upload button-->
                                <span class="btn btn-primary btn-file">
                                    อัพโหลดรูปภาพ <input type="file" name="pers_img" id="pers_img">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header">ลงทะเบียนบุคลากรใหม่</div>
                            <div class="card-body">

                                <div class="row g-3">
                                    <div class="col-md-9">
                                        <label for="pers_status" class="form-label">สถานะผู้ใช้งาน</label>
                                        <select class="form-select" id="pers_status" name="pers_status" required="">
                                            <option value="กำลังใช้งาน">กำลังใช้งาน</option>
                                            <option value="ย้ายสถานศึกษา">ย้ายสถานศึกษา</option>
                                            <option value="ลาออก">ลาออก</option>
                                            <option value="เกษียรอายุ">เกษียรอายุ</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            กรุณากรอกเลือกสถานะผู้ใช้งาน
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="pers_id" class="form-label">รหัสประจำตัว</label>
                                        <input type="text" class="form-control" id="pers_id" name="pers_id"
                                            placeholder="" value="<?=$pers_id;?>" required="" readonly>
                                        <div class="invalid-feedback">
                                            กรุณากรอกชื่อจริง...
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="pers_prefix" class="form-label">คำนำหน้า</label>
                                        <select class="form-select" id="pers_prefix" name="pers_prefix" required="">
                                            <option value="">เลือก...</option>
                                            <option value="นาย">นาย</option>
                                            <option value="นาง">นาง</option>
                                            <option value="นางสาว">นางสาว</option>
                                            <option value="ว่าที่ร้อยตรี">ว่าที่ร้อยตรี</option>
                                            <option value="ว่าที่ร้อยตรีหญิง">ว่าที่ร้อยตรีหญิง</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            กรุณากรอกเลือกคำนำหน้า
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pers_firstname" class="form-label">ชื่อจริง</label>
                                        <input type="text" class="form-control" id="pers_firstname"
                                            name="pers_firstname" placeholder="" value="" required="">
                                        <div class="invalid-feedback">
                                            กรุณากรอกชื่อจริง...
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="pers_lastname" class="form-label">นามสกุล</label>
                                        <input type="text" class="form-control" id="pers_lastname" name="pers_lastname"
                                            placeholder="" value="" required="">
                                        <div class="invalid-feedback">
                                            กรุณากรอกนามสกุล...
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pers_britday" class="form-label">วันเกิด</label>
                                        <input type="text" class="form-control selector" id="pers_britday"
                                            name="pers_britday" placeholder="" value="" autocomplete="off">
                                        <div class="invalid-feedback">
                                            กรุณาเลือกวันเกิด
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pers_phone" class="form-label">เบอร์โทรศัพท์</label>
                                        <input type="tel" class="form-control" id="pers_phone" name="pers_phone"
                                            placeholder="" value="">
                                        <div class="invalid-feedback">
                                            กรุณากรอกเบอร์โทรศัพท์...
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <label for="pers_username" class="form-label">Email <span
                                                class="text-muted">(Optional)</span></label>
                                        <input type="email" class="form-control" id="pers_username"
                                            placeholder="ให้ใช้อีเมลของโรงเรียน" name="pers_username">
                                        <div class="invalid-feedback">
                                            กรุณากรอกอีเมล
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="col-md-4">
                                        <label for="pers_position" class="form-label">ตำแหน่งทางการศึกษา</label>
                                        <select class="form-select" id="pers_position" name="pers_position" required="">
                                            <option value="">เลือก...</option>
                                            <?php foreach ($position as $key => $value) : ?>
                                            <option value="<?=$value->posi_id;?>"><?=$value->posi_name;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            กรุณาเลือกตำแหน่งทางการศึกษา
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="pers_learning" class="form-label">กลุ่มสาระการเรียนรู้</label>
                                        <select class="form-select" id="pers_learning" name="pers_learning">
                                            <option value="">ไม่มีไม่ต้องเลือก...</option>
                                            <?php foreach ($learning as $key => $value) : ?>
                                            <option value="<?=$value->lear_id;?>"><?=$value->lear_namethai;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            กรุณาเลือกกลุ่มสาระการเรียนรู้
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php $degee = array('ชำนาญการ','ชำนาญการพิเศษ','เชี่ยวชาญ','เชี่ยวชาญพิเศษ'); ?>
                                        <label for="pers_academic" class="form-label">วิทยฐานะ</label>
                                        <select class="form-select" id="pers_academic" name="pers_academic">
                                            <option value="">ไม่มีไม่ต้องเลือก...</option>
                                            <?php foreach ($degee as $key => $value) : ?>
                                            <option value="<?=$value;?>"><?=$value;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid state.
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="pers_groupleade"
                                            class="form-label">หัวหน้าและรองหัวหน้ากลุ่มสาระ</label>
                                        <select class="form-select" id="pers_groupleade" name="pers_groupleade">
                                            <option value="">ไม่มีไม่ต้องเลือก...</option>
                                            <option value="หัวหน้ากลุ่มสาระ">หัวหน้ากลุ่มสาระ</option>
                                            <option value="รองหัวหน้ากลุ่มสาระ">รองหัวหน้ากลุ่มสาระ</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid state.
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <button class="w-100 btn btn-primary btn-lg" type="submit">บันทึก</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>








        </div>



        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->