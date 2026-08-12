<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --accent-gradient: linear-gradient(135deg, #ff6b9d 0%, #ee0979 100%);
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    .premium-container {
        padding-top: 1.5rem;
        padding-bottom: 2.5rem;
        position: relative;
    }

    /* Welcome Hero Banner */
    .welcome-card {
        background: var(--glass-bg);
        backdrop-filter: blur(16px);
        border: 1px solid var(--glass-border);
        border-radius: 1.5rem;
        box-shadow: 0 8px 25px rgba(105, 108, 255, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .gradient-text {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
    }

    /* Balanced Service Cards */
    .service-card {
        background: var(--glass-bg);
        backdrop-filter: blur(14px);
        border: 1px solid var(--glass-border);
        border-radius: 1.25rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.75rem 1.15rem;
        text-align: center;
        position: relative;
    }

    .service-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 15px 30px rgba(105, 108, 255, 0.15);
    }

    .service-card:hover h5 {
        color: #696cff !important;
    }

    .icon-wrapper {
        width: 72px;
        height: 72px;
        background: #f0f2ff;
        border-radius: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.15rem;
        transition: all 0.3s ease;
    }

    .icon-img {
        width: 42px;
        height: 42px;
        transition: transform 0.3s ease;
    }

    .service-card:hover .icon-img {
        transform: scale(1.1) rotate(5deg);
    }

    .service-card h5 {
        font-size: 1.1rem;
        font-weight: 700;
    }

    .service-card p {
        font-size: 0.85rem;
        min-height: 2.6em;
        line-height: 1.35;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Uniform Button Alignment */
    .btn-premium {
        background: var(--primary-gradient);
        border: none;
        border-radius: 50px;
        padding: 0.55rem 1.25rem;
        color: white;
        font-weight: 600;
        font-size: 0.88rem;
        letter-spacing: 0.3px;
        box-shadow: 0 4px 12px rgba(105, 108, 255, 0.25);
        transition: all 0.3s ease;
        width: 85%;
        margin-top: auto;
    }

    .btn-premium:hover {
        transform: scale(1.04);
        box-shadow: 0 6px 18px rgba(105, 108, 255, 0.35);
        color: white;
    }

    /* Floating Illustration Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-6px); }
        100% { transform: translateY(0px); }
    }

    .floating-img {
        animation: float 4s ease-in-out infinite;
    }

    /* Proportional Mobile Rules */
    @media (max-width: 768px) {
        .premium-container {
            padding-top: 0.75rem;
            padding-bottom: 1.5rem;
        }
        .welcome-card {
            border-radius: 1.25rem;
            margin-bottom: 0.85rem !important;
        }
        .welcome-card .card-body {
            padding: 1.15rem 0.95rem !important;
        }
        .welcome-card h2 {
            font-size: 1.3rem !important;
        }
        .welcome-card h4 {
            font-size: 0.9rem !important;
            margin-bottom: 0.35rem !important;
        }
        .welcome-card p {
            font-size: 0.78rem !important;
            margin-bottom: 0 !important;
        }
        .floating-img {
            height: 95px !important;
        }
        .service-card {
            padding: 1.15rem 0.65rem;
            border-radius: 1rem;
        }
        .icon-wrapper {
            width: 54px;
            height: 54px;
            border-radius: 0.9rem;
            margin-bottom: 0.75rem;
        }
        .icon-img {
            width: 32px;
            height: 32px;
        }
        .service-card h5 {
            font-size: 0.9rem;
            margin-bottom: 0.35rem !important;
        }
        .service-card p {
            font-size: 0.72rem;
            min-height: 2.7em;
            margin-bottom: 0.75rem !important;
            line-height: 1.25;
        }
        .btn-premium {
            padding: 0.4rem 0.75rem;
            font-size: 0.78rem;
            width: 95%;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 premium-container">
    <!-- Welcome Hero Banner -->
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            <div class="card welcome-card">
                <div class="d-flex align-items-center row">
                    <div class="col-7 col-sm-8 order-1">
                        <div class="card-body p-3 p-md-4">
                            <h2 class="display-6 gradient-text mb-1 mb-md-2">สกจ.บริหารทั่วไป</h2>
                            <h4 class="fw-medium text-dark mb-1 mb-md-2">ยินดีต้อนรับสู่ระบบงานส่วนกลาง 👋</h4>
                            <p class="mb-0 text-muted fs-6">
                                โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
                                <span class="badge bg-label-primary rounded-pill ms-md-2 d-none d-sm-inline-block">Smart Management System</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-5 col-sm-4 text-end text-sm-center order-2 pe-3 pe-sm-4">
                        <img src="<?=base_url();?>assets/img/illustrations/man-with-laptop-light.png"
                            height="135" alt="Welcome Illustration" class="floating-img me-2 me-sm-0"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Core Services Grid (2 Columns on Mobile, 4 Columns on Desktop) -->
    <div class="row g-2 g-md-3 justify-content-center">
        <!-- จองสถานที่ -->
        <div class="col-6 col-lg-3">
            <a href="<?=base_url('Booking');?>" class="text-decoration-none h-100 d-block">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <img src="https://cdn-icons-png.flaticon.com/128/1908/1908239.png"
                            class="icon-img" alt="จองสถานที่">
                    </div>
                    <h5 class="mb-2 fw-bold text-dark">จองสถานที่</h5>
                    <p class="text-muted mb-3 px-1">ห้องประชุม หอประชุม และอาคาร</p>
                    <button class="btn btn-premium">เข้าใช้งาน</button>
                </div>
            </a>
        </div>

        <!-- จองยานพาหนะ -->
        <div class="col-6 col-lg-3">
            <a href="<?=base_url('CarBooking');?>" class="text-decoration-none h-100 d-block">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <img src="https://cdn-icons-png.flaticon.com/128/11649/11649708.png"
                            class="icon-img" alt="จองยานพาหนะ">
                    </div>
                    <h5 class="mb-2 fw-bold text-dark">จองยานพาหนะ</h5>
                    <p class="text-muted mb-3 px-1">รถยนต์ส่วนกลาง รถตู้ และรถรับส่ง</p>
                    <button class="btn btn-premium">เข้าใช้งาน</button>
                </div>
            </a>
        </div>

        <!-- แจ้งซ่อมออนไลน์ -->
        <div class="col-6 col-lg-3">
            <a href="<?=base_url('Repair');?>" class="text-decoration-none h-100 d-block">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <img src="https://cdn-icons-png.flaticon.com/128/10203/10203414.png"
                            class="icon-img" alt="แจ้งซ่อมออนไลน์">
                    </div>
                    <h5 class="mb-2 fw-bold text-dark">แจ้งซ่อมออนไลน์</h5>
                    <p class="text-muted mb-3 px-1">แจ้งปัญหาไฟฟ้า ประปา และงานซ่อม</p>
                    <button class="btn btn-premium">เข้าใช้งาน</button>
                </div>
            </a>
        </div>

        <!-- รายการอาหาร -->
        <div class="col-6 col-lg-3">
            <a href="<?=base_url('FoodReport');?>" class="text-decoration-none h-100 d-block">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <img src="https://cdn-icons-png.flaticon.com/128/3595/3595458.png"
                            class="icon-img" alt="รายการอาหาร">
                    </div>
                    <h5 class="mb-2 fw-bold text-dark">รายการอาหาร</h5>
                    <p class="text-muted mb-3 px-1">ตรวจเมนูอาหาร และรายงานประจำวัน</p>
                    <button class="btn btn-premium">เข้าใช้งาน</button>
                </div>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

