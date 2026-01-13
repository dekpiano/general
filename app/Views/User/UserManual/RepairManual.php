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
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 0.75rem;
        color: #ffffff;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .hero-subtitle {
        font-size: 1.1rem;
        color: #ffffff;
        max-width: 600px;
        text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
    }

    /* Override breadcrumb colors in hero */
    .manual-hero .breadcrumb-item a {
        color: rgba(255,255,255,0.8) !important;
    }

    .manual-hero .breadcrumb-item.active {
        color: #ffffff !important;
    }

    .manual-hero .breadcrumb-item::before {
        color: rgba(255,255,255,0.6) !important;
    }

    /* Global text improvements */
    .text-muted {
        color: #697a8d !important;
    }

    p.text-muted {
        color: #566a7f !important;
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
        padding: 12px 28px;
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
        overflow: hidden;
        transition: all 0.4s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    }

    .step-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(105, 108, 255, 0.12);
    }

    .step-header {
        background: linear-gradient(135deg, rgba(105, 108, 255, 0.08) 0%, rgba(105, 108, 255, 0.02) 100%);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--glass-border);
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: var(--manual-gradient);
        color: #fff;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.3rem;
        box-shadow: 0 8px 20px rgba(105, 108, 255, 0.35);
    }

    .step-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #32475c;
        margin-bottom: 4px;
    }

    .step-subtitle {
        color: #566a7f;
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    /* Override bootstrap text colors for better contrast */
    .step-body .text-muted {
        color: #697a8d !important;
    }

    .step-body .text-secondary {
        color: #566a7f !important;
    }

    .features-list strong {
        color: #32475c;
    }

    .features-list small.text-muted {
        color: #697a8d !important;
    }

    ol.text-secondary li,
    ol.text-secondary {
        color: #566a7f !important;
    }

    .tips-box .text-muted {
        color: #566a7f !important;
    }

    /* Additional text contrast improvements */
    small {
        color: #697a8d;
    }

    small.text-muted {
        color: #697a8d !important;
    }

    .accordion-body {
        color: #566a7f !important;
    }

    /* Admin feature card text */
    .admin-feature-card p {
        color: #697a8d !important;
    }

    .admin-feature-card h5 {
        color: #32475c;
    }

    /* Mockup text visibility */
    .mockup-card-body .text-muted {
        color: #697a8d !important;
    }

    /* Badge and label text */
    .badge {
        font-weight: 600;
    }

    /* FAQ title */
    .faq-title {
        color: #32475c !important;
    }

    .step-body {
        padding: 2rem;
    }

    /* Mockup Cards within Steps */
    .mockup-wrapper {
        background: #f8faff;
        border-radius: 16px;
        padding: 2rem;
        border: 2px dashed rgba(105, 108, 255, 0.15);
        position: relative;
    }

    .mockup-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
    }

    .mockup-card-header {
        background: var(--manual-gradient);
        padding: 12px 16px;
        color: #fff;
    }

    .mockup-card-body {
        padding: 16px;
    }

    /* Features List */
    .features-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .features-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px dashed rgba(0,0,0,0.06);
    }

    .features-list li:last-child {
        border-bottom: none;
    }

    .feature-icon {
        width: 32px;
        height: 32px;
        min-width: 32px;
        background: rgba(113, 221, 55, 0.15);
        color: #71dd37;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .feature-icon.warning {
        background: rgba(255, 171, 0, 0.15);
        color: #ffab00;
    }

    .feature-icon.info {
        background: rgba(3, 195, 236, 0.15);
        color: #03c3ec;
    }

    .feature-icon.primary {
        background: rgba(105, 108, 255, 0.15);
        color: #696cff;
    }

    /* FAQ Accordion */
    .faq-section {
        background: var(--glass-bg);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid var(--glass-border);
    }

    .accordion-premium .accordion-item {
        border: none;
        background: transparent;
        margin-bottom: 12px;
    }

    .accordion-premium .accordion-button {
        background: #f8faff;
        border-radius: 12px !important;
        font-weight: 600;
        color: #32475c;
        padding: 16px 20px;
        box-shadow: none;
    }

    .accordion-premium .accordion-button:not(.collapsed) {
        background: rgba(105, 108, 255, 0.1);
        color: var(--manual-primary);
    }

    .accordion-premium .accordion-button::after {
        background-size: 14px;
    }

    /* Admin Cards */
    .admin-feature-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 16px;
        padding: 1.5rem;
        height: 100%;
        transition: all 0.3s ease;
    }

    .admin-feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(105, 108, 255, 0.1);
    }

    .admin-icon-box {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-in {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Tips Box */
    .tips-box {
        background: linear-gradient(135deg, rgba(255, 171, 0, 0.1) 0%, rgba(255, 171, 0, 0.05) 100%);
        border: 1px solid rgba(255, 171, 0, 0.2);
        border-radius: 12px;
        padding: 16px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .tips-box.success {
        background: linear-gradient(135deg, rgba(113, 221, 55, 0.1) 0%, rgba(113, 221, 55, 0.05) 100%);
        border-color: rgba(113, 221, 55, 0.2);
    }

    .tips-box i {
        font-size: 1.5rem;
        color: #ffab00;
    }

    .tips-box.success i {
        color: #71dd37;
    }

    /* Status Flow */
    .status-flow {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .status-flow .arrow {
        color: #a1acb8;
        font-size: 1.5rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Hero Section -->
    <div class="manual-hero animate-in">
        <div class="hero-content">
            <div class="d-flex align-items-center mb-3">
                <i class='bx bxs-wrench fs-2 me-2'></i>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('manual') ?>" class="text-white-50">คู่มือ</a></li>
                        <li class="breadcrumb-item active text-white">ระบบแจ้งซ่อม</li>
                    </ol>
                </nav>
            </div>
            <h1 class="hero-title">คู่มือระบบแจ้งซ่อมออนไลน์</h1>
            <p class="hero-subtitle">เรียนรู้วิธีการแจ้งปัญหา ติดตามสถานะ และระบบจัดการงานซ่อมบำรุงภายในโรงเรียน</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-6 col-md-8">
            <ul class="nav nav-manual nav-fill" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#user-manual" type="button">
                        <i class="bx bx-user me-1"></i> สำหรับผู้แจ้ง
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#admin-manual" type="button">
                        <i class="bx bx-wrench me-1"></i> สำหรับช่าง/ผู้ดูแล
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        
        <!-- User Manual -->
        <div class="tab-pane fade show active" id="user-manual">
            <div class="row g-4">
                
                <!-- Step 1: เข้าสู่หน้าแจ้งซ่อม -->
                <div class="col-12 animate-in" style="animation-delay: 0.1s">
                    <div class="step-card">
                        <div class="step-header d-flex align-items-center gap-3">
                            <div class="step-number">1</div>
                            <div>
                                <h4 class="step-title">เข้าสู่หน้าระบบแจ้งซ่อม</h4>
                                <p class="step-subtitle">ตรวจสอบประวัติการแจ้งซ่อมและสถิติ</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-navigation me-2 text-primary'></i>วิธีเข้าถึงหน้าแจ้งซ่อม</h6>
                                    <ol class="ps-3 text-secondary">
                                        <li class="mb-2">ไปที่เมนู <strong class="text-dark">"แจ้งซ่อมออนไลน์"</strong> ในแถบเมนูหลัก</li>
                                        <li class="mb-2">ระบบจะแสดง <strong class="text-primary">สถิติงานซ่อม</strong> แบบ Real-time</li>
                                        <li class="mb-2">ดูรายการแจ้งซ่อมทั้งหมดในตารางด้านล่าง</li>
                                        <li class="mb-2">สามารถกรองดูตาม <strong class="text-success">ปีงบประมาณ</strong> ได้</li>
                                    </ol>

                                    <ul class="features-list mt-4">
                                        <li>
                                            <div class="feature-icon primary"><i class='bx bx-briefcase-alt-2'></i></div>
                                            <div>
                                                <strong class="d-block">งานทั้งหมด</strong>
                                                <small class="text-muted">จำนวนรายการแจ้งซ่อมทั้งหมดในปี</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon warning"><i class='bx bx-time-five'></i></div>
                                            <div>
                                                <strong class="d-block">รอดำเนินการ</strong>
                                                <small class="text-muted">รายการที่ยังไม่มีช่างรับงาน</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon info"><i class='bx bx-cog'></i></div>
                                            <div>
                                                <strong class="d-block">กำลังดำเนินการ</strong>
                                                <small class="text-muted">ช่างกำลังซ่อมอยู่</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-check-circle'></i></div>
                                            <div>
                                                <strong class="d-block">เสร็จสิ้นแล้ว</strong>
                                                <small class="text-muted">ซ่อมเสร็จเรียบร้อย</small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: Stats Cards -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <div class="bg-white rounded-3 p-3 shadow-sm d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-3 p-2 me-2">
                                                        <i class='bx bxs-briefcase-alt-2 text-primary'></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-muted" style="font-size: 10px;">งานทั้งหมด</div>
                                                        <div class="fw-bold">150</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-white rounded-3 p-3 shadow-sm d-flex align-items-center">
                                                    <div class="bg-warning bg-opacity-10 rounded-3 p-2 me-2">
                                                        <i class='bx bxs-time-five text-warning'></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-muted" style="font-size: 10px;">รอดำเนินการ</div>
                                                        <div class="fw-bold">12</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-white rounded-3 p-3 shadow-sm d-flex align-items-center">
                                                    <div class="bg-info bg-opacity-10 rounded-3 p-2 me-2">
                                                        <i class='bx bxs-cog text-info'></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-muted" style="font-size: 10px;">กำลังดำเนินการ</div>
                                                        <div class="fw-bold">8</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-white rounded-3 p-3 shadow-sm d-flex align-items-center">
                                                    <div class="bg-success bg-opacity-10 rounded-3 p-2 me-2">
                                                        <i class='bx bxs-check-circle text-success'></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-muted" style="font-size: 10px;">เสร็จสิ้นแล้ว</div>
                                                        <div class="fw-bold">130</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="bg-primary text-white rounded-pill px-4 py-2 d-inline-block shadow-sm" style="font-size: 12px;">
                                                <i class='bx bx-plus-circle me-1'></i> แจ้งซ่อมใหม่
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: กรอกรายละเอียด -->
                <div class="col-12 animate-in" style="animation-delay: 0.2s">
                    <div class="step-card">
                        <div class="step-header d-flex align-items-center gap-3">
                            <div class="step-number">2</div>
                            <div>
                                <h4 class="step-title">กรอกรายละเอียดปัญหา</h4>
                                <p class="step-subtitle">กดปุ่ม "แจ้งซ่อมใหม่" และกรอกข้อมูลตามขั้นตอน</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6 order-lg-2">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-edit me-2 text-primary'></i>ข้อมูลที่ต้องกรอก (4 ขั้นตอน)</h6>
                                    
                                    <ul class="features-list">
                                        <li>
                                            <div class="feature-icon primary"><i class='bx bx-wrench'></i></div>
                                            <div>
                                                <strong class="d-block">ขั้นตอนที่ 1: แจ้งปัญหา</strong>
                                                <small class="text-muted">เลือกประเภทงานซ่อม (คอมพิวเตอร์, ปริ้นเตอร์, ระบบเครือข่าย, โสตฯ, อาคารฯ) และอธิบายอาการเสีย</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon warning"><i class='bx bx-map'></i></div>
                                            <div>
                                                <strong class="d-block">ขั้นตอนที่ 2: ระบุสถานที่</strong>
                                                <small class="text-muted">เลือกอาคาร, ชั้น และเลขห้อง</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon info"><i class='bx bx-user'></i></div>
                                            <div>
                                                <strong class="d-block">ขั้นตอนที่ 3: ข้อมูลผู้แจ้ง</strong>
                                                <small class="text-muted">เลือกตำแหน่ง, รายชื่อ และเบอร์ติดต่อ</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-camera'></i></div>
                                            <div>
                                                <strong class="d-block">ขั้นตอนที่ 4: หลักฐาน</strong>
                                                <small class="text-muted">แนบรูปภาพประกอบ + ลายเซ็นผู้แจ้ง + ตอบคำถามป้องกัน Bot</small>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="tips-box mt-4">
                                        <i class='bx bxs-camera'></i>
                                        <div>
                                            <strong class="d-block mb-1">สำคัญ: แนบรูปภาพ</strong>
                                            <span class="text-muted small">การแนบรูปภาพปัญหาจะช่วยให้ช่างเข้าใจและเตรียมอุปกรณ์ได้ถูกต้อง</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 order-lg-1">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: Repair Form Stepper -->
                                        <div class="mockup-card mx-auto" style="max-width: 340px; transform: rotate(2deg);">
                                            <div class="mockup-card-header">
                                                <i class='bx bxs-wrench me-1'></i> บันทึกข้อมูลแจ้งซ่อม
                                            </div>
                                            <div class="mockup-card-body">
                                                <!-- Stepper -->
                                                <div class="d-flex justify-content-between mb-3">
                                                    <div class="text-center">
                                                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 11px;">1</div>
                                                        <div class="text-muted mt-1" style="font-size: 9px;">แจ้งปัญหา</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 11px;">2</div>
                                                        <div class="text-muted mt-1" style="font-size: 9px;">ระบุสถานที่</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 11px;">3</div>
                                                        <div class="text-muted mt-1" style="font-size: 9px;">ข้อมูลผู้แจ้ง</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 11px;"><i class='bx bx-check'></i></div>
                                                        <div class="text-muted mt-1" style="font-size: 9px;">หลักฐาน</div>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="text-muted small mb-1" style="font-size: 10px;">ประเภทงานซ่อม *</div>
                                                    <div class="border rounded p-2 bg-light" style="font-size: 11px;">คอมพิวเตอร์/โปรเจคเตอร์</div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="text-muted small mb-1" style="font-size: 10px;">รายละเอียดอาการเสีย *</div>
                                                    <div class="border rounded p-2 bg-light" style="font-size: 11px;">คอมพิวเตอร์เปิดไม่ติด...</div>
                                                </div>
                                                <div class="border-2 border-dashed rounded p-2 text-center bg-primary bg-opacity-10 mb-2">
                                                    <i class='bx bx-camera text-primary'></i>
                                                    <div class="text-primary small" style="font-size: 10px;">แนบรูปภาพประกอบ</div>
                                                </div>
                                                <div class="bg-primary rounded-2 text-white text-center p-2 mt-3" style="font-size: 12px;">
                                                    <i class='bx bx-paper-plane me-1'></i> บันทึกแจ้งซ่อม
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: ติดตามสถานะ -->
                <div class="col-12 animate-in" style="animation-delay: 0.3s">
                    <div class="step-card">
                        <div class="step-header d-flex align-items-center gap-3">
                            <div class="step-number">3</div>
                            <div>
                                <h4 class="step-title">ติดตามสถานะงานซ่อม</h4>
                                <p class="step-subtitle">รอรับการแก้ไขและติดตามสถานะแบบ Real-time</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-loader-circle me-2 text-primary'></i>ขั้นตอนการดำเนินงาน</h6>
                                    <p class="text-muted">เมื่อส่งคำขอแล้ว งานซ่อมจะเข้าสู่กระบวนการดังต่อไปนี้:</p>

                                    <!-- Status Flow Visual -->
                                    <div class="status-flow my-4">
                                        <span class="badge bg-warning px-3 py-2">รอรับงาน</span>
                                        <i class='bx bx-right-arrow-alt arrow'></i>
                                        <span class="badge bg-info px-3 py-2">กำลังดำเนินการ</span>
                                        <i class='bx bx-right-arrow-alt arrow'></i>
                                        <span class="badge bg-success px-3 py-2">ซ่อมสำเร็จ</span>
                                    </div>

                                    <ul class="features-list">
                                        <li>
                                            <div class="feature-icon warning"><i class='bx bx-hourglass'></i></div>
                                            <div>
                                                <strong class="d-block">รอรับงาน</strong>
                                                <small class="text-muted">ช่างยังไม่ได้รับคำขอของคุณ</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon info"><i class='bx bx-loader-alt'></i></div>
                                            <div>
                                                <strong class="d-block">กำลังดำเนินการ</strong>
                                                <small class="text-muted">ช่างกำลังซ่อมอุปกรณ์ของคุณ</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-check-double'></i></div>
                                            <div>
                                                <strong class="d-block">ซ่อมสำเร็จ</strong>
                                                <small class="text-muted">ซ่อมเสร็จเรียบร้อย พร้อมรายละเอียดการแก้ไข</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon" style="background: rgba(255, 62, 29, 0.15); color: #ff3e1d;"><i class='bx bx-x'></i></div>
                                            <div>
                                                <strong class="d-block">ซ่อมไม่ได้</strong>
                                                <small class="text-muted">กรณีอุปกรณ์เสียหายเกินซ่อม พร้อมเหตุผล</small>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="tips-box success mt-4">
                                        <i class='bx bxs-file-pdf'></i>
                                        <div>
                                            <strong class="d-block mb-1">พิมพ์ใบแจ้งซ่อม</strong>
                                            <span class="text-muted small">สามารถพิมพ์ใบแจ้งซ่อมเป็น PDF เพื่อเก็บเป็นหลักฐานได้</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: Status Progress -->
                                        <div class="mockup-card mx-auto" style="max-width: 300px;">
                                            <div class="mockup-card-header bg-info">
                                                <i class='bx bx-cog bx-spin me-1'></i> สถานะงานซ่อม
                                            </div>
                                            <div class="mockup-card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="bg-info text-white rounded p-1 me-2">
                                                        <i class='bx bx-loader-circle'></i>
                                                    </div>
                                                    <div class="fw-bold small">กำลังดำเนินการ</div>
                                                </div>
                                                <div class="progress mb-3" style="height: 8px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 60%"></div>
                                                </div>
                                                <div class="p-2 bg-light rounded-3 mb-3">
                                                    <div class="text-muted small mb-1" style="font-size: 10px;">รายละเอียดงาน</div>
                                                    <div style="font-size: 11px;"><strong>คอมพิวเตอร์เปิดไม่ติด</strong></div>
                                                    <div class="text-muted" style="font-size: 10px;">อาคาร 1 ชั้น 4 ห้อง 421</div>
                                                </div>
                                                <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 10px;">
                                                    <i class='bx bx-user-circle fs-5'></i>
                                                    <div>
                                                        <div>ช่าง: นายสมชาย ซ่อมเก่ง</div>
                                                        <div>รับงาน: 10 ม.ค. 68 14:30</div>
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

            </div>
        </div>

        <!-- Admin Manual -->
        <div class="tab-pane fade" id="admin-manual">
            <div class="row g-4 mb-4">
                <div class="col-lg-5 text-center">
                    <img src="<?= base_url('assets/img/illustrations/man-with-laptop-light.png') ?>" alt="Admin" class="img-fluid mb-3" style="max-height: 220px;">
                    <h4 class="fw-bold text-primary">สำหรับช่างและผู้ดูแลระบบ</h4>
                    <p class="text-muted">รับงาน ดำเนินการซ่อม และปิดงานอย่างเป็นระบบ</p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-warning text-warning">
                                    <i class='bx bx-hard-hat'></i>
                                </div>
                                <h5 class="fw-bold mb-2">รับงานซ่อม</h5>
                                <p class="text-muted small mb-0">ตรวจสอบรายการแจ้งซ่อมใหม่ ดูรายละเอียดและรูปภาพปัญหา จากนั้นกด "รับงาน" เพื่อเริ่มดำเนินการ</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-info text-info">
                                    <i class='bx bx-cog'></i>
                                </div>
                                <h5 class="fw-bold mb-2">ดำเนินการซ่อม</h5>
                                <p class="text-muted small mb-0">เปลี่ยนสถานะเป็น "กำลังดำเนินการ" เพื่อแจ้งให้ผู้ใช้ทราบว่ากำลังซ่อมอยู่</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-success text-success">
                                    <i class='bx bx-check-double'></i>
                                </div>
                                <h5 class="fw-bold mb-2">ปิดงานซ่อม</h5>
                                <p class="text-muted small mb-0">บันทึกผลการซ่อมแซม ค่าใช้จ่าย หรือเปลี่ยนอะไหล่ และเปลี่ยนสถานะเป็น "ซ่อมสำเร็จ"</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-danger text-danger">
                                    <i class='bx bx-x-circle'></i>
                                </div>
                                <h5 class="fw-bold mb-2">แจ้งซ่อมไม่ได้</h5>
                                <p class="text-muted small mb-0">กรณีอุปกรณ์เสียหายเกินซ่อม สามารถบันทึกเหตุผลและเปลี่ยนสถานะเป็น "ซ่อมไม่ได้"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How to Access Admin -->
            <div class="step-card">
                <div class="step-header d-flex align-items-center gap-3">
                    <div class="step-number"><i class='bx bx-shield'></i></div>
                    <div>
                        <h4 class="step-title">วิธีจัดการงานซ่อมในระบบ</h4>
                        <p class="step-subtitle">เฉพาะเจ้าหน้าที่ช่างและผู้ดูแลอาคารสถานที่</p>
                    </div>
                </div>
                <div class="step-body">
                    <ol class="ps-3 text-secondary">
                        <li class="mb-2">ไปที่หน้า <strong class="text-dark">"แจ้งซ่อมออนไลน์"</strong></li>
                        <li class="mb-2">ดูรายการที่สถานะ <span class="badge bg-warning">รอรับงาน</span></li>
                        <li class="mb-2">กดปุ่ม <strong class="text-primary">"รับงาน"</strong> ที่รายการที่ต้องการ</li>
                        <li class="mb-2">เมื่อซ่อมเสร็จ กดปุ่ม <strong class="text-success">"ปิดงาน"</strong> และบันทึกรายละเอียด</li>
                        <li class="mb-0">ระบบจะอัพเดทสถิติและแจ้งผู้แจ้งซ่อมอัตโนมัติ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section mt-5">
        <h4 class="faq-title">
            <i class='bx bx-help-circle fs-3'></i>
            คำถามที่พบบ่อย (FAQ)
        </h4>
        <div class="accordion accordion-premium" id="accordionFAQ">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        <i class='bx bx-question-mark me-2'></i> ถ้าซ่อมไม่ได้ต้องทำอย่างไร?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        หากอุปกรณ์เสียหายจนไม่สามารถซ่อมได้ เจ้าหน้าที่จะทำเรื่องจำหน่ายออก หรือเสนอจัดซื้อทดแทนตามระเบียบพัสดุครับ
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        <i class='bx bx-question-mark me-2'></i> ใช้เวลาซ่อมนานเท่าไหร่?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        ขึ้นอยู่กับลักษณะปัญหาครับ งานซ่อมทั่วไปใช้เวลา 1-3 วันทำการ กรณีต้องสั่งอะไหล่อาจใช้เวลานานกว่านั้น
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        <i class='bx bx-question-mark me-2'></i> สามารถติดตามสถานะงานซ่อมได้อย่างไร?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        สามารถดูสถานะได้ที่หน้า "แจ้งซ่อมออนไลน์" โดยระบบจะแสดงสถานะล่าสุดของแต่ละรายการครับ
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        <i class='bx bx-question-mark me-2'></i> จำเป็นต้องแนบรูปภาพหรือไม่?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        แนะนำให้แนบครับ เพราะจะช่วยให้ช่างเข้าใจปัญหาได้ชัดเจน และเตรียมอุปกรณ์มาซ่อมได้ถูกต้อง
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
    // Animate elements on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.step-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s cubic-bezier(0.16, 1, 0.3, 1)';
        observer.observe(el);
    });
</script>
<?= $this->endSection() ?>
