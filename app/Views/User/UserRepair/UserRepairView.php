<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4 row justify-content-between">
                <div class="col-md-6">
                    <span class="text-muted fw-light"><a href="<?=base_url('Repair')?>">งานแจ้งซ่อม</a> /</span>
                    <?=$title?>
                </div>
                <div class="col-md-6 mt-xs-3 text-md-end text-sm-center">
                    <?php $checkRloes = explode(",",@$_SESSION['rloes']);?>
                    <?php if(!empty($_SESSION['username']) && $_SESSION['username'] != '' && in_array("งานแจ้งซ่อม",$checkRloes) || in_array("งานอาคารสถานที่",$checkRloes)):?>
                    <button type="button" class="btn btn-secondary" id="ModalFormAdmin">สำหรับผู้ซ่อม</button>
                    <?php endif; ?>
                    <a href="<?=base_url('Repair/PrintOrder/').$Order[0]->repair_order?>" target="_blank"
                        class="btn btn-primary PrintOrder">พิมพ์ใบแจ้งซ่อม</a>
                </div>
            </h4>

            <div class="card">
                <div class="card-body">
                    <div class="bg-primary text-white p-2">
                        ข้อมูลการแจ้งปัญหา
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">หมายเลขใบแจ้งซ่อม</th>
                                <td id="show_repair_order"> <?=$Order[0]->repair_order?></td>
                            </tr>
                            <tr>
                                <th scope="col">รายการแจ้งซ่อม</th>
                                <td scope="col">
                                    <div>
                                        ประเภท : <span id="show_repair_caselist"><?=$Order[0]->repair_caselist?></span>
                                    </div>
                                    <div>
                                        สถานที่ : <span
                                            id="show_repair_location"><?=$Order[0]->repair_building.' ชั้น '.$Order[0]->repair_class.' ห้อง '.$Order[0]->repair_room?></span>
                                    </div>
                                    <div>
                                        <u> รายละเอียดเพิ่มเติม</u>
                                    </div>
                                    <div id="show_repair_detail"><?=$Order[0]->repair_detail?></div>
                                    <div id="show_repair_imguser">
                                        <?php  if(!empty($Order[0]->repair_imguser)) : ?>
                                        <img src="<?=base_url('uploads/admin/Repair/User/').$Order[0]->repair_imguser?>"
                                            class="img-fluid" alt="" srcset="">
                                            <?php else: ?>
                                                <?php echo "(ไม่ได้แนบภาพมาด้วย!)"; ?>
                                            <?php endif; ?>
                                            
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">วันที่แจ้งซ่อม</th>
                                <td scope="col">
                                    <span
                                        id="show_repair_datetime"><?=$Datethai->thai_date_and_time(strtotime($Order[0]->repair_datetime))?></span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">ผู้แจ้งซ่อม</th>
                                <td scope="col" id="show_repair_userID">
                                    <?=$Order[0]->pers_prefix.$Order[0]->pers_firstname.' '.$Order[0]->pers_lastname?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">ตำแหน่ง</th>
                                <td scope="col" id="show_repair_posi"><?=$Order[0]->posi_name?></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-white p-2 bg-success mt-5">
                        ข้อมูลการดำเนินการ
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="col">สถานะการดำเนินการ</th>
                                <td scope="col" id="show_repair_status"><?=$Order[0]->repair_status ?? 'รอดำเนินการ'?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">วันที่ดำเนินการ</th>
                                <td id="show_repair_datework">
                                    <?php 
                                    if($Order[0]->repair_datework == '0000-00-00 00:00:00' || $Order[0]->repair_datework == null){
                                        echo "รอดำเนินการ";
                                    }else{
                                        echo $Datethai->thai_date_and_time(strtotime($Order[0]->repair_datework));
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">ผู้ดำเนินการ</th>
                                <td scope="col" id="show_repair_Repairman"><?=$Order[1]->Repairman ?? 'รอดำเนินการ'?>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">สาเหตุ/วิธีแก้ไข</th>
                                <td scope="col" id="show_repair_cause"><?=$Order[0]->repair_cause ?? 'รอดำเนินการ'?>
                                </td>
                            </tr>

                            <tr>
                                <th scope="col">รูปภาพ</th>
                                <td scope="col" id="show_repair_imgwork">
                                    <?php
                                        if($Order[0]->repair_imgwork != "") :
                                    ?>
                                    <img src="<?=base_url('uploads/admin/Repair/').$Order[0]->repair_imgwork?>"
                                        class="img-fluid" alt="" srcset="">
                                    <?php else: ?>
                                    รอดำเนินการ
                                    <?php endif; ?>


                                </td>
                            </tr>
                            <tr>
                                <th scope="col">ลายมือชื่อผู้รับเรื่อง</th>
                                <td scope="col" id="show_repair_adminsignature">
                                    <?php
                                        if($Order[0]->repair_adminsignature != "") :
                                    ?>
                                    <img src="<?=$Order[0]->repair_adminsignature?>" class="img-fluid" alt="" srcset="">
                                    <?php else: ?>
                                    รอดำเนินการ
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
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
                                class="img-fluid" alt="" srcset="">
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
                            <button type="submit" id="BtnSave" class="btn btn-primary">บันทึกการซ่อม</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>