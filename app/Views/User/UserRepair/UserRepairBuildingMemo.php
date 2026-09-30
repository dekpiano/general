<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<!-- Google Fonts: Sarabun & TH Sarabun PSK style -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sarabun:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
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
    @font-face {
        font-family: 'TH Sarabun PSK';
        src: local('TH Sarabun PSK Bold'), local('THSarabunPSK-Bold');
        font-weight: bold;
        font-style: normal;
    }

    :root {
        --memo-primary: #696cff;
        --memo-primary-dark: #4345bb;
        --thai-sarabun: 'TH Sarabun New', 'TH Sarabun PSK', 'Sarabun', sans-serif;
    }

    .memo-container {
        padding-top: 1.25rem;
        padding-bottom: 4rem;
    }

    /* Page Header */
    .memo-header {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 1.35rem;
        padding: 2rem 2.25rem;
        margin-bottom: 2rem;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.08);
        position: relative;
        overflow: hidden;
    }

    .memo-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(105, 108, 255, 0.25) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* Form Cards */
    .form-glass-card {
        background: #ffffff;
        border: 1px solid rgba(67, 89, 113, 0.12);
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .form-glass-card:hover {
        border-color: rgba(105, 108, 255, 0.3);
        box-shadow: 0 8px 25px rgba(105, 108, 255, 0.08);
    }

    .card-title-premium {
        background: #f8f9fc;
        padding: 1rem 1.4rem;
        border-bottom: 1px solid #edf0f5;
        color: #32475c;
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-body-premium {
        padding: 1.5rem 1.4rem;
    }

    .btn-submit-premium {
        background: linear-gradient(135deg, #696cff 0%, #4345bb 100%);
        border: none;
        color: white;
        padding: 0.9rem 1.5rem;
        border-radius: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 8px 20px rgba(105, 108, 255, 0.3);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-submit-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(105, 108, 255, 0.4);
        color: white;
    }

    /* Select2 Sneat Styling */
    .select2-container--default .select2-selection--single {
        border: 1px solid #d9dee3 !important;
        border-radius: 0.5rem !important;
        height: calc(1.53em + 0.875rem + 2px) !important;
        padding: 0.4375rem 0.875rem !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #435971 !important;
        padding-left: 0 !important;
        line-height: normal !important;
        font-size: 0.9375rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        right: 8px !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #696cff !important;
        box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.15) !important;
    }

    /* -------------------------------------------------------------
       A4 OFFICIAL THAI GOVERNMENT MEMORANDUM PREVIEW (ระเบียบงานสารบรรณ)
       ------------------------------------------------------------- */
    .a4-preview-container {
        background-color: #334155;
        background-image: radial-gradient(#475569 1px, transparent 1px);
        background-size: 16px 16px;
        padding: 1.5rem 1rem;
        border-radius: 1.35rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-x: auto;
        overflow-y: auto;
        max-height: 1200px;
        box-shadow: inset 0 2px 10px rgba(0,0,0,0.3);
    }

    .a4-preview-viewport {
        display: flex;
        justify-content: center;
        width: 100%;
        overflow: hidden;
    }

    .a4-page {
        background: #ffffff;
        width: 210mm;
        min-height: 297mm;
        padding: 25mm 20mm 20mm 25mm; /* Official standard: Left 2.5cm, Top 2.5cm, Right 2.0cm, Bottom 2.0cm */
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        color: #000000;
        font-family: var(--thai-sarabun);
        font-size: 16pt;
        line-height: 1.25;
        position: relative;
        box-sizing: border-box;
        transform: scale(0.55);
        transform-origin: top center;
        margin-bottom: -130mm; /* Compensate for scaled down height */
        transition: transform 0.25s ease, margin-bottom 0.25s ease;
    }

    @media (max-width: 1400px) {
        .a4-page {
            transform: scale(0.50);
            margin-bottom: -145mm;
        }
    }

    @media (max-width: 1200px) {
        .a4-page {
            transform: scale(0.45);
            margin-bottom: -160mm;
        }
    }

    @media (max-width: 991px) {
        .a4-page {
            transform: scale(0.40);
            margin-bottom: -175mm;
        }
    }

    /* Official Garuda Emblem (Top Left) */
    .a4-garuda {
        width: 15mm;
        position: absolute;
        top: 20mm;
        left: 25mm;
    }

    /* "บันทึกข้อความ" Title 29pt Bold */
    .a4-memo-title {
        text-align: center;
        font-size: 29pt;
        font-weight: 800;
        line-height: 1.1;
        margin-top: 0;
        margin-bottom: 5mm;
        letter-spacing: 0.5px;
    }

    /* Header Table Fields: Labels 20pt Bold, Values 16pt Normal */
    .a4-header-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2mm;
    }

    .a4-header-table td {
        vertical-align: bottom;
        padding: 1px 0;
        line-height: 1.2;
    }

    .a4-lbl-20 {
        font-size: 20pt;
        font-weight: 700;
        color: #000000;
        display: inline-block;
    }

    .a4-val-16 {
        font-size: 16pt;
        font-weight: 400;
        color: #000000;
        display: inline;
        word-break: break-word;
    }

    /* Value highlight in preview */
    .a4-val-highlight {
        color: #000000;
        background-color: rgba(105, 108, 255, 0.06);
        padding: 0 4px;
        border-radius: 3px;
    }

    /* Official Solid Divider Line */
    .a4-solid-divider {
        border-bottom: 1.5pt solid #000000;
        margin: 2.5mm 0 4mm 0;
    }

    /* Greeting: "เรียน" 20pt Bold */
    .a4-greeting {
        margin-top: 2mm;
        margin-bottom: 3mm;
    }

    /* Content Paragraphs: Indent 2.5cm, Justified */
    .a4-paragraph {
        text-indent: 2.5cm;
        margin-top: 3.5mm;
        margin-bottom: 0;
        text-align: justify;
        text-justify: inter-cluster;
        line-height: 1.35;
        font-size: 16pt;
    }

    /* Submitter Signature Block */
    .a4-signature-block {
        margin-top: 9mm;
        width: 100%;
    }

    .a4-sig-table {
        width: 100%;
        border-collapse: collapse;
    }

    .a4-sig-cell {
        text-align: center;
        line-height: 1.3;
    }

    /* Official Endorsements & Approval Routing Table (3 Layers) */
    .a4-routing-box {
        margin-top: 8mm;
        border: 1pt solid #000000;
        border-collapse: collapse;
        width: 100%;
        font-size: 14pt;
    }

    .a4-routing-box td {
        border: 1pt solid #000000;
        vertical-align: top;
        padding: 3mm 4mm;
        line-height: 1.25;
    }

    .a4-routing-title {
        font-weight: 700;
        font-size: 14pt;
        text-decoration: underline;
        margin-bottom: 2mm;
        text-align: center;
    }

    .a4-checkbox {
        display: inline-block;
        width: 13px;
        height: 13px;
        border: 1pt solid #000000;
        margin-right: 4px;
        vertical-align: middle;
    }

    @media (max-width: 1200px) {
        .a4-page {
            transform: scale(0.85);
            transform-origin: top center;
        }
    }
    @media (max-width: 991px) {
        .a4-page {
            transform: scale(0.68);
            transform-origin: top center;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 memo-container">
    
    <!-- Top Header -->
    <div class="memo-header">
        <div style="position: relative; z-index: 2;">
            <div class="d-flex align-items-center mb-2">
                <i class="bx bxs-file-blank fs-3 me-2 text-warning"></i>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url()?>" class="text-white-50">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="<?=base_url('Repair')?>" class="text-white-50">แจ้งซ่อมออนไลน์</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">บันทึกข้อความอาคารสถานที่</li>
                    </ol>
                </nav>
            </div>
            <h2 class="mb-1 text-white fw-bold">สร้างบันทึกข้อความราชการ (งานอาคารสถานที่)</h2>
            <p class="mb-0 text-white-50">กรอกข้อมูลเพื่อสร้างแบบฟอร์มบันทึกข้อความขออนุมัติซ่อมแซมตามระเบียบงานสารบรรณ พร้อมพิมพ์เป็นเอกสารราชการ</p>
        </div>
        <div style="position: relative; z-index: 2;" class="d-flex gap-2 align-items-center">
            <a href="<?= base_url('Repair') ?>" class="btn btn-outline-light rounded-pill px-3">
                <i class="bx bx-arrow-back me-1"></i> ย้อนกลับ
            </a>
            <button type="button" class="btn btn-warning rounded-pill px-3 fw-bold" onclick="document.getElementById('memoMainForm').submit();">
                <i class="bx bx-printer me-1"></i> สั่งพิมพ์ PDF ทันที
            </button>
        </div>
    </div>

    <form id="memoMainForm" action="<?= base_url('Repair/BuildingMemo/Print') ?>" method="post" enctype="multipart/form-data" target="_blank">
        <input type="hidden" name="repair_order" value="<?= esc($repair_order ?? '') ?>">
        <input type="hidden" name="memo_posi_name" id="hidden_posi_name" value="">

        <div class="row g-4">
            
            <!-- Left Column: Modern Form Controls -->
            <div class="col-xl-5 col-lg-5">
                
                <!-- Card 1: ข้อมูลหัวหนังสือราชการ -->
                <div class="form-glass-card">
                    <div class="card-title-premium">
                        <span><i class="bx bx-file-find me-2 text-primary"></i> 1. ข้อมูลหัวหนังสือราชการ</span>
                        <span class="badge bg-label-primary rounded-pill">ส่วนราชการ</span>
                    </div>
                    <div class="card-body-premium">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">ส่วนราชการ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="memo_agency" id="input_agency" 
                                       value="<?= $memo_data_db['memo_agency'] ?? 'กลุ่มบริหารทั่วไป งานอาคารสถานที่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ โทร. ๐-๕๖๐๐-๙๖๖๗' ?>" required>
                                <small class="text-muted">ชื่อกลุ่มงาน/งาน และหน่วยงานผู้เสนอ</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">ที่ (เลขที่หนังสือออก)</label>
                                <input type="text" class="form-control" name="memo_no" id="input_no" 
                                       value="<?= $memo_data_db['memo_no'] ?? '' ?>" placeholder="เช่น ศธ ๐๔๓๒๘/...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">วันที่ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="memo_date" id="input_date" 
                                       value="<?= $memo_data_db['memo_date'] ?? $Datethai->thai_date_fullmonth(strtotime(date('Y-m-d'))) ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">เรื่อง <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="memo_subject" id="input_subject" 
                                       value="<?= $memo_data_db['memo_subject'] ?? 'ขออนุมัติซ่อมแซมอาคารสถานที่' ?>" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">เรียน (ผู้รับหนังสือ) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="memo_to" id="input_to" 
                                       value="<?= $memo_data_db['memo_to'] ?? 'ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์' ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: สาระสำคัญและข้อเท็จจริงการแจ้งซ่อม -->
                <div class="form-glass-card">
                    <div class="card-title-premium">
                        <span><i class="bx bx-wrench me-2 text-warning"></i> 2. สาระสำคัญ & จุดที่ต้องซ่อม</span>
                        <span class="badge bg-label-warning rounded-pill">รายละเอียด</span>
                    </div>
                    <div class="card-body-premium">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">สถานที่ / บริเวณที่ชำรุดเสียหาย <span class="text-danger">*</span></label>
                                <?php 
                                    $default_loc = '';
                                    if(isset($repair_info)) {
                                        $locArr = array_filter([$repair_info['repair_building'] ?? '', !empty($repair_info['repair_class']) ? 'ชั้น '.$repair_info['repair_class'] : '', !empty($repair_info['repair_room']) ? 'ห้อง '.$repair_info['repair_room'] : '']);
                                        $default_loc = implode(' ', $locArr);
                                    }
                                ?>
                                <input type="text" class="form-control" name="memo_location" id="input_location" 
                                       value="<?= $memo_data_db['memo_location'] ?? $default_loc ?>" 
                                       placeholder="เช่น บริเวณห้องน้ำหญิง อาคาร 1 ชั้น 2" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">สาเหตุความเสียหาย / ความจำเป็นที่ต้องซ่อม <span class="text-danger">*</span></label>
                                <textarea name="memo_reason" id="input_reason" class="form-control" rows="3" 
                                          placeholder="ระบุอาการชำรุดเสียหาย เช่น ท่อน้ำรั่วซึม ทำให้มีน้ำเจิ่งนอง หรือหลอดไฟดับ ไม่สามารถใช้งานได้..." required><?= $memo_data_db['memo_reason'] ?? ($repair_info['repair_detail'] ?? '') ?></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">ประมาณการงบประมาณ / ค่าใช้จ่าย (บาท)</label>
                                <input type="text" class="form-control" name="memo_budget" id="input_budget" 
                                       value="<?= $memo_data_db['memo_budget'] ?? '' ?>" 
                                       placeholder="เว้นว่างได้ หรือระบุยอดเงิน เช่น 3,500">
                                <small class="text-muted">หากระบุ ยอดเงินจะปรากฏในย่อหน้าที่ 2 ของบันทึกข้อความ</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: ข้อมูลผู้ขอ / ผู้ลงนาม -->
                <div class="form-glass-card">
                    <div class="card-title-premium">
                        <span><i class="bx bx-user me-2 text-info"></i> 3. ข้อมูลผู้เสนอขออนุมัติ</span>
                        <span class="badge bg-label-info rounded-pill">ผู้ลงนาม</span>
                    </div>
                    <div class="card-body-premium">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">ตำแหน่งผู้เสนอ <span class="text-danger">*</span></label>
                                <?php
                                    $d_posi = $memo_data_db['memo_posi'] ?? ($repair_info['repair_posi'] ?? '');
                                    $d_academic = $repair_pers['pers_academic'] ?? '';
                                    if (!empty($d_academic) && ($d_posi === 'ครู' || mb_strpos($d_posi, 'ครู') !== false) && mb_strpos($d_posi, 'ผู้อำนวยการ') === false && mb_strpos($d_posi, 'วิทยฐานะ') === false && $d_academic !== 'ไม่มี' && $d_academic !== '-') {
                                        if (mb_strpos($d_academic, 'วิทยฐานะ') !== false) {
                                            $d_posi .= ' ' . $d_academic;
                                        } elseif (mb_strpos($d_academic, 'ครู') === 0) {
                                            $d_posi .= ' วิทยฐานะ' . $d_academic;
                                        } else {
                                            $d_posi .= ' วิทยฐานะครู' . $d_academic;
                                        }
                                    }
                                ?>
                                <input type="hidden" name="memo_posi_name" id="hidden_posi_name" value="<?= esc($d_posi) ?>">
                                <select name="memo_posi" id="input_posi" class="form-select" required>
                                    <option value="" <?= empty($d_posi)?'selected':'' ?> disabled>-- เลือกตำแหน่ง --</option>
                                    <?php foreach ($Posi as $v) :?>
                                    <option value="<?=$v->posi_id?>" <?= ($d_posi==$v->posi_name || $d_posi==$v->posi_id)?'selected':'' ?> data-posiname="<?=$v->posi_name?>"><?=$v->posi_name?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">ชื่อ - นามสกุล ผู้เสนอ <span class="text-danger">*</span></label>
                                <?php $d_fullname = $memo_data_db['memo_fullname'] ?? (isset($repair_pers) ? ($repair_pers['pers_prefix'].$repair_pers['pers_firstname'].' '.$repair_pers['pers_lastname']) : ''); ?>
                                <select name="memo_fullname" id="input_fullname" class="form-select" required <?= empty($d_fullname)?'disabled':'' ?>>
                                    <?php if(empty($d_fullname)): ?>
                                        <option value="" selected disabled>-- กรุณาเลือกตำแหน่งก่อน --</option>
                                    <?php else: ?>
                                        <option value="<?= $d_fullname ?>" selected><?= $d_fullname ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: แนบรูปภาพประกอบ -->
                <div class="form-glass-card">
                    <div class="card-title-premium">
                        <span><i class="bx bx-image-add me-2 text-success"></i> 4. รูปภาพประกอบจุดชำรุด (ถ้ามี)</span>
                    </div>
                    <div class="card-body-premium">
                        <p class="text-muted small mb-3">รูปภาพที่แนบจะถูกจัดวางเป็นเอกสารแนบท้ายในหน้าถัดไปของ PDF โดยอัตโนมัติ</p>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">รูปภาพที่ 1</label>
                                <input class="form-control form-control-sm" type="file" name="memo_image1" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">รูปภาพที่ 2</label>
                                <input class="form-control form-control-sm" type="file" name="memo_image2" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="mb-4">
                    <button type="submit" class="btn btn-submit-premium w-100 shadow">
                        <i class="bx bxs-file-pdf fs-4"></i> สร้างเอกสารและพิมพ์บันทึกข้อความ (PDF)
                    </button>
                </div>

            </div>
            
            <!-- Right Column: High Fidelity A4 Live Official Preview -->
            <div class="col-xl-7 col-lg-7">
                <div class="d-flex justify-content-between align-items-center mb-2 px-1 flex-wrap gap-2">
                    <span class="text-muted small fw-bold"><i class="bx bx-show me-1"></i> ตัวอย่างเอกสารราชการจริง (Live A4 Preview)</span>
                    
                    <!-- Interactive Zoom Controls -->
                    <div class="d-flex align-items-center gap-1 bg-white p-1 rounded-pill shadow-sm border">
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-circle" style="width: 26px; height: 26px; padding: 0;" onclick="changeZoom(-0.05)" title="ย่อขนาด A4">
                            <i class="bx bx-minus" style="font-size: 14px;"></i>
                        </button>
                        <span id="zoomLabel" class="badge text-dark px-2 font-monospace" style="font-size: 0.8rem;">55%</span>
                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary rounded-circle" style="width: 26px; height: 26px; padding: 0;" onclick="changeZoom(0.05)" title="ขยายขนาด A4">
                            <i class="bx bx-plus" style="font-size: 14px;"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-light rounded-pill px-2 py-0 ms-1 text-muted" style="font-size: 0.75rem;" onclick="resetZoom()" title="คืนค่าขนาดมาตรฐาน">รีเซ็ต</button>
                    </div>
                </div>

                <div class="a4-preview-container">
                    <div class="a4-preview-viewport">
                        <div class="a4-page">
                            
                            <!-- ตราครุฑ 1.5 ซม. มุมบนซ้าย -->
                            <img src="<?= base_url('uploads/krut/krut-1.5-cm.png') ?>" alt="ตราครุฑ" class="a4-garuda">
                            
                            <!-- คำว่า "บันทึกข้อความ" 29pt หนา -->
                            <div class="a4-memo-title">บันทึกข้อความ</div>
                            
                            <!-- Header Details: ส่วนราชการ, ที่, วันที่, เรื่อง -->
                            <table class="a4-header-table">
                                <tr>
                                    <td width="100%">
                                        <span class="a4-lbl-20">ส่วนราชการ</span>
                                        <span class="a4-val-16 a4-val-highlight ms-2" id="prev_agency">กลุ่มบริหารทั่วไป งานอาคารสถานที่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ โทร. ๐-๕๖๐๐-๙๖๖๗</span>
                                    </td>
                                </tr>
                            </table>
                            
                            <table class="a4-header-table">
                                <tr>
                                    <td width="50%">
                                        <span class="a4-lbl-20">ที่</span>
                                        <span class="a4-val-16 a4-val-highlight ms-2 text-muted" id="prev_no">....................................................................</span>
                                    </td>
                                    <td width="50%">
                                        <span class="a4-lbl-20">วันที่</span>
                                        <span class="a4-val-16 a4-val-highlight ms-2" id="prev_date"><?= $Datethai->thai_date_fullmonth(strtotime(date('Y-m-d'))) ?></span>
                                    </td>
                                </tr>
                            </table>

                            <table class="a4-header-table">
                                <tr>
                                    <td width="100%">
                                        <span class="a4-lbl-20">เรื่อง</span>
                                        <span class="a4-val-16 a4-val-highlight ms-2" id="prev_subject">ขออนุมัติซ่อมแซมอาคารสถานที่</span>
                                    </td>
                                </tr>
                            </table>

                            <!-- เส้นคั่นเดี่ยวมาตรฐาน -->
                            <div class="a4-solid-divider"></div>

                            <!-- คำขึ้นต้น: เรียน -->
                            <div class="a4-greeting">
                                <span class="a4-lbl-20">เรียน</span>
                                <span class="a4-val-16 a4-val-highlight ms-2" id="prev_to">ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</span>
                            </div>

                            <!-- เนื้อหา 3 ย่อหน้ามาตรฐานราชการ -->
                            <!-- ย่อหน้า 1: ต้นเรื่อง -->
                            <p class="a4-paragraph">
                                ด้วย งานอาคารสถานที่ กลุ่มบริหารทั่วไป ได้รับแจ้งปัญหาความชำรุดเสียหายบริเวณ 
                                <span id="prev_location" class="a4-val-highlight fw-bold">........................................................................................</span> 
                                เนื่องจาก <span id="prev_reason" class="a4-val-highlight fw-bold">..........................................................................................................................................</span>
                            </p>

                            <!-- ย่อหน้า 2: เหตุผลความจำเป็น & ข้อเสนอ -->
                            <p class="a4-paragraph">
                                ในการนี้ เพื่อให้การปฏิบัติงานและการจัดกิจกรรมการเรียนการสอนดำเนินไปด้วยความเรียบร้อย มีความปลอดภัยในชีวิตและทรัพย์สินของทางราชการ และป้องกันมิให้เกิดความชำรุดเสียหายเพิ่มมากขึ้น งานอาคารสถานที่จึงเห็นควรดำเนินการซ่อมแซมจุดดังกล่าว 
                                <span id="prev_budget_container" style="display: none;">
                                    โดยมีประมาณการค่าใช้จ่ายเบื้องต้นจำนวนทั้งสิ้น <span id="prev_budget" class="a4-val-highlight fw-bold"></span> บาท
                                </span>
                            </p>
                            
                            <!-- ย่อหน้า 3: ความประสงค์ / สรุป -->
                            <p class="a4-paragraph">
                                จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ และมอบหมายเจ้าหน้าที่ผู้เกี่ยวข้องดำเนินการต่อไป
                            </p>

                            <!-- ส่วนลงนามผู้ขอ (ชิดขวา) -->
                            <div class="a4-signature-block">
                                <table class="a4-sig-table">
                                    <tr>
                                        <td width="40%"></td>
                                        <td width="60%" class="a4-sig-cell">
                                            <p class="mb-1">ลงชื่อ..............................................................</p>
                                            <?php 
                                                $initFullname = !empty($d_fullname) ? $d_fullname : '........................................................';
                                                $initPosi = 'ตำแหน่ง........................................................';
                                                if(!empty($d_posi)) {
                                                    $initPosi = (mb_strpos($d_posi, 'ตำแหน่ง') === 0) ? $d_posi : ('ตำแหน่ง ' . $d_posi);
                                                }
                                            ?>
                                            <p class="mb-1">(<span id="prev_fullname" class="a4-val-highlight <?= empty($d_fullname)?'text-muted':'' ?>"><?= esc($initFullname) ?></span>)</p>
                                            <p class="mb-0"><span id="prev_posi" class="a4-val-highlight <?= empty($d_posi)?'text-muted':'' ?>"><?= esc($initPosi) ?></span></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Live Zoom Controller
    let currentScale = 0.55;
    function applyZoom(scale) {
        currentScale = Math.min(Math.max(scale, 0.35), 1.10);
        const a4Page = document.querySelector('.a4-page');
        if (a4Page) {
            a4Page.style.transform = `scale(${currentScale})`;
            // Dynamically calculate bottom margin to prevent large dead spaces below scaled element
            const mb = -Math.round((1 - currentScale) * 290);
            a4Page.style.marginBottom = `${mb}mm`;
        }
        const zoomLabel = document.getElementById('zoomLabel');
        if (zoomLabel) {
            zoomLabel.textContent = `${Math.round(currentScale * 100)}%`;
        }
    }
    function changeZoom(delta) {
        applyZoom(currentScale + delta);
    }
    function resetZoom() {
        applyZoom(0.55);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 with Sneat default theme
        $('#input_posi').select2({
            width: '100%',
            placeholder: "-- เลือกตำแหน่ง --"
        });
        
        $('#input_fullname').select2({
            width: '100%',
            placeholder: "-- กรุณาเลือกตำแหน่งก่อน --"
        });

        // Helper function to sync input to preview
        function syncField(inputId, previewId, defaultTxt) {
            const $in = $('#' + inputId);
            const $prev = $('#' + previewId);
            if (!$in.length || !$prev.length) return;

            const update = () => {
                let val = '';
                if ($in.is('select')) {
                    const selText = $in.find('option:selected').text();
                    if (selText && $in.val() !== "" && !selText.includes('--')) {
                        val = selText;
                    }
                } else {
                    val = $in.val().trim();
                }

                if (val === '') {
                    $prev.text(defaultTxt).addClass('text-muted');
                } else {
                    $prev.text(val).removeClass('text-muted');
                }
            };

            $in.on('input change select2:select', update);
            update();
        }

        // Sync all memo fields
        syncField('input_agency', 'prev_agency', 'กลุ่มบริหารทั่วไป งานอาคารสถานที่ โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์ โทร. ๐-๕๖๐๐-๙๖๖๗');
        syncField('input_no', 'prev_no', '....................................................................');
        syncField('input_date', 'prev_date', '..................................................');
        syncField('input_subject', 'prev_subject', 'ขออนุมัติซ่อมแซมอาคารสถานที่');
        syncField('input_to', 'prev_to', 'ผู้อำนวยการโรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์');
        syncField('input_location', 'prev_location', '........................................................................................');
        syncField('input_reason', 'prev_reason', '..........................................................................................................................................');
        syncField('input_fullname', 'prev_fullname', '........................................................');

        // Function to compute position with academic standing (วิทยฐานะ)
        function updatePositionDisplay() {
            const posiName = $('#input_posi').find('option:selected').data('posiname') || $('#input_posi').find('option:selected').text() || '';
            const academic = $('#input_fullname').find('option:selected').data('academic') || '';
            
            let fullPosi = posiName.trim();
            if (fullPosi && !fullPosi.includes('--')) {
                if ((fullPosi === 'ครู' || fullPosi.includes('ครู')) && !fullPosi.includes('ผู้อำนวยการ')) {
                    if (academic && academic !== 'ไม่มี' && academic !== '-') {
                        if (academic.includes('วิทยฐานะ')) {
                            fullPosi = fullPosi + ' ' + academic;
                        } else if (academic.startsWith('ครู')) {
                            fullPosi = fullPosi + ' วิทยฐานะ' + academic;
                        } else {
                            fullPosi = fullPosi + ' วิทยฐานะครู' + academic;
                        }
                    }
                }
                $('#hidden_posi_name').val(fullPosi);
                const cleanPosi = fullPosi.startsWith('ตำแหน่ง') ? fullPosi : ('ตำแหน่ง ' + fullPosi);
                $('#prev_posi').text(cleanPosi).removeClass('text-muted');
            } else {
                $('#hidden_posi_name').val('');
                $('#prev_posi').text('ตำแหน่ง........................................................').addClass('text-muted');
            }
        }

        // Position change handler & update hidden field
        $('#input_posi').on('change select2:select', function() {
            const posiId = $(this).val();
            updatePositionDisplay();

            if (!posiId) return;

            $('#input_fullname').prop('disabled', true)
                .html('<option value="" selected disabled>กำลังโหลดรายชื่อ...</option>')
                .trigger('change.select2');

            $.post(
                "<?= base_url('Repair/DB/CheckPosiUser') ?>",
                { repair_posi: posiId },
                function(data) {
                    $('#input_fullname').prop('disabled', false).empty().append('<option value="" selected disabled>-- เลือกรายชื่อ --</option>');
                    
                    $.each(data, function(key, val) {
                        const fullName = val.pers_prefix + val.pers_firstname + " " + val.pers_lastname;
                        const isMatch = (fullName === '<?= addslashes($d_fullname) ?>') ? 'selected' : '';
                        const academic = val.pers_academic || '';
                        $('#input_fullname').append(`<option value="${fullName}" data-academic="${academic}" ${isMatch}>${fullName}</option>`);
                    });
                    
                    $('#input_fullname').trigger('change').trigger('change.select2');
                    updatePositionDisplay();
                },
                "json"
            );
        });

        $('#input_fullname').on('change select2:select', function() {
            updatePositionDisplay();
        });

        // Trigger on initial load
        if ($('#input_posi').val()) {
            $('#input_posi').trigger('change');
        }

        // Budget live update
        const $budgetIn = $('#input_budget');
        const $budgetContainer = $('#prev_budget_container');
        const $budgetPrev = $('#prev_budget');

        $budgetIn.on('input', function() {
            const val = $(this).val().trim();
            if (val !== '') {
                $budgetPrev.text(val);
                $budgetContainer.show();
            } else {
                $budgetContainer.hide();
            }
        });
    });
</script>
<?= $this->endSection() ?>
