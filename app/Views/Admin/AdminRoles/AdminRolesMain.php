<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>
<?= $this->section('content') ?>

<?php
// สร้างตัวแปรช่วยค้นหาสิทธิ์ของผู้ใช้งานแต่ละคนได้ง่ายขึ้น
$userRolesMap = [];
foreach ($Manager as $role) {
    $userRolesMap[$role->admin_rloes_userid] = $role;
}

// รายการระบบทั้งหมดที่สามารถเลือกได้
$systemList = [
    'งานอาคารสถานที่',
    'งานธุรการ',
    'งานยานพาหนะ',
    'งานแจ้งซ่อม',
    'งานบุคลากร',
    'งานรายงานอาหาร'
];

$roleLevels = [
    '1/หัวหน้าสูงสุด',
    '2/รองหัวหน้า',
    '1/หัวหน้า',
    '1/หัวหน้างาน',
    '2/เจ้าหน้าที่'
];

$roleStatuses = [
    'AdminGeneral' => 'เจ้าหน้าที่ทั่วไป (Admin)',
    'ManagerGeneral' => 'หัวหน้าระดับกลาง (Manager)',
    'ExecutiveGeneral' => 'ผู้บริหาร (Executive)',
    'superadmin' => 'ผู้ดูแลระบบสูงสุด (Superadmin)'
];
?>

