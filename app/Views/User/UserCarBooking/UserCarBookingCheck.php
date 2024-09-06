<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">

        <h4 class="py-3 mb-4"><span class="text-muted fw-light">
                    <a href="<?=base_url('CarBooking');?>">หน้าแรก</a>
                    /</span> เลือกรถยนต์
            </h4>
            <div class=" mt-3">
                <div class="">
                    <div class="row">
                        <?php foreach ($CheckCar as $key => $v_CheckCar) : ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <img class="card-img-top" src="<?=base_url('uploads/admin/Car/'.$v_CheckCar->car_img)?>"
                                    alt="Card image cap">
                                <div class="card-body d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title"><?=$v_CheckCar->car_category?></h5>
                                        <p class="card-text">
                                            <?=$v_CheckCar->car_registration?> <?=$v_CheckCar->car_province?>
                                        </p>
                                    </div>
                                    <div class="text-center">
                                        <?php if(isset($_SESSION['username'])): ?>
                                        <a href="<?=base_url('CarBooking/Add/'.$v_CheckCar->car_ID)?>"
                                            class="btn btn-primary">จองรถ</a>
                                        <?php else: ?>
                                        <a href="#"
                                            class="btn btn-primary" onClick="CheckLogin()" ;>จองรถ</a>

                                        <script>
                                        function CheckLogin() {
                                            Swal.fire({
                                                title: "แจ้งเตือน?",
                                                text: "คุณจะจองรถ ต้อง Login เข้าสู่ระบบก่อน!",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "ใช่ ฉันต้องการเข้าสู่ระบบ!"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                   window.location.href = " <?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>";
                                                }
                                            });
                                        }
                                        </script>

                                        <?php endif; ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->