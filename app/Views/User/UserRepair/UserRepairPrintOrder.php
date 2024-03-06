<br>
<img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" style="width: 8%;float: left;margin-right:15px;" alt=""
    srcset="">

<div style="align-self: center;">
    <span style="font-size: 24px;">ระบบแจ้งซ่อมออนไลน์&nbsp;</span> <br>
    <span style="font-size: 18px;">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</span>
</div>
<hr>
<p
    style='box-sizing: border-box; margin: 0px; font-size: 1.5rem; cursor: text; padding: 0px; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(34, 34, 34); font-family: "Sailec Light", sans-serif; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: pre-wrap; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;'>
    <span style="font-size: 24px;">ข้อมูลการแจ้งซ่อม&nbsp;</span>

</p>
<table style="width: 100%;">
    <tbody>
        <tr>
            <td style="width: 20.7602%; text-align: right;">เลขที่ใบแจ้งซ่อม :&nbsp;</td>
            <td style="width: 79.1228%;"><?=$RepairUser[0]->repair_order?></td>
        </tr>
        <tr>
            <td style="width: 20.7602%; text-align: right;">วันที่แจ้งซ่อม :&nbsp;</td>
            <td style="width: 79.1228%;"><?=$Datethai->thai_date_and_time(strtotime($RepairUser[0]->repair_datetime))?>
            </td>
        </tr>
        <tr>
            <td style="width: 20.7602%; text-align: right;">ผู้แจ้งซ่อม :&nbsp;</td>
            <td style="width: 79.1228%;">
                <?=$RepairUser[0]->pers_prefix.$RepairUser[0]->pers_firstname.' '.$RepairUser[0]->pers_lastname?></td>
        </tr>
        <tr>
            <td style="width: 20.7602%; text-align: right;">รายการแจ้งซ่อม :&nbsp;</td>
            <td style="width: 79.1228%;"><?=$RepairUser[0]->repair_caselist?></td>
        </tr>
        <tr>
            <td style="width: 20.7602%; text-align: right;">ปัญหาการแจ้งซ่อม :&nbsp;</td>
            <td style="width: 79.1228%;">
                <?=$RepairUser[0]->repair_detail?> <br>
                ณ <?=$RepairUser[0]->repair_building?>
                ชั้น <?=$RepairUser[0]->repair_class?>
                ห้อง <?=$RepairUser[0]->repair_room?>

            </td>
        </tr>
        <tr>
            <td></td>
            <td><img src="<?=base_url('uploads/admin/Repair/User/').$RepairUser[0]->repair_imguser?>"
                    style="width: 300px;height:180px;"></td>

        </tr>
    </tbody>
</table>
<hr>
<p
    style='box-sizing: border-box; margin: 0px; font-size: 1.5rem; cursor: text; padding: 0px; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(34, 34, 34); font-family: "Sailec Light", sans-serif; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: pre-wrap; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;'>
    <span style="font-size: 24px;">ข้อมูลผู้รับซ่อม&nbsp;</span>
<table style="width: 100%;">
    <tr>
        <td style="width: 20.7602%; text-align: right;">สถานะ :&nbsp;
        </td>
        <td style="width: 79.1228%;"><?=$RepairUser[0]->repair_status?></td>
    </tr>
    <tr>
        <td style="width: 20.7602%; text-align: right;">ผู้รับซ่อม :&nbsp;</td>
        <td style="width: 79.1228%;">
            <?=@$Repairman[0]->pers_prefix.@$Repairman[0]->pers_firstname.' '.@$Repairman[0]->pers_lastname?></td>
    </tr>
    <tr>
        <td style="width: 20.7602%; text-align: right;">วันที่ซ่อม :&nbsp;</td>
        <td style="width: 79.1228%;">
            <?php 
                    if($RepairUser[0]->repair_datework == '0000-00-00 00:00:00' || $RepairUser[0]->repair_datework == null){
                       
                    }else{
                        echo $Datethai->thai_date_and_time(strtotime($RepairUser[0]->repair_datework));
                    }
                ?>

        </td>
    </tr>
    <tr>
        <td style="width: 20.7602%; text-align: right;">สาเหตุ/วิธีแก้ไข :&nbsp;</td>
        <td style="width: 79.1228%;"><?=$RepairUser[0]->repair_cause?></td>
    </tr>
</table>
</p>
<hr>
<br>



<table style="width: 100%;">
    <tbody>
        <tr>
            <td style="width: 50.0000%;text-align: center;">
                <?php if($RepairUser[0]->repair_usersignature) : ?>
                <!-- <img src="" alt=""
                    style="width: 25%;margin-bottom: -29px;margin-top: -0px;position: absolute;"> -->
                <br>
                <?php endif; ?>
                ลงชื่อ ............................................
                <br>(<?=$RepairUser[0]->pers_prefix.$RepairUser[0]->pers_firstname.' '.$RepairUser[0]->pers_lastname?>)
                <br>ผู้แจ้งซ่อม
                <br>วันที่ <?=$Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datetime))?>

                </div>
            </td>
            <td style="width: 50.0000%; text-align: center;">
                <?php if($RepairUser[0]->repair_usersignature) : ?>
                <!-- <img src="" alt=""
                    style="width: 25%;margin-bottom: -29px;margin-top: -0px;position: absolute;"> -->
                <br>
                <?php endif; ?>
                <div style="" id="isPasted">ลงชื่อ ............................................
                    <br>(<?=@$Repairman[0]->pers_prefix.@$Repairman[0]->pers_firstname.' '.@$Repairman[0]->pers_lastname?>)
                    <br>ผู้รับซ่อม
                    <br>วันที่ <?=$Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datework))?>
                </div>
            </td>
        </tr>
    </tbody>
</table>