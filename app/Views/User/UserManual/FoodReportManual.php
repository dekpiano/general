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

    /* Meal Badge Colors */
    .meal-badge-morning { background: rgba(217, 119, 6, 0.15); color: #d97706; }
    .meal-badge-lunch { background: rgba(37, 99, 235, 0.15); color: #2563eb; }
    .meal-badge-dinner { background: rgba(220, 38, 38, 0.15); color: #dc2626; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Hero Section -->
    <div class="manual-hero animate-in">
        <div class="hero-content">
            <div class="d-flex align-items-center mb-3">
                <i class='bx bxs-dish fs-2 me-2'></i>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('manual') ?>" class="text-white-50">คู่มือ</a></li>
                        <li class="breadcrumb-item active text-white">ระบบรายงานอาหาร</li>
                    </ol>
                </nav>
            </div>
            <h1 class="hero-title">คู่มือระบบรายงานอาหารโรงเรียน</h1>
            <p class="hero-subtitle">เรียนรู้วิธีการบันทึกข้อมูลอาหาร อัปโหลดรูปภาพ และพิมพ์รายงานประจำวัน</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-6 col-md-8">
            <ul class="nav nav-manual nav-fill" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#user-manual" type="button">
                        <i class="bx bx-user me-1"></i> สำหรับผู้รายงาน
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#admin-manual" type="button">
                        <i class="bx bx-shield-quarter me-1"></i> สำหรับผู้ดูแล
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
                
                <!-- Step 1: เข้าสู่หน้าระบบ -->
                <div class="col-12 animate-in" style="animation-delay: 0.1s">
                    <div class="step-card">
                        <div class="step-header d-flex align-items-center gap-3">
                            <div class="step-number">1</div>
                            <div>
                                <h4 class="step-title">เข้าสู่ระบบรายงานอาหาร</h4>
                                <p class="step-subtitle">ดูสถิติรายงานและรายการอาหารที่บันทึกไว้</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-navigation me-2 text-primary'></i>วิธีเข้าถึงหน้ารายงาน</h6>
                                    <ol class="ps-3 text-secondary">
                                        <li class="mb-2">ไปที่เมนู <strong class="text-dark">"รายงานอาหาร"</strong> หรือคลิกที่ลิงก์ <strong>FoodReport</strong></li>
                                        <li class="mb-2">ระบบจะแสดง <strong class="text-primary">สถิติรายงาน</strong> ประจำปีการศึกษา</li>
                                        <li class="mb-2">สามารถเลือก <strong class="text-success">ปีการศึกษา</strong> จากดรอปดาวน์ได้</li>
                                        <li class="mb-2">กดปุ่ม <strong class="text-primary">"เพิ่มรายงาน"</strong> เพื่อบันทึกอาหารใหม่</li>
                                    </ol>

                                    <ul class="features-list mt-4">
                                        <li>
                                            <div class="feature-icon primary"><i class='bx bx-file-find'></i></div>
                                            <div>
                                                <strong class="d-block">รายงานทั้งหมด</strong>
                                                <small class="text-muted">จำนวนฉบับที่บันทึกในปี</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon warning"><i class='bx bx-coffee-togo'></i></div>
                                            <div>
                                                <strong class="d-block">มื้อเช้า</strong>
                                                <small class="text-muted">จำนวนวันที่บันทึกมื้อเช้า</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon info"><i class='bx bx-bowl-hot'></i></div>
                                            <div>
                                                <strong class="d-block">มื้อกลางวัน</strong>
                                                <small class="text-muted">จำนวนวันที่บันทึกมื้อกลางวัน</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon" style="background: rgba(220, 38, 38, 0.15); color: #dc2626;"><i class='bx bx-moon'></i></div>
                                            <div>
                                                <strong class="d-block">มื้อเย็น</strong>
                                                <small class="text-muted">จำนวนวันที่บันทึกมื้อเย็น</small>
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
                                                        <i class='bx bxs-file-find text-primary'></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-muted" style="font-size: 10px;">รายงานทั้งหมด</div>
                                                        <div class="fw-bold">75 <small class="fw-normal">ฉบับ</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-white rounded-3 p-3 shadow-sm d-flex align-items-center">
                                                    <div class="bg-warning bg-opacity-10 rounded-3 p-2 me-2">
                                                        <i class='bx bxs-coffee-togo text-warning'></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-muted" style="font-size: 10px;">มื้อเช้า</div>
                                                        <div class="fw-bold">25 <small class="fw-normal">วัน</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-white rounded-3 p-3 shadow-sm d-flex align-items-center">
                                                    <div class="bg-info bg-opacity-10 rounded-3 p-2 me-2">
                                                        <i class='bx bxs-bowl-hot text-info'></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-muted" style="font-size: 10px;">มื้อกลางวัน</div>
                                                        <div class="fw-bold">30 <small class="fw-normal">วัน</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="bg-white rounded-3 p-3 shadow-sm d-flex align-items-center">
                                                    <div class="bg-danger bg-opacity-10 rounded-3 p-2 me-2">
                                                        <i class='bx bxs-moon text-danger'></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-muted" style="font-size: 10px;">มื้อเย็น</div>
                                                        <div class="fw-bold">20 <small class="fw-normal">วัน</small></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="bg-primary text-white rounded-pill px-4 py-2 d-inline-block shadow-sm" style="font-size: 12px;">
                                                <i class='bx bx-plus-circle me-1'></i> เพิ่มรายงาน
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
                                <h4 class="step-title">กรอกข้อมูลรายงานอาหาร</h4>
                                <p class="step-subtitle">กดปุ่ม "เพิ่มรายงาน" และกรอกข้อมูลให้ครบ</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6 order-lg-2">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-edit me-2 text-primary'></i>ข้อมูลที่ต้องกรอก</h6>
                                    
                                    <ul class="features-list">
                                        <li>
                                            <div class="feature-icon primary"><i class='bx bx-calendar'></i></div>
                                            <div>
                                                <strong class="d-block">วันที่รายงาน</strong>
                                                <small class="text-muted">เลือกวันที่ที่ต้องการบันทึกอาหาร</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon warning"><i class='bx bx-time'></i></div>
                                            <div>
                                                <strong class="d-block">มื้ออาหาร</strong>
                                                <small class="text-muted">เลือกมื้อเช้า (07:00-08:30), กลางวัน (11:00-13:00), หรือเย็น (16:30-18:00)</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-restaurant'></i></div>
                                            <div>
                                                <strong class="d-block">รายการเมนูอาหาร</strong>
                                                <small class="text-muted">ระบุเมนูอาหารที่เสิร์ฟ คั่นด้วยจุลภาค (,)</small>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="tips-box mt-4">
                                        <i class='bx bxs-info-circle'></i>
                                        <div>
                                            <strong class="d-block mb-1">ตัวอย่างการกรอกเมนู</strong>
                                            <span class="text-muted small">ข้าวสวย, ต้มจืดวุ้นเส้น, ไก่ทอด, ผลไม้ตามฤดูกาล</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 order-lg-1">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: Add Form -->
                                        <div class="mockup-card mx-auto" style="max-width: 340px; transform: rotate(2deg);">
                                            <div class="mockup-card-header">
                                                <i class='bx bx-plus-circle me-1'></i> เพิ่มรายงานอาหารใหม่
                                            </div>
                                            <div class="mockup-card-body">
                                                <div class="mb-2">
                                                    <div class="text-muted small mb-1" style="font-size: 10px;">ข้อมูลเบื้องต้น</div>
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-6">
                                                            <div class="border rounded p-2 bg-light" style="font-size: 11px;">
                                                                <i class='bx bx-calendar me-1 text-primary'></i> 13 ม.ค. 2569
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="meal-badge-lunch rounded p-2 text-center" style="font-size: 10px;">
                                                                <i class='bx bx-cloud me-1'></i> มื้อกลางวัน
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <div class="text-muted small mb-1" style="font-size: 10px;">รายการอาหารและรูปภาพ</div>
                                                    <div class="border rounded p-2 bg-light mb-2" style="font-size: 11px;">
                                                        <span class="badge bg-light text-dark border me-1 mb-1">ข้าวสวย</span>
                                                        <span class="badge bg-light text-dark border me-1 mb-1">ต้มจืด</span>
                                                        <span class="badge bg-light text-dark border mb-1">ไก่ทอด</span>
                                                    </div>
                                                </div>
                                                <div class="border-2 border-dashed rounded p-2 text-center bg-primary bg-opacity-10 mb-2">
                                                    <i class='bx bx-cloud-upload text-primary'></i>
                                                    <div class="text-primary small" style="font-size: 10px;">อัปโหลดรูปภาพอาหาร</div>
                                                </div>
                                                <div class="bg-primary rounded-2 text-white text-center p-2 mt-3" style="font-size: 12px;">
                                                    <i class='bx bx-save me-1'></i> บันทึกข้อมูลรายงาน
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: อัปโหลดรูปภาพ -->
                <div class="col-12 animate-in" style="animation-delay: 0.3s">
                    <div class="step-card">
                        <div class="step-header d-flex align-items-center gap-3">
                            <div class="step-number">3</div>
                            <div>
                                <h4 class="step-title">อัปโหลดรูปภาพอาหาร</h4>
                                <p class="step-subtitle">แนบรูปภาพอาหารประกอบรายงาน (หลายรูปได้)</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-image-add me-2 text-primary'></i>วิธีอัปโหลดรูปภาพ</h6>
                                    <ol class="ps-3 text-secondary">
                                        <li class="mb-2">คลิกที่กรอบ <strong class="text-dark">"อัปโหลดรูปภาพอาหาร"</strong></li>
                                        <li class="mb-2">เลือกไฟล์รูปภาพจากเครื่องคอมพิวเตอร์หรือโทรศัพท์</li>
                                        <li class="mb-2">สามารถเลือกได้ <strong class="text-success">หลายรูปพร้อมกัน</strong></li>
                                        <li class="mb-2">ระบบจะแสดง <strong class="text-primary">ตัวอย่าง</strong> รูปภาพก่อนบันทึก</li>
                                    </ol>

                                    <ul class="features-list mt-4">
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-check'></i></div>
                                            <div>
                                                <strong class="d-block">รองรับ JPEG และ PNG</strong>
                                                <small class="text-muted">ไฟล์ .jpg, .jpeg, .png</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-check'></i></div>
                                            <div>
                                                <strong class="d-block">อัปโหลดได้หลายรูป</strong>
                                                <small class="text-muted">เลือกหลายไฟล์พร้อมกันได้</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon info"><i class='bx bx-show'></i></div>
                                            <div>
                                                <strong class="d-block">ดูตัวอย่างก่อนบันทึก</strong>
                                                <small class="text-muted">ตรวจสอบรูปภาพก่อนส่ง</small>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="tips-box success mt-4">
                                        <i class='bx bxs-camera'></i>
                                        <div>
                                            <strong class="d-block mb-1">เคล็ดลับ: ถ่ายรูปอาหาร</strong>
                                            <span class="text-muted small">ถ่ายภาพอาหารทุกจานที่เสิร์ฟ เพื่อให้รายงานมีความสมบูรณ์</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: Upload Zone -->
                                        <div class="mockup-card mx-auto" style="max-width: 300px;">
                                            <div class="mockup-card-body">
                                                <div class="border-2 border-dashed rounded-3 p-4 text-center bg-primary bg-opacity-10 mb-3">
                                                    <i class='bx bx-cloud-upload text-primary fs-1 mb-2'></i>
                                                    <div class="text-primary fw-bold small mb-1">อัปโหลดรูปภาพอาหาร</div>
                                                    <div class="text-muted" style="font-size: 10px;">คลิกเพื่อเลือกไฟล์ หรือลากไฟล์มาวาง</div>
                                                </div>
                                                <div class="text-muted small mb-2" style="font-size: 10px;">ตัวอย่างรูปภาพ:</div>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <div class="bg-warning rounded" style="width: 60px; height: 60px;"></div>
                                                    <div class="bg-success rounded" style="width: 60px; height: 60px;"></div>
                                                    <div class="bg-info rounded" style="width: 60px; height: 60px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: บันทึกและพิมพ์ -->
                <div class="col-12 animate-in" style="animation-delay: 0.4s">
                    <div class="step-card">
                        <div class="step-header d-flex align-items-center gap-3">
                            <div class="step-number">4</div>
                            <div>
                                <h4 class="step-title">บันทึกและพิมพ์รายงาน</h4>
                                <p class="step-subtitle">บันทึกข้อมูล แก้ไข หรือพิมพ์เป็น PDF</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6 order-lg-2">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-check-double me-2 text-primary'></i>หลังบันทึกสำเร็จ</h6>
                                    
                                    <ul class="features-list">
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-save'></i></div>
                                            <div>
                                                <strong class="d-block">บันทึกข้อมูลทันที</strong>
                                                <small class="text-muted">ข้อมูลจะถูกบันทึกลงระบบและแสดงในตาราง</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon warning"><i class='bx bx-edit'></i></div>
                                            <div>
                                                <strong class="d-block">แก้ไขรายงานของตนเอง</strong>
                                                <small class="text-muted">สามารถแก้ไขได้เฉพาะรายงานที่ตนเองบันทึก</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon info"><i class='bx bx-printer'></i></div>
                                            <div>
                                                <strong class="d-block">พิมพ์รายงานเป็น PDF</strong>
                                                <small class="text-muted">กดปุ่มพิมพ์เพื่อเปิดหน้าพิมพ์รายงาน</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon" style="background: rgba(255, 62, 29, 0.15); color: #ff3e1d;"><i class='bx bx-trash'></i></div>
                                            <div>
                                                <strong class="d-block">ลบรายงาน</strong>
                                                <small class="text-muted">สามารถลบได้เฉพาะรายงานที่ตนเองบันทึก</small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 order-lg-1">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: Success & Actions -->
                                        <div class="mockup-card mx-auto" style="max-width: 280px;">
                                            <div class="mockup-card-body p-4 text-center">
                                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                    <i class='bx bxs-check-circle text-success fs-1'></i>
                                                </div>
                                                <h5 class="fw-bold text-success mb-2">บันทึกสำเร็จ!</h5>
                                                <p class="text-muted small mb-3">รายงานอาหารถูกบันทึกเรียบร้อยแล้ว</p>
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <button class="btn btn-sm btn-label-info rounded-pill px-3">
                                                        <i class='bx bx-printer me-1'></i> พิมพ์
                                                    </button>
                                                    <button class="btn btn-sm btn-label-warning rounded-pill px-3">
                                                        <i class='bx bx-edit me-1'></i> แก้ไข
                                                    </button>
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
                    <h4 class="fw-bold text-primary">สำหรับผู้ดูแลระบบ</h4>
                    <p class="text-muted">ตรวจสอบ ดูสถิติ และจัดการรายงานอาหาร</p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-success text-success">
                                    <i class='bx bx-list-check'></i>
                                </div>
                                <h5 class="fw-bold mb-2">ตรวจสอบรายงาน</h5>
                                <p class="text-muted small mb-0">ดูรายการรายงานอาหารทั้งหมดจากทุกผู้รายงาน กรองตามปีการศึกษา ค้นหาตามวันที่หรือเมนู</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-info text-info">
                                    <i class='bx bx-bar-chart-alt-2'></i>
                                </div>
                                <h5 class="fw-bold mb-2">ดูสถิติและรายงาน</h5>
                                <p class="text-muted small mb-0">ดูสถิติจำนวนรายงานในแต่ละมื้อ (เช้า/กลางวัน/เย็น) และติดตามการบันทึก</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-warning text-warning">
                                    <i class='bx bx-edit'></i>
                                </div>
                                <h5 class="fw-bold mb-2">แก้ไข/ลบรายงาน</h5>
                                <p class="text-muted small mb-0">ผู้รายงานสามารถแก้ไขหรือลบรายงานของตนเองได้ เพื่อความถูกต้องของข้อมูล</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-primary text-primary">
                                    <i class='bx bx-images'></i>
                                </div>
                                <h5 class="fw-bold mb-2">ดูรูปภาพอาหาร</h5>
                                <p class="text-muted small mb-0">คลิกดูรูปภาพอาหารแบบอัลบั้มภาพ ขยายดูรูปขนาดใหญ่ได้ทันที</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Who can access -->
            <div class="step-card">
                <div class="step-header d-flex align-items-center gap-3">
                    <div class="step-number"><i class='bx bx-shield'></i></div>
                    <div>
                        <h4 class="step-title">สิทธิ์การเข้าถึงระบบ</h4>
                        <p class="step-subtitle">เฉพาะบุคลากรที่ได้รับสิทธิ์งานรายงานอาหาร</p>
                    </div>
                </div>
                <div class="step-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">ผู้ที่สามารถเพิ่มรายงานได้:</h6>
                            <ul class="features-list">
                                <li>
                                    <div class="feature-icon"><i class='bx bx-check'></i></div>
                                    <div>
                                        <strong class="d-block">บุคลากรที่มีสิทธิ์ "งานรายงานอาหาร"</strong>
                                        <small class="text-muted">สามารถเพิ่ม, แก้ไข, ลบ รายงานของตนเอง</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">ผู้ที่ดูได้อย่างเดียว:</h6>
                            <ul class="features-list">
                                <li>
                                    <div class="feature-icon info"><i class='bx bx-show'></i></div>
                                    <div>
                                        <strong class="d-block">บุคคลทั่วไป</strong>
                                        <small class="text-muted">สามารถดูรายงานอาหารและรูปภาพได้ แต่ไม่สามารถเพิ่มหรือแก้ไข</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
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
                        <i class='bx bx-question-mark me-2'></i> ใครสามารถเพิ่มรายงานอาหารได้บ้าง?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        เฉพาะบุคลากรที่ได้รับสิทธิ์ <strong>"งานรายงานอาหาร"</strong> เท่านั้นที่สามารถเพิ่มรายงานได้ครับ หากต้องการสิทธิ์นี้ กรุณาติดต่อผู้ดูแลระบบ
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        <i class='bx bx-question-mark me-2'></i> สามารถแก้ไขรายงานของคนอื่นได้ไหม?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        ไม่ได้ครับ ผู้รายงานสามารถแก้ไขและลบได้เฉพาะรายงานที่ตนเองเป็นผู้บันทึกเท่านั้น เพื่อความปลอดภัยและความถูกต้องของข้อมูล
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        <i class='bx bx-question-mark me-2'></i> รูปภาพอาหารรองรับไฟล์ประเภทใดบ้าง?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        ระบบรองรับไฟล์ภาพ <strong>JPEG (.jpg, .jpeg)</strong> และ <strong>PNG (.png)</strong> ครับ สามารถอัปโหลดได้หลายรูปพร้อมกัน
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        <i class='bx bx-question-mark me-2'></i> หากต้องการพิมพ์รายงานเป็นเอกสารทำอย่างไร?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        ในตารางรายงาน คลิกที่ปุ่ม <i class='bx bx-printer text-info'></i> (พิมพ์) ที่รายการที่ต้องการ ระบบจะเปิดหน้าพิมพ์แบบฟอร์มรายงานอาหาร สามารถพิมพ์หรือบันทึกเป็น PDF ได้ครับ
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
