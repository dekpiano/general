<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --repair-primary: #6366f1;
        --repair-primary-hover: #4f46e5;
        --repair-secondary: #0ea5e9;
        --repair-bg-soft: #f8fafc;
        --repair-card-bg: #ffffff;
        --repair-border: #e2e8f0;
        --repair-text-main: #1e293b;
        --repair-text-muted: #64748b;
        --repair-accent-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #06b6d4 100%);
    }

    .repair-container {
        padding-top: 1.5rem;
        padding-bottom: 4rem;
    }

    /* Hero Header */
    .repair-hero-card {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 80%, #6366f1 100%);
        border-radius: 1.5rem;
        padding: 2.25rem 2.5rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px -15px rgba(67, 56, 202, 0.4);
        margin-bottom: 2rem;
    }

    .repair-hero-card::before {
        content: '';
        position: absolute;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, rgba(99, 102, 241, 0) 70%);
        top: -80px;
        right: 15%;
        border-radius: 50%;
        pointer-events: none;
    }

    .repair-hero-card::after {
        content: '';
        position: absolute;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.25) 0%, rgba(14, 165, 233, 0) 70%);
        bottom: -50px;
        left: -50px;
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 0.4rem 1rem;
        border-radius: 9999px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        color: #e0e7ff;
        margin-bottom: 1rem;
    }

    .hero-title {
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #ffffff;
        margin-bottom: 0.5rem;
        line-height: 1.25;
    }

    .hero-subtitle {
        color: #c7d2fe;
        font-size: 0.95rem;
        max-width: 650px;
        line-height: 1.5;
        margin-bottom: 0;
    }

    .hero-illus {
        height: 120px;
        filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.25));
        transition: transform 0.3s ease;
    }

    .hero-illus:hover {
        transform: scale(1.05) rotate(-2deg);
    }

    /* Stepper Progress Bar */
    .stepper-nav {
        background: #ffffff;
        border: 1px solid var(--repair-border);
        border-radius: 1.25rem;
        padding: 1.25rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .stepper-step {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        position: relative;
        z-index: 2;
        flex: 1;
    }

    .stepper-step:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        width: 35%;
        height: 2px;
        background: #e2e8f0;
        z-index: 1;
    }

    .step-circle {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        background: #f1f5f9;
        color: #64748b;
        border: 2px solid #e2e8f0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }

    .stepper-step.active .step-circle {
        background: var(--repair-accent-gradient);
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 8px 16px rgba(99, 102, 241, 0.3);
    }

    .step-content {
        display: flex;
        flex-direction: column;
    }

    .step-subtitle {
        font-size: 0.72rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #94a3b8;
    }

    .step-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--repair-text-main);
    }

    /* Cards */
    .card-modern {
        background: #ffffff;
        border: 1px solid var(--repair-border);
        border-radius: 1.25rem;
        box-shadow: 0 4px 25px -4px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.75rem;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-modern-header {
        padding: 1.25rem 1.75rem;
        background: linear-gradient(to right, #f8fafc, #ffffff);
        border-bottom: 1px solid var(--repair-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-modern-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--repair-text-main);
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin: 0;
    }

    .card-modern-title i {
        font-size: 1.35rem;
        color: var(--repair-primary);
        background: #eef2ff;
        padding: 0.45rem;
        border-radius: 10px;
    }

    .card-modern-body {
        padding: 1.75rem;
    }

    /* Form Fields */
    .form-group-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--repair-primary);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-modern {
        font-size: 0.88rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.45rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .form-label-modern i {
        color: var(--repair-primary);
        font-size: 1.05rem;
    }

    .form-control-modern {
        height: 48px;
        border-radius: 12px;
        border: 1.5px solid #cbd5e1;
        padding: 0.65rem 1.1rem;
        font-size: 0.92rem;
        color: #1e293b;
        background-color: #ffffff;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }

    .form-control-modern:focus {
        border-color: var(--repair-primary) !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15) !important;
        background-color: #ffffff;
    }

    textarea.form-control-modern {
        height: auto;
        min-height: 120px;
        line-height: 1.6;
    }

    .input-hint {
        font-size: 0.78rem;
        color: #94a3b8;
        margin-top: 0.35rem;
    }

    /* Category Badges / Quick select */
    .category-quick-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .category-pill-btn {
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 10px;
        padding: 0.45rem 0.9rem;
        font-size: 0.84rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .category-pill-btn:hover {
        border-color: var(--repair-primary);
        color: var(--repair-primary);
        background: #eef2ff;
        transform: translateY(-1px);
    }

    .category-pill-btn.active {
        background: var(--repair-primary);
        border-color: var(--repair-primary);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.25);
    }

    /* Select2 Sneat/Modern Overrides */
    .select2-container {
        display: block !important;
        width: 100% !important;
    }

    .select2-container .select2-selection--single {
        height: 48px !important;
        min-height: 48px !important;
        border: 1.5px solid #cbd5e1 !important;
        border-radius: 12px !important;
        background-color: #ffffff !important;
        padding: 0 1rem !important;
        display: flex !important;
        align-items: center !important;
        transition: all 0.2s ease-in-out !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02) !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: var(--repair-primary) !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15) !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        color: #1e293b !important;
        font-size: 0.92rem !important;
        font-weight: 500 !important;
        padding-left: 0 !important;
        line-height: 46px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 48px !important;
        right: 12px !important;
    }

    .select2-dropdown {
        border: 1.5px solid rgba(99, 102, 241, 0.25) !important;
        border-radius: 14px !important;
        box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.15) !important;
        overflow: hidden !important;
        z-index: 99999 !important;
        padding: 8px !important;
    }

    .select2-container .select2-search--dropdown .select2-search__field {
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 10px !important;
        padding: 0.6rem 0.9rem !important;
        font-size: 0.9rem !important;
    }

    .select2-container--default .select2-results__option {
        padding: 9px 14px !important;
        border-radius: 8px !important;
        margin-bottom: 3px !important;
        font-size: 0.9rem !important;
        color: #334155 !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #eef2ff !important;
        color: var(--repair-primary) !important;
        font-weight: 600 !important;
    }

    .select2-container--default .select2-results__option[aria-selected="true"] {
        background: var(--repair-accent-gradient) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
    }

    /* Photo Upload Cards */
    .photo-slot {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 0.75rem;
        cursor: pointer;
        position: relative;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .photo-slot:hover {
        border-color: var(--repair-primary);
        background: #eef2ff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.12);
    }

    .photo-slot-img {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        border-radius: 10px;
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .photo-slot-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(4px);
        color: #ffffff;
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .photo-slot-hint {
        margin-top: 0.6rem;
        font-size: 0.76rem;
        font-weight: 600;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .photo-slot:hover .photo-slot-hint {
        color: var(--repair-primary);
    }

    /* Signature Pad Modern Box */
    .signature-card-box {
        background: #ffffff;
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 0.5rem;
        position: relative;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }

    .signature-card-box:focus-within,
    .signature-card-box:hover {
        border-color: var(--repair-primary);
    }

    #signature-pad {
        width: 100%;
        height: 180px;
        background-color: #ffffff;
        border-radius: 10px;
        cursor: crosshair;
        touch-action: none;
    }

    .signature-guide-line {
        position: absolute;
        bottom: 45px;
        left: 25px;
        right: 25px;
        height: 1px;
        border-bottom: 1px dashed #e2e8f0;
        pointer-events: none;
        z-index: 1;
    }

    .signature-watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #cbd5e1;
        font-size: 0.85rem;
        font-weight: 600;
        pointer-events: none;
        user-select: none;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        z-index: 0;
        transition: opacity 0.2s ease;
    }

    /* Captcha & Submit Card */
    .captcha-box {
        background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
        border: 1.5px solid #e0e7ff;
        border-radius: 14px;
        padding: 1.25rem;
        text-align: center;
        margin-bottom: 1.25rem;
    }

    .captcha-equation {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: #ffffff;
        padding: 0.65rem 1.25rem;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.08);
        border: 1px solid #e2e8f0;
    }

    .captcha-badge {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--repair-primary);
        letter-spacing: 1px;
    }

    .captcha-input-modern {
        width: 85px;
        height: 52px;
        font-size: 1.5rem;
        font-weight: 800;
        text-align: center;
        border-radius: 10px;
        border: 2px solid #cbd5e1;
        color: #1e293b;
        transition: all 0.2s ease;
    }

    .captcha-input-modern:focus {
        border-color: var(--repair-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        outline: none;
    }

    .btn-submit-glow {
        background: var(--repair-accent-gradient);
        border: none;
        color: #ffffff;
        padding: 1.1rem 1.5rem;
        border-radius: 14px;
        font-size: 1.05rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.45);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
    }

    .btn-submit-glow:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px -5px rgba(79, 70, 229, 0.6);
        color: #ffffff;
    }

    .btn-submit-glow:disabled {
        background: #cbd5e1;
        box-shadow: none;
        cursor: not-allowed;
        color: #64748b;
    }

    .section-separator {
        height: 1px;
        background: #f1f5f9;
        margin: 1.5rem 0;
    }

    @media (max-width: 991.98px) {
        .stepper-nav {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
            padding: 1.25rem;
        }
        .stepper-step {
            width: 100%;
        }
        .stepper-step::after {
            display: none !important;
        }
        .hero-illus {
            display: none;
        }
        .repair-hero-card {
            padding: 1.75rem 1.5rem;
        }
        .hero-title {
            font-size: 1.45rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 repair-container">

    <!-- Hero Header -->
    <div class="repair-hero-card">
        <div class="row align-items-center">
            <div class="col-lg-9">
                <div class="hero-badge">
                    <i class="bx bx-check-shield"></i> ระบบแจ้งซ่อมทั่วไปและโสตทัศนูปกรณ์
                </div>
                <h1 class="hero-title">แบบฟอร์มบันทึกการแจ้งซ่อมออนไลน์</h1>
                <p class="hero-subtitle">
                    กรอกข้อมูลรายละเอียดอาการเสีย สถานที่เกิดเหตุ พร้อมแนบรูปถ่ายและลงลายมือชื่อ เพื่อให้เจ้าหน้าที่ฝ่ายเทคนิคและงานอาคารสถานที่รับเรื่องและดำเนินการแก้ไขอย่างรวดเร็ว
                </p>
                <div class="d-flex align-items-center gap-3 mt-3 flex-wrap">
                    <span class="badge bg-white text-dark py-2 px-3 rounded-pill fw-bold" style="font-size: 0.85rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <i class="bx bx-calendar me-1 text-primary"></i> วันที่แจ้ง: <?=$Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')))?>
                    </span>
                    <a href="<?=base_url('Repair')?>" class="text-white text-decoration-none small fw-semibold opacity-75 hover-opacity-100">
                        <i class="bx bx-arrow-back me-1"></i> ย้อนกลับไปหน้าตรวจสอบสถานะ
                    </a>
                </div>
            </div>
            <div class="col-lg-3 text-end d-none d-lg-block">
                <img src="<?=base_url('assets/img/illustrations/man-with-laptop-light.png')?>" alt="Repair Illustration" class="hero-illus img-fluid">
            </div>
        </div>
    </div>

    <!-- Stepper Progress Tracker -->
    <div class="stepper-nav">
        <div class="stepper-step active">
            <div class="step-circle"><i class="bx bx-wrench"></i></div>
            <div class="step-content">
                <span class="step-subtitle">ขั้นตอนที่ 1</span>
                <span class="step-title">ระบุอาการเสีย</span>
            </div>
        </div>
        <div class="stepper-step active">
            <div class="step-circle"><i class="bx bx-map-pin"></i></div>
            <div class="step-content">
                <span class="step-subtitle">ขั้นตอนที่ 2</span>
                <span class="step-title">สถานที่เกิดเหตุ</span>
            </div>
        </div>
        <div class="stepper-step active">
            <div class="step-circle"><i class="bx bx-user-circle"></i></div>
            <div class="step-content">
                <span class="step-subtitle">ขั้นตอนที่ 3</span>
                <span class="step-title">ข้อมูลผู้แจ้ง</span>
            </div>
        </div>
        <div class="stepper-step active">
            <div class="step-circle"><i class="bx bx-check-double"></i></div>
            <div class="step-content">
                <span class="step-subtitle">ขั้นตอนที่ 4</span>
                <span class="step-title">หลักฐาน & ยืนยัน</span>
            </div>
        </div>
    </div>

    <!-- Main Repair Form -->
    <form id="FormAddRepair" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="row g-4">
            
            <!-- Left Column: Form Details (Steps 1, 2, 3) -->
            <div class="col-lg-8">

                <!-- Step 1 & 2 Card: Details & Location -->
                <div class="card-modern">
                    <div class="card-modern-header">
                        <h2 class="card-modern-title">
                            <i class="bx bx-detail"></i> รายละเอียดปัญหาและสถานที่
                        </h2>
                        <span class="badge bg-label-primary rounded-pill px-3 py-2 fw-semibold">
                            ส่วนที่ 1 & 2
                        </span>
                    </div>

                    <div class="card-modern-body">
                        <!-- Hidden Date Tracker -->
                        <input type="hidden" id="repair_date" value="<?=$Datethai->thai_date_and_time(strtotime(date('Y-m-d H:i:s')))?>">

                        <!-- SECTION 1: Problem Details -->
                        <div class="form-group-title">
                            <i class="bx bx-wrench"></i> 1. หมวดหมู่และรายละเอียดปัญหา
                        </div>

                        <!-- Quick Category Pills -->
                        <div class="mb-3">
                            <label class="form-label-modern" for="repair_caselist">
                                <i class="bx bx-category"></i> ประเภทงานแจ้งซ่อม <span class="text-danger">*</span>
                            </label>
                            
                            <div class="category-quick-pills">
                                <?php 
                                $categories = [
                                    'คอมพิวเตอร์/โปรเจคเตอร์' => 'bx-laptop',
                                    'ปริ้นเตอร์/สแกนเนอร์' => 'bx-printer',
                                    'ระบบเครือข่าย' => 'bx-wifi',
                                    'โสตทัศนอุปกรณ์' => 'bx-volume-full',
                                    'งานอาคารสถานที่' => 'bx-building'
                                ];
                                foreach($categories as $catName => $catIcon): 
                                    $isSelected = ($selectedCategory ?? '') === $catName;
                                ?>
                                <button type="button" class="category-pill-btn <?= $isSelected ? 'active' : '' ?>" data-val="<?=$catName?>">
                                    <i class="bx <?=$catIcon?>"></i> <?=$catName?>
                                </button>
                                <?php endforeach; ?>
                            </div>

                            <select name="repair_caselist" id="repair_caselist" class="form-select" required>
                                <option value="" <?= empty($selectedCategory) ? 'selected' : '' ?> disabled>-- กรุณาเลือกประเภทงานซ่อม --</option>
                                <?php foreach($categories as $catName => $catIcon): ?>
                                    <option value="<?=$catName?>" <?= ($selectedCategory ?? '') === $catName ? 'selected' : '' ?>><?=$catName?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern" for="repair_detail">
                                <i class="bx bx-message-square-error"></i> รายละเอียดอาการเสีย / ปัญหาที่พบ <span class="text-danger">*</span>
                            </label>
                            <textarea id="repair_detail" name="repair_detail" class="form-control form-control-modern" placeholder="อธิบายอาการเสียอย่างละเอียด เช่น เปิดไม่ติด มีเสียงดัง ปริ้นไม่ออก หรือรหัสครุภัณฑ์ (ถ้ามี)..." required></textarea>
                            <div class="input-hint">
                                <i class="bx bx-info-circle me-1"></i> ยิ่งระบุรายละเอียดได้ชัดเจน เจ้าหน้าที่จะเตรียมอุปกรณ์และอะไหล่ได้ตรงจุดยิ่งขึ้น
                            </div>
                        </div>

                        <div class="section-separator"></div>

                        <!-- SECTION 2: Location Details -->
                        <div class="form-group-title">
                            <i class="bx bx-map"></i> 2. สถานที่เกิดเหตุและห้อง
                        </div>

                        <div class="row g-3 mb-2">
                            <div class="col-md-5">
                                <label class="form-label-modern" for="repair_building">
                                    <i class="bx bx-building-house"></i> อาคาร / สถานที่ <span class="text-danger">*</span>
                                </label>
                                <select name="repair_building" id="repair_building" class="form-select" required>
                                    <option value="" selected disabled>-- เลือกอาคาร --</option>
                                    <option value="อาคาร 1">อาคาร 1</option>
                                    <option value="อาคาร 2">อาคาร 2</option>
                                    <option value="อาคาร 3">อาคาร 3</option>
                                    <option value="อาคาร 4">อาคาร 4</option>
                                    <option value="อาคาร 5">อาคาร 5 โรงอาหาร</option>
                                    <option value="อาคาร 6">อาคาร 6</option>
                                    <option value="อาคาร 7">อาคาร 7</option>
                                    <option value="อาคาร 8">อาคาร 8</option>
                                    <option value="อาคาร 9">อาคาร 9</option>
                                    <option value="อาคารเจ้าพระยา">อาคารเจ้าพระยา</option>
                                    <option value="อาคารกีฬา">อาคารกีฬา</option>
                                    <option value="อาคารโดมเอนกประสงค์">อาคารโดมเอนกประสงค์</option>
                                    <option value="อาคารเอนกประสงค์">อาคารเอนกประสงค์</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label-modern" for="repair_class">
                                    <i class="bx bx-layer"></i> ชั้นที่ <span class="text-danger">*</span>
                                </label>
                                <select name="repair_class" id="repair_class" class="form-select" required>
                                    <option value="" selected disabled>-- เลือกชั้น --</option>
                                    <option value="1">ชั้น 1</option>
                                    <option value="2">ชั้น 2</option>
                                    <option value="3">ชั้น 3</option>
                                    <option value="4">ชั้น 4</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label-modern" for="repair_room">
                                    <i class="bx bx-door-open"></i> เลขห้อง / ชื่อห้อง
                                </label>
                                <input type="text" class="form-control form-control-modern" name="repair_room" id="repair_room" placeholder="เช่น ห้อง 421 หรือ ห้องพักครู">
                            </div>
                        </div>

                        <div class="section-separator"></div>

                        <!-- SECTION 3: Requester Details -->
                        <div class="form-group-title">
                            <i class="bx bx-user-check"></i> 3. ข้อมูลผู้แจ้งซ่อม
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-modern" for="repair_posi">
                                    <i class="bx bx-id-card"></i> กลุ่มสาระฯ / ตำแหน่ง <span class="text-danger">*</span>
                                </label>
                                <select name="repair_posi" id="repair_posi" class="form-select" required>
                                    <option value="" selected disabled>-- เลือกกลุ่มสาระ/ตำแหน่ง --</option>
                                    <?php foreach ($Posi as $v_Posi) :?>
                                    <option value="<?=$v_Posi->posi_id?>"><?=$v_Posi->posi_name?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-modern" for="repair_userID">
                                    <i class="bx bx-user"></i> ชื่อผู้แจ้งซ่อม <span class="text-danger">*</span>
                                </label>
                                <select name="repair_userID" id="repair_userID" class="form-select" required disabled>
                                    <option value="" selected disabled>-- กรุณาเลือกกลุ่มสาระก่อน --</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label-modern" for="repair_phone">
                                    <i class="bx bx-phone-call"></i> เบอร์โทรศัพท์ติดต่อกลับ <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px; border-color: #cbd5e1;">
                                        <i class="bx bx-phone text-muted"></i>
                                    </span>
                                    <input type="tel" class="form-control form-control-modern border-start-0" name="repair_phone" id="repair_phone" placeholder="เช่น 0812345678" style="border-radius: 0 12px 12px 0;" required>
                                </div>
                                <div class="input-hint">
                                    <i class="bx bx-check-circle me-1 text-success"></i> ระบบจะดึงเบอร์โทรศัพท์ประจำตัวให้อัตโนมัติเมื่อเลือกรายชื่อ (สามารถแก้ไขได้)
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Right Column: Sidebar (Photos, Signature, Captcha & Submit) -->
            <div class="col-lg-4">
                <div class="row g-4">

                    <!-- Photos Card -->
                    <div class="col-12">
                        <div class="card-modern">
                            <div class="card-modern-header">
                                <h2 class="card-modern-title">
                                    <i class="bx bx-camera"></i> รูปภาพประกอบ
                                </h2>
                                <span class="badge bg-label-info rounded-pill px-2 py-1 small">
                                    สูงสุด 3 รูป
                                </span>
                            </div>
                            <div class="card-modern-body">
                                <p class="text-muted small mb-3">
                                    แนบรูปภาพจุดที่ชำรุดเพื่อช่วยให้ช่างประเมินอาการได้รวดเร็ว (คลิกที่ช่องเพื่ออัปโหลดหรือถ่ายรูป)
                                </p>

                                <div class="row g-3">
                                    <?php for($i=0; $i<3; $i++): ?>
                                    <div class="col-12">
                                        <div class="photo-slot" onclick="triggerFileInput(<?=$i?>)">
                                            <span class="photo-slot-badge">รูปที่ <?=$i+1?></span>
                                            <img src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22400%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f1f5f9%22%2F%3E%3Cpath%20d%3D%22M180%20100h40v25h-40z%22%20fill%3D%22%23cbd5e1%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2255%25%22%20font-family%3D%22sans-serif%22%20font-size%3D%2214%22%20fill%3D%22%2394a3b8%22%20text-anchor%3D%22middle%22%3E%2B%20%E0%B8%84%E0%B8%A5%E0%B8%B4%E0%B8%81%E0%B9%80%E0%B8%9E%E0%B8%B7%E0%B9%88%E0%B8%AD%E0%B9%81%E0%B8%99%E0%B8%9A%E0%B8%A3%E0%B8%B9%E0%B8%9B%3C%2Ftext%3E%3C%2Fsvg%3E" 
                                                 id="imageResult<?=$i?>" 
                                                 class="photo-slot-img" 
                                                 alt="รูปถ่ายที่ <?=$i+1?>">
                                            <div class="photo-slot-hint">
                                                <i class="bx bx-cloud-upload"></i> คลิกถ่ายภาพ / เลือกไฟล์รูป
                                            </div>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>

                                <input type="file" id="repair_imguser_input" class="d-none" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Digital Signature Card -->
                    <div class="col-12">
                        <div class="card-modern">
                            <div class="card-modern-header">
                                <h2 class="card-modern-title">
                                    <i class="bx bx-edit-alt"></i> ลายเซ็นผู้แจ้งซ่อม
                                </h2>
                                <span class="text-danger small fw-bold">* จำเป็น</span>
                            </div>
                            <div class="card-modern-body">
                                <p class="text-muted small mb-2">
                                    ลงลายมือชื่อดิจิทัลในกรอบด้านล่างเพื่อยืนยันการแจ้ง
                                </p>

                                <div class="signature-card-box mb-2">
                                    <div class="signature-watermark" id="signature-placeholder">
                                        <i class="bx bx-pencil fs-3"></i>
                                        <span>ลงลายมือชื่อที่นี่ (Sign Here)</span>
                                    </div>
                                    <div class="signature-guide-line"></div>
                                    <canvas id="signature-pad"></canvas>
                                </div>

                                <button type="button" class="btn btn-outline-danger btn-sm w-100 py-2 rounded-3" id="clear">
                                    <i class="bx bx-eraser me-1"></i> ล้างลายมือชื่อเพื่อเซ็นใหม่
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bot Protection & Submit Action -->
                    <div class="col-12">
                        <div class="card-modern">
                            <div class="card-modern-body">
                                
                                <div class="captcha-box">
                                    <label class="form-label-modern justify-content-center mb-2" for="captcha_input">
                                        <i class="bx bx-shield-quarter"></i> ยืนยันความถูกต้อง (Math Challenge)
                                    </label>
                                    <div class="captcha-equation">
                                        <div class="captcha-badge" data-answer="<?=$num1 + $num2?>">
                                            <?=$num1?> + <?=$num2?>
                                        </div>
                                        <span class="fs-4 fw-bold text-muted">=</span>
                                        <input type="number" 
                                               class="form-control captcha-input-modern" 
                                               id="captcha_input" 
                                               name="captcha_input" 
                                               placeholder="?" 
                                               required 
                                               autocomplete="off">
                                    </div>
                                    <div class="small text-muted mt-2">
                                        คำนวณผลบวกด้านบนเพื่อปลดล็อกปุ่มบันทึก
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-submit-glow w-100 disabled" id="BtnSubRepair" disabled>
                                    <span id="btnSaveText"><i class="bx bx-paper-plane me-1"></i> บันทึกข้อมูลแจ้งซ่อม</span>
                                    <span id="btnSpinner" class="spinner-border spinner-border-sm" style="display:none;" role="status"></span>
                                </button>

                                <a href="<?=base_url('Repair')?>" class="btn btn-link text-muted w-100 mt-2 text-decoration-none small">
                                    <i class="bx bx-x me-1"></i> ยกเลิกและย้อนกลับหน้าแรก
                                </a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </form>

    <!-- Crop Image Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden;">
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title text-white d-flex align-items-center gap-2" id="cropModalLabel">
                        <i class="bx bx-crop"></i> ปรับขนาดและครอบตัดรูปภาพ (16:9)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-dark">
                    <div id="croppie-container" style="height: 420px;"></div>
                </div>
                <div class="modal-footer bg-light d-flex justify-content-between py-2 px-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2" id="btn-rotate-left">
                            <i class="bx bx-rotate-left me-1"></i> หมุนซ้าย
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" id="btn-rotate-right">
                            <i class="bx bx-rotate-right me-1"></i> หมุนขวา
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-label-secondary btn-sm rounded-pill px-3 me-2" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm" id="btn-crop">
                            <i class="bx bx-check me-1"></i> ตกลง ใช้รูปนี้
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize Select2 with Sneat theme
        $('#FormAddRepair select').select2({
            width: '100%'
        });

        // Quick Category Pills Interaction
        $('.category-pill-btn').on('click', function() {
            const val = $(this).data('val');
            $('.category-pill-btn').removeClass('active');
            $(this).addClass('active');

            $('#repair_caselist').val(val).trigger('change');
        });

        // Sync Select2 back to pill buttons
        $('#repair_caselist').on('change', function() {
            const val = $(this).val();
            $('.category-pill-btn').removeClass('active');
            $(`.category-pill-btn[data-val="${val}"]`).addClass('active');
        });

        // Initialize Signature Pad for Add page if function exists
        if (typeof initSignaturePad === 'function') {
            setTimeout(function() {
                initSignaturePad();
                if (typeof resizeSignatureCanvas === 'function') {
                    resizeSignatureCanvas();
                }
            }, 100);
        }
    });
</script>
<?= $this->endSection() ?>
