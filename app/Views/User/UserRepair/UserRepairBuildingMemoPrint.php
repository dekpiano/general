<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกข้อความ - ขออนุมัติซ่อมแซมอาคารสถานที่</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />

    <!-- Google Fonts: Sarabun Fallback -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <style>
        /* -----------------------------------------------------------------
           FONT FACES: TH Sarabun PSK & TH Sarabun New (มาตรฐานงานสารบรรณภาครัฐ)
           ----------------------------------------------------------------- */
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
        @font-face {
            font-family: 'TH Sarabun PSK';
            src: local('TH Sarabun PSK Bold'), local('THSarabunPSK-Bold');
            font-weight: bold;
            font-style: normal;
        }

        @page {
            size: A4 portrait;
            margin: 25mm 20mm 20mm 25mm; /* บน 2.5 ซม. / ซ้าย 2.5 ซม. / ขวา 2.0 ซม. / ล่าง 2.0 ซม. */
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'TH Sarabun New', 'TH Sarabun PSK', 'Sarabun', sans-serif;
            font-size: 16pt;
            line-height: 1.25;
            color: #000000;
            background: #475569;
            margin: 0;
            padding: 20px 0;
        }

        /* Screen Toolbar */
        .print-screen-bar {
            max-width: 210mm;
            margin: 0 auto 15px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #1e293b;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.25);
            font-family: 'Sarabun', sans-serif;
        }

        .btn-print-action {
            background: #696cff;
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-print-action:hover {
            background: #5659e6;
        }

        .btn-close-action {
            background: rgba(255,255,255,0.15);
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13.5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-close-action:hover {
            background: rgba(255,255,255,0.25);
            color: #ffffff;
        }

        /* A4 Page Container (Screen Preview) */
        .a4-document-page {
            background: #ffffff;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 25mm 20mm 20mm 25mm; /* สัดส่วนขอบตรงตามมาตรฐานราชการ */
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            box-sizing: border-box;
        }

        /* Header Layout: Garuda Top-Left, Title Center */
        .memo-top-header {
            position: relative;
            min-height: 15mm;
            margin-bottom: 5mm;
        }

        /* ตราครุฑ 1.5 ซม. ด้านซ้าย (ตรงกับระดับคำว่า บันทึกข้อความ) */
        .garuda-logo {
            width: 15mm;
            height: 15mm;
            position: absolute;
            top: 0;
            left: 0;
            object-fit: contain;
        }

        /* "บันทึกข้อความ" 29pt หนา ตรงกึ่งกลาง */
        .memo-main-title {
            text-align: center;
            font-size: 29pt;
            font-weight: bold;
            line-height: 1.1;
            margin: 0;
            letter-spacing: 0.5px;
        }

        /* ตารางหัวหนังสือ: ส่วนราชการ, ที่, วันที่, เรื่อง */
        .memo-header-tbl {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5mm;
        }

        .memo-header-tbl td {
            vertical-align: bottom;
            padding: 1px 0;
            line-height: 1.2;
        }

        /* หัวข้อ 20pt หนา */
        .lbl-bold-20 {
            font-size: 20pt;
            font-weight: bold;
            display: inline-block;
        }

        /* ข้อความต่อท้าย 16pt ปกติ */
        .val-norm-16 {
            font-size: 16pt;
            font-weight: normal;
            display: inline;
        }

        /* เส้นคั่นเดี่ยวทึบ หนา 1.5pt ใต้เรื่อง */
        .memo-solid-divider {
            border-bottom: 1.5pt solid #000000;
            margin: 3mm 0 3.5mm 0;
        }

        /* คำว่า "เรียน" */
        .memo-greeting {
            margin-top: 1mm;
            margin-bottom: 4mm;
            line-height: 1.2;
        }

        /* เนื้อหา 3 ย่อหน้ามาตรฐาน: Indent 2.5 ซม., 16pt ปกติ, Justify, ระยะห่างบรรทัด 1.25 */
        .memo-content-para {
            text-indent: 2.5cm;
            margin-top: 4.5mm;
            margin-bottom: 0;
            text-align: justify;
            text-justify: inter-cluster;
            line-height: 1.28;
            font-size: 16pt;
            font-weight: normal;
        }

        /* ส่วนลงนามผู้ขอ (ชิดขวา เริ่มจากกึ่งกลางหน้ากระดาษ) */
        .memo-sig-container {
            margin-top: 14mm;
            width: 100%;
        }

        .memo-sig-tbl {
            width: 100%;
            border-collapse: collapse;
        }

        .memo-sig-cell {
            text-align: center;
            line-height: 1.25;
        }

        .sig-line {
            margin: 0 0 4px 0;
            font-size: 16pt;
        }

        /* Images Attachment Page */
        .attachment-page {
            background: #ffffff;
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto 0 auto;
            padding: 25mm 20mm 20mm 25mm;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            page-break-before: always !important;
            break-before: page !important;
            box-sizing: border-box;
        }

        .attach-title {
            text-align: center;
            font-size: 20pt;
            font-weight: bold;
            margin-bottom: 10mm;
            text-decoration: underline;
        }

        .attach-img-box {
            text-align: center;
            margin-bottom: 10mm;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .attach-img {
            max-width: 150mm;
            max-height: 95mm;
            border: 1pt solid #000000;
            border-radius: 4px;
            object-fit: contain;
        }

        /* -------------------------------------------------------------
           PRINT MODE OVERRIDE (เบราว์เซอร์ตัดขอบกระดาษตาม @page อัตโนมัติ)
           ------------------------------------------------------------- */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .a4-document-page {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                min-height: auto !important;
            }
            .attachment-page {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                min-height: auto !important;
                page-break-before: always !important;
                break-before: page !important;
            }
        }
    </style>
</head>
<body>

    <!-- On-screen Control Bar (Hidden when printing) -->
    <div class="print-screen-bar no-print">
        <div>
            <strong style="font-size: 15px;">📄 พิมพ์บันทึกข้อความราชการ</strong>
            <span style="opacity: 0.75; font-size: 13px; margin-left: 8px;">(ระเบียบสำนักนายกรัฐมนตรีว่าด้วยงานสารบรรณ)</span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button class="btn-print-action" onclick="window.print();">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
                สั่งพิมพ์ (Print)
            </button>
            <button class="btn-close-action" onclick="window.close();">ปิดหน้านี้</button>
        </div>
    </div>

    <!-- Official A4 Document Page -->
    <div class="a4-document-page">
        
        <!-- Header: ครุฑ 1.5 ซม. ด้านซ้าย + บันทึกข้อความ 29pt ตรงกลาง -->
        <div class="memo-top-header">
            <img src="<?= base_url('uploads/krut/krut-1.5-cm.png') ?>" alt="ตราครุฑ" class="garuda-logo">
            <div class="memo-main-title">บันทึกข้อความ</div>
        </div>

        <!-- ส่วนหัว: ส่วนราชการ -->
        <table class="memo-header-tbl">
            <tr>
                <td width="100%">
                    <span class="lbl-bold-20">ส่วนราชการ</span>
                    <span class="val-norm-16" style="margin-left: 8px;"><?= esc($memo_data['memo_agency'] ?? 'กลุ่มบริหารทั่วไป งานอาคารสถานที่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ โทร. ๐-๕๖๐๐-๙๖๖๗') ?></span>
                </td>
            </tr>
        </table>

        <!-- ที่ และ วันที่ (วันที่เริ่มที่กึ่งกลางหน้ากระดาษ) -->
        <table class="memo-header-tbl">
            <tr>
                <td width="50%">
                    <span class="lbl-bold-20">ที่</span>
                    <span class="val-norm-16" style="margin-left: 8px;"><?= !empty($memo_data['memo_no']) ? esc($memo_data['memo_no']) : '....................................................................' ?></span>
                </td>
                <td width="50%">
                    <span class="lbl-bold-20">วันที่</span>
                    <span class="val-norm-16" style="margin-left: 8px;"><?= esc($memo_data['memo_date'] ?? '') ?></span>
                </td>
            </tr>
        </table>

        <!-- เรื่อง -->
        <table class="memo-header-tbl">
            <tr>
                <td width="100%">
                    <span class="lbl-bold-20">เรื่อง</span>
                    <span class="val-norm-16" style="margin-left: 8px;"><?= esc($memo_data['memo_subject'] ?? 'ขออนุมัติซ่อมแซมอาคารสถานที่') ?></span>
                </td>
            </tr>
        </table>

        <!-- เส้นคั่นเดี่ยวทึบ -->
        <div class="memo-solid-divider"></div>

        <!-- เรียน -->
        <div class="memo-greeting">
            <span class="lbl-bold-20">เรียน</span>
            <span class="val-norm-16" style="margin-left: 8px;"><?= esc($memo_data['memo_to'] ?? 'ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์') ?></span>
        </div>

        <!-- เนื้อหา 3 ย่อหน้ามาตรฐานราชการ -->
        <!-- ย่อหน้า 1: ต้นเรื่อง -->
        <div class="memo-content-para">
            ด้วย งานอาคารสถานที่ กลุ่มบริหารทั่วไป ได้รับแจ้งปัญหาความชำรุดเสียหายบริเวณ 
            <?= esc($memo_data['memo_location'] ?? '........................................................................................') ?> 
            เนื่องจาก <?= esc($memo_data['memo_reason'] ?? '..........................................................................................................................................') ?>
        </div>

        <!-- ย่อหน้า 2: เหตุผลความจำเป็น & ข้อเสนอ -->
        <div class="memo-content-para">
            ในการนี้ เพื่อให้การปฏิบัติงานและการจัดกิจกรรมการเรียนการสอนดำเนินไปด้วยความเรียบร้อย มีความปลอดภัยในชีวิตและทรัพย์สินของทางราชการ และป้องกันมิให้เกิดความชำรุดเสียหายเพิ่มมากขึ้น งานอาคารสถานที่จึงเห็นควรดำเนินการซ่อมแซมจุดดังกล่าว 
            <?php if(!empty($memo_data['memo_budget'])): ?>
                โดยมีประมาณการค่าใช้จ่ายเบื้องต้นจำนวนทั้งสิ้น <?= esc($memo_data['memo_budget']) ?> บาท
            <?php endif; ?>
        </div>
        
        <!-- ย่อหน้า 3: ความประสงค์ / สรุป -->
        <div class="memo-content-para">
            จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ และมอบหมายเจ้าหน้าที่ผู้เกี่ยวข้องดำเนินการต่อไป
        </div>

        <!-- ส่วนลงนามผู้ขอ (ชิดขวา เริ่มจากกึ่งกลางหน้ากระดาษ) -->
        <div class="memo-sig-container">
            <table class="memo-sig-tbl">
                <tr>
                    <td width="45%"></td>
                    <td width="55%" class="memo-sig-cell">
                        <p class="sig-line">ลงชื่อ..............................................................</p>
                        <?php 
                            $fullname = !empty($memo_data['memo_fullname']) ? trim($memo_data['memo_fullname']) : '........................................................';
                            
                            $posi = '';
                            if (!empty($memo_data['memo_posi'])) {
                                $p = trim($memo_data['memo_posi']);
                                $posi = (mb_strpos($p, 'ตำแหน่ง') === 0) ? $p : ('ตำแหน่ง ' . $p);
                            } else {
                                $posi = 'ตำแหน่ง........................................................';
                            }
                        ?>
                        <p class="sig-line">(<?= esc($fullname) ?>)</p>
                        <p class="sig-line"><?= esc($posi) ?></p>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    <!-- Page 2+: Attached Images Page (แยกขึ้นหน้าใหม่เสมอเมื่อมีรูปภาพแนบ) -->
    <?php if(!empty($memo_data['images']) && count($memo_data['images']) > 0): ?>
        <div class="page-break" style="page-break-before: always; break-before: page; height: 0; margin: 0; padding: 0;"></div>
        <div class="attachment-page">
            <div class="attach-title">รูปภาพประกอบการพิจารณาซ่อมแซมอาคารสถานที่</div>
            <?php if(!empty($memo_data['memo_subject'])): ?>
                <p style="text-align: center; font-size: 15pt; margin: -6mm 0 8mm 0; color: #333333;">
                    (เอกสารแนบท้าย เรื่อง <?= esc($memo_data['memo_subject']) ?>)
                </p>
            <?php endif; ?>

            <?php foreach($memo_data['images'] as $idx => $imgUrl): ?>
                <div class="attach-img-box">
                    <img src="<?= esc($imgUrl) ?>" alt="รูปภาพประกอบ <?= $idx + 1 ?>" class="attach-img">
                    <p style="font-size: 16pt; margin: 6px 0 0 0; font-weight: bold;">ภาพที่ <?= $idx + 1 ?>: สภาพความชำรุดเสียหาย ณ จุดเกิดเหตุ</p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</body>
</html>
