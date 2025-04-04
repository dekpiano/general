<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a
                        href="<?=base_url('CarBooking/CheckCar')?>">เลือกรถ</a> / ข้อมูลการจองทั้งหมด (สำหรับผู้ดูแลระบบ)</span>

            </h4>

            <div class="card">
                <h5 class="card-header">ข้อมูลการจองทั้งหมด (สำหรับผู้ดูแลระบบ)</h5>
                <div class="table-responsive text-nowrap p-3">
                    <table class="table table-hover display nowrap" id="TBShowDataCarBookingAdmin">
                        <thead>
                            <tr>
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
                                <th>อนุมัติ</th>
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

<!-- Modal -->
<div class="modal fade" id="ModalApproveAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">อนุมัติและเลือกคนขับรถ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FormAppoveCarReservation" class="needs-validation" novalidate>
                <div class="modal-body">
                    <input type="hidden" value="" name="carbookingID" id="carbookingID">
                    <select name="Driver" id="Driver" class="form-select" required>
                        <option value="">เลือกคนขับรถ</option>
                        <?php foreach ($CarDriver as $key => $v_CarDriver):?>
                        <option value="<?=$v_CarDriver->pers_id?>">
                            <?=$v_CarDriver->pers_prefix.$v_CarDriver->pers_firstname.' '.$v_CarDriver->pers_lastname;?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        กรุณาเลือกคนขับรถ
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" id="BtnNoAppoveCarBooking" class="btn btn-danger">ไม่อนุมัติ</button>
                    <button type="submit" class="btn btn-primary">อนุมัติการจองรถ</button>
                </div>
            </form>
        </div>
    </div>
</div>