<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --accent-gradient: linear-gradient(135deg, #ff6b9d 0%, #ee0979 100%);
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.4);
    }

    .premium-container {
        padding-top: 2rem;
        padding-bottom: 4rem;
        position: relative;
        overflow: hidden;
    }

    .premium-container::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: var(--primary-gradient);
        opacity: 0.05;
        border-radius: 50%;
        z-index: -1;
    }

    /* Welcome Card Styling */
    .welcome-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .welcome-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(105, 108, 255, 0.1);
    }

    .gradient-text {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
    }

    /* Service Card Styling */
    .service-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 2rem;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2.5rem 1.5rem;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .service-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 2rem;
        background: var(--primary-gradient);
        opacity: 0;
        z-index: -1;
        transition: opacity 0.4s ease;
    }

    .service-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 20px 40px rgba(105, 108, 255, 0.15);
    }

    .service-card:hover h5 {
        color: #696cff !important;
    }

    .icon-wrapper {
        width: 100px;
        height: 100px;
        background: #f0f2ff;
        border-radius: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        transition: all 0.4s ease;
        position: relative;
    }

    .icon-wrapper::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: var(--primary-gradient);
        border-radius: 1.5rem;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.4s ease;
    }

    .service-card:hover .icon-wrapper {
        background: transparent;
    }

    .service-card:hover .icon-wrapper::before {
        opacity: 0.1;
        transform: scale(1.1);
    }

    .icon-img {
        width: 60px;
        height: 60px;
        z-index: 2;
        transition: transform 0.4s ease;
    }

    .service-card:hover .icon-img {
        transform: scale(1.1) rotate(5deg);
    }

    /* Button Styling */
    .btn-premium {
        background: var(--primary-gradient);
        border: none;
        border-radius: 50px;
        padding: 0.6rem 2rem;
        color: white;
        font-weight: 500;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(105, 108, 255, 0.3);
        transition: all 0.3s ease;
        width: 80%;
        margin-top: auto;
    }

    .btn-premium:hover {
        background: var(--primary-gradient);
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(105, 108, 255, 0.4);
        color: white;
    }

    /* Floating Animations */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .floating-img {
        animation: float 4s ease-in-out infinite;
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .service-card {
            margin-bottom: 1rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 premium-container">
    <!-- Welcome Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10 col-md-12">
            <div class="card welcome-card">
                <div class="d-flex align-items-center row">
                    <div class="col-sm-7 order-2 order-sm-1">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="display-6 gradient-text mb-2">สกจ.บริหารทั่วไป</h2>
                            <h4 class="fw-medium text-dark mb-3">ยินดีต้อนรับสู่ระบบงานส่วนกลาง 👋</h4>
                            <p class="mb-4 text-muted fs-5">
                                โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์<br>
                                <span class="badge bg-label-primary rounded-pill mt-2">Smart Management System</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center order-1 order-sm-2">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="<?=base_url();?>assets/img/illustrations/man-with-laptop-light.png"
                                height="200" alt="Welcome Illustration" class="floating-img"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Grid -->
    <div class="row g-4 justify-content-center">
        <!-- จองสถานที่ -->
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="<?=base_url('Booking');?>" class="text-decoration-none h-100 d-block">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <img src="https://cdn-icons-png.flaticon.com/128/1908/1908239.png"
                            class="icon-img" alt="จองสถานที่">
                    </div>
                    <h5 class="mb-3 fw-bold text-dark">จองสถานที่</h5>
                    <p class="text-muted mb-4 px-2small">ห้องประชุม, หอประชุม, <br>สนามกีฬา และอาคารต่าง ๆ</p>
                    <button class="btn btn-premium">เข้าใช้งาน</button>
                </div>
            </a>
        </div>

        <!-- จองยานพาหนะ -->
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="<?=base_url('CarBooking');?>" class="text-decoration-none h-100 d-block">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <img src="https://cdn-icons-png.flaticon.com/128/11649/11649708.png"
                            class="icon-img" alt="จองยานพาหนะ">
                    </div>
                    <h5 class="mb-3 fw-bold text-dark">จองยานพาหนะ</h5>
                    <p class="text-muted mb-4 px-2small">รถยนต์ส่วนกลาง, รถตู้, <br>และรถรับส่งนักเรียน</p>
                    <button class="btn btn-premium">เข้าใช้งาน</button>
                </div>
            </a>
        </div>

        <!-- แจ้งซ่อมออนไลน์ -->
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="<?=base_url('Repair');?>" class="text-decoration-none h-100 d-block">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <img src="https://cdn-icons-png.flaticon.com/128/10203/10203414.png"
                            class="icon-img" alt="แจ้งซ่อมออนไลน์">
                    </div>
                    <h5 class="mb-3 fw-bold text-dark">แจ้งซ่อมออนไลน์</h5>
                    <p class="text-muted mb-4 px-2small">แจ้งปัญหาอุปกรณ์ไฟฟ้า, <br>ประปา และงานซ่อมบำรุง</p>
                    <button class="btn btn-premium">เข้าใช้งาน</button>
                </div>
            </a>
        </div>

        <!-- รายการอาหาร -->
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="<?=base_url('FoodReport');?>" class="text-decoration-none h-100 d-block">
                <div class="service-card">
                    <div class="icon-wrapper">
                        <img src="https://cdn-icons-png.flaticon.com/128/3595/3595458.png"
                            class="icon-img" alt="รายการอาหาร">
                    </div>
                    <h5 class="mb-3 fw-bold text-dark">รายการอาหาร</h5>
                    <p class="text-muted mb-4 px-2small">ตรวจสอบรายการอาหาร<br>และบันทึกรายงานประจำวัน</p>
                    <button class="btn btn-premium">เข้าใช้งาน</button>
                </div>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

