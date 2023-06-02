<!-- Layout container -->
<div class="layout-page">
    <?php //echo view('User/UserLeyout/UserNavbar'); ?>

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">ระบบงาน SKJ E-Office ยินดีตอนรับ! 🎉</h5>
                                    <p class="mb-4">
                                        โรงเรียนสวนกุหลาบวิทยาลัย (จิรประวัติ) นครสวรรค์
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="<?=base_url();?>assets/img/illustrations/man-with-laptop-light.png"
                                        height="140" alt="View Badge User"
                                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="<?=base_url();?>assets/img/icons/unicons/wallet-info.png" alt="Credit Card"
                                        class="rounded">
                                </div>                             
                            </div>
                            <span>คำสั่ง</span>
                            <h3 class="card-title text-nowrap mb-1"><?=$DictationAll;?></h3>
                          
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>