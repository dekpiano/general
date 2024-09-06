<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light">
                    <a href="<?=base_url('CarBooking/CheckCar');?>">รถ</a>
                    /</span> จองรถ
            </h4>

            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card mb-3">
                        <img class="card-img-top" src="<?=base_url('uploads/admin/Car/'.$Car->car_img)?>"
                            alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?=$Car->car_category?></h5>
                            <p class="card-text">
                                <?=$Car->car_registration?> <?=$Car->car_province?>
                            </p>
                        </div>
                    </div>


                </div>
                <div class="col-md-6 col-lg-8 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <form id="FormAddCarReservation" class="needs-validation" novalidate>

                                <input type="hidden" class="form-control" id="car_reserv_carID" name="car_reserv_carID"
                                    placeholder="เลือกวันที่จอง" value="<?=$uri->getSegment(3);?>"
                                    aria-describedby="floatingInputHelp" required readonly>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="car_reserv_order"
                                                name="car_reserv_order" placeholder="เลือกวันที่จอง"
                                                value="<?=$car_reserv_order;?>" aria-describedby="floatingInputHelp"
                                                required readonly>
                                            <label for="floatingInput">เลขที่จองรถ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="car_reserv_created_at"
                                                name="car_reserv_created_at" placeholder="เลือกวันที่จอง"
                                                value="<?=date('d-m-Y')?>" aria-describedby="floatingInputHelp" required
                                                readonly>
                                            <label for="floatingInput">วันที่จอง</label>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-floating mb-3">
                                    <input type="hidden" class="form-control" id="car_reserv_memberID" required
                                        name="car_reserv_memberID" placeholder="ใส่ชื่อผู้จอง"
                                        aria-describedby="floatingInputHelp" value="<?=$_SESSION['id']?>" readonly>

                                    <input type="text" class="form-control" id="" required name=""
                                        placeholder="ใส่ชื่อผู้จอง" aria-describedby="floatingInputHelp"
                                        value="<?=$_SESSION['username']?>" readonly>
                                    <label for="floatingInput">ชื่อผู้จอง</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="car_reserv_location" required
                                        name="car_reserv_location" placeholder="ระบุสถานที่ที่ไป"
                                        aria-describedby="floatingInputHelp">
                                    <label for="floatingInput">ขออนุญาตใช้รถยนต์ส่วนกลางไปที่</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="car_reserv_detail" required
                                        name="car_reserv_detail" placeholder="กรอกรายละเอียด"
                                        aria-describedby="floatingInputHelp">
                                    <label for="floatingInput">เพื่อปฏิบัติงานเรื่อง</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="car_reserv_number" required
                                        name="car_reserv_number" placeholder="ระบุจำนวนคน"
                                        aria-describedby="floatingInputHelp">
                                    <label for="floatingInput">จำนวนผู้ไปปฏิบัติงาน</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="car_reserv_StartDate" required
                                                name="car_reserv_StartDate" placeholder="ระบุออกเดินทางวันที่"
                                                aria-describedby="floatingInputHelp">
                                            <label for="floatingInput">ออกเดินทางวันที่</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="time" class="form-control" id="car_reserv_StartTime" required
                                                name="car_reserv_StartTime" placeholder="ระบุเวลาออก"
                                                aria-describedby="floatingInputHelp">
                                            <label for="floatingInput">เวลาออก</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="car_reserv_EndDate" required
                                                name="car_reserv_EndDate" placeholder="ระบุเดินทางกลับวันที่"
                                                aria-describedby="floatingInputHelp">
                                            <label for="floatingInput">เดินทางกลับวันที่</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="time" class="form-control" id="car_reserv_EndTime" required
                                                name="car_reserv_EndTime" placeholder="ระบุเวลากลับ"
                                                aria-describedby="floatingInputHelp">
                                            <label for="floatingInput">เวลากลับ</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="tel" class="form-control" id="car_reserv_phone" required
                                        name="car_reserv_phone" placeholder="ระบุเบอร์โทรศัพท์"
                                        aria-describedby="floatingInputHelp">
                                    <label for="floatingInput">เบอร์โทรศัพท์</label>
                                </div>


                                <button type="submit" id="BtnSubBooking" class="btn btn-primary">จองรถ</button>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->