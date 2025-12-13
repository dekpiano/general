<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    color: #fff;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    filter: blur(20px);
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -20%;
    left: 5%;
    width: 150px;
    height: 150px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    filter: blur(15px);
}

.page-header h4 {
    color: #fff;
    margin: 0;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-header .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0.5rem 0 0;
}

.page-header .breadcrumb-item,
.page-header .breadcrumb-item a {
    color: rgba(255,255,255,0.9);
    font-size: 0.875rem;
    text-decoration: none;
}

.page-header .breadcrumb-item.active {
    color: #fff;
    font-weight: 500;
}

/* Stats Cards */
.stats-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stats-card .icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin-bottom: 1rem;
}

.stats-card .stats-title {
    color: #8592a3;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.stats-card .stats-value {
    color: #566a7f;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0;
}

.stats-card .progress-wrapper {
    margin-top: 1rem;
    height: 4px;
    background: #f0f2f5;
    border-radius: 2px;
    overflow: hidden;
}

.stats-card .progress-bar {
    height: 100%;
    border-radius: 2px;
}

/* Specific Card Styles */
.stats-card.primary .icon-wrapper { background: rgba(255, 62, 29, 0.1); color: #ff3e1d; }
.stats-card.primary .progress-bar { background: #ff3e1d; }

.stats-card.warning .icon-wrapper { background: rgba(255, 171, 0, 0.1); color: #ffab00; }
.stats-card.warning .progress-bar { background: #ffab00; }

.stats-card.info .icon-wrapper { background: rgba(3, 195, 236, 0.1); color: #03c3ec; }
.stats-card.info .progress-bar { background: #03c3ec; }

.stats-card.success .icon-wrapper { background: rgba(113, 221, 55, 0.1); color: #71dd37; }
.stats-card.success .progress-bar { background: #71dd37; }

/* Table Card */
.table-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: none;
    overflow: hidden;
}

.table-card .card-header {
    background: #fff;
    padding: 1.5rem;
    border-bottom: 1px solid #f0f2f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-card .card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #566a7f;
    margin: 0;
    display: flex;
    align-items: center;
}

/* Action Buttons */
.btn-new-repair {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
    border: none;
    color: #fff;
    padding: 0.6rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
    transition: all 0.3s ease;
}

.btn-new-repair:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(255, 107, 107, 0.5);
    color: #fff;
}

.btn-stats {
    background: #fff;
    color: #ff3e1d;
    border: 1px solid #ff3e1d;
    padding: 0.6rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-stats:hover {
    background: rgba(255, 62, 29, 0.05);
    color: #ff3e1d;
}

/* Data Table Styling */
table.dataTable thead th {
    background: #fafbfc;
    border-bottom: 2px solid #f0f2f5 !important;
    color: #566a7f;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
}

table.dataTable tbody td {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid #f9fafb;
    vertical-align: middle;
    color: #697a8d;
    font-size: 0.9rem;
}

table.dataTable tbody tr:hover {
    background-color: rgba(67, 89, 113, 0.02) !important;
}

/* Badge Styling */
.badge-custom {
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
        text-align: center;
    }
    .page-header .row {
        flex-direction: column;
        gap: 1rem;
    }
    .page-header .col-md-7, 
    .page-header .col-md-5 {
        text-align: center !important;
        justify-content: center !important;
    }
    .stats-card {
        margin-bottom: 1rem;
    }
    .table-card .card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    .table-card .card-actions {
        width: 100%;
        display: flex;
        justify-content: flex-end;
    }
}

/* Modal Improvements */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.modal-header {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
    color: #fff;
    padding: 1.5rem;
    border-radius: 16px 16px 0 0;
}

.modal-title {
    font-weight: 600;
    display: flex;
    align-items: center;
}

.btn-close-white {
    filter: brightness(0) invert(1);
}

</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h4><i class='bx bxs-wrench me-2'></i>ระบบงานแจ้งซ่อมออนไลน์</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url('Repair')?>">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการแจ้งซ่อม</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2 align-items-center">
                <div class="d-inline-block">
                    <select class="form-select border-0 shadow-sm text-primary fw-bold" id="yearFilter" onchange="window.location.href='<?=base_url('Repair')?>?year='+this.value" style="width: auto; cursor: pointer; position: relative; z-index: 1005;">
                        <?php foreach($years as $y): ?>
                        <option value="<?=$y?>" <?=$y == $selectedYear ? 'selected' : ''?>>ปี <?=$y+543?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- <a href="<?=base_url('Repair/RepairStatistics')?>" class="btn btn-stats">
                    <i class="bx bx-bar-chart-alt-2 me-1"></i> สถิติ
                </a> -->
                <a href="<?=base_url('Repair/Add')?>" class="btn btn-new-repair">
                    <i class="bx bx-plus me-1"></i> แจ้งซ่อมใหม่
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Total Repair -->
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-card primary">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="icon-wrapper">
                            <i class='bx bxs-wrench'></i>
                        </div>
                        <h6 class="stats-title">รายการแจ้งซ่อมทั้งหมด (ปี <?=$selectedYear+543?>)</h6>
                        <h3 class="stats-value"><?= number_format($TotalRepair ?? 0) ?></h3>
                    </div>
                </div>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="icon-wrapper">
                            <i class='bx bxs-time-five'></i>
                        </div>
                        <h6 class="stats-title">รอดำเนินการ</h6>
                        <h3 class="stats-value"><?= number_format($StatusPending ?? 0) ?></h3>
                    </div>
                </div>
                <?php 
                    $percentPending = ($TotalRepair ?? 0) > 0 ? (($StatusPending ?? 0) / $TotalRepair) * 100 : 0;
                ?>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: <?=$percentPending?>%"></div>
                </div>
            </div>
        </div>

        <!-- Processing -->
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-card info">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="icon-wrapper">
                            <i class='bx bxs-cog bxs-spin'></i>
                        </div>
                        <h6 class="stats-title">กำลังดำเนินการ</h6>
                        <h3 class="stats-value"><?= number_format($StatusProcess ?? 0) ?></h3>
                    </div>
                </div>
                <?php 
                    $percentProcess = ($TotalRepair ?? 0) > 0 ? (($StatusProcess ?? 0) / $TotalRepair) * 100 : 0;
                ?>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: <?=$percentProcess?>%"></div>
                </div>
            </div>
        </div>

        <!-- Success -->
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card success">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="icon-wrapper">
                            <i class='bx bxs-check-circle'></i>
                        </div>
                        <h6 class="stats-title">เสร็จสิ้น</h6>
                        <h3 class="stats-value"><?= number_format($StatusSuccess ?? 0) ?></h3>
                    </div>
                </div>
                <?php 
                    $percentSuccess = ($TotalRepair ?? 0) > 0 ? (($StatusSuccess ?? 0) / $TotalRepair) * 100 : 0;
                ?>
                <div class="progress-wrapper">
                    <div class="progress-bar" style="width: <?=$percentSuccess?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bx bx-list-ul me-2 text-primary"></i> รายการแจ้งซ่อมล่าสุด
            </h5>
            <div class="card-actions">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="reloadTable()">
                    <i class='bx bx-refresh me-1'></i> รีโหลด
                </button>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover border-top" id="TbDataRepair" style="width:100%">
                <thead>
                    <tr>
                        <th width="10%">สถานะ</th>
                        <th width="20%">รายการแจ้งซ่อม</th>
                        <th width="15%">วันที่แจ้ง</th>
                        <th width="15%">ใบแจ้งซ่อม</th>
                        <th width="20%">ผู้แจ้ง</th>
                        <th width="10%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function reloadTable() {
        if ($.fn.DataTable.isDataTable('#TbDataRepair')) {
            $('#TbDataRepair').DataTable().ajax.url("<?= base_url('Repair/DataTable/ShowRepari') ?>?year=<?= $selectedYear ?>").load(null, false);
        }
    }
    
    // ...

    $(document).ready(function() {
         $('#TbDataRepair').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "ajax": "<?= base_url('Repair/DataTable/ShowRepari') ?>?year=<?= $selectedYear ?>",
            "columns": [
                { "data": "repair_status", "render": function(data) {
                    let badge = 'bg-label-secondary';
                    if(data=='รอดำเนินการ') badge = 'bg-label-warning';
                    else if(data=='กำลังดำเนินการ') badge = 'bg-label-info';
                    else if(data=='เสร็จสิ้น') badge = 'bg-label-success';
                    return `<span class="badge ${badge}">${data}</span>`;
                }},
                { "data": "repair_caselist" },
                { "data": "repair_datetime" },
                { "data": "repair_order" },
                { "data": "UserFullname" },
                { "data": "repair_ID", "render": function(data, type, row) {
                    return `<a href="<?= base_url('Repair/View/') ?>${row.repair_order}" class="btn btn-sm btn-info"><i class="bx bx-file me-1"></i>รายละเอียด</a>`;
                }}
            ],
            "order": [[ 2, "desc" ]] // order by datetime
        });
        
        // Remove internal ViewRepair function so it falls back to user's implementation
        // window.ViewRepair = ... (Removed)

        $('.btn-new-repair').on('click', function(e) {
            // e.preventDefault(); // Uncomment if you want to handle navigation manually
            const $btn = $(this);
            $btn.html('<span class="spinner-border spinner-border-sm me-1"></span> กำลังไป...');
            $btn.addClass('disabled');
        });
    });
</script>
<!-- Assuming UserRepairMain.js is loaded elsewhere or automagically -->
<?php if(file_exists(FCPATH . 'assets/js/User/UserRepair/UserRepairMain.js')): ?>
<script src="<?=base_url('assets/js/User/UserRepair/UserRepairMain.js?v='.time())?>"></script>
<?php endif; ?>
<?= $this->endSection() ?>
