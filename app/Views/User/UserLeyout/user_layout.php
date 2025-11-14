<!-- user_layout.php -->
<!DOCTYPE html>
<html lang="th" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="<?=base_url()?>/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?=$title;?> | SKJ บริหารทั่วไป</title>

    <meta name="description" content="<?= $description ?>" />
    <meta
        content="ระบบงาน,E-Office,โรงเรียนสวนกุหลาบวิทยาลัย,โรงเรียน,สวนกุหลาบ,จิรประวัติ,นครสวรรค์,สวนกุหลาบจิรประวัติ,โรงเรียนสวนกุหลาบ"
        name="keywords">
    <meta http-equiv="content-language" content="th" />
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="1 day" />
    <meta name="author" content="Dekpiano" />
    <meta property="og:url" content="<?= $full_url ?>" />
    <meta property="og:title" content="<?=$title;?>" />
    <meta property="og:description" content="<?= $description ?>" />
    <meta property="og:type" content="website" />
    <?php if($uri->getSegment(1) == 'Booking') : ?>
    <meta property="og:image" content="<?=base_url();?>uploads/banner/booking/bannerBooking.png" />
    <?php elseif($uri->getSegment(1) == 'Repair'): ?>
    <meta property="og:image" content="<?=base_url();?>uploads/banner/repair/bannerRepair.jpg" />
    <?php else: ?>
    <meta property="og:image" content="<?=base_url();?>uploads/banner/home/bannerHome.png" />
    <?php endif?>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=base_url()?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@200;300&display=swap" rel="stylesheet">

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Core CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/demo.css?v=1" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/flatpickr.css?v=3" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/select2.css?v=2" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/css/user-repair.css?v=2" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?=base_url()?>/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />

    <!-- Helpers -->
    <script src="<?=base_url()?>/assets/vendor/js/helpers.js"></script>
    <script src="<?=base_url()?>/assets/js/config.js"></script>
</head>

