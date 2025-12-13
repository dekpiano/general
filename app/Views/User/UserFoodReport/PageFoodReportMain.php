<?php $isLoggedIn = session()->get('logged_in'); ?>
<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #71dd37 0%, #ffab00 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
    color: #fff;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    filter: blur(20px);
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -20%;
    left: 5%;
    width: 150px;
    height: 150px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    filter: blur(15px);
}

.page-header h4 {
    color: #fff;
    margin: 0;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-header .breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0.5rem 0 0;
}

.page-header .breadcrumb-item,
.page-header .breadcrumb-item a {
    color: rgba(255,255,255,0.9);
    font-size: 0.875rem;
    text-decoration: none;
}

.page-header .breadcrumb-item.active {
    color: #fff;
    font-weight: 500;
}

/* Stats Cards */
.stats-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    border: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stats-card .icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin-bottom: 1rem;
}

.stats-card .stats-title {
    color: #8592a3;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.stats-card .stats-value {
    color: #566a7f;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0;
}

/* Specific Card Styles */
.stats-card.primary .icon-wrapper { background: rgba(113, 221, 55, 0.1); color: #71dd37; }
.stats-card.warning .icon-wrapper { background: rgba(255, 171, 0, 0.1); color: #ffab00; }
.stats-card.info .icon-wrapper { background: rgba(3, 195, 236, 0.1); color: #03c3ec; }
.stats-card.danger .icon-wrapper { background: rgba(235, 87, 87, 0.1); color: #eb5757; }

/* Table Card */
.table-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border: none;
    overflow: hidden;
}

.table-card .card-header {
    background: #fff;
    padding: 1.5rem;
    border-bottom: 1px solid #f0f2f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-card .card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #566a7f;
    margin: 0;
    display: flex;
    align-items: center;
}

/* Action Buttons */
.btn-new-report {
    background: linear-gradient(135deg, #71dd37 0%, #ffab00 100%);
    border: none;
    color: #fff;
    padding: 0.6rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(113, 221, 55, 0.4);
    transition: all 0.3s ease;
}

.btn-new-report:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(113, 221, 55, 0.5);
    color: #fff;
}

/* Modal Improvements */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.modal-header {
    background: linear-gradient(135deg, #71dd37 0%, #ffab00 100%);
    color: #fff;
    padding: 1.5rem;
    border-radius: 16px 16px 0 0;
}

.modal-title {
    font-weight: 600;
    display: flex;
    align-items: center;
    color: #fff !important;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.form-floating-custom {
    position: relative;
    margin-bottom: 1rem;
}

/* Image Preview */
#image-preview .wrapper {
    transition: transform 0.2s;
}
#image-preview .wrapper:hover {
    transform: scale(1.05);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
        text-align: center;
    }
    .page-header .row {
        flex-direction: column;
        gap: 1rem;
    }
    .page-header .col-md-7, 
    .page-header .col-md-5 {
        text-align: center !important;
        justify-content: center !important;
    }
    .stats-card {
        margin-bottom: 1rem;
    }
    .table-card .card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    .table-card .card-actions {
        width: 100%;
        display: flex;
        justify-content: flex-end;
    }
    
    /* Adjust Modal padding */
    .modal-body {
        padding: 1rem !important;
    }
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h4><i class='bx bxs-dish me-2'></i>รายงานอาหาร</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url('FoodReport')?>">หน้าหลัก</a></li>
                        <li class="breadcrumb-item active">รายการอาหาร</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2 align-items-center">
                <div class="d-inline-block">
                    <select class="form-select border-0 shadow-sm text-success fw-bold" id="yearFilter" onchange="window.location.href='<?=base_url('FoodReport')?>?year='+this.value" style="width: auto; cursor: pointer; position: relative; z-index: 1005;">
                        <?php foreach($years as $y): ?>
                        <option value="<?=$y?>" <?=$y == $selectedYear ? 'selected' : ''?>>ปี <?=$y+543?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if ($isLoggedIn && in_array('งานรายงานอาหาร', array_map('trim', explode(',', session()->get('rloes'))))): ?>
                <button type="button" class="btn btn-new-report" data-bs-toggle="modal" data-bs-target="#addReportModal">
                    <i class="bx bx-plus me-1"></i> เพิ่มรายงานใหม่
                </button>
                <?php elseif (!$isLoggedIn): ?>
                <a href="<?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>" class="btn btn-outline-light">
                    <i class="bx bx-log-in me-1"></i> เข้าสู่ระบบ
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Total -->
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-card primary">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper me-3">
                        <i class='bx bxs-folder-open'></i>
                    </div>
                    <div>
                        <h6 class="stats-title">รายงานทั้งหมด (ปี <?=$selectedYear+543?>)</h6>
                        <h3 class="stats-value"><?= number_format($TotalReports ?? 0) ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Breakfast -->
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-card warning">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper me-3">
                        <i class='bx bxs-sun'></i>
                    </div>
                    <div>
                        <h6 class="stats-title">มื้อเช้า</h6>
                        <h3 class="stats-value"><?= number_format($BreakfastCount ?? 0) ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lunch -->
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-card info">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper me-3">
                        <i class='bx bxs-sun' style="transform: rotate(45deg);"></i>
                    </div>
                    <div>
                        <h6 class="stats-title">มื้อกลางวัน</h6>
                        <h3 class="stats-value"><?= number_format($LunchCount ?? 0) ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dinner -->
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card danger">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper me-3">
                        <i class='bx bxs-moon'></i>
                    </div>
                    <div>
                        <h6 class="stats-title">มื้อเย็น</h6>
                        <h3 class="stats-value"><?= number_format($DinnerCount ?? 0) ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bx bx-list-ul me-2 text-success"></i> รายการอาหารล่าสุด
            </h5>
            <div class="card-actions">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="$('#food-reports-table').DataTable().ajax.url('<?= base_url('FoodReport/getFoodReportsJson') ?>?year=<?= $selectedYear ?>').load(null, false)">
                    <i class='bx bx-refresh me-1'></i> รีโหลด
                </button>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover nowrap border-top" style="width:100%" id="food-reports-table">
                <thead class="bg-light">
                    <tr>
                        <th width="15%">วันที่</th>
                        <th width="10%">มื้ออาหาร</th>
                        <th width="35%">เมนู</th>
                        <th width="10%">รูปภาพ</th>
                        <?php if ($isLoggedIn && in_array('งานรายงานอาหาร', array_map('trim', explode(',', session()->get('rloes'))))): ?>
                        <th width="15%">ผู้บันทึก</th>
                        <th width="5%">พิมพ์</th>
                        <th width="10%">จัดการ</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<?php if ($isLoggedIn && in_array('งานรายงานอาหาร', explode(',', session()->get('rloes')))): ?>
<!-- Add/Edit Modal -->
<div class="modal fade" id="addReportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReportModalLabel"><i class="bx bx-plus-circle me-2"></i>เพิ่มรายงานอาหารใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addReportForm" action="<?= base_url('FoodReport/insert') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" id="food_id" name="food_id">
                <div class="modal-body p-4 bg-light">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="food_date" class="form-label fw-bold text-muted">วันที่</label>
                            <input type="date" class="form-control" id="food_date" name="food_date" value="<?=date("Y-m-d")?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="food_meal" class="form-label fw-bold text-muted">มื้ออาหาร</label>
                            <select class="form-select" id="food_meal" name="food_meal" required>
                                <option selected disabled value="">เลือกมื้ออาหาร...</option>
                                <option value="มื้อเช้า">มื้อเช้า</option>
                                <option value="มื้อกลางวัน">มื้อกลางวัน</option>
                                <option value="มื้อเย็น">มื้อเย็น</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="food_menu" class="form-label fw-bold text-muted">เมนูอาหาร</label>
                            <textarea class="form-control" id="food_menu" name="food_menu" style="height: 100px" required placeholder="ระบุรายชื่อเมนูอาหาร (คั่นด้วยจุลภาค ,)"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted mb-2"><i class="bx bx-images me-1"></i>รูปภาพ (เลือกได้หลายรูป)</label>
                            <input class="form-control" type="file" id="food_images" name="food_images[]" multiple accept="image/*">
                            <div class="form-text">รองรับไฟล์รูปภาพ .jpg, .png, .jpeg</div>
                        </div>
                        <div class="col-12">
                            <div id="image-preview" class="d-flex flex-wrap gap-3 mt-2 p-3 bg-white rounded-3 border border-dashed text-center justify-content-center" style="min-height: 120px; align-items: center;">
                                <span class="text-muted small">ตัวอย่างรูปภาพจะแสดงที่นี่</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSaveReport">
                        <span class="btn-text"><i class="bx bx-save me-1"></i> บันทึกข้อมูล</span>
                        <span class="btn-loading d-none">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            กำลังบันทึก...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Image Viewer Modal -->
<div class="modal fade" id="imageViewerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white"><i class="bx bx-images me-2"></i>รูปภาพประกอบ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light">
                <div id="image-gallery-in-modal" class="d-flex flex-wrap gap-3 justify-content-center"></div>
            </div>
            <div class="modal-footer bg-white">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<?php if ($isLoggedIn && in_array('งานรายงานอาหาร', explode(',', session()->get('rloes')))): ?>
<script>
document.getElementById('food_images').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = '';
    Array.from(event.target.files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'wrapper shadow-sm';
                wrapper.style.cssText = 'width:100px;height:100px;border:2px solid #eee;border-radius:12px;overflow:hidden;background:#fff;';
                wrapper.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        }
    });
});

