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
        unset($groupedDepartments[$dept]); // Remove from original to handle leftovers
    }
}

// Add any remaining departments that were not in the predefined order
// and sort them by key to ensure a consistent order
ksort($groupedDepartments);
foreach ($groupedDepartments as $dept => $roles) {
    $orderedGroupedDepartments[$dept] = $roles;
}

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center py-3 mb-4">
        <h4 class="mb-0">
            <span class="text-muted fw-light"></span> กำหนดสิทธิ์ใช้งานในระบบบริหารทั่วไป
        </h4>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
            <i class="bx bx-buildings me-sm-1"></i> เพิ่มงาน
        </button>
    </div>

    <!-- Executive Section (No Add/Delete functionality) -->
    <div class="card">
        <div class="card-header">
            <h5>ผู้บริหาร</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($executiveRoles as $v_Manager) : ?>
                    <div class="col-md-4">
                        <label for=""><?= htmlspecialchars($v_Manager->admin_rloes_nanetype) ?></label>
                        <div class="mt-3">
                            <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                                rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                                rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                                Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
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
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Dynamic Department Sections (With Add/Delete functionality) -->
    <?php foreach ($orderedGroupedDepartments as $department => $roles) : ?>
    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><?= htmlspecialchars($department) ?></h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-role-group="<?= htmlspecialchars($department) ?>">
                <i class="bx bx-plus me-sm-1"></i> เพิ่มเจ้าหน้าที่
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($roles as $v_Manager) : ?>
                <div class="col-md-4 mt-2">
                    <label for=""><?php 
                        $SubLevel = explode("/", $v_Manager->admin_rloes_level);
                        echo htmlspecialchars(isset($SubLevel[1]) ? $SubLevel[1] : 'N/A'); 
                    ?></label>
                    <div class="mt-2">
                        <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                            rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                            rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                            Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                            <option value="">เลือกเจ้าหน้าที่</option>
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
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addDepartmentForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDepartmentModalLabel">เพิ่มงานใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">ชื่องาน</label>
                        <input type="text" class="form-control" id="department_name" name="department_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addRoleForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">เพิ่มเจ้าหน้าที่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modalRoleGroup" name="role_group">
                    
                    <div class="mb-3">
                        <label for="modalUserSelect" class="form-label">ผู้ใช้งาน</label>
                        <select class="form-select" id="modalUserSelect" name="user_id" required>
                            <option value="">เลือกผู้ใช้งาน</option>
                            <?php foreach ($NameTeacher as $v_NameTeacher) : ?>
                                <option value="<?=$v_NameTeacher->pers_id?>">
                                    <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Select2 for the modal user selection
    $('#modalUserSelect').select2({
        dropdownParent: $('#addRoleModal'),
        width: '100%'
    });

    // --- Add Department Modal Logic ---
    const addDepartmentModal = document.getElementById('addDepartmentModal');
    const addDepartmentForm = document.getElementById('addDepartmentForm');

    addDepartmentForm.addEventListener('submit', function(event) {
        event.preventDefault();
        console.log('Submitting Add Department form...');
        const formData = new FormData(addDepartmentForm);
        console.log('Department Name:', formData.get('department_name'));
        const modalInstance = bootstrap.Modal.getInstance(addDepartmentModal);
        modalInstance.hide();

        fetch('<?= base_url('Admin/Rloes/AddDepartment') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            console.log('Server response for Add Department:', result);
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: result.msg,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: result.msg
                });
            }
        })
        .catch(error => {
            console.error('Error in Add Department fetch:', error);
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดที่ไม่คาดคิด',
                text: 'กรุณาลองใหม่อีกครั้ง'
            });
        });
    });

    addDepartmentModal.addEventListener('hidden.bs.modal', function (event) {
        addDepartmentForm.reset();
    });


    // --- Add Role Modal Logic ---
    const addRoleModal = document.getElementById('addRoleModal');
    addRoleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const roleGroup = button.getAttribute('data-role-group');
        const modalTitle = addRoleModal.querySelector('.modal-title');
        const roleGroupInput = addRoleModal.querySelector('#modalRoleGroup');
        
        modalTitle.textContent = 'เพิ่มเจ้าหน้าที่สำหรับ ' + roleGroup;
        roleGroupInput.value = roleGroup;

        // Reset form and Select2
        $('#addRoleForm')[0].reset();
        $('#modalUserSelect').val(null).trigger('change');
    });

    const addRoleForm = document.getElementById('addRoleForm');
    addRoleForm.addEventListener('submit', function (event) {
        event.preventDefault();
        console.log('Submitting Add Role form...');
        const formData = new FormData(addRoleForm);
        console.log('Role Group:', formData.get('role_group'));
        console.log('User ID:', formData.get('user_id'));
        // Hardcode the role_level for new staff
        formData.append('role_level', '2/เจ้าหน้าที่');

        const modalInstance = bootstrap.Modal.getInstance(addRoleModal);
        modalInstance.hide();

        fetch('<?= base_url('Admin/Rloes/AddRole') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            console.log('Server response for Add Role:', result);
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: result.msg,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: result.msg
                });
            }
        })
        .catch(error => {
            console.error('Error in Add Role fetch:', error);
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดที่ไม่คาดคิด',
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
            console.log('Attempting to delete role with ID:', selectElement.attr('rloes-id'));

            Swal.fire({
                title: 'ยืนยันการลบ',
                text: "คุณต้องการนำผู้ใช้งานออกจากตำแหน่งนี้ใช่หรือไม่? การดำเนินการนี้จะลบข้อมูลตำแหน่งนี้ออกจากระบบอย่างถาวร",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
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
                            console.log('Server response for Delete Role:', response);
                            if (response.success) {
                                Swal.fire('ลบแล้ว!', response.msg, 'success');
                                selectElement.closest('.col-md-4').fadeOut(500, function() { $(this).remove(); });
                            } else {
                                Swal.fire('เกิดข้อผิดพลาด!', response.msg, 'error');
                                selectElement.val(previousValue).trigger('change.select2');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error in Delete Role AJAX:', textStatus, errorThrown);
                            Swal.fire('เกิดข้อผิดพลาด!', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                            selectElement.val(previousValue).trigger('change.select2');
                        }
                    });
                } else {
                    selectElement.val(previousValue).trigger('change.select2');
                }
            });
        } 
    });
});
</script>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?=base_url()?>/assets/js/Admin/AdminRoles/AdminRolesMain.js?v=3.2"></script>
<?= $this->endSection() ?>