<style>
    /* CSS Variables for Premium Dark/Glassmorphism Design */
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);
        --superadmin-gradient: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.18);
        --text-dark: #2d3748;
        --text-muted: #718096;
        --shadow-soft: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        --shadow-hover: 0 12px 40px 0 rgba(31, 38, 135, 0.15);
    }

    /* Page Header */
    .premium-header {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        color: white;
        box-shadow: 0 10px 25px rgba(118, 75, 162, 0.3);
    }

    .premium-header::before, .premium-header::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
    }

    .premium-header::before {
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
    }

    .premium-header::after {
        bottom: -100px;
        left: 10%;
        width: 300px;
        height: 300px;
    }

    .premium-header .header-content {
        position: relative;
        z-index: 2;
    }

    /* Glass Card */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 20px;
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-soft);
        padding: 2rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Table Styles */
    .premium-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .premium-table th {
        background: transparent;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 1rem 1.5rem;
        border: none;
    }

    .premium-table tbody tr {
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .premium-table tbody tr:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: var(--shadow-hover);
    }

    .premium-table td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border-top: 1px solid rgba(0,0,0,0.02);
        border-bottom: 1px solid rgba(0,0,0,0.02);
    }

    .premium-table td:first-child {
        border-left: 1px solid rgba(0,0,0,0.02);
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    .premium-table td:last-child {
        border-right: 1px solid rgba(0,0,0,0.02);
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Tags */
    .tag-system {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
        margin: 3px;
        transition: all 0.3s ease;
        border: 1px solid rgba(102, 126, 234, 0.2);
    }

    .tag-system:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    .tag-superadmin {
        background: var(--superadmin-gradient);
        color: #fff;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: bold;
        box-shadow: 0 4px 15px rgba(246, 211, 101, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* User Avatar */
    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        margin-right: 15px;
        flex-shrink: 0;
        overflow: hidden;
        border: 2px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Buttons */
    .btn-edit {
        background: rgba(118, 75, 162, 0.1);
        color: #764ba2;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        background: #764ba2;
        color: white;
        box-shadow: 0 5px 15px rgba(118, 75, 162, 0.3);
    }

    .btn-delete {
        background: rgba(255, 62, 29, 0.1);
        color: #ff3e1d;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        background: #ff3e1d;
        color: white;
        box-shadow: 0 5px 15px rgba(255, 62, 29, 0.3);
    }

    /* Modal Adjustments */
    .modal-content.glass-modal {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.5);
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* Select2 Custom Styles */
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 10px !important;
        border: 1px solid #d9dee3 !important;
        min-height: calc(1.5em + 1rem + 2px) !important;
        padding: 0.375rem 0.75rem;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
        background-color: rgba(102, 126, 234, 0.1) !important;
        color: #667eea !important;
        border: none !important;
        border-radius: 20px !important;
        padding: 2px 10px !important;
        margin-top: 5px !important;
    }

    /* Make SweetAlert2 appear above Bootstrap Modals */
    .swal2-container {
        z-index: 100000 !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Premium Page Header -->
    <div class="premium-header">
        <div class="header-content d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="mb-2 fw-bold text-white"><i class='bx bx-fingerprint me-2'></i> จัดการสิทธิ์ผู้ใช้งานระบบ</h2>
                <p class="mb-0 text-white-50">กำหนดการเข้าถึงระบบต่างๆ สำหรับบุคลากร 1 คนสามารถเข้าถึงได้หลายระบบพร้อมกัน</p>
            </div>
            <div class="mt-3 mt-md-0">
                <button class="btn btn-warning rounded-pill px-4 py-2 shadow-sm text-dark fw-bold me-2" type="button" onclick="openAddModal()">
                    <i class='bx bx-user-plus me-1'></i> เพิ่มสิทธิ์ผู้ใช้งาน
                </button>
                <button class="btn btn-light rounded-pill px-4 py-2 shadow-sm text-primary fw-bold" type="button" onclick="window.location.reload();">
                    <i class='bx bx-refresh me-1'></i> รีเฟรชข้อมูล
                </button>
            </div>
        </div>
    </div>

<?php
// เตรียมข้อมูลจัดกลุ่ม
$executives = [];
$superadmins = [];
$departments = [];
foreach ($systemList as $sys) {
    $departments[$sys] = [];
}

foreach ($NameTeacher as $user) {
    $role = $userRolesMap[$user->pers_id] ?? null;
    if (!$role) continue;
    
    $systems = [];
    if (!empty($role->admin_rloes_nanetype)) {
        $decoded = json_decode($role->admin_rloes_nanetype, true);
        $systems = is_array($decoded) ? $decoded : [$role->admin_rloes_nanetype];
    }
    
    $userData = ['user' => $user, 'role' => $role, 'systems' => $systems];
    
    if ($role->admin_rloes_status === 'superadmin') {
        $superadmins[] = $userData;
    } elseif (in_array($role->admin_rloes_status, ['ExecutiveGeneral', 'ManagerGeneral'])) {
        $executives[] = $userData;
    } else {
        foreach ($systems as $sys) {
            if (isset($departments[$sys])) {
                $departments[$sys][] = $userData;
            } else {
                $departments[$sys] = [$userData];
            }
        }
    }
}

// ฟังก์ชันวาดตาราง
$renderTable = function($usersList) use ($roleStatuses) {
    if (empty($usersList)) return;
    ?>
    <div class="table-responsive text-nowrap">
        <table class="table premium-table rolesTable">
            <thead>
                <tr>
                    <th>บุคลากร</th>
                    <th>ระดับผู้ใช้งาน</th>
                    <th>สถานะ (Status)</th>
                    <th>ระบบที่เข้าถึงได้</th>
                    <th class="text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usersList as $userData) : 
                    extract($userData);
                    $hasAccess = $role !== null;
                    $isSuperadmin = $role && $role->admin_rloes_status === 'superadmin';
                    $initial = mb_substr($user->pers_firstname, 0, 1);
                ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="user-avatar">
                                <?php if (!empty($user->pers_img)): ?>
                                    <img src="https://personnel.skj.ac.th/uploads/admin/Personnal/<?=$user->pers_img?>" alt="<?=$user->pers_firstname?>" onerror="this.onerror=null; this.parentNode.innerText='<?=$initial?>';">
                                <?php else: ?>
                                    <?=$initial?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h6 class="mb-0 text-dark fw-bold"><?=$user->pers_prefix.$user->pers_firstname." ".$user->pers_lastname?></h6>
                                <small class="text-muted"><?= $user->posi_name ?? $user->pers_position ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php if ($hasAccess): ?>
                            <span class="badge bg-label-primary rounded-pill px-3 py-2">
                                <i class='bx bx-briefcase me-1'></i> <?=explode('/', $role->admin_rloes_level)[1] ?? $role->admin_rloes_level?>
                            </span>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($isSuperadmin): ?>
                            <div class="tag-superadmin"><i class='bx bxs-crown'></i> Superadmin</div>
                        <?php elseif ($hasAccess): ?>
                            <span class="fw-bold" style="color: #4a5568;">
                                <?= $roleStatuses[$role->admin_rloes_status] ?? $role->admin_rloes_status ?>
                            </span>
                        <?php else: ?>
                            <span class="text-muted">ไม่มีสิทธิ์</span>
                        <?php endif; ?>
                    </td>
                    <td style="white-space: normal; min-width: 250px;">
                        <?php if ($isSuperadmin): ?>
                            <span class="text-success fw-bold"><i class='bx bx-check-double'></i> เข้าถึงได้ทุกระบบ (Bypass)</span>
                        <?php elseif (!empty($systems)): ?>
                            <?php foreach ($systems as $sys): ?>
                                <span class="tag-system"><?=$sys?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="text-muted fst-italic">ยังไม่ได้กำหนดระบบ</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <button class="btn-edit" 
                            onclick='openEditModal(
                                "<?=$user->pers_id?>", 
                                "<?=$user->pers_prefix.$user->pers_firstname." ".$user->pers_lastname?>",
                                <?=json_encode($systems)?>,
                                "<?=$role ? $role->admin_rloes_level : '2/เจ้าหน้าที่'?>",
                                "<?=$role ? $role->admin_rloes_status : 'AdminGeneral'?>"
                            )'>
                            <i class='bx bx-edit-alt me-1'></i> แก้ไข
                        </button>
                        <button class="btn-delete" onclick="deleteRole('<?=$user->pers_id?>', '<?=$user->pers_firstname?>')">
                            <i class='bx bx-trash me-1'></i> ลบ
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
};
?>

    <!-- ผู้บริหาร Section -->
    <div class="glass-card mb-4 border-primary" style="border-left: 5px solid #667eea;">
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0 fw-bold" style="color: var(--text-dark);"><i class='bx bxs-user-badge text-primary me-2 fs-3'></i> ผู้บริหาร</h4>
        </div>
        <?php 
        if (!empty($executives)) {
            $renderTable($executives); 
        } else {
            echo '<div class="text-muted">ไม่มีข้อมูลผู้บริหาร</div>';
        }
        ?>
    </div>

    <!-- ระบบต่างๆ Section -->
    <h4 class="mb-3 fw-bold mt-5 text-white"><i class='bx bx-category me-2'></i> ผู้ดูแลระบบย่อยตามสายงาน</h4>
    <div class="row g-4">
        <?php foreach ($departments as $sys => $users) : ?>
        <div class="col-12">
            <div class="glass-card">
                <div class="d-flex align-items-center mb-3">
                    <h5 class="mb-0 fw-bold" style="color: var(--text-dark);"><i class='bx bx-building text-primary me-2 fs-4'></i> <?=$sys?></h5>
                </div>
                <?php 
                if (!empty($users)) {
                    $renderTable($users); 
                } else {
                    echo '<div class="text-muted text-center py-3">ยังไม่มีผู้ดูแลระบบนี้</div>';
                }
                ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Superadmin Section (ล่างสุด) -->
    <div class="glass-card mt-5 mb-4" style="border-left: 5px solid #fda085; background: rgba(254, 249, 231, 0.85);">
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0 fw-bold" style="color: var(--text-dark);"><i class='bx bxs-crown text-warning me-2 fs-3'></i> ผู้ดูแลระบบสูงสุด (Superadmin)</h4>
        </div>
        <?php 
        if (!empty($superadmins)) {
            $renderTable($superadmins); 
        } else {
            echo '<div class="text-muted">ไม่มีข้อมูล Superadmin</div>';
        }
        ?>
    </div>
</div>

<!-- Add Role Modal (Glassmorphism) -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-modal">
            <div class="modal-header border-0 pb-0">
                <h4 class="modal-title fw-bold" style="color: #2d3748;">
                    <i class='bx bx-user-plus text-primary me-2'></i> เพิ่มผู้ดูแลระบบใหม่
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addRoleForm">
                <div class="modal-body pt-4">
                    <div class="row g-4">
                        <!-- เลือกบุคลากร -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-2">เลือกบุคลากร</label>
                            <select id="addModalUserId" name="user_id" class="select2-single" required>
                                <option value="">-- เลือกบุคลากร --</option>
                                <?php foreach ($NameTeacher as $user): ?>
                                    <option value="<?=$user->pers_id?>">
                                        <?=$user->pers_prefix.$user->pers_firstname." ".$user->pers_lastname?> (<?=$user->posi_name ?? $user->pers_position?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ระบบที่เข้าถึงได้ -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-2">ระบบที่เข้าถึงได้ (เลือกได้มากกว่า 1)</label>
                            <select id="addModalSystems" name="systems[]" class="select2-multiple-add" multiple="multiple" data-placeholder="เลือกสิทธิ์การเข้าระบบ">
                                <?php foreach ($systemList as $sys): ?>
                                    <option value="<?=$sys?>"><?=$sys?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- สถานะในระบบ -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark mb-2">สถานะสิทธิ์ (Status)</label>
                            <select id="addModalStatus" name="status" class="form-select" onchange="checkAddSuperadmin()">
                                <?php foreach ($roleStatuses as $key => $label): ?>
                                    <option value="<?=$key?>"><?=$label?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ระดับตำแหน่ง -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark mb-2">ระดับตำแหน่ง (Level)</label>
                            <select id="addModalLevel" name="level" class="form-select">
                                <?php foreach ($roleLevels as $lvl): ?>
                                    <option value="<?=$lvl?>"><?=$lvl?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div id="addSuperadminAlert" class="alert alert-warning mt-4 d-none" style="border-radius: 12px; border-left: 5px solid #f6d365;">
                        <h6 class="alert-heading fw-bold mb-1"><i class='bx bxs-crown'></i> คำเตือน Superadmin</h6>
                        <p class="mb-0">การตั้งสถานะเป็น Superadmin จะทำให้ผู้ใช้นี้ <strong>เข้าใช้งานได้ทุกระบบทันที</strong> โดยไม่สนใจว่าจะเลือกระบบในช่องด้านบนหรือไม่</p>
                    </div>

                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm" style="background: var(--primary-gradient); border: none;">
                        <i class='bx bx-save me-1'></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Role Modal (Glassmorphism) -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content glass-modal">
            <div class="modal-header border-0 pb-0">
                <h4 class="modal-title fw-bold" style="color: #2d3748;">
                    <i class='bx bx-lock-open-alt text-primary me-2'></i> แก้ไขสิทธิ์: <span id="modalUserName" class="text-primary"></span>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRoleForm">
                <div class="modal-body pt-4">
                    <input type="hidden" id="modalUserId" name="user_id">
                    
                    <div class="row g-4">
                        <!-- ระบบที่เข้าถึงได้ -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark mb-2">ระบบที่เข้าถึงได้ (เลือกได้มากกว่า 1)</label>
                            <select id="modalSystems" name="systems[]" class="select2-multiple" multiple="multiple" data-placeholder="เลือกสิทธิ์การเข้าระบบ">
                                <?php foreach ($systemList as $sys): ?>
                                    <option value="<?=$sys?>"><?=$sys?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted mt-2 d-block"><i class='bx bx-info-circle'></i> ข้อมูลนี้จะถูกเก็บเป็น Array</small>
                        </div>

                        <!-- สถานะในระบบ -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark mb-2">สถานะสิทธิ์ (Status)</label>
                            <select id="modalStatus" name="status" class="form-select" onchange="checkSuperadmin()">
                                <?php foreach ($roleStatuses as $key => $label): ?>
                                    <option value="<?=$key?>"><?=$label?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ระดับตำแหน่ง -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark mb-2">ระดับตำแหน่ง (Level)</label>
                            <select id="modalLevel" name="level" class="form-select">
                                <?php foreach ($roleLevels as $lvl): ?>
                                    <option value="<?=$lvl?>"><?=$lvl?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div id="superadminAlert" class="alert alert-warning mt-4 d-none" style="border-radius: 12px; border-left: 5px solid #f6d365;">
                        <h6 class="alert-heading fw-bold mb-1"><i class='bx bxs-crown'></i> คำเตือน Superadmin</h6>
                        <p class="mb-0">การตั้งสถานะเป็น Superadmin จะทำให้ผู้ใช้นี้ <strong>เข้าใช้งานได้ทุกระบบทันที</strong> โดยไม่สนใจว่าจะเลือกระบบในช่องด้านบนหรือไม่</p>
                    </div>

                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-label-secondary rounded-pill px-4" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm" style="background: var(--primary-gradient); border: none;">
                        <i class='bx bx-save me-1'></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize DataTable
    $('.rolesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/th.json',
        },
        pageLength: 25,
        ordering: false, // Custom sorted by controller
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-7"p>>',
    });

    // Initialize Select2 in modal
    $('.select2-multiple').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#editRoleModal'),
        width: '100%',
        closeOnSelect: false
    });

    // Initialize Select2 in Add Modal
    $('.select2-single').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#addRoleModal'),
        width: '100%'
    });
    
    $('.select2-multiple-add').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#addRoleModal'),
        width: '100%',
        closeOnSelect: false
    });

    // Handle Edit Form Submit
    $('#editRoleForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let btn = $(this).find('button[type="submit"]');
        let originalText = btn.html();
        
        btn.html('<i class="bx bx-loader bx-spin"></i> กำลังบันทึก...').prop('disabled', true);
        
        fetch('<?=base_url('Admin/Rloes/SaveUserRoles')?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกสำเร็จ!',
                    text: 'อัปเดตสิทธิ์ผู้ใช้งานเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        popup: 'rounded-4'
                    }
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('ข้อผิดพลาด', data.msg, 'error');
                btn.html(originalText).prop('disabled', false);
            }
        })
        .catch(err => {
            Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
            btn.html(originalText).prop('disabled', false);
        });
    });

    // Handle Add Form Submit
    $('#addRoleForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let btn = $(this).find('button[type="submit"]');
        let originalText = btn.html();
        
        btn.html('<i class="bx bx-loader bx-spin"></i> กำลังบันทึก...').prop('disabled', true);
        
        fetch('<?=base_url('Admin/Rloes/SaveUserRoles')?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'เพิ่มผู้ดูแลสำเร็จ!',
                    text: 'เพิ่มสิทธิ์การเข้าถึงระบบเรียบร้อยแล้ว',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        popup: 'rounded-4'
                    }
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('ข้อผิดพลาด', data.msg, 'error');
                btn.html(originalText).prop('disabled', false);
            }
        })
        .catch(err => {
            Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
            btn.html(originalText).prop('disabled', false);
        });
    });
});

