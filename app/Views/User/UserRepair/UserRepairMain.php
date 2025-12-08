<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h4 class="py-3 mb-0">
            <span class="text-muted fw-light">งานแจ้งซ่อม /</span> สถานะการซ่อม
        </h4>
        <div>
            <a href="<?=base_url('Repair/Add')?>" class="btn btn-primary me-2">
                <i class="bx bx-plus me-1"></i>แจ้งซ่อม/แจ้งปัญหา
            </a>
            <a href="<?=base_url('Repair/RepairStatistics')?>" class="btn btn-outline-secondary">
                <i class="bx bx-bar-chart me-1"></i>สถิติ
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">รายการแจ้งซ่อมทั้งหมด</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover nowrap" id="TbDataRepair" style="width:100%">
                <thead>
                    <tr>
                        <th>สถานะ</th>
                        <th>รายการแจ้งซ่อม</th>
                        <th>วันที่แจ้งซ่อม</th>
                        <th>ใบแจ้งซ่อม</th>
                        <th>ผู้แจ้งซ่อม</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="ModalShowRepair" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดรายการแจ้งซ่อม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                <a href="#" target="_blank" class="btn btn-primary PrintOrder">พิมพ์ใบแจ้งซ่อม</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
