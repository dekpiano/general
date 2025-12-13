<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>
<?= $this->section('content') ?>

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #696cff 0%, #8592ff 100%);
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

.stats-mini-card .icon.primary { background: rgba(105, 108, 255, 0.16); color: #696cff; }
.stats-mini-card .icon.success { background: rgba(113, 221, 55, 0.16); color: #71dd37; }
.stats-mini-card .icon.warning { background: rgba(255, 171, 0, 0.16); color: #ffab00; }
.stats-mini-card .icon.info { background: rgba(3, 195, 236, 0.16); color: #03c3ec; }

/* Location Cards Grid */
.location-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.location-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.location-card .location-img-wrapper {
    position: relative;
    height: 180px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.location-card .location-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.location-card:hover .location-img-wrapper img {
    transform: scale(1.1);
}

.location-card .no-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f0f2f5, #e4e7eb);
    color: #a1acb8;
}

.location-card .no-image-placeholder i {
    font-size: 4rem;
    margin-bottom: 0.5rem;
    opacity: 0.6;
}

.location-card .no-image-placeholder span {
    font-size: 0.875rem;
    opacity: 0.8;
}

.location-card .location-category-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.location-card .location-category-badge.room { background: rgba(105, 108, 255, 0.9); color: #fff; }
.location-card .location-category-badge.building { background: rgba(255, 171, 0, 0.9); color: #fff; }
.location-card .location-category-badge.field { background: rgba(113, 221, 55, 0.9); color: #fff; }

.location-card .card-body {
    padding: 1.25rem;
}

.location-card .location-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #566a7f;
    margin-bottom: 0.25rem;
}

.location-card .location-building {
    color: #8592a3;
    font-size: 0.875rem;
    margin-bottom: 0.75rem;
}

.location-card .location-info {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.location-card .location-info-item {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.8rem;
    color: #697a8d;
}

.location-card .location-info-item i {
    color: #696cff;
}

.location-card .action-buttons {
    display: flex;
    gap: 0.5rem;
}

.location-card .action-buttons .btn {
    flex: 1;
    padding: 0.5rem;
    font-size: 0.8rem;
}

/* Add Location Card */
.add-location-card {
    border: 2px dashed #d9dee3;
    border-radius: 16px;
    min-height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.add-location-card:hover {
    border-color: #696cff;
    background: rgba(105, 108, 255, 0.05);
}

.add-location-card .add-content {
    text-align: center;
}

.add-location-card .add-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: rgba(105, 108, 255, 0.16);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: #696cff;
    transition: all 0.3s ease;
}

.add-location-card:hover .add-icon {
    background: #696cff;
    color: #fff;
    transform: scale(1.1);
}

/* Modal Improvements */
.modal-content {
    border-radius: 16px;
    border: none;
}

.modal-header {
    background: linear-gradient(135deg, #696cff 0%, #8592ff 100%);
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
    border-color: #696cff;
    box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.16);
}

/* Image Preview */
.img-preview-wrapper {
    width: 100%;
    height: 150px;
    border: 2px dashed #d9dee3;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: #fafbfc;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.img-preview-wrapper:hover {
    border-color: #696cff;
}

.img-preview-wrapper img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.img-preview-wrapper .placeholder-text {
    text-align: center;
    color: #8592a3;
}

.img-preview-wrapper .placeholder-text i {
    font-size: 2.5rem;
    color: #d9dee3;
    display: block;
    margin-bottom: 0.5rem;
}

/* Filter Tabs */
.filter-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-tabs .btn {
    border-radius: 20px;
    padding: 0.4rem 1rem;
    font-size: 0.875rem;
}

.filter-tabs .btn.active {
    background: #696cff;
    color: #fff;
    border-color: #696cff;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .location-card .location-img-wrapper {
        height: 150px;
    }
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4><i class='bx bxs-building-house me-2'></i> จัดการห้องประชุมและสถานที่</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url('Admin/Home')?>">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="#">งานอาคารสถานที่</a></li>
                        <li class="breadcrumb-item active">ห้องประชุม / สถานที่</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                    <i class='bx bx-plus me-1'></i> เพิ่มสถานที่ใหม่
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon primary me-3">
                        <i class='bx bxs-building-house'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="totalLocations">0</h4>
                        <small class="text-muted">สถานที่ทั้งหมด</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon info me-3">
                        <i class='bx bxs-door-open'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="totalRooms">0</h4>
                        <small class="text-muted">ห้องประชุม</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon warning me-3">
                        <i class='bx bxs-building'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="totalBuildings">0</h4>
                        <small class="text-muted">อาคาร</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon success me-3">
                        <i class='bx bxs-tree'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="totalFields">0</h4>
                        <small class="text-muted">สนาม</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4" style="border-radius: 12px; border: none;">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class='bx bx-search'></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchLocation" placeholder="ค้นหาห้อง, อาคาร, สถานที่...">
                    </div>
                </div>
                <div class="col-md-7 mt-2 mt-md-0">
                    <div class="filter-tabs d-flex justify-content-md-end">
                        <button class="btn btn-outline-secondary active" data-filter="all">
                            <i class='bx bx-grid-alt me-1'></i> ทั้งหมด
                        </button>
                        <button class="btn btn-outline-secondary" data-filter="ห้อง">
                            <i class='bx bx-door-open me-1'></i> ห้อง
                        </button>
                        <button class="btn btn-outline-secondary" data-filter="อาคาร">
                            <i class='bx bx-building me-1'></i> อาคาร
                        </button>
                        <button class="btn btn-outline-secondary" data-filter="สนาม">
                            <i class='bx bx-tree me-1'></i> สนาม
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Location Cards Grid -->
    <div class="row" id="locationCardsContainer">
        <!-- Loading Skeleton -->
        <div class="col-12 text-center py-5" id="loadingIndicator">
            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mb-0">กำลังโหลดข้อมูลห้องประชุมและสถานที่...</p>
        </div>
        
        <!-- Add Location Card (hidden during loading) -->
        <div class="col-sm-6 col-xl-4 col-xxl-3 mb-4 add-location-col d-none">
            <div class="add-location-card" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                <div class="add-content">
                    <div class="add-icon">
                        <i class='bx bx-plus'></i>
                    </div>
                    <h6 class="mb-1">เพิ่มสถานที่ใหม่</h6>
                    <small class="text-muted">คลิกเพื่อเพิ่มข้อมูล</small>
                </div>
            </div>
        </div>
        <!-- Location cards will be loaded here -->
    </div>

</div>

<!-- Add Location Modal -->
<div class="modal fade" id="addLocationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class='bx bx-building-house me-2'></i>เพิ่มห้องประชุม / สถานที่ใหม่
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FromLocationRoomInsert" novalidate>
                <div class="modal-body">
                    <div class="row">
                        <!-- Image Preview -->
                        <div class="col-md-4">
                            <div class="img-preview-wrapper" id="imgPreviewWrapper">
                                <div class="placeholder-text">
                                    <i class='bx bxs-image'></i>
                                    <span>เลือกรูปภาพสถานที่</span>
                                </div>
                            </div>
                            <div class="form-floating-custom">
                                <input type="file" class="form-control" id="location_img" name="location_img" accept="image/*" required>
                            </div>
                        </div>
                        
                        <!-- Form Fields -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label for="location_category"><i class='bx bx-category me-1'></i> ประเภทสถานที่</label>
                                        <select id="location_category" name="location_category" class="form-select" required>
                                            <option value="">-- เลือกประเภท --</option>
                                            <option value="ห้อง">🚪 ห้อง</option>
                                            <option value="อาคาร">🏢 อาคาร</option>
                                            <option value="สนาม">🌳 สนาม</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label for="location_seats"><i class='bx bx-chair me-1'></i> จำนวนที่นั่ง</label>
                                        <input type="number" class="form-control" id="location_seats" name="location_seats" placeholder="เช่น 50" min="1" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-floating-custom">
                                <label for="location_name"><i class='bx bx-text me-1'></i> ชื่อห้อง / สถานที่</label>
                                <input type="text" class="form-control" id="location_name" name="location_name" placeholder="เช่น ห้องประชุม 72" required>
                            </div>
                            
                            <div class="form-floating-custom">
                                <label for="location_number"><i class='bx bx-map me-1'></i> เลขห้อง / ที่ตั้งอาคาร</label>
                                <input type="text" class="form-control" id="location_number" name="location_number" placeholder="เช่น อาคาร 4 ชั้น 1" required>
                            </div>
                            
                            <div class="form-floating-custom">
                                <label for="location_detail"><i class='bx bx-detail me-1'></i> รายละเอียดเพิ่มเติม</label>
                                <textarea class="form-control" id="location_detail" name="location_detail" rows="3" placeholder="อุปกรณ์ที่มี, ความจุ, สิ่งอำนวยความสะดวก..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSaveLocation">
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

<!-- View Location Modal -->
<div class="modal fade" id="viewLocationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class='bx bx-building-house me-2'></i> รายละเอียดสถานที่
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewLocationContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    let locationData = [];
    
    // Load location data
    function loadLocationData() {
        $.ajax({
            url: '<?=base_url("Admin/LocationRoom/ShowData")?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                locationData = response.aaData || [];
                updateStats();
                renderLocationCards(locationData);
            }
        });
    }
    
    // Update statistics
    function updateStats() {
        $('#totalLocations').text(locationData.length);
        $('#totalRooms').text(locationData.filter(l => (l.location_category || '').includes('ห้อง')).length);
        $('#totalBuildings').text(locationData.filter(l => (l.location_category || '').includes('อาคาร')).length);
        $('#totalFields').text(locationData.filter(l => (l.location_category || '').includes('สนาม')).length);
    }
    
    // Get category badge class
    function getCategoryBadge(category) {
        if ((category || '').includes('ห้อง')) return 'room';
        if ((category || '').includes('อาคาร')) return 'building';
        if ((category || '').includes('สนาม')) return 'field';
        return 'room';
    }
    
    // Render location cards
    function renderLocationCards(data) {
        const container = $('#locationCardsContainer');
        container.find('.location-card-col').remove();
        
        // Hide loading, show add card
        $('#loadingIndicator').addClass('d-none');
        $('.add-location-col').removeClass('d-none');
        
        if (data.length === 0) {
            return;
        }
        
        data.forEach(location => {
            const hasImage = location.location_img && location.location_img !== '';
            const badgeClass = getCategoryBadge(location.location_category);
            
            const imageContent = hasImage 
                ? `<img src="<?=base_url('uploads/admin/LocationRoom/')?>/${location.location_img}" alt="${location.location_name}" onerror="this.parentElement.innerHTML='<div class=\\'no-image-placeholder\\'><i class=\\'bx bxs-building\\'></i><span>ไม่มีรูปภาพ</span></div>'">`
                : `<div class="no-image-placeholder"><i class='bx bxs-building'></i><span>ไม่มีรูปภาพ</span></div>`;
            
            const cardHtml = `
                <div class="col-sm-6 col-xl-4 col-xxl-3 mb-4 location-card-col" data-category="${location.location_category || ''}">
                    <div class="card location-card h-100">
                        <div class="location-img-wrapper">
                            ${imageContent}
                            <span class="location-category-badge ${badgeClass}">${location.location_category || 'ไม่ระบุ'}</span>
                        </div>
                        <div class="card-body">
                            <div class="location-name">${location.location_name}</div>
                            <div class="location-building">
                                <i class='bx bx-map-pin'></i> ${location.location_number || '-'}
                            </div>
                            <div class="location-info">
                                <span class="location-info-item">
                                    <i class='bx bxs-user'></i> ${location.location_seats || 0} ที่นั่ง
                                </span>
                            </div>
                            <div class="action-buttons">
                                <button class="btn btn-outline-primary btn-view" data-id="${location.location_ID}">
                                    <i class='bx bx-show'></i> ดู
                                </button>
                                <button class="btn btn-outline-danger btn-delete" data-id="${location.location_ID}">
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
    $('#searchLocation').on('input', function() {
        const query = $(this).val().toLowerCase();
        const filtered = locationData.filter(location => 
            location.location_name.toLowerCase().includes(query) ||
            (location.location_number || '').toLowerCase().includes(query) ||
            (location.location_detail || '').toLowerCase().includes(query)
        );
        renderLocationCards(filtered);
    });
    
    // Filter tabs
    $('.filter-tabs .btn').on('click', function() {
        $('.filter-tabs .btn').removeClass('active');
        $(this).addClass('active');
        
        const filter = $(this).data('filter');
        const filtered = filter === 'all' 
            ? locationData 
            : locationData.filter(l => (l.location_category || '') === filter);
        renderLocationCards(filtered);
    });
    
    // Image preview
    $('#location_img').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imgPreviewWrapper').html(`<img src="${e.target.result}" alt="Preview">`);
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Form submit
    $('#FromLocationRoomInsert').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const $btn = $('#btnSaveLocation');
        
        // Show button loading
        $btn.prop('disabled', true);
        $btn.find('.btn-text').addClass('d-none');
        $btn.find('.btn-loading').removeClass('d-none');
        
        $.ajax({
            url: '<?=base_url("Admin/LocationRoom/Insert")?>',
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
                    $('#addLocationModal').modal('hide');
                    $('#FromLocationRoomInsert')[0].reset();
                    $('#imgPreviewWrapper').html(`
                        <div class="placeholder-text">
                            <i class='bx bxs-image'></i>
                            <span>เลือกรูปภาพสถานที่</span>
                        </div>
                    `);
                    loadLocationData();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: response.msg
                    });
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
    
    // Delete location
    $(document).on('click', '.btn-delete', function() {
        const locationId = $(this).data('id');
        
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: 'คุณต้องการลบข้อมูลสถานที่นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?=base_url("Admin/LocationRoom/Delete")?>',
                    type: 'POST',
                    data: { DelKey: locationId },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบสำเร็จ!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadLocationData();
                    }
                });
            }
        });
    });
    
    // View location details
    $(document).on('click', '.btn-view', function() {
        const locationId = $(this).data('id');
        const location = locationData.find(l => l.location_ID == locationId);
        
        if (location) {
            const hasImage = location.location_img && location.location_img !== '';
            const imgContent = hasImage 
                ? `<img src="<?=base_url('uploads/admin/LocationRoom/')?>/${location.location_img}" class="img-fluid rounded-3" alt="${location.location_name}" style="max-height: 250px; object-fit: cover;">`
                : `<div style="height: 200px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, #f0f2f5, #e4e7eb); border-radius: 12px; color: #a1acb8;"><i class='bx bxs-building' style="font-size: 4rem; opacity: 0.6;"></i><span>ไม่มีรูปภาพ</span></div>`;
            
            const content = `
                <div class="row">
                    <div class="col-md-5">
                        ${imgContent}
                    </div>
                    <div class="col-md-7">
                        <h3 class="fw-bold text-primary mb-2">${location.location_name}</h3>
                        <p class="text-muted mb-4"><i class='bx bx-map-pin'></i> ${location.location_number || '-'}</p>
                        
                        <div class="mb-3">
                            <span class="badge bg-label-primary mb-2">${location.location_category || 'ไม่ระบุ'}</span>
                        </div>
                        
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted" width="40%"><i class='bx bx-chair me-2'></i>จำนวนที่นั่ง</td>
                                <td class="fw-semibold">${location.location_seats || 0} ที่นั่ง</td>
                            </tr>
                            <tr>
                                <td class="text-muted"><i class='bx bx-detail me-2'></i>รายละเอียด</td>
                                <td class="fw-semibold">${location.location_detail || '-'}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            `;
            
            $('#viewLocationContent').html(content);
            $('#viewLocationModal').modal('show');
        }
    });
    
    // Initial load
    loadLocationData();
});
</script>
<?= $this->endSection() ?>