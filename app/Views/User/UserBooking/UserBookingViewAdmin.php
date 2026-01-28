<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('content') ?>

<style>
    /* Premium CSS Variables */
    :root {
        --primary-gradient: linear-gradient(135deg, #696cff 0%, #3f42ef 100%);
        --success-gradient: linear-gradient(135deg, #71dd37 0%, #56b328 100%);
        --warning-gradient: linear-gradient(135deg, #ffab00 0%, #e09600 100%);
        --danger-gradient: linear-gradient(135deg, #ff3e1d 0%, #e6381a 100%);
        --info-gradient: linear-gradient(135deg, #03c3ec 0%, #0299ba 100%);
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    .admin-view-content-lux {
        background-color: #f8faff;
        min-height: 100vh;
    }

    /* Modern Banner Styling */
    .admin-banner {
        background: #fff;
        border-radius: 20px;
        padding: 0;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid #f1f4f9;
        display: flex;
    }

    .banner-accent {
        width: 10px;
        background: var(--primary-gradient);
    }

    .banner-body {
        padding: 2rem;
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .banner-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .banner-icon-box {
        width: 60px;
        height: 60px;
        background: #f8faff;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #696cff;
        border: 1px solid #eef2f7;
    }

    .banner-text h3 {
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .banner-text p {
        color: #7f8c8d;
        margin-bottom: 0;
    }

    .banner-img {
        height: 80px;
    }

    /* Compact Stats Cards */
    .stat-card-lux {
        border: none;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        background: white;
        margin-bottom: 1rem;
    }

    .stat-card-lux .chart-box {
        padding: 0.5rem;
    }

    .stat-card-lux h6 {
        font-weight: 700;
        color: #566a7f;
        margin-bottom: 1rem;
        padding: 1rem 1rem 0;
        display: flex;
        align-items: center;
    }

    .stat-card-lux h6 i { color: #696cff; margin-right: 8px; }

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

    /* Status Pills */
    .status-pill {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .status-pill.pending { background: #fff2e0; color: #ffab00; border: 1px solid #ffe5d0; }
    .status-pill.approved { background: #e8fadf; color: #71dd37; border: 1px solid #d4f4cd; }
    .status-pill.rejected { background: #ffeae7; color: #ff3e1d; border: 1px solid #ffdcd6; }

    /* Custom Scrollbar for Table */
    .table-responsive::-webkit-scrollbar { height: 6px; }
    .table-responsive::-webkit-scrollbar-thumb { background: #eef2f7; border-radius: 10px; }

    /* Premium Modals */
    .modal-lux {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .modal-lux .modal-header {
        background: #f8faff;
        border-bottom: 1px solid #eef2f7;
        padding: 1.25rem 1.5rem;
    }

    .modal-lux .modal-footer {
        background: #f8faff;
        border-top: 1px solid #eef2f7;
        padding: 1rem 1.5rem;
    }

    /* Animation */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .table-container { animation: fadeInUp 0.6s ease-out; }
</style>

<div class="container-xxl flex-grow-1 container-p-y admin-view-content-lux">
    <!-- Banner Header -->
    <div class="admin-banner shadow-sm">
        <div class="banner-accent"></div>
        <div class="banner-body">
            <div class="banner-info">
                <div class="banner-icon-box">
                    <i class='bx bxs-buildings'></i>
                </div>
                <div class="banner-text">
                    <h3 class="fw-bold mb-1">จัดการอนุมัติห้องประชุมและสถานที่</h3>
                    <p>ตรวจสอบ ติดตาม และอนุมัติรายการขอใช้สถานที่ทั้งหมดของโรงเรียน</p>
                </div>
            </div>
            <div class="d-none d-md-block">
                <img src="<?=base_url('assets/img/illustrations/man-with-laptop-light.png')?>" class="banner-img" alt="Admin Illustration">
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card-lux card shadow-none h-100">
                <h6><i class='bx bx-pie-chart-alt'></i>สัดส่วนการใช้สถานที่</h6>
                <div class="chart-box">
                    <div id="pie-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card-lux card shadow-none h-100">
                <h6><i class='bx bx-trending-up'></i>ผู้จองสูงสุด 5 อันดับแรก</h6>
                <div class="chart-box">
                    <div id="bar-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card-lux card shadow-none h-100">
                <h6><i class='bx bx-check-shield'></i>สรุปการดำเนินการ</h6>
                <div class="chart-box">
                    <div id="chart-Approve"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Data Table Container -->
    <div class="table-container">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
            <div>
                <h5 class="fw-bold mb-1">รายการจองทั้งหมด</h5>
                <p class="text-muted small mb-0">แสดงข้อมูลล่าสุดเรียงตามลำดับเวลา</p>
            </div>
            <div class="search-box">
                <div class="input-group input-group-merge shadow-none">
                    <span class="input-group-text bg-light border-0"><i class="bx bx-search"></i></span>
                    <input type="text" id="tableSearch" class="form-control bg-light border-0 px-2" placeholder="ค้นหา รหัส, ชื่อผู้จอง, สถานที่..." style="width: 250px;">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table custom-table w-100" id="TBShowDataBookingAdmin">
                <thead>
                    <tr>
                        <th>เลขที่/ผู้จอง</th>
                        <th>รายละเอียด/หัวข้อ</th>
                        <th>สถานที่</th>
                        <th>สถานะ</th>
                        <th>เหตุผล</th>
                        <th class="text-end">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTable content injected via JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Signature -->
<div class="modal fade" id="ModalSignatureAdmin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-lux">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-1">ลงนามอนุมัติ (E-Signature)</h5>
                    <p class="text-muted small mb-0">กรุณาลงลายเซ็นเพื่อยืนยันการอนุมัติใบงาน</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="signature-wrapper mb-3" style="background: #fdfdfd; border-radius: 8px;">
                    <canvas id="SignatureAdmin" width="400" height="200" style="border: 2px dashed #dce1e6; border-radius: 8px; max-width: 100%;"></canvas>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="clear">
                    <i class='bx bx-eraser me-1'></i> ล้างลายเซ็น
                </button>
            </div>
            <div class="modal-footer d-flex gap-2">
                <button type="button" class="btn btn-label-secondary btn-lg rounded-pill flex-fill" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary btn-lg rounded-pill flex-fill shadow-primary" id="SaveSignatureAdmin">
                    <i class='bx bx-save me-1'></i> บันทึกลายเซ็น
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Generic Detail / Image -->
<div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content modal-lux">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">รายละเอียดแนบ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0" id="modalBody">
        <!-- Image content -->
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
