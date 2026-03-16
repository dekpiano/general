<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">

   <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
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
                        <div class="d-flex gap-2">
                            <?php $checkRloes = explode(",",@$_SESSION['rloes']);?>
                            <?php if(!empty($_SESSION['username']) && (in_array("งานแจ้งซ่อม",$checkRloes) || in_array("งานอาคารสถานที่",$checkRloes))):?>
                            <button type="button" class="btn btn-warning shadow-sm fw-bold" id="ModalFormAdmin">
                                <i class="bx bx-wrench me-1"></i> สำหรับผู้ซ่อม
                            </button>
                            <button type="button" class="btn btn-outline-danger shadow-sm fw-bold" id="BtnCleanupImages">
                                <i class="bx bx-trash me-1"></i> ล้างไฟล์ขยะ
                            </button>
                            <?php endif; ?>
                            
                            <?php if($Order[0]->repair_caselist === 'งานอาคารสถานที่' && session()->get('id') == $Order[0]->repair_userID): ?>
                            <a href="<?=base_url('Repair/BuildingMemo?order=').$Order[0]->repair_order?>" 
                                class="btn btn-outline-warning shadow-sm fw-bold">
                                <i class="bx bx-file me-1"></i> บันทึกข้อความ
                            </a>
                            <?php endif; ?>

                            <a href="<?=base_url('Repair/PrintOrder/').$Order[0]->repair_order?>" target="_blank"
                                class="btn btn-primary shadow-sm fw-bold PrintOrder">
                                <i class="bx bx-printer me-1"></i> พิมพ์ใบแจ้งซ่อม
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <img src="<?=base_url('uploads/admin/Repair/User/').$Order[0]->repair_imguser?>" class="img-fluid rounded shadow-sm" style="max-height: 300px;" alt="ภาพประกอบการแจ้งซ่อม">
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
                        <img src="<?=base_url('uploads/admin/Repair/').$Order[0]->repair_imgwork?>" class="img-fluid rounded shadow-sm" style="max-height: 250px;" alt="ภาพการดำเนินงาน">
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
                                <label for="repair_imgwork" class="form-label">รูปภาพหลังซ่อมเสร็จ</label>
                                <input type="hidden" name="imgwork" id="imgwork" value="<?=$Order[0]->repair_imgwork;?>">
                                <input class="form-control" type="file" name="repair_imgwork" id="repair_imgwork">
                                <div class="mt-2 text-center p-2 border rounded bg-light">
                                    <img src="<?=base_url('uploads/admin/Repair/').$Order[0]->repair_imgwork?>" class="img-fluid rounded" id="preview_imgwork" style="max-height: 150px; display: <?=empty($Order[0]->repair_imgwork)?'none':'inline'?>;">
                                </div>
                                <script>
                                repair_imgwork.onchange = e => {
                                    const [file] = repair_imgwork.files;
                                    if (file) {
                                        preview_imgwork.src = URL.createObjectURL(file);
                                        preview_imgwork.style.display = "inline";
                                    }
                                };
                                </script>
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

<?= $this->endSection() ?>
