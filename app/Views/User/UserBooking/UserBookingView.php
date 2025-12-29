<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    /* --- Premium Variables --- */
    :root {
        --booking-primary: #696cff;
        --booking-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --glass-bg: rgba(255, 255, 255, 0.9);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .premium-animate {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Page Header --- */
    .page-header {
        background: var(--booking-gradient);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 15px 40px -10px rgba(105, 108, 255, 0.3);
    }
    .header-content { position: relative; z-index: 2; }
    .page-header::before {
        content: ''; position: absolute; top: -50%; right: -10%; width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* --- Table Styling --- */
    .table-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(105, 108, 255, 0.1);
        padding: 1.5rem;
    }

    .status-badge {
        padding: 8px 12px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .booking-row:hover { background-color: rgba(105, 108, 255, 0.03) !important; }

    .location-cell-icon {
        width: 35px;
        height: 35px;
        background: rgba(105, 108, 255, 0.1);
        color: var(--booking-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .btn-action-mini {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-action-mini:hover { transform: scale(1.1); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Premium Header -->
    <div class="page-header premium-animate">
        <div class="header-content d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="<?=base_url('Booking');?>" class="text-white-50">สถานที่</a></li>
                        <li class="breadcrumb-item active text-white">ประวัติการจอง</li>
                    </ol>
                </nav>
                <h3 class="mb-0 fw-bold text-white">
                    <?php if($CheckAll == 1){ echo 'ข้อมูลการจองทั้งหมด'; }else{ echo 'การจอง: '.@$Booking[0]->location_name; }?>
                </h3>
            </div>
            <i class='bx bx-history fs-1 text-white-50'></i>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="table-card premium-animate" style="animation-delay: 0.1s">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="mb-0 fw-bold text-dark"><i class='bx bx-list-ul me-2 text-primary'></i> รายการจองล่าสุด</h5>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="location.reload()">
                    <i class='bx bx-refresh me-1'></i>รีเฟรช
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover border-top-0" id="TBShowDataBooking" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="border-0">สถานะการจอง</th>
                        <th class="border-0">เรื่องที่จอง / สถานที่</th>
                        <th class="border-0">วัน-เวลาใช้งาน</th>
                        <th class="border-0">ผู้จอง / ติดต่อ</th>
                        <th class="border-0 text-center">เอกสาร</th>
                        <?php if(isset($_SESSION['username']) && !isset($All)) : ?>
                        <th class="border-0 text-center">จัดการ</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php foreach ($Booking as $v_Booking):
                        if($v_Booking->booking_admin_approve == 'รอตรวจสอบ'){ $badgeClass = 'bg-label-warning'; $icon = 'bx-hourglass'; }
                        elseif($v_Booking->booking_admin_approve == 'อนุมัติ'){ $badgeClass = 'bg-label-success'; $icon = 'bx-check-circle'; }
                        else{ $badgeClass = 'bg-label-danger'; $icon = 'bx-x-circle'; }
                    ?>
                    <tr class="booking-row">
                        <td>
                            <span class="status-badge <?=$badgeClass?>">
                                <i class='bx <?=$icon?>'></i><?=$v_Booking->booking_admin_approve?>
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark"><?=$v_Booking->booking_title?></div>
                            <div class="d-flex align-items-center mt-1">
                                <div class="location-cell-icon me-2"><i class='bx bxs-map' style="font-size: 0.8rem;"></i></div>
                                <span class="small text-muted"><?=$v_Booking->location_name?></span>
                            </div>
                        </td>
                        <td>
                            <div class="small fw-bold">
                                <?= $Datethai->thai_date_and_time_short(strtotime($v_Booking->booking_dateStart)) ?>
                            </div>
                            <div class="small text-muted">
                                <i class='bx bx-time me-1'></i> <?=date('H:i', strtotime($v_Booking->booking_timeStart))?> - <?=date('H:i', strtotime($v_Booking->booking_timeEnd))?> น.
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold small"><?=$v_Booking->pers_prefix.$v_Booking->pers_firstname.' '.$v_Booking->pers_lastname?></div>
                            <div class="small text-muted"><i class='bx bx-phone me-1'></i><?=$v_Booking->booking_telephone?></div>
                        </td>
                        <td class="text-center">
                            <a target="_blank" href="<?=base_url('Booking/Approve/File/Requestform/'.$v_Booking->booking_id)?>"
                               class="btn btn-icon btn-outline-primary btn-sm rounded-circle <?=($v_Booking->booking_admin_approve == 'อนุมัติ' ? '' : 'disabled')?>">
                                <i class='bx bx-download'></i>
                            </a>
                        </td>
                        <?php if(isset($_SESSION['username']) && !isset($All)) : 
                            $isCancel = $v_Booking->booking_admin_approve == "ยกเลิกโดยผู้จอง";
                            $isApproved = $v_Booking->booking_admin_approve == "อนุมัติ";
                        ?>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="<?=base_url('Booking/Edit/'.$v_Booking->booking_id)?>" 
                                   class="btn-action-mini btn-label-warning <?=($isCancel || $isApproved) ? 'disabled' : ''?>">
                                    <i class='bx bx-edit'></i>
                                </a>
                                <button type="button" class="btn-action-mini btn-label-danger <?=$isApproved ? 'disabled' : ''?> delete-btn"
                                        key-id="<?=$v_Booking->booking_id;?>">
                                    <i class='bx bx-trash'></i>
                                </button>
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
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
    // DataTable or other custom logic can go here
</script>
<?= $this->endSection() ?>
