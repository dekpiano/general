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
                <?php if(session()->has('username') && (session('rloes') != '' || in_array(session('status'), ['AdminGeneral', 'ManagerGeneral', 'ExecutiveGeneral', 'admin']))): ?>
                <!-- Notifications -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        <i class="bi bi-bell fs-4"></i>
                        <span id="notification-badge" class="badge bg-danger rounded-pill badge-notifications" style="display:none;">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end py-0" style="min-width: 320px; max-height: 500px; overflow-y: auto;">
                        <li class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h5 class="text-body mb-0 me-auto fw-bold">การแจ้งเตือน Admin</h5>
                                <span class="badge bg-label-primary dropdown-notifications-all-count">0</span>
                            </div>
                        </li>
                        <li class="dropdown-notifications-list">
                            <ul class="list-group list-group-flush" id="notification-list">
                                <li class="list-group-item list-group-item-action dropdown-notifications-item text-center py-4">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">กำลังโหลด...</span>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!--/ Notifications -->
                <?php endif; ?>

                <?php if(session()->has('username')): ?>
                <li class="nav-item me-2 d-none d-sm-block">
                    <span class="badge rounded-pill bg-success">กำลังใช้งาน</span>
                </li>
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online" style="width: 38px; height: 38px; background: transparent !important;">
                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= session('pers_img') ?>"
                                alt="User Avatar" class="rounded-circle object-fit-cover w-100 h-100">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <div class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online" style="width: 45px; height: 45px; background: transparent !important;">
                                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?= session('pers_img') ?>"
                                                alt="User Avatar" class="rounded-circle object-fit-cover w-100 h-100">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-bold d-block fs-6"><?= session('username') ?></span>
                                        <small class="text-primary fw-medium"><?= session('status') ?? 'Member' ?></small>
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
                    <a href="<?= base_url('LoginOfficerGeneral?return_to=' . urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")) ?>" 
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
