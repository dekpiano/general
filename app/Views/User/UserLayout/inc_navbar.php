    <!-- Navbar -->
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Title -->
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    <i class="bx bx-chevron-right text-muted me-2 d-none d-md-block"></i>
                    <span class="fw-bold text-dark fs-5" style="letter-spacing: -0.5px;"><?= $title ?></span>
                </div>
            </div>
            <!-- /Title -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <?php if(isset($_SESSION['username'])): ?>
                <li class="nav-item me-2 d-none d-sm-block">
                    <span class="badge rounded-pill bg-success">กำลังใช้งาน</span>
                </li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online shadow-sm" style="width: 38px; height: 38px;">
                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?=@$_SESSION['pers_img']?>"
                                alt="User Avatar" class="rounded-circle border-white border-2 object-fit-cover w-100 h-100">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <div class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online" style="width: 45px; height: 45px;">
                                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?=@$_SESSION['pers_img']?>"
                                                alt="User Avatar" class="rounded-circle object-fit-cover w-100 h-100">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-bold d-block fs-6"><?=@$_SESSION['username']?></span>
                                        <small class="text-primary fw-medium"><?=@$_SESSION['status'] ?? 'Member'?></small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><div class="dropdown-divider"></div></li>
                        <li>
                            <a class="dropdown-item" href="<?=base_url('/LogoutOfficerGeneral')?>">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">ออกจากระบบ</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="nav-item me-2">
                    <span class="text-muted small d-none d-sm-block">ผู้ใช้งานทั่วไป</span>
                </li>
                <li class="nav-item">
                    <a href="<?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>" 
                       class="btn btn-primary btn-sm">
                        <i class="bx bx-log-in me-1"></i>
                        <span class="d-none d-sm-inline-block">เข้าสู่ระบบ</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <!-- / Navbar -->
