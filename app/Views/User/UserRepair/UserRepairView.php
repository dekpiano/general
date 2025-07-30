<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('Repair') ?>">งานแจ้งซ่อม</a>
                        </li>
                        <li class="breadcrumb-item active"><?=$title?></li>
                    </ol>
                </nav>
                <div>
                    <?php $checkRloes = explode(",",@$_SESSION['rloes']);?>
                    <?php if(!empty($_SESSION['username']) && $_SESSION['username'] != '' && in_array("งานแจ้งซ่อม",$checkRloes) || in_array("งานอาคารสถานที่",$checkRloes)):?>
                    <button type="button" class="btn btn-secondary btn-sm" id="ModalFormAdmin">สำหรับผู้ซ่อม</button>
                    <?php endif; ?>
                    <a href="<?=base_url('Repair/PrintOrder/').$Order[0]->repair_order?>" target="_blank"
                        class="btn btn-primary btn-sm PrintOrder">พิมพ์ใบแจ้งซ่อม</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7 mb-4">
                    <div class="card">
                        <h5 class="card-header">ข้อมูลการแจ้งปัญหา</h5>
                        <div class="card-body">
                            <dl class="row mb-4">
                                <dt class="col-sm-4 fw-medium">หมายเลขใบแจ้งซ่อม:</dt>
                                <dd class="col-sm-8" id="show_repair_order"><?=$Order[0]->repair_order?></dd>

                                <dt class="col-sm-4 fw-medium">วันที่แจ้งซ่อม:</dt>
                                <dd class="col-sm-8" id="show_repair_datetime"><?=$Datethai->thai_date_and_time(strtotime($Order[0]->repair_datetime))?></dd>

                                <dt class="col-sm-4 fw-medium">ผู้แจ้งซ่อม:</dt>
                                <dd class="col-sm-8" id="show_repair_userID"><?=$Order[0]->pers_prefix.$Order[0]->pers_firstname.' '.$Order[0]->pers_lastname?></dd>

                                <dt class="col-sm-4 fw-medium">ตำแหน่ง:</dt>
                                <dd class="col-sm-8" id="show_repair_posi"><?=$Order[0]->posi_name?></dd>

                                <dt class="col-sm-4 fw-medium">ประเภท:</dt>
                                <dd class="col-sm-8" id="show_repair_caselist"><?=$Order[0]->repair_caselist?></dd>

                                <dt class="col-sm-4 fw-medium">สถานที่:</dt>
                                <dd class="col-sm-8" id="show_repair_location"><?=$Order[0]->repair_building.' ชั้น '.$Order[0]->repair_class.' ห้อง '.$Order[0]->repair_room?></dd>
                            </dl>

                            <h6 class="mb-2">รายละเอียดเพิ่มเติม</h6>
                            <p id="show_repair_detail"><?=$Order[0]->repair_detail?></p>

                            <h6 class="mt-4 mb-2">ภาพประกอบ</h6>
                            <div id="show_repair_imguser">
                                <?php if(!empty($Order[0]->repair_imguser)) : ?>
                                <img src="<?=base_url('uploads/admin/Repair/User/').$Order[0]->repair_imguser?>" class="img-fluid rounded border" style="max-height: 400px;" alt="ภาพประกอบการแจ้งซ่อม">
                                <?php else: ?>
                                <p class="text-muted">(ไม่ได้แนบภาพมาด้วย)</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="card">
                        <h5 class="card-header">ข้อมูลการดำเนินการ</h5>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-5 fw-medium">สถานะ:</dt>
                                <dd class="col-sm-7" id="show_repair_status">
                                    <?php 
                                        $status = $Order[0]->repair_status ?? 'รอดำเนินการ';
                                        $badge_class = 'bg-label-secondary';
                                        if ($status == 'กำลังดำเนินการ') $badge_class = 'bg-label-info';
                                        if ($status == 'ดำเนินการเรียบร้อย') $badge_class = 'bg-label-success';
                                        if ($status == 'ยกเลิก') $badge_class = 'bg-label-danger';
                                    ?>
                                    <span class="badge <?=$badge_class?>"><?=$status?></span>
                                </dd>

                                <dt class="col-sm-5 fw-medium">วันที่ดำเนินการ:</dt>
                                <dd class="col-sm-7" id="show_repair_datework">
                                    <?php 
                                    if($Order[0]->repair_datework == '0000-00-00 00:00:00' || $Order[0]->repair_datework == null){
                                        echo "<span class='text-muted'>รอดำเนินการ</span>";
                                    }else{
                                        echo $Datethai->thai_date_and_time(strtotime($Order[0]->repair_datework));
                                    }
                                    ?>
                                </dd>

                                <dt class="col-sm-5 fw-medium">ผู้ดำเนินการ:</dt>
                                <dd class="col-sm-7" id="show_repair_Repairman"><?=$Order[1]->Repairman ?? "<span class='text-muted'>รอดำเนินการ</span>"?></dd>
                            </dl>

                            <h6 class="mt-4 mb-2">สาเหตุ/วิธีแก้ไข</h6>
                            <p id="show_repair_cause"><?=$Order[0]->repair_cause ?? "<span class='text-muted'>รอดำเนินการ</span>"?></p>

                            <h6 class="mt-4 mb-2">ภาพการดำเนินงาน</h6>
                            <div id="show_repair_imgwork">
                                <?php if(!empty($Order[0]->repair_imgwork)) : ?>
                                <img src="<?=base_url('uploads/admin/Repair/').$Order[0]->repair_imgwork?>" class="img-fluid rounded border" style="max-height: 300px;" alt="ภาพการดำเนินงาน">
                                <?php else: ?>
                                <p class="text-muted">รอดำเนินการ</p>
                                <?php endif; ?>
                            </div>

                            <h6 class="mt-4 mb-2">ลายมือชื่อผู้รับเรื่อง</h6>
                            <div id="show_repair_adminsignature">
                                <?php if(!empty($Order[0]->repair_adminsignature)) : ?>
                                <img src="<?=$Order[0]->repair_adminsignature?>" class="img-fluid rounded border bg-light" style="max-height: 150px;" alt="ลายมือชื่อ">
                                <?php else: ?>
                                <p class="text-muted">รอดำเนินการ</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
