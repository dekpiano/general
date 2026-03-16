<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>บันทึกข้อความ</title>
    <style>
        body {
            font-family: 'thsarabun', sans-serif;
            font-size: 16pt;
            line-height: 1.12; /* Approximate for government standard */
            color: #000;
            margin: 0;
            padding: 0;
        }
        .font-bold { font-weight: bold; }
        
        /* 2. Garuda 1.5 cm */
        /* Configured via inline style on img tag directly */
        
        /* 3. "บันทึกข้อความ" 29pt Bold, Exactly 35pt */
        .memo-title {
            text-align: center;
            font-size: 29pt;
            font-weight: bold;
            margin-top: -12mm; /* Negative margin to pull it up to align with absolute Garuda */
            margin-bottom: 5mm;
        }
        
        /* 6,7,8,9. Labels 20pt Bold, Values 16pt Normal */
        .label-20 {
            font-size: 20pt;
            font-weight: bold;
        }
        .value-16 {
            font-size: 16pt;
            font-weight: normal;
        }
        
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            padding: 1px 0;
            vertical-align: bottom;
        }
        
        .line-divider {
            border-bottom: 0.5pt solid #000;
            margin: 2mm 0;
        }
        
        /* 11. Paragraphs with indent 2.5cm and Before 6pt */
        .content-para {
            text-indent: 2.5cm;
            margin-top: 6pt;
            margin-bottom: 0;
            text-align: justify;
        }
        
        /* 10.sGleeting with Before 6pt */
        .greeting {
            margin-top: 6pt;
            margin-bottom: 0;
        }
        
        /* 12. Signature box with 3 line spacing (4 Enter) */
        .signature-area {
            margin-top: 36pt; /* Approx 3-4 lines */
            width: 100%;
        }
        .signature-table {
            width: 100%;
        }
        
        .sig-name {
            text-align: center;
            padding-left: 50%;
        }

        .committee-table {
            width: 100%;
            margin-top: 20px;
        }
        .committee-table td {
            text-align: center;
            vertical-align: top;
            font-size: 14pt;
        }
    </style>