document.getElementById('addReportModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('addReportForm').reset();
    document.getElementById('image-preview').innerHTML = '<span class="text-muted small">ตัวอย่างรูปภาพจะแสดงที่นี่</span>';
});

document.getElementById('addReportForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = event.target;
    
    const $btn = $('#btnSaveReport');
    // Show button loading
    $btn.prop('disabled', true);
    $btn.find('.btn-text').addClass('d-none');
    $btn.find('.btn-loading').removeClass('d-none');

    fetch(form.action, { method: 'POST', body: new FormData(form) })
        .then(r => r.json())
        .then(data => {
            // Reset button
            $btn.prop('disabled', false);
            $btn.find('.btn-text').removeClass('d-none');
            $btn.find('.btn-loading').addClass('d-none');

            if (data.status === 'success') {
                bootstrap.Modal.getInstance(document.getElementById('addReportModal')).hide();
                Swal.fire({ 
                    icon: 'success', 
                    title: 'บันทึกสำเร็จ!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#food-reports-table').DataTable().ajax.reload();
            } else {
                Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด!', text: data.message });
            }
        })
        .catch(error => {
            // Reset button
            $btn.prop('disabled', false);
            $btn.find('.btn-text').removeClass('d-none');
            $btn.find('.btn-loading').addClass('d-none');
            
            Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด!', text: error.message });
        });
});

