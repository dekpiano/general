<!DOCTYPE html>
<html lang="th" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="<?=base_url('assets')?>/" data-template="vertical-menu-template-free">

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
    <link rel="icon" type="image/x-icon" href="<?=base_url('assets/img/favicon/favicon.ico')?>" />

    <!-- PWA Manifest & App Icons -->
    <link rel="manifest" href="<?=base_url('manifest.json')?>">
    <meta name="theme-color" content="#696cff">
    <link rel="apple-touch-icon" href="<?=base_url('assets/img/icons/icon-192x192.png')?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@200;300;400;500;600&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Core CSS -->
    <link rel="stylesheet" href="<?=base_url('assets/vendor/css/core.css')?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/css/theme-default.css')?>"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/demo.css?v=1')?>" />
    <link rel="stylesheet" href="<?=base_url('assets/css/flatpickr.css?v=3')?>" />
    <link rel="stylesheet" href="<?=base_url('assets/css/select2.css?v=2')?>" />
    <link rel="stylesheet" href="<?=base_url('assets/css/user-repair.css?v=2')?>" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?=base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')?>" />
    <link rel="stylesheet" href="<?=base_url('assets/vendor/libs/apex-charts/apex-charts.css')?>" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />

    <!-- Helpers -->
    <script src="<?=base_url('assets/vendor/js/helpers.js')?>"></script>
    <script src="<?=base_url('assets/js/config.js')?>"></script>
    
    <!-- Custom CSS Section -->
    <style>
        /* --- Premium Sidebar --- */
        #layout-menu .menu-inner .menu-item.active > .menu-link {
            background: linear-gradient(72.47deg, #696cff 22.16%, rgba(105, 108, 255, 0.7) 76.47%) !important;
            box-shadow: 0px 4px 12px rgba(105, 108, 255, 0.25);
            color: #fff !important;
            border-radius: 0.5rem;
            margin: 0.125rem 0.5rem;
            width: calc(100% - 1rem);
        }

        #layout-menu .menu-inner .menu-item.active .menu-icon {
            color: #fff !important;
        }

        #layout-menu .menu-inner .menu-item .menu-link {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            margin: 0.125rem 0.5rem;
            width: calc(100% - 1rem);
        }

        #layout-menu .menu-inner .menu-item .menu-link:hover {
            background-color: rgba(105, 108, 255, 0.08) !important;
            color: #696cff !important;
        }

        #layout-menu .menu-inner .menu-item .menu-link:hover .menu-icon {
            color: #696cff !important;
            transform: translateX(3px);
            transition: all 0.3s ease;
        }

        .menu-vertical .menu-header {
            margin-top: 1.5rem;
            padding-left: 1.5rem;
        }

        .menu-vertical .menu-header .menu-header-text {
            font-weight: 700;
            color: #a1acb8;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }

        /* --- Premium Navbar --- */
        #layout-navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(105, 108, 255, 0.1) !important;
            border-radius: 1rem !important;
            margin-top: 1rem !important;
            transition: all 0.3s ease;
        }

        #layout-navbar.navbar-scrolled {
            background: rgba(255, 255, 255, 0.95);
        }

        .navbar-dropdown .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 0.5rem;
        }

        .navbar-dropdown .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
        }

        .navbar-dropdown .dropdown-item:hover {
            background-color: rgba(105, 108, 255, 0.08);
            color: #696cff;
        }

        .navbar-dropdown .dropdown-item i {
            font-size: 1.25rem;
        }

        /* --- Sidebar Scrollbar --- */
        .menu-inner::-webkit-scrollbar {
            width: 4px;
        }
        .menu-inner::-webkit-scrollbar-thumb {
            background: rgba(105, 108, 255, 0.2);
            border-radius: 10px;
        }
        .menu-inner::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
    <?= $this->renderSection('customCSS') ?>
</head>
