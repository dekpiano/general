<?php
    $items = $borrow['items'] ?? [];
    $itemCount = count($items);

    // คำนวณสเกลขนาดตัวอักษรและระยะช่องไฟอัตโนมัติตามจำนวนรายการอุปกรณ์ เพื่อไม่ให้เกิน 1 หน้ากระดาษ A4
    if ($itemCount <= 4) {
        $bodyFontSize     = '16pt';
        $docTitleSize     = '18pt';
        $tableFontSize    = '15pt';
        $opinionFontSize  = '14pt';
        $lineHeight       = '1.25';
        $tableCellPadding = '3px 6px';
        $opinionHeight1   = '75px';
        $opinionHeight2   = '78px';
        $pageMargin       = '2.0cm 2.0cm 1.5cm 2.5cm';
    } elseif ($itemCount <= 7) {
        $bodyFontSize     = '14.5pt';
        $docTitleSize     = '17pt';
        $tableFontSize    = '13.5pt';
        $opinionFontSize  = '13pt';
        $lineHeight       = '1.2';
        $tableCellPadding = '2.5px 5px';
        $opinionHeight1   = '65px';
        $opinionHeight2   = '68px';
        $pageMargin       = '1.5cm 2.0cm 1.2cm 2.2cm';
    } elseif ($itemCount <= 11) {
        $bodyFontSize     = '13pt';
        $docTitleSize     = '15.5pt';
        $tableFontSize    = '12pt';
        $opinionFontSize  = '11.5pt';
        $lineHeight       = '1.18';
        $tableCellPadding = '2px 4px';
        $opinionHeight1   = '55px';
        $opinionHeight2   = '58px';
        $pageMargin       = '1.2cm 1.8cm 1.0cm 2.0cm';
    } else {
        $bodyFontSize     = '11.5pt';
        $docTitleSize     = '14pt';
        $tableFontSize    = '11pt';
        $opinionFontSize  = '10.5pt';
        $lineHeight       = '1.12';
        $tableCellPadding = '1.5px 3px';
        $opinionHeight1   = '45px';
        $opinionHeight2   = '48px';
        $pageMargin       = '1.0cm 1.5cm 0.8cm 1.8cm';
    }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แบบขอยืมพัสดุอุปกรณ์ - <?= esc($borrow['borrow_code']) ?></title>
    <!-- TH Sarabun Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
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

        /* มาตรฐานกระดาษและการตั้งค่าหน้ากระดาษราชการ (ปรับระยะตามจำนวนข้อมูลอัตโนมัติ) */
        @page {
            size: A4 portrait;
            margin: <?= $pageMargin ?>;
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'TH Sarabun New', 'TH Sarabun PSK', 'Sarabun', sans-serif;
            font-size: <?= $bodyFontSize ?>;
            line-height: <?= $lineHeight ?>;
            color: #000;
            background: #eef2f6;
            margin: 0;
            padding: 15px 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* จำลองกระดาษ A4 บนหน้าจอ */
        .page-container {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm 15mm 22mm;
            margin: 0 auto 30px auto;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            position: relative;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .fw-bold { font-weight: bold; }
        
        /* หัวเอกสารแบบราชการ */
        .doc-title {
            font-size: <?= $docTitleSize ?>;
            font-weight: bold;
            text-align: center;
            margin-bottom: 6px;
        }
        
        /* สถานที่เขียนและวันที่จัดเยื้องขวา */
        .write-place {
            text-align: right;
            margin-bottom: 2px;
            font-size: <?= $bodyFontSize ?>;
        }
        .write-date {
            text-align: right;
            margin-bottom: 6px;
            font-size: <?= $bodyFontSize ?>;
        }
        
        /* ข้อความและย่อหน้ามาตรฐาน 2.5 ซม. */
        .content-line {
            margin-bottom: 3px;
            line-height: <?= $lineHeight ?>;
            text-align: justify;
        }
        
        .indent-gov {
            text-indent: 2.5cm;
        }
        
        .val-text {
            font-weight: bold;
            color: #000;
            padding: 0 2px;
        }

        /* ตารางรายการอุปกรณ์ตามแบบราชการ */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0 6px 0;
            font-size: <?= $tableFontSize ?>;
        }

        .items-table th, .items-table td {
            border: 1px solid #000;
            padding: <?= $tableCellPadding ?>;
            vertical-align: middle;
        }

        .items-table th {
            font-weight: bold;
            text-align: center;
            background-color: #fafafa;
        }

        /* ตารางความเห็น */
        .opinion-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: <?= $opinionFontSize ?>;
        }

        .opinion-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        /* ส่วนลายมือชื่อ จัดตำแหน่งด้านขวา */
        .sign-area {
            text-align: center;
            margin: 4px 0 4px auto;
            width: 320px;
            line-height: <?= $lineHeight ?>;
            font-size: <?= $bodyFontSize ?>;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: #ffffff;
                padding: 0;
                font-size: <?= $bodyFontSize ?>;
            }
            .page-container {
                width: 100%;
                min-height: auto;
                padding: 0;
                margin: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

    <!-- แถบปุ่มควบคุมก่อนพิมพ์ -->
    <div class="no-print" style="max-width: 210mm; margin: 0 auto 15px auto; display: flex; justify-content: space-between; align-items: center; background: #ffffff; padding: 12px 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        <div style="font-size: 16px; font-weight: bold; color: #333;">
            📄 ตัวอย่างแบบฟอร์มขอยืมพัสดุอุปกรณ์ (ขนาดกระดาษ A4 มาตรฐานราชการ)
        </div>
        <div>
            <button onclick="window.print()" style="padding: 8px 24px; font-size: 15px; font-weight: bold; cursor: pointer; background: #1e40af; color: white; border: none; border-radius: 6px; box-shadow: 0 2px 6px rgba(30,64,175,0.3); margin-right: 8px;">
                🖨️ พิมพ์เอกสาร
            </button>
            <button onclick="window.close()" style="padding: 8px 16px; font-size: 15px; cursor: pointer; background: #64748b; color: white; border: none; border-radius: 6px;">
                ปิดหน้าต่าง
            </button>
        </div>
    </div>

    <div class="page-container">
        <?php
            $createdTime = strtotime($borrow['created_at']);
            $dayThai   = date('j', $createdTime);
            $monthArr  = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
            $monthThai = $monthArr[(int)date('n', $createdTime)];
            $yearThai  = date('Y', $createdTime) + 543;
        ?>

        <!-- หัวเอกสาร -->
        <div class="doc-title">แบบขอยืมพัสดุอุปกรณ์</div>
        <div class="write-place">เขียนที่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</div>
        <div class="write-date">
            วันที่ <span class="val-text"><?= $dayThai ?></span> เดือน <span class="val-text"><?= $monthThai ?></span> พ.ศ. <span class="val-text"><?= $yearThai ?></span>
        </div>

        <!-- เรียน -->
        <div class="content-line">
            <span class="fw-bold">เรียน</span> ผู้อำนวยการสถานศึกษา โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
        </div>

        <!-- ข้อมูลผู้ขอ (ย่อหน้า 2.5 ซม.) -->
        <?php if (($borrow['borrower_type'] ?? '') === 'external'): ?>
            <div class="content-line indent-gov">
                ข้าพเจ้า <span class="val-text"><?= esc($borrow['borrower_name']) ?></span> 
                หน่วยงาน/องค์กรภายนอก <span class="val-text"><?= esc($borrow['borrower_org']) ?></span>
            </div>
            <div class="content-line">
                โทรศัพท์ที่สามารถติดต่อได้ <span class="val-text"><?= esc($borrow['borrower_tel']) ?></span>
            </div>
        <?php else: ?>
            <div class="content-line indent-gov">
                ข้าพเจ้า <span class="val-text"><?= esc($borrow['borrower_name']) ?></span> 
                ตำแหน่ง <span class="val-text"><?= esc($borrowerPosition ?: 'ครู/บุคลากร') ?></span>
            </div>
            <div class="content-line">
                ฝ่าย/กลุ่มงาน/กลุ่มสาระการเรียนรู้ <span class="val-text"><?= esc($borrow['borrower_org']) ?></span> 
                โทรศัพท์ที่สามารถติดต่อได้ <span class="val-text"><?= esc($borrow['borrower_tel']) ?></span>
            </div>
        <?php endif; ?>

        <div class="content-line">
            มีความประสงค์ขอใช้อุปกรณ์ดังต่อไปนี้
        </div>

        <!-- ตารางรายการพัสดุอุปกรณ์ -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 10%;">ลำดับ</th>
                    <th style="width: 60%;">รายการอุปกรณ์</th>
                    <th style="width: 15%;">จำนวน</th>
                    <th style="width: 15%;">หน่วยนับ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalRows = max(3, $itemCount);
                    for ($idx = 0; $idx < $totalRows; $idx++): 
                        $item = $items[$idx] ?? null;
                ?>
                    <tr>
                        <td class="text-center"><?= $idx + 1 ?></td>
                        <td>
                            <?php if ($item): ?>
                                <span class="fw-bold"><?= esc($item['display_name'] ?? ($item['item_name'] ?? ($item['eq_name'] ?? ''))) ?></span>
                            <?php else: ?>
                                &nbsp;
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?= $item ? esc($item['qty']) : '&nbsp;' ?>
                        </td>
                        <td class="text-center">
                            <?= $item ? esc($item['display_unit'] ?? ($item['item_unit'] ?? ($item['eq_unit'] ?? 'ชิ้น'))) : '&nbsp;' ?>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <!-- เพื่อใช้งาน / สถานที่ (ย่อหน้า 2.5 ซม.) -->
        <div class="content-line indent-gov">
            เพื่อใช้งาน <span class="val-text"><?= esc($borrow['purpose']) ?></span>
            <?php 
                $isValidDate = function($d) {
                    return !empty($d) && $d !== '0000-00-00' && $d !== '0000-00-00 00:00:00';
                };
                if ($isValidDate($borrow['borrow_date'])):
                    $bDateStr = isset($Datethai) ? $Datethai->thai_date_fullmonth(strtotime($borrow['borrow_date'])) : '';
                    $dDateStr = $isValidDate($borrow['due_date']) && isset($Datethai) ? $Datethai->thai_date_fullmonth(strtotime($borrow['due_date'])) : '';
            ?>
                (ระหว่างวันที่ <?= $bDateStr ?> ถึงวันที่ <?= $dDateStr ?>)
            <?php endif; ?>
        </div>

        <div class="content-line">
            สถานที่นำไปใช้ <span class="val-text"><?= esc($borrow['location'] ?: 'ภายในโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์') ?></span>
        </div>

        <div class="content-line indent-gov">
            โดยข้าพเจ้ายินดีจะปฏิบัติตามระเบียบการใช้พัสดุอุปกรณ์พร้อมทั้งจะรับผิดชอบต่อความเสียหายทั้งหมดระหว่างการปฏิบัติงาน และดูแลรักษาให้อยู่ในสภาพเรียบร้อยทุกประการ
        </div>

        <!-- ลายเซ็นผู้ยื่นคำขอยืม จัดตำแหน่งขวาตามแบบราชการ -->
        <div class="sign-area">
            (ลงชื่อ)............................................................ผู้ยื่นคำขอยืม<br>
            ( <span class="val-text"><?= esc($borrow['borrower_name']) ?></span> )<br>
            <?php if (($borrow['borrower_type'] ?? '') === 'external'): ?>
                <span class="val-text"><?= esc($borrow['borrower_org']) ?></span>
            <?php else: ?>
                ตำแหน่ง <span class="val-text"><?= esc($borrowerPosition ?: 'ครู/บุคลากร') ?></span>
            <?php endif; ?>
        </div>

        <!-- กล่องความเห็น 3 ฝ่าย -->
        <table class="opinion-table">
            <tr>
                <td width="50%" style="height: <?= $opinionHeight1 ?>;">
                    <div class="fw-bold">ข้อคิดเห็นของหัวหน้างานอาคารสถานที่และสิ่งแวดล้อม</div>
                    <div style="color: #666; font-size: 13pt; line-height: 1.2;">
                        ...........................................................................................
                    </div>
                    <div class="text-center" style="margin-top: 4px;">
                        (ลงชื่อ)............................................................<br>
                        ( <span class="val-text"><?= $HeadBuildings ? esc($HeadBuildings->pers_prefix . $HeadBuildings->pers_firstname . ' ' . $HeadBuildings->pers_lastname) : '............................................................' ?></span> )<br>
                        วันที่......./......./.......
                    </div>
                </td>
                <td width="50%">
                    <div class="fw-bold">ข้อคิดเห็นของรองผู้อำนวยการบริหารงานทั่วไป</div>
                    <div style="color: #666; font-size: 13pt; line-height: 1.2;">
                        ...........................................................................................
                    </div>
                    <div class="text-center" style="margin-top: 4px;">
                        (ลงชื่อ)............................................................<br>
                        ( <span class="val-text"><?= $DeputyExecutive ? esc($DeputyExecutive->pers_prefix . $DeputyExecutive->pers_firstname . ' ' . $DeputyExecutive->pers_lastname) : '............................................................' ?></span> )<br>
                        วันที่......./......./.......
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="height: <?= $opinionHeight2 ?>;">
                    <div class="fw-bold">ข้อคิดเห็นของผู้อำนวยการสถานศึกษา / ผู้ได้รับมอบหมาย</div>
                    <div style="color: #666; font-size: 13pt; line-height: 1.2;">
                        ...............................................................................................................................................................................
                    </div>
                    <div class="text-center" style="margin-top: 4px;">
                        (ลงชื่อ)............................................................<br>
                        ( <span class="val-text"><?= $Director ? esc($Director->pers_prefix . $Director->pers_firstname . ' ' . $Director->pers_lastname) : '............................................................' ?></span> )<br>
                        วันที่......./......./.......
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
