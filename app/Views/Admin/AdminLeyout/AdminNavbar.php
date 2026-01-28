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
                <div class="nav-item d-flex align-items-center">
                    <i class="bx bx-search fs-4 lh-0"></i>
                    <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                        aria-label="Search..." />
                </div>
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Notifications -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        <i class="bi bi-bell fs-4"></i>
                        <span id="notification-badge" class="badge bg-danger rounded-pill badge-notifications" style="display:none;">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end py-0" style="min-width: 300px;">
                        <li class="dropdown-menu-header border-bottom">
                            <div class="dropdown-header d-flex align-items-center py-3">
                                <h5 class="text-body mb-0 me-auto">การแจ้งเตือน</h5>
                                <span class="badge bg-label-primary dropdown-notifications-all-count">0</span>
                                <!-- <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="bx fs-4 bx-envelope-open"></i></a> -->
                            </div>
                        </li>
                        <li class="dropdown-notifications-list scrollable-container">
                            <ul class="list-group list-group-flush" id="notification-list">
                                <!-- Notifications will be loaded here via JS -->
                                <li class="list-group-item list-group-item-action dropdown-notifications-item text-center py-4">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!--/ Notifications -->

                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                    <?=$_SESSION['username'];?> <br>
                    <small class="text-muted">Admin</small>
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online" style="width: 38px; height: 38px; background: transparent !important;">
                            <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?=@$_SESSION['pers_img']?>" alt
                                class="w-100 h-100 rounded-circle object-fit-cover" />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                      
                       
                        <!-- <li>
                            <div class="dropdown-divider"></div>
                        </li> -->
                        <li>
                            <a class="dropdown-item" href="<?=base_url('/LogoutOfficerGeneral')?>">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </nav>

    <!-- / Navbar -->