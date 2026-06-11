<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<?php 
    // ประกาศตัวแปรสิทธิ์การใช้งานไว้ด้านบนสุดเพื่อให้เรียกใช้ได้ทั้งหน้า
    $checkRloes = explode(",",@$_SESSION['rloes']);
    $isAdmin = (!empty($_SESSION['username']) && (in_array("งานแจ้งซ่อม",$checkRloes) || in_array("งานอาคารสถานที่",$checkRloes)));
?>

<style>
/* Star Rating CSS - Mobile Friendly */
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 15px; /* เพิ่มระยะห่างให้กดง่ายขึ้นบนมือถือ */
}
.star-rating input {
    display: none;
}
.star-rating label {
    font-size: 2.5rem; /* ขยายขนาดดาวให้ใหญ่ขึ้นสำหรับนิ้วสัมผัส */
    color: #e9ecef;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    padding: 5px; /* เพิ่มพื้นที่กด */
}
.star-rating label:active {
    transform: scale(1.2); /* มี Feedback เมื่อกด */
}
.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input:checked ~ label {
    color: #ffc107;
}
.star-rating label:hover:before,
.star-rating label:hover ~ label:before,
.star-rating input:checked ~ label:before {
    content: "\ea83";
    font-family: 'boxicons';
}
.star-display {
    color: #ffc107;
    letter-spacing: 2px;
}

