<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>
<?= $this->section('content') ?>

<?php
// Partition roles into Executives and Department Staff based on status
$executiveRoles = [];
$departmentRoles = [];
foreach ($Manager as $role) {
    if (isset($role->admin_rloes_status) && ($role->admin_rloes_status === 'ManagerGeneral' || $role->admin_rloes_status === 'ExecutiveGeneral')) {
        $executiveRoles[] = $role;
    } else {
        $departmentRoles[] = $role;
    }
}

// Group department staff by their department name (admin_rloes_nanetype)
$groupedDepartments = [];
foreach ($departmentRoles as $role) {
    $groupedDepartments[$role->admin_rloes_nanetype][] = $role;
}

// Define a specific order for departments to maintain consistency
$departmentOrder = [
    'งานอาคารสถานที่',
    'งานธุรการ',
    'งานยานพาหนะ',
    'งานแจ้งซ่อม',
    'งานบุคลากร'
];

// Create a new ordered array for department cards
$orderedGroupedDepartments = [];
foreach ($departmentOrder as $dept) {
    if (isset($groupedDepartments[$dept])) {
        $orderedGroupedDepartments[$dept] = $groupedDepartments[$dept];
        unset($groupedDepartments[$dept]);
    }
}

ksort($groupedDepartments);
foreach ($groupedDepartments as $dept => $roles) {
    $orderedGroupedDepartments[$dept] = $roles;
}

// Department Icons
$departmentIcons = [
    'งานอาคารสถานที่' => 'bxs-building-house',
    'งานธุรการ' => 'bxs-briefcase',
    'งานยานพาหนะ' => 'bxs-car',
    'งานแจ้งซ่อม' => 'bxs-wrench',
    'งานบุคลากร' => 'bxs-user-badge'
];

// Department Colors
$departmentColors = [
    'งานอาคารสถานที่' => '#696cff',
    'งานธุรการ' => '#71dd37',
    'งานยานพาหนะ' => '#ffab00',
    'งานแจ้งซ่อม' => '#ff3e1d',
    'งานบุคลากร' => '#03c3ec'
];
?>

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #8c6eff 0%, #696cff 100%);
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

.page-header::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: 10%;
    width: 150px;
    height: 150px;
    background: rgba(255,255,255,0.08);
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

/* Stats Cards */
.stats-card {
    background: #fff;
    border-radius: 12px;
    padding: 1.25rem;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stats-card .icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

/* Executive Card */
.executive-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.executive-card .card-header {
    background: linear-gradient(135deg, #8c6eff 0%, #696cff 100%);
    color: #fff;
    padding: 1.25rem 1.5rem;
    border: none;
}

.executive-card .card-header h5 {
    margin: 0;
    font-weight: 600;
    color: #fff;
}

/* Role Item */
.role-item {
    background: #fff;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border-left: 4px solid #696cff;
}

.role-item:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transform: translateX(5px);
}

.role-item .role-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #8592a3;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.role-item .role-label i {
    margin-right: 0.25rem;
}

/* Department Section */
.department-section {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.department-section:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.department-header {
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f0f2f5;
}

.department-header .dept-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.department-header .dept-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
}

.department-header .dept-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #566a7f;
    margin: 0;
}

.department-header .dept-count {
    font-size: 0.8rem;
    color: #8592a3;
}

.department-body {
    padding: 1.25rem 1.5rem;
}

/* Staff Card */
.staff-card {
    background: linear-gradient(135deg, #fafbfc 0%, #fff 100%);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 0.75rem;
    border: 1px solid #f0f2f5;
    transition: all 0.3s ease;
}

.staff-card:hover {
    border-color: #696cff;
    box-shadow: 0 4px 15px rgba(105, 108, 255, 0.15);
}

.staff-card .position-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #8592a3;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.staff-card .position-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
}

