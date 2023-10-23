<br> <br> <br>
    <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" style="width: 8%;float: left;margin-right:15px;" alt="" srcset="">

    <div style="align-self: center;">
        <span style="font-size: 24px;">ระบบแจ้งซ่อมออนไลน์&nbsp;</span> <br>
        <span style="font-size: 18px;">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</span>
    </div>

    </p>
    <br>
    </p>
    <hr>
    <p
        style='box-sizing: border-box; margin: 0px; font-size: 1.5rem; cursor: text; padding: 0px; counter-reset: list-1 0 list-2 0 list-3 0 list-4 0 list-5 0 list-6 0 list-7 0 list-8 0 list-9 0; color: rgb(34, 34, 34); font-family: "Sailec Light", sans-serif; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: pre-wrap; background-color: rgb(255, 255, 255); text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;'>
        <span style="font-size: 24px;">ข้อมูลการแจ้งซ่อม&nbsp;</span>
       
    </p>
    <hr>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 20.7602%; text-align: right;">เลขที่ใบแจ้งซ่อม :&nbsp;</td>
                <td style="width: 79.1228%;"><?=$RepairUser[0]->repair_order?></td>
            </tr>
            <tr>
                <td style="width: 20.7602%; text-align: right;">วันที่แจ้งซ่อม :&nbsp;</td>
                <td style="width: 79.1228%;"><?=$Datethai->thai_date_and_time(strtotime($RepairUser[0]->repair_datetime))?></td>
            </tr>
            <tr>
                <td style="width: 20.7602%; text-align: right;">ผู้แจ้งซ่อม :&nbsp;</td>
                <td style="width: 79.1228%;"><?=$RepairUser[0]->pers_prefix.$RepairUser[0]->pers_firstname.' '.$RepairUser[0]->pers_lastname?></td>
            </tr>
            <tr>
                <td style="width: 20.7602%; text-align: right;">รายการแจ้งซ่อม :&nbsp;</td>
                <td style="width: 79.1228%;"><?=$RepairUser[0]->repair_caselist?></td>
            </tr>
            <tr>
                <td style="width: 20.7602%; text-align: right;">ปัญหาการแจ้งซ่อม :&nbsp;</td>
                <td style="width: 79.1228%;"><?=$RepairUser[0]->repair_detail?></td>
            </tr>
            <tr>
                <td style="width: 20.7602%; text-align: right;">ผู้ซ่อม :&nbsp;</td>
                <td style="width: 79.1228%;"><?=@$Repairman[0]->pers_prefix.@$Repairman[0]->pers_firstname.' '.@$Repairman[0]->pers_lastname?></td>
            </tr>
            <tr>
                <td style="width: 20.7602%; text-align: right;">สถานะ :&nbsp;
                </td>
                <td style="width: 79.1228%;"><?=$RepairUser[0]->repair_status?></td>
            </tr>
        </tbody>
    </table>
    <hr>


    <br> <br> <br> <br>


    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50.0000%;text-align: center;">
                    <div style=""></div>
                        <!-- <img src="<?=$RepairUser[0]->repair_usersignature?>" alt="" style="width: 30%;" >  <br> -->
                        ลงชื่อ ............................................
                        <br>(<?=$RepairUser[0]->pers_prefix.$RepairUser[0]->pers_firstname.' '.$RepairUser[0]->pers_lastname?>)
                        <br>ผู้แจ้งซ่อม
                        <br>วันที่ <?=$Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datetime))?>
                        
                    </div>
                </td>
                <td style="width: 50.0000%; text-align: center;">
                    <div style="" id="isPasted">ลงชื่อ ............................................
                        <br>(<?=@$Repairman[0]->pers_prefix.@$Repairman[0]->pers_firstname.' '.@$Repairman[0]->pers_lastname?>)
                        <br>ผู้ซ่อม
                        <br>วันที่ <?=$Datethai->thai_date_fullmonth(strtotime($RepairUser[0]->repair_datework))?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
