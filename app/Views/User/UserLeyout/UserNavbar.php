    <!-- Navbar -->

    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
                <?=$title;?>
                <!-- <div class="nav-item d-flex align-items-center">
                    <i class="bx bx-search fs-4 lh-0"></i>
                    <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                        aria-label="Search..." />
                </div> -->
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <?php if(isset($_SESSION['username'])): ?>
                <li>
                    <?=$_SESSION['username']?>
                    <div>
                        <small>
                            สมาชิกในระบบ <?=$_SESSION['status']?>
                        </small>
                    </div>
                </li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="avatar avatar-online">

                            <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt=""
                                class="w-px-40 h-auto rounded-circle">
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
                <?php else: ?>
                <li>
                    ผู้ใช้งานทั่วไป
                </li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="avatar avatar-online">

                            <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt=""
                                class="w-px-40 h-auto rounded-circle">
                        </div>
                    </a>               
                </li>
                <?php endif; ?>
               

            </ul>
        </div>
    </nav>

    <!-- / Navbar -->