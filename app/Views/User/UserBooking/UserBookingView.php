<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> ข้อมูลจอง<?=@$Booking[0]->location_name?>
            </h4>

            <div class="card">
                <h5 class="card-header">ข้อมูลการจอง<?=@$Booking[0]->location_name?></h5>
                <div class="table-responsive text-nowrap p-3">
                    <table class="table table-hover" id="TBShowDataBooking">
                        <thead>
                            <tr>
                                <th>หัวข้อ</th>
                                <th>ชื่อห้อง</th>
                                <th>ชื่อผู้จอง</th>
                                <th>สถานะ</th>
                                <th>เหตุผล</th>
                                <?php if(isset($_SESSION['username'])) : ?>
                                <th>คำสั่ง</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php foreach ($Booking as $key => $v_Booking):?>
                            <tr>
                                <td>
                                    <?=$v_Booking->booking_title?>
                                    <div>
                                        <small>
                                            ใช้สำหรับ <?=$v_Booking->booking_typeuse?>
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <?=$v_Booking->location_name?>
                                    <div>
                                        <small>
                                            <?=$v_Booking->booking_dateStart.' '.$v_Booking->booking_timeStart?> ถึง
                                            <?=$v_Booking->booking_dateStart.' '.$v_Booking->booking_timeEnd?>
                                        </small>
                                    </div>
                                </td>
                                <td><?=$v_Booking->booking_Booker?></td>
                                <td><span class="badge bg-label-primary me-1"><?=$v_Booking->booking_status?></span>
                                </td>
                                <td><?=$v_Booking->booking_reason?></td>
                                <?php if(isset($_SESSION['username'])) : ?>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <button type="button" class="btn btn-warning">แก้ไข</button>
                                        <button type="button" id="BtnCancelBooking" class="btn btn-danger" key-id="<?=$v_Booking->booking_id;?>">ยกเลิก</button>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>

                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->