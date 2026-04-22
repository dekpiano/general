<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบแจ้งซ่อม</title>
    <style>
        body {
            font-family: 'thsarabun', sans-serif;
            font-size: 16px;
            line-height: 1.4;
            color: #000;
        }
        .document-container {
            width: 100%;
            margin: 0 auto;
            padding-top: 0;
        }
        /* Header Section */
        .document-header {
            text-align: center;
            margin-bottom: 8px;
            margin-top: 0;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            padding-top: 0;
        }
        .document-header img {
            width: 8mm;
            height: auto;
        }
        .document-header h1 {
            font-size: 22px;
            margin: 5px 0 0 0;
            font-weight: bold;
        }
        .document-header h2 {
            font-size: 18px;
            margin: 3px 0;
            font-weight: normal;
        }
        .document-header p {
            font-size: 14px;
            margin: 2px 0;
            color: #333;
        }
        /* Document Info */
        .document-info {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .document-info-left, .document-info-right {
            display: table-cell;
            width: 50%;
        }
        .document-info-right {
            text-align: right;
        }
        .document-number {
            font-size: 18px;
            font-weight: bold;
        }
        /* Main Title */
        .document-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
            text-decoration: underline;
        }
        /* Content Table */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .content-table th, .content-table td {
            border: 1px solid #000;
            padding: 6px 10px;
            vertical-align: top;
            font-size: 16px;
        }
        .content-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
            width: 25%;
        }
        .section-header {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: center;
            font-size: 16px;
            padding: 8px;
        }
        /* Status Badge */
        .status-completed {
            color: #006600;
            font-weight: bold;
        }
        .status-pending {
            color: #cc6600;
            font-weight: bold;
        }
        /* Image Container */
        .image-container {
            text-align: center;
            padding: 0;
        }
        .image-container img {
            /* Moved to inline style for mPDF compatibility */
        }
        .no-image {
            color: #999;
            font-style: italic;
            font-size: 14px;
        }
        /* Signature Section */
        .signature-table {
            width: 100%;
            margin-top: 15px;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            padding: 10px 20px;
        }
        .signature-img {
            height: 18mm;
            margin-bottom: 2px;
        }
        .signature-line {
            border-bottom: 1px dotted #000;
            width: 200px;
            margin: 0 auto 5px auto;
        }
        .signature-name {
            font-size: 18px;
            margin: 2px 0;
            font-weight: bold;
        }
        .signature-title {
            font-size: 16px;
            font-weight: bold;
            margin: 2px 0;
        }
        .signature-date {
            font-size: 16px;
            margin: 2px 0;
        }
        /* Footer */
        .document-footer {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px solid #999;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="document-container">
        <!-- New Streamlined Header -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
            <tr style="margin-bottom: 10px;">
                
                <td colspan="3"  style="width: 40%; text-align: center; vertical-align: middle;">
                    <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" style="width: 16mm; height: auto;" alt="ตราโรงเรียน"><br>
                    <b style="font-size: 18px;">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</b><br>
                    <small style="font-size: 12px;">สังกัดองค์การบริหารส่วนจังหวัดนครสวรรค์</small>
                </td>

            </tr>
           
            <tr>
                <td style="width: 30%; vertical-align: bottom; font-size: 16px;">
                    <b>เลขที่:</b> <?=$RepairUser[0]->repair_order?>
                </td>
                <td style="text-align: center; font-size: 24px; font-weight: bold; padding-bottom: 10px; padding-top: 20px;">
                    ใบแจ้งซ่อม
                </td>
                <td style="width: 30%; text-align: right; vertical-align: bottom; font-size: 16px;">
                    <b>วันที่:</b> <?=$Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datetime))?>
                </td>
            </tr>
        </table>

        <!-- Thin separator line instead of thick border -->
        <div style="border-bottom: 1px solid #000; margin-bottom: 15px;"></div>


        <!-- Section 1: ข้อมูลผู้แจ้ง -->
        <table class="content-table">
            <tr>
                <td colspan="4" class="section-header">ส่วนที่ 1: ข้อมูลการแจ้งซ่อม</td>
            </tr>
            <tr>
                <th>ผู้แจ้งซ่อม</th>
                <td><?=$RepairUser[0]->pers_prefix.$RepairUser[0]->pers_firstname.' '.$RepairUser[0]->pers_lastname?></td>
                <th>เบอร์โทรศัพท์</th>
                <td><?=$RepairUser[0]->repair_phone ?? '-'?></td>
            </tr>
            <tr>
                <th>ประเภทงาน</th>
                <td><?=$RepairUser[0]->repair_caselist?></td>
                <th>สถานที่</th>
                <td>อาคาร <?=$RepairUser[0]->repair_building?> ชั้น <?=$RepairUser[0]->repair_class?> ห้อง <?=$RepairUser[0]->repair_room?></td>
            </tr>
            <tr>
                <th>รายละเอียดปัญหา</th>
                <td colspan="3"><?=nl2br($RepairUser[0]->repair_detail ?: '-')?></td>
            </tr>
            <tr>
                <th style="text-align: center;">รูปภาพประกอบ</th>
                <td colspan="3" class="image-container">
                    <?php 
                        if(!empty($RepairUser[0]->repair_imguser)) : 
                            $user_imgs = explode(',', $RepairUser[0]->repair_imguser);
                            $user_imgs = array_filter($user_imgs);
                            $u_count = count($user_imgs);
                    ?>
                        <div style="text-align: center; padding: 5px 0;">
                            <?php foreach($user_imgs as $img): ?>
                                <img src="<?=ROOTPATH . 'uploads/user/Repair/'.$img?>" style="width: 150px; margin: 5px; display: inline-block; vertical-align: top;">
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="no-image">(ไม่มีรูปภาพประกอบ)</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <!-- Section 2: ผลการดำเนินการ -->
        <table class="content-table">
            <tr>
                <td colspan="4" class="section-header">ส่วนที่ 2: ผลการดำเนินการ</td>
            </tr>
            <tr>
                <th>สถานะ</th>
                <td>
                    <?php if($RepairUser[0]->repair_status == 'ดำเนินการเรียบร้อย'): ?>
                    <span class="status-completed">✓ <?=$RepairUser[0]->repair_status?></span>
                    <?php else: ?>
                    <span class="status-pending"><?=$RepairUser[0]->repair_status ?? 'รอดำเนินการ'?></span>
                    <?php endif; ?>
                </td>
                <th>วันที่ดำเนินการ</th>
                <td>
                    <?php 
                        if($RepairUser[0]->repair_datework == '0000-00-00 00:00:00' || $RepairUser[0]->repair_datework == null){
                            echo '-';
                        } else {
                            echo $Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datework));
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th>ผู้รับผิดชอบ</th>
                <td colspan="3">
                    <?php 
                        if(!isset($Repairman[0]->pers_prefix)) {
                            echo '-';
                        } else {
                            echo $Repairman[0]->pers_prefix.$Repairman[0]->pers_firstname.' '.$Repairman[0]->pers_lastname;
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th>สาเหตุ/วิธีแก้ไข</th>
                <td colspan="3"><?=nl2br($RepairUser[0]->repair_cause ?: '-')?></td>
            </tr>
            <tr>
                <th style="text-align: center;">รูปภาพหลังซ่อม</th>
                <td colspan="3" class="image-container">
                    <?php 
                        if(!empty($RepairUser[0]->repair_imgwork)) : 
                            $work_imgs = explode(',', $RepairUser[0]->repair_imgwork);
                            $work_imgs = array_filter($work_imgs);
                            $w_count = count($work_imgs);
                    ?>
                        <div style="text-align: center; padding: 5px 0;">
                            <?php foreach($work_imgs as $img_w): ?>
                                <img src="<?=ROOTPATH . 'uploads/admin/Repair/'.$img_w?>" style="width: 150px; margin: 5px; display: inline-block; vertical-align: top;">
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span class="no-image">(ไม่มีรูปภาพ)</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

          <table class="signature-table">
            <tr>
                <td>
                    <?php if($RepairUser[0]->repair_usersignature) : ?>
                    <img src="<?=$RepairUser[0]->repair_usersignature?>" class="signature-img">
                    <?php else: ?>
                    <div style="height: 50px;"></div>
                    <?php endif; ?>
                    <div class="signature-line"></div>
                    <p class="signature-name">(<?=$RepairUser[0]->pers_prefix.$RepairUser[0]->pers_firstname.' '.$RepairUser[0]->pers_lastname?>)</p>
                    <p class="signature-title">ผู้แจ้งซ่อม</p>
                    <p class="signature-date">วันที่ <?=$Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datetime))?></p>
                </td>
                <td>
                    <?php if($RepairUser[0]->repair_adminsignature) : ?>
                    <img src="<?=$RepairUser[0]->repair_adminsignature;?>" class="signature-img">
                    <?php else: ?>
                    <div style="height: 50px;"></div>
                    <?php endif; ?>
                    <div class="signature-line"></div>
                    <p class="signature-name">(<?=@$Repairman[0]->pers_prefix.@$Repairman[0]->pers_firstname.' '.@$Repairman[0]->pers_lastname ?? '...........................................'?>)</p>
                    <p class="signature-title">ผู้ดำเนินการซ่อม</p>
                    <p class="signature-date">วันที่ <?php if($RepairUser[0]->repair_datework != '0000-00-00 00:00:00' && $RepairUser[0]->repair_datework != null) echo $Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datework)); else echo '...........................................'; ?></p>
                </td>
            </tr>
        </table>

    </div>

    <!-- Footer for mPDF -->
    <htmlpagefooter name="MyFooter">
      
        
        <div class="document-footer">
            กลุ่มงานเทคโนโลยีสารสนเทศและงานเว็บไซต์ | โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
        </div>
    </htmlpagefooter>

    <!-- Activate footer -->
    <sethtmlpagefooter name="MyFooter" value="on" />
</body>
</html>