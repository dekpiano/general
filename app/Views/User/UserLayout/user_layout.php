<?= $this->include('User/UserLayout/inc_header') ?>

<body style="font-family:'Prompt', sans-serif">
    <div id="page-loader"><div class="spinner"></div></div>
    <script>const BASE_URL = '<?= base_url() ?>';</script>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            
            <?= $this->include('User/UserLayout/inc_sidebar') ?>

            <!-- Layout container -->
            <div class="layout-page">
                
                <?= $this->include('User/UserLayout/inc_navbar') ?>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <?= $this->renderSection('content') ?>
                    <!-- / Content -->

                    <?= $this->include('User/UserLayout/inc_footer') ?>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- /layout-container -->

    <?= $this->include('User/UserLayout/inc_scripts') ?>
    <?= $this->renderSection('customJS') ?>
    <?= $this->renderSection('scripts') ?>
</body>
</html>