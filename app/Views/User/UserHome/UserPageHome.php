<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y demo ">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12 col-12 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h4 class="card-title fw-bold text-primary">สกจ.บริหารทั่วไป ยินดีตอนรับ! 🎉</h4>
                            <p class="mb-4">
                                โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5  text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="<?=base_url();?>assets/img/illustrations/man-with-laptop-light.png"
                                height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <style>
    .icon-hero {
        width: 70px;
        height: 70px;
        margin-bottom: 16px;
        filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.2));
        transition: transform 0.3s ease;
    }

    .card-hover {
        border: none;
        transition: 0.18s cubic-bezier(.4, 2, .34, 1);
        background: rgba(255, 255, 255, 0.96);
        border-radius: 2rem;
        box-shadow: 0 1px 12px 2px rgba(84, 121, 255, .07), 0 1.5px 8px rgba(100, 100, 200, .06);
    }

    .card-hover:hover {
        box-shadow: 0 8px 32px rgba(84, 121, 255, .18), 0 1.5px 8px rgba(112, 124, 255, .10);
        transform: translateY(-3px) scale(1.035);
        background: #f7faff;
    }
    </style>

    <div class="row justify-content-center g-4">
        <!-- จองสถานที่ -->
        <div class="col-12 col-md-3">
            <a href="<?=base_url('Booking');?>" class="text-decoration-none">
                <div class="card card-hover rounded-4 shadow-sm p-4 h-100 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/1908/1908239.png"
                        class="icon-hero align-self-center" alt="จองสถานที่">
                    <h5 class="mb-2 fw-bold text-primary">จองสถานที่</h5>
                    <div class="text-secondary mb-3">ห้องประชุม, หอประชุม, สนามกีฬา ฯลฯ</div>
                    <button class="btn btn-primary w-75 mx-auto">เข้าสู่ระบบ</button>
                </div>
            </a>
        </div>
        <!-- จองยานพาหนะ -->
        <div class="col-12 col-md-3">
            <a href="<?=base_url('CarBooking');?>" class="text-decoration-none">
                <div class="card card-hover rounded-4 shadow-sm p-4 h-100 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/11649/11649708.png"
                        class="icon-hero align-self-center" alt="จองยานพาหนะ">
                    <h5 class="mb-2 fw-bold text-primary">จองยานพาหนะ</h5>
                    <div class="text-secondary mb-3">รถยนต์, รถตู้, รถรับส่ง, ฯลฯ</div>
                    <button class="btn btn-primary w-75 mx-auto">เข้าสู่ระบบ</button>
                </div>
            </a>
        </div>
        <!-- แจ้งซ่อมออนไลน์ -->
        <div class="col-12 col-md-3">
            <a href="<?=base_url('Repair');?>" class="text-decoration-none">
                <div class="card card-hover rounded-4 shadow-sm p-4 h-100 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/10203/10203414.png"
                        class="icon-hero align-self-center" alt="แจ้งซ่อมออนไลน์">
                    <h5 class="mb-2 fw-bold text-primary">แจ้งซ่อมออนไลน์</h5>
                    <div class="text-secondary mb-3">แจ้งปัญหาอุปกรณ์, ระบบต่าง ๆ</div>
                    <button class="btn btn-primary w-75 mx-auto text-white">เข้าสู่ระบบ</button>
                </div>
            </a>
        </div>
        <!-- รายการอาหาร -->
        <div class="col-12 col-md-3">
            <a href="<?=base_url('FoodReport');?>" class="text-decoration-none">
                <div class="card card-hover rounded-4 shadow-sm p-4 h-100 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/3595/3595458.png"
                        class="icon-hero align-self-center" alt="รายการอาหาร">
                    <h5 class="mb-2 fw-bold text-primary">รายการอาหาร</h5>
                    <div class="text-secondary mb-3">ดูและบันทึกรายงานอาหารประจำวัน</div>
                    <button class="btn btn-primary w-75 mx-auto">เข้าสู่ระบบ</button>
                </div>
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
