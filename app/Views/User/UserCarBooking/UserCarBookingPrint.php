<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบ 3 - ใบขออนุญาตใช้รถส่วนกลาง / ขออนุมัติเบิกน้ำมันเชื้อเพลิงและหล่อลื่น</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />

    <!-- TH Sarabun & Sarabun Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">

    <style>
        @font-face {
            font-family: 'TH Sarabun New';
            src: local('TH Sarabun New'), local('THSarabunNew');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'TH Sarabun New';
            src: local('TH Sarabun New Bold'), local('THSarabunNew-Bold');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'TH Sarabun PSK';
            src: local('TH Sarabun PSK'), local('THSarabunPSK');
            font-weight: normal;
            font-style: normal;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'TH Sarabun New', 'TH Sarabun PSK', 'Sarabun', sans-serif;
            font-size: 15.5pt;
            line-height: 1.48;
            color: #000;
            background-color: #4a5568;
            margin: 0;
            padding: 15px 0;
        }

        /* Top Action Toolbar */
        .top-toolbar {
            max-width: 210mm;
            margin: 0 auto 12px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 9px 18px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            font-family: 'Sarabun', sans-serif;
        }

        .toolbar-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .toolbar-actions {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 14px;
            font-size: 13.5px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .btn-back {
            background: #f1f5f9;
            color: #475569;
            border-color: #cbd5e1;
        }

        .btn-back:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        .btn-toggle {
            background: #f0f9ff;
            color: #0369a1;
            border-color: #bae6fd;
        }

        .btn-toggle:hover {
            background: #e0f2fe;
        }

        .btn-print {
            background: #2563eb;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
        }

        .btn-print:hover {
            background: #1d4ed8;
        }

        /* A4 Page Container (Strict 1 Page) */
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 1.2cm 1.8cm 1.0cm 2.0cm;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            box-sizing: border-box;
            position: relative;
        }

        .doc-header-right {
            text-align: right;
            font-size: 15.5pt;
            margin-bottom: 4px;
        }

        .doc-title {
            text-align: center;
            font-size: 17.5pt;
            font-weight: bold;
            margin-bottom: 6px;
            line-height: 1.25;
        }

        /* Line blocks for Word-like flow & fresh line breaks */
        .line-block {
            line-height: 1.5;
            margin-bottom: 2px;
            text-align: justify;
            text-justify: inter-cluster;
            font-size: 15.5pt;
        }

        /* ข้อความที่มีข้อมูลแล้ว (ตัวหนา ชัดเจน ไม่มีเส้นประ) */
        .val-text {
            font-weight: 600;
            color: #000;
            padding: 0 3px;
        }

        /* ช่องว่างที่ยังไม่มีข้อมูล (แสดงเส้นประกระชับ สวยงาม) */
        .doc-field {
            display: inline-block;
            background-image: linear-gradient(to right, #000 42%, transparent 42%);
            background-position: 0 100%;
            background-size: 2.8px 1.2px;
            background-repeat: repeat-x;
            vertical-align: baseline;
            min-height: 18px;
            padding: 0 2px;
        }

        /* Compact & Centered Signature Boxes */
        .sig-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 5px;
        }

        .sig-box {
            width: 8.2cm;
            text-align: center;
            line-height: 1.2;
            font-size: 15.5pt;
        }

        .sig-row-top {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 2px;
        }

        .sig-line-center {
            text-align: center;
            margin: 2px 0;
        }

        /* Checkbox */
        .box-check {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 13px;
            height: 13px;
            border: 1.5px solid #000;
            margin-right: 5px;
            font-size: 11pt;
            font-weight: bold;
            line-height: 1;
            vertical-align: middle;
        }

        /* Print Settings (Strictly 1 Page A4) */
        @media print {
            @page {
                size: A4 portrait;
                margin: 1.2cm 1.8cm 1.0cm 2.0cm;
            }

            html,
            body {
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: none !important;
                font-size: 15.5pt;
                overflow: hidden !important;
            }

            .no-print {
                display: none !important;
            }

            .page {
                width: 100% !important;
                height: 100% !important;
                min-height: auto !important;
                max-height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                page-break-after: avoid !important;
                page-break-before: avoid !important;
                page-break-inside: avoid !important;
            }
        }
    </style>
