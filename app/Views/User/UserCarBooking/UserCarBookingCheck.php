<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="<?=base_url('CarBooking')?>">หน้าแรก</a> /
        </span>
        เลือกยานพาหนะ
    </h4>

    <!-- Cars Grid -->
    <div class="row g-4">
        <?php foreach ($CheckCar as $v_CheckCar) : ?>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100">
                <img class="card-img-top" 
                     src="<?=base_url('uploads/admin/Car/'.$v_CheckCar->car_img)?>"
                     alt="<?=$v_CheckCar->car_category?>"
                     style="height: 180px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">
                        <?=$v_CheckCar->car_category?>
                        <?php if (isset($v_CheckCar->car_status)): ?>
                            <?php if ($v_CheckCar->car_status === 'ซ่อมบำรุง'): ?>
                                <span class="badge bg-warning float-end"><i class='bx bx-wrench'></i> ซ่อมบำรุง</span>
                            <?php elseif ($v_CheckCar->car_status === 'งดใช้งาน'): ?>
                                <span class="badge bg-danger float-end"><i class='bx bx-block'></i> งดใช้งาน</span>
                            <?php else: ?>
                                <span class="badge bg-success float-end"><i class='bx bx-check-circle'></i> ใช้งานได้</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </h5>
                    <p class="card-text">
                        <i class='bx bx-id-card me-1'></i>
                        <?=$v_CheckCar->car_registration?> <?=$v_CheckCar->car_province?>
                    </p>
                </div>
                <div class="card-footer pt-0 border-0 bg-transparent">
                    <?php 
                    $isAvailable = (!isset($v_CheckCar->car_status) || $v_CheckCar->car_status === 'ใช้งานได้');
                    if($isAvailable): 
                    ?>
                        <?php if(isset($_SESSION['username'])): ?>
                        <a href="<?=base_url('CarBooking/Add/'.$v_CheckCar->car_ID)?>" class="btn btn-primary w-100">
                            <i class='bx bx-calendar-plus me-1'></i>จองยานพาหนะ
                        </a>
                        <?php else: ?>
                        <button type="button" class="btn btn-primary w-100 CheckUserLogin"
                                data-url="<?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>">
                            <i class='bx bx-calendar-plus me-1'></i>จองยานพาหนะ
                        </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <button type="button" class="btn btn-secondary w-100" disabled>
                            <i class='bx bx-block me-1'></i>ไม่พร้อมให้บริการ
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.CheckUserLogin').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'กรุณาเข้าสู่ระบบ',
                text: 'คุณต้องเข้าสู่ระบบก่อนจองยานพาหนะ',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'เข้าสู่ระบบ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = this.dataset.url;
                }
            });
        });
    });
});
</script>

<?= $this->endSection() ?>
