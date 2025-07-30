<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('Repair') ?>">งานแจ้งซ่อม</a>
                    </li>
                    <li class="breadcrumb-item active">สถิติการแจ้งซ่อม</li>
                </ol>
            </nav>

            <h4 class="py-3 mb-4">
                สถิติการแจ้งซ่อม
            </h4>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <h5 class="card-header">สถิติแยกตามประเภท</h5>
                        <div class="card-body">
                            <div id="chart-type" style="min-height: 365px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <h5 class="card-header">สถิติแยกตามสถานะ</h5>
                        <div class="card-body">
                            <div id="chart-status" style="min-height: 365px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
</div>