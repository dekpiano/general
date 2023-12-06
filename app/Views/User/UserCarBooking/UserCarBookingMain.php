<style>
.cards:hover {

    box-shadow: 5px 6px 6px 2px #e9ecef;
    transform: scale(1.1);
}
</style>
<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">

            <div class="row">
                <div class="col-sm-6 col-lg-3 mb-4">
                    <a href="<?=base_url('CarBooking/CheckCar')?>">
                        <div class="card cards h-100 bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between pb-1">
                                    <div class="avatar me-2" style="width: 4.375rem;height: 4.375rem;">
                                        <span class="avatar-initial rounded bg-label-info">
                                            <i class='bx bx-calendar bx-lg'></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h1 class="ms-1 mb-0  text-white"><?=$CountLocationRoomAll;?></h1>
                                        <p class="mb-1 h5 text-white">จองรถ</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <a href="<?=base_url('Booking/Select')?>">
                        <div class="card cards h-100 bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between pb-1">
                                    <div class="avatar me-2" style="width: 4.375rem;height: 4.375rem;">
                                        <span class="avatar-initial rounded bg-label-warning">
                                        <i class='bx bx-list-ul bx-lg'></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h1 class="ms-1 mb-0  text-white"><?=$CountLocationRoomAll;?></h1>
                                        <p class="mb-1 h5 text-white">สถานะจองรถ</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-lg-3 mb-4">
                    <a target="_blank"
                        href="https://www.canva.com/design/DAF1VkidVas/KTSxUIGCXwAmE8OLcTfXyg/view?utm_content=DAF1VkidVas&utm_campaign=designshare&utm_medium=link&utm_source=editor">
                        <div class="h-100 cards border border-success rounded d-flex">
                            <div class="card-body align-self-center">
                                <div class="d-flex align-items-center mb-2 pb-1">
                                    <div class="avatar me-2">
                                        <span class="avatar-initial rounded  bg-label-warning">
                                            <i class='bx bx-book-bookmark'></i>
                                        </span>
                                    </div>
                                    <h4 class="ms-1 mb-0 ">คู่มือการใช้งาน</h4>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>


                <?php if(isset($_SESSION['username']) && @$_SESSION['status'] =="AdminGeneral" || @$_SESSION['status'] =="ExecutiveGeneral"):?>
                <div class="col-sm-6 col-lg-3 mb-4 <?=isset($_SESSION['username']) ?"":"offset-md-3" ?>">
                    <?php if(@$_SESSION['status'] =="AdminGeneral"):?>
                    <a href="<?=base_url('Booking/Approve/Admin')?>">
                        <?php elseif(@$_SESSION['status'] =="ExecutiveGeneral"): ?>
                        <a href="<?=base_url('Booking/Approve/Executive')?>">
                            <?php endif;?>
                            <div class="card h-100 bg-info text-white">
                                <div class="card-body ">
                                    <div class="d-flex align-items-center mb-2 pb-1">
                                        <div class="avatar me-2">
                                            <span class="avatar-initial rounded bg-label-info"><i
                                                    class="bx bx-time-five"></i></span>
                                        </div>
                                        <div>
                                            <h6 class="ms-1 mb-0 text-white">ยอดจองทั้งหมด <?=$CountbookingAll;?> รายการ
                                            </h6>
                                            <h4 class="ms-1 mb-0 text-white">รออนุมัติ <?=$NumRowsWaitApprove;?> รายการ
                                            </h4>
                                        </div>

                                    </div>
                                    <p class="mb-1 h5 text-white">อนุมัติแล้ว <?=$NumRowsApprove;?> รายการ</p>
                                </div>
                            </div>
                        </a>
                </div>
                <?php endif; ?>
            </div>
            <div class="card">
                <div class="card-body">
                    <div id='calendar'></div>
                </div>
            </div>


        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->