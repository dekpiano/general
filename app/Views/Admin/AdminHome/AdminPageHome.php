<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h5 class="pb-1 mb-4">งานอาคารสถานที่</h5>
    <div class="row">
        <div class="col-sm-6 col-xl-3 mb-4">
            <a href="<?=base_url('Admin/LocationRoom/LocationRoomMain')?>" class="text-dark text-decoration-none">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>ห้อง/สถานที่ทั้งหมด</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2"><?=$LocationRoomAll;?></h4>
                                </div>
                                <small>ทั้งหมด</small>
                            </div>
                            <span class="badge bg-label-primary rounded p-2">
                            <i class='bx bxs-file-doc bx-sm'></i>                                    
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <hr class="my-4">

    <h5 class="pb-1 mb-4">งานยานพาหนะ</h5>
    <div class="row">
        <div class="col-sm-6 col-xl-3 mb-4">
            <a href="<?=base_url('Admin/Car/CarMain')?>" class="text-dark text-decoration-none">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>ยานพาหนะทั้งหมด</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2"><?=$CarAll;?></h4>
                                </div>
                                <small>ทั้งหมด</small>
                            </div>
                            <span class="badge bg-label-warning rounded p-2">
                            <i class='bx bxs-car bx-sm'></i>                                    
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3 mb-4">
            <a href="<?=base_url('Admin/Car/CarDriver')?>" class="text-dark text-decoration-none">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span>พนักงานขับรถทั้งหมด</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2"><?=$DriverAll;?></h4>
                                </div>
                                <small>ทั้งหมด</small>
                            </div>
                            <span class="badge bg-label-info rounded p-2">
                            <i class='bx bxs-user-account bx-sm'></i>                                    
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
