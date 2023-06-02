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
                    <li class="menu-item">
                        <a href="#" class="menu-link" data-bs-toggle="modal" data-bs-target="#modalToggle">
                            <i class="menu-icon tf-icons bx bxs-key"></i>
                            <div data-i18n="Analytics">เข้าสู่ระบบ</div>
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

                                    <form id="formAuthentication"
                                        class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" action="index.html"
                                        method="POST" novalidate="novalidate">
                                        <div class="mb-3 fv-plugins-icon-container">
                                            <label for="email" class="form-label">Email or Username</label>
                                            <input type="text" class="form-control" id="email" name="email-username"
                                                placeholder="Enter your email or username" autofocus="">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="password">Password</label>
                                               
                                            </div>
                                            <div class="input-group input-group-merge has-validation">
                                                <input type="password" id="password" class="form-control"
                                                    name="password" placeholder="············"
                                                    aria-describedby="password">
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                            </div>
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                
                                        <div class="mb-3">
                                            <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                                        </div>
                                        <input type="hidden">
                                    </form>

                                    <div class="divider my-4">
                                        <div class="divider-text">or</div>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                    <?php echo $GoogleButton; ?>
                                    </div>
                             
                            <!-- /Register -->
                        </div>
                    </div>                 
                </div>
            </div>
        </div>