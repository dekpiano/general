
<style>
.booking-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    border-radius: 10px;
    color: white; /* Default text color for gradients */
}

.booking-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.booking-card .card-body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.booking-card i {
    font-size: 3.5rem; /* Larger icon size */
    margin-bottom: 1rem;
    color: white; /* Icons should also be white for contrast */
}

.booking-card .card-title,
.booking-card .card-text {
    color: white; /* Ensure text is white */
}

/* Gradient Colors */
.gradient-blue {
    background: linear-gradient(45deg, #4CAF50, #8BC34A); /* Greenish */
}

.gradient-orange {
    background: linear-gradient(45deg, #FF9800, #FFC107); /* Orangish */
}

.gradient-purple {
    background: linear-gradient(45deg, #9C27B0, #E040FB); /* Purplish */
}

.gradient-red {
    background: linear-gradient(45deg, #F44336, #FF5722); /* Reddish */
}

/* Adjust text color for manual card if needed */
.manual-card .card-title,
.manual-card .card-text {
    color: #333; /* Darker text for non-gradient card */
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
                    <a href="<?=base_url('Booking/Select')?>" class="text-decoration-none">
                        <div class="card booking-card gradient-blue h-100 text-center">
                            <div class="card-body">
                                <i class='bx bx-add-to-queue'></i>
                                <h5 class="card-title mb-0"><?=$CountLocationRoomAll;?></h5>
                                <p class="card-text">จองห้องประชุม / สถานที่</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <a href="<?=base_url('Booking/View/All')?>" class="text-decoration-none">
                        <div class="card booking-card gradient-orange h-100 text-center">
                            <div class="card-body">
                                <i class="bx bx-time-five"></i>
                                <h5 class="card-title mb-0"><?=$CountbookingAll;?> รายการ</h5>
                                <p class="card-text">สถานะจองห้องประชุม / สถานที่</p>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="col-sm-6 col-lg-3 mb-4">
                    <a target="_blank" href="https://www.canva.com/design/DAF1VkidVas/KTSxUIGCXwAmE8OLcTfXyg/view?utm_content=DAF1VkidVas&utm_campaign=designshare&utm_medium=link&utm_source=editor" class="text-decoration-none">
                        <div class="card booking-card manual-card h-100 text-center">
                            <div class="card-body">
                                <i class='bx bx-book-bookmark text-success'></i>
                                <h5 class="card-title mb-0">คู่มือการใช้งาน</h5>
                            </div>
                        </div>
                    </a>
                </div>


                <?php if(isset($_SESSION['username']) && in_array("งานอาคารสถานที่", explode(',',@$_SESSION['rloes'])) || @$_SESSION['status'] =="ExecutiveGeneral"):?>
                <div class="col-sm-6 col-lg-3 mb-4 <?=isset($_SESSION['username']) ?"":"offset-md-3" ?>">
                    <?php if(@$_SESSION['status'] =="AdminGeneral"):?>
                    <a href="<?=base_url('Booking/Approve/Admin')?>" class="text-decoration-none">
                        <?php elseif(@$_SESSION['status'] =="ExecutiveGeneral"): ?>
                        <a href="<?=base_url('Booking/Approve/Admin')?>" class="text-decoration-none">
                            <?php endif;?>
                            <div class="card gradient-purple h-100 text-center text-white">
                                <div class="card-body">
                                    สำหรับเจ้าหน้าที่
                                    <p class="card-text mb-0"><i class='bx bx-list-ul me-2'></i>ยอดจองทั้งหมด <?=$CountbookingAll;?> รายการ</p>
                                    <p class="card-text"><i class='bx bx-hourglass me-2'></i>รออนุมัติ <?=$NumRowsWaitApprove;?> รายการ</p>
                                    <p class="card-text"><i class='bx bx-check-circle me-2'></i>อนุมัติแล้ว <?=$NumRowsApprove;?> รายการ</p>
                                </div>
                            </div>
                        </a>
                </div>
                <?php endif; ?>
            </div>
            <style>
            .fc-toolbar {
                display: flex;
                flex-wrap: wrap;
                /* ให้ขึ้นบรรทัดใหม่เมื่อพื้นที่ไม่พอ */
                justify-content: center;
                /* จัดให้อยู่ตรงกลาง */
                gap: 5px;
                /* เพิ่มระยะห่างระหว่างปุ่ม */
            }

            .fc-button {
                padding: 5px 10px;
                font-size: 14px;
            }
            </style>
            <div class="card">
                <div class="card-body">
                    <p><span class="badge bg-warning"><i class='bx bx-hourglass me-1'></i>รอตรวจสอบ</span>
                    <span class="badge bg-success"><i class='bx bx-check-circle me-1'></i>อนุมัติ</span>
                    <span class="badge bg-danger"><i class='bx bx-x-circle me-1'></i>ไม่อนุมัติ</span>                    
                    </p>
                    <div id='CalendarBooking'></div>
                </div>
            </div>


        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->