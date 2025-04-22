<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">

            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item me-3 mb-2">
                    <a class="nav-link active" href="<?=base_url('Repair/Add')?>"><i class="bx bx-bell me-1"></i>
                        แจ้งซ่อม/แจ้งปัญหา</a>
                </li>
                <li class="nav-item me-3 mb-2">
                    <a class="nav-link active" href="<?=base_url('Repair')?>"><i class="bx bx-user me-1"></i>
                        สถานะการซ่อม</a>
                </li>

                <li class="nav-item me-3 mb-2">
                    <a class="nav-link active" href="pages-account-settings-connections.html"><i
                            class="bx bx-link-alt me-1"></i> สถิติแจ้งซ่อม</a>
                </li>
            </ul>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart-type"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart-status"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->