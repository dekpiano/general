<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="py-3 mb-0 d-none d-md-block">
                    <span class="text-muted fw-light">งานแจ้งซ่อม /</span> สถานะการซ่อม
                </h4>
                <div class="dt-buttons">
                    <a href="<?=base_url('Repair/Add')?>" class="btn btn-primary btn-lg me-2">
                        <i class="bx bx-plus me-1"></i>แจ้งซ่อม/แจ้งปัญหา
                    </a>
                    <a href="<?=base_url('Repair/RepairStatistics')?>" class="btn btn-outline-secondary">
                        <span><i class="bx bx-bar-chart me-1"></i><span class="d-none d-sm-inline-block">สถิติ</span></span>
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">รายการแจ้งซ่อมทั้งหมด</h5>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table table-hover nowrap dataTable dtr-inline collapsed" id="TbDataRepair">
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
                        <tbody class="table-border-bottom-0">
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
</div>

<!-- Modal to show repair details -->
<div class="modal fade" id="ModalShowRepair" tabindex="-1" aria-labelledby="ModalShowRepairLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalShowRepairLabel">รายละเอียดรายการแจ้งซ่อม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded here dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                <a href="#" target="_blank" class="btn btn-primary PrintOrder">พิมพ์ใบแจ้งซ่อม</a>
            </div>
        </div>
    </div>
</div>