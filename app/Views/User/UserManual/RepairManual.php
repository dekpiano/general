<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>
<?= $this->section('customCSS') ?>
<style>
    .manual-hero {
        background: linear-gradient(135deg, #FF9966 0%, #FF5E62 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    .step-card {
        border: none;
        border-radius: 16px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .step-number {
        font-size: 2.5rem;
        font-weight: 900;
        color: rgba(67, 89, 113, 0.1);
        line-height: 1;
        margin-bottom: 1rem;
    }
    .step-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(253, 126, 20, 0.1);
        color: #fd7e14;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    .screenshot-placeholder {
        background: #f8f9fa;
        border-radius: 12px;
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #d9dee3;
        color: #a1acb8;
        font-weight: 500;
        transition: all 0.3s;
    }
    .screenshot-placeholder:hover {
        border-color: #fd7e14;
        color: #fd7e14;
        background: rgba(253, 126, 20, 0.05);
    }
    .nav-pills .nav-link.active {
        background-color: #fd7e14;
        box-shadow: 0 4px 10px rgba(253, 126, 20, 0.4);
    }
    .accordion-button:not(.collapsed) {
        background-color: rgba(253, 126, 20, 0.1);
        color: #fd7e14;
    }
</style>
<?= $this->endSection() ?>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h2 class="manual-hero mb-2 display-6">คู่มือการใช้งานระบบแจ้งซ่อม</h2>
        <p class="text-muted fs-5">แจ้งปัญหาและติดตามสถานะการซ่อมบำรุงวัสดุครุภัณฑ์ภายในโรงเรียน</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 col-lg-6">
            <ul class="nav nav-pills nav-fill p-1 bg-white rounded-pill shadow-sm border" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active rounded-pill py-2" data-bs-toggle="pill" data-bs-target="#user-manual" type="button">
                        <i class="bx bx-user me-1"></i> สำหรับผู้แจ้ง (User)
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link rounded-pill py-2" data-bs-toggle="pill" data-bs-target="#admin-manual" type="button">
                        <i class="bx bx-wrench me-1"></i> สำหรับช่าง/ผู้ดูแล (Admin)
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content border-0 shadow-none p-0 mt-0">
        
        <!-- User Manual -->
        <div class="tab-pane fade show active" id="user-manual">
            <div class="row g-4">
                
                <!-- Step 1 -->
                <div class="col-12">
                    <div class="card step-card p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 order-md-1">
                                <div class="p-3">
                                    <div class="step-number">01</div>
                                    <h4 class="fw-bold mb-3 text-warning">ไปที่เมนูแจ้งซ่อม</h4>
                                    <p class="text-secondary mb-4">
                                        เข้าสู่ระบบและเลือกเมนู <strong>"แจ้งซ่อมออนไลน์"</strong> ท่านสามารถดูประวัติการแจ้งซ่อมของตนเอง
                                        และติดตามสถานะงานซ่อมต่างๆ ได้จากหน้านี้
                                    </p>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>ตรวจสอบรายการแจ้งซ่อมย้อนหลัง</li>
                                        <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>ดูสถานะงานซ่อมแบบ Real-time</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 order-md-2">
                                <div class="screenshot-placeholder">
                                    <div class="text-center">
                                        <i class="bx bx-list-ul display-4 mb-2"></i>
                                        <p>ภาพตัวอย่าง: รายการแจ้งซ่อม</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-12">
                    <div class="card step-card p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 order-md-2">
                                <div class="p-3">
                                    <div class="step-number text-end">02</div>
                                    <h4 class="fw-bold mb-3 text-warning text-md-end">ระบุรายละเอียดปัญหา</h4>
                                    <p class="text-secondary mb-4 text-md-end">
                                        กดปุ่ม <strong>"แจ้งซ่อมใหม่"</strong> และกรอกรายละเอียดให้ครบถ้วน 
                                        เช่น สถานที่, รายการที่ชำรุด, อาการเสีย และที่สำคัญคือ <strong>การแนบรูปภาพ</strong> เพื่อให้ช่างเข้าใจปัญหาได้ชัดเจน
                                    </p>
                                    <ul class="list-unstyled text-md-end">
                                        <li class="mb-2">ระบบค้นหาครุภัณฑ์อัจฉริยะ <i class="bx bx-search text-warning ms-2"></i></li>
                                        <li class="mb-2">อัปโหลดรูปภาพได้ง่ายๆ <i class="bx bx-image-add text-warning ms-2"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 order-md-1">
                                <div class="screenshot-placeholder">
                                    <div class="text-center">
                                        <i class="bx bx-edit display-4 mb-2"></i>
                                        <p>ภาพตัวอย่าง: ฟอร์มแจ้งซ่อม</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-12">
                    <div class="card step-card p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6 order-md-1">
                                <div class="p-3">
                                    <div class="step-number">03</div>
                                    <h4 class="fw-bold mb-3 text-warning">รอรับการแก้ไข</h4>
                                    <p class="text-secondary mb-4">
                                        เมื่อช่างได้รับเรื่องและเข้าดำเนินการแก้ไข สถานะจะเปลี่ยนเป็น <strong>"กำลังดำเนินการ"</strong>
                                        และเมื่อซ่อมเสร็จ ท่านจะได้รับการแจ้งเตือนสถานะ <strong>"ซ่อมสำเร็จ"</strong> พร้อมรายละเอียดการแก้ไข
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 order-md-2">
                                <div class="screenshot-placeholder">
                                    <div class="text-center">
                                        <i class="bx bx-wrench display-4 mb-2"></i>
                                        <p>ภาพตัวอย่าง: การอัปเดตสถานะ</p>
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
            <div class="row g-4 align-items-center">
                <div class="col-lg-5 text-center mb-4 mb-lg-0">
                    <img src="<?= base_url('assets/img/illustrations/man-with-laptop-light.png') ?>" alt="Admin Dashboard" class="img-fluid" style="max-height: 250px;">
                    <h4 class="mt-3 fw-bold text-warning">การจัดการงานซ่อม</h4>
                    <p class="text-muted">ระบบบริหารจัดการสำหรับทีมช่างและผู้ดูแลอาคารสถานที่</p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 step-card">
                                <div class="card-body text-center p-4">
                                    <div class="step-icon mx-auto bg-label-warning text-warning">
                                        <i class="bx bx-hard-hat fs-2"></i>
                                    </div>
                                    <h5 class="mb-3 fw-bold">รับงานซ่อม</h5>
                                    <p class="text-muted small">
                                        ตรวจสอบรายการแจ้งซ่อมใหม่ ดูรายละเอียดและรูปภาพปัญหา จากนั้นกด "รับงาน" เพื่อเริ่มดำเนินการ
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 step-card">
                                <div class="card-body text-center p-4">
                                    <div class="step-icon mx-auto bg-label-success text-success">
                                        <i class="bx bx-check-double fs-2"></i>
                                    </div>
                                    <h5 class="mb-3 fw-bold">ปิดงานซ่อม</h5>
                                    <p class="text-muted small">
                                        บันทึกผลการซ่อมแซม ค่าใช้จ่าย หรือเปลี่ยนอะไหล่ และเปลี่ยนสถานะเป็น "ซ่อมสำเร็จ" เพื่อแจ้งผู้ใช้
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- FAQ Section -->
    <div class="mt-5">
        <h4 class="fw-bold text-center mb-4 text-muted">คำถามที่พบบ่อย (FAQ)</h4>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion shadow-sm rounded-3 overflow-hidden" id="accordionFAQ">
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                <i class="bx bx-question-mark circle-icon me-2"></i> ถ้าซ่อมไม่ได้ต้องทำอย่างไร?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-secondary">
                                หากอุปกรณ์เสียหายจนไม่สามารถซ่อมได้ เจ้าหน้าที่จะทำเรื่องจำหน่ายออก หรือเสนอจัดซื้อทดแทนตามระเบียบพัสดุครับ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