.staff-card .position-badge.head { background: rgba(255, 171, 0, 0.16); color: #ffab00; }
.staff-card .position-badge.staff { background: rgba(105, 108, 255, 0.16); color: #696cff; }

/* Modal Improvements */
.modal-content {
    border-radius: 16px;
    border: none;
}

.modal-header {
    background: linear-gradient(135deg, #8c6eff 0%, #696cff 100%);
    color: #fff;
    border-radius: 16px 16px 0 0;
    padding: 1.25rem 1.5rem;
}

.modal-header .modal-title {
    font-weight: 600;
    color: #fff;
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

/* Add Department Card */
.add-dept-card {
    border: 2px dashed #d9dee3;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.add-dept-card:hover {
    border-color: #696cff;
    background: rgba(105, 108, 255, 0.05);
}

.add-dept-card .add-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(105, 108, 255, 0.16);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.75rem;
    color: #696cff;
    transition: all 0.3s ease;
}

.add-dept-card:hover .add-icon {
    background: #696cff;
    color: #fff;
    transform: scale(1.1);
}

/* Select2 Styling */
.select2-container--default .select2-selection--single {
    border-radius: 8px !important;
    border: 1px solid #d9dee3 !important;
    height: auto !important;
    padding: 0.5rem 0.75rem !important;
}

.select2-container--default .select2-selection--single:focus {
    border-color: #696cff !important;
}

.select2-dropdown {
    border-radius: 8px !important;
    border: 1px solid #d9dee3 !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
}

/* Loading Skeleton */
.skeleton {
    background: linear-gradient(90deg, #f0f2f5 25%, #e4e7eb 50%, #f0f2f5 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 8px;
}

@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .department-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .department-header .dept-info {
        flex-direction: column;
    }
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4><i class='bx bxs-shield-alt-2 me-2'></i> กำหนดสิทธิ์การใช้งานระบบ</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?=base_url('Admin/Home')?>">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">กำหนดสิทธิ์</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                    <i class='bx bx-buildings me-1'></i> เพิ่มงานใหม่
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="icon me-3" style="background: rgba(105, 108, 255, 0.16); color: #696cff;">
                        <i class='bx bxs-user-badge'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?=count($Manager)?></h4>
                        <small class="text-muted">ตำแหน่งทั้งหมด</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="icon me-3" style="background: rgba(140, 110, 255, 0.16); color: #8c6eff;">
                        <i class='bx bxs-crown'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?=count($executiveRoles)?></h4>
                        <small class="text-muted">ผู้บริหาร</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 mb-3 mb-xl-0">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="icon me-3" style="background: rgba(113, 221, 55, 0.16); color: #71dd37;">
                        <i class='bx bxs-buildings'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?=count($orderedGroupedDepartments)?></h4>
                        <small class="text-muted">งาน/แผนก</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="icon me-3" style="background: rgba(3, 195, 236, 0.16); color: #03c3ec;">
                        <i class='bx bxs-user-check'></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?=count($departmentRoles)?></h4>
                        <small class="text-muted">เจ้าหน้าที่</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Executive Section -->
    <div class="executive-card">
        <div class="card-header d-flex align-items-center">
            <i class='bx bxs-crown me-2' style="font-size: 1.5rem;"></i>
            <h5>ผู้บริหาร</h5>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <?php foreach ($executiveRoles as $v_Manager) : ?>
                    <div class="col-md-4 mb-3">
                        <div class="role-item">
                            <div class="role-label">
                                <i class='bx bxs-star'></i>
                                <?= htmlspecialchars($v_Manager->admin_rloes_nanetype) ?>
                            </div>
                            <div class="d-flex gap-2">
                                <select class="select2Rloes form-select SettingGeneralRloes flex-grow-1"
                                    rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                                    rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                                    Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                                    <option value="">-- ไม่ระบุ --</option>
                                <?php foreach ($NameTeacher as $v_NameTeacher) : ?>
                                <option
                                    <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                    value="<?=$v_NameTeacher->pers_id?>">
                                    <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                                </option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Department Sections -->
    <div class="row">
        <?php foreach ($orderedGroupedDepartments as $department => $roles) : 
            $deptIcon = $departmentIcons[$department] ?? 'bxs-folder';
            $deptColor = $departmentColors[$department] ?? '#696cff';
        ?>
        <div class="col-lg-6 mb-4">
            <div class="department-section">
                <div class="department-header">
                    <div class="dept-info">
                        <div class="dept-icon" style="background: <?=$deptColor?>;">
                            <i class='bx <?=$deptIcon?>'></i>
                        </div>
                        <div>
                            <h6 class="dept-title"><?= htmlspecialchars($department) ?></h6>
                            <span class="dept-count"><?=count($roles)?> ตำแหน่ง</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-role-group="<?= htmlspecialchars($department) ?>">
                        <i class='bx bx-plus'></i> เพิ่ม
                    </button>
                </div>
                <div class="department-body">
                    <?php foreach ($roles as $v_Manager) : 
                        $SubLevel = explode("/", $v_Manager->admin_rloes_level);
                        $isHead = ($SubLevel[0] ?? '2') === '1';
                    ?>
                    <div class="staff-card">
                        <div class="position-label d-flex justify-content-between align-items-center">
                            <span class="position-badge <?=$isHead ? 'head' : 'staff'?>">
                                <i class='bx <?=$isHead ? 'bxs-star' : 'bxs-user'?> me-1'></i>
                                <?= htmlspecialchars(isset($SubLevel[1]) ? $SubLevel[1] : 'เจ้าหน้าที่') ?>
                            </span>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete-role" 
                                    data-id="<?=$v_Manager->admin_rloes_id?>" 
                                    data-name="<?=htmlspecialchars(isset($SubLevel[1]) ? $SubLevel[1] : 'เจ้าหน้าที่')?>">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                        <select class="select2Rloes form-select SettingGeneralRloes"
                            rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                            rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                            Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                            <option value="">-- เลือกเจ้าหน้าที่ (ลบจากตำแหน่ง) --</option>
                            <?php foreach ($NameTeacher as $v_NameTeacher) : ?>
                            <option
                                <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                value="<?=$v_NameTeacher->pers_id?>">
                                <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Add New Department Card -->
        <div class="col-lg-6 mb-4">
            <div class="add-dept-card" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                <div class="add-icon">
                    <i class='bx bx-plus'></i>
                </div>
                <h6 class="mb-1">เพิ่มงานใหม่</h6>
                <small class="text-muted">คลิกเพื่อสร้างงาน/แผนกใหม่</small>
            </div>
        </div>
    </div>

</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addDepartmentForm">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class='bx bx-buildings me-2'></i>เพิ่มงานใหม่
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating-custom">
                        <label for="department_name"><i class='bx bx-text me-1'></i> ชื่องาน</label>
                        <input type="text" class="form-control" id="department_name" name="department_name" placeholder="เช่น งานประชาสัมพันธ์" required>
                    </div>
                    
                    <div class="alert alert-info d-flex align-items-center mt-3" role="alert">
                        <i class='bx bx-info-circle me-2' style="font-size: 1.25rem;"></i>
                        <div>
                            เมื่อเพิ่มงานใหม่ ระบบจะสร้างตำแหน่ง "หัวหน้างาน" ให้อัตโนมัติ
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSaveDept">
                        <span class="btn-text"><i class='bx bx-save me-1'></i> บันทึก</span>
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

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addRoleForm">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class='bx bx-user-plus me-2'></i>เพิ่มเจ้าหน้าที่
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modalRoleGroup" name="role_group">
                    
                    <div class="text-center mb-4">
                        <div style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #8c6eff, #696cff); display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class='bx bxs-user-plus' style="font-size: 2rem; color: #fff;"></i>
                        </div>
                    </div>
                    
                    <div class="form-floating-custom">
                        <label for="modalUserSelect"><i class='bx bx-user me-1'></i> เลือกบุคลากร</label>
                        <select class="form-select" id="modalUserSelect" name="user_id" required>
                            <option value="">-- เลือกบุคลากร --</option>
                            <?php foreach ($NameTeacher as $v_NameTeacher) : ?>
                                <option value="<?=$v_NameTeacher->pers_id?>">
                                    <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="alert alert-warning d-flex align-items-center mt-3" role="alert">
                        <i class='bx bx-info-circle me-2' style="font-size: 1.25rem;"></i>
                        <div>
                            บุคลากรที่เลือกจะถูกเพิ่มเป็น <strong>"เจ้าหน้าที่"</strong> ในงานนี้
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x me-1'></i> ยกเลิก
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSaveRole">
                        <span class="btn-text"><i class='bx bx-save me-1'></i> บันทึก</span>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Select2 for all selects
    $('.select2Rloes').select2({
        width: '100%',
        placeholder: 'เลือกบุคลากร'
    });
    
    $('#modalUserSelect').select2({
        dropdownParent: $('#addRoleModal'),
        width: '100%'
    });

    // --- Add Department Modal Logic ---
    const addDepartmentForm = document.getElementById('addDepartmentForm');
    addDepartmentForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(addDepartmentForm);
        const $btn = $('#btnSaveDept');
        
        // Show button loading
        $btn.prop('disabled', true);
        $btn.find('.btn-text').addClass('d-none');
        $btn.find('.btn-loading').removeClass('d-none');

        fetch('<?= base_url('Admin/Rloes/AddDepartment') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            // Reset button
            $btn.prop('disabled', false);
            $btn.find('.btn-text').removeClass('d-none');
            $btn.find('.btn-loading').addClass('d-none');
            
            if (result.success) {
                bootstrap.Modal.getInstance(document.getElementById('addDepartmentModal')).hide();
                Swal.fire({
                    icon: 'success',
                    title: result.msg,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => location.reload(), 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: result.msg
                });
            }
        })
        .catch(error => {
            $btn.prop('disabled', false);
            $btn.find('.btn-text').removeClass('d-none');
            $btn.find('.btn-loading').addClass('d-none');
            
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาลองใหม่อีกครั้ง'
            });
        });
    });

    // --- Add Role Modal Logic ---
    const addRoleModal = document.getElementById('addRoleModal');
    addRoleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const roleGroup = button.getAttribute('data-role-group');
        const modalTitle = addRoleModal.querySelector('.modal-title');
        const roleGroupInput = addRoleModal.querySelector('#modalRoleGroup');
        
        modalTitle.innerHTML = '<i class="bx bx-user-plus me-2"></i>เพิ่มเจ้าหน้าที่ - ' + roleGroup;
        roleGroupInput.value = roleGroup;

        $('#addRoleForm')[0].reset();
        $('#modalUserSelect').val(null).trigger('change');
    });

    const addRoleForm = document.getElementById('addRoleForm');
    addRoleForm.addEventListener('submit', function (event) {
        event.preventDefault();
        
        const formData = new FormData(addRoleForm);
        formData.append('role_level', '2/เจ้าหน้าที่');
        
        const $btn = $('#btnSaveRole');
        
        // Show button loading
        $btn.prop('disabled', true);
        $btn.find('.btn-text').addClass('d-none');
        $btn.find('.btn-loading').removeClass('d-none');

        fetch('<?= base_url('Admin/Rloes/AddRole') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            // Reset button
            $btn.prop('disabled', false);
            $btn.find('.btn-text').removeClass('d-none');
            $btn.find('.btn-loading').addClass('d-none');
            
            if (result.success) {
                bootstrap.Modal.getInstance(addRoleModal).hide();
                Swal.fire({
                    icon: 'success',
                    title: result.msg,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => location.reload(), 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: result.msg
                });
            }
        })
        .catch(error => {
            $btn.prop('disabled', false);
            $btn.find('.btn-text').removeClass('d-none');
            $btn.find('.btn-loading').addClass('d-none');
            
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาลองใหม่อีกครั้ง'
            });
        });
    });

    // --- Role Update & Deletion Logic ---
    let previousValue;
    
    $(document).on('focus', '.SettingGeneralRloes', function () {
        previousValue = $(this).val();
    });

    $(document).on('change', '.SettingGeneralRloes', function (e) {
        const selectElement = $(this);
        const selectedValue = selectElement.val();
        
        if (selectedValue === "") {
            e.preventDefault();
            e.stopImmediatePropagation();

            Swal.fire({
                title: 'ยืนยันการลบ',
                text: "คุณต้องการนำผู้ใช้งานออกจากตำแหน่งนี้ใช่หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('Admin/Rloes/DeleteRole') ?>',
                        type: 'POST',
                        data: { rloes_id: selectElement.attr('rloes-id') },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: response.msg,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                selectElement.closest('.staff-card').fadeOut(500, function() { $(this).remove(); });
                            } else {
                                Swal.fire('เกิดข้อผิดพลาด!', response.msg, 'error');
                                selectElement.val(previousValue).trigger('change.select2');
                            }
                        },
                        error: function() {
                            Swal.fire('เกิดข้อผิดพลาด!', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                            selectElement.val(previousValue).trigger('change.select2');
                        }
                    });
                } else {
                    selectElement.val(previousValue).trigger('change.select2');
                }
            });
        } else {
            // Update the role
            $.ajax({
                url: '<?= base_url('Admin/Rloes/RloesSettingManager') ?>',
                type: 'POST',
                data: {
                    TeachID: selectedValue,
                    RloesLevel: selectElement.attr('rloes-level'),
                    Keytype: selectElement.attr('Key-nanetype'),
                    RloesID: selectElement.attr('rloes-id')
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'บันทึกสำเร็จ!',
                        timer: 1000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            });
        }
    });

    // --- New Delete Button Logic ---
    $(document).on('click', '.btn-delete-role', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const card = $(this).closest('.staff-card');

        Swal.fire({
            title: 'ยืนยันการลบตำแหน่ง?',
            text: `คุณกำลังจะลบตำแหน่ง "${name}" ออกจากระบบถาวร`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('Admin/Rloes/DeleteRole') ?>',
                    type: 'POST',
                    data: { rloes_id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: response.msg,
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            card.fadeOut(500, function() { $(this).remove(); });
                        } else {
                            Swal.fire('เกิดข้อผิดพลาด!', response.msg, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('เกิดข้อผิดพลาด!', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                    }
                });
            }
        });
    });
});
</script>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?=base_url()?>/assets/js/Admin/AdminRoles/AdminRolesMain.js?v=3.2"></script>
<?= $this->endSection() ?>
