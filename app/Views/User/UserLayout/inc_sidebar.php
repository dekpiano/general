        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="<?=base_url()?>" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" alt="" width="40">
                    </span>
                    <span class="app-brand-text demo menu-text fw-bolder ms-2">สกจ.บริหารทั่วไป</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

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

                <!-- Admin Section -->
                <?php if(isset($_SESSION['username']) && (@$_SESSION['status'] == "AdminGeneral" || @$_SESSION['status'] == 'ManagerGeneral')): ?>
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">ผู้ดูแลระบบ</span>
                </li>
                <li class="menu-item">
                    <a href="<?=base_url('Admin/Home');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-cog"></i>
                        <div>จัดการข้อมูลระบบ</div>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </aside>
        <!-- / Menu -->