function openEditModal(userId, userName, systems, level, status) {
    $('#modalUserId').val(userId);
    $('#modalUserName').text(userName);
    
    // Set Status and Level
    $('#modalStatus').val(status);
    $('#modalLevel').val(level);
    
    // Set Multiple Systems
    $('#modalSystems').val(systems).trigger('change');
    
    checkSuperadmin();
    
    new bootstrap.Modal(document.getElementById('editRoleModal')).show();
}

function checkSuperadmin() {
    let status = $('#modalStatus').val();
    if(status === 'superadmin') {
        $('#superadminAlert').removeClass('d-none').addClass('d-flex align-items-center gap-3');
    } else {
        $('#superadminAlert').addClass('d-none').removeClass('d-flex align-items-center gap-3');
    }
}

function openAddModal() {
    // Reset form
    $('#addRoleForm')[0].reset();
    $('#addModalUserId').val('').trigger('change');
    $('#addModalSystems').val([]).trigger('change');
    checkAddSuperadmin();
    
    new bootstrap.Modal(document.getElementById('addRoleModal')).show();
}

function checkAddSuperadmin() {
    let status = $('#addModalStatus').val();
    if(status === 'superadmin') {
        $('#addSuperadminAlert').removeClass('d-none').addClass('d-flex align-items-center gap-3');
    } else {
        $('#addSuperadminAlert').addClass('d-none').removeClass('d-flex align-items-center gap-3');
    }
}

function deleteRole(userId, userName) {
    Swal.fire({
        title: 'ยืนยันการลบสิทธิ์?',
        html: `คุณต้องการลบสิทธิ์ผู้ดูแลระบบของ <b>${userName}</b> ใช่หรือไม่?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff3e1d',
        cancelButtonColor: '#8592a3',
        confirmButtonText: 'ใช่, ลบสิทธิ์เลย!',
        cancelButtonText: 'ยกเลิก',
        customClass: {
            popup: 'rounded-4'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('user_id', userId);
            
            fetch('<?=base_url('Admin/Rloes/DeleteRole')?>', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบสำเร็จ!',
                        text: 'ลบสิทธิ์เรียบร้อยแล้ว',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: { popup: 'rounded-4' }
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('ข้อผิดพลาด', data.msg, 'error');
                }
            })
            .catch(err => {
                Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
            });
        }
    });
}
</script>

<?= $this->endSection() ?>