</head>

<body>

    <!-- แถบเมนูด้านบน (ไม่แสดงเวลาพิมพ์) -->
    <div class="top-toolbar no-print">
        <div class="toolbar-title">
            <span>📋</span>
            <span>แบบ 3 ใบขออนุญาตใช้รถส่วนกลาง / ขออนุมัติเบิกน้ำมันเชื้อเพลิงและหล่อลื่น (A4 หน้าเดียว)</span>
        </div>
        <div class="toolbar-actions">
            <a href="<?= base_url('CarBooking') ?>" class="btn-action btn-back" onclick="if(window.opener && window.history.length <= 1){window.close();return false;}else if(window.history.length > 1){window.history.back();return false;}">
                ↩️ ย้อนกลับ
            </a>
            <button type="button" class="btn-action btn-toggle" onclick="toggleBlankMode()">
                👁️ <span id="toggleText">สลับเป็นแบบฟอร์มเปล่า</span>
            </button>
            <button type="button" class="btn-action btn-print" onclick="window.print()">
                🖨️ พิมพ์เอกสาร (A4)
            </button>
        </div>
    </div>

    <!-- กระดาษ A4 -->
    <div class="page">
        <!-- หัวเอกสารมุมขวาบน -->
        <div class="doc-header-right">แบบ 3</div>

        <!-- ชื่อเอกสาร -->
        <div class="doc-title">
            ใบขออนุญาตใช้รถส่วนกลาง / ขออนุมัติเบิกน้ำมันเชื้อเพลิงและหล่อลื่น
        </div>

        <?php
        $monthTH = [null, 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        // Format dates
        $createDate = !empty($Booking->car_reserv_created_at) ? strtotime($Booking->car_reserv_created_at) : null;
        $d = $createDate ? date('j', $createDate) : '';
        $m = $createDate ? $monthTH[date('n', $createDate)] : '';
        $y = $createDate ? (date('Y', $createDate) + 543) : '';

        $startDate = !empty($Booking->car_reserv_StartDate) ? strtotime($Booking->car_reserv_StartDate) : null;
        $start_d = $startDate ? date('j', $startDate) : '';
        $start_m = $startDate ? $monthTH[date('n', $startDate)] : '';
        $start_y = $startDate ? (date('Y', $startDate) + 543) : '';
        $start_date_text = $startDate ? ($start_d . ' ' . $start_m . ' ' . $start_y) : '';

        $endDate = !empty($Booking->car_reserv_EndDate) ? strtotime($Booking->car_reserv_EndDate) : null;
        $end_d = $endDate ? date('j', $endDate) : '';
        $end_m = $endDate ? $monthTH[date('n', $endDate)] : '';
        $end_y = $endDate ? (date('Y', $endDate) + 543) : '';
        $end_date_text = $endDate ? ($end_d . ' ' . $end_m . ' ' . $end_y) : '';

        $start_time = !empty($Booking->car_reserv_StartTime) ? substr($Booking->car_reserv_StartTime, 0, 5) : '';
        $end_time = !empty($Booking->car_reserv_EndTime) ? substr($Booking->car_reserv_EndTime, 0, 5) : '';

        $req_name = trim(($Booking->req_prefix ?? '') . ($Booking->req_firstname ?? '') . ' ' . ($Booking->req_lastname ?? ''));
        $drv_name = ($Booking->car_reserv_driver) ? trim(($Booking->drv_prefix ?? '') . ($Booking->drv_firstname ?? '') . ' ' . ($Booking->drv_lastname ?? '')) : '';

        // Helper จัดรูปแบบตำแหน่ง + วิทยฐานะ
        $formatPosition = function($bookingObj) {
            $posiMain = trim($bookingObj->req_position_main ?? '');
            $posiName = trim($bookingObj->req_position ?? '');
            $persPos  = trim($bookingObj->req_pers_position ?? '');
            $academic = trim($bookingObj->req_academic ?? '');
            $learning = trim($bookingObj->req_pers_learning ?? '');

            // 1. ถ้ามีชื่อตำแหน่งจริงจาก tb_position_main (เช่น เจ้าหน้าที่พัสดุ, เจ้าหน้าที่การเงิน, พนักงานขับรถ ฯลฯ)
            if (!empty($posiMain)) {
                $position = $posiMain;
            } elseif (!empty($posiName)) {
                $position = $posiName;
            } else {
                $position = $persPos;
            }

            // ตรวจสอบ fallback กรณีประเภทการจ้างทั่วไป
            $isGeneralEmploymentType = (
                mb_strpos($position, 'พนักงานจ้าง') !== false ||
                mb_strpos($position, 'ลูกจ้าง') !== false
            );

            if ($isGeneralEmploymentType && !empty($learning) && !is_numeric($learning)) {
                $position = $learning;
            }

            if (empty($academic)) {
                return $position;
            }
            // ผู้อำนวยการ และ รองผู้อำนวยการ ไม่ต้องใส่วิทยฐานะ
            if (mb_strpos($position, 'ผู้อำนวยการ') !== false || mb_strpos($position, 'รองผู้อำนวยการ') !== false) {
                return $position;
            }
            // เฉพาะตำแหน่งครู
            if ($position === 'ครู' || mb_strpos($position, 'ครู') !== false) {
                if (mb_strpos($academic, 'วิทยฐานะ') !== false) {
                    return $position . ' ' . $academic;
                }
                if (mb_strpos($academic, 'ครู') === 0) {
                    return $position . ' วิทยฐานะ' . $academic;
                }
                return $position . ' วิทยฐานะครู' . $academic;
            }
            return $position;
        };

        $req_position_full = $formatPosition($Booking);

        // รองผู้อำนวยการกลุ่มบริหารทั่วไป (หัวหน้าฝ่าย)
        $deputy_name = isset($DeputyDirectorGeneral) ? $DeputyDirectorGeneral->ExecutiveName : '';
        $deputy_position = 'รองผู้อำนวยการกลุ่มบริหารทั่วไป';

        // ผู้มีอำนาจสั่งใช้รถ (ผอ.โรงเรียน)
        $dir_name = isset($Director) ? $Director->DirectorName : '';
        $dir_position = 'ผู้อำนวยการโรงเรียน';
        $car_reg_full = trim(($Booking->car_registration ?? '') . ' ' . ($Booking->car_province ?? ''));

        // Fuel requests
        $isFuelReq = ($Booking->fuel_request == 'yes');
        $fuel_95 = ($isFuelReq && $Booking->fuel_type == 'น้ำมันแก๊สโซฮอล์ 95') ? $Booking->fuel_amount : '';
        $fuel_91 = ($isFuelReq && $Booking->fuel_type == 'น้ำมันแก๊สโซฮอล์ 91') ? $Booking->fuel_amount : '';
        $fuel_b10 = ($isFuelReq && $Booking->fuel_type == 'น้ำมันดีเซล B10') ? $Booking->fuel_amount : '';
        $fuel_b7 = ($isFuelReq && $Booking->fuel_type == 'น้ำมันดีเซล B7') ? $Booking->fuel_amount : '';
        $fuel_other = ($isFuelReq && $Booking->fuel_type == 'อื่นๆ') ? $Booking->fuel_amount : '';
        $fuel_other_desc = ($isFuelReq && $Booking->fuel_type == 'อื่นๆ') ? $Booking->fuel_other_desc : '';

        $fuel_po_date_text = !empty($Booking->fuel_po_date) ? $Datethai->thai_date_fullmonth(strtotime($Booking->fuel_po_date)) : '';

        // Status checks
        $isApproved = ($Booking->car_reserv_status == 'อนุมัติ');
        $isRejected = ($Booking->car_reserv_status == 'ไม่อนุมัติ');
        $fuelApproved = ($Booking->fuel_approver_status == 'approved');
        $fuelRejected = ($Booking->fuel_approver_status == 'rejected');
        ?>

        <!-- วันที่ -->
        <div id="dateFilled" style="text-align: right; padding-right: 1.5cm; margin-bottom: 5px; font-size: 15.5pt;">
            วันที่
            <?= $d ? '<span class="val-text">' . $d . '</span>' : '<span class="doc-field" style="min-width: 40px;"></span>' ?>
            เดือน
            <?= $m ? '<span class="val-text">' . $m . '</span>' : '<span class="doc-field" style="min-width: 120px;"></span>' ?>
            พ.ศ.
            <?= $y ? '<span class="val-text">' . $y . '</span>' : '<span class="doc-field" style="min-width: 55px;"></span>' ?>
        </div>
        <div id="dateBlank"
            style="text-align: right; padding-right: 1.5cm; margin-bottom: 5px; font-size: 15.5pt; display: none;">
            วันที่ <span class="doc-field" style="min-width: 40px;"></span> เดือน <span class="doc-field"
                style="min-width: 120px;"></span> พ.ศ. <span class="doc-field" style="min-width: 55px;"></span>
        </div>

        <!-- เรียน -->
        <div style="margin-bottom: 4px; font-size: 15.5pt;">
            เรียน&nbsp;&nbsp;&nbsp;&nbsp;นายกองค์การบริหารส่วนจังหวัดนครสวรรค์
        </div>

        <!-- เนื้อหาแบบมีข้อมูล (มีข้อมูลแล้วไม่มีเส้นประ / ตรงไหนเป็นช่องว่างมีเส้นประ) -->
        <div id="viewFilled">
            <!-- ข้าพเจ้า / ตำแหน่ง / สำนัก/กอง/หน่วย / ขออนุญาตใช้รถ หมายเลขทะเบียน -->
            <div class="line-block" style="text-indent: 2.5cm;">
                ข้าพเจ้า
                <?= $req_name ? '<span class="val-text">' . esc($req_name) . '</span>' : '<span class="doc-field" style="min-width: 250px;"></span>' ?>
                ตำแหน่ง
                <?= !empty($req_position_full) ? '<span class="val-text">' . esc($req_position_full) . '</span>' : '<span class="doc-field" style="min-width: 150px;"></span>' ?>
                สำนัก/กอง/หน่วย
                <?= $req_department ? '<span class="val-text">' . esc($req_department) . '</span>' : '<span class="doc-field" style="min-width: 200px;"></span>' ?>
                ขออนุญาตใช้รถ หมายเลขทะเบียน
                <?= $car_reg_full ? '<span class="val-text">' . esc($car_reg_full) . '</span>' : '<span class="doc-field" style="min-width: 180px;"></span>' ?>
            </div>

            <!-- ไปราชการที่ (ขึ้นบรรทัดใหม่) -->
            <div class="line-block">
                ไปราชการที่
                <?= !empty($Booking->car_reserv_location) ? '<span class="val-text">' . esc($Booking->car_reserv_location) . '</span>' : '<span class="doc-field" style="min-width: calc(100% - 95px);"></span>' ?>
            </div>

            <!-- เพื่อปฏิบัติงานเรื่อง (ขึ้นบรรทัดใหม่) -->
            <div class="line-block">
                เพื่อปฏิบัติงานเรื่อง
                <?= !empty($Booking->car_reserv_detail) ? '<span class="val-text">' . esc($Booking->car_reserv_detail) . '</span>' : '<span class="doc-field" style="min-width: calc(100% - 145px);"></span>' ?>
            </div>

            <!-- มีคนนั่ง (ขึ้นบรรทัดใหม่) -->
            <div class="line-block">
                มีคนนั่ง
                <?= !empty($Booking->car_reserv_number) ? '<span class="val-text">' . esc($Booking->car_reserv_number) . '</span>' : '<span class="doc-field" style="min-width: 45px;"></span>' ?>
                คน
                ในวันที่
                <?= $start_date_text ? '<span class="val-text">' . $start_date_text . '</span>' : '<span class="doc-field" style="min-width: 135px;"></span>' ?>
                เวลา
                <?= $start_time ? '<span class="val-text">' . $start_time . '</span>' : '<span class="doc-field" style="min-width: 65px;"></span>' ?>
                น.
                ถึงวันที่
                <?= $end_date_text ? '<span class="val-text">' . $end_date_text . '</span>' : '<span class="doc-field" style="min-width: 135px;"></span>' ?>
                เวลา
                <?= $end_time ? '<span class="val-text">' . $end_time . '</span>' : '<span class="doc-field" style="min-width: 65px;"></span>' ?>
                น.
            </div>

            <!-- โดยให้ (ขึ้นบรรทัดใหม่) -->
            <div class="line-block">
                โดยให้
                <?= $drv_name ? '<span class="val-text">' . esc($drv_name) . '</span>' : '<span class="doc-field" style="min-width: 250px;"></span>' ?>
                เป็นผู้ขับรถยนต์ และขอใช้น้ำมันเชื้อเพลิง
            </div>
        </div>

        <!-- เนื้อหาแบบฟอร์มเปล่า -->
        <div id="viewBlank" style="display: none; margin-bottom: 4px;">
            <div class="line-block" style="text-indent: 2.5cm;">
                ข้าพเจ้า <span class="doc-field" style="min-width: 220px;"></span>
                ตำแหน่ง <span class="doc-field" style="min-width: 140px;"></span>
                สำนัก/กอง/หน่วย <span class="doc-field" style="min-width: 180px;"></span>
                ขออนุญาตใช้รถ หมายเลขทะเบียน <span class="doc-field" style="min-width: 180px;"></span>
            </div>
            <div class="line-block">
                ไปราชการที่ <span class="doc-field" style="min-width: calc(100% - 95px);"></span>
            </div>
            <div class="line-block">
                เพื่อปฏิบัติงานเรื่อง <span class="doc-field" style="min-width: calc(100% - 145px);"></span>
            </div>
            <div class="line-block">
                มีคนนั่ง <span class="doc-field" style="min-width: 45px;"></span> คน
                ในวันที่ <span class="doc-field" style="min-width: 135px;"></span>
                เวลา <span class="doc-field" style="min-width: 65px;"></span> น.
                ถึงวันที่ <span class="doc-field" style="min-width: 135px;"></span>
                เวลา <span class="doc-field" style="min-width: 65px;"></span> น.
            </div>
            <div class="line-block">
                โดยให้ <span class="doc-field" style="min-width: 250px;"></span>
                เป็นผู้ขับรถยนต์ และขอใช้น้ำมันเชื้อเพลิง
            </div>
        </div>

        <!-- รายการน้ำมันเชื้อเพลิง (5 รายการ 2 คอลัมน์ เลขอารบิกทั้งหมด) -->
        <div id="fuelFilled"
            style="display: flex; justify-content: space-between; margin-top: 4px; margin-bottom: 4px; padding-left: 15px; line-height: 1.5; font-size: 15.5pt;">
            <div style="width: 48%;">
                <div>1. น้ำมันแก๊สโซฮอล์ 95 &nbsp;&nbsp;จำนวน
                    <?= $fuel_95 ? '<span class="val-text">' . $fuel_95 . '</span>' : '<span class="doc-field" style="min-width: 70px;"></span>' ?>
                    ลิตร
                </div>
                <div>2. น้ำมันแก๊สโซฮอล์ 91 &nbsp;&nbsp;จำนวน
                    <?= $fuel_91 ? '<span class="val-text">' . $fuel_91 . '</span>' : '<span class="doc-field" style="min-width: 70px;"></span>' ?>
                    ลิตร
                </div>
                <div>3. น้ำมันดีเซล B10 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวน
                    <?= $fuel_b10 ? '<span class="val-text">' . $fuel_b10 . '</span>' : '<span class="doc-field" style="min-width: 70px;"></span>' ?>
                    ลิตร
                </div>
            </div>
            <div style="width: 48%;">
                <div>4. น้ำมันดีเซล B7 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวน
                    <?= $fuel_b7 ? '<span class="val-text">' . $fuel_b7 . '</span>' : '<span class="doc-field" style="min-width: 70px;"></span>' ?>
                    ลิตร
                </div>
                <div>5. อื่นๆ
                    <?= $fuel_other_desc ? '<span class="val-text">' . $fuel_other_desc . '</span>' : '<span class="doc-field" style="min-width: 90px;"></span>' ?>
                    จำนวน
                    <?= $fuel_other ? '<span class="val-text">' . $fuel_other . '</span>' : '<span class="doc-field" style="min-width: 70px;"></span>' ?>
                    ลิตร
                </div>
            </div>
        </div>

        <div id="fuelBlank"
            style="display: none; justify-content: space-between; margin-top: 4px; margin-bottom: 4px; padding-left: 15px; line-height: 1.5; font-size: 15.5pt;">
            <div style="width: 48%;">
                <div>1. น้ำมันแก๊สโซฮอล์ 95 &nbsp;&nbsp;จำนวน <span class="doc-field" style="min-width: 70px;"></span>
                    ลิตร</div>
                <div>2. น้ำมันแก๊สโซฮอล์ 91 &nbsp;&nbsp;จำนวน <span class="doc-field" style="min-width: 70px;"></span>
                    ลิตร</div>
                <div>3. น้ำมันดีเซล B10 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวน <span class="doc-field"
                        style="min-width: 70px;"></span> ลิตร</div>
            </div>
            <div style="width: 48%;">
                <div>4. น้ำมันดีเซล B7 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวน <span class="doc-field"
                        style="min-width: 70px;"></span> ลิตร</div>
                <div>5. อื่นๆ <span class="doc-field" style="min-width: 90px;"></span> จำนวน <span class="doc-field"
                        style="min-width: 70px;"></span> ลิตร</div>
            </div>
        </div>

        <!-- ลายเซ็นผู้ขออนุญาต & หัวหน้าฝ่าย (ชิดขวา กระชับ และชื่อกับตำแหน่งอยู่กึ่งกลางลงชื่อเสมอ) -->
        <div id="sigFilled">
            <!-- ผู้ขออนุญาต -->
            <div class="sig-container">
                <div class="sig-box">
                    <div class="sig-row-top">
                        <span>(ลงชื่อ)</span>
                        <span class="doc-field" style="flex: 1; height: 16px; margin: 0 4px;"></span>
                        <span>ผู้ขออนุญาต</span>
                    </div>
                    <div class="sig-line-center">
                        ( <span class="val-text"><?= esc($req_name) ?></span> )
                    </div>
                    <div class="sig-line-center">
                        ตำแหน่ง <span class="val-text"><?= esc($req_position_full) ?></span>
                    </div>
                </div>
            </div>

            <!-- หัวหน้าฝ่าย (รองผู้อำนวยการกลุ่มบริหารทั่วไป) -->
            <div class="sig-container" style="margin-top: 4px;">
                <div class="sig-box">
                    <div class="sig-row-top">
                        <span>(ลงชื่อ)</span>
                        <span class="doc-field" style="flex: 1; height: 16px; margin: 0 4px;"></span>
                        <span>หัวหน้าฝ่าย</span>
                    </div>
                    <div class="sig-line-center">
                        ( <span class="val-text"><?= esc($deputy_name) ?></span> )
                    </div>
                    <div class="sig-line-center">
                        ตำแหน่ง <span class="val-text"><?= esc($deputy_position) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div id="sigBlank" style="display: none;">
            <div class="sig-container">
                <div class="sig-box">
                    <div class="sig-row-top">
                        <span>(ลงชื่อ)</span>
                        <span class="doc-field" style="flex: 1; height: 16px; margin: 0 4px;"></span>
                        <span>ผู้ขออนุญาต</span>
                    </div>
                    <div class="sig-line-center">
                        ( <span class="doc-field" style="min-width: 180px;"></span> )
                    </div>
                    <div class="sig-line-center">
                        ตำแหน่ง <span class="doc-field" style="min-width: 180px;"></span>
                    </div>
                </div>
            </div>
            <div class="sig-container" style="margin-top: 4px;">
                <div class="sig-box">
                    <div class="sig-row-top">
                        <span>(ลงชื่อ)</span>
                        <span class="doc-field" style="flex: 1; height: 16px; margin: 0 4px;"></span>
                        <span>หัวหน้าฝ่าย</span>
                    </div>
                    <div class="sig-line-center">
                        ( <span class="doc-field" style="min-width: 180px;"></span> )
                    </div>
                    <div class="sig-line-center">
                        ตำแหน่ง <span class="val-text">รองผู้อำนวยการกลุ่มบริหารทั่วไป</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ความเห็นสั่งใช้รถ & พิจารณาสั่งการน้ำมัน + ลายเซ็นผู้อนุมัติ -->
        <div style="margin-top: 5px; font-size: 15.5pt;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; line-height: 1.35;">
                <!-- คอลัมน์ซ้าย: สั่งใช้รถ -->
                <div style="width: 48%;">
                    <div style="margin-bottom: 2px;">ความเห็นของผู้มีอำนาจสั่งใช้รถ</div>
                    <div style="margin-bottom: 1px;">
                        <span class="box-check" id="chkApprove"><?= $isApproved ? '✓' : '' ?></span> อนุญาต
                    </div>
                    <div>
                        <span class="box-check" id="chkReject"><?= $isRejected ? '✓' : '' ?></span> ไม่อนุญาต
                    </div>
                </div>

                <!-- คอลัมน์ขวา: สั่งการใช้น้ำมัน -->
                <div style="width: 48%; padding-left: 20px;">
                    <div style="margin-bottom: 2px;">พิจารณาสั่งการใช้น้ำมันเชื้อเพลิง</div>
                    <div style="margin-bottom: 1px;">
                        <span class="box-check" id="chkFuelApprove"><?= $fuelApproved ? '✓' : '' ?></span> อนุมัติ
                    </div>
                    <div>
                        <span class="box-check" id="chkFuelReject"><?= $fuelRejected ? '✓' : '' ?></span> ไม่อนุมัติ
                    </div>
                </div>
            </div>

            <!-- ลายเซ็นผู้มีอำนาจสั่งใช้รถ (ผอ.โรงเรียน) -->
            <div id="approverFilled"
                style="display: flex; justify-content: center; margin-top: 4px; padding-left: 2.5cm;">
                <div class="sig-box">
                    <div class="sig-line-center">
                        (ลงชื่อ) <span class="doc-field" style="width: 5.5cm; height: 16px; margin: 0 4px;"></span>
                    </div>
                    <div class="sig-line-center">
                        ( <span class="val-text"><?= esc($dir_name) ?></span> )
                    </div>
                    <div class="sig-line-center">
                        ตำแหน่ง <span class="val-text"><?= esc($dir_position) ?></span>
                    </div>
                    <div class="sig-line-center">
                        <span class="doc-field" style="width: 4.5cm; height: 16px;"></span> (วัน เดือน ปี)
                    </div>
                </div>
            </div>

            <div id="approverBlank"
                style="display: none; justify-content: center; margin-top: 4px; padding-left: 2.5cm;">
                <div class="sig-box">
                    <div class="sig-line-center">
                        (ลงชื่อ) <span class="doc-field" style="width: 5.5cm; height: 16px; margin: 0 4px;"></span>
                    </div>
                    <div class="sig-line-center">
                        ( <span class="doc-field" style="min-width: 180px;"></span> )
                    </div>
                    <div class="sig-line-center">
                        ตำแหน่ง <span class="val-text">ผู้อำนวยการโรงเรียน</span>
                    </div>
                    <div class="sig-line-center">
                        <span class="doc-field" style="width: 4.5cm; height: 16px;"></span> (วัน เดือน ปี)
                    </div>
                </div>
            </div>
        </div>

        <!-- ท้ายเอกสาร: ใบสั่งซื้อสินค้า & เลขไมล์ (มีข้อมูลแล้วไม่มีเส้นประ / ว่างอยู่มีเส้นประ) -->
        <div id="footerFilled" style="margin-top: 8px; line-height: 1.5; font-size: 15.5pt;">
            <div>
                ใบสั่งซื้อสินค้า เล่มที่
                <?= !empty($Booking->fuel_po_book) ? '<span class="val-text">' . esc($Booking->fuel_po_book) . '</span>' : '<span class="doc-field" style="min-width: 75px;"></span>' ?>
                เลขที่
                <?= !empty($Booking->fuel_po_number) ? '<span class="val-text">' . esc($Booking->fuel_po_number) . '</span>' : '<span class="doc-field" style="min-width: 75px;"></span>' ?>
                ลงวันที่
                <?= $fuel_po_date_text ? '<span class="val-text">' . $fuel_po_date_text . '</span>' : '<span class="doc-field" style="min-width: 140px;"></span>' ?>
            </div>
            <div style="margin-top: 2px;">
                ระยะ กม.ไมล์เมื่อรถออกเดินทาง
                <?= !empty($Booking->departure_mileage) ? '<span class="val-text">' . esc($Booking->departure_mileage) . '</span>' : '<span class="doc-field" style="min-width: 130px;"></span>' ?>
                ระยะ กม.ไมล์เมื่อกลับถึงสำนักงาน
                <?= !empty($Booking->return_mileage) ? '<span class="val-text">' . esc($Booking->return_mileage) . '</span>' : '<span class="doc-field" style="min-width: 100px;"></span>' ?>
            </div>
        </div>

        <div id="footerBlank" style="display: none; margin-top: 8px; line-height: 1.5; font-size: 15.5pt;">
            <div>
                ใบสั่งซื้อสินค้า เล่มที่ <span class="doc-field" style="min-width: 75px;"></span>
                เลขที่ <span class="doc-field" style="min-width: 75px;"></span>
                ลงวันที่ <span class="doc-field" style="min-width: 140px;"></span>
            </div>
            <div style="margin-top: 2px;">
                ระยะ กม.ไมล์เมื่อรถออกเดินทาง <span class="doc-field" style="min-width: 130px;"></span>
                &nbsp;&nbsp;&nbsp;&nbsp;ระยะ กม.ไมล์เมื่อกลับถึงสำนักงาน <span class="doc-field"
                    style="min-width: 100px;"></span>
            </div>
        </div>

    </div>

    <script>
        let isBlankMode = false;
        function toggleBlankMode() {
            isBlankMode = !isBlankMode;
            document.getElementById('toggleText').textContent = isBlankMode ? 'สลับเป็นแบบมีข้อมูล' : 'สลับเป็นแบบฟอร์มเปล่า';

            // Toggle views
            document.getElementById('viewFilled').style.display = isBlankMode ? 'none' : 'block';
            document.getElementById('viewBlank').style.display = isBlankMode ? 'block' : 'none';

            document.getElementById('dateFilled').style.display = isBlankMode ? 'none' : 'block';
            document.getElementById('dateBlank').style.display = isBlankMode ? 'block' : 'none';

            document.getElementById('fuelFilled').style.display = isBlankMode ? 'none' : 'flex';
            document.getElementById('fuelBlank').style.display = isBlankMode ? 'flex' : 'none';

            document.getElementById('sigFilled').style.display = isBlankMode ? 'none' : 'block';
            document.getElementById('sigBlank').style.display = isBlankMode ? 'block' : 'none';

            document.getElementById('approverFilled').style.display = isBlankMode ? 'none' : 'flex';
            document.getElementById('approverBlank').style.display = isBlankMode ? 'flex' : 'none';

            document.getElementById('footerFilled').style.display = isBlankMode ? 'none' : 'block';
            document.getElementById('footerBlank').style.display = isBlankMode ? 'block' : 'none';

            // Checkboxes
            document.getElementById('chkApprove').textContent = isBlankMode ? '' : '<?= $isApproved ? '✓' : '' ?>';
            document.getElementById('chkReject').textContent = isBlankMode ? '' : '<?= $isRejected ? '✓' : '' ?>';
            document.getElementById('chkFuelApprove').textContent = isBlankMode ? '' : '<?= $fuelApproved ? '✓' : '' ?>';
            document.getElementById('chkFuelReject').textContent = isBlankMode ? '' : '<?= $fuelRejected ? '✓' : '' ?>';
        }
    </script>
</body>

</html>