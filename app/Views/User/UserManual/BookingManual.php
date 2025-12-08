<?= $this->extend('User/UserLayout/user_layout') ?>
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
        background: #007bff;
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

    .arrow {
        font-size: 2rem;
        color: #ced4da;
        text-align: center;
        margin: 15px 0;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">คู่มือการใช้งาน /</span> ระบบจองสถานที่</h4>

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
                                <i class="bi bi-cursor-fill"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>1. เลือกสถานที่</strong>
                                <p class="mb-0">ไปที่หน้าจองและเลือกสถานที่ที่ต้องการใช้งาน</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>2. กรอกข้อมูลการจอง</strong>
                                <p class="mb-0">กรอกรายละเอียดต่างๆ เช่น หัวข้อ, วัน-เวลา, จำนวนผู้เข้าร่วม และอุปกรณ์ที่ต้องการใช้</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-send-check-fill"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>3. ส่งคำขอจอง</strong>
                                <p class="mb-0">ตรวจสอบข้อมูลและกดยืนยันการจอง ระบบจะส่งคำขอไปยังผู้ดูแล</p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>4. รอการอนุมัติ</strong>
                                <p class="mb-0">ผู้ดูแลระบบจะได้รับแจ้งเตือนและตรวจสอบคำขอของท่าน</p>
                            </div>
                        </div>
                        
                        <!-- Step 5 -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-check-circle-fill text-success"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>5. ได้รับการยืนยัน</strong>
                                <p class="mb-0">เมื่อผู้ดูแลอนุมัติ ท่านจะได้รับการแจ้งเตือนยืนยันการจองผ่านระบบ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Flow -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-person-gear me-2"></i>ขั้นตอนสำหรับผู้ดูแลระบบ</h5>
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
                                <p class="mb-0">ระบบจะส่ง LINE แจ้งเตือนเมื่อมีคำขอจองใหม่เข้ามา</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="timeline-item">
                            <div class="timeline-icon timeline-icon-admin">
                                <i class="bi bi-search"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>2. ตรวจสอบคำขอ</strong>
                                <p class="mb-0">เข้าสู่ระบบและไปที่หน้า "อนุมัติการจอง" เพื่อดูรายละเอียด</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="timeline-item">
                            <div class="timeline-icon timeline-icon-admin">
                                <i class="bi bi-check2-square"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>3. พิจารณาและอนุมัติ</strong>
                                <p class="mb-0">ตรวจสอบความถูกต้องและความพร้อมของสถานที่ จากนั้นกด "อนุมัติ" หรือ "ไม่อนุมัติ"</p>
                            </div>
                        </div>
                        
                        <!-- Step 4 -->
                        <div class="timeline-item">
                            <div class="timeline-icon timeline-icon-admin">
                                <i class="bi bi-envelope-check-fill"></i>
                            </div>
                            <div class="timeline-content p-3">
                                <strong>4. ระบบแจ้งผู้ใช้</strong>
                                <p class="mb-0">ระบบจะส่งอีเมลและแจ้งเตือนไปยังผู้จองเพื่อแจ้งผลการอนุมัติโดยอัตโนมัติ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
