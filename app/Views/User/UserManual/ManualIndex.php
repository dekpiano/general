<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>
<?= $this->section('customCSS') ?>
<style>
    /* --- Premium Variables --- */
    :root {
        --manual-primary: #696cff;
        --manual-gradient: linear-gradient(135deg, #696cff 0%, #8e92ff 50%, #a5a8ff 100%);
    }

    /* --- Hero Section --- */
    .manual-hero-section {
        background: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        border-radius: 24px;
        padding: 3.5rem 2.5rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 20px 50px -15px rgba(105, 108, 255, 0.4);
    }

    .manual-hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .manual-hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: 5%;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .manual-hero-section * {
        position: relative;
        z-index: 2;
    }

    .manual-hero-section h1 {
        font-size: 2.75rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 0.75rem;
    }

    .manual-hero-section p {
        font-size: 1.15rem;
        opacity: 0.85;
        max-width: 600px;
    }

    /* --- Manual Cards --- */
    .manual-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .manual-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
    }

    .manual-card .card-icon-wrapper {
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .manual-card .card-icon-wrapper::before {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        opacity: 0.1;
        top: -50px;
        right: -50px;
    }

    .manual-card .card-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        transition: transform 0.3s ease;
    }

    .manual-card:hover .card-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .manual-card .card-body {
        padding: 1.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .manual-card .card-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.75rem;
    }

    .manual-card .card-text {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
        flex: 1;
    }

    .manual-card .btn-view-manual {
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .manual-card .btn-view-manual:hover {
        transform: translateX(5px);
    }

    /* Card Themes */
    .manual-card.theme-blue .card-icon-wrapper { background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); }
    .manual-card.theme-blue .card-icon-wrapper::before { background: #0ea5e9; }
    .manual-card.theme-blue .card-icon { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: #fff; }
    .manual-card.theme-blue .btn-view-manual { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: #fff; border: none; }

    .manual-card.theme-purple .card-icon-wrapper { background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); }
    .manual-card.theme-purple .card-icon-wrapper::before { background: #a855f7; }
    .manual-card.theme-purple .card-icon { background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%); color: #fff; }
    .manual-card.theme-purple .btn-view-manual { background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%); color: #fff; border: none; }

    .manual-card.theme-orange .card-icon-wrapper { background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%); }
    .manual-card.theme-orange .card-icon-wrapper::before { background: #f97316; }
    .manual-card.theme-orange .card-icon { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: #fff; }
    .manual-card.theme-orange .btn-view-manual { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: #fff; border: none; }

    .manual-card.theme-green .card-icon-wrapper { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); }
    .manual-card.theme-green .card-icon-wrapper::before { background: #10b981; }
    .manual-card.theme-green .card-icon { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; }
    .manual-card.theme-green .btn-view-manual { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border: none; }

    /* Animation */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-card {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    .animate-card:nth-child(1) { animation-delay: 0.1s; }
    .animate-card:nth-child(2) { animation-delay: 0.2s; }
    .animate-card:nth-child(3) { animation-delay: 0.3s; }
    .animate-card:nth-child(4) { animation-delay: 0.4s; }

    /* Search Box */
    .manual-search {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        color: #fff;
        width: 100%;
        max-width: 400px;
        transition: all 0.3s ease;
    }

    .manual-search::placeholder {
        color: rgba(255,255,255,0.6);
    }

    .manual-search:focus {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.4);
        outline: none;
        box-shadow: 0 0 0 4px rgba(255,255,255,0.1);
    }

    /* Responsive */
    @media (max-width: 767px) {
        .manual-hero-section {
            padding: 2rem 1.5rem;
            text-align: center;
        }
        .manual-hero-section h1 {
            font-size: 1.75rem;
        }
        .manual-hero-section p {
            font-size: 1rem;
        }
    }
</style>
<?= $this->endSection() ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Hero Section -->
    <div class="manual-hero-section">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-white bg-opacity-25 rounded-3 p-2 me-3">
                        <i class="bx bxs-book-content text-white fs-3"></i>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?=base_url('/')?>" class="text-white-50">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active text-white">คู่มือการใช้งาน</li>
                        </ol>
                    </nav>
                </div>
                <h1 class="text-white mb-2">ศูนย์รวมคู่มือการใช้งาน</h1>
                <p class="text-white-50 mb-0">เรียนรู้วิธีการใช้งานระบบต่างๆ ภายในโรงเรียน ด้วยคู่มือที่ละเอียดและเข้าใจง่าย</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="position-relative d-inline-block w-100">
                    <i class="bx bx-search position-absolute top-50 start-0 translate-middle-y ms-4 text-white-50"></i>
                    <input type="text" class="manual-search ps-5" id="searchManual" placeholder="ค้นหาคู่มือ...">
                </div>
            </div>
        </div>
    </div>

    <!-- Manual Cards Grid -->
    <div class="row g-4" id="manualCards">
        
        <!-- Booking Manual -->
        <div class="col-md-6 col-xl-3 animate-card manual-item" data-keywords="จองห้อง สถานที่ ห้องประชุม booking room">
            <div class="manual-card theme-blue h-100">
                <div class="card-icon-wrapper">
                    <div class="card-icon">
                        <i class="bx bxs-calendar-check"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">ระบบจองห้อง/สถานที่</h5>
                    <p class="card-text">
                        เรียนรู้วิธีการจองห้องประชุม สถานที่ ตรวจสอบตารางว่าง และติดตามสถานะการอนุมัติ
                    </p>
                    <div class="mt-auto pt-3">
                        <a href="<?= base_url('manual/booking') ?>" class="btn btn-view-manual w-100">
                            <i class="bx bx-book-open me-1"></i> อ่านคู่มือ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Car Booking Manual -->
        <div class="col-md-6 col-xl-3 animate-card manual-item" data-keywords="จองรถ ยานพาหนะ car vehicle booking transport">
            <div class="manual-card theme-purple h-100">
                <div class="card-icon-wrapper">
                    <div class="card-icon">
                        <i class="bx bxs-car"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">ระบบจองยานพาหนะ</h5>
                    <p class="card-text">
                        เรียนรู้วิธีการจองรถ ตรวจสอบตารางเดินรถ และระบบอนุมัติการใช้ยานพาหนะ
                    </p>
                    <div class="mt-auto pt-3">
                        <a href="<?= base_url('manual/car-booking') ?>" class="btn btn-view-manual w-100">
                            <i class="bx bx-book-open me-1"></i> อ่านคู่มือ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Repair Manual -->
        <div class="col-md-6 col-xl-3 animate-card manual-item" data-keywords="แจ้งซ่อม ซ่อมบำรุง repair maintenance fix">
            <div class="manual-card theme-orange h-100">
                <div class="card-icon-wrapper">
                    <div class="card-icon">
                        <i class="bx bxs-wrench"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">ระบบแจ้งซ่อมออนไลน์</h5>
                    <p class="card-text">
                        เรียนรู้วิธีการแจ้งซ่อมอุปกรณ์ ติดตามสถานะงานซ่อม และดูประวัติการซ่อมบำรุง
                    </p>
                    <div class="mt-auto pt-3">
                        <a href="<?= base_url('manual/repair') ?>" class="btn btn-view-manual w-100">
                            <i class="bx bx-book-open me-1"></i> อ่านคู่มือ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Food Report Manual -->
        <div class="col-md-6 col-xl-3 animate-card manual-item" data-keywords="รายงานอาหาร โภชนาการ food report meal nutrition">
            <div class="manual-card theme-green h-100">
                <div class="card-icon-wrapper">
                    <div class="card-icon">
                        <i class="bx bxs-dish"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">ระบบรายงานอาหาร</h5>
                    <p class="card-text">
                        เรียนรู้วิธีการบันทึกรายงานอาหาร อัปโหลดรูปภาพ และพิมพ์รายงานประจำวัน
                    </p>
                    <div class="mt-auto pt-3">
                        <a href="<?= base_url('manual/food-report') ?>" class="btn btn-view-manual w-100">
                            <i class="bx bx-book-open me-1"></i> อ่านคู่มือ
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Manual -->
        <div class="col-md-6 col-xl-3 animate-card manual-item" data-keywords="ยืมคืน พัสดุ อุปกรณ์ equipment borrow return โสต เครื่องมือ">
            <div class="manual-card theme-blue h-100">
                <div class="card-icon-wrapper" style="background: linear-gradient(135deg, rgba(105, 108, 255, 0.1) 0%, rgba(63, 65, 145, 0.15) 100%);">
                    <div class="card-icon text-primary">
                        <i class="bx bxs-box"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">ระบบยืม-คืนพัสดุอุปกรณ์</h5>
                    <p class="card-text">
                        เรียนรู้วิธีการยืมพัสดุ ตรวจสอบสต็อก การอนุมัติ ส่งมอบถ่ายภาพ และตรวจรับคืนเข้าสต็อก
                    </p>
                    <div class="mt-auto pt-3">
                        <a href="<?= base_url('manual/equipment') ?>" class="btn btn-view-manual w-100">
                            <i class="bx bx-book-open me-1"></i> อ่านคู่มือ
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- No Results Message -->
    <div class="text-center py-5 d-none" id="noResults">
        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
            <i class="bx bx-search-alt-2 text-muted" style="font-size: 3rem;"></i>
        </div>
        <h4 class="text-muted">ไม่พบคู่มือที่ค้นหา</h4>
        <p class="text-secondary">ลองค้นหาด้วยคำอื่น หรือ <a href="javascript:void(0)" onclick="document.getElementById('searchManual').value=''; filterManuals('');">ดูคู่มือทั้งหมด</a></p>
    </div>

    <!-- Help Section -->
    <div class="card mt-5 border-0 bg-label-primary bg-opacity-50">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="fw-bold text-primary mb-2">
                        <i class="bx bx-help-circle me-2"></i>
                        ต้องการความช่วยเหลือเพิ่มเติม?
                    </h5>
                    <p class="text-secondary mb-0">
                        หากมีคำถามหรือปัญหาการใช้งานระบบ สามารถติดต่อทีมงานสนับสนุนได้ตลอดเวลาทำการ
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="<?= base_url('/') ?>" class="btn btn-primary rounded-pill px-4">
                        <i class="bx bx-home-alt me-1"></i> กลับหน้าหลัก
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchManual');
    const manualItems = document.querySelectorAll('.manual-item');
    const noResults = document.getElementById('noResults');
    const manualCards = document.getElementById('manualCards');

    searchInput.addEventListener('input', function() {
        filterManuals(this.value);
    });

    window.filterManuals = function(query) {
        const searchTerm = query.toLowerCase().trim();
        let visibleCount = 0;

        manualItems.forEach(function(item) {
            const title = item.querySelector('.card-title').textContent.toLowerCase();
            const description = item.querySelector('.card-text').textContent.toLowerCase();
            const keywords = item.dataset.keywords.toLowerCase();

            if (title.includes(searchTerm) || description.includes(searchTerm) || keywords.includes(searchTerm) || searchTerm === '') {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
            manualCards.classList.add('d-none');
        } else {
            noResults.classList.add('d-none');
            manualCards.classList.remove('d-none');
        }
    };
});
</script>
<?= $this->endSection() ?>