document.getElementById('addReportModal').addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const form = document.getElementById('addReportForm');
    const modalTitle = document.getElementById('addReportModalLabel');
    const foodIdInput = document.getElementById('food_id');
    const preview = document.getElementById('image-preview');
    form.reset();
    preview.innerHTML = '<span class="text-muted small">ตัวอย่างรูปภาพจะแสดงที่นี่</span>';

    if (button && button.classList.contains('item-edit')) {
        const foodId = button.getAttribute('data-id');
        modalTitle.innerHTML = '<i class="bx bx-edit me-2"></i>แก้ไขรายงานอาหาร';
        form.action = '<?= base_url('FoodReport/update') ?>';
        foodIdInput.value = foodId;
        
        // Load data
        fetch(`<?= base_url('FoodReport/getReportById/') ?>${foodId}`)
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success' && data.report) {
                    document.getElementById('food_date').value = data.report.food_date;
                    document.getElementById('food_meal').value = data.report.food_meal;
                    document.getElementById('food_menu').value = data.report.food_menu;
                    
                    let images = [];
                    try { images = JSON.parse(data.report.food_images) || []; } catch (e) {}
                    
                    if(images.length > 0) preview.innerHTML = '';
                    
                    images.forEach(img => {
                        const url = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(`<?=env('upload.server.baseurl')?>${data.report.food_date}/${img}`)}`;
                        const wrapper = document.createElement('div');
                        wrapper.className = 'wrapper shadow-sm';
                        wrapper.style.cssText = 'width:100px;height:100px;border:2px solid #eee;border-radius:12px;overflow:hidden;';
                        wrapper.innerHTML = `<img src="${url}" style="width:100%;height:100%;object-fit:cover;">`;
                        preview.appendChild(wrapper);
                    });
                }
            });
    } else {
        modalTitle.innerHTML = '<i class="bx bx-plus-circle me-2"></i>เพิ่มรายงานอาหารใหม่';
        form.action = '<?= base_url('FoodReport/insert') ?>';
        foodIdInput.value = '';
        document.getElementById('food_date').value = '<?= date("Y-m-d") ?>';
    }
});
</script>
<?php endif; ?>

<script>
$(document).ready(function() {
    const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
    const canManage = <?= ($isLoggedIn && in_array('งานรายงานอาหาร', array_map('trim', explode(',', session()->get('rloes') ?? '')))) ? 'true' : 'false' ?>;
    const loggedInUserId = '<?= session()->get('id') ?? '' ?>';

    function formatThaiDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const months = [
            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];
        const day = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear() + 543;
        return `${day} ${month} ${year}`;
    }

    let columns = [
        { 
            "data": "food_date", 
            "render": function(data, type, row) {
                if (type === 'display' || type === 'filter') {
                    return `<span class="fw-medium text-primary">${formatThaiDate(data)}</span>`;
                }
                return data;
            }
        },
        { 
            "data": "food_meal",
            "render": function(data) {
                let badgeClass = 'bg-label-primary';
                if(data === 'มื้อเช้า') badgeClass = 'bg-label-warning';
                else if(data === 'มื้อกลางวัน') badgeClass = 'bg-label-info';
                else if(data === 'มื้อเย็น') badgeClass = 'bg-label-danger';
                return `<span class="badge ${badgeClass}">${data}</span>`;
            }
        },
        { 
            "data": "food_menu",
            "render": function(data) {
                return data ? `<div style="white-space:normal; min-width:200px;">${data}</div>` : '';
            }
        },
        {
            "data": "food_images",
            "render": function(data, type, row) {
                let images = [];
                try { images = JSON.parse(data) || []; } catch (e) {}
                return images.length > 0 
                    ? `<button class="btn btn-sm btn-outline-primary view-images-btn rounded-pill" data-bs-toggle="modal" data-bs-target="#imageViewerModal" data-images='${data}' data-food-date="${row.food_date}"><i class="bx bx-images me-1"></i> ดูรูป (${images.length})</button>`
                    : '<span class="text-muted small">-</span>';
            },
            "orderable": false
        }
    ];



    if (canManage) {
        columns.push({ "data": "recorder_full_name", "render": d => d ? `<div class="d-flex align-items-center"><div class="avatar avatar-xs me-2"><span class="avatar-initial rounded-circle bg-label-secondary"><i class='bx bx-user'></i></span></div>${d}</div>` : '<span class="text-muted">ไม่ระบุ</span>' });
        columns.push({
            "data": "food_id",
            "render": d => `<a href="<?= base_url('FoodReport/print/') ?>${d}" target="_blank" class="btn btn-sm btn-info" title="พิมพ์"><i class="bx bx-printer me-1"></i>พิมพ์</a>`,
            "orderable": false
        });
        columns.push({
            "data": "food_id",
            "render": function(data, type, row) {
                if (row.food_admin == loggedInUserId) {
                    return `<div class="d-inline-flex gap-1">
                                <button class="btn btn-sm btn-warning item-edit" data-bs-toggle="modal" data-bs-target="#addReportModal" data-id="${data}"><i class="bx bx-edit-alt me-1"></i>แก้ไข</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${data}"><i class="bx bx-trash me-1"></i>ลบ</button>
                            </div>`;
                }
                return `<span class="text-muted small">No Action</span>`;
            },
            "orderable": false
        });
    }

    $('#food-reports-table').DataTable({
        "responsive": true,
        "ajax": { "url": "<?= base_url('FoodReport/getFoodReportsJson') ?>?year=<?= $selectedYear ?>" },
        "columns": columns,
        "order": [[0, "desc"]],
        "language": {
            "search": "",
            "searchPlaceholder": "ค้นหาเมนู, วันที่...",
            "lengthMenu": "_MENU_",
            "info": "แสดง _START_ - _END_ จาก _TOTAL_",
            "paginate": { "first": "«", "last": "»", "next": "›", "previous": "‹" },
            "emptyTable": "ไม่พบข้อมูลรายการอาหาร"
        },
        "dom": '<"card-header d-flex border-bottom-0 pb-0"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        "displayLength": 10,
        "lengthMenu": [10, 25, 50, 75, 100]
    });

    $('#food-reports-table tbody').on('click', '.delete-btn', function() {
        const foodId = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "ข้อมูลรายการอาหารนี้จะถูกลบถาวร!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ลบข้อมูล',
            cancelButtonText: 'ยกเลิก',
            customClass: { confirmButton: 'btn btn-danger me-3', cancelButton: 'btn btn-secondary' },
            buttonsStyling: false
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch('<?= base_url('FoodReport/delete') ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: new URLSearchParams({ 'id': foodId })
                    });
                    const res = await response.json();
                    
                    if (res.status === 'success') {
                        Swal.fire({ 
                            icon: 'success', 
                            title: 'ลบสำเร็จ!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#food-reports-table').DataTable().ajax.reload();
                    } else {
                        Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด!', text: res.message });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด!', text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้' });
                }
            }
        });
    });

    document.getElementById('imageViewerModal')?.addEventListener('show.bs.modal', function(event) {
        const btn = event.relatedTarget;
        const gallery = document.getElementById('image-gallery-in-modal');
        gallery.innerHTML = '';
        let images = [];
        try { images = JSON.parse(btn.getAttribute('data-images')); } catch (e) {}
        const foodDate = btn.getAttribute('data-food-date');
        
        if (images.length === 0) {
            gallery.innerHTML = '<div class="text-center w-100 py-3 text-muted">ไม่พบรูปภาพประกอบ</div>';
            return;
        }

        images.forEach(img => {
            const url = `<?=env('upload.server.baseurl')?>${foodDate}/${img}`;
            const proxy = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(url)}`;
            const wrapper = document.createElement('a');
            wrapper.href = url;
            wrapper.target = "_blank";
            wrapper.className = "d-block position-relative shadow-sm rounded-3 overflow-hidden border";
            wrapper.style.cssText = "width:150px; height:150px; transition: transform 0.2s;";
            wrapper.innerHTML = `<img src="${proxy}" class="w-100 h-100 object-fit-cover" 
                                      onerror="this.src='https://via.placeholder.com/150x150?text=Error'">`;
            wrapper.onmouseover = () => wrapper.style.transform = "scale(1.05)";
            wrapper.onmouseout = () => wrapper.style.transform = "scale(1)";
            gallery.appendChild(wrapper);
        });
    });
});
</script>
<?= $this->endSection() ?>
