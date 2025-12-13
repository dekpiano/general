<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>

<?= $this->section('content') ?>

<style>
/* Welcome Card Gradient */
.welcome-card {
    background: linear-gradient(135deg, #696cff 0%, #8592ff 50%, #a5aeff 100%);
    border-radius: 16px;
    position: relative;
    overflow: hidden;
    min-height: 220px;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.welcome-card::after {
    content: '';
    position: absolute;
    bottom: -30%;
    right: 10%;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}

.welcome-illustration {
    position: absolute;
    right: 30px;
    bottom: 0;
    height: 180px;
    opacity: 0.9;
}

/* Stats Cards */
.stats-card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    overflow: hidden;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}

.stats-card .card-body {
    padding: 1.5rem;
}

.stats-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stats-icon.primary { background: rgba(105, 108, 255, 0.16); color: #696cff; }
.stats-icon.success { background: rgba(113, 221, 55, 0.16); color: #71dd37; }
.stats-icon.warning { background: rgba(255, 171, 0, 0.16); color: #ffab00; }
.stats-icon.info { background: rgba(3, 195, 236, 0.16); color: #03c3ec; }
.stats-icon.danger { background: rgba(255, 62, 29, 0.16); color: #ff3e1d; }

.stats-value {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1.2;
}

/* Quick Access Cards */
.quick-access-card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    display: block;
}

.quick-access-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}

.quick-access-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin-bottom: 1rem;
}

.quick-access-icon.building {
    background: linear-gradient(135deg, #696cff, #8592ff);
    color: #fff;
}

.quick-access-icon.car {
    background: linear-gradient(135deg, #ffab00, #ffc107);
    color: #fff;
}

.quick-access-icon.driver {
    background: linear-gradient(135deg, #03c3ec, #00d4ff);
    color: #fff;
}

.quick-access-icon.settings {
    background: linear-gradient(135deg, #8592a3, #a1acb8);
    color: #fff;
}

/* Section Headers */
.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-header h5 {
    margin: 0;
    font-weight: 600;
    color: #566a7f;
}

.section-header .badge {
    margin-left: 10px;
    font-size: 0.75rem;
    padding: 0.4em 0.8em;
}

/* Activity Timeline */
.activity-timeline {
    position: relative;
    padding-left: 30px;
}

.activity-timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e7e7e8;
}

.activity-item {
    position: relative;
    padding-bottom: 1.5rem;
}

.activity-item::before {
    content: '';
    position: absolute;
    left: -24px;
    top: 4px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #696cff;
    border: 2px solid #fff;
    box-shadow: 0 0 0 4px rgba(105, 108, 255, 0.16);
}

.activity-item.success::before { background: #71dd37; box-shadow: 0 0 0 4px rgba(113, 221, 55, 0.16); }
.activity-item.warning::before { background: #ffab00; box-shadow: 0 0 0 4px rgba(255, 171, 0, 0.16); }
.activity-item.info::before { background: #03c3ec; box-shadow: 0 0 0 4px rgba(3, 195, 236, 0.16); }

/* Animated Counter */
@keyframes countUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-count {
    animation: countUp 0.6s ease-out forwards;
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-illustration {
        display: none;
    }
    
    .welcome-card {
        min-height: 180px;
    }
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card text-white p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="fw-bold mb-2 text-white">ยินดีต้อนรับ, <?=$_SESSION['username']?>! 👋</h3>
                        <p class="mb-3 opacity-90">ระบบจัดการงานบริหารทั่วไป โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ)</p>
                        <div class="d-flex gap-3">
                            <a href="<?=base_url('Booking/Approve/Admin')?>" class="btn btn-light btn-sm px-3">
                                <i class='bx bx-calendar-check me-1'></i> ดูรายการจอง
                            </a>
                            <a href="<?=base_url('CarBooking/Approve/Admin')?>" class="btn btn-outline-light btn-sm px-3">
                                <i class='bx bx-car me-1'></i> ดูการจองรถ
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <img src="<?=base_url()?>/assets/img/illustrations/man-with-laptop-light.png" 
                             alt="Welcome" class="welcome-illustration">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="section-header">
        <h5><i class='bx bx-stats me-2'></i> ภาพรวมระบบ</h5>
        <span class="badge bg-label-primary">สถิติทั้งหมด</span>
    </div>
    
    <div class="row mb-4">
        <!-- Location Room Stats -->
        <div class="col-sm-6 col-xl-3 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted d-block mb-1">ห้อง/สถานที่</span>
                            <h3 class="stats-value text-primary animate-count"><?=$LocationRoomAll;?></h3>
                            <small class="text-success">
                                <i class='bx bx-check-circle'></i> พร้อมใช้งาน
                            </small>
                        </div>
                        <div class="stats-icon primary">
                            <i class='bx bxs-building-house'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Car Stats -->
        <div class="col-sm-6 col-xl-3 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted d-block mb-1">ยานพาหนะ</span>
                            <h3 class="stats-value text-warning animate-count"><?=$CarAll;?></h3>
                            <small class="text-success">
                                <i class='bx bx-check-circle'></i> พร้อมใช้งาน
                            </small>
                        </div>
                        <div class="stats-icon warning">
                            <i class='bx bxs-car'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Driver Stats -->
        <div class="col-sm-6 col-xl-3 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted d-block mb-1">พนักงานขับรถ</span>
                            <h3 class="stats-value text-info animate-count"><?=$DriverAll;?></h3>
                            <small class="text-success">
                                <i class='bx bx-user-check'></i> ประจำการ
                            </small>
                        </div>
                        <div class="stats-icon info">
                            <i class='bx bxs-user-badge'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Pending Stats -->
        <div class="col-sm-6 col-xl-3 mb-4">
            <div class="card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted d-block mb-1">รออนุมัติ</span>
                            <h3 class="stats-value text-danger animate-count"><?=isset($PendingBooking) ? $PendingBooking : 0;?></h3>
                            <small class="text-warning">
                                <i class='bx bx-time-five'></i> รอดำเนินการ
                            </small>
                        </div>
                        <div class="stats-icon danger">
                            <i class='bx bxs-bell-ring'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Section -->
    <div class="section-header">
        <h5><i class='bx bx-grid-alt me-2'></i> เมนูลัด</h5>
        <span class="badge bg-label-info">เข้าถึงด่วน</span>
    </div>

    <div class="row mb-4">
        <!-- งานอาคารสถานที่ -->
        <div class="col-sm-6 col-xl-3 mb-4">
            <a href="<?=base_url('Admin/LocationRoom/LocationRoomMain')?>" class="quick-access-card card h-100">
                <div class="card-body text-center py-4">
                    <div class="quick-access-icon building mx-auto">
                        <i class='bx bxs-building'></i>
                    </div>
                    <h6 class="mb-1 fw-semibold">ห้องประชุม/สถานที่</h6>
                    <small class="text-muted">จัดการห้องประชุม</small>
                    <div class="mt-3">
                        <span class="badge bg-primary"><?=$LocationRoomAll;?> รายการ</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- งานยานพาหนะ -->
        <div class="col-sm-6 col-xl-3 mb-4">
            <a href="<?=base_url('Admin/Car/CarMain')?>" class="quick-access-card card h-100">
                <div class="card-body text-center py-4">
                    <div class="quick-access-icon car mx-auto">
                        <i class='bx bxs-car'></i>
                    </div>
                    <h6 class="mb-1 fw-semibold">รถยนต์</h6>
                    <small class="text-muted">จัดการยานพาหนะ</small>
                    <div class="mt-3">
                        <span class="badge bg-warning"><?=$CarAll;?> คัน</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- คนขับรถ -->
        <div class="col-sm-6 col-xl-3 mb-4">
            <a href="<?=base_url('Admin/Car/CarDriver')?>" class="quick-access-card card h-100">
                <div class="card-body text-center py-4">
                    <div class="quick-access-icon driver mx-auto">
                        <i class='bx bxs-user-account'></i>
                    </div>
                    <h6 class="mb-1 fw-semibold">พนักงานขับรถ</h6>
                    <small class="text-muted">จัดการคนขับรถ</small>
                    <div class="mt-3">
                        <span class="badge bg-info"><?=$DriverAll;?> คน</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- กำหนดสิทธิ์ -->
        <?php if($_SESSION['id'] == "pers_021") : ?>
        <div class="col-sm-6 col-xl-3 mb-4">
            <a href="<?=base_url('Admin/Rloes/Setting')?>" class="quick-access-card card h-100">
                <div class="card-body text-center py-4">
                    <div class="quick-access-icon settings mx-auto">
                        <i class='bx bxs-cog'></i>
                    </div>
                    <h6 class="mb-1 fw-semibold">กำหนดสิทธิ์</h6>
                    <small class="text-muted">จัดการสิทธิ์ผู้ใช้</small>
                    <div class="mt-3">
                        <span class="badge bg-secondary">ผู้ดูแลระบบ</span>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Activity & Info Section -->
    <div class="row">
        <!-- Quick Links -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class='bx bx-link-alt text-primary me-2'></i>ลิงก์ด่วน
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="<?=base_url('Booking/Approve/Admin')?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class='bx bx-calendar-event text-primary me-2'></i>
                                อนุมัติการจองห้องประชุม
                            </div>
                            <i class='bx bx-chevron-right'></i>
                        </a>
                        <a href="<?=base_url('CarBooking/Approve/Admin')?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class='bx bx-car text-warning me-2'></i>
                                อนุมัติการจองรถ
                            </div>
                            <i class='bx bx-chevron-right'></i>
                        </a>
                        <a href="<?=base_url('Repair/Update')?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class='bx bx-wrench text-info me-2'></i>
                                จัดการงานแจ้งซ่อม
                            </div>
                            <i class='bx bx-chevron-right'></i>
                        </a>
                        <a href="<?=base_url('Booking/Statistics')?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class='bx bx-bar-chart-alt-2 text-success me-2'></i>
                                ดูสถิติการจอง
                            </div>
                            <i class='bx bx-chevron-right'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class='bx bx-info-circle text-info me-2'></i>ข้อมูลระบบ
                    </h5>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        <div class="activity-item success">
                            <div class="d-flex justify-content-between">
                                <strong>ระบบจองห้องประชุม</strong>
                                <span class="badge bg-label-success">เปิดใช้งาน</span>
                            </div>
                            <small class="text-muted">จองห้องประชุมและสถานที่ออนไลน์</small>
                        </div>
                        <div class="activity-item success">
                            <div class="d-flex justify-content-between">
                                <strong>ระบบจองรถ</strong>
                                <span class="badge bg-label-success">เปิดใช้งาน</span>
                            </div>
                            <small class="text-muted">จองรถยนต์สำหรับกิจกรรมต่างๆ</small>
                        </div>
                        <div class="activity-item success">
                            <div class="d-flex justify-content-between">
                                <strong>ระบบแจ้งซ่อม</strong>
                                <span class="badge bg-label-success">เปิดใช้งาน</span>
                            </div>
                            <small class="text-muted">แจ้งซ่อมอุปกรณ์และสิ่งอำนวยความสะดวก</small>
                        </div>
                        <div class="activity-item info">
                            <div class="d-flex justify-content-between">
                                <strong>เวอร์ชันระบบ</strong>
                                <span class="badge bg-label-info">v2.0.0</span>
                            </div>
                            <small class="text-muted">อัปเดตล่าสุด: ธันวาคม 2568</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Animated counter effect
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.stats-value');
    
    counters.forEach(counter => {
        const target = parseInt(counter.innerText);
        const duration = 1000;
        const step = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.innerText = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.innerText = target;
            }
        };
        
        updateCounter();
    });
});
</script>
<?= $this->endSection() ?>
