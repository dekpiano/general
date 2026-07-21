<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>
<?= $this->section('content') ?>

<?php if(isset($_GET['modal']) && $_GET['modal'] == 1): ?>
<style>
    #layout-menu, .layout-navbar, .layout-footer { display: none !important; }
    .layout-page { padding-left: 0 !important; }
    .content-wrapper { padding: 0 !important; }
    .container-xxl { padding: 10px !important; max-width: 100% !important; }
    html, body { overflow-x: hidden; }
</style>
<?php endif; ?>

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.page-header h4 {
    color: #fff;
    margin: 0;
    font-weight: 600;
}

.page-header .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0.5rem 0 0;
}

.page-header .breadcrumb-item,
.page-header .breadcrumb-item a {
    color: rgba(255,255,255,0.85);
    font-size: 0.875rem;
}

.page-header .breadcrumb-item.active {
    color: #fff;
}

.page-header .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.5);
}

/* Stats Cards */
.stats-mini-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.25rem;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}

.stats-mini-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stats-mini-card .icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stats-mini-card .icon.info { background: rgba(3, 195, 236, 0.16); color: #03c3ec; }
.stats-mini-card .icon.success { background: rgba(113, 221, 55, 0.16); color: #71dd37; }
.stats-mini-card .icon.warning { background: rgba(255, 171, 0, 0.16); color: #ffab00; }

/* Driver Cards Grid */
.driver-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    text-align: center;
}

.driver-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.driver-card .card-body {
    padding: 1.5rem;
}

.driver-card .driver-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    margin: 0 auto 1rem;
    display: block;
}

.driver-card .no-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #03c3ec 0%, #00a5ce 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    border: 4px solid #fff;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.driver-card .no-avatar i {
    font-size: 3rem;
    color: #fff;
}

.driver-card .driver-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #566a7f;
    margin-bottom: 0.25rem;
}

.driver-card .driver-phone {
    color: #8592a3;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.driver-card .driver-phone i {
    color: #03c3ec;
    margin-right: 0.25rem;
}

.driver-card .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: rgba(113, 221, 55, 0.16);
    color: #71dd37;
    margin-bottom: 1rem;
}

.driver-card .action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.driver-card .action-buttons .btn {
    padding: 0.5rem 1rem;
    font-size: 0.8rem;
    border-radius: 8px;
}

/* Add Driver Card */
.add-driver-card {
    border: 2px dashed #d9dee3;
    border-radius: 16px;
    min-height: 280px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.add-driver-card:hover {
    border-color: #03c3ec;
    background: rgba(3, 195, 236, 0.05);
}

.add-driver-card .add-content {
    text-align: center;
}

.add-driver-card .add-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: rgba(3, 195, 236, 0.16);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: #03c3ec;
    transition: all 0.3s ease;
}

.add-driver-card:hover .add-icon {
    background: #03c3ec;
    color: #fff;
    transform: scale(1.1);
}

/* Modal Improvements */
.modal-content {
    border-radius: 16px;
    border: none;
}

