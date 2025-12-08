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
                            <h4 class="fw-bold mb-0 text-primary"><i class="bx bx-bar-chart-alt-2 me-2"></i>สถิติการแจ้งซ่อม</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-style1 mb-0 mt-2">
                                    <li class="breadcrumb-item">
                                        <a href="<?=base_url('Repair')?>" class="text-primary">งานแจ้งซ่อม</a>
                                    </li>
                                    <li class="breadcrumb-item active text-muted">สถิติ</li>
                                </ol>
                            </nav>
                        </div>
                         <div class="d-flex gap-2">
                            <a href="<?=base_url('Repair')?>" class="btn btn-outline-primary bg-white border-0 shadow-sm text-primary fw-bold">
                                <i class="bx bx-arrow-back me-1"></i> ย้อนกลับ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="card-title text-primary mb-0"><i class="bx bx-pie-chart-alt me-2"></i>สถิติแยกตามประเภท</h5>
                </div>
                <div class="card-body pt-4">
                    <div id="chart-type" style="min-height: 365px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="card-title text-primary mb-0"><i class="bx bx-doughnut-chart me-2"></i>สถิติแยกตามสถานะ</h5>
                </div>
                <div class="card-body pt-4">
                    <div id="chart-status" style="min-height: 365px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
