<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบแจ้งซ่อม</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/user-repair.css') ?>">
</head>
<body class="print-page">
    <div class="print-container" style="margin-top: 20px;">
        <div class="print-header" >
                        <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" alt="Logo" style="width: 70px; height: auto; margin: 15px;">
            <div class="print-header-text">
                <h1>ระบบแจ้งซ่อมออนไลน์</h1>
                <p>โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
            </div>
        </div>

        <h2 class="print-document-title">ใบแจ้งซ่อม</h2>

        <div class="print-section-title">ข้อมูลการแจ้งซ่อม</div>
        <table class="print-content-table">
            <tbody>
                <tr>
                    <th>เลขที่ใบแจ้งซ่อม</th>
                    <td><?=$RepairUser[0]->repair_order?></td>
                </tr>
                <tr>
                    <th>วันที่แจ้งซ่อม</th>
                    <td><?=$Datethai->thai_date_and_time(strtotime($RepairUser[0]->repair_datetime))?></td>
                </tr>
                <tr>
                    <th>ผู้แจ้งซ่อม</th>
                    <td><?=$RepairUser[0]->pers_prefix.$RepairUser[0]->pers_firstname.' '.$RepairUser[0]->pers_lastname?></td>
                </tr>
                <tr>
                    <th>รายการแจ้งซ่อม</th>
                    <td><?=$RepairUser[0]->repair_caselist?></td>
                </tr>
                <tr>
                    <th>รายละเอียดปัญหาและสถานที่</th>
                    <td>
                        <?=$RepairUser[0]->repair_detail?> <br>
                        <b>สถานที่:</b> <?=$RepairUser[0]->repair_building?> ชั้น <?=$RepairUser[0]->repair_class?> ห้อง <?=$RepairUser[0]->repair_room?>
                    </td>
                </tr>
                <tr>
                    <th>ภาพประกอบ</th>
                    <td>
                        <?php if(!empty($RepairUser[0]->repair_imguser)) : ?>
                        <img src="<?=base_url('uploads/admin/Repair/User/').$RepairUser[0]->repair_imguser?>" style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                        <?php else: ?>
                        (ไม่ได้แนบภาพ)
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="print-section-title">ข้อมูลการดำเนินการ</div>
        <table class="print-content-table">
            <tbody>
                <tr>
                    <th>สถานะ</th>
                    <td><?=$RepairUser[0]->repair_status ?? 'รอดำเนินการ'?></td>
                </tr>
                <tr>
                    <th>ผู้รับซ่อม</th>
                    <td>
                        <?php 
                            if(!isset($Repairman[0]->pers_prefix)) {
                                echo 'รอดำเนินการ';
                            } else {
                                echo @$Repairman[0]->pers_prefix.@$Repairman[0]->pers_firstname.' '.@$Repairman[0]->pers_lastname;
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>วันที่ดำเนินการ</th>
                    <td>
                        <?php 
                            if($RepairUser[0]->repair_datework == '0000-00-00 00:00:00' || $RepairUser[0]->repair_datework == null){
                                echo 'รอดำเนินการ';
                            } else {
                                echo $Datethai->thai_date_and_time(strtotime($RepairUser[0]->repair_datework));
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>สาเหตุ/วิธีแก้ไข</th>
                    <td><?=$RepairUser[0]->repair_cause ?? 'รอดำเนินการ'?></td>
                </tr>
            </tbody>
        </table>

        <table class="print-signature-section">
            <tr>
                <td class="print-signature-box">
                    <?php if($RepairUser[0]->repair_usersignature) : ?>
                    <img src="<?=$RepairUser[0]->repair_usersignature?>" alt="ลายเซ็นผู้แจ้งซ่อม" style="max-width: 200px; max-height: 100px;">
                    <?php endif; ?>
                    <div class="print-signature-line"></div>
                    <p>(<?=$RepairUser[0]->pers_prefix.$RepairUser[0]->pers_firstname.' '.$RepairUser[0]->pers_lastname?>)</p>
                    <p><strong>ผู้แจ้งซ่อม</strong></p>
                    <p>วันที่: <?=$Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datetime))?></p>
                </td>
                <td class="print-signature-box">
                    <?php if($RepairUser[0]->repair_adminsignature) : ?>
                    <img src="<?=$RepairUser[0]->repair_adminsignature;?>" alt="ลายเซ็นผู้รับซ่อม">
                    <?php endif; ?>
                    <div class="print-signature-line"></div>
                    <p>(<?=@$Repairman[0]->pers_prefix.@$Repairman[0]->pers_firstname.' '.@$Repairman[0]->pers_lastname ?? '...........................................'?>)</p>
                    <p><strong>ผู้รับซ่อม</strong></p>
                    <p>วันที่: <?php if($RepairUser[0]->repair_datework != '0000-00-00 00:00:00' && $RepairUser[0]->repair_datework != null) echo $Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datework)); else echo '...........................................'; ?></p>
                </td>
            </tr>
        </table>

        <div class="print-footer">
            <p>เอกสารนี้จัดทำโดยระบบแจ้งซ่อมออนไลน์ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</p>
        </div>

    </div>
</body>
</html>