.modal-header {
    background: linear-gradient(135deg, #03c3ec 0%, #00a5ce 100%);
    color: #fff;
    border-radius: 16px 16px 0 0;
    padding: 1.25rem 1.5rem;
}

.modal-header .modal-title {
    font-weight: 600;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.form-floating-custom {
    position: relative;
    margin-bottom: 1rem;
}

.form-floating-custom label {
    font-weight: 500;
    color: #566a7f;
    margin-bottom: 0.5rem;
    display: block;
}

.form-floating-custom .form-control,
.form-floating-custom .form-select {
    border-radius: 8px;
    border: 1px solid #d9dee3;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-floating-custom .form-control:focus,
.form-floating-custom .form-select:focus {
    border-color: #03c3ec;
    box-shadow: 0 0 0 3px rgba(3, 195, 236, 0.16);
}

/* Search Box */
.search-box {
    position: relative;
}

.search-box .form-control {
    padding-left: 2.5rem;
    border-radius: 10px;
}

.search-box .search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #8592a3;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .driver-card .driver-avatar,
    .driver-card .no-avatar {
        width: 80px;
        height: 80px;
    }
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4><i class='bx bxs-user-badge me-2'></i> จัดการข้อมูลพนักงานขับรถ</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url('Admin/Home')?>">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="#">งานยานพาหนะ</a></li>
                        <li class="breadcrumb-item active">พนักงานขับรถ</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#addDriverModal">
                    <i class='bx bx-plus me-1'></i> เพิ่มคนขับใหม่
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-sm-6 col-xl-4 mb-3 mb-xl-0">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon info me-3">
                        <i class='bx bxs-user-badge'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="totalDrivers">0</h4>
                        <small class="text-muted">พนักงานขับรถทั้งหมด</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4 mb-3 mb-xl-0">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon success me-3">
                        <i class='bx bxs-check-circle'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="activeDrivers">0</h4>
                        <small class="text-muted">พร้อมปฏิบัติงาน</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon warning me-3">
                        <i class='bx bxs-car'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">
                            <a href="<?=base_url('Admin/Car/CarMain')?>" class="text-warning text-decoration-none">
                                ดูข้อมูลรถ <i class='bx bx-chevron-right'></i>
                            </a>
                        </h4>
                        <small class="text-muted">จัดการยานพาหนะ</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="card mb-4" style="border-radius: 12px; border: none;">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class='bx bx-search search-icon'></i>
                        <input type="text" class="form-control" id="searchDriver" placeholder="ค้นหาชื่อพนักงานขับรถ...">
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-2 mt-md-0">
                    <span class="text-muted">
                        <i class='bx bx-info-circle me-1'></i> คลิกที่การ์ดเพื่อดูรายละเอียด
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Driver Cards Grid -->
    <div class="row" id="driverCardsContainer">
        <!-- Loading Skeleton -->
        <div class="col-12 text-center py-5" id="loadingIndicator">
            <div class="spinner-border text-info mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mb-0">กำลังโหลดข้อมูลพนักงานขับรถ...</p>
        </div>
        
        <!-- Add Driver Card (hidden during loading) -->
        <div class="col-sm-6 col-xl-4 col-xxl-3 mb-4 add-driver-col d-none">
            <div class="add-driver-card" data-bs-toggle="modal" data-bs-target="#addDriverModal">
                <div class="add-content">
                    <div class="add-icon">
                        <i class='bx bx-user-plus'></i>
                    </div>
                    <h6 class="mb-1">เพิ่มพนักงานขับรถ</h6>
                    <small class="text-muted">คลิกเพื่อเพิ่มบุคลากร</small>
                </div>
            </div>
        </div>
        <!-- Driver cards will be loaded here -->
    </div>

</div>

<!-- Add Driver Modal -->
<div class="modal fade" id="addDriverModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class='bx bx-user-plus me-2'></i>เพิ่มพนักงานขับรถ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FromCarDriverInsert" novalidate>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-preview mb-3" id="selectedDriverPreview" style="display: none;">
                            <img src="" class="rounded-circle" width="80" height="80" style="object-fit: cover; border: 3px solid #03c3ec;">
                        </div>
                        <div class="avatar-placeholder" id="avatarPlaceholder">
                            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #e9ecef, #f8f9fa); display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class='bx bxs-user' style="font-size: 2.5rem; color: #8592a3;"></i>
                            </div>
                            <small class="text-muted d-block mt-2">เลือกบุคลากรจากรายการด้านล่าง</small>
                        </div>
                    </div>
                    
                    <div class="form-floating-custom">
                        <label for="cardriver_userID"><i class='bx bx-user me-1'></i> เลือกบุคลากร</label>
                        <select id="cardriver_userID" name="cardriver_userID" class="form-select" required>
                            <option value="">-- กรุณาเลือกบุคลากร --</option>
                            <?php foreach ($CheckDriver as $value) : ?>
                                <option value="<?=$value->pers_id?>" 
                                        data-img="<?=$value->pers_img ?? ''?>"
                                        data-phone="<?=$value->pers_phone?>">
                                    <?=$value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="alert alert-info d-flex align-items-center mt-3" role="alert">
                        <i class='bx bx-info-circle me-2' style="font-size: 1.25rem;"></i>
                        <div>
                            บุคลากรที่เลือกจะถูกเพิ่มเป็นพนักงานขับรถในระบบ
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-info" id="btnSaveDriver">
                        <span class="btn-text"><i class='bx bx-save me-1'></i> บันทึกข้อมูล</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            กำลังบันทึก...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    let driverData = [];
    const personnelImgPath = 'https://personnel.skj.ac.th/uploads/admin/Personnal/';
    
    // Load driver data
    function loadDriverData() {
        $.ajax({
            url: '<?=base_url("Admin/CarDriver/ShowData")?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                driverData = response.aaData || [];
                updateStats();
                renderDriverCards(driverData);
            }
        });
    }
    
    // Update statistics
    function updateStats() {
        $('#totalDrivers').text(driverData.length);
        $('#activeDrivers').text(driverData.length); // All are active
    }
    
    // Render driver cards
    function renderDriverCards(data) {
        const container = $('#driverCardsContainer');
        container.find('.driver-card-col').remove();
        
        // Hide loading, show add card
        $('#loadingIndicator').addClass('d-none');
        $('.add-driver-col').removeClass('d-none');
        
        if (data.length === 0) {
            return;
        }
        
        data.forEach(driver => {
            const hasImg = driver.cardriver_img && driver.cardriver_img !== '';
            const avatarContent = hasImg 
                ? `<img src="${personnelImgPath}${driver.cardriver_img}" class="driver-avatar" alt="${driver.cardriver_Fullname}" onerror="this.outerHTML='<div class=\\'no-avatar\\'><i class=\\'bx bxs-user\\'></i></div>'">`
                : `<div class="no-avatar"><i class='bx bxs-user'></i></div>`;
            
            const cardHtml = `
                <div class="col-sm-6 col-xl-4 col-xxl-3 mb-4 driver-card-col">
                    <div class="card driver-card h-100">
                        <div class="card-body">
                            ${avatarContent}
                            <div class="driver-name">${driver.cardriver_Fullname}</div>
                            <div class="driver-phone">
                                <i class='bx bx-phone'></i> ${driver.cardriver_phone || 'ไม่ระบุ'}
                            </div>
                            <div class="status-badge">
                                <i class='bx bxs-circle' style="font-size: 0.5rem;"></i> พร้อมปฏิบัติงาน
                            </div>
                            <div class="action-buttons">
                                <a href="tel:${driver.cardriver_phone}" class="btn btn-outline-info btn-sm">
                                    <i class='bx bx-phone-call'></i> โทร
                                </a>
                                <button class="btn btn-outline-danger btn-sm btn-delete" data-id="${driver.cardriver_id}">
                                    <i class='bx bx-trash'></i> ลบ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.append(cardHtml);
        });
    }
    
    // Search functionality
    $('#searchDriver').on('input', function() {
        const query = $(this).val().toLowerCase();
        const filtered = driverData.filter(driver => 
            driver.cardriver_Fullname.toLowerCase().includes(query)
        );
        renderDriverCards(filtered);
    });
    
    // Select change - show preview
    $('#cardriver_userID').on('change', function() {
        const selected = $(this).find(':selected');
        const img = selected.data('img');
        
        if ($(this).val()) {
            if (img) {
                $('#selectedDriverPreview').show();
                $('#selectedDriverPreview img').attr('src', personnelImgPath + img);
                $('#avatarPlaceholder').hide();
            } else {
                $('#selectedDriverPreview').hide();
                $('#avatarPlaceholder').show();
            }
        } else {
            $('#selectedDriverPreview').hide();
            $('#avatarPlaceholder').show();
        }
    });
    
    // Form submit
    $('#FromCarDriverInsert').on('submit', function(e) {
        e.preventDefault();
        
        if (!$('#cardriver_userID').val()) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกบุคลากร',
                text: 'กรุณาเลือกบุคลากรที่ต้องการเพิ่มเป็นพนักงานขับรถ'
            });
            return;
        }
        
        const formData = new FormData(this);
        const $btn = $('#btnSaveDriver');
        
        // Show button loading
        $btn.prop('disabled', true);
        $btn.find('.btn-text').addClass('d-none');
        $btn.find('.btn-loading').removeClass('d-none');
        
        $.ajax({
            url: '<?=base_url("Admin/CarDriver/Insert")?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Reset button
                $btn.prop('disabled', false);
                $btn.find('.btn-text').removeClass('d-none');
                $btn.find('.btn-loading').addClass('d-none');
                
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: response.msg,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#addDriverModal').modal('hide');
                    $('#FromCarDriverInsert')[0].reset();
                    $('#selectedDriverPreview').hide();
                    $('#avatarPlaceholder').show();
                    loadDriverData();
                }
            },
            error: function() {
                // Reset button
                $btn.prop('disabled', false);
                $btn.find('.btn-text').removeClass('d-none');
                $btn.find('.btn-loading').addClass('d-none');
                
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถบันทึกข้อมูลได้'
                });
            }
        });
    });
    
    // Delete driver
    $(document).on('click', '.btn-delete', function() {
        const driverId = $(this).data('id');
        
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: 'คุณต้องการลบพนักงานขับรถคนนี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?=base_url("Admin/CarDriver/Delete")?>',
                    type: 'POST',
                    data: { DelKey: driverId },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบสำเร็จ!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadDriverData();
                    }
                });
            }
        });
    });
    
    // Initial load
    loadDriverData();
});
</script>
<?= $this->endSection() ?>