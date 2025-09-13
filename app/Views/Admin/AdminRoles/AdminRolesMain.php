<?= $this->extend('Admin/AdminLeyout/admin_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"></span> กำหนดสิทธิ์ใช้งานในระบบบริหารทั่วไป
    </h4>
    <div class="card">
        <div class="card-header">
            <h5>ผู้บริหาร</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($Manager as $key => $v_Manager) : ?>
                <?php if($v_Manager->admin_rloes_status ==="ManagerGeneral" || $v_Manager->admin_rloes_status === "ExecutiveGeneral"): ?>
                <div class="col-md-4">
                    <label for=""><?php echo $v_Manager->admin_rloes_nanetype;?></label>
                    <div class="mt-3">
                        <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                            rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                            rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                            Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                            <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option
                                <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                value="<?=$v_NameTeacher->pers_id?>">
                                <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>งานอาคารสถานที่</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-role-group="งานอาคารสถานที่">
                <i class="bx bx-plus me-sm-1"></i> เพิ่มเจ้าหน้าที่
            </button>
        </div>
        <div class="card-body">
            <div class="row">

                <?php foreach ($Manager as $key => $v_Manager) : ?>
                <?php if($v_Manager->admin_rloes_nanetype === "งานอาคารสถานที่"): ?>

                <div class="col-md-4 mt-2">
                    <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                    echo $SubLevel[1]; ?></label>
                    <div class="mt-2">
                        <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                            rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                            rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                            Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                            <option value="">เลือกเจ้าหน้าที่</option>
                            <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option
                                <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                value="<?=$v_NameTeacher->pers_id?>">
                                <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>งานธุรการ</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-role-group="งานธุรการ">
                <i class="bx bx-plus me-sm-1"></i> เพิ่มเจ้าหน้าที่
            </button>
        </div>
        <div class="card-body">
            <div class="row">

                <?php foreach ($Manager as $key => $v_Manager) : ?>
                <?php if($v_Manager->admin_rloes_nanetype === "งานธุรการ"): ?>

                <div class="col-md-4 mt-2">
                    <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                    echo $SubLevel[1]; ?></label>
                    <div class="mt-2">
                        <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                            rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                            rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                            Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                            <option value="">เลือกเจ้าหน้าที่</option>
                            <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option
                                <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                value="<?=$v_NameTeacher->pers_id?>">
                                <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>งานยานพาหนะ</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-role-group="งานยานพาหนะ">
                <i class="bx bx-plus me-sm-1"></i> เพิ่มเจ้าหน้าที่
            </button>
        </div>
        <div class="card-body">
            <div class="row">

                <?php foreach ($Manager as $key => $v_Manager) : ?>
                <?php if($v_Manager->admin_rloes_nanetype === "งานยานพาหนะ"): ?>

                <div class="col-md-4 mt-2">
                    <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                    echo $SubLevel[1]; ?></label>
                    <div class="mt-2">
                        <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                            rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                            rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                            Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                            <option value="">เลือกเจ้าหน้าที่</option>
                            <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option
                                <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                value="<?=$v_NameTeacher->pers_id?>">
                                <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>งานแจ้งซ่อม</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-role-group="งานแจ้งซ่อม">
                <i class="bx bx-plus me-sm-1"></i> เพิ่มเจ้าหน้าที่
            </button>
        </div>
        <div class="card-body">
            <div class="row">

                <?php foreach ($Manager as $key => $v_Manager) : ?>
                <?php if($v_Manager->admin_rloes_nanetype === "งานแจ้งซ่อม"): ?>

                <div class="col-md-4 mt-2">
                    <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                    echo $SubLevel[1]; ?></label>
                    <div class="mt-2">
                        <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                            rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                            rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                            Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                            <option value="">เลือกเจ้าหน้าที่</option>
                            <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option
                                <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                value="<?=$v_NameTeacher->pers_id?>">
                                <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>งานบุคลากร</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-role-group="งานบุคลากร">
                <i class="bx bx-plus me-sm-1"></i> เพิ่มเจ้าหน้าที่
            </button>
        </div>
        <div class="card-body">
            <div class="row">

                <?php foreach ($Manager as $key => $v_Manager) : ?>
                <?php if($v_Manager->admin_rloes_nanetype === "งานบุคลากร"): ?>

                <div class="col-md-4 mt-2">
                    <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                    echo $SubLevel[1]; ?></label>
                    <div class="mt-2">
                        <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                            rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                            rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                            Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                            <option value="">เลือกเจ้าหน้าที่</option>
                            <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                            <option
                                <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                value="<?=$v_NameTeacher->pers_id?>">
                                <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <?php endif; ?>
                <?php endforeach; ?>
            </div>
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
                            <?php foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
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
    const addRoleModal = document.getElementById('addRoleModal');
    addRoleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const roleGroup = button.getAttribute('data-role-group');
        const modalTitle = addRoleModal.querySelector('.modal-title');
        const roleGroupInput = addRoleModal.querySelector('#modalRoleGroup');
        
        modalTitle.textContent = 'เพิ่มเจ้าหน้าที่สำหรับ ' + roleGroup;
        roleGroupInput.value = roleGroup;
    });

    const addRoleForm = document.getElementById('addRoleForm');
    addRoleForm.addEventListener('submit', function (event) {
        event.preventDefault();

        // Hide the modal
        $('#addRoleModal').modal('hide');
        
        const formData = new FormData(addRoleForm);
        // Hardcode the role_level as requested
        formData.append('role_level', '2/เจ้าหน้าที่');

        fetch('<?= base_url('Admin/Rloes/AddRole') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
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
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดที่ไม่คาดคิด',
                text: 'กรุณาลองใหม่อีกครั้ง'
            });
        });
    });

    $('#modalUserSelect').select2({
            dropdownParent: $('#addRoleModal'),
            width: '100%'
        });

    // Handle role deletion
    let previousValue;
    $('.SettingGeneralRloes').on('focus', function () {
        previousValue = $(this).val();
    });

    $('.SettingGeneralRloes').on('change', function (e) {
        const selectElement = $(this);
        if (selectElement.val() === "") {
            // Stop the original update script from running
            e.preventDefault();
            e.stopImmediatePropagation();

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
                        data: {
                            rloes_id: selectElement.attr('rloes-id')
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('ลบแล้ว!', response.msg, 'success');
                                selectElement.closest('.col-md-4').fadeOut(500, function() { $(this).remove(); });
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
        }
    });
});
</script>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?=base_url()?>/assets/js/Admin/AdminRoles/AdminRolesMain.js?v=3.2"></script>
<?= $this->endSection() ?>