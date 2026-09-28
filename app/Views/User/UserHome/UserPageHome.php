<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --home-primary: #696cff;
        --home-primary-dark: #5659e5;
        --home-primary-light: #eceeff;
        --home-gradient-hero: linear-gradient(135deg, #696cff 0%, #4a4dcf 50%, #3538a0 100%);
        --glass-card-bg: rgba(255, 255, 255, 0.95);
        --glass-card-border: rgba(255, 255, 255, 0.8);
        --glass-card-shadow: 0 10px 30px rgba(67, 89, 113, 0.08);
        --glass-card-hover-shadow: 0 20px 40px rgba(105, 108, 255, 0.16);
    }

    .home-container {
        padding-top: 1rem;
        padding-bottom: 2.5rem;
        position: relative;
    }

    /* -------------------------------------------------------------
       1. HERO BANNER SECTION (Deep Royal Purple Gradient Theme)
       ------------------------------------------------------------- */
    .hero-box {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 40%, #7c3aed 100%);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 14px 38px rgba(79, 70, 229, 0.32);
        margin-bottom: 2rem;
        color: #ffffff;
    }

    /* Luminous background ambient lights */
    .hero-box::before {
        content: '';
        position: absolute;
        width: 360px;
        height: 360px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
        top: -110px;
        right: 15%;
        pointer-events: none;
    }
    .hero-box::after {
        content: '';
        position: absolute;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.35) 0%, rgba(236, 72, 153, 0) 70%);
        bottom: -80px;
        left: 20%;
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        padding: 2.2rem 2.2rem;
    }

    .badge-pill-soft {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.82rem;
        padding: 0.42rem 1rem;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        margin-bottom: 0.9rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .hero-title {
        font-size: 2.1rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        line-height: 1.25;
        margin-bottom: 0.5rem;
        color: #ffffff;
        text-shadow: 0 2px 6px rgba(0,0,0,0.18);
    }

    .hero-title-highlight {
        color: #fde047;
        text-shadow: 0 2px 10px rgba(253, 224, 71, 0.35);
    }

    .hero-subtitle {
        font-size: 0.98rem;
        color: #f1f5f9;
        line-height: 1.6;
        max-width: 580px;
        margin-bottom: 1.35rem;
        font-weight: 400;
        text-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }

    .hero-stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        background: rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.28);
        padding: 0.5rem 1.05rem;
        border-radius: 12px;
        font-size: 0.84rem;
        font-weight: 600;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .floating-illustration {
        animation: floatMotion 4.5s ease-in-out infinite;
        filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.3));
    }

    @keyframes floatMotion {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-7px) rotate(-1deg); }
    }

    /* -------------------------------------------------------------
       2. SECTION HEADER
       ------------------------------------------------------------- */
    .section-headline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    .section-headline-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #435971;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0;
    }
    .section-headline-title i {
        color: var(--home-primary);
        font-size: 1.4rem;
    }

    /* -------------------------------------------------------------
       3. MODERN SERVICE CARDS (Glassmorphism + Dynamic Glows)
       ------------------------------------------------------------- */
    .svc-card-wrapper {
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
    }

    .svc-card {
        background: var(--glass-card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--glass-card-border);
        border-radius: 1.35rem;
        padding: 1.6rem 1.25rem 1.4rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: var(--glass-card-shadow);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
    }

    /* Top Accent Line on Card */
    .svc-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--card-accent-gradient, var(--home-gradient-hero));
        opacity: 0.7;
        transition: opacity 0.3s ease, height 0.3s ease;
    }

    .svc-card:hover {
        transform: translateY(-8px) scale(1.015);
        box-shadow: var(--glass-card-hover-shadow);
        border-color: rgba(105, 108, 255, 0.3);
    }

    .svc-card:hover::before {
        opacity: 1;
        height: 6px;
    }

    /* Icon Box with Smooth Glow */
    .svc-icon-box {
        width: 74px;
        height: 74px;
        border-radius: 1.25rem;
        background: var(--card-icon-bg, #f0f2ff);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.15rem;
        position: relative;
        transition: all 0.35s ease;
        box-shadow: 0 8px 18px var(--card-icon-shadow, rgba(105, 108, 255, 0.12));
    }

    .svc-icon-box img {
        width: 44px;
        height: 44px;
        object-fit: contain;
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .svc-card:hover .svc-icon-box {
        transform: scale(1.08) translateY(-2px);
        box-shadow: 0 12px 24px var(--card-icon-shadow, rgba(105, 108, 255, 0.25));
    }

    .svc-card:hover .svc-icon-box img {
        transform: scale(1.12) rotate(4deg);
    }

    /* Card Typography */
    .svc-title {
        font-size: 1.12rem;
        font-weight: 700;
        color: #435971;
        margin-bottom: 0.35rem;
        transition: color 0.2s ease;
    }

    .svc-card:hover .svc-title {
        color: var(--home-primary);
    }

    .svc-desc {
        font-size: 0.84rem;
        color: #79879a;
        line-height: 1.45;
        margin-bottom: 1.2rem;
        min-height: 2.5em;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.25rem;
    }

    /* Action Trigger Pill */
    .svc-action-btn {
        margin-top: auto;
        width: 100%;
        max-width: 190px;
        padding: 0.52rem 1.1rem;
        border-radius: 50px;
        background: #f4f5fb;
        border: 1px solid rgba(67, 89, 113, 0.08);
        color: #566a7f;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.3s ease;
    }

    .svc-action-btn i {
        font-size: 1.05rem;
        transition: transform 0.3s ease;
    }

    .svc-card:hover .svc-action-btn {
        background: var(--card-btn-gradient, var(--home-gradient-hero));
        color: #ffffff;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(105, 108, 255, 0.35);
    }

    .svc-card:hover .svc-action-btn i {
        transform: translateX(4px);
    }

    /* Individual Card Theme Variables */
    /* 1. จองสถานที่ (Emerald Green Theme) */
    .svc-theme-booking {
        --card-accent-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --card-icon-bg: #ecfdf5;
        --card-icon-shadow: rgba(16, 185, 129, 0.18);
        --card-btn-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .svc-theme-booking:hover .svc-title { color: #059669; }

    /* 2. จองยานพาหนะ (Sky Blue Theme) */
    .svc-theme-car {
        --card-accent-gradient: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        --card-icon-bg: #f0f9ff;
        --card-icon-shadow: rgba(2, 132, 199, 0.18);
        --card-btn-gradient: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    }
    .svc-theme-car:hover .svc-title { color: #0284c7; }

    /* 3. แจ้งซ่อมออนไลน์ (Amber / Orange Theme) */
    .svc-theme-repair {
        --card-accent-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        --card-icon-bg: #fffbeb;
        --card-icon-shadow: rgba(245, 158, 11, 0.2);
        --card-btn-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    .svc-theme-repair:hover .svc-title { color: #d97706; }

    /* 4. รายงานอาหาร (Rose Theme) */
    .svc-theme-food {
        --card-accent-gradient: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        --card-icon-bg: #fdf2f8;
        --card-icon-shadow: rgba(236, 72, 153, 0.18);
        --card-btn-gradient: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
    }
    .svc-theme-food:hover .svc-title { color: #db2777; }

    /* 5. ยืม-คืนพัสดุอุปกรณ์ (Royal Indigo / Purple Theme) */
    .svc-theme-equipment {
        --card-accent-gradient: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        --card-icon-bg: #f5f3ff;
        --card-icon-shadow: rgba(139, 92, 246, 0.2);
        --card-btn-gradient: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }
    .svc-theme-equipment:hover .svc-title { color: #7c3aed; }

    /* -------------------------------------------------------------
       4. QUICK INFO & ANNOUNCEMENT BAR
       ------------------------------------------------------------- */
    .info-strip {
        background: #ffffff;
        border-radius: 1.2rem;
        border: 1px solid rgba(67, 89, 113, 0.08);
        padding: 1rem 1.4rem;
        box-shadow: 0 4px 18px rgba(0,0,0,0.03);
        margin-top: 1.75rem;
    }

    /* -------------------------------------------------------------
       5. RESPONSIVE BREAKPOINTS (Mobile Optimization)
       ------------------------------------------------------------- */
    @media (max-width: 991.98px) {
        .hero-title { font-size: 1.5rem; }
        .hero-content { padding: 1.6rem 1.4rem; }
    }

    @media (max-width: 767.98px) {
        .home-container {
            padding-top: 0.5rem;
            padding-bottom: 2rem;
        }
        .hero-box {
            border-radius: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .hero-content {
            padding: 1.35rem 1.15rem;
            text-align: left;
        }
        .hero-title {
            font-size: 1.35rem;
            margin-bottom: 0.35rem;
        }
        .hero-subtitle {
            font-size: 0.85rem;
            margin-bottom: 0.85rem;
            line-height: 1.4;
        }
        .floating-illustration {
            height: 110px !important;
        }
        .svc-card {
            padding: 1.15rem 0.75rem 1rem;
            border-radius: 1.1rem;
        }
        .svc-icon-box {
            width: 58px;
            height: 58px;
            border-radius: 1rem;
            margin-bottom: 0.8rem;
        }
        .svc-icon-box img {
            width: 34px;
            height: 34px;
        }
        .svc-title {
            font-size: 0.96rem;
            margin-bottom: 0.25rem;
        }
        .svc-desc {
            font-size: 0.74rem;
            line-height: 1.3;
            min-height: 2.6em;
            margin-bottom: 0.75rem;
        }
        .svc-action-btn {
            padding: 0.38rem 0.75rem;
            font-size: 0.78rem;
            border-radius: 25px;
            max-width: 100%;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 home-container">
    
    <!-- 1. Hero Welcome Section -->
    <div class="hero-box">
        <div class="row align-items-center g-0">
            <div class="col-8 col-sm-8 col-lg-8 order-1">
                <div class="hero-content">
                    <div class="badge-pill-soft">
                        <i class='bx bx-check-shield fs-6'></i>
                        <span>Smart General Management E-Office</span>
                    </div>
                    <h1 class="hero-title">สกจ. <span class="hero-title-highlight">บริหารทั่วไป</span></h1>
                    <p class="hero-subtitle mb-2 mb-md-3">
                        ยินดีต้อนรับสู่ศูนย์กลางระบบงานบริการส่วนกลาง โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
                    </p>
                    <div class="d-none d-md-flex align-items-center gap-2">
                        <div class="hero-stat-pill">
                            <i class='bx bx-devices text-warning'></i>
                            <span>ระบบงานออนไลน์ 5 หมวดบริการ</span>
                        </div>
                        <div class="hero-stat-pill">
                            <i class='bx bx-bell text-info'></i>
                            <span>แจ้งเตือนอัตโนมัติผ่าน Telegram & Push</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 col-sm-4 col-lg-4 text-center order-2 pe-3 pe-md-4">
                <img src="<?=base_url();?>assets/img/illustrations/hero-general-eoffice.png"
                    height="175" alt="ระบบบริหารทั่วไป SKJ E-Office" class="floating-illustration img-fluid my-2 my-md-3"
                    style="max-height: 190px; object-fit: contain;">
            </div>
        </div>
    </div>

    <!-- 2. Services Section Headline -->
    <div class="section-headline">
        <h2 class="section-headline-title">
            <i class='bx bxs-grid-alt'></i>
            <span>บริการระบบงานออนไลน์ (Online Services)</span>
        </h2>
        <span class="badge bg-label-primary rounded-pill px-3 py-2 d-none d-sm-inline-flex align-items-center gap-1">
            <i class='bx bx-check-circle'></i> พร้อมใช้งาน 24 ชั่วโมง
        </span>
    </div>

    <!-- 3. Core Services Grid (5 Pillars) -->
    <div class="row g-2 g-md-3 g-xl-4 justify-content-center">
        
        <!-- 1. จองสถานที่ (Booking) -->
        <div class="col-6 col-md-4 col-xl">
            <a href="<?=base_url('Booking');?>" class="svc-card-wrapper">
                <div class="svc-card svc-theme-booking">
                    <div class="svc-icon-box">
                        <img src="https://cdn-icons-png.flaticon.com/128/1908/1908239.png" alt="จองสถานที่">
                    </div>
                    <h3 class="svc-title">จองสถานที่</h3>
                    <p class="svc-desc">ห้องประชุม หอประชุม และอาคารสถานที่</p>
                    <div class="svc-action-btn">
                        <span>เข้าใช้งาน</span>
                        <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 2. จองยานพาหนะ (Car Booking) -->
        <div class="col-6 col-md-4 col-xl">
            <a href="<?=base_url('CarBooking');?>" class="svc-card-wrapper">
                <div class="svc-card svc-theme-car">
                    <div class="svc-icon-box">
                        <img src="https://cdn-icons-png.flaticon.com/128/11649/11649708.png" alt="จองยานพาหนะ">
                    </div>
                    <h3 class="svc-title">จองยานพาหนะ</h3>
                    <p class="svc-desc">รถตู้ รถยนต์ส่วนกลาง และรถรับส่งภารกิจ</p>
                    <div class="svc-action-btn">
                        <span>เข้าใช้งาน</span>
                        <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 3. แจ้งซ่อมออนไลน์ (Repair) -->
        <div class="col-6 col-md-4 col-xl">
            <a href="<?=base_url('Repair');?>" class="svc-card-wrapper">
                <div class="svc-card svc-theme-repair">
                    <div class="svc-icon-box">
                        <img src="https://cdn-icons-png.flaticon.com/128/10203/10203414.png" alt="แจ้งซ่อมออนไลน์">
                    </div>
                    <h3 class="svc-title">แจ้งซ่อมออนไลน์</h3>
                    <p class="svc-desc">แจ้งปัญหาชำรุด ไฟฟ้า ประปา และอาคาร</p>
                    <div class="svc-action-btn">
                        <span>เข้าใช้งาน</span>
                        <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 4. รายงานอาหาร (Food Report) -->
        <div class="col-6 col-md-6 col-xl">
            <a href="<?=base_url('FoodReport');?>" class="svc-card-wrapper">
                <div class="svc-card svc-theme-food">
                    <div class="svc-icon-box">
                        <img src="https://cdn-icons-png.flaticon.com/128/3595/3595458.png" alt="รายการอาหาร">
                    </div>
                    <h3 class="svc-title">รายการอาหาร</h3>
                    <p class="svc-desc">รายงานโภชนาการ และตรวจเมนูประจำวัน</p>
                    <div class="svc-action-btn">
                        <span>เข้าใช้งาน</span>
                        <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- 5. ยืม-คืนพัสดุอุปกรณ์ (Equipment) -->
        <div class="col-6 col-md-6 col-xl">
            <a href="<?=base_url('Equipment');?>" class="svc-card-wrapper">
                <div class="svc-card svc-theme-equipment">
                    <div class="svc-icon-box">
                        <img src="https://cdn-icons-png.flaticon.com/128/2897/2897785.png" alt="ยืม-คืนพัสดุอุปกรณ์">
                    </div>
                    <h3 class="svc-title">ยืม-คืนพัสดุ</h3>
                    <p class="svc-desc">โสตทัศน์ เครื่องมือช่าง โต๊ะเก้าอี้ พัสดุ</p>
                    <div class="svc-action-btn">
                        <span>เข้าใช้งาน</span>
                        <i class='bx bx-right-arrow-alt'></i>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- 4. Quick Support & Manual Helper Bar -->
    <div class="info-strip d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="p-2 rounded-3 bg-label-primary d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class='bx bx-help-circle fs-3 text-primary'></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold text-dark">คู่มือการใช้งาน & ติดต่อกลุ่มงานบริหารทั่วไป</h6>
                <small class="text-muted">ศึกษาวิธีการใช้งานระบบต่างๆ หรือประสานงานเจ้าหน้าที่ผู้ดูแลระบบ</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 w-100 w-md-auto justify-content-end">
            <a href="<?=base_url('manual');?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-2">
                <i class='bx bx-book-open me-1'></i> ดูคู่มือระบบ
            </a>
            <?php if(!session()->has('username')): ?>
            <a href="<?=base_url('LoginOfficerGeneral');?>" class="btn btn-sm btn-primary rounded-pill px-3 py-2 text-white">
                <i class='bx bx-log-in me-1'></i> เข้าสู่ระบบเจ้าหน้าที่
            </a>
            <?php endif; ?>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

