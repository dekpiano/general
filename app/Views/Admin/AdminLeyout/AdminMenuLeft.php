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
                    <span class="app-brand-text menu-text fw-bolder ms-2">สกจ.ทั่วไป <small>(เจ้าหน้าที่)</small></span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboard -->
                <li class="menu-item <?php echo ($uri->getSegment(2) == "Home"?"active":"")?>">
                    <a href="<?=base_url('Admin/Home');?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div data-i18n="Analytics">หน้าแรก</div>
                    </a>
                </li>

                <!-- Layouts -->
                <?php 
                $session = session();
                $rloesData = $session->get('rloes') ?: '[]';
                $decodedRloes = json_decode($rloesData, true);
                $SubRloes = is_array($decodedRloes) ? $decodedRloes : [];
                $isSuperAdmin = ($session->get('status') === 'superadmin');
                ?>

                <?php if($isSuperAdmin || in_array("งานอาคารสถานที่",$SubRloes)) :?>
                <li class="menu-item <?php echo $uri->getSegment(2) == "LocationRoom"?"active open":""?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-layout"></i>
                        <div data-i18n="Layouts">งานอาคารสถานที่</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item <?php echo $uri->getSegment(3) == "LocationRoomMain"?"active":""?>">
                            <a href="<?=base_url('Admin/LocationRoom/LocationRoomMain')?>" class="menu-link">
                                <div data-i18n="Without menu">ห้องประชุม / สถานที่</div>
                            </a>
                        </li>

                    </ul>
                </li>
                <?php endif; ?>
                <!-- Layouts -->
                <?php if($isSuperAdmin || in_array("งานยานพาหนะ",$SubRloes)) :?>
                <li class="menu-item <?php echo $uri->getSegment(2) == "Car"?"active open":""?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-car"></i>
                        <div data-i18n="Layouts">งานยานพาหนะ</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item <?php echo $uri->getSegment(3) == "CarMain"?"active":""?>">
                            <a href="<?=base_url('Admin/Car/CarMain')?>" class="menu-link">
                                <div data-i18n="Without menu">รถยนต์</div>
                            </a>
                        </li>
                        <li class="menu-item <?php echo $uri->getSegment(3) == "CarDriver"?"active":""?>">
                            <a href="<?=base_url('Admin/Car/CarDriver')?>" class="menu-link">
                                <div data-i18n="Without menu">คนขับรถ</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- งานพัสดุและอุปกรณ์ -->
                <?php if($isSuperAdmin || in_array("งานพัสดุและอุปกรณ์",$SubRloes)) :?>
                <li class="menu-item <?php echo $uri->getSegment(2) == "Equipment"?"active open":""?>">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-box"></i>
                        <div data-i18n="Layouts">งานพัสดุและอุปกรณ์</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item <?php echo ($uri->getSegment(2) == "Equipment" && $uri->getSegment(3) == "Approve")?"active":""?>">
                            <a href="<?=base_url('Admin/Equipment/Approve')?>" class="menu-link">
                                <div data-i18n="Without menu">รายการยืม-คืนพัสดุ</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

            </ul>

            <?php if($session->get('status') === 'superadmin') : ?>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text text-danger fw-bold"><i class='bx bxs-crown me-1'></i> สำหรับผู้ดูแลระบบสูงสุด</span>
            </li>
            <li class="menu-item <?php echo $uri->getSegment(2) == "Rloes"?"active":""?>">
                <a href="<?=base_url('Admin/Rloes/Setting');?>" class="menu-link" style="background: rgba(255, 62, 29, 0.05); border-radius: 0 20px 20px 0; border-left: 4px solid #ff3e1d;">
                    <i class="menu-icon tf-icons bx bx-fingerprint text-danger"></i>
                    <div data-i18n="Analytics" class="text-danger fw-bold">จัดการสิทธิ์ผู้ใช้งาน</div>
                    <div class="badge bg-label-danger rounded-pill ms-auto">Superadmin</div>
                </a>
            </li>
            <?php endif; ?>
        </aside>
        <!-- / Menu -->