<body style="font-family:'Sarabun'">
    <script>const BASE_URL = '<?= base_url() ?>';</script>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="<?=base_url()?>" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="https://skj.ac.th/uploads/logoSchool/LogoSKJ_4.png" alt="" width="40">
                        </span>
                        <span class="app-brand-text menu-text fw-bolder ms-2">สกจ.บริหารทั่วไป</span>
                    </a>
                    <a href="<?=base_url()?>" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <li class="menu-item <?php echo $UrlMenuMain == ""?"active":""?>">
                        <a href="<?=base_url();?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">หน้าแรก</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">งานอาคารสถานที่</span>
                    </li>
                    <li class="menu-item <?php echo $UrlMenuMain == "Booking"?"active":""?>">
                        <a href="<?=base_url('Booking');?>" class="menu-link">
                            <i class="menu-icon tf-icons bx bxs-home-circle"></i>
                            <div data-i18n="Analytics">จองห้อง / สถานที่</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">งานยานพาหนะ</span>
                    </li>
                    <li class="menu-item <?php echo $UrlMenuMain == "CarBooking"?"active":""?>">
                        <a href="<?=base_url('CarBooking');?>" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-car'></i>
                            <div data-i18n="Analytics">จองยานพาหนะ</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">งานโสตทัศนูปกรณ์</span>
                    </li>
                    <li class="menu-item <?php echo $UrlMenuMain == "Repair"?"active":""?>">
                        <a href="<?=base_url('Repair');?>" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-wrench'></i>
                            <div data-i18n="Analytics">แจ้งซ่อมออนไลน์</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">งานโภชนาการ</span>
                    </li>
                    <li class="menu-item <?php echo $UrlMenuMain == "FoodReport"?"active":""?>">
                        <a href="<?=base_url('FoodReport');?>" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-coffee'></i>
                            <div data-i18n="Analytics">รายงานอาหาร</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">คู่มือการใช้งาน</span>
                    </li>
                    <li class="menu-item <?php echo $UrlMenuMain == "ManualBooking"?"active":""?>">
                        <a href="<?=base_url('manual/booking');?>" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-book-content'></i>
                            <div data-i18n="Analytics">คู่มือจองสถานที่</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $UrlMenuMain == "ManualCarBooking"?"active":""?>">
                        <a href="<?=base_url('manual/car-booking');?>" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-car-garage'></i>
                            <div data-i18n="Analytics">คู่มือจองยานพาหนะ</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo $UrlMenuMain == "ManualRepair"?"active":""?>">
                        <a href="<?=base_url('manual/repair');?>" class="menu-link">
                        <i class='menu-icon tf-icons bx bxs-report'></i>
                            <div data-i18n="Analytics">คู่มือแจ้งซ่อม</div>
                        </a>
                    </li>
                </ul>
                <div>
                    <?php if(isset($_SESSION['username']) && @$_SESSION['status'] == "AdminGeneral" || @$_SESSION['status'] == 'ManagerGeneral'): ?>
                    <ul class="menu-inner py-1">
                        <li class="menu-item">
                            <a href="<?=base_url('Admin/Home');?>" class="menu-link">
                                <i class="menu-icon tf-icons bx bxs-key"></i>
                                <div data-i18n="Analytics">จัดการข้อมูลระบบ</div>
                            </a>
                        </li>
                    </ul>
                    <?php else: ?>
                    <ul class="menu-inner py-1">
                        <li class="menu-item">
                            <a href="<?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>"
                                class="menu-link">
                                <i class="menu-icon tf-icons bx bxs-key"></i>
                                <div data-i18n="Analytics">เข้าสู่ระบบ</div>
                            </a>
                        </li>
                    </ul>
                    <?php endif; ?>
                </div>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <div class="w-title">
                                <?=$title;?>
                            </div>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto ps-3">
                            <?php if(isset($_SESSION['username'])): ?>
                            <li>
                                <div class="one-line-ellipsis">
                                    <span class="badge rounded-pill bg-success">กำลังใช้งาน</span>
                                </div>
                            </li>
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-online">
                                        <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?=@$_SESSION['pers_img']?>" alt="" class="w-px-40 rounded-circle">
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
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-online">
                                        <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt="" class="w-px-40 h-auto rounded-circle">
                                    </div>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?= $this->renderSection('content') ?>
                    <!-- / Content -->

                </div>
                <!-- Content wrapper -->
                   <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl d-flex flex-wrap justify-content-end py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                    ©
                    <script>
                    document.write(new Date().getFullYear());
                    </script>
                    , made with ❤️ by
                    <a href="https://facebook.com/dekpiano" target="_blank" class="footer-link fw-bolder">Dekpiano</a>
                </div>
            </div>
        </footer>
        <!-- / Footer -->

            </div>
            <!-- / Layout page -->

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- /layout-container -->

      
    <!-- Core JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?=base_url()?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?=base_url()?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?=base_url()?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?=base_url()?>/assets/vendor/js/menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://hcaptcha.com/1/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>
    <script src="<?=base_url()?>/assets/js/select2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="<?=base_url()?>/assets/js/main.js"></script>
    <script src="<?=base_url()?>/assets/js/dashboards-analytics.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js"></script>

    <!-- Page-specific scripts -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js"></script>

    <?php if($uri->getSegment(1) == 'Booking') : ?>
    <script src="<?=base_url()?>/assets/js/User/UserBooking/UserBooking.js?v=26"></script>
    <script src="<?=base_url()?>/assets/js/User/UserBooking/UserBookingSignature.js?v=1.3"></script>
    <script src="<?=base_url()?>/assets/js/User/UserBooking/UserBookingCrop.js?v=3"></script>
    <script src="<?=base_url()?>/assets/js/User/UserBooking/UserBookingChart.js?v=1.3"></script>

    <?php elseif($uri->getSegment(1) == 'Repair') : ?>
    <script src="<?=base_url()?>/assets/js/User/UserRepair/UserRepair.js?v=22.2"></script>
    <script src="<?=base_url()?>/assets/js/User/UserRepair/UserRepairStatistics.js?v=1.4"></script>
    <?php elseif($uri->getSegment(1) == 'CarBooking') : ?>
    <script src="<?=base_url()?>/assets/js/User/UserCarReservation/UserCarReservation.js?v=5"></script> 
    <script src="<?=base_url()?>/assets/js/User/UserCarReservation/UserCarReservationChart.js?v=1.3"></script>   
    <?php endif; ?>


    <script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()

$(function() {
    'use strict';

});
    </script>

    <script>
        $('.select2Teach').select2();
         $('#booking_telephone').inputmask('99-9999-9999');

flatpickr.localize(flatpickr.l10ns.th);

flatpickr(".selector", {
    
    dateFormat: "Y-m-d",
    allowInput: false,
    altFormat: "d/m/Y", 
    // ถ้าต้องการโชว์ พ.ศ. ให้ใช้ formatDate แค่อันเดียวแบบนี้
    formatDate: (date, format, locale) => {
        let day = String(date.getDate()).padStart(2, '0');
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let year = date.getFullYear() + 543;
        return `${day}/${month}/${year}`;
    }
});

$(".selectorEdit").flatpickr({
    //dateFormat: "Y-m-d",
    altFormat: "j F Y",
    altInput: true,
    onReady: function(selectedDates, dateStr, instance) {
        // ปรับปีในวันที่ที่ถูกเลือก
        const selectedDate = instance.selectedDates[0];
        if (selectedDate) {
            selectedDate.setFullYear(selectedDate.getFullYear() + 543);
            instance.setDate(selectedDate);
        }
    }
});

$(".selectorTime").flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});
    </script>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    var lazyLoadImages = document.querySelectorAll('.lazy-load');

    var lazyLoad = function() {
        lazyLoadImages.forEach(function(img) {
            if (img.getBoundingClientRect().top < window.innerHeight && img.dataset.src) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            }
        });
    };

    // Initial load
    lazyLoad();

    // Lazy load on scroll
    document.addEventListener('scroll', lazyLoad);
});
    </script>
<?= $this->renderSection('scripts') ?>