<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>
<?= $this->section('content') ?>

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #ffab00 0%, #ff8f00 100%);
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

.stats-mini-card .icon.warning { background: rgba(255, 171, 0, 0.16); color: #ffab00; }
.stats-mini-card .icon.success { background: rgba(113, 221, 55, 0.16); color: #71dd37; }
.stats-mini-card .icon.info { background: rgba(3, 195, 236, 0.16); color: #03c3ec; }
.stats-mini-card .icon.primary { background: rgba(105, 108, 255, 0.16); color: #696cff; }

/* Car Cards Grid */
.car-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.car-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.car-card .car-img-wrapper {
    position: relative;
    height: 180px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.car-card .no-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f0f2f5, #e4e7eb);
    color: #a1acb8;
}

.car-card .no-image-placeholder i {
    font-size: 4rem;
    margin-bottom: 0.5rem;
    opacity: 0.6;
}

.car-card .no-image-placeholder span {
    font-size: 0.875rem;
    opacity: 0.8;
}

.car-card .car-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.car-card:hover .car-img-wrapper img {
    transform: scale(1.1);
}

.car-card .car-category-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.car-card .car-category-badge.pickup { background: rgba(105, 108, 255, 0.9); color: #fff; }
.car-card .car-category-badge.van { background: rgba(255, 171, 0, 0.9); color: #fff; }
.car-card .car-category-badge.truck { background: rgba(113, 221, 55, 0.9); color: #fff; }
.car-card .car-category-badge.minibus { background: rgba(3, 195, 236, 0.9); color: #fff; }

.car-card .card-body {
    padding: 1.25rem;
}

.car-card .car-registration {
    font-size: 1.25rem;
    font-weight: 700;
    color: #566a7f;
    margin-bottom: 0.25rem;
}

.car-card .car-brand {
    color: #8592a3;
    font-size: 0.875rem;
    margin-bottom: 0.75rem;
}

.car-card .car-info {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.car-card .car-info-item {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.8rem;
    color: #697a8d;
}

.car-card .car-info-item i {
    color: #ffab00;
}

.car-card .action-buttons {
    display: flex;
    gap: 0.5rem;
}

.car-card .action-buttons .btn {
    flex: 1;
    padding: 0.5rem;
    font-size: 0.8rem;
}

/* Add Car Button */
.add-car-card {
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

.add-car-card:hover {
    border-color: #ffab00;
    background: rgba(255, 171, 0, 0.05);
}

.add-car-card .add-content {
    text-align: center;
}

.add-car-card .add-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: rgba(255, 171, 0, 0.16);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2rem;
    color: #ffab00;
    transition: all 0.3s ease;
}

.add-car-card:hover .add-icon {
    background: #ffab00;
    color: #fff;
    transform: scale(1.1);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem;
}

.empty-state .icon {
    font-size: 4rem;
    color: #d9dee3;
    margin-bottom: 1rem;
}

/* Modal Improvements */
.modal-content {
    border-radius: 16px;
    border: none;
}

.modal-header {
    background: linear-gradient(135deg, #ffab00 0%, #ff8f00 100%);
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
    border-color: #ffab00;
    box-shadow: 0 0 0 3px rgba(255, 171, 0, 0.16);
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
    border-color: #ffab00;
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

/* View Toggle */
.view-toggle .btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
}

.view-toggle .btn.active {
    background: #ffab00;
    color: #fff;
    border-color: #ffab00;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .car-card .car-img-wrapper {
        height: 150px;
    }
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4><i class='bx bxs-car me-2'></i> จัดการข้อมูลรถยนต์</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url('Admin/Home')?>">หน้าแรก</a></li>
                        <li class="breadcrumb-item"><a href="#">งานยานพาหนะ</a></li>
                        <li class="breadcrumb-item active">รถยนต์</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#addCarModal">
                    <i class='bx bx-plus me-1'></i> เพิ่มรถใหม่
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon warning me-3">
                        <i class='bx bxs-car'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="totalCars">0</h4>
                        <small class="text-muted">รถทั้งหมด</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon primary me-3">
                        <i class='bx bxs-truck'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="totalPickup">0</h4>
                        <small class="text-muted">รถกระบะ</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon success me-3">
                        <i class='bx bxs-bus'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="totalVan">0</h4>
                        <small class="text-muted">รถตู้</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stats-mini-card">
                <div class="d-flex align-items-center">
                    <div class="icon info me-3">
                        <i class='bx bxs-bus-school'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold" id="totalOther">0</h4>
                        <small class="text-muted">อื่นๆ</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4" style="border-radius: 12px; border: none;">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class='bx bx-search'></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchCar" placeholder="ค้นหาทะเบียน, ยี่ห้อ, รุ่น...">
                    </div>
                </div>
                <div class="col-md-3 mt-2 mt-md-0">
                    <select class="form-select" id="filterCategory">
                        <option value="">ประเภททั้งหมด</option>
                        <option value="รถกระบะ 4 ประตู">รถกระบะ 4 ประตู</option>
                        <option value="รถตู้">รถตู้</option>
                        <option value="รถบรรทุกเล็ก 6 ล้อ">รถบรรทุกเล็ก 6 ล้อ</option>
                        <option value="รถมินิบัส">รถมินิบัส</option>
                    </select>
                </div>
                <div class="col-md-3 mt-2 mt-md-0 text-md-end">
                    <div class="btn-group view-toggle" role="group">
                        <button type="button" class="btn btn-outline-secondary active" id="gridView">
                            <i class='bx bx-grid-alt'></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="listView">
                            <i class='bx bx-list-ul'></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Car Cards Grid -->
    <div class="row" id="carCardsContainer">
        <!-- Loading Skeleton -->
        <div class="col-12 text-center py-5" id="loadingIndicator">
            <div class="spinner-border text-warning mb-3" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mb-0">กำลังโหลดข้อมูลรถยนต์...</p>
        </div>
        
        <!-- Add Car Card (hidden during loading) -->
        <div class="col-sm-6 col-xl-4 col-xxl-3 mb-4 add-car-col d-none">
            <div class="add-car-card" data-bs-toggle="modal" data-bs-target="#addCarModal">
                <div class="add-content">
                    <div class="add-icon">
                        <i class='bx bx-plus'></i>
                    </div>
                    <h6 class="mb-1">เพิ่มรถใหม่</h6>
                    <small class="text-muted">คลิกเพื่อเพิ่มข้อมูลรถยนต์</small>
                </div>
            </div>
        </div>
        <!-- Car cards will be loaded here -->
    </div>

    <!-- Table View (Hidden by default) -->
    <div class="card d-none" id="tableViewContainer" style="border-radius: 12px; border: none;">
        <div class="card-datatable table-responsive p-3">
            <table class="TbDataCar datatables-basic table border-top">
                <thead>
                    <tr>
                        <th>รูป</th>
                        <th>รายละเอียดรถ</th>
                        <th>ประเภทรถ</th>
                        <th>จำนวนที่นั่ง</th>
                        <th>คำสั่ง</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<!-- Add/Edit Car Modal -->
<div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCarModalLabel">
                    <i class='bx bx-plus-circle me-2'></i>เพิ่มข้อมูลรถยนต์ใหม่
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="FromCarInsert" novalidate>
                <div class="modal-body">
                    <div class="row">
                        <!-- Image Preview -->
                        <div class="col-md-4">
                            <div class="img-preview-wrapper" id="imgPreviewWrapper">
                                <div class="placeholder-text">
                                    <i class='bx bxs-car-garage'></i>
                                    <span>เลือกรูปภาพรถ</span>
                                </div>
                            </div>
                            <div class="form-floating-custom">
                                <input type="file" class="form-control" id="CarD_Img" name="CarD_Img" accept="image/*">
                            </div>
                        </div>
                        
                        <!-- Form Fields -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label for="CarD_Register"><i class='bx bx-id-card me-1'></i> ทะเบียนรถ</label>
                                        <input type="text" class="form-control" id="CarD_Register" name="CarD_Register" placeholder="เช่น กขค 1234" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label for="CarD_Province"><i class='bx bx-map me-1'></i> จังหวัด</label>
                                        <select id="CarD_Province" name="CarD_Province" class="form-select" required>
                                            <option value="">-- เลือกจังหวัด --</option>
                                            <?php foreach ($Province as $value) : ?>
                                                <option value="<?=$value->name_th?>"><?=$value->name_th?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label for="CarD_Category"><i class='bx bx-category me-1'></i> ประเภทรถ</label>
                                        <select id="CarD_Category" name="CarD_Category" class="form-select" required>
                                            <option value="">-- เลือกประเภท --</option>
                                            <option value="รถกระบะ 4 ประตู">🚗 รถกระบะ 4 ประตู</option>
                                            <option value="รถตู้">🚐 รถตู้</option>
                                            <option value="รถบรรทุกเล็ก 6 ล้อ">🚚 รถบรรทุกเล็ก 6 ล้อ</option>
                                            <option value="รถมินิบัส">🚌 รถมินิบัส</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label for="CarD_NumberSeats"><i class='bx bx-chair me-1'></i> จำนวนที่นั่ง</label>
                                        <input type="number" class="form-control" id="CarD_NumberSeats" name="CarD_NumberSeats" placeholder="เช่น 7" min="1" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label for="CarD_Brand"><i class='bx bx-building me-1'></i> ยี่ห้อ</label>
                                        <input type="text" class="form-control" id="CarD_Brand" name="CarD_Brand" placeholder="เช่น Toyota" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label for="CarD_Model"><i class='bx bx-tag me-1'></i> รุ่น</label>
                                        <input type="text" class="form-control" id="CarD_Model" name="CarD_Model" placeholder="เช่น Hilux Revo" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-floating-custom">
                                <label for="CarD_Details"><i class='bx bx-detail me-1'></i> รายละเอียดเพิ่มเติม</label>
                                <textarea class="form-control" id="CarD_Details" name="CarD_Details" rows="3" placeholder="รายละเอียดอื่นๆ เช่น สี, ปีที่ซื้อ, หมายเลขตัวถัง..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-warning" id="btnSaveCar">
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

<!-- View Car Modal -->
<div class="modal fade" id="viewCarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class='bx bx-car me-2'></i> รายละเอียดรถยนต์
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewCarContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    let carData = [];
    
    // Load car data
    function loadCarData() {
        $.ajax({
            url: '<?=base_url("Admin/Car/ShowData")?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                carData = response.aaData || [];
                updateStats();
                renderCarCards(carData);
            }
        });
    }
    
    // Update statistics
    function updateStats() {
        $('#totalCars').text(carData.length);
        $('#totalPickup').text(carData.filter(c => c.car_category.includes('กระบะ')).length);
        $('#totalVan').text(carData.filter(c => c.car_category.includes('ตู้')).length);
        $('#totalOther').text(carData.filter(c => !c.car_category.includes('กระบะ') && !c.car_category.includes('ตู้')).length);
    }
    
    // Get category badge class
    function getCategoryBadge(category) {
        if (category.includes('กระบะ')) return 'pickup';
        if (category.includes('ตู้')) return 'van';
        if (category.includes('บรรทุก')) return 'truck';
        if (category.includes('มินิบัส')) return 'minibus';
        return 'pickup';
    }
    
    // Render car cards
    function renderCarCards(data) {
        const container = $('#carCardsContainer');
        container.find('.car-card-col').remove();
        
        // Hide loading, show add card
        $('#loadingIndicator').addClass('d-none');
        $('.add-car-col').removeClass('d-none');
        
        if (data.length === 0) {
            // Keep add card only
            return;
        }
        
        data.forEach(car => {
            const hasImage = car.car_img && car.car_img !== '';
            const imgSrc = hasImage ? `<?=base_url('uploads/admin/Car/')?>/${car.car_img}` : '';
            const badgeClass = getCategoryBadge(car.car_category);
            
            const imageContent = hasImage 
                ? `<img src="${imgSrc}" alt="${car.car_registration}" onerror="this.parentElement.innerHTML='<div class=\\'no-image-placeholder\\'><i class=\\'bx bxs-car\\'></i><span>ไม่มีรูปภาพ</span></div>'">`
                : `<div class="no-image-placeholder"><i class='bx bxs-car'></i><span>ไม่มีรูปภาพ</span></div>`;
            
            const cardHtml = `
                <div class="col-sm-6 col-xl-4 col-xxl-3 mb-4 car-card-col" data-category="${car.car_category}">
                    <div class="card car-card h-100">
                        <div class="car-img-wrapper">
                            ${imageContent}
                            <span class="car-category-badge ${badgeClass}">${car.car_category}</span>
                        </div>
                        <div class="card-body">
                            <div class="car-registration">${car.car_registration}</div>
                            <div class="car-brand">${car.car_brand} ${car.car_model} • ${car.car_province}</div>
                            <div class="car-info">
                                <span class="car-info-item">
                                    <i class='bx bxs-user'></i> ${car.car_seats} ที่นั่ง
                                </span>
                            </div>
                            <div class="action-buttons">
                                <button class="btn btn-outline-primary btn-view" data-id="${car.car_ID}">
                                    <i class='bx bx-show'></i> ดู
                                </button>
                                <button class="btn btn-outline-danger btn-delete" data-id="${car.car_ID}">
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
    $('#searchCar').on('input', function() {
        const query = $(this).val().toLowerCase();
        const filtered = carData.filter(car => 
            car.car_registration.toLowerCase().includes(query) ||
            car.car_brand.toLowerCase().includes(query) ||
            car.car_model.toLowerCase().includes(query) ||
            car.car_province.toLowerCase().includes(query)
        );
        renderCarCards(filtered);
    });
    
    // Filter by category
    $('#filterCategory').on('change', function() {
        const category = $(this).val();
        const filtered = category ? carData.filter(c => c.car_category === category) : carData;
        renderCarCards(filtered);
    });
    
    // View toggle
    $('#gridView').on('click', function() {
        $(this).addClass('active');
        $('#listView').removeClass('active');
        $('#carCardsContainer').removeClass('d-none');
        $('#tableViewContainer').addClass('d-none');
        $('.add-car-col').removeClass('d-none');
    });
    
    $('#listView').on('click', function() {
        $(this).addClass('active');
        $('#gridView').removeClass('active');
        $('#carCardsContainer').addClass('d-none');
        $('#tableViewContainer').removeClass('d-none');
        $('.add-car-col').addClass('d-none');
        initDataTable();
    });
    
    // Image preview
    $('#CarD_Img').on('change', function() {
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
    $('#FromCarInsert').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const $btn = $('#btnSaveCar');
        
        // Show button loading
        $btn.prop('disabled', true);
        $btn.find('.btn-text').addClass('d-none');
        $btn.find('.btn-loading').removeClass('d-none');
        
        $.ajax({
            url: '<?=base_url("Admin/Car/Insert")?>',
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
                    $('#addCarModal').modal('hide');
                    $('#FromCarInsert')[0].reset();
                    $('#imgPreviewWrapper').html(`
                        <div class="placeholder-text">
                            <i class='bx bxs-car-garage'></i>
                            <span>เลือกรูปภาพรถ</span>
                        </div>
                    `);
                    loadCarData();
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
    
    // Delete car
    $(document).on('click', '.btn-delete', function() {
        const carId = $(this).data('id');
        
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: 'คุณต้องการลบข้อมูลรถยนต์นี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?=base_url("Admin/Car/Delete")?>',
                    type: 'POST',
                    data: { DelKey: carId },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบสำเร็จ!',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadCarData();
                    }
                });
            }
        });
    });
    
    // View car details
    $(document).on('click', '.btn-view', function() {
        const carId = $(this).data('id');
        const car = carData.find(c => c.car_ID == carId);
        
        if (car) {
            const hasImage = car.car_img && car.car_img !== '';
            const imgContent = hasImage 
                ? `<img src="<?=base_url('uploads/admin/Car/')?>/${car.car_img}" class="img-fluid rounded-3" alt="${car.car_registration}" onerror="this.parentElement.innerHTML='<div class=\\'view-no-image\\'><i class=\\'bx bxs-car\\'></i><span>ไม่มีรูปภาพ</span></div>'" style="max-height: 250px; object-fit: cover;">`
                : `<div class="view-no-image" style="height: 200px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, #f0f2f5, #e4e7eb); border-radius: 12px; color: #a1acb8;"><i class='bx bxs-car' style="font-size: 4rem; opacity: 0.6;"></i><span>ไม่มีรูปภาพ</span></div>`;
            
            const content = `
                <div class="row">
                    <div class="col-md-5">
                        ${imgContent}
                    </div>
                    <div class="col-md-7">
                        <h3 class="fw-bold text-warning mb-2">${car.car_registration}</h3>
                        <p class="text-muted mb-4">${car.car_province}</p>
                        
                        <div class="mb-3">
                            <span class="badge bg-label-warning mb-2">${car.car_category}</span>
                        </div>
                        
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted" width="40%"><i class='bx bx-building me-2'></i>ยี่ห้อ</td>
                                <td class="fw-semibold">${car.car_brand}</td>
                            </tr>
                            <tr>
                                <td class="text-muted"><i class='bx bx-tag me-2'></i>รุ่น</td>
                                <td class="fw-semibold">${car.car_model}</td>
                            </tr>
                            <tr>
                                <td class="text-muted"><i class='bx bx-chair me-2'></i>จำนวนที่นั่ง</td>
                                <td class="fw-semibold">${car.car_seats} ที่นั่ง</td>
                            </tr>
                            <tr>
                                <td class="text-muted"><i class='bx bx-detail me-2'></i>รายละเอียด</td>
                                <td class="fw-semibold">${car.car_detail || '-'}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            `;
            
            $('#viewCarContent').html(content);
            $('#viewCarModal').modal('show');
        }
    });
    
    // DataTable for list view
    let dataTable = null;
    function initDataTable() {
        if (dataTable) {
            dataTable.destroy();
        }
        
        dataTable = $('.TbDataCar').DataTable({
            data: carData,
            columns: [
                {
                    data: 'car_img',
                    render: function(data) {
                        if (data && data !== '') {
                            return `<img src="<?=base_url('uploads/admin/Car/')?>/${data}" width="80" height="50" class="rounded" style="object-fit:cover" onerror="this.outerHTML='<div style=\\'width:80px;height:50px;background:#f0f2f5;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#a1acb8;\\'><i class=\\'bx bxs-car\\' style=\\'font-size:1.5rem;\\'></i></div>'">`;
                        }
                        return `<div style="width:80px;height:50px;background:#f0f2f5;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#a1acb8;"><i class='bx bxs-car' style="font-size:1.5rem;"></i></div>`;
                    }
                },
                {
                    data: null,
                    render: function(data) {
                        return `<strong>${data.car_registration}</strong><br><small class="text-muted">${data.car_brand} ${data.car_model}</small>`;
                    }
                },
                { data: 'car_category' },
                { 
                    data: 'car_seats',
                    render: function(data) {
                        return `<span class="badge bg-label-info">${data} ที่นั่ง</span>`;
                    }
                },
                {
                    data: 'car_ID',
                    render: function(data) {
                        return `
                            <button class="btn btn-sm btn-outline-primary btn-view" data-id="${data}"><i class='bx bx-show'></i></button>
                            <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${data}"><i class='bx bx-trash'></i></button>
                        `;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/th.json'
            }
        });
    }
    
    // Initial load
    loadCarData();
});
</script>
<?= $this->endSection() ?>