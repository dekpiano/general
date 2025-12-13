<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #ffab00 0%, #ff8f00 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.page-header h4 {
    color: #fff;
    margin: 0;
    font-weight: 600;
}

.page-header .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0.5rem 0 0;
}

.page-header .breadcrumb-item,
.page-header .breadcrumb-item a {
    color: rgba(255,255,255,0.85);
    font-size: 0.875rem;
    text-decoration: none;
}

.page-header .breadcrumb-item.active {
    color: #fff;
}

.page-header .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.5);
}

/* Cards */
.card-premium {
    border: none;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    background: #fff;
}

.card-premium:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.card-premium .card-header {
    background: transparent;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.25rem 1.5rem;
    font-weight: 600;
    color: #566a7f;
}

.card-premium .card-body {
    padding: 1.5rem;
}

.chart-box {
    min-height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Table */
.table-card {
    border-radius: 16px;
    overflow: hidden;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}

.table-responsive {
    padding: 1rem;
}

table.dataTable thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #ebeef0;
    color: #566a7f;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
}

table.dataTable tbody td {
    vertical-align: middle;
    color: #697a8d;
    font-size: 0.95rem;
}

/* Modal */
.modal-content {
    border-radius: 16px;
    border: none;
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, #ffab00 0%, #ff8f00 100%);
    color: white;
    padding: 1.5rem;
}

.modal-header .modal-title {
    font-weight: 600;
    color: white;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.form-floating-custom {
    position: relative;
    margin-bottom: 1rem;
}

.form-floating-custom .form-select {
    border-radius: 10px;
    height: 3.5rem;
    padding-top: 1.625rem;
    padding-bottom: 0.625rem;
}

.form-floating-custom label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    padding: 1rem 0.75rem;
    pointer-events: none;
    transform-origin: 0 0;
    transition: opacity .1s ease-in-out,transform .1s ease-in-out;
    opacity: .65;
    transform: scale(.85) translateY(-.5rem) translateX(.15rem);
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4><i class='bx bxs-file-find me-2'></i> อนุมัติการจองยานพาหนะ</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url('CarBooking')?>">หน้าหลักจองยานพาหนะ</a></li>
                        <li class="breadcrumb-item active">สำหรับผู้ดูแลระบบ</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-white/20 text-white p-2">
                    <i class='bx bx-calendar-check me-1'></i> <?= date('d/m/Y') ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card card-premium">
                <div class="card-header d-flex align-items-center">
                    <i class='bx bx-pie-chart-alt-2 me-2 text-warning font-24'></i>
                    <span>สัดส่วนการใช้ทรัพยากร</span>
                </div>
                <div class="card-body">
                    <div class="chart-box">
                        <div id="pie-chart" class="w-100"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-premium">
                <div class="card-header d-flex align-items-center">
                    <i class='bx bx-bar-chart-alt-2 me-2 text-primary font-24'></i>
                    <span>ผู้ใช้งานสูงสุด 5 อันดับ</span>
                </div>
                <div class="card-body">
                    <div class="chart-box">
                        <div id="bar-chart" class="w-100"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-premium">
                <div class="card-header d-flex align-items-center">
                    <i class='bx bx-doughnut-chart me-2 text-success font-24'></i>
                    <span>สถานะการอนุมัติ</span>
                </div>
                <div class="card-body">
                    <div class="chart-box">
                        <div id="chart-Approve" class="w-100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card table-card">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><i class='bx bx-list-ul me-2'></i> รายการจองทั้งหมด</h5>
                <div class="card-actions">
                    <button class="btn btn-outline-secondary btn-sm" onclick="location.reload()">
                        <i class='bx bx-refresh me-1'></i> รีโหลด
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover w-100" id="TBShowDataCarBookingAdmin">
                <thead>
                    <tr>
                        <th width="5%">สถานะ</th>
                        <th width="10%">เลขที่จอง</th>
                        <th width="60%">รายละเอียดการจอง</th>
                        <th width="25%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data loaded via Ajax -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalApproveAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class='bx bx-check-shield me-2'></i> อนุมัติและเลือกคนขับรถ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FormAppoveCarReservation" class="needs-validation" novalidate>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-xl bg-label-warning rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                            <i class='bx bxs-user-badge text-warning'></i>
                        </div>
                        <h5 class="mb-1">มอบหมายงานขับรถ</h5>
                        <p class="text-muted">กรุณาเลือกพนักงานขับรถสำหรับรายการนี้</p>
                    </div>

                    <input type="hidden" value="" name="carbookingID" id="carbookingID">
                    
                    <div class="form-floating form-floating-custom">
                        <select name="Driver" id="Driver" class="form-select" required>
                            <option value="">เลือกพนักงานขับรถ...</option>
                            <?php foreach ($CarDriver as $key => $v_CarDriver):?>
                            <option value="<?=$v_CarDriver->pers_id?>">
                                <?=$v_CarDriver->pers_prefix.$v_CarDriver->pers_firstname.' '.$v_CarDriver->pers_lastname;?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="Driver">พนักงานขับรถ</label>
                        <div class="invalid-feedback">
                            กรุณาเลือกพนักงานขับรถ
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <div class="d-flex w-100 justify-content-between gap-2">
                        <button type="button" id="BtnNoAppoveCarBooking" class="btn btn-danger px-4">
                            <i class='bx bx-x-circle me-1'></i> ไม่อนุมัติ
                        </button>
                        <button type="submit" class="btn btn-success px-4">
                            <i class='bx bx-check-circle me-1'></i> อนุมัติการจอง
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Detail Modal -->
<div class="modal fade" id="ViewDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-white">
                    <i class='bx bx-detail me-2'></i> รายละเอียดการจอง
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-break lh-lg">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

