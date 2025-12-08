<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb -->
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="<?=base_url('Booking')?>" class="text-primary">สถานที่</a> /
        </span>
        <?php if($CheckAll == 1){
            echo $Title = 'ข้อมูลการจองทั้งหมด';
        }else{
            echo $Title = 'ข้อมูลการจอง '.@$Booking[0]->location_name;
        }?>
    </h4>

    <!-- Data Table Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class='bx bx-list-ul me-2'></i><?=$Title?></h5>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="TBShowDataBooking" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>สถานะ</th>
                        <th>เลขที่จอง</th>
                        <th>รายละเอียด</th>
                        <th>ห้อง/วันเวลา</th>
                        <th>ผู้จอง</th>
                        <th>เหตุผล</th>
                        <th>เอกสาร</th>
                        <?php if(isset($_SESSION['username']) && !isset($All)) : ?>
                        <th>จัดการ</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Booking as $v_Booking):
                        // Status styling
                        if($v_Booking->booking_admin_approve == 'รอตรวจสอบ'){
                            $badgeClass = 'bg-label-warning';
                            $icon = 'bx-hourglass';
                        }elseif($v_Booking->booking_admin_approve == 'อนุมัติ'){
                            $badgeClass = 'bg-label-success';
                            $icon = 'bx-check-circle';
                        }else{
                            $badgeClass = 'bg-label-danger';
                            $icon = 'bx-x-circle';
                        }
                    ?>
                    <tr>
                        <td>
                            <span class="badge <?=$badgeClass?>">
                                <i class='bx <?=$icon?> me-1'></i><?=$v_Booking->booking_admin_approve?>
                            </span>
                        </td>
                        <td>
                            <strong><?=$v_Booking->booking_order?></strong>
                        </td>
                        <td>
                            <div class="fw-semibold"><?=$v_Booking->booking_title?></div>
                            <small class="text-muted">
                                <i class='bx bx-target-lock'></i> <?=$v_Booking->booking_typeuse?>
                            </small>
                        </td>
                        <td>
                            <div class="fw-semibold"><?=$v_Booking->location_name?></div>
                            <small class="text-muted d-block">
                                <i class='bx bx-calendar'></i>
                                <?=$Datethai->thai_date_and_time_short(strtotime($v_Booking->booking_dateStart))?> -
                                <?=$Datethai->thai_date_and_time_short(strtotime($v_Booking->booking_dateEnd))?>
                            </small>
                            <small class="text-muted">
                                <i class='bx bx-time'></i>
                                <?=date('H:i', strtotime($v_Booking->booking_timeStart))?> - <?=date('H:i', strtotime($v_Booking->booking_timeEnd))?>
                            </small>
                        </td>
                        <td>
                            <div class="fw-semibold"><?=$v_Booking->pers_prefix.$v_Booking->pers_firstname.' '.$v_Booking->pers_lastname?></div>
                            <small class="text-muted">
                                <i class='bx bx-phone'></i> <?=$v_Booking->booking_telephone?>
                            </small>
                        </td>
                        <td>
                            <?=$v_Booking->booking_admin_reason ?: '-'?>
                        </td>
                        <td>
                            <a target="_blank"
                               href="<?=base_url('Booking/Approve/File/Requestform/'.$v_Booking->booking_id)?>"
                               class="btn btn-sm btn-primary <?=($v_Booking->booking_admin_approve == 'อนุมัติ' ? '' : 'disabled')?>">
                                <i class='bx bx-download me-1'></i>ดาวน์โหลด
                            </a>
                        </td>
                        <?php if(isset($_SESSION['username']) && !isset($All)) : 
                            $isCancel = $v_Booking->booking_admin_approve == "ยกเลิกโดยผู้จอง";
                            $isApproved = $v_Booking->booking_admin_approve == "อนุมัติ";
                        ?>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?=base_url('Booking/Edit/'.$v_Booking->booking_id)?>" 
                                   class="btn btn-sm btn-label-warning <?=($isCancel || $isApproved) ? 'disabled' : ''?>">
                                    <i class='bx bx-edit'></i>
                                </a>
                                <button type="button" 
                                        id="BtnCancelBooking"
                                        class="btn btn-sm btn-label-danger <?=$isApproved ? 'disabled' : ''?>"
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
