<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>
<?= $this->section('customCSS') ?>
<style>
    .manual-hero {
        background: linear-gradient(135deg, #007bff 0%, #00d4ff 100%);
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
        background: rgba(0, 123, 255, 0.1);
        color: #007bff;
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
        border-color: #007bff;
        color: #007bff;
        background: rgba(0, 123, 255, 0.05);
    }
    .nav-pills .nav-link.active {
        background-color: #007bff;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.4);
    }
    .accordion-button:not(.collapsed) {
        background-color: rgba(0, 123, 255, 0.1);
        color: #007bff;
    }
</style>
<?= $this->endSection() ?>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h2 class="manual-hero mb-2 display-6">คู่มือการใช้งานระบบจองสถานที่</h2>
        <p class="text-muted fs-5">ขั้นตอนการจองห้องประชุมและสถานที่ต่างๆ ภายในโรงเรียน</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 col-lg-6">
            <ul class="nav nav-pills nav-fill p-1 bg-white rounded-pill shadow-sm border" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active rounded-pill py-2" data-bs-toggle="pill" data-bs-target="#user-manual" type="button">
                        <i class="bx bx-user me-1"></i> สำหรับผู้จอง (User)
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link rounded-pill py-2" data-bs-toggle="pill" data-bs-target="#admin-manual" type="button">
                        <i class="bx bx-shield-quarter me-1"></i> สำหรับผู้ดูแล (Admin)
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
                                    <h4 class="fw-bold mb-3 text-primary">เลือกสถานที่ที่ต้องการ</h4>
                                    <p class="text-secondary mb-4">
                                        ไปที่เมนู <strong>"จองสถานที่"</strong> ท่านสามารถเลือกดูห้องประชุมหรือสถานที่ต่างๆ 
                                        พร้อมตรวจสอบสถานะว่าง/ไม่ว่าง ได้จากปฏิทินงาน
                                    </p>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>ดูภาพตัวอย่างสถานที่</li>
                                        <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>ตรวจสอบอุปกรณ์ภายในห้อง</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 order-md-2">
                                <!-- Mockup: Calendar/Location Card -->
                                <div class="mockup-container bg-light rounded-3 p-4 border border-dashed text-center">
                                    <div class="card shadow-sm mx-auto text-start" style="max-width: 300px; transform: rotate(-2deg);">
                                        <div class="card-body p-2">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="bg-primary rounded-1" style="width: 40px; height: 40px;"></div>
                                                <div class="ms-2">
                                                    <div class="bg-secondary opacity-25 rounded-pill" style="width: 100px; height: 10px; margin-bottom: 4px;"></div>
                                                    <div class="bg-secondary opacity-10 rounded-pill" style="width: 60px; height: 8px;"></div>
                                                </div>
                                            </div>
                                            <!-- Mini Calendar Grid -->
                                            <div class="row g-1 mt-3">
                                                <?php for($i=1; $i<=12; $i++): ?>
                                                    <div class="col-3"><div class="rounded-1 bg-secondary opacity-10" style="height: 25px;"></div></div>
                                                <?php endfor; ?>
                                                <div class="col-3"><div class="rounded-1 bg-success text-white text-center" style="height: 25px; font-size: 8px; line-height: 25px;">ว่าง</div></div>
                                                <div class="col-3"><div class="rounded-1 bg-danger text-white text-center" style="height: 25px; font-size: 8px; line-height: 25px;">เต็ม</div></div>
                                            </div>
                                        </div>
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
                                    <h4 class="fw-bold mb-3 text-primary text-md-end">กรอกรายละเอียดการจอง</h4>
                                    <p class="text-secondary mb-4 text-md-end">
                                        ระบุหัวข้อการประชุม, วัน-เวลาที่ต้องการใช้, จำนวนผู้เข้าร่วม 
                                        และสามารถเลือก <strong>"อุปกรณ์ที่ต้องการยืมเพิ่มเติม"</strong> ได้ในขั้นตอนนี้
                                    </p>
                                    <ul class="list-unstyled text-md-end">
                                        <li class="mb-2">ระบบช่วยตรวจสอบเวลาว่างอัตโนมัติ <i class="bx bx-time text-primary ms-2"></i></li>
                                        <li class="mb-2">แนบเอกสารประกอบคำขอได้ <i class="bx bx-file text-primary ms-2"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 order-md-1">
                                <!-- Mockup: Form -->
                                <div class="mockup-container bg-light rounded-3 p-4 border border-dashed">
                                    <div class="card shadow-sm mx-auto" style="max-width: 320px; transform: rotate(2deg);">
                                        <div class="card-header bg-white border-bottom p-3">
                                            <div class="bg-primary opacity-75 rounded-pill" style="width: 120px; height: 12px;"></div>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="mb-2 border rounded p-2 bg-white">
                                                <div class="text-muted small" style="font-size: 8px;">หัวข้อการประชุม</div>
                                                <div class="bg-secondary opacity-10 rounded-pill mt-1" style="width: 80%; height: 8px;"></div>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-6">
                                                    <div class="border rounded p-2 bg-white">
                                                        <div class="text-muted small" style="font-size: 8px;">วันที่เริ่มต้น</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded p-2 bg-white">
                                                        <div class="text-muted small" style="font-size: 8px;">เวลา</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-primary rounded-2 w-100 mt-2" style="height: 30px;"></div>
                                        </div>
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
                                    <h4 class="fw-bold mb-3 text-primary">รอผลการอนุมัติ</h4>
                                    <p class="text-secondary mb-4">
                                        เมื่อส่งคำขอแล้ว ระบบจะส่งเรื่องไปยังผู้ดูแลสถานที่ทันที 
                                        ท่านจะได้รับแจ้งเตือนผลการอนุมัติผ่านทาง <strong>LINE Official</strong>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 order-md-2">
                                <!-- Mockup: Notification -->
                                <div class="mockup-container bg-light rounded-3 p-4 border border-dashed text-center">
                                    <div class="card shadow-sm mx-auto border-0" style="max-width: 280px; border-radius: 20px; overflow: hidden;">
                                        <div class="bg-dark p-2 text-white d-flex justify-content-between align-items-center" style="font-size: 10px;">
                                            <span>9:41</span>
                                            <i class="bx bxs-battery-full"></i>
                                        </div>
                                        <div class="p-3 bg-white text-start">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 30px; height: 30px;">
                                                    <i class="bx bxl-line"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <div class="fw-bold small">LINE • Now</div>
                                                    <div class="text-muted" style="font-size: 10px;">แจ้งเตือนสถานะการจอง</div>
                                                </div>
                                            </div>
                                            <div class="p-2 bg-light rounded-3 border">
                                                <div class="fw-bold text-success small mb-1">อนุมัติเรียบร้อย!</div>
                                                <div class="text-muted" style="font-size: 11px;">
                                                    ห้องประชุม 1 ได้รับการอนุมัติแล้ว<br>
                                                    วันที่: 12 ม.ค. 2568
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
            <div class="row g-4 align-items-center">
                <div class="col-lg-5 text-center mb-4 mb-lg-0">
                    <img src="<?= base_url('assets/img/illustrations/man-with-laptop-light.png') ?>" alt="Admin Dashboard" class="img-fluid" style="max-height: 250px;">
                    <h4 class="mt-3 fw-bold text-primary">การจัดการสถานที่</h4>
                    <p class="text-muted">ตรวจสอบความเรียบร้อยและอนุมัติการใช้งานห้องประชุม</p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 step-card">
                                <div class="card-body text-center p-4">
                                    <div class="step-icon mx-auto bg-label-primary text-primary">
                                        <i class="bx bx-checkbox-checked fs-2"></i>
                                    </div>
                                    <h5 class="mb-3 fw-bold">อนุมัติคำขอ</h5>
                                    <p class="text-muted small">
                                        ตรวจสอบรายละเอียดการขอใช้ห้อง และกดอนุมัติเพื่อยืนยันการจอง ระบบจะล็อคตารางห้องให้อัตโนมัติ
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 step-card">
                                <div class="card-body text-center p-4">
                                    <div class="step-icon mx-auto bg-label-warning text-warning">
                                        <i class="bx bx-calendar-edit fs-2"></i>
                                    </div>
                                    <h5 class="mb-3 fw-bold">จัดการตาราง</h5>
                                    <p class="text-muted small">
                                        ผู้ดูแลสามารถแก้ไข ปรับเลื่อน หรือยกเลิกการจองได้ในกรณีที่มีความจำเป็นเร่งด่วน
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
                                <i class="bx bx-question-mark circle-icon me-2"></i> บุคคลภายนอกสามารถจองได้หรือไม่?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-secondary">
                                ปัจจุบันระบบเปิดให้จองเฉพาะบุคลากรภายในโรงเรียนเท่านั้นครับ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
