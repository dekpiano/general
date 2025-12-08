<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-label-primary border-0 text-white overflow-hidden wave-bg">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-0 text-primary"><i class="bx bx-wrench me-2"></i>ระบบงานแจ้งซ่อมออนไลน์</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-style1 mb-0 mt-2">
                                    <li class="breadcrumb-item">
                                        <a href="<?=base_url('Repair')?>" class="text-primary">หน้าหลัก</a>
                                    </li>
                                    <li class="breadcrumb-item active text-muted">รายการแจ้งซ่อม</li>
                                </ol>
                            </nav>
                        </div>
                         <div class="d-flex gap-2">
                             <a href="<?=base_url('Repair/RepairStatistics')?>" class="btn btn-outline-primary bg-white border-0 shadow-sm text-primary fw-bold">
                                <i class="bx bx-bar-chart-alt-2 me-1"></i> สถิติ
                            </a>
                            <a href="<?=base_url('Repair/Add')?>" class="btn btn-primary shadow-sm fw-bold">
                                <i class="bx bx-plus-circle me-1"></i> แจ้งซ่อมใหม่
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom-0 py-3">
            <h5 class="card-title text-primary mb-0"><i class="bx bx-list-ul me-2"></i>รายการแจ้งซ่อมทั้งหมด</h5>
        </div>
        <div class="card-datatable table-responsive pt-0">
            <table class="table table-hover nowrap" id="TbDataRepair" style="width:100%">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 rounded-start-2">สถานะ</th>
                        <th class="py-3">รายการแจ้งซ่อม</th>
                        <th class="py-3">วันที่แจ้งซ่อม</th>
                        <th class="py-3">ใบแจ้งซ่อม</th>
                        <th class="py-3">ผู้แจ้งซ่อม</th>
                        <th class="py-3 rounded-end-2">รายละเอียด</th>
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
        <div class="modal-content rounded-3 border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="bx bx-file me-2"></i>รายละเอียดรายการแจ้งซ่อม</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light"></div>
            <div class="modal-footer bg-white">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                <a href="#" target="_blank" class="btn btn-primary PrintOrder shadow-sm"><i class="bx bx-printer me-1"></i> พิมพ์ใบแจ้งซ่อม</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
