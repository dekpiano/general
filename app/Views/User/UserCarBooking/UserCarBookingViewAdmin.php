<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('content') ?>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #2af598 0%, #009efd 100%);
        --warning-gradient: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        --danger-gradient: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --glass-bg: rgba(255, 255, 255, 0.9);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    /* Modern Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #aaa;
    }

    /* Page Header Upgraded */
    .page-header-premium {
        background: #fff;
        border-radius: 24px;
        padding: 0;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        border: 1px solid #f1f4f9;
        display: flex;
    }

    .header-accent {
        width: 12px;
        background: var(--primary-gradient);
    }

    .header-body {
        padding: 2.5rem;
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
    }

    .header-info {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .header-icon-box {
        width: 80px;
        height: 80px;
        background: #f8faff;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #667eea;
        transition: all 0.3s;
        border: 1px solid #eef2f7;
    }

    .page-header-premium:hover .header-icon-box {
        transform: rotate(10deg);
        background: var(--primary-gradient);
        color: white;
    }

    .header-text h2 {
        color: #2c3e50;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .header-text p {
        color: #7f8c8d;
        font-size: 1.1rem;
    }

    .header-actions {
        text-align: right;
    }

    .header-date-badge {
        background: #f8faff;
        color: #667eea;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        display: inline-block;
        border: 1px solid #eef2f7;
    }

    /* Quick Action Cards */
    .stat-card {
        border: none;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: white;
        overflow: hidden;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .stat-card .card-body {
        padding: 1.5rem;
        z-index: 2;
        position: relative;
    }

    .stat-icon-bg {
        position: absolute;
        bottom: -15px;
        right: -15px;
        font-size: 5rem;
        opacity: 0.1;
        transform: rotate(-15deg);
        z-index: 1;
    }

    /* Table Redesign: Compact & Clear */
    .table-container {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    .custom-table {
        border-collapse: separate;
        border-spacing: 0 0;
        width: 100% !important;
    }

    .custom-table thead th {
        background: #f8faff;
        border-bottom: 2px solid #eef2f7;
        color: #495057;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.75rem;
        padding: 0.8rem 0.75rem;
        vertical-align: middle;
    }

    .custom-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f1f4f9;
        background: white;
    }

    .custom-table tbody td {
        padding: 0.6rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f4f9;
        color: #566a7f;
        font-size: 0.85rem;
    }

    .custom-table tbody tr:last-child td:first-child { border-radius: 0 0 0 12px; }
    .custom-table tbody tr:last-child td:last-child { border-radius: 0 0 12px 0; }

    /* Badges & Indicators */
    .status-pill {
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-pill.pending { background: #fff4e5; color: #ff9800; }
    .status-pill.approved { background: #e8fadf; color: #71dd37; }
    .status-pill.rejected { background: #ffe5e5; color: #ff3e1d; }

    /* Modal Styling */
    .modal-lux {
        border-radius: 24px;
        border: none;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-lux .modal-header {
        border-bottom: none;
        padding: 2rem 2rem 1rem;
    }

    .modal-lux .modal-body {
        padding: 1rem 2rem 2rem;
    }

    .modal-lux .modal-footer {
        border-top: none;
        padding: 1rem 2rem 2rem;
    }

    .glass-input {
        background: #f8f9fa;
        border: 2px solid transparent;
        border-radius: 14px;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
    }

    .glass-input:focus {
        background: white;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: none;
    }

    .action-btn:hover {
        transform: translateY(-3px);
    }

    .btn-approve { background: #e8fadf; color: #71dd37; }
    .btn-approve:hover { background: #71dd37; color: white; }

    .btn-reject { background: #ffe5e5; color: #ff3e1d; }
    .btn-reject:hover { background: #ff3e1d; color: white; }

    .btn-view { background: #e7e7ff; color: #696cff; }
    .btn-view:hover { background: #696cff; color: white; }

    .btn-print { background: #d7f5fc; color: #03c3ec; }
    .btn-print:hover { background: #03c3ec; color: white; }

    /* Chart Styles */
    .chart-container-premium {
        position: relative;
        overflow: hidden;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="page-header-premium">
        <div class="header-accent"></div>
        <div class="header-body">
            <div class="header-info">
                <div class="header-icon-box shadow-sm">
                    <i class='bx bxs-car-garage'></i>
                </div>
                <div class="header-text">
                    <h2 class="fw-bold mb-1">จัดการการจองยานพาหนะ สำหรับผู้ดูแล</h2>
                    <p class="mb-0">ตรวจสอบ ตรวจทาน และอนุมัติรายการขอใช้รถยนต์ส่วนกลาง</p>
                </div>
            </div>
            <div class="header-actions">
                <div class="header-date-badge">
                    <i class='bx bx-calendar-star me-1'></i> วันนี้: <?= date('d F Y') ?>
                </div>
                <div>
                    <button class="btn btn-primary btn-lg rounded-pill shadow-primary px-4" onclick="location.reload()">
                        <i class='bx bx-refresh me-1'></i> อัปเดตข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Summary Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card border-start border-warning border-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1 text-uppercase tracking-wider">สัดส่วนการใช้รถ</h6>
                            <h3 class="fw-bold mb-0">ทรัพยากร</h3>
                        </div>
                        <div class="avatar bg-label-warning p-2 rounded-3">
                            <i class='bx bx-pie-chart-alt-2 fs-3'></i>
                        </div>
                    </div>
                    <div class="mt-4 chart-container-premium">
                        <div id="pie-chart" style="min-height: 250px;"></div>
                    </div>
                    <i class='bx bx-car stat-icon-bg'></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card border-start border-primary border-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1 text-uppercase tracking-wider">ผู้ใช้งานสูงสุด 5 อันดับ</h6>
                            <h3 class="fw-bold mb-0">ผู้นิยมใช้</h3>
                        </div>
                        <div class="avatar bg-label-primary p-2 rounded-3">
                            <i class='bx bx-bar-chart-alt-2 fs-3'></i>
                        </div>
                    </div>
                    <div class="mt-4 chart-container-premium">
                        <div id="bar-chart" style="min-height: 250px;"></div>
                    </div>
                    <i class='bx bx-user-voice stat-icon-bg'></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card border-start border-success border-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1 text-uppercase tracking-wider">สถานะการตรวจสอบ</h6>
                            <h3 class="fw-bold mb-0">การอนุมัติ</h3>
                        </div>
                        <div class="avatar bg-label-success p-2 rounded-3">
                            <i class='bx bx-check-double fs-3'></i>
                        </div>
                    </div>
                    <div class="mt-4 chart-container-premium">
                        <div id="chart-Approve" style="min-height: 250px;"></div>
                    </div>
                    <i class='bx bx-task stat-icon-bg'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main List Table -->
    <div class="table-container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 px-2">
            <div>
                <h4 class="fw-bold mb-1"><i class='bx bx-list-check me-2 text-primary'></i>รายการรอการตรวจสอบ</h4>
                <p class="text-muted small mb-0">ข้อมูลการจองทั้งหมดที่เกิดขึ้นในระบบ</p>
            </div>
            <div class="d-flex gap-2">
                <div class="input-group input-group-merge" style="width: 250px;">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control" id="tableSearch" placeholder="ค้นหาการจอง...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table custom-table w-100" id="TBShowDataCarBookingAdmin">
                <thead>
                    <tr>
                        <th>สถานะ</th>
                        <th>เลขที่/ผู้จอง</th>
                        <th>จุดหมาย/รายละเอียด</th>
                        <th>ยานพาหนะ</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTable content -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Approve / Select Driver -->
<div class="modal fade" id="ModalApproveAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-lux">
            <div class="modal-header">
                <div>
                    <h4 class="modal-title fw-bold mb-1">อนุมัติการใช้รถ</h4>
                    <p class="text-muted small mb-0">กรุณาระบุพนักงานขับรถเพื่อลงนามปฏิบัติหน้าที่</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FormAppoveCarReservation" class="needs-validation" novalidate>
                <div class="modal-body">
                    <input type="hidden" name="carbookingID" id="carbookingID">
                    
                    <div class="mb-4 text-center">
                        <div class="avatar avatar-xl bg-label-info rounded-circle mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class='bx bx-id-card fs-1'></i>
                        </div>
                        <h5 class="fw-bold">มอบหมายพนักงานขับรถ</h5>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label fw-bold mb-2">พนักงานขับรถที่ว่างงาน</label>
                        <select name="Driver" id="Driver" class="form-select glass-input shadow-none" required>
                            <option value="">-- เลือกพนักงานขับรถ --</option>
                            <?php foreach ($CarDriver as $key => $v_CarDriver):?>
                            <option value="<?=$v_CarDriver->pers_id?>">
                                <?=$v_CarDriver->pers_prefix.$v_CarDriver->pers_firstname.' '.$v_CarDriver->pers_lastname;?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">กรุณาเลือกผู้อันมัติ</div>
                    </div>
                </div>
                <div class="modal-footer d-flex gap-2">
                    <button type="button" id="BtnNoAppoveCarBooking" class="btn btn-outline-danger btn-lg rounded-pill flex-fill">
                        <i class='bx bx-x-circle me-1'></i> ไม่อนุมัติ
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill flex-fill shadow-primary">
                        <i class='bx bx-check-circle me-1'></i> ยอมรับการจอง
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: View Detailed Information -->
<div class="modal fade" id="ViewDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-lux">
            <div class="modal-header border-bottom pb-3">
                <div class="d-flex align-items-center">
                    <div class="avatar bg-label-primary p-2 rounded-3 me-3">
                        <i class='bx bx-info-square fs-3'></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold mb-1">รายละเอียดใบงานการจอง</h4>
                        <p class="text-muted small mb-0" id="detailModalSubtitle">ตรวจสอบข้อมูลผู้จองและยานพาหนะ</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-4">
                <!-- Content injected via JS -->
                 <div id="detailContentLoader" class="text-center py-5 d-none">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted">กำลังโหลดข้อมูล...</p>
                 </div>
                 <div id="detailContentBody"></div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
 
<?= $this->section('customScripts') ?>
<script src="<?= base_url('assets/js/User/UserCarReservation/UserCarReservation.js?v=' . time()) ?>"></script>
<script src="<?= base_url('assets/js/User/UserCarReservation/UserCarReservationChart.js?v=' . time()) ?>"></script>
<?= $this->endSection() ?>

