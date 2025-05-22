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
                <div class="w-title">
                    <?=$title;?>
                </div>

                <!-- <div class="nav-item d-flex align-items-center">
                    <i class="bx bx-search fs-4 lh-0"></i>
                    <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                        aria-label="Search..." />
                </div> -->
            </div>
            <!-- /Search -->

            <style>
            /* มือถือแนวตั้ง (เล็กมาก) */
            @media screen and (max-width: 575.98px) {
                .one-line-ellipsis {
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    max-width: 160px;
                    /* หรือปรับขนาดเอง */
                    display: block;
                }

                .w-title {
                    width: 160px;
                }

                .w-user {
                    white-space: nowrap;
                    margin-left: -10px;
                }
            }

            /* มือถือ (ทั่วไป) */
            @media screen and (max-width: 767.98px) {}

            /* แท็บเล็ต */
            @media screen and (max-width: 991.98px) {}

            /* โน้ตบุ๊ค */
            @media screen and (max-width: 1199.98px) {}

            /* จอ desktop ใหญ่ */
            @media screen and (max-width: 1399.98px) {}
            </style>

            <ul class="navbar-nav flex-row align-items-center ms-auto ps-3">
                <?php if(isset($_SESSION['username'])): ?>
                <li>
                    <div class="one-line-ellipsis">
                        <!-- <?=$_SESSION['username']?> -->
                        <span class="badge rounded-pill bg-success">กำลังใช้งาน</span>
                    </div>

                    <div>
                        <!-- <small>
                            สมาชิกในระบบ <?=$_SESSION['status']?>
                        </small> -->
                    </div>
                </li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="avatar avatar-online">

                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?=@$_SESSION['pers_img']?>"
                                alt="" class="w-px-40 rounded-circle">
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
                    <div class="w-user">
                        ผู้ใช้งานทั่วไป
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
                </li>
                <?php endif; ?>


            </ul>
        </div>
    </nav>

    <!-- / Navbar -->