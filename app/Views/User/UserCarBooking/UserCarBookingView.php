<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="<?=base_url('CarBooking/CheckCar')?>">ยานพาหนะ</a>
                    / <?=$title?></span>
            </h4>


            <div class="card">
                <div class="table-responsive text-nowrap p-3">
                    <table class="table table-hover display nowrap" id="TBShowDataCarBooking">
                        <thead>
                            <tr>
                            <th>สถานะ</th>
                                <th>เลขที่จองรถ</th>
                                <th>รูปรถ</th>
                                <th>ทะเบียน</th>
                                <th>คนขับรถ</th>
                                <th>ไปที่</th>
                                <th>วันที่</th>
                                <th>หัวเรื่อง</th>
                                <th>ชื่อผู้จอง</th>
                                
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