</div>

<!-- Modal -->
<div class="modal fade" id="ModalRepairSaveAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รายละเอียดดำเนินงานของช่างซ่อม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormSaveRepairAdmin">
                    <div class="mb-3 row">
                        <label for="repair_datework" class="col-sm-3 col-form-label">หมายเลขใบแจ้งซ่อม</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="repair_order"
                                name="repair_order" value="<?=$uri->getSegment(3)?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">สถานะการดำเนินการ</label>
                        <div class="col-sm-9">
                            <select class="form-select" name="repair_status" id="repair_status">
                                <option <?=$Order[0]->repair_status == "รอดำเนินการ"?"selected":""?>
                                    value="รอดำเนินการ">รอดำเนินการ</option>
                                <option <?=$Order[0]->repair_status == "กำลังดำเนินการ"?"selected":""?>
                                    value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                                <option <?=$Order[0]->repair_status == "ดำเนินการเรียบร้อย"?"selected":""?>
                                    value="ดำเนินการเรียบร้อย">ดำเนินการเรียบร้อย</option>
                                <option <?=$Order[0]->repair_status == "ยกเลิก"?"selected":""?> value="ยกเลิก">ยกเลิก
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="repair_datework" class="col-sm-3 col-form-label">วันที่ดำเนินการ</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="" name=""
                                value="<?php echo $Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')));?>">
                            <input type="hidden" readonly class="form-control-plaintext" id="repair_datework"
                                name="repair_datework" value="<?php echo date('Y-m-d H:i:s');?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">ผู้ดำเนินการ</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail"
                                value="<?php echo @$_SESSION['username'];?>">
                            <input type="hidden" readonly class="form-control-plaintext" id="repair_Repairman"
                                name="repair_Repairman" value="<?php echo @$_SESSION['id'];?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="repair_cause" class="col-sm-3 col-form-label">สาเหตุ/วิธีแก้ไข</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="repair_cause" id="repair_cause"
                                rows="3"><?=$Order[0]->repair_cause;?></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="repair_imgwork" class="col-sm-3 col-form-label">ไฟล์ภาพ</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="imgwork" id="imgwork" value="<?=$Order[0]->repair_imgwork;?>">
                            <input class="form-control" type="file" name="repair_imgwork" id="repair_imgwork">
                            <img src="<?=base_url('uploads/admin/Repair/').$Order[0]->repair_imgwork?>"
                                class="img-fluid" id="preview_imgwork" alt="" srcset="">

                            <script>
                            repair_imgwork.onchange = e => {
                                const [file] = repair_imgwork.files;
                                if (file) {
                                    preview_imgwork.src = URL.createObjectURL(file);
                                    preview_imgwork.style.display = "block";
                                }
                            };
                            </script>
                        </div>



                    </div>
                    <div class="mb-3 row">
                        <style>
                        canvas {
                            border: 2px solid #000;
                            width: 100%;
                            max-width: 500px;
                            /* ป้องกันการขยายเกิน */
                            height: 200px;
                            background-color: #fff;
                        }
                        </style>
                        <label for="inputPassword" class="col-sm-3 col-form-label">ลายมือชื่อผู้รับเรื่อง</label>
                        <div class="col-sm-9">
                            <canvas id="signature-pad" width=350 height=200></canvas>
                            <a href="#" class="btn btn-warning" id="clear">ล้างลายเซ็น</a>
                        </div>

                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <button type="submit" id="BtnSave" class="btn btn-primary">
                                <span id="btnSaveText">บันทึกการซ่อม</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2"
                                    style="display:none;" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>