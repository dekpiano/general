<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>
<?= $this->section('customCSS') ?>
<style>
    .manual-hero {
        background: linear-gradient(135deg, #1fa2ff 0%, #12d8fa 50%, #a6ffcb 100%);
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
        background: rgba(105, 108, 255, 0.1);
        color: #696cff;
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
        border-color: #696cff;
        color: #696cff;
        background: rgba(105, 108, 255, 0.05);
    }
    .nav-pills .nav-link.active {
        background-color: #696cff;
        box-shadow: 0 4px 10px rgba(105, 108, 255, 0.4);
    }
    .accordion-button:not(.collapsed) {
        background-color: rgba(105, 108, 255, 0.1);
        color: #696cff;
    }
</style>
<?= $this->endSection() ?>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h2 class="manual-hero mb-2 display-6">คู่มือการใช้งานระบบจองยานพาหนะ</h2>
        <p class="text-muted fs-5">เรียนรู้วิธีการใช้งานระบบใหม่ ที่สะดวก รวดเร็ว และทันสมัยยิ่งขึ้น</p>
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
                                    <h4 class="fw-bold mb-3 text-primary">ตรวจสอบตารางการเดินรถ</h4>
                                    <p class="text-secondary mb-4">
                                        ก่อนทำการจอง ท่านสามารถตรวจสอบตารางการเดินรถได้ที่หน้า <strong>"ปฏิทินจองยานพาหนะ"</strong> 
                                        ระบบจะแสดงรายการรถที่ถูกจองแล้วในแต่ละวัน เพื่อให้ท่านวางแผนการเดินทางได้สะดวกขึ้น
                                    </p>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>มุมมองแบบปฏิทินรายเดือน</li>
                                        <li class="mb-2"><i class="bx bx-check-circle text-success me-2"></i>แยกสีตามสถานะ (รออนุมัติ/อนุมัติแล้ว)</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 order-md-2">
                                <div class="screenshot-placeholder">
                                    <div class="text-center">
                                        <i class="bx bx-calendar display-4 mb-2"></i>
                                        <p>ภาพตัวอย่าง: หน้าปฏิทินการจอง</p>
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
                                    <h4 class="fw-bold mb-3 text-primary text-md-end">กรอกแบบฟอร์มการจอง</h4>
                                    <p class="text-secondary mb-4 text-md-end">
                                        คลิกที่ปุ่ม <strong>"จองยานพาหนะ"</strong> และกรอกข้อมูลในแบบฟอร์มใหม่ที่ทันสมัย
                                        ด้วยระบบ <strong>Floating Labels</strong> และ <strong>Smart Search</strong> ช่วยให้การกรอกข้อมูลง่ายและถูกต้อง
                                    </p>
                                    <ul class="list-unstyled text-md-end">
                                        <li class="mb-2">ค้นหาสถานที่หรือบุคลากรได้รวดเร็ว <i class="bx bx-search text-primary ms-2"></i></li>
                                        <li class="mb-2">เลือกเวลาเดินทางไป-กลับ ได้อย่างแม่นยำ <i class="bx bx-time text-primary ms-2"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 order-md-1">
                                <div class="screenshot-placeholder">
                                    <div class="text-center">
                                        <i class="bx bx-edit display-4 mb-2"></i>
                                        <p>ภาพตัวอย่าง: ฟอร์มจองแบบ Floating Labels</p>
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
                                    <h4 class="fw-bold mb-3 text-primary">ติดตามสถานะและรับแจ้งเตือน</h4>
                                    <p class="text-secondary mb-4">
                                        หลังจากส่งคำขอจอง ท่านสามารถติดตามสถานะได้ที่เมนู <strong>"ข้อมูลการจองของฉัน"</strong>
                                        เมื่อผู้ดูแลทำการอนุมัติ ระบบจะส่งแจ้งเตือนผ่าน <strong>LINE และ Email</strong> ให้ท่านทราบทันที
                                    </p>
                                    <div class="d-flex gap-3 mt-3">
                                        <span class="badge bg-label-warning px-3 py-2 fs-6">รออนุมัติ</span>
                                        <i class="bx bx-right-arrow-alt align-self-center text-muted"></i>
                                        <span class="badge bg-label-success px-3 py-2 fs-6">อนุมัติแล้ว</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 order-md-2">
                                <div class="screenshot-placeholder">
                                    <div class="text-center">
                                        <i class="bx bxs-bell-ring display-4 mb-2"></i>
                                        <p>ภาพตัวอย่าง: การแจ้งเตือนผ่าน LINE</p>
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
                    <h4 class="mt-3 fw-bold text-primary">ระบบจัดการสำหรับผู้ดูแล</h4>
                    <p class="text-muted">ควบคุมและบริหารจัดการยานพาหนะได้อย่างเต็มประสิทธิภาพ</p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 step-card">
                                <div class="card-body text-center p-4">
                                    <div class="step-icon mx-auto bg-label-primary text-primary">
                                        <i class="bx bx-check-shield fs-2"></i>
                                    </div>
                                    <h5 class="mb-3 fw-bold">การอนุมัติคำขอ</h5>
                                    <p class="text-muted small">
                                        ตรวจสอบและอนุมัติคำขอจอง พร้อมระบุเหตุผลและจัดสรรคนขับรถได้ในคลิกเดียว
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 step-card">
                                <div class="card-body text-center p-4">
                                    <div class="step-icon mx-auto bg-label-success text-success">
                                        <i class="bx bx-id-card fs-2"></i>
                                    </div>
                                    <h5 class="mb-3 fw-bold">จัดการพนักงานขับรถ</h5>
                                    <p class="text-muted small">
                                        ระบบตรวจสอบตารางงานคนขับรถอัตโนมัติ ป้องกันการจองซ้อนและบริหารเวลางานได้ง่ายขึ้น
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
                                <i class="bx bx-question-mark circle-icon me-2"></i> สามารถยกเลิกการจองได้หรือไม่?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-secondary">
                                ได้ครับ โดยท่านสามารถกดยกเลิกได้ที่หน้า "ประวัติการจอง" หากสถานะยังเป็น "รออนุมัติ" 
                                หากอนุมัติแล้ว กรุณาติดต่อผู้ดูแลระบบเพื่อทำการยกเลิก
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 border-bottom">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                <i class="bx bx-question-mark circle-icon me-2"></i> จำเป็นต้องจองล่วงหน้ากี่วัน?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                            <div class="accordion-body text-secondary">
                                เพื่อความสะดวกในการบริหารจัดการรถ แนะนำให้จองล่วงหน้าอย่างน้อย <strong>2-3 วันทำการ</strong> ครับ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
