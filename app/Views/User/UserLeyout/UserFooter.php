    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


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
        </div>
    </footer>
    <!-- / Footer -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?=base_url()?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?=base_url()?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?=base_url()?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?=base_url()?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?=base_url()?>/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <script src="<?=base_url()?>/assets/js/fullcalendar.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/th.js"></script>
    <!-- moment -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vendors JS -->
    <script src="<?=base_url()?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="<?=base_url()?>/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?=base_url()?>/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    </body>

    </html>

    <script src="<?=base_url()?>/assets/js/User/UserBooking/UserBooking.js?v=7.2"></script>

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
flatpickr.localize(flatpickr.l10ns.th);
$(".selector").flatpickr({
    dateFormat: "Y-m-d",
    altInput: true,
    onChange: (selectedDates, dateStr, instance) => {
        moment.locale('th');
        thai_DM = moment(selectedDates[0]).format('Do MMMM');
        thai_Y = parseInt(moment(selectedDates[0]).format('YYYY')) + 543;
        instance.altInput.value = thai_DM + " " + thai_Y;
    }
});

var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
    },
    navLinks: true, // can click day/week names to navigate views
    editable: false,
    locale: 'th',
    eventSources: [
     {
        timeZone: 'UTC',

         events: function(start, end, timezone, callback) {
            var start = moment('2021-01-10T00:00:00').unix();
            var end = moment('2021-01-15T00:00:00').unix();
             $.ajax({
             url: "<?=base_url('Booking/DB/ShowTimeBooking')?>",
             dataType: 'json',
             data: {
             // our hypothetical feed requires UNIX timestamps
             start: start,
             end: end
             },
             success: function(msg) {
                 var events = msg.events;
                 callback(events);
             }
             });
         }
     },
 ],
 initialView: 'dayGridMonth'
});
calendar.render();
    </script>