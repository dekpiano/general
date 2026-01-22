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
    <?php if($uri->getSegment(1) == 'Booking') : ?>
    <script src="<?=base_url()?>/assets/js/User/UserBooking/UserBooking.js?v=29"></script>
    <script src="<?=base_url()?>/assets/js/User/UserBooking/UserBookingSignature.js?v=1.3"></script>
    <script src="<?=base_url()?>/assets/js/User/UserBooking/UserBookingCrop.js?v=3"></script>
    
    <?php if($uri->getSegment(2) == ''): ?>
    <script src="<?=base_url()?>/assets/js/User/UserBooking/UserBookingChart.js?v=1.3"></script>
    <?php endif; ?>

    <?php elseif($uri->getSegment(1) == 'Repair') : ?>
    <script src="<?=base_url()?>/assets/js/User/UserRepair/UserRepair.js?v=23"></script>
    <script src="<?=base_url()?>/assets/js/User/UserRepair/UserRepairStatistics.js?v=1.4"></script>
    <?php elseif($uri->getSegment(1) == 'CarBooking') : ?>
    <script src="<?=base_url()?>/assets/js/User/UserCarReservation/UserCarReservation.js?v=5"></script> 
    <script src="<?=base_url()?>/assets/js/User/UserCarReservation/UserCarReservationChart.js?v=1.3"></script>   
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
    </script>

    <?= $this->renderSection('customScripts') ?>
    <?= $this->renderSection('scripts') ?>
