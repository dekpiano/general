<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    /* --- Premium Variables --- */
    :root {
        --manual-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --manual-primary: #696cff;
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(105, 108, 255, 0.1);
    }

    /* Hero Section */
    .manual-hero {
        background: var(--manual-gradient);
        border-radius: 24px;
        padding: 3rem 2rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 20px 50px -15px rgba(105, 108, 255, 0.35);
        margin-bottom: 2.5rem;
    }

    .manual-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -15%;
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .manual-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-content { position: relative; z-index: 2; }

    .hero-title {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 0.75rem;
        color: #ffffff;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-subtitle {
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.9);
        max-width: 650px;
    }

    /* Pill Navigation */
    .nav-manual {
        background: var(--glass-bg);
        border-radius: 50px;
        padding: 6px;
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
    }

    .nav-manual .nav-link {
        border-radius: 50px;
        padding: 12px 24px;
        font-weight: 600;
        color: #32475c;
        transition: all 0.3s ease;
    }

    .nav-manual .nav-link.active {
        background: var(--manual-gradient);
        color: #fff;
        box-shadow: 0 8px 20px rgba(105, 108, 255, 0.35);
    }

    .nav-manual .nav-link:hover:not(.active) {
        background: rgba(105, 108, 255, 0.08);
        color: var(--manual-primary);
    }

    /* Step Cards */
    .step-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .step-card:hover {
        box-shadow: 0 15px 40px rgba(105, 108, 255, 0.12);
        transform: translateY(-3px);
    }

    .step-header {
        background: linear-gradient(135deg, rgba(105, 108, 255, 0.08) 0%, rgba(105, 108, 255, 0.02) 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--glass-border);
    }

    .step-body {
        padding: 2rem;
    }

    .step-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        background: var(--manual-gradient);
        color: #fff;
        font-weight: 800;
        font-size: 1.25rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(105, 108, 255, 0.3);
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .flow-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
    }

    /* Mockup Frame UI */
    .mockup-wrapper {
        background: #f4f6fb;
        border-radius: 16px;
        padding: 1.25rem;
        border: 2px dashed rgba(105, 108, 255, 0.2);
        position: relative;
    }

    .mockup-window {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(67, 89, 113, 0.1);
    }

    .mockup-window-header {
        background: #eef1f6;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        border-bottom: 1px solid rgba(67, 89, 113, 0.1);
    }

    .mockup-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    .mockup-dot.red { background: #ff5f56; }
    .mockup-dot.yellow { background: #ffbd2e; }
    .mockup-dot.green { background: #27c93f; }

    .mockup-window-body {
        padding: 1rem;
        font-size: 0.85rem;
    }

    .tip-box {
        background: rgba(105, 108, 255, 0.06);
        border-left: 4px solid var(--manual-primary);
        border-radius: 0 12px 12px 0;
        padding: 1rem 1.25rem;
        margin-top: 1.25rem;
    }

    .status-pill-demo {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    @media (max-width: 768px) {
        .manual-hero {
            padding: 2rem 1.25rem;
            text-align: center;
        }
        .hero-title { font-size: 1.6rem; }
        .step-body { padding: 1.25rem; }
        .step-header { padding: 1.25rem; }
        .nav-manual { border-radius: 16px; }
        .nav-manual .nav-link { padding: 8px 14px; font-size: 0.88rem; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y px-3 px-md-4">
    
    <!-- Hero Banner Header -->
    <div class="manual-hero">
        <div class="hero-content">
            <div class="d-flex align-items-center mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-white-50">หน้าหลัก</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('manual') ?>" class="text-white-50">คู่มือการใช้งาน</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">ระบบยืม-คืนพัสดุอุปกรณ์</li>
                    </ol>
                </nav>
            </div>
            <h1 class="hero-title">
                <i class="bi bi-box-seam me-2"></i>คู่มือการใช้งานระบบยืม-คืนพัสดุอุปกรณ์
            </h1>
            <p class="hero-subtitle mb-0">
                เรียนรู้ขั้นตอนการยืมพัสดุอุปกรณ์ การติดตามสถานะ การจ่ายของ/ส่งมอบ และการตรวจรับคืนเข้าสต็อกอย่างสมบูรณ์แบบ
            </p>
        </div>
    </div>

    <!-- Navigation Tabs (User vs Officer vs Lifecycle) -->
    <ul class="nav nav-manual nav-pills justify-content-center mb-4 gap-2" id="manualTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="user-tab" data-bs-toggle="pill" data-bs-target="#user-flow" type="button" role="tab">
                <i class="bi bi-person-fill me-1"></i> สำหรับผู้ขอยืม (บุคคลภายใน/ภายนอก)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="officer-tab" data-bs-toggle="pill" data-bs-target="#officer-flow" type="button" role="tab">
                <i class="bi bi-shield-check me-1"></i> สำหรับเจ้าหน้าที่งานพัสดุ
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="status-tab" data-bs-toggle="pill" data-bs-target="#status-flow" type="button" role="tab">
                <i class="bi bi-diagram-3 me-1"></i> วงจรสถานะ & เอกสาร A4
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="manualTabContent">

        <!-- ================= TAB 1: ผู้ขอยืม ================= -->
        <div class="tab-pane fade show active" id="user-flow" role="tabpanel">
            
            <!-- Step 1: ตรวจสอบรายการพัสดุ & แคตตาล็อก -->
            <div class="step-card">
                <div class="step-header d-flex align-items-center">
                    <div class="step-badge">1</div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">เลือกดูพัสดุอุปกรณ์ และตรวจสอบจำนวนคงเหลือ</h4>
                        <span class="flow-badge bg-label-primary text-primary">
                            <i class="bi bi-grid-fill"></i> หน้าหลักพัสดุอุปกรณ์ (/Equipment)
                        </span>
                    </div>
                </div>
                <div class="step-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-search text-primary me-2"></i>ขั้นตอนการเลือกดูอุปกรณ์</h6>
                            <ol class="text-secondary ps-3 mb-3">
                                <li class="mb-2">เข้าสู่หน้าหลัก <strong class="text-dark">"พัสดุอุปกรณ์"</strong> เพื่อดูรายการสิ่งของทั้งหมดที่เปิดให้ยืม</li>
                                <li class="mb-2">สามารถเลือกดูตามหมวดหมู่ (เช่น โสตทัศนูปกรณ์, เครื่องมือช่าง, อุปกรณ์กีฬา) หรือพิมพ์ค้นหา</li>
                                <li class="mb-2">ดูป้ายจำนวนคงเหลือสีเขียว <span class="badge bg-label-success">พร้อมยืม 5 ตัว</span> เพื่อทราบสถานะสต็อกทันที</li>
                                <li class="mb-2">กดปุ่มสีม่วง <strong class="text-primary">"ขอยืมอุปกรณ์นี้"</strong> เพื่อเปิดแบบฟอร์มพร้อมเลือกอุปกรณ์ให้อัตโนมัติ</li>
                            </ol>
                            <div class="tip-box">
                                <strong class="text-primary"><i class="bi bi-lightbulb-fill me-1"></i> Tip:</strong> หากยังไม่ได้เข้าสู่ระบบ สามารถดูรายการอุปกรณ์และสต็อกคงเหลือได้ตลอดเวลา
                            </div>
                        </div>

                        <!-- Mockup Screen: Catalog & KPIs -->
                        <div class="col-lg-6">
                            <div class="mockup-wrapper">
                                <div class="mockup-window">
                                    <div class="mockup-window-header">
                                        <span class="mockup-dot red"></span>
                                        <span class="mockup-dot yellow"></span>
                                        <span class="mockup-dot green"></span>
                                        <span class="small text-muted ms-2 font-monospace">https://general.skj.ac.th/Equipment</span>
                                    </div>
                                    <div class="mockup-window-body bg-light">
                                        <!-- Header Banner Mini -->
                                        <div class="bg-primary text-white p-2 rounded-3 mb-2 d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold" style="font-size: 0.8rem;">📦 ระบบยืม-คืนพัสดุอุปกรณ์</div>
                                                <small style="font-size: 0.65rem; opacity: 0.85;">ยืมอุปกรณ์โสตทัศนูปกรณ์ & เครื่องมือ</small>
                                            </div>
                                            <span class="badge bg-light text-primary" style="font-size: 0.65rem;">+ ยื่นคำขอ</span>
                                        </div>

                                        <!-- KPI 4 Mini Cards -->
                                        <div class="row g-1 mb-2 text-center">
                                            <div class="col-3">
                                                <div class="bg-white p-1 rounded border">
                                                    <div class="text-warning fw-bold" style="font-size: 0.75rem;">1</div>
                                                    <div class="text-muted" style="font-size: 0.6rem;">รออนุมัติ</div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="bg-white p-1 rounded border">
                                                    <div class="text-info fw-bold" style="font-size: 0.75rem;">2</div>
                                                    <div class="text-muted" style="font-size: 0.6rem;">อนุมัติแล้ว</div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="bg-white p-1 rounded border">
                                                    <div class="text-primary fw-bold" style="font-size: 0.75rem;">3</div>
                                                    <div class="text-muted" style="font-size: 0.6rem;">กำลังยืม</div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="bg-white p-1 rounded border">
                                                    <div class="text-success fw-bold" style="font-size: 0.75rem;">18</div>
                                                    <div class="text-muted" style="font-size: 0.6rem;">คืนแล้ว</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Catalog Item Card Mini -->
                                        <div class="bg-white p-2 rounded-3 border d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-label-primary p-2 rounded text-primary fw-bold" style="font-size: 1rem;">📽️</div>
                                                <div>
                                                    <div class="fw-bold text-dark" style="font-size: 0.75rem;">โปรเจคเตอร์ EPSON EB-X06</div>
                                                    <span class="badge bg-label-success" style="font-size: 0.6rem;">พร้อมยืม 4 เครื่อง</span>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-primary rounded-pill py-0 px-2" style="font-size: 0.65rem;">ขอยืม</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: กรอกแบบฟอร์ม & แคปช่า -->
            <div class="step-card">
                <div class="step-header d-flex align-items-center">
                    <div class="step-badge">2</div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">กรอกแบบฟอร์มยื่นคำขอยืมพัสดุ</h4>
                        <span class="flow-badge bg-label-info text-info">
                            <i class="bi bi-pencil-square"></i> หน้ายื่นคำขอ (/Equipment/Add)
                        </span>
                    </div>
                </div>
                <div class="step-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-card-checklist text-primary me-2"></i>ข้อมูลสำคัญในแบบฟอร์ม</h6>
                            <ol class="text-secondary ps-3 mb-3">
                                <li class="mb-2"><strong>ประเภทผู้ขอยืม:</strong> เลือก <em>"บุคลากรภายใน"</em> (ระบบเติมชื่อตำแหน่งให้อัตโนมัติ) หรือ <em>"บุคคล/หน่วยงานภายนอก"</em> (กรอกเลขบัตรประชาชน & เบอร์ติดต่อ)</li>
                                <li class="mb-2"><strong>กำหนดวันเวลา & สถานที่:</strong> เลือกวันที่ต้องการยืม วันที่กำหนดส่งคืน และสถานที่ใช้งาน</li>
                                <li class="mb-2"><strong>รายการพัสดุ:</strong> เพิ่มได้หลายรายการพร้อมกัน ระบุจำนวนและหน่วยนับได้อย่างยืดหยุ่น</li>
                                <li class="mb-2"><strong>แนบรูปภาพประกอบ:</strong> แนบรูปถ่ายสถานที่หรือเอกสารประกอบได้สูงสุด 5 รูป พร้อมระบบย่อขนาดภาพอัตโนมัติ</li>
                                <li class="mb-2"><strong>แคปช่ากันบอท (Math Captcha):</strong> คำนวณผลบวกตัวเลขเพื่อยืนยันความปลอดภัย</li>
                            </ol>
                        </div>

                        <!-- Mockup Screen: Form & Captcha -->
                        <div class="col-lg-6">
                            <div class="mockup-wrapper">
                                <div class="mockup-window">
                                    <div class="mockup-window-header">
                                        <span class="mockup-dot red"></span>
                                        <span class="mockup-dot yellow"></span>
                                        <span class="mockup-dot green"></span>
                                        <span class="small text-muted ms-2 font-monospace">https://general.skj.ac.th/Equipment/Add</span>
                                    </div>
                                    <div class="mockup-window-body bg-white">
                                        <div class="border rounded p-2 mb-2 bg-light">
                                            <div class="d-flex gap-2 mb-2">
                                                <div class="btn btn-sm btn-primary py-0 px-2 flex-fill" style="font-size: 0.7rem;"><i class="bi bi-person-fill"></i> บุคลากรภายใน</div>
                                                <div class="btn btn-sm btn-outline-secondary py-0 px-2 flex-fill" style="font-size: 0.7rem;"><i class="bi bi-building"></i> บุคคลภายนอก</div>
                                            </div>
                                            <div class="row g-1 mb-1">
                                                <div class="col-6"><input type="text" class="form-control form-control-sm" value="นายสมชาย ใจดี" readonly style="font-size: 0.7rem;"></div>
                                                <div class="col-6"><input type="text" class="form-control form-control-sm" value="กลุ่มสาระฯ วิทยาศาสตร์" readonly style="font-size: 0.7rem;"></div>
                                            </div>
                                        </div>

                                        <!-- Item Row Mock -->
                                        <div class="border rounded p-2 mb-2 bg-white">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="badge bg-primary rounded-circle p-1" style="font-size: 0.6rem;">1</span>
                                                <small class="text-success fw-bold" style="font-size: 0.65rem;">จำนวน: 2 เครื่อง</small>
                                            </div>
                                            <div class="fw-bold text-dark" style="font-size: 0.75rem;">ไมโครโฟนไร้สาย Wireless Mic</div>
                                        </div>

                                        <!-- Captcha Box Mock -->
                                        <div class="bg-label-primary p-2 rounded-3 text-center border border-primary border-opacity-25 mb-2">
                                            <small class="text-primary fw-bold d-block mb-1" style="font-size: 0.65rem;">🛡️ ระบบตรวจสอบความปลอดภัย</small>
                                            <div class="d-inline-flex align-items-center gap-2">
                                                <span class="badge bg-white text-primary border fw-bold" style="font-size: 0.8rem; letter-spacing: 1px;">5 + 3</span>
                                                <span class="fw-bold text-dark">=</span>
                                                <input type="text" class="form-control form-control-sm text-center fw-bold text-primary" value="8" style="width: 45px; height: 28px; font-size: 0.8rem;" readonly>
                                            </div>
                                        </div>

                                        <button class="btn btn-sm btn-primary w-100 rounded-pill py-1 fw-bold" style="font-size: 0.75rem;">
                                            <i class="bi bi-send me-1"></i> ยืนยันการส่งคำขอยืม
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: ติดตามสถานะ & พิมพ์ใบยืม A4 -->
            <div class="step-card">
                <div class="step-header d-flex align-items-center">
                    <div class="step-badge">3</div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">ติดตามสถานะคำขอ และพิมพ์ใบขอยืม A4</h4>
                        <span class="flow-badge bg-label-success text-success">
                            <i class="bi bi-clock-history"></i> หน้าประวัติคำขอ (/Equipment/History)
                        </span>
                    </div>
                </div>
                <div class="step-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-printer text-primary me-2"></i>การพิมพ์เอกสารใบยืม</h6>
                            <ul class="text-secondary ps-3 mb-3">
                                <li class="mb-2">สามารถค้นหาเลขคำขอยืม เช่น <code>EQ-256908-0001</code> เพื่อดูสถานะการอนุมัติ</li>
                                <li class="mb-2">แตะปุ่ม <strong>"พิมพ์ใบยืม"</strong> เพื่อเปิดเอกสารขนาด A4 มาตรฐาน</li>
                                <li class="mb-2">ระบบจัดหน้ากระดาษพอดี 1 หน้า ไม่ล้น พร้อมช่องลงนามของ <strong>หัวหน้างานอาคารสถานที่, รองผู้อำนวยการ, และผู้อำนวยการโรงเรียน</strong> โดยอัตโนมัติ</li>
                            </ul>
                        </div>

                        <!-- Mockup Screen: Print Preview A4 -->
                        <div class="col-lg-6">
                            <div class="mockup-wrapper">
                                <div class="mockup-window">
                                    <div class="mockup-window-header">
                                        <span class="mockup-dot red"></span>
                                        <span class="mockup-dot yellow"></span>
                                        <span class="mockup-dot green"></span>
                                        <span class="small text-muted ms-2 font-monospace">https://general.skj.ac.th/Equipment/Print/1</span>
                                    </div>
                                    <div class="mockup-window-body bg-white p-3 text-center border-top">
                                        <div class="border p-2 bg-white shadow-sm mx-auto" style="max-width: 280px; text-align: left; font-size: 0.6rem;">
                                            <div class="text-center fw-bold mb-1" style="font-size: 0.7rem;">แบบฟอร์มการขอยืมพัสดุอุปกรณ์</div>
                                            <div class="text-center text-muted mb-2" style="font-size: 0.55rem;">โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์</div>
                                            <div class="d-flex justify-content-between border-bottom pb-1 mb-1">
                                                <span>เลขที่: EQ-256908-0001</span>
                                                <span>วันที่: 20 ส.ค. 2569</span>
                                            </div>
                                            <div class="mb-1"><strong>ผู้ขอยืม:</strong> นายสมชาย ใจดี</div>
                                            <div class="mb-2"><strong>วัตถุประสงค์:</strong> ใช้จัดกิจกรรมค่ายดาราศาสตร์</div>
                                            
                                            <!-- Mini Signatures -->
                                            <div class="row g-1 text-center mt-2 pt-1 border-top" style="font-size: 0.5rem;">
                                                <div class="col-4 border-end">ลงชื่อ..................<br>(เจ้าหน้าที่พัสดุ)</div>
                                                <div class="col-4 border-end">ลงชื่อ..................<br>(รองผู้อำนวยการ)</div>
                                                <div class="col-4">ลงชื่อ..................<br>(ผู้อำนวยการ)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= TAB 2: เจ้าหน้าที่ ================= -->
        <div class="tab-pane fade" id="officer-flow" role="tabpanel">
            
            <!-- Officer Step 1: พอร์ทัลเจ้าหน้าที่ & การอนุมัติ -->
            <div class="step-card">
                <div class="step-header d-flex align-items-center">
                    <div class="step-badge">1</div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">พิจารณาอนุมัติคำขอยืม (1-Tap Approve)</h4>
                        <span class="flow-badge bg-label-warning text-dark">
                            <i class="bi bi-shield-lock"></i> พอร์ทัลเจ้าหน้าที่ (/Equipment/Approve)
                        </span>
                    </div>
                </div>
                <div class="step-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-check2-circle text-primary me-2"></i>การจัดการคำขอ</h6>
                            <ul class="text-secondary ps-3 mb-3">
                                <li class="mb-2">เมื่อล็อกอินด้วยบัญชีเจ้าหน้าที่ สามารถเข้าสู่เมนู <strong>"รายการอนุมัติ & รับ-ส่งคืน"</strong></li>
                                <li class="mb-2"><strong>ปุ่มอนุมัติ (สีเขียว):</strong> แตะเพื่ออนุมัติคำขอทันที</li>
                                <li class="mb-2"><strong>ปุ่มไม่อนุมัติ (สีแดง):</strong> แตะเพื่อปฏิเสธคำขอ พร้อมกล่องข้อความให้ระบุเหตุผลเพื่อแจ้งผู้ยืม</li>
                                <li class="mb-2"><strong>ปุ่มล้างรูปภาพขยะ (สีแดงบนแบนเนอร์):</strong> ตรวจสอบและลบรูปภาพที่ไม่มีอยู่ในฐานข้อมูลเพื่อประหยัดพื้นที่เซิร์ฟเวอร์</li>
                            </ul>
                        </div>

                        <!-- Mockup Screen: Staff Card Action -->
                        <div class="col-lg-6">
                            <div class="mockup-wrapper">
                                <div class="mockup-window">
                                    <div class="mockup-window-header">
                                        <span class="mockup-dot red"></span>
                                        <span class="mockup-dot yellow"></span>
                                        <span class="mockup-dot green"></span>
                                        <span class="small text-muted ms-2 font-monospace">Staff Portal - Approve</span>
                                    </div>
                                    <div class="mockup-window-body bg-light">
                                        <div class="bg-white p-2 rounded-3 border shadow-sm mb-2">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold text-primary font-monospace" style="font-size: 0.75rem;">EQ-256908-0001</span>
                                                <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">รออนุมัติ</span>
                                            </div>
                                            <div class="fw-bold text-dark" style="font-size: 0.75rem;">นายสมชาย ใจดี (วิทย์-คณิต)</div>
                                            <small class="text-muted d-block mb-2" style="font-size: 0.65rem;">ขอยืม: โปรเจคเตอร์ 1 เครื่อง, ไมค์ลอย 2 ตัว</small>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-success rounded-pill py-0 px-2 flex-fill" style="font-size: 0.65rem;"><i class="bi bi-check-lg"></i> อนุมัติ</button>
                                                <button class="btn btn-sm btn-outline-danger rounded-pill py-0 px-2 flex-fill" style="font-size: 0.65rem;"><i class="bi bi-x-lg"></i> ไม่อนุมัติ</button>
                                                <button class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2" style="font-size: 0.65rem;"><i class="bi bi-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Officer Step 2: บันทึกจ่ายของ & รับคืน พร้อมถ่ายรูปหลักฐาน -->
            <div class="step-card">
                <div class="step-header d-flex align-items-center">
                    <div class="step-badge">2</div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">บันทึกส่งมอบ (จ่ายของ) & ตรวจรับคืน พร้อมภาพถ่ายหลักฐาน</h4>
                        <span class="flow-badge bg-label-info text-info">
                            <i class="bi bi-camera-fill"></i> ระบบบันทึกภาพถ่ายหลักฐาน (Photo Proofs)
                        </span>
                    </div>
                </div>
                <div class="step-body">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-check text-primary me-2"></i>กระบวนการตัดและคืนสต็อกอัตโนมัติ</h6>
                            <ol class="text-secondary ps-3 mb-3">
                                <li class="mb-2"><strong>ตอนจ่ายของ (Pickup):</strong> ถ่ายภาพผู้รับมอบหรือสภาพอุปกรณ์ (สูงสุด 5 รูป) -> <em>ระบบจะตัดสต็อกคงเหลือทันที</em></li>
                                <li class="mb-2"><strong>ตอนรับคืน (Return):</strong> ตรวจนับสภาพ (ปกติ/ชำรุด/สูญหาย) พร้อมถ่ายภาพตอนคืน (สูงสุด 5 รูป) -> <em>ระบบจะคืนจำนวนเข้าสต็อกทันที</em></li>
                                <li class="mb-2">ภาพถ่ายทั้งหมดจะถูกแสดงผลในหน้ารายละเอียดคำขอ และสามารถแตะเพื่อดูภาพขนาดเต็มได้</li>
                            </ol>
                        </div>

                        <!-- Mockup Screen: Photo Upload & Modal -->
                        <div class="col-lg-6">
                            <div class="mockup-wrapper">
                                <div class="mockup-window">
                                    <div class="mockup-window-header">
                                        <span class="mockup-dot red"></span>
                                        <span class="mockup-dot yellow"></span>
                                        <span class="mockup-dot green"></span>
                                        <span class="small text-muted ms-2 font-monospace">Modal: บันทึกส่งมอบ & ภาพถ่าย</span>
                                    </div>
                                    <div class="mockup-window-body bg-white text-center">
                                        <div class="border border-2 border-dashed rounded-3 p-2 bg-light mb-2">
                                            <i class="bi bi-camera text-primary" style="font-size: 1.5rem;"></i>
                                            <div class="fw-bold text-dark" style="font-size: 0.7rem;">ถ่ายภาพหลักฐานตอนส่งมอบ</div>
                                            <small class="text-muted" style="font-size: 0.6rem;">รองรับการถ่ายจากกล้องมือถือ (1-5 รูป)</small>
                                        </div>
                                        <div class="d-flex justify-content-center gap-1 mb-2">
                                            <div class="border rounded p-1 bg-light" style="width: 45px; height: 45px;"><i class="bi bi-image text-muted"></i></div>
                                            <div class="border rounded p-1 bg-light" style="width: 45px; height: 45px;"><i class="bi bi-image text-muted"></i></div>
                                            <div class="border rounded p-1 bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="bi bi-plus text-primary"></i></div>
                                        </div>
                                        <button class="btn btn-sm btn-primary rounded-pill w-100 py-1" style="font-size: 0.7rem;">
                                            <i class="bi bi-box-arrow-right me-1"></i> ยืนยันจ่ายของ & ตัดสต็อก
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= TAB 3: วงจรสถานะ & เอกสาร ================= -->
        <div class="tab-pane fade" id="status-flow" role="tabpanel">
            
            <div class="step-card">
                <div class="step-header">
                    <h4 class="fw-bold text-dark mb-0"><i class="bi bi-diagram-3-fill text-primary me-2"></i>วงจรสถานะของคำขอยืมพัสดุ (Lifecycle Flow)</h4>
                </div>
                <div class="step-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 190px;">สถานะ</th>
                                    <th>ความหมาย</th>
                                    <th>การดำเนินการถัดไป</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="status-pill-demo bg-warning text-dark"><i class="bi bi-clock me-1"></i> รอพิจารณาอนุมัติ</span></td>
                                    <td>ผู้ขอยื่นคำขอเข้ามาในระบบเรียบร้อยแล้ว อยู่ระหว่างรอเจ้าหน้าที่ตรวจสอบ</td>
                                    <td>เจ้าหน้าที่กดอนุมัติ หรือไม่อนุมัติ (ผู้ขอยืมยังสามารถยกเลิกคำขอได้)</td>
                                </tr>
                                <tr>
                                    <td><span class="status-pill-demo bg-info text-white"><i class="bi bi-check-circle me-1"></i> อนุมัติแล้ว</span></td>
                                    <td>คำขอผ่านการอนุมัติแล้ว รอผู้ยืมติดต่อรับของ</td>
                                    <td>ผู้ยืมติดต่อรับของ ณ จุดจ่ายพัสดุ เจ้าหน้าที่ถ่ายภาพและบันทึกจ่ายของ</td>
                                </tr>
                                <tr>
                                    <td><span class="status-pill-demo bg-primary text-white"><i class="bi bi-box-seam me-1"></i> กำลังยืมใช้งาน</span></td>
                                    <td>ผู้ยืมได้รับพัสดุไปใช้งานแล้ว (สต็อกถูกตัดลดลงแล้ว)</td>
                                    <td>ผู้ยืมนำพัสดุมาส่งคืนภายในกำหนด เจ้าหน้าที่ตรวจรับและถ่ายภาพ</td>
                                </tr>
                                <tr>
                                    <td><span class="status-pill-demo bg-success text-white"><i class="bi bi-check2-all me-1"></i> คืนเรียบร้อยแล้ว</span></td>
                                    <td>ส่งคืนพัสดุเรียบร้อย สต็อกถูกคืนกลับเข้าสู่ระบบเสร็จสมบูรณ์</td>
                                    <td>สิ้นสุดกระบวนการยืม-คืน (เอกสารและภาพถ่ายถูกเก็บเป็นประวัติ)</td>
                                </tr>
                                <tr>
                                    <td><span class="status-pill-demo bg-danger text-white"><i class="bi bi-x-lg me-1"></i> ไม่อนุมัติ</span></td>
                                    <td>เจ้าหน้าที่ไม่อนุมัติคำขอ พร้อมระบุเหตุผลประกอบ</td>
                                    <td>ผู้ขอยืมตรวจสอบเหตุผลในหน้ารายละเอียดคำขอ</td>
                                </tr>
                                <tr>
                                    <td><span class="status-pill-demo bg-secondary text-white"><i class="bi bi-slash-circle me-1"></i> ยกเลิกแล้ว</span></td>
                                    <td>ผู้ขอยืมกดยกเลิกคำขอด้วยตนเอง</td>
                                    <td>สิ้นสุดรายการ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bottom Help Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mt-4 text-center bg-light">
        <h5 class="fw-bold text-dark mb-2">พร้อมใช้งานระบบยืม-คืนพัสดุอุปกรณ์แล้วหรือยัง?</h5>
        <p class="text-muted small mb-3">สามารถเริ่มต้นยื่นคำขอยืม หรือเข้าสู่หน้าหลักของระบบได้ทันที</p>
        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="<?= base_url('Equipment/Add') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> ยื่นคำขอยืมพัสดุ
            </a>
            <a href="<?= base_url('Equipment') ?>" class="btn btn-outline-primary rounded-pill px-4">
                <i class="bi bi-box-seam me-1"></i> หน้าหลักพัสดุอุปกรณ์
            </a>
            <a href="<?= base_url('manual') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-book me-1"></i> ดูคู่มือระบบอื่นทั้งหมด
            </a>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
