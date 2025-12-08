<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Alert Message -->
    <div class="alert alert-primary alert-dismissible" role="alert">
        <h5 class="alert-heading mb-1"><i class='bx bx-info-circle me-2'></i>คำแนะนำการจอง</h5>
        <span>ท่านสามารถเลือกห้องที่ต้องการ และคลิกที่วันที่ว่างในปฏิทินด้านล่างเพื่อทำการจองได้เลยครับ</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="row">
        <!-- Left Column: Location Rooms -->
        <div class="col-md-9">
            <?php 
            $categories = [];
            if(isset($LocationList) && !empty($LocationList)) {
                foreach($LocationList as $location) {
                    $cat = $location->location_category ?: 'อื่นๆ'; // Default category if empty
                    if(!isset($categories[$cat])) {
                        $categories[$cat] = [];
                    }
                    $categories[$cat][] = $location;
                }
            }
            ?>

            <?php foreach($categories as $categoryName => $locations): ?>
                <div class="divider text-start mt-4">
                    <div class="divider-text fs-4 fw-bold text-primary">
                        <i class='bx bx-category-alt me-2'></i><?= $categoryName ?>
                    </div>
                </div>
                
                <div class="row g-4 mb-4">
                    <?php foreach($locations as $location): ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="<?= base_url('uploads/admin/LocationRoom/'.$location->location_img) ?>" 
                                     class="card-img-top" 
                                     alt="<?= $location->location_name ?>" 
                                     style="height: 160px; object-fit: cover;"
                                     onerror="this.src='<?= base_url('assets/img/elements/1.jpg') ?>'">
                                
                                <div class="card-body p-3">
                                    <div class="text-center mb-3">
                                        <h5 class="card-title mb-1 text-primary fw-bold">
                                            <i class='bx bx-building me-1'></i> <?= $location->location_name ?>
                                        </h5>
                                    </div>

                                    <hr class="my-3">

                                    <!-- Month/Year Selector -->
                                    <div class="row g-2 mb-3 mini-calendar-header justify-content-center">
                                        <div class="col-7">
                                            <select class="form-select form-select-sm month-selector shadow-none border-1" data-location-id="<?= $location->location_ID ?>">
                                                <option value="1">มกราคม</option>
                                                <option value="2">กุมภาพันธ์</option>
                                                <option value="3">มีนาคม</option>
                                                <option value="4">เมษายน</option>
                                                <option value="5">พฤษภาคม</option>
                                                <option value="6">มิถุนายน</option>
                                                <option value="7">กรกฎาคม</option>
                                                <option value="8">สิงหาคม</option>
                                                <option value="9">กันยายน</option>
                                                <option value="10">ตุลาคม</option>
                                                <option value="11">พฤศจิกายน</option>
                                                <option value="12">ธันวาคม</option>
                                            </select>
                                        </div>
                                        <div class="col-5">
                                            <select class="form-select form-select-sm year-selector shadow-none border-1" data-location-id="<?= $location->location_ID ?>">
                                                <?php 
                                                $currentYear = date('Y');
                                                for($y = $currentYear - 1; $y <= $currentYear + 2; $y++): 
                                                ?>
                                                    <option value="<?= $y ?>" <?= $y == $currentYear ? 'selected' : '' ?>><?= $y + 543 ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Mini Calendar Container -->
                                    <div id="miniCalendar_<?= $location->location_ID ?>" class="mini-calendar rounded p-2 bg-light bg-opacity-50"></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Right Column: Quick Actions -->
        <div class="col-md-3">
            <div class="row g-3 sticky-top" style="top: 20px; z-index: 1;">
                <!-- Book Room -->
                <div class="col-12">
                    <a href="#CalendarBooking" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class='bx bx-building-house bx-sm'></i>
                                        </span>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block mb-1">จองห้อง/สถานที่</small>
                                        <h5 class="mb-0 text-nowrap"><?= $CountLocationRoomAll ?> <small class="text-muted fw-normal">แห่ง</small></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- View Bookings -->
                <div class="col-12">
                    <a href="<?=base_url('Booking/View/All')?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-warning">
                                            <i class='bx bx-list-check bx-sm'></i>
                                        </span>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block mb-1">รายการจอง</small>
                                        <h5 class="mb-0 text-dark text-nowrap"><?= $CountbookingAll ?> <small class="text-muted fw-normal">รายการ</small></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Manual -->
                <div class="col-12">
                    <a target="_blank" 
                       href="https://www.canva.com/design/DAF1VkidVas/KTSxUIGCXwAmE8OLcTfXyg/view" 
                       class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-success">
                                            <i class='bx bx-book-reader bx-sm'></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark">คู่มือใช้งาน</h6>
                                        <small class="text-muted">คลิกเพื่อดู</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Admin Panel -->
                <?php if(isset($_SESSION['username']) && in_array("งานอาคารสถานที่", explode(',',@$_SESSION['rloes'])) || @$_SESSION['status'] =="ExecutiveGeneral"):?>
                <div class="col-12">
                    <a href="<?=base_url('Booking/Approve/Admin')?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-info">
                                            <i class='bx bx-user-check bx-sm'></i>
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-dark">สำหรับเจ้าหน้าที่</h6>
                                        <small class="badge bg-label-info rounded-pill">Admin</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center ps-1">
                                    <small class="text-muted">รออนุมัติ</small>
                                    <span class="badge bg-warning badge-center rounded-circle w-px-20 h-px-20 d-flex align-items-center justify-content-center" style="font-size: 0.7rem;"><?=$NumRowsWaitApprove?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1 ps-1">
                                    <small class="text-muted">อนุมัติแล้ว</small>
                                    <span class="badge bg-success badge-center rounded-circle w-px-20 h-px-20 d-flex align-items-center justify-content-center" style="font-size: 0.7rem;"><?=$NumRowsApprove?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('customCSS') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/User/UserBooking/mini-calendar.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
    const CURRENT_USER_ID = '<?= $_SESSION['id'] ?? '' ?>';
</script>
<script src="<?= base_url('assets/js/User/UserBooking/UserBookingMiniCalendar.js') ?>"></script>
<?= $this->endSection() ?>