/* ปรับปรุง Modal สำหรับมือถือ */
@media (max-width: 576px) {
    .star-rating label {
        font-size: 2.2rem;
        gap: 10px;
    }
    .modal-body {
        padding: 1.5rem 1rem !important;
    }
    #FormEvaluation label.fw-bold {
        font-size: 0.9rem;
    }
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">

   <!-- Header -->
    <div class="row mb-4">
        <div class="col-12 <?php if($isAdmin){echo "col-md-8";}?> ">
            <div class="card bg-label-primary border-0 text-white overflow-hidden wave-bg">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-0 text-primary"><i class="bx bx-file me-2"></i>รายละเอียดการแจ้งซ่อม</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-style1 mb-0 mt-2">
                                    <li class="breadcrumb-item">
                                        <a href="<?=base_url('Repair')?>" class="text-primary">งานแจ้งซ่อม</a>
                                    </li>
                                    <li class="breadcrumb-item active text-muted"><?=$Order[0]->repair_order?></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex gap-2 align-items-center">
                            <?php if($Order[0]->repair_caselist === 'งานอาคารสถานที่' && session()->get('id') == $Order[0]->repair_userID): ?>
                            <a href="<?=base_url('Repair/BuildingMemo?order=').$Order[0]->repair_order?>"
                                class="btn btn-outline-warning shadow-sm fw-bold btn-sm">
                                <i class="bx bx-file me-1"></i> บันทึกข้อความ
                            </a>
                            <?php endif; ?>

                            <a href="<?=base_url('Repair/PrintOrder/').$Order[0]->repair_order?>" target="_blank"
                                class="btn btn-primary shadow-sm fw-bold PrintOrder btn-sm">
                                <i class="bx bx-printer me-1"></i> พิมพ์
                            </a>

                            <?php if(!$isAdmin): ?>
                            <button type="button" class="btn btn-dark shadow-sm fw-bold btn-sm" id="BtnStaffLogin">
                                <i class="bx bx-shield-quarter me-1"></i> เจ้าหน้าที่รับงาน
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

    <!-- Admin Control Panel (Horizontal Bar) -->
    <?php if($isAdmin): ?>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm bg-label-warning overflow-hidden">
                <div class="card-body py-2 px-3">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center text-warning">
                            <i class="bx bx-shield-quarter fs-4 me-2"></i>
                            <span class="fw-bold">แผงควบคุมเจ้าหน้าที่:</span>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-warning btn-sm fw-bold px-3" id="ModalFormAdmin">
                                <i class="bx bx-wrench me-1"></i> รับงาน/บันทึกการซ่อม
                            </button>

                            <?php if(!empty($MemoData)): ?>
                            <a href="<?=base_url('Repair/BuildingMemo/Print?order=').$Order[0]->repair_order?>" 
                                target="_blank" class="btn btn-outline-primary btn-sm fw-bold px-3">
                                <i class="bx bx-file me-1"></i> ดูบันทึกข้อความ (ผู้แจ้ง)
                            </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="BtnCleanupImages">
                                <i class="bx bx-trash me-1"></i> ล้างรูปขยะ
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="BtnMigrateImages">
                                <i class="bx bx-move me-1"></i> จัดระเบียบไฟล์
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <?php endif; ?>

    </div>

    <div class="row">
        <!-- Left: Repair Info -->
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="card-title text-primary mb-0"><i class="bx bx-info-circle me-2"></i>ข้อมูลการแจ้งปัญหา</h5>
                </div>
                <div class="card-body pt-4">
                     <div class="bg-label-secondary rounded p-3 mb-4">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <small class="text-muted d-block uppercase">หมายเลขใบแจ้งซ่อม</small>
                                <span class="fw-bold text-dark fs-5" id="show_repair_order"><?=$Order[0]->repair_order?></span>
                            </div>
                             <div class="col-sm-6">
                                <small class="text-muted d-block uppercase">วันที่แจ้ง</small>
                                <span class="fw-bold text-dark" id="show_repair_datetime"><?=$Datethai->thai_date_and_time(strtotime($Order[0]->repair_datetime))?></span>
                            </div>
                        </div>
                    </div>

                    <dl class="row mb-4">
                        <dt class="col-sm-4 fw-medium text-muted">ผู้แจ้งซ่อม:</dt>
                        <dd class="col-sm-8" id="show_repair_userID"><?=$Order[0]->pers_prefix.$Order[0]->pers_firstname.' '.$Order[0]->pers_lastname?></dd>

                        <dt class="col-sm-4 fw-medium text-muted">ตำแหน่ง:</dt>
                        <dd class="col-sm-8" id="show_repair_posi"><?=$Order[0]->posi_name?></dd>

                        <dt class="col-sm-4 fw-medium text-muted">สถานที่:</dt>
                        <dd class="col-sm-8" id="show_repair_location"><?=$Order[0]->repair_building.' ชั้น '.$Order[0]->repair_class.' ห้อง '.$Order[0]->repair_room?></dd>
                        
                        <dt class="col-sm-4 fw-medium text-muted">ประเภท:</dt>
                        <dd class="col-sm-8"><span class="badge bg-label-info"><?=$Order[0]->repair_caselist?></span></dd>
                    </dl>

                    <h6 class="mb-2 fw-bold text-dark"><i class="bx bx-detail me-2"></i>รายละเอียดเพิ่มเติม</h6>
                    <div class="p-3 bg-light rounded mb-4">
                        <p class="mb-0" id="show_repair_detail"><?=$Order[0]->repair_detail?></p>
                    </div>

                    <h6 class="mb-2 fw-bold text-dark"><i class="bx bx-image me-2"></i>ภาพประกอบ</h6>
                    <div id="show_repair_imguser" class="text-center p-3 border border-dashed rounded">
                        <?php if(!empty($Order[0]->repair_imguser)) : ?>
                            <div class="row g-2 justify-content-center">
                            <?php 
                                $imgs = explode(',', $Order[0]->repair_imguser);
                                foreach($imgs as $img) : 
                                    if(empty($img)) continue;
                            ?>
                                <div class="col-12 mb-3">
                                    <img src="<?=base_url('uploads/user/Repair/').$img?>" class="img-fluid rounded shadow-sm border" style="width: 100%;" alt="ภาพประกอบการแจ้งซ่อม">
                                </div>
                            <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                        <div class="text-muted my-3"><i class="bx bx-image-alt fs-1"></i><br>ไม่ได้แนบภาพมาด้วย</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Operation Info -->
        <div class="col-lg-5 mb-4">
            
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="card-title text-primary mb-0"><i class="bx bx-cog me-2"></i>ข้อมูลการดำเนินการ</h5>
                </div>
                <div class="card-body pt-4">
                     <div class="mb-4 text-center">
                        <small class="text-muted d-block mb-1">สถานะปัจจุบัน</small>
                         <?php 
                            $status = $Order[0]->repair_status ?? 'รอดำเนินการ';
                            $badge_class = 'bg-label-secondary';
                            $icon_class = 'bx-time';
                            if ($status == 'กำลังดำเนินการ') { $badge_class = 'bg-label-info'; $icon_class = 'bx-loader-circle bx-spin'; }
                            if ($status == 'ดำเนินการเรียบร้อย') { $badge_class = 'bg-label-success'; $icon_class = 'bx-check-circle'; }
                            if ($status == 'ยกเลิก') { $badge_class = 'bg-label-danger'; $icon_class = 'bx-x-circle'; }
                        ?>
                        <span class="badge <?=$badge_class?> fs-4 py-2 px-4 rounded-pill">
                            <i class="bx <?=$icon_class?> me-2"></i><?=$status?>
                        </span>
                    </div>

                    <!-- Evaluation Section -->
                    <div class="mt-4">
                        <?php 
                            $isOwner = (session()->get('id') == $Order[0]->repair_userID);
                            
                            // แสดงปุ่มถ้า (สถานะเรียบร้อย) AND (เป็นเจ้าของ OR เป็น Admin)
                            if(trim($status) == 'ดำเนินการเรียบร้อย' && ($isOwner || $isAdmin)): 
                        ?>
                            <?php if(empty($Evaluation)): ?>
                                <div class="alert alert-primary d-flex align-items-center border-0 shadow-sm" role="alert">
                                    <i class="bx bx-star fs-3 me-3"></i>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">ประเมินความพึงพอใจ</div>
                                        <div class="small">งานซ่อมเสร็จสิ้นแล้ว รบกวนคุณสละเวลาสักครู่เพื่อประเมินการทำงานครับ</div>
                                    </div>
                                    <button class="btn btn-primary btn-sm ms-2" id="BtnOpenEvaluation">ประเมิน</button>
                                </div>
                            <?php else: ?>
                                <div class="card bg-label-success border-0 shadow-none mb-0">
                                    <div class="card-body p-3">
                                        <div class="fw-bold mb-2 text-success"><i class="bx bxs-check-shield me-1"></i> ประเมินแล้ว</div>
                                        <div class="row g-2 small text-dark">
                                            <div class="col-6">ความรวดเร็ว:</div>
                                            <div class="col-6 star-display">
                                                <?= str_repeat('<i class="bx bxs-star"></i>', $Evaluation->eval_score_speed) ?>
                                            </div>
                                            <div class="col-6">คุณภาพ:</div>
                                            <div class="col-6 star-display">
                                                <?= str_repeat('<i class="bx bxs-star"></i>', $Evaluation->eval_score_quality) ?>
                                            </div>
                                            <div class="col-6">การบริการ:</div>
                                            <div class="col-6 star-display">
                                                <?= str_repeat('<i class="bx bxs-star"></i>', $Evaluation->eval_score_service) ?>
                                            </div>
                                        </div>
                                        <?php if(!empty($Evaluation->eval_comment)): ?>
                                            <div class="mt-2 p-2 bg-white rounded-3 small border border-success border-opacity-25">
                                                <strong>ความเห็น:</strong> <?= $Evaluation->eval_comment ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <ul class="list-unstyled">
                         <li class="d-flex mb-3">
                            <i class="bx bx-calendar me-3 text-primary fs-4"></i>
                            <div>
                                <small class="text-muted">วันที่ดำเนินการ</small>
                                <div class="fw-medium">
                                    <?php 
                                    if($Order[0]->repair_datework == '0000-00-00 00:00:00' || $Order[0]->repair_datework == null){
                                        echo "<span class='text-muted'>-</span>";
                                    }else{
                                        echo $Datethai->thai_date_and_time(strtotime($Order[0]->repair_datework));
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-3">
                             <i class="bx bx-user-voice me-3 text-primary fs-4"></i>
                            <div>
                                <small class="text-muted">ผู้ดำเนินการ</small>
                                <div class="fw-medium" id="show_repair_Repairman"><?=$Order[1]->Repairman ?? "<span class='text-muted'>-</span>"?></div>
                            </div>
                        </li>
                    </ul>
                    
                    <hr class="my-4">

                    <h6 class="mb-2 fw-bold text-dark">สาเหตุ/วิธีแก้ไข</h6>
                    <div class="p-3 bg-light rounded mb-4">
                        <p class="mb-0" id="show_repair_cause"><?=$Order[0]->repair_cause ?? "<span class='text-muted'>-</span>"?></p>
                    </div>

                    <h6 class="mb-2 fw-bold text-dark">ภาพการดำเนินงาน</h6>
                    <div id="show_repair_imgwork" class="text-center p-3 border border-dashed rounded mb-4">
                        <?php if(!empty($Order[0]->repair_imgwork)) : ?>
                            <div class="row g-2 justify-content-center">
                            <?php 
                                $imgs_work = explode(',', $Order[0]->repair_imgwork);
                                foreach($imgs_work as $img_w) : 
                                    if(empty($img_w)) continue;
                            ?>
                                <div class="col-12 mb-3">
                                    <img src="<?=base_url('uploads/admin/Repair/').$img_w?>" class="img-fluid rounded shadow-sm border" style="width: 100%;" alt="ภาพการดำเนินงาน">
                                </div>
                            <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                         <div class="text-muted my-3"><i class="bx bx-image-alt fs-1"></i><br>ไม่มีรูปภาพ</div>
                        <?php endif; ?>
                    </div>

                    <h6 class="mb-2 fw-bold text-dark text-center">ช่างผู้ดำเนินการ / ผู้รับเรื่อง</h6>
                    <div id="show_repair_adminsignature" class="text-center">
                        <?php if(!empty($Order[0]->repair_adminsignature)) : ?>
                        <div class="mb-2">
                            <img src="<?=$Order[0]->repair_adminsignature?>" class="img-fluid rounded bg-light border p-1" style="max-height: 100px;" alt="ลายมือชื่อ">
                        </div>
                        <div class="fw-bold text-dark">
                            ( <?=$Order[1]->Repairman ?? '..................................................'?> )
                        </div>
                        <?php else: ?>
                        <span class="text-muted">- ยังไม่มีการลงเครื่องหมายรับเรื่อง -</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Staff Login Modal -->
<div class="modal fade" id="ModalStaffLogin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white"><i class="bx bx-shield-quarter me-2"></i>เข้าสู่ระบบเจ้าหน้าที่</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-label-dark mb-3" style="width:64px;height:64px;">
                        <i class="bx bx-user-check fs-2 text-dark"></i>
                    </div>
                    <p class="text-muted mb-0 small">กรุณากรอกข้อมูลเพื่อเข้าสู่ระบบสำหรับเจ้าหน้าที่รับงาน</p>
                </div>
                <form id="FormStaffLogin">
                    <input type="hidden" name="repair_order" value="<?=$Order[0]->repair_order?>">
                    <div class="mb-3">
                        <label for="staff_username" class="form-label fw-bold">ชื่อผู้ใช้</label>
                        <div class="input-group">
                            <span class="input-group-text bg-label-dark border-end-0"><i class="bx bx-user"></i></span>
                            <input type="text" class="form-control border-start-0" id="staff_username" name="username" placeholder="กรอกชื่อผู้ใช้" required autocomplete="username">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="staff_password" class="form-label fw-bold">รหัสผ่าน</label>
                        <div class="input-group">
                            <span class="input-group-text bg-label-dark border-end-0"><i class="bx bx-lock-alt"></i></span>
                            <input type="password" class="form-control border-start-0 border-end-0" id="staff_password" name="password" placeholder="กรอกรหัสผ่าน" required autocomplete="current-password">
                            <button class="btn btn-outline-secondary border-start-0" type="button" id="toggleStaffPassword"><i class="bx bx-show"></i></button>
                        </div>
                    </div>
                    <div id="staffLoginError" class="alert alert-danger py-2 px-3 mb-3" style="display:none;">
                        <i class="bx bx-error-circle me-1"></i> <span id="staffLoginErrorMsg"></span>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-2 fw-bold" id="BtnStaffLoginSubmit">
                        <span id="staffLoginBtnText"><i class="bx bx-log-in me-1"></i> เข้าสู่ระบบ</span>
                        <span id="staffLoginSpinner" class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Admin Modal -->
<div class="modal fade" id="ModalRepairSaveAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-3 border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="bx bx-wrench me-2"></i>บันทึกการซ่อม (สำหรับเจ้าหน้าที่)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
                <form id="FormSaveRepairAdmin">
                    <div class="card shadow-sm border-0 mb-3">
                         <div class="card-body">
                             <div class="row g-3">
                                 <div class="col-md-6">
                                     <label class="form-label">สถานะการดำเนินการ</label>
                                     <select class="form-select" name="repair_status" id="repair_status">
                                        <option <?=$Order[0]->repair_status == "รอดำเนินการ"?"selected":""?> value="รอดำเนินการ">รอดำเนินการ</option>
                                        <option <?=$Order[0]->repair_status == "กำลังดำเนินการ"?"selected":""?> value="กำลังดำเนินการ">กำลังดำเนินการ</option>
                                        <option <?=$Order[0]->repair_status == "ดำเนินการเรียบร้อย"?"selected":""?> value="ดำเนินการเรียบร้อย">ดำเนินการเรียบร้อย</option>
                                        <option <?=$Order[0]->repair_status == "ยกเลิก"?"selected":""?> value="ยกเลิก">ยกเลิก</option>
                                    </select>
                                 </div>
                                 <div class="col-md-6">
                                     <label class="form-label">หมายเลขใบแจ้งซ่อม</label>
                                     <input type="text" readonly class="form-control-plaintext fw-bold" name="repair_order" value="<?=$uri->getSegment(3)?>">
                                 </div>
                                 <div class="col-md-6">
                                    <label class="form-label">ผู้ดำเนินการ</label>
                                    <input type="text" readonly class="form-control-plaintext" value="<?php echo @$_SESSION['username'];?>">
                                    <input type="hidden" name="repair_Repairman" value="<?php echo @$_SESSION['id'];?>">
                                 </div>
                                 <div class="col-md-6">
                                     <label class="form-label">วันที่ดำเนินการ</label>
                                     <input type="text" readonly class="form-control-plaintext" value="<?php echo $Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')));?>">
                                     <input type="hidden" name="repair_datework" value="<?php echo date('Y-m-d H:i:s');?>">
                                 </div>
                             </div>
                         </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white pb-0">
                            <h6 class="card-title text-primary py-2 mb-0">รายละเอียดการซ่อม</h6>
                        </div>
                        <div class="card-body pt-3">
                             <div class="mb-3">
                                <label for="repair_cause" class="form-label">สาเหตุ / วิธีแก้ไข</label>
                                <textarea class="form-control" name="repair_cause" id="repair_cause" rows="3"><?=$Order[0]->repair_cause;?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">รูปภาพหลังซ่อมเสร็จ (สูงสุด 3 รูป)</label>
                                <div class="row g-2 mb-2">
                                    <?php for($j=0; $j<3; $j++): ?>
                                    <div class="col-4">
                                        <div class="upload-zone p-2 d-flex flex-column align-items-center justify-content-center" onclick="triggerAdminFileInput(<?=$j?>)" style="border: 1px dashed #dee2e6; cursor: pointer;">
                                            <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2216%22%20height%3D%229%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f8f9fa%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22sans-serif%22%20font-size%3D%221%22%20fill%3D%22%23dee2e6%22%20text-anchor%3D%22middle%22%20dy%3D%22.3em%22%3E16:9%3C/text%3E%3C/svg%3E" id="adminImageResult<?=$j?>" class="img-fluid rounded mb-1" style="width: 100%; aspect-ratio: 16/9; object-fit: cover;">
                                            <span class="x-small text-muted" style="font-size: 0.6rem;">รูปที่ <?=$j+1?></span>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                                <input type="file" id="repair_imgwork_input" class="d-none" accept="image/*">
                                <input type="hidden" name="imgwork" id="imgwork" value="<?=$Order[0]->repair_imgwork;?>">
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                         <div class="card-header bg-white pb-0">
                            <h6 class="card-title text-primary py-2 mb-0">ลายเซ็นช่างซ่อม/ผู้รับเรื่อง</h6>
                        </div>
                         <div class="card-body pt-3">
                            <div class="border rounded p-0 text-center bg-white mb-2 overflow-hidden">
                                <canvas id="signature-pad" class="w-100" style="touch-action: none;"></canvas>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger w-100 mb-3" id="clear">
                                <i class="bx bx-refresh me-1"></i> ล้างลายเซ็น
                            </button>
                            
                            <button type="submit" id="BtnSave" class="btn btn-primary w-100 py-2 fw-bold">
                                <span id="btnSaveText"><i class="bx bx-save me-1"></i> บันทึกการซ่อม</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Modal for Cropping Image -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="cropModalLabel"><i class="bx bx-crop me-2"></i> ครอบตัดรูปภาพ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="croppie-container" style="height: 450px;"></div>
                </div>
                <div class="modal-footer bg-light d-flex justify-content-between">
                    <div class="rotation-controls">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-rotate-left">
                            <i class="bx bx-rotate-left"></i> หมุนซ้าย
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-rotate-right">
                            <i class="bx bx-rotate-right"></i> หมุนขวา
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" id="btn-crop">
                            <i class="bx bx-check me-1"></i> ตกลง และใช้รูปนี้
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluation Modal -->
    <div class="modal fade" id="ModalEvaluation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white"><i class="bx bx-star me-2"></i>ประเมินความพึงพอใจ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormEvaluation">
                    <div class="modal-body p-4">
                        <input type="hidden" name="repair_order" value="<?=$Order[0]->repair_order?>">
                        
                        <div class="text-center mb-4">
                            <p class="text-muted">ความพึงพอใจของคุณช่วยให้เราพัฒนาการบริการให้ดียิ่งขึ้น</p>
                        </div>

                        <!-- Speed Score -->
                        <div class="mb-4">
                            <label class="d-block text-center fw-bold mb-2">1. ความรวดเร็วในการให้บริการ</label>
                            <div class="star-rating">
                                <input type="radio" id="speed-5" name="score_speed" value="5" required /><label for="speed-5"><i class="bx bx-star"></i></label>
                                <input type="radio" id="speed-4" name="score_speed" value="4" /><label for="speed-4"><i class="bx bx-star"></i></label>
                                <input type="radio" id="speed-3" name="score_speed" value="3" /><label for="speed-3"><i class="bx bx-star"></i></label>
                                <input type="radio" id="speed-2" name="score_speed" value="2" /><label for="speed-2"><i class="bx bx-star"></i></label>
                                <input type="radio" id="speed-1" name="score_speed" value="1" /><label for="speed-1"><i class="bx bx-star"></i></label>
                            </div>
                        </div>

                        <!-- Quality Score -->
                        <div class="mb-4">
                            <label class="d-block text-center fw-bold mb-2">2. คุณภาพการซ่อมแซม</label>
                            <div class="star-rating">
                                <input type="radio" id="quality-5" name="score_quality" value="5" required /><label for="quality-5"><i class="bx bx-star"></i></label>
                                <input type="radio" id="quality-4" name="score_quality" value="4" /><label for="quality-4"><i class="bx bx-star"></i></label>
                                <input type="radio" id="quality-3" name="score_quality" value="3" /><label for="quality-3"><i class="bx bx-star"></i></label>
                                <input type="radio" id="quality-2" name="score_quality" value="2" /><label for="quality-2"><i class="bx bx-star"></i></label>
                                <input type="radio" id="quality-1" name="score_quality" value="1" /><label for="quality-1"><i class="bx bx-star"></i></label>
                            </div>
                        </div>

                        <!-- Service Score -->
                        <div class="mb-4">
                            <label class="d-block text-center fw-bold mb-2">3. มารยาทและการให้บริการของเจ้าหน้าที่</label>
                            <div class="star-rating">
                                <input type="radio" id="service-5" name="score_service" value="5" required /><label for="service-5"><i class="bx bx-star"></i></label>
                                <input type="radio" id="service-4" name="score_service" value="4" /><label for="service-4"><i class="bx bx-star"></i></label>
                                <input type="radio" id="service-3" name="score_service" value="3" /><label for="service-3"><i class="bx bx-star"></i></label>
                                <input type="radio" id="service-2" name="score_service" value="2" /><label for="service-2"><i class="bx bx-star"></i></label>
                                <input type="radio" id="service-1" name="score_service" value="1" /><label for="service-1"><i class="bx bx-star"></i></label>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="comment" class="form-label fw-bold">ข้อเสนอแนะเพิ่มเติม (ถ้ามี)</label>
                            <textarea class="form-control bg-light border-0" id="comment" name="comment" rows="3" placeholder="เขียนความเห็นของคุณที่นี่..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm" id="BtnSaveEvaluation">
                            <i class="bx bx-check-circle me-1"></i> ส่งผลการประเมิน
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).on('click', '#BtnStaffLogin', function() {
    $('#ModalStaffLogin').modal('show');
});

// Toggle password visibility
$(document).on('click', '#toggleStaffPassword', function() {
    const $input = $('#staff_password');
    const $icon = $(this).find('i');
    if ($input.attr('type') === 'password') {
        $input.attr('type', 'text');
        $icon.removeClass('bx-show').addClass('bx-hide');
    } else {
        $input.attr('type', 'password');
        $icon.removeClass('bx-hide').addClass('bx-show');
    }
});

// Staff Login Form Submit
$(document).on('submit', '#FormStaffLogin', function(e) {
    e.preventDefault();
    const $btn = $('#BtnStaffLoginSubmit');
    const $btnText = $('#staffLoginBtnText');
    const $spinner = $('#staffLoginSpinner');
    const $error = $('#staffLoginError');

    $error.hide();
    $btn.prop('disabled', true);
    $btnText.text('กำลังเข้าสู่ระบบ...');
    $spinner.show();

    $.ajax({
        url: '<?= base_url("Repair/DB/StaffLogin") ?>',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'เข้าสู่ระบบสำเร็จ!',
                    text: 'กำลังเปลี่ยนหน้า...',
                    timer: 1200,
                    showConfirmButton: false,
                    allowOutsideClick: false
                }).then(function() {
                    window.location.href = res.redirect;
                });
            } else {
                $('#staffLoginErrorMsg').text(res.message);
                $error.show();
                $btn.prop('disabled', false);
                $btnText.html('<i class="bx bx-log-in me-1"></i> เข้าสู่ระบบ');
                $spinner.hide();
            }
        },
        error: function() {
            $('#staffLoginErrorMsg').text('เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์');
            $error.show();
            $btn.prop('disabled', false);
            $btnText.html('<i class="bx bx-log-in me-1"></i> เข้าสู่ระบบ');
            $spinner.hide();
        }
    });
});
</script>
<?= $this->endSection() ?>
