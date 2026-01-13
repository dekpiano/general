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
        color: #566a7f;
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

    /* Nav link text */
    .nav-manual .nav-link {
        color: #32475c;
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

    .faq-title {
        font-weight: 700;
        color: #32475c;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.5rem;
    }

    .faq-title i {
        color: var(--manual-primary);
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

    .accordion-premium .accordion-body {
        padding: 16px 20px;
        color: #8592a3;
        line-height: 1.7;
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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Hero Section -->
    <div class="manual-hero animate-in">
        <div class="hero-content">
            <div class="d-flex align-items-center mb-3">
                <i class='bx bxs-book-content fs-2 me-2'></i>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('manual') ?>" class="text-white-50">คู่มือ</a></li>
                        <li class="breadcrumb-item active text-white">ระบบจองห้อง</li>
                    </ol>
                </nav>
            </div>
            <h1 class="hero-title">คู่มือระบบจองห้องและสถานที่</h1>
            <p class="hero-subtitle">เรียนรู้วิธีการจองห้องประชุม สถานที่ต่างๆ ตั้งแต่ขั้นตอนแรกจนถึงการอนุมัติ</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-6 col-md-8">
            <ul class="nav nav-manual nav-fill" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#user-manual" type="button">
                        <i class="bx bx-user me-1"></i> สำหรับผู้จอง
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#admin-manual" type="button">
                        <i class="bx bx-shield-quarter me-1"></i> สำหรับผู้อนุมัติ
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
                
                <!-- Step 1: เลือกสถานที่ -->
                <div class="col-12 animate-in" style="animation-delay: 0.1s">
                    <div class="step-card">
                        <div class="step-header d-flex align-items-center gap-3">
                            <div class="step-number">1</div>
                            <div>
                                <h4 class="step-title">เข้าสู่หน้าระบบจองสถานที่</h4>
                                <p class="step-subtitle">เลือกห้องที่ต้องการจากรายการทั้งหมด พร้อมตรวจสอบวันว่างผ่าน Mini Calendar</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-navigation me-2 text-primary'></i>วิธีเข้าถึงหน้าจอง</h6>
                                    <ol class="ps-3 text-secondary">
                                        <li class="mb-2">ไปที่เมนู <strong class="text-dark">"จองสถานที่"</strong> ในแถบเมนูหลัก</li>
                                        <li class="mb-2">ระบบจะแสดงรายการห้อง/สถานที่ทั้งหมด <strong class="text-primary">แยกตามหมวดหมู่</strong></li>
                                        <li class="mb-2">แต่ละห้องจะมี <strong class="text-success">ปฏิทินขนาดเล็ก (Mini Calendar)</strong> แสดงอยู่</li>
                                        <li class="mb-2">สามารถเปลี่ยนเดือน/ปีเพื่อดูตารางล่วงหน้าได้</li>
                                    </ol>

                                    <div class="tips-box mt-4">
                                        <i class='bx bxs-bulb'></i>
                                        <div>
                                            <strong class="d-block mb-1">เคล็ดลับ</strong>
                                            <span class="text-muted small">สีเขียว = มีการจองที่อนุมัติแล้ว, สีเหลือง = รอตรวจสอบ คลิกที่วันเพื่อจองได้เลย!</span>
                                        </div>
                                    </div>

                                    <ul class="features-list mt-4">
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-check'></i></div>
                                            <div>
                                                <strong class="d-block">ดูภาพสถานที่</strong>
                                                <small class="text-muted">แต่ละห้องมีรูปภาพประกอบให้ดู</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-check'></i></div>
                                            <div>
                                                <strong class="d-block">เลือกวันจากปฏิทิน</strong>
                                                <small class="text-muted">คลิกวันที่ต้องการจองได้โดยตรง</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon info"><i class='bx bx-info-circle'></i></div>
                                            <div>
                                                <strong class="d-block">Sidebar เครื่องมือ</strong>
                                                <small class="text-muted">ดูจำนวนห้องทั้งหมด, รายการจองของฉัน, คู่มือ</small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: Location Card with Mini Calendar -->
                                        <div class="mockup-card mx-auto" style="max-width: 320px; transform: rotate(-2deg);">
                                            <div class="mockup-card-header d-flex align-items-center gap-2">
                                                <i class='bx bxs-door-open'></i>
                                                <span class="fw-semibold">ห้องประชุม 1</span>
                                            </div>
                                            <div class="mockup-card-body">
                                                <div class="d-flex gap-2 mb-3">
                                                    <div class="bg-light rounded px-2 py-1 flex-grow-1 text-center" style="font-size: 11px;">มกราคม</div>
                                                    <div class="bg-light rounded px-2 py-1" style="font-size: 11px;">2569</div>
                                                </div>
                                                <div class="row g-1">
                                                    <?php for($i=1; $i<=7; $i++): ?>
                                                        <div class="col text-center"><small class="text-muted" style="font-size:9px;"><?= ['อา','จ','อ','พ','พฤ','ศ','ส'][$i-1] ?></small></div>
                                                    <?php endfor; ?>
                                                </div>
                                                <div class="row g-1 mt-1">
                                                    <?php for($d=1; $d<=14; $d++): ?>
                                                        <div class="col">
                                                            <div class="rounded-1 text-center py-1 <?= $d==5 ? 'bg-success text-white' : ($d==8 ? 'bg-warning text-dark' : 'bg-light') ?>" style="font-size: 10px;"><?= $d ?></div>
                                                        </div>
                                                        <?php if($d % 7 == 0): ?></div><div class="row g-1 mt-1"><?php endif; ?>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <span class="badge bg-success me-1">สีเขียว = อนุมัติแล้ว</span>
                                            <span class="badge bg-warning">สีเหลือง = รอตรวจสอบ</span>
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
                                <h4 class="step-title">กรอกรายละเอียดการจอง</h4>
                                <p class="step-subtitle">ระบุข้อมูลการใช้งาน วันเวลา และอุปกรณ์ที่ต้องการ</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6 order-lg-2">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-edit me-2 text-primary'></i>ข้อมูลที่ต้องกรอก</h6>
                                    
                                    <ul class="features-list">
                                        <li>
                                            <div class="feature-icon primary"><i class='bx bx-detail'></i></div>
                                            <div>
                                                <strong class="d-block">ข้อมูลพื้นฐาน</strong>
                                                <small class="text-muted">หัวข้อการใช้งาน, จำนวนผู้เข้าร่วม, ลักษณะงาน (ประชุม/อบรม/สัมนา/จัดเลี้ยง/จัดกิจกรรม)</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon warning"><i class='bx bx-calendar'></i></div>
                                            <div>
                                                <strong class="d-block">วันและเวลา</strong>
                                                <small class="text-muted">วันที่เริ่มปฏิบัติงาน, เวลาเริ่ม-สิ้นสุด (รองรับการจองข้ามวัน)</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-cog'></i></div>
                                            <div>
                                                <strong class="d-block">อุปกรณ์เพิ่มเติม</strong>
                                                <small class="text-muted">เครื่องคอมพิวเตอร์, โปรเจ็คเตอร์, เครื่องฉายแผ่นใส, เครื่องขยายเสียง</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon info"><i class='bx bx-image-add'></i></div>
                                            <div>
                                                <strong class="d-block">รูปภาพประกอบ / ผังงาน</strong>
                                                <small class="text-muted">แนบรูปหรือผังการจัดสถานที่ได้ (ถ้ามี)</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon primary"><i class='bx bx-phone'></i></div>
                                            <div>
                                                <strong class="d-block">ข้อมูลติดต่อ</strong>
                                                <small class="text-muted">ชื่อผู้จอง และเบอร์โทรศัพท์สำหรับติดต่อกลับ</small>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="tips-box success mt-4">
                                        <i class='bx bxs-check-shield'></i>
                                        <div>
                                            <strong class="d-block mb-1">ระบบตรวจสอบอัตโนมัติ</strong>
                                            <span class="text-muted small">ระบบจะแจ้งเตือนทันทีหากวันเวลาที่เลือกมีการจองซ้อนกับรายการอื่น</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 order-lg-1">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: Booking Form -->
                                        <div class="mockup-card mx-auto" style="max-width: 340px; transform: rotate(2deg);">
                                            <div class="mockup-card-header">
                                                <i class='bx bxs-edit me-1'></i> แบบฟอร์มการจอง
                                            </div>
                                            <div class="mockup-card-body">
                                                <div class="mb-2">
                                                    <div class="text-muted small mb-1" style="font-size: 10px;">หัวข้อการใช้งาน *</div>
                                                    <div class="border rounded p-2 bg-light" style="font-size: 11px;">ประชุมคณะกรรมการ...</div>
                                                </div>
                                                <div class="row g-2 mb-2">
                                                    <div class="col-6">
                                                        <div class="text-muted small mb-1" style="font-size: 10px;">วันที่เริ่มต้น</div>
                                                        <div class="border rounded p-2 bg-success bg-opacity-10 text-success text-center" style="font-size: 11px;">15/01/2569</div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-muted small mb-1" style="font-size: 10px;">เวลา</div>
                                                        <div class="border rounded p-2 bg-light text-center" style="font-size: 11px;">09:00</div>
                                                    </div>
                                                </div>
                                                <div class="p-2 bg-success bg-opacity-10 rounded mb-2">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class='bx bx-check-circle text-success'></i>
                                                        <small class="text-success fw-bold" style="font-size: 10px;">ช่วงเวลานี้ว่าง! สามารถจองได้</small>
                                                    </div>
                                                </div>
                                                <div class="bg-primary rounded-2 text-white text-center p-2 mt-3" style="font-size: 12px;">
                                                    <i class='bx bx-check-double me-1'></i> ส่งคำขอจอง
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: รอผลอนุมัติ -->
                <div class="col-12 animate-in" style="animation-delay: 0.3s">
                    <div class="step-card">
                        <div class="step-header d-flex align-items-center gap-3">
                            <div class="step-number">3</div>
                            <div>
                                <h4 class="step-title">รอผลการอนุมัติ</h4>
                                <p class="step-subtitle">ติดตามสถานะคำขอและรับการแจ้งเตือนอัตโนมัติ</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-bell me-2 text-primary'></i>การติดตามสถานะ</h6>
                                    <p class="text-muted">เมื่อส่งคำขอแล้ว ระบบจะส่งเรื่องไปยังเจ้าหน้าที่งานอาคารสถานที่ทันที ท่านสามารถติดตามสถานะได้ดังนี้:</p>

                                    <ul class="features-list">
                                        <li>
                                            <div class="feature-icon warning"><i class='bx bx-time'></i></div>
                                            <div>
                                                <strong class="d-block">รอตรวจสอบ</strong>
                                                <small class="text-muted">คำขออยู่ระหว่างการพิจารณาจากเจ้าหน้าที่</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon"><i class='bx bx-check-double'></i></div>
                                            <div>
                                                <strong class="d-block">อนุมัติ</strong>
                                                <small class="text-muted">ได้รับอนุมัติแล้ว สามารถดาวน์โหลดใบขออนุมัติได้</small>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="feature-icon" style="background: rgba(255, 62, 29, 0.15); color: #ff3e1d;"><i class='bx bx-x'></i></div>
                                            <div>
                                                <strong class="d-block">ไม่อนุมัติ</strong>
                                                <small class="text-muted">พร้อมเหตุผลประกอบจากเจ้าหน้าที่</small>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="tips-box mt-4">
                                        <i class='bx bxl-line fs-1 text-success'></i>
                                        <div>
                                            <strong class="d-block mb-1">แจ้งเตือนผ่าน LINE</strong>
                                            <span class="text-muted small">ท่านจะได้รับแจ้งผลการอนุมัติผ่าน LINE Official ของโรงเรียนโดยอัตโนมัติ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: LINE Notification -->
                                        <div class="mockup-card mx-auto" style="max-width: 300px; border-radius: 28px;">
                                            <div class="bg-dark p-2 text-white d-flex justify-content-between align-items-center text-center" style="font-size: 11px; border-radius: 28px 28px 0 0;">
                                                <span class="ms-2">9:41</span>
                                                <span>การแจ้งเตือน</span>
                                                <i class="bx bxs-battery-full me-2"></i>
                                            </div>
                                            <div class="p-3 bg-white">
                                                <div class="d-flex align-items-start mb-3 gap-2">
                                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 40px; height: 40px;">
                                                        <i class="bx bxl-line fs-5"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-bold small">SKJ School</div>
                                                        <div class="text-muted" style="font-size: 10px;">เมื่อสักครู่</div>
                                                    </div>
                                                </div>
                                                <div class="p-3 rounded-3 border" style="background: #f8faff;">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <i class='bx bxs-check-circle text-success fs-4'></i>
                                                        <strong class="text-success">อนุมัติเรียบร้อย!</strong>
                                                    </div>
                                                    <div class="text-muted small" style="line-height: 1.6;">
                                                        <strong class="text-dark">ห้องประชุม 1</strong><br>
                                                        📅 วันที่ 15 ม.ค. 2569<br>
                                                        ⏰ เวลา 09:00 - 12:00 น.
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

                <!-- Step 4: ดูประวัติการจอง -->
                <div class="col-12 animate-in" style="animation-delay: 0.4s">
                    <div class="step-card">
                        <div class="step-header d-flex align-items-center gap-3">
                            <div class="step-number">4</div>
                            <div>
                                <h4 class="step-title">ดูประวัติการจองและจัดการ</h4>
                                <p class="step-subtitle">ตรวจสอบรายการจอง แก้ไข หรือยกเลิกคำขอที่ยังไม่อนุมัติ</p>
                            </div>
                        </div>
                        <div class="step-body">
                            <div class="row g-4">
                                <div class="col-lg-7">
                                    <h6 class="fw-bold mb-3"><i class='bx bx-history me-2 text-primary'></i>วิธีดูประวัติการจอง</h6>
                                    <ol class="ps-3 text-secondary">
                                        <li class="mb-2">กดปุ่ม <strong class="text-dark">"รายการจองของฉัน"</strong> ที่ Sidebar ด้านขวา</li>
                                        <li class="mb-2">ระบบจะแสดงรายการจองทั้งหมดของท่าน</li>
                                        <li class="mb-2">สามารถดูสถานะ, แก้ไข, หรือยกเลิกคำขอได้</li>
                                        <li class="mb-2">ดาวน์โหลด <strong class="text-success">ใบขออนุมัติ (PDF)</strong> ได้หลังอนุมัติแล้ว</li>
                                    </ol>

                                    <div class="row g-3 mt-3">
                                        <div class="col-6">
                                            <div class="p-3 bg-light rounded-3 text-center">
                                                <i class='bx bx-edit fs-2 text-warning mb-2 d-block'></i>
                                                <div class="fw-bold small">แก้ไขคำขอ</div>
                                                <small class="text-muted">เฉพาะสถานะ "รอตรวจสอบ"</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 bg-light rounded-3 text-center">
                                                <i class='bx bx-trash fs-2 text-danger mb-2 d-block'></i>
                                                <div class="fw-bold small">ยกเลิกคำขอ</div>
                                                <small class="text-muted">เฉพาะสถานะ "รอตรวจสอบ"</small>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="p-3 bg-success bg-opacity-10 rounded-3 text-center">
                                                <i class='bx bx-download fs-2 text-success mb-2 d-block'></i>
                                                <div class="fw-bold small text-success">ดาวน์โหลดใบขออนุมัติ</div>
                                                <small class="text-muted">พร้อมลายเซ็นผู้อนุมัติ (PDF)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="mockup-wrapper">
                                        <!-- Mockup: History Table Row -->
                                        <div class="mockup-card">
                                            <div class="mockup-card-header bg-secondary">
                                                <i class='bx bx-list-ul me-1'></i> ประวัติการจอง
                                            </div>
                                            <div class="mockup-card-body p-0">
                                                <div class="d-flex align-items-center p-3 border-bottom">
                                                    <span class="badge bg-success rounded-pill me-2" style="font-size: 10px;">อนุมัติ</span>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-bold small">ประชุมคณะกรรมการ</div>
                                                        <div class="text-muted" style="font-size: 10px;">15 ม.ค. 68 | 09:00-12:00</div>
                                                    </div>
                                                    <i class='bx bx-download text-primary'></i>
                                                </div>
                                                <div class="d-flex align-items-center p-3 border-bottom bg-warning bg-opacity-10">
                                                    <span class="badge bg-warning rounded-pill me-2" style="font-size: 10px;">รอตรวจสอบ</span>
                                                    <div class="flex-grow-1">
                                                        <div class="fw-bold small">อบรมครู</div>
                                                        <div class="text-muted" style="font-size: 10px;">20 ม.ค. 68 | 08:30-16:00</div>
                                                    </div>
                                                    <i class='bx bx-edit text-warning me-2'></i>
                                                    <i class='bx bx-trash text-danger'></i>
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
                    <h4 class="fw-bold text-primary">สำหรับเจ้าหน้าที่งานอาคารสถานที่</h4>
                    <p class="text-muted">จัดการอนุมัติคำขอใช้ห้องประชุมและสถานที่ต่างๆ</p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-primary text-primary">
                                    <i class='bx bx-checkbox-checked'></i>
                                </div>
                                <h5 class="fw-bold mb-2">อนุมัติคำขอ</h5>
                                <p class="text-muted small mb-0">ตรวจสอบรายละเอียดการขอใช้ห้อง ลงลายเซ็นอิเล็กทรอนิกส์ (E-Signature) และกดอนุมัติ ระบบจะล็อคตารางห้องและแจ้งผู้จองอัตโนมัติ</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-danger text-danger">
                                    <i class='bx bx-x-circle'></i>
                                </div>
                                <h5 class="fw-bold mb-2">ไม่อนุมัติ</h5>
                                <p class="text-muted small mb-0">ระบุเหตุผลประกอบการไม่อนุมัติ เพื่อให้ผู้จองทราบสาเหตุและแก้ไขคำขอใหม่</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-info text-info">
                                    <i class='bx bx-pie-chart-alt-2'></i>
                                </div>
                                <h5 class="fw-bold mb-2">ดูสถิติรายงาน</h5>
                                <p class="text-muted small mb-0">กราฟแสดงสัดส่วนการใช้สถานที่, ผู้จองสูงสุด 5 อันดับแรก และสรุปการดำเนินการ</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="admin-feature-card">
                                <div class="admin-icon-box bg-label-warning text-warning">
                                    <i class='bx bx-image'></i>
                                </div>
                                <h5 class="fw-bold mb-2">ดูรายละเอียดแนบ</h5>
                                <p class="text-muted small mb-0">ดูรูปภาพผังงานประกอบที่ผู้จองแนบมา และตรวจสอบข้อมูลเพิ่มเติม</p>
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
                        <h4 class="step-title">วิธีเข้าสู่หน้าจัดการอนุมัติ</h4>
                        <p class="step-subtitle">เฉพาะผู้ดูแลงานอาคารสถานที่ และผู้บริหาร</p>
                    </div>
                </div>
                <div class="step-body">
                    <ol class="ps-3 text-secondary">
                        <li class="mb-2">ไปที่หน้า <strong class="text-dark">"จองสถานที่"</strong></li>
                        <li class="mb-2">ที่ Sidebar ด้านขวา จะมีส่วน <strong class="text-info">"ส่วนงานเจ้าหน้าที่"</strong> แสดงอยู่</li>
                        <li class="mb-2">กดปุ่ม <strong class="text-dark">"หน้าจัดการคำขอ"</strong></li>
                        <li class="mb-2">จะเห็นจำนวนคำขอ <span class="badge bg-warning">รอดำเนินการ</span> และ <span class="badge bg-success">อนุมัติแล้ววันนี้</span></li>
                        <li class="mb-2">ในหน้าจัดการ กดปุ่ม <strong class="text-success">"อนุมัติ"</strong> หรือ <strong class="text-danger">"ไม่อนุมัติ"</strong> ที่แต่ละรายการ</li>
                        <li class="mb-0">หากอนุมัติ จะต้อง <strong class="text-primary">ลงลายเซ็นอิเล็กทรอนิกส์</strong> ก่อนยืนยัน</li>
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
                        <i class='bx bx-question-mark me-2'></i> บุคคลภายนอกสามารถจองได้หรือไม่?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        ปัจจุบันระบบเปิดให้จองเฉพาะบุคลากรภายในโรงเรียนเท่านั้นครับ
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        <i class='bx bx-question-mark me-2'></i> สามารถจองล่วงหน้าได้กี่วัน?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        ท่านสามารถจองล่วงหน้าได้ไม่จำกัดจำนวนวันครับ แต่แนะนำให้จองล่วงหน้าอย่างน้อย 3 วันทำการ เพื่อให้เจ้าหน้าที่มีเวลาเตรียมการ
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        <i class='bx bx-question-mark me-2'></i> ถ้าต้องการยกเลิกการจองที่อนุมัติแล้วต้องทำอย่างไร?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        กรุณาติดต่อเจ้าหน้าที่งานอาคารสถานที่โดยตรง เนื่องจากรายการที่อนุมัติแล้วจะไม่สามารถยกเลิกผ่านระบบได้ครับ
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        <i class='bx bx-question-mark me-2'></i> สามารถจองหลายห้องพร้อมกันได้หรือไม่?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                    <div class="accordion-body">
                        ได้ครับ ท่านสามารถส่งคำขอจองหลายห้องได้ โดยแต่ละห้องจะต้องกรอกแบบฟอร์มแยกกัน
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
