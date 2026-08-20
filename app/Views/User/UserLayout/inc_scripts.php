    <!-- Core JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?=base_url('assets/vendor/libs/popper/popper.js')?>"></script>
    <script src="<?=base_url('assets/vendor/js/bootstrap.js')?>"></script>
    <script src="<?=base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')?>"></script>
    <script src="<?=base_url('assets/vendor/js/menu.js')?>"></script>
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
    <script src="<?=base_url('assets/js/select2.js')?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="<?=base_url('assets/js/main.js')?>"></script>
    <script src="<?=base_url('assets/js/dashboards-analytics.js')?>"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.15/index.global.min.js"></script>
    
    <?php if(isset($_SESSION['username']) && (isset($_SESSION['rloes']) && $_SESSION['rloes'] != '' || in_array(@$_SESSION['status'], ['AdminGeneral', 'ManagerGeneral', 'ExecutiveGeneral', 'admin', 'superadmin']))): ?>
    <!-- Admin Notifications Logic -->
    <script src="<?=base_url('assets/js/Admin/AdminNotification.js')?>?v=1.3"></script>
    <?php endif; ?>

    <!-- Page-specific scripts -->
    <?php if($uri->getSegment(1) == 'Booking') : ?>
    <script src="<?=base_url('assets/js/User/UserBooking/UserBooking.js')?>?v=29"></script>
    <script src="<?=base_url('assets/js/User/UserBooking/UserBookingSignature.js')?>?v=1.3"></script>
    <script src="<?=base_url('assets/js/User/UserBooking/UserBookingCrop.js')?>?v=3"></script>
    
    <?php if($uri->getSegment(2) == ''): ?>
    <script src="<?=base_url('assets/js/User/UserBooking/UserBookingChart.js')?>?v=1.3"></script>
    <?php endif; ?>

    <?php elseif($uri->getSegment(1) == 'Repair') : ?>
    <script src="<?=base_url('assets/js/User/UserRepair/UserRepair.js')?>?v=24"></script>
    <script src="<?=base_url('assets/js/User/UserRepair/UserRepairStatistics.js')?>?v=1.4"></script>
    <?php elseif($uri->getSegment(1) == 'CarBooking') : ?>
    <script src="<?=base_url('assets/js/User/UserCarReservation/UserCarReservation.js')?>?v=5"></script> 
    <script src="<?=base_url('assets/js/User/UserCarReservation/UserCarReservationChart.js')?>?v=1.3"></script>   
    <?php endif; ?>

    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
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

    // Hide Page Loader
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });

    // แจ้งเตือนเมื่อ Login สำเร็จ
    <?php if (session()->getFlashdata('login_success')): ?>
    Swal.fire({
        icon: 'success',
        title: 'เข้าสู่ระบบสำเร็จ!',
        text: <?= json_encode(session()->getFlashdata('login_success')) ?>,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
    <?php endif; ?>

    // แจ้งเตือนเมื่อ Login ผิดพลาด
    <?php if (session()->getFlashdata('login_error')): ?>
    Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: <?= json_encode(session()->getFlashdata('login_error')) ?>,
        confirmButtonText: 'ตกลง',
        confirmButtonColor: '#3085d6'
    });
    <?php endif; ?>
    </script>

    <!-- OneSignal Push Notification SDK -->
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            try {
                if (window.location.hostname !== "general.skj.ac.th") {
                    return;
                }
                await OneSignal.init({
                    appId: "be488231-0e72-4fe0-962d-fcb32cb761e7",
                    safari_web_id: "YOUR-SAFARI-WEB-ID",
                    notifyButton: {
                        enable: true,
                    },
                    allowLocalhostAsSecureOrigin: true,
                });
            } catch (err) {
                console.warn("OneSignal init skipped:", err.message);
            }

            // Tag User (ถ้ามีการ Login)
            const userId = <?= json_encode((string)($_SESSION['id'] ?? '')) ?>;
            const userRoles = <?= json_encode((string)($_SESSION['rloes'] ?? '')) ?>;
            
            if (userId) {
                OneSignal.login(userId);
                OneSignal.User.addTag("user_id", userId);
                
                // ตรวจสอบ Role เพื่อติดแท็กสำหรับ Admin
                <?php if (isset($_SESSION['rloes']) || isset($_SESSION['status'])): ?>
                    const roles = <?= json_encode((string)($_SESSION['rloes'] ?? '')) ?>;
                    const levels = <?= json_encode((string)($_SESSION['rloes_level'] ?? '')) ?>;
                    const status = <?= json_encode((string)($_SESSION['status'] ?? '')) ?>;
                    
                    if (roles.includes("งานอาคารสถานที่") || status === "ExecutiveGeneral") {
                        OneSignal.User.addTag("role", "admin_building");
                        if (levels.includes("1/หัวหน้างาน")) {
                            OneSignal.User.addTag("role", "head_building");
                        }
                    }
                    if (roles.includes("งานแจ้งซ่อม") || status === "ExecutiveGeneral") {
                        OneSignal.User.addTag("role", "admin_repair");
                        if (levels.includes("1/หัวหน้างาน")) {
                            OneSignal.User.addTag("role", "head_repair");
                        }
                    }
                    // Keep admin_booking for room booking system compatibility
                    if (roles.includes("งานอาคารสถานที่") || status === "ExecutiveGeneral") {
                        OneSignal.User.addTag("role", "admin_booking");
                    }
                <?php endif; ?>
            }
        });
    </script>

    <?= $this->renderSection('customScripts') ?>
    <?= $this->renderSection('scripts') ?>


