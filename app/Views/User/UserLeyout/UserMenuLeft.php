<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="<?=base_url()?>" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" alt="" width="40">
                    </span>
                    <span class="app-brand-text menu-text fw-bolder ms-2">สกจ.บริหารทั่วไป</span>
                </a>

                <a href="<?=base_url()?>" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item <?php echo $UrlMenuMain == ""?"active":""?>">
                    <a href="<?=base_url();?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">หน้าแรก</div>
                    </a>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">งานอาคารสถานที่</span>
                </li>
                <li class="menu-item <?php echo $UrlMenuMain == "Booking"?"active":""?>">
                    <a href="<?=base_url('Booking');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-home-circle"></i>
                        <div data-i18n="Analytics">จองห้อง / สถานที่</div>
                    </a>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">งานยานพาหนะ</span>
                </li>
                <li class="menu-item <?php echo $UrlMenuMain == "CarBooking"?"active":""?>">
                    <a href="<?=base_url('CarBooking');?>" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-car'></i>
                        <div data-i18n="Analytics">จองรถ</div>
                    </a>
                </li>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">งานโสตทัศนูปกรณ์</span>
                </li>
                <!-- แจ้งซ่อม -->
                <li class="menu-item <?php echo $UrlMenuMain == "Repair"?"active":""?>">
                    <a href="<?=base_url('Repair');?>" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-wrench'></i>
                        <div data-i18n="Analytics">แจ้งซ่อมออนไลน์</div>
                    </a>
                </li>
            </ul>
            <div>
                <?php if(isset($_SESSION['username']) && @$_SESSION['status'] == "AdminGeneral" || @$_SESSION['status'] == 'ManagerGeneral'): ?>
                <ul class="menu-inner py-1">
                    <li class="menu-item">
                        <!-- data-bs-toggle="modal" data-bs-target="#modalToggle" -->
                        <a href="<?=base_url('Admin/Home');?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-key"></i>
                            <div data-i18n="Analytics">จัดการข้อมูลระบบ</div>
                        </a>
                    </li>
                </ul>
                <?php else: ?>
                <ul class="menu-inner py-1">
                    <li class="menu-item">
                        <!-- data-bs-toggle="modal" data-bs-target="#modalToggle" -->
                        <a href="<?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>"
                            class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-key"></i>
                            <div data-i18n="Analytics">เข้าสู่ระบบ</div>
                        </a>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </aside>
        <!-- / Menu -->

        <!-- Modal 1-->
        <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="authentication-inner">
                            <!-- Register -->

                            <h4 class="mb-2">Welcome to Login SKJ E-Office 👋</h4>
                            <p class="mb-4">สำหรับเจ้าหน้าที่</p>


                            <div class="d-flex justify-content-center">
                                <?php //echo $GoogleButton; ?>
                            </div>

                            <!-- /Register -->
                        </div>
                    </div>
                </div>
            </div>
        </div>