</head>
<body>

    <img src="<?= FCPATH . 'uploads/krut/krut-1.5-cm.png' ?>" width="57" style="position: absolute; top: 0mm; left: -15mm;" alt="ตราครุฑ">
    
    <div class="memo-title">บันทึกข้อความ</div>

    <table class="header-table">
        <tr>
            <td width="55%">
                <span class="label-20">ส่วนราชการ</span>
                <span class="value-16"><?= $memo_data['memo_agency'] ?? '' ?></span>
            </td>
        </tr>
    </table>
    
    <table class="header-table">
        <tr>
            <td width="50%">
                <span class="label-20">ที่</span>
                <span class="value-16"><?= $memo_data['memo_no'] ?: '................................................' ?></span>
            </td>
            <td width="50%">
                <span class="label-20">วันที่</span>
                <span class="value-16"><?= $memo_data['memo_date'] ?? '' ?></span>
            </td>
        </tr>
    </table>

    <table class="header-table">
        <tr>
            <td width="100%">
                <span class="label-20">เรื่อง</span>
                <span class="value-16"><?= $memo_data['memo_subject'] ?? '' ?></span>
            </td>
        </tr>
    </table>

    <div class="line-divider"></div>

    <!-- 10. Greeting -->
    <div class="greeting">
        <span class="label-20">เรียน</span>
        <span class="value-16"><?= $memo_data['memo_to'] ?? '' ?></span>
    </div>

    <!-- 11. Content Sections -->
    <div class="content-para">
        ด้วยงานอาคารสถานที่ กลุ่มบริหารทั่วไป ได้รับแจ้งปัญหา/ความชำรุดเสียหายบริเวณ 
        <span class="font-bold"><?= $memo_data['memo_location'] ?? '................................................' ?></span> 
        เนื่องจาก <span class="font-bold"><?= $memo_data['memo_reason'] ?? '....................................................................................' ?></span>
    </div>

    <div class="content-para">
        ในการนี้ เพื่อให้การจัดเรียนการสอนและกิจกรรมของโรงเรียนดำเนินไปได้ด้วยความเรียบร้อย และป้องกันไม่ให้เกิดความเสียหายมากขึ้น 
        จึงขออนุมัติดำเนินการซ่อมแซมจุดดังกล่าว 
        <?php if(!empty($memo_data['memo_budget'])): ?>
            โดยมีประมาณการค่าใช้จ่ายเบื้องต้นจำนวนทั้งสิ้น <span class="font-bold"><?= $memo_data['memo_budget'] ?></span> บาท
        <?php endif; ?>
    </div>
    
    <div class="content-para">
        จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ
    </div>

    <!-- 12. Signature Section (3 line gap / 4 enter) -->
    <div class="signature-area">
        <table class="signature-table">
            <tr>
                <td width="45%"></td>
                <td width="55%" style="text-align: center;">
                    <p>ลงชื่อ..............................................................</p>
                    <p style="margin-top: 5px;">(<?= !empty($memo_data['memo_fullname']) ? $memo_data['memo_fullname'] : '........................................................' ?>)</p>
                    <p><?= !empty($memo_data['memo_posi']) ? $memo_data['memo_posi'] : 'ตำแหน่ง........................................' ?></p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Administrative Approval Chain -->
    <div style="margin-top: 15mm;">
        <table class="committee-table" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; padding: 5px;">
                    <p class="font-bold" style="text-decoration: underline;">ความเห็นของหัวหน้างานอาคารสถานที่</p>
                    <div style="height: 15mm;"></div>
                    <p>........................................................................</p>
                    <p style="margin-top: 5px;">(ว่าที่ร้อยตรีทัพธนพล พิพัฒน์เดชาวัชญ์)</p>
                    <p>หัวหน้างานอาคารสถานที่และระบบสาธารณูปโภค</p>
                </td>
                <td style="width: 50%; padding: 5px;">
                    <p class="font-bold" style="text-decoration: underline;">ความเห็นของรองผู้อำนวยการ ฝ่ายบริหารทั่วไป</p>
                    <div style="height: 15mm;"></div>
                    <p>........................................................................</p>
                    <p style="margin-top: 5px;">(นางเพ็ญประภา เพตรา)</p>
                    <p>รองผู้อำนวยการโรงเรียน ฝ่ายบริหารทั่วไป</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="signature-area" style="margin-top: 5mm;">
        <table class="signature-table">
            <tr>
                <td width="40%"></td>
                <td width="60%" style="text-align: center;">
                    <p class="font-bold" style="text-decoration: underline;">คำสั่ง / การพิจารณาอนุมัติ</p>
                    <p>[ &nbsp; ] อนุมัติ &nbsp; &nbsp; &nbsp; &nbsp; [ &nbsp; ] ไม่อนุมัติ ......................................</p>
                    <div style="height: 15mm;"></div>
                    <p>ลงชื่อ..............................................................</p>
                    <p style="margin-top: 5px;">(นายอภิรักษ์ อุ่นใจ)</p>
                    <p>ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ)</p>
                </td>
            </tr>
        </table>
    </div>

    <?php if(!empty($img1) || !empty($img2)): ?>
        <pagebreak />
        <div style="text-align: center; font-size: 20pt; font-weight: bold; margin-bottom: 10mm;">รูปภาพประกอบการพิจารณา</div>
        <div style="text-align: center;">
            <?php if(!empty($img1)): ?>
                <div style="margin-bottom: 10mm;">
                    <img src="<?= FCPATH . $img1 ?>" style="max-width: 140mm; max-height: 90mm; border: 1pt solid #000;">
                    <p style="font-size: 16pt; margin-top: 2mm;">ภาพที่ 1: ก่อนการซ่อมแซม</p>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($img2)): ?>
                <div>
                    <img src="<?= FCPATH . $img2 ?>" style="max-width: 140mm; max-height: 90mm; border: 1pt solid #000;">
                    <p style="font-size: 16pt; margin-top: 2mm;">ภาพที่ 2: ก่อนการซ่อมแซม</p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</body>
</html>
