<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('customCSS') ?>
<style>
    :root {
        --repair-primary: #696cff;
        --repair-secondary: #8592a3;
        --repair-success: #71dd37;
        --repair-info: #03c3ec;
        --repair-warning: #ffab00;
        --repair-danger: #ff3e1d;
        --glass-bg: rgba(255, 255, 255, 0.8);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    .repair-container {
        padding-top: 1.5rem;
        padding-bottom: 3rem;
    }

    /* Premium Header */
    .glass-header {
        background: linear-gradient(135deg, rgba(105, 108, 255, 0.9) 0%, rgba(63, 65, 145, 0.9) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 2rem;
        padding: 2.5rem;
        margin-bottom: 2.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(105, 108, 255, 0.2);
    }

    .glass-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .glass-header h2 {
        color: white;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    /* Glass Stats Cards */
    .glass-stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 1.5rem;
        padding: 1.5rem;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .glass-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-right: 1.25rem;
        flex-shrink: 0;
    }

    .stat-info h6 {
        font-size: 0.85rem;
        color: var(--repair-secondary);
        margin-bottom: 0.25rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-info h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0;
        color: #566a7f;
    }

    /* Table Glass Card */
    .table-glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .card-header-premium {
        padding: 1.75rem 2rem;
        background: rgba(255, 255, 255, 0.5);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Premium Buttons */
    .btn-glass-primary {
        background: #ffffff !important;
        color: var(--repair-primary) !important;
        border: none !important;
        padding: 0.75rem 1.5rem;
        border-radius: 1rem;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease;
    }

    .btn-glass-primary:hover {
        background: #f8f9ff !important;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2) !important;
        color: var(--repair-primary) !important;
    }

    .btn-add-repair {
        background: linear-gradient(135deg, #ff8a00 0%, #ff5e3a 100%);
        color: white !important;
        border: none;
        padding: 0.85rem 2.25rem;
        border-radius: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 25px rgba(255, 94, 58, 0.4);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        animation: pulse-repair 2s infinite;
        position: relative;
        overflow: hidden;
    }

    .btn-add-repair::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transform: rotate(45deg);
        transition: 0.5s;
        display: block;
        animation: shine-repair 3s infinite;
    }

    .btn-add-repair:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 30px rgba(255, 94, 58, 0.5);
        color: white !important;
    }

    @keyframes pulse-repair {
        0% { box-shadow: 0 0 0 0 rgba(255, 94, 58, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(255, 94, 58, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 94, 58, 0); }
    }

    @keyframes shine-repair {
        0% { left: -100%; transition-property: left; }
        20% { left: 100%; transition-property: left; }
        100% { left: 100%; transition-property: left; }
    }

    /* Status Badges Premium */
    .badge-premium {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    /* Filter Styling */
    .year-select {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid var(--glass-border);
        border-radius: 0.75rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
        color: var(--repair-primary);
        cursor: pointer;
        outline: none;
    }

    /* Table Styling */
    #TbDataRepair thead th {
        background: rgba(105, 108, 255, 0.03);
        color: var(--repair-primary);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 1.25rem 1rem;
        border-bottom: 2px solid rgba(105, 108, 255, 0.1);
    }

    #TbDataRepair tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.03);
    }

    #TbDataRepair tbody tr:hover {
        background-color: rgba(105, 108, 255, 0.02) !important;
    }

    @media (max-width: 768px) {
        .glass-header {
            padding: 1.5rem;
            text-align: center;
        }
        .header-actions {
            margin-top: 1rem;
            justify-content: center !important;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 repair-container">
    
    <!-- Premium Header -->
    <div class="glass-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="display-6"><i class='bx bxs-wrench me-3'></i>ระบบแจ้งซ่อมออนไลน์</h2>
                <div class="d-flex align-items-center mt-2">
                    <span class="badge bg-white text-primary rounded-pill px-3 me-2">Repair Management</span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?=base_url('Repair')?>" class="text-white-50">หน้าแรก</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">รายการแจ้งซ่อม</li>
                        </ol>
                    </nav>
                </div>
                <!-- ปุ่มคู่มือและตัวเลือกปี -->
                <div class="d-flex align-items-center gap-2 mt-4 flex-wrap">
                    <a target="_blank" href="<?=base_url('manual/repair') ?>" class="btn btn-glass-primary py-2">
                        <i class='bx bx-book-content me-1'></i> คู่มือการใช้งาน
                    </a>
                    <select class="year-select shadow-sm" id="yearFilter" onchange="window.location.href='<?=base_url('Repair')?>?year='+this.value">
                        <?php foreach($years as $y): ?>
                        <option value="<?=$y?>" <?=$y == $selectedYear ? 'selected' : ''?>>ปีงบประมาณ <?=$y+543?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-md-end header-actions align-items-center mt-3 mt-md-0">
                <a href="<?=base_url('Repair/Add')?>" class="btn btn-add-repair">
                    <i class="bx bx-plus-circle me-1"></i> แจ้งซ่อมใหม่
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-4 mb-5">
        <div class="col-sm-6 col-xl-3">
            <div class="glass-stat-card">
                <div class="stat-icon bg-label-primary">
                    <i class='bx bxs-briefcase-alt-2'></i>
                </div>
                <div class="stat-info">
                    <h6>งานทั้งหมด</h6>
                    <h3><?= number_format($TotalRepair ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="glass-stat-card">
                <div class="stat-icon bg-label-warning">
                    <i class='bx bxs-time-five'></i>
                </div>
                <div class="stat-info">
                    <h6>รอดำเนินการ</h6>
                    <h3><?= number_format($StatusPending ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="glass-stat-card">
                <div class="stat-icon bg-label-info">
                    <i class='bx bxs-cog bxs-spin'></i>
                </div>
                <div class="stat-info">
                    <h6>กำลังดำเนินการ</h6>
                    <h3><?= number_format($StatusProcess ?? 0) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="glass-stat-card">
                <div class="stat-icon bg-label-success">
                    <i class='bx bxs-check-circle'></i>
                </div>
                <div class="stat-info">
                    <h6>เสร็จสิ้นแล้ว</h6>
                    <h3><?= number_format($StatusSuccess ?? 0) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-glass-card">
        <div class="card-header-premium">
            <h5 class="mb-0 fw-bold">
                <i class="bx bx-list-check me-2 text-primary"></i> 
                ข้อมูลการแจ้งซ่อมประจำปี <?= $selectedYear + 543 ?>
            </h5>
            <button type="button" class="btn btn-link text-secondary p-0" onclick="reloadTable()">
                <i class='bx bx-refresh fs-4'></i>
            </button>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover" id="TbDataRepair">
                <thead>
                    <tr>
                        <th width="12%">สถานะ</th>
                        <th width="25%">รายการ/สเตตัส</th>
                        <th width="15%">วันที่แจ้ง</th>
                        <th width="15%">ใบแจ้งซ่อม</th>
                        <th width="20%">ผู้แจ้ง / เบอร์โทร</th>
                        <th width="13%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const SESSION_PERS_ID = '<?= session()->get('id') ?? '' ?>';

    function reloadTable() {
        if ($.fn.DataTable.isDataTable('#TbDataRepair')) {
            const table = $('#TbDataRepair').DataTable();
            table.ajax.url("<?= base_url('Repair/DataTable/ShowRepari') ?>?year=<?= $selectedYear ?>").load(null, false);
        }
    }

    $(document).ready(function() {
        $('.btn-add-repair').on('click', function() {
            $(this).html('<span class="spinner-border spinner-border-sm me-2"></span> กำลังไป...');
            $(this).addClass('disabled');
        });
    });
</script>
<?php if(file_exists(FCPATH . 'assets/js/User/UserRepair/UserRepairMain.js')): ?>
<script src="<?=base_url('assets/js/User/UserRepair/UserRepairMain.js?v='.time())?>"></script>
<?php endif; ?>
<?= $this->endSection() ?>

