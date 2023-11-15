<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a
                        href="<?=base_url('Booking/Select')?>">สถานที่</a> /</span>
            
            </h4>

            <div class="card">
                <h5 class="card-header">ข้อมูลการจองทั้งหมด</h5>
                <div class="table-responsive text-nowrap p-3">
                    <table class="table table-hover display nowrap"  id="TBShowDataBookingAdmin">
                        <thead>
                            <tr>
                            <th>เลขที่จอง</th>
                                <th>หัวข้อ</th>
                                <th>ชื่อห้อง</th>
                                <th>ชื่อผู้จอง</th>
                                <th>สถานะ</th>
                                <th>เหตุผล</th>                              
                                <th>คำสั่ง</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->