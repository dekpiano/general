<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme border-end-0 shadow-sm"
    style="background: rgba(255, 255, 255, 0.95) !important; backdrop-filter: blur(10px);">
    <div class="app-brand demo py-4">
        <a href="<?= base_url() ?>" class="app-brand-link">
            <span class="app-brand-logo demo">
                <div class="p-2 rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                    style="width: 45px; height: 45px;">
                    <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" alt="" width="32">
                </div>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-3"
                style="font-size: 1.15rem; color: #566a7f; letter-spacing: -0.5px;">สกจ. <span
                    class="text-primary">บริหารทั่วไป</span></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle text-primary"></i>
        </a>
    </div>

    <div class="menu-inner-shadow" style="background: linear-gradient(#fff 5%,rgba(255,255,255,0) 95%); height: 3rem;">
    </div>

    <ul class="menu-inner py-1">
        <!-- Home -->
        <li class="menu-item <?= $UrlMenuMain == "" ? "active" : "" ?>">
            <a href="<?= base_url(); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>หน้าแรก</div>
            </a>
        </li>

        <!-- Systems Header -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">ระบบ</span>
        </li>

        <li class="menu-item <?= $UrlMenuMain == "Booking" ? "active" : "" ?>">
            <a href="<?= base_url('Booking'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-building-house"></i>
                <div>จองห้อง / สถานที่</div>
            </a>
        </li>

        <li class="menu-item <?= $UrlMenuMain == "CarBooking" ? "active" : "" ?>">
            <a href="<?= base_url('CarBooking'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-car"></i>
                <div>จองยานพาหนะ</div>
            </a>
        </li>

        <li class="menu-item <?= $UrlMenuMain == "Repair" ? "active" : "" ?>">
            <a href="<?= base_url('Repair'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wrench"></i>
                <div>แจ้งซ่อมออนไลน์</div>
            </a>
        </li>

        <li class="menu-item <?= $UrlMenuMain == "FoodReport" ? "active" : "" ?>">
            <a href="<?= base_url('FoodReport'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-food-menu"></i>
                <div>รายงานอาหาร</div>
            </a>
        </li>

        <?php 
        $userRoles = json_decode($_SESSION['rloes'] ?? '[]', true) ?: [];
        $isEquipmentStaff = (isset($_SESSION['username']) && (
            in_array(@$_SESSION['status'], ['superadmin', 'admin', 'AdminGeneral']) ||
            in_array('งานพัสดุและอุปกรณ์', $userRoles)
        ));
        ?>
        <li class="menu-item <?= ($UrlMenuMain ?? '') == "Equipment" ? "active open" : "" ?>">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box text-primary"></i>
                <div>ยืม-คืนพัสดุอุปกรณ์</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item <?= ($UrlMenuSub ?? '') == "EquipmentMain" ? "active" : "" ?>">
                    <a href="<?= base_url('Equipment'); ?>" class="menu-link">
                        <div>รายการพัสดุ / บริการยืม</div>
                    </a>
                </li>
                <li class="menu-item <?= ($UrlMenuSub ?? '') == "EquipmentAdd" ? "active" : "" ?>">
                    <a href="<?= base_url('Equipment/Add'); ?>" class="menu-link">
                        <div>ยื่นคำขอยืมพัสดุ</div>
                    </a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                <li class="menu-item <?= ($UrlMenuSub ?? '') == "EquipmentHistory" ? "active" : "" ?>">
                    <a href="<?= base_url('Equipment/History'); ?>" class="menu-link">
                        <div>ประวัติการยืมของฉัน</div>
                    </a>
                </li>
                <?php endif; ?>

                <!-- เมนูสำหรับเจ้าหน้าที่พัสดุ (แสดงในหน้าบ้าน ไม่ต้องเด้งไปหลังบ้าน) -->
                <?php if ($isEquipmentStaff): ?>
                <li class="menu-header small text-uppercase py-1 ps-3">
                    <span class="badge bg-label-warning text-dark fw-bold" style="font-size: 0.7rem;">
                        <i class="bx bx-shield-quarter me-1"></i> สำหรับเจ้าหน้าที่
                    </span>
                </li>
                <li class="menu-item <?= ($UrlMenuSub ?? '') == "EquipmentApprove" ? "active" : "" ?>">
                    <a href="<?= base_url('Equipment/Approve'); ?>" class="menu-link fw-bold text-primary">
                        <i class="bx bx-check-shield me-2"></i>
                        <div>รายการอนุมัติ & รับ-ส่งคืน</div>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
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
            <a href="<?= base_url('manual/booking'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div>คู่มือจองสถานที่</div>
            </a>
        </li>

        <li class="menu-item <?= $UrlMenuMain == "ManualCarBooking" ? "active" : "" ?>">
            <a href="<?= base_url('manual/car-booking'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-reader"></i>
                <div>คู่มือจองยานพาหนะ</div>
            </a>
        </li>

        <li class="menu-item <?= $UrlMenuMain == "ManualRepair" ? "active" : "" ?>">
            <a href="<?= base_url('manual/repair'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-content"></i>
                <div>คู่มือแจ้งซ่อม</div>
            </a>
        </li>

        <li class="menu-item <?= $UrlMenuMain == "ManualFoodReport" ? "active" : "" ?>">
            <a href="<?= base_url('manual/food-report'); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-bookmark"></i>
                <div>คู่มือรายงานอาหาร</div>
            </a>
        </li>

        <!-- Admin Section -->
        <?php 
        $userRoles = json_decode($_SESSION['rloes'] ?? '[]', true) ?: [];
        $isAdminRole = (isset($_SESSION['username']) && (
            in_array(@$_SESSION['status'], ['superadmin', 'admin', 'AdminGeneral']) ||
            in_array('งานพัสดุและอุปกรณ์', $userRoles) ||
            in_array('งานอาคารสถานที่', $userRoles) ||
            in_array('งานยานพาหนะ', $userRoles)
        ));
        if ($isAdminRole): 
        ?>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">เจ้าหน้าที่ / ผู้ดูแลระบบ</span>
            </li>
            <li class="menu-item <?= ($UrlMenuMain ?? '') == "AdminHome" ? "active" : "" ?>">
                <a href="<?= base_url('Admin/Equipment/Approve'); ?>" class="menu-link text-primary fw-bold" style="background: rgba(105, 108, 255, 0.08); border-radius: 0 20px 20px 0;">
                    <i class="menu-icon tf-icons bx bx-shield-quarter text-primary"></i>
                    <div>ระบบจัดการหลังบ้าน (Admin)</div>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</aside>
<!-- / Menu -->