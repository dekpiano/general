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
                    <span class="app-brand-text menu-text fw-bolder ms-2">SKJ E-Office</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
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

                <!-- Layouts -->
                <li class="menu-item <?php echo $UrlMenuMain == "WorkSaraban"?"active open":""?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-layout"></i>
                        <div data-i18n="Layouts">งานสารบรรณ</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item <?php echo $UrlMenuSub == "InstructionMain"?"active":""?>">
                            <a href="<?=base_url('User/WorkSaraban/InstructionMain')?>" class="menu-link">
                                <div data-i18n="Without menu">หนังสือคำสั่ง</div>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>

            <div>
                <ul class="menu-inner py-1">
                    <li class="menu-item"> <!-- data-bs-toggle="modal" data-bs-target="#modalToggle" -->
                        <a href="<?=base_url('LoginEoffice');?>" class="menu-link" >
                            <i class="menu-icon tf-icons bx bxs-key"></i>
                            <div data-i18n="Analytics">เข้าสู่ระบบ (เจ้าหน้าที่)</div>
                        </a>
                    </li>
                </ul>
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