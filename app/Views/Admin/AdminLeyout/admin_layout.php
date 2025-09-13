<!-- admin_layout.php -->
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="<?=base_url()?>/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?=$title;?> | SKJ E-Office</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=base_url()?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@200;300&display=swap" rel="stylesheet">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/select2.css?v=2" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/demo.css?v=1" />

    <link rel="stylesheet" href="<?=base_url()?>/assets/css/flatpickr.css?v=1" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Datatable css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

    <!-- Helpers -->
    <script src="<?=base_url()?>/assets/vendor/js/helpers.js"></script>
    <script src="<?=base_url()?>/assets/js/config.js"></script>
</head>

<body style="font-family:'Sarabun'">
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" alt="" width="40">
                        </span>
                        <span class="app-brand-text menu-text fw-bolder ms-2">สกจ.ทั่วไป
                            <small>(เจ้าหน้าที่)</small></span>
                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item <?php echo ($uri->getSegment(2) == "Home"?"active":"")?>">
                        <a href="<?=base_url('Admin/Home');?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">หน้าแรก</div>
                        </a>
                    </li>

                    <!-- Layouts -->
                    <?php $SubRloes = explode(',',$_SESSION['rloes']); ?>

                    <?php if(in_array("งานอาคารสถานที่",$SubRloes)) :?>
                    <li class="menu-item <?php echo $uri->getSegment(2) == "LocationRoom"?"active open":""?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">งานอาคารสถานที่</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item <?php echo $uri->getSegment(3) == "LocationRoomMain"?"active":""?>">
                                <a href="<?=base_url('Admin/LocationRoom/LocationRoomMain')?>" class="menu-link">
                                    <div data-i18n="Without menu">ห้องประชุม / สถานที่</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <!-- Layouts -->
                    <?php if(in_array("งานยานพาหนะ",$SubRloes)) :?>
                    <li class="menu-item <?php echo $uri->getSegment(2) == "Car"?"active open":""?>">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-layout"></i>
                            <div data-i18n="Layouts">งานยานพาหนะ</div>
                        </a>

                        <ul class="menu-sub">
                            <li class="menu-item <?php echo $uri->getSegment(3) == "CarMain"?"active":""?>">
                                <a href="<?=base_url('Admin/Car/CarMain')?>" class="menu-link">
                                    <div data-i18n="Without menu">รถยนต์</div>
                                </a>
                            </li>
                            <li class="menu-item <?php echo $uri->getSegment(3) == "CarDriver"?"active":""?>">
                                <a href="<?=base_url('Admin/Car/CarDriver')?>" class="menu-link">
                                    <div data-i18n="Without menu">คนขับรถ</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>

                </ul>

                <?php if($_SESSION['id'] == "pers_021") : ?>
                <div>
                    <ul class="menu-inner py-1">
                        <li class="menu-item <?php echo $uri->getSegment(2) == "Rloes"?"active":""?>">
                            <a href="<?=base_url('Admin/Rloes/Setting');?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                                <div data-i18n="Analytics">กำหนดสิทธิ์ใช้งาน</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                                    aria-label="Search..." />
                            </div>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item lh-1 me-3">
                                <?=$_SESSION['username'];?> <br>
                                <small class="text-muted">Admin</small>
                            </li>
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="<?=base_url()?>/assets/img/avatars/1.png" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="<?=base_url('/LogoutOfficerGeneral')?>">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?= $this->renderSection('content') ?>
                    <!-- / Content -->
                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-end py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                document.write(new Date().getFullYear());
                                </script>
                                , made with ❤️ by
                                <a href="https://facebook.com/dekpiano" target="_blank"
                                    class="footer-link fw-bolder">Dekpiano</a>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->

            </div>
            <!-- / Layout page -->

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- /layout-container -->

    </div>
    <!-- /layout-wrapper -->



    <!-- Core JS -->
    <script src="<?=base_url()?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?=base_url()?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?=base_url()?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?=base_url()?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?=base_url()?>/assets/vendor/js/menu.js"></script>
    <script src="<?=base_url()?>/assets/js/select2.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?=base_url()?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script src="<?=base_url()?>/assets/js/main.js"></script>
    <script src="<?=base_url()?>/assets/js/dashboards-analytics.js"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>


    <?= $this->renderSection('scripts') ?>
</body>

</html>