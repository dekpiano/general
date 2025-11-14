<?= $this->extend('User/UserLeyout/user_layout') ?>
<?= $this->section('content') ?>

<style>
    .timeline-container {
        position: relative;
        padding-left: 50px;
    }

    .timeline-container::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 20px;
        bottom: 20px;
        width: 4px;
        background: #e9ecef;
        border-radius: 2px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }

    .timeline-icon {
        position: absolute;
        left: -30px;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fd7e14; /* Repair theme color */
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        border: 2px solid white;
        z-index: 1;
    }
    
    .timeline-icon-admin {
        background: #6f42c1;
    }

    .timeline-content {
        position: relative;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">คู่มือการใช้งาน /</span> ระบบแจ้งซ่อมออนไลน์</h4>

    <div class="row">
        <!-- User Flow -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-person-fill me-2"></i>ขั้นตอนสำหรับผู้ใช้งาน</h5>
                </div>
                <div class="card-body">
                    <div class="timeline-container">
                        <!-- Step 1 -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-tools"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>1. ไปที่หน้าแจ้งซ่อม</strong>
                                <p class="mb-0">เข้าสู่ระบบและเลือกเมนู "แจ้งซ่อมออนไลน์"</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>2. กรอกข้อมูลการแจ้งซ่อม</strong>
                                <p class="mb-0">กรอกรายละเอียดของสิ่งที่ชำรุด, สถานที่, และแนบรูปภาพ (ถ้ามี)</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-send-check-fill"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>3. ส่งใบแจ้งซ่อม</strong>
                                <p class="mb-0">ตรวจสอบข้อมูลและกดยืนยัน ระบบจะสร้างใบแจ้งซ่อมและส่งให้ผู้ดูแล</p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-search"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>4. ติดตามสถานะ</strong>
                                <p class="mb-0">ท่านสามารถตรวจสอบสถานะการซ่อมได้จากหน้า "รายการแจ้งซ่อม"</p>
                            </div>
                        </div>
                        
                        <!-- Step 5 -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-check-circle-fill text-success"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>5. งานซ่อมเสร็จสิ้น</strong>
                                <p class="mb-0">เมื่อช่างซ่อมเสร็จสิ้น สถานะในระบบจะเปลี่ยนเป็น "ซ่อมสำเร็จ"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin/Technician Flow -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-person-gear me-2"></i>ขั้นตอนสำหรับช่าง/ผู้ดูแล</h5>
                </div>
                <div class="card-body">
                    <div class="timeline-container">
                        <!-- Step 1 -->
                        <div class="timeline-item">
                            <div class="timeline-icon timeline-icon-admin">
                                <i class="bi bi-bell-fill"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>1. รับแจ้งเตือน</strong>
                                <p class="mb-0">ระบบจะแจ้งเตือนเมื่อมีรายการแจ้งซ่อมใหม่เข้ามา</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="timeline-item">
                            <div class="timeline-icon timeline-icon-admin">
                                <i class="bi bi-clipboard-plus"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>2. รับงานซ่อม</strong>
                                <p class="mb-0">เข้าระบบเพื่อดูรายละเอียดและกด "รับงาน" เพื่อเริ่มดำเนินการ</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="timeline-item">
                            <div class="timeline-icon timeline-icon-admin">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>3. อัปเดตสถานะ</strong>
                                <p class="mb-0">เปลี่ยนสถานะของงานซ่อมในระบบเมื่อดำเนินการ เช่น "กำลังดำเนินการ"</p>
                            </div>
                        </div>
                        
                        <!-- Step 4 -->
                        <div class="timeline-item">
                            <div class="timeline-icon timeline-icon-admin">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>4. ปิดงาน</strong>
                                <p class="mb-0">เมื่อซ่อมเสร็จสิ้น ให้เปลี่ยนสถานะเป็น "ซ่อมสำเร็จ" และกรอกรายละเอียดการซ่อม</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
