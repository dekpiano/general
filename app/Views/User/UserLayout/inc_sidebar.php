        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme border-end-0 shadow-sm" style="background: rgba(255, 255, 255, 0.95) !important; backdrop-filter: blur(10px);">
            <div class="app-brand demo py-4">
                <a href="<?=base_url()?>" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <div class="p-2 rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" alt="" width="32">
                        </div>
                    </span>
                    <span class="app-brand-text demo menu-text fw-bold ms-3" style="font-size: 1.15rem; color: #566a7f; letter-spacing: -0.5px;">สกจ. <span class="text-primary">บริหารทั่วไป</span></span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle text-primary"></i>
                </a>
            </div>

            <div class="menu-inner-shadow" style="background: linear-gradient(#fff 5%,rgba(255,255,255,0) 95%); height: 3rem;"></div>

            <ul class="menu-inner py-1">
                <!-- Home -->
                <li class="menu-item <?= $UrlMenuMain == "" ? "active" : "" ?>">
                    <a href="<?=base_url();?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div>หน้าแรก</div>
                    </a>
                </li>

                <!-- Systems Header -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">ระบบ</span>
                </li>

                <li class="menu-item <?= $UrlMenuMain == "Booking" ? "active" : "" ?>">
                    <a href="<?=base_url('Booking');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-building-house"></i>
                        <div>จองห้อง / สถานที่</div>
                    </a>
                </li>

                <li class="menu-item <?= $UrlMenuMain == "CarBooking" ? "active" : "" ?>">
                    <a href="<?=base_url('CarBooking');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-car"></i>
                        <div>จองยานพาหนะ</div>
                    </a>
                </li>

                <li class="menu-item <?= $UrlMenuMain == "Repair" ? "active" : "" ?>">
                    <a href="<?=base_url('Repair');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-wrench"></i>
                        <div>แจ้งซ่อมออนไลน์</div>
                    </a>
                </li>

                <li class="menu-item <?= $UrlMenuMain == "FoodReport" ? "active" : "" ?>">
                    <a href="<?=base_url('FoodReport');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-food-menu"></i>
                        <div>รายงานอาหาร</div>
                    </a>
                </li>

                <!-- Documents Header -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">โหลดเอกสาร</span>
                </li>

                <li class="menu-item">
                    <a href="https://documentcenter.skj.ac.th/category/dictation-general" class="menu-link" target="_blank">
                        <i class="menu-icon tf-icons bx bx-file"></i>
                        <div>คำสั่ง</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="https://documentcenter.skj.ac.th/category/form-general" class="menu-link" target="_blank">
                        <i class="menu-icon tf-icons bx bx-file-blank"></i>
                        <div>แบบฟอร์ม</div>
                    </a>
                </li>

                <!-- Manual Header -->
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">คู่มือการใช้งาน</span>
                </li>

                <li class="menu-item <?= $UrlMenuMain == "ManualBooking" ? "active" : "" ?>">
                    <a href="<?=base_url('manual/booking');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-book-open"></i>
                        <div>คู่มือจองสถานที่</div>
                    </a>
                </li>

                <li class="menu-item <?= $UrlMenuMain == "ManualCarBooking" ? "active" : "" ?>">
                    <a href="<?=base_url('manual/car-booking');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-book-reader"></i>
                        <div>คู่มือจองยานพาหนะ</div>
                    </a>
                </li>

                <li class="menu-item <?= $UrlMenuMain == "ManualRepair" ? "active" : "" ?>">
                    <a href="<?=base_url('manual/repair');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-book-content"></i>
                        <div>คู่มือแจ้งซ่อม</div>
                    </a>
                </li>

                <li class="menu-item <?= $UrlMenuMain == "ManualFoodReport" ? "active" : "" ?>">
                    <a href="<?=base_url('manual/food-report');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-book-bookmark"></i>
                        <div>คู่มือรายงานอาหาร</div>
                    </a>
                </li>

                <!-- Admin Section -->
                <?php if(isset($_SESSION['username']) && (@$_SESSION['status'] == "AdminGeneral" || @$_SESSION['status'] == 'ManagerGeneral')): ?>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">ผู้ดูแลระบบ</span>
                </li>
                <li class="menu-item <?= $UrlMenuMain == "AdminHome" ? "active" : "" ?>">
                    <a href="<?=base_url('Admin/Home');?>" class="menu-link text-danger fw-bold">
                        <i class="menu-icon tf-icons bx bx-cog text-danger"></i>
                        <div>จัดการข้อมูลระบบ</div>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </aside>
        <!-- / Menu -->
