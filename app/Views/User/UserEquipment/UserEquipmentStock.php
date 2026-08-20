<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    .eq-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 0.5rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <span class="text-muted fw-light">ยืม-คืนพัสดุ /</span> ทะเบียนและสต็อกพัสดุ (สำหรับเจ้าหน้าที่)
            </h4>
            <p class="text-muted mb-0">จัดการรายการพัสดุ หมวดหมู่ และจำนวนสต็อกคงเหลือ</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalCategory">
                <i class="bx bx-folder-plus me-1"></i> จัดการหมวดหมู่
            </button>
            <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" onclick="openAddModal()">
                <i class="bx bx-plus me-1"></i> เพิ่มพัสดุใหม่
            </button>
            <a href="<?= base_url('Equipment/Approve') ?>" class="btn btn-outline-primary rounded-pill px-3">
                <i class="bx bx-check-shield me-1"></i> รายการอนุมัติ
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="<?= base_url('Equipment/Manage') ?>" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <select name="category" class="form-select rounded-pill" onchange="this.form.submit()">
                        <option value="all">-- หมวดหมู่ทั้งหมด --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['category_id'] ?>" <?= ($selectedCategory == $cat['category_id']) ? 'selected' : '' ?>>
                                <?= esc($cat['category_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control rounded-pill" placeholder="ค้นหาชื่อพัสดุ, รหัส, หมายเลขเครื่อง..." value="<?= esc($search ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary rounded-pill w-100">ค้นหา</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">รูปภาพ</th>
                        <th>รหัส / ชื่อพัสดุอุปกรณ์</th>
                        <th>หมวดหมู่</th>
                        <th class="text-center">สต็อกทั้งหมด</th>
                        <th class="text-center">คงเหลือ (พร้อมยืม)</th>
                        <th>สถานะ</th>
                        <th class="text-center pe-4">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($equipments)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bx bx-package fs-1 mb-2"></i>
                                <p class="mb-0">ยังไม่มีรายการพัสดุในระบบ</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($equipments as $eq): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <?php 
                                        $imgUrl = 'https://cdn-icons-png.flaticon.com/512/2897/2897785.png';
                                        if (!empty($eq['eq_image'])) {
                                            $imgUrl = \App\Libraries\RemoteUploadService::getUrl($eq['eq_image'], 'Equipment/items');
                                        }
                                        ?>
                                        <img src="<?= $imgUrl ?>" class="eq-thumb shadow-sm" alt="<?= esc($eq['eq_name']) ?>" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2897/2897785.png'">
                                    </div>
                                </td>
                                <td>
                                    <span class="font-monospace text-muted small"><?= esc($eq['eq_code']) ?></span>
                                    <div class="fw-bold text-dark"><?= esc($eq['eq_name']) ?></div>
                                    <small class="text-muted"><?= esc($eq['eq_brand_model']) ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-label-secondary rounded-pill">
                                        <?= esc($eq['category_name']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-dark"><?= $eq['total_qty'] ?></span> <?= esc($eq['eq_unit']) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($eq['available_qty'] > 0): ?>
                                        <span class="badge bg-success rounded-pill px-3"><?= $eq['available_qty'] ?> <?= esc($eq['eq_unit']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger rounded-pill px-3">0 <?= esc($eq['eq_unit']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    if ($eq['eq_status'] === 'active') {
                                        echo '<span class="badge bg-label-success">พร้อมใช้งาน</span>';
                                    } elseif ($eq['eq_status'] === 'maintenance') {
                                        echo '<span class="badge bg-label-warning">ส่งซ่อม/บำรุง</span>';
                                    } else {
                                        echo '<span class="badge bg-label-danger">จำหน่ายออก/เลิกใช้</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center pe-4">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-circle me-1" onclick="openEditModal(<?= htmlspecialchars(json_encode($eq)) ?>)">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="deleteEquipment(<?= $eq['eq_id'] ?>, '<?= esc($eq['eq_name']) ?>')">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal เพิ่ม/แก้ไข พัสดุ -->
<div class="modal fade" id="modalEquipment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form id="formEquipment" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="eq_id" id="modal_eq_id">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white fw-bold" id="modalEquipmentTitle"><i class="bx bx-plus-circle me-2"></i>เพิ่มพัสดุอุปกรณ์</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">ชื่อพัสดุอุปกรณ์ <span class="text-danger">*</span></label>
                            <input type="text" name="eq_name" id="modal_eq_name" class="form-control rounded-3" required placeholder="เช่น โปรเจคเตอร์ EPSON, สว่านไฟฟ้า">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">หมวดหมู่ <span class="text-danger">*</span></label>
                            <select name="category_id" id="modal_category_id" class="form-select rounded-3" required>
                                <option value="">-- เลือกหมวดหมู่ --</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['category_id'] ?>"><?= esc($cat['category_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">รหัสพัสดุ / หมายเลขครุภัณฑ์</label>
                            <input type="text" name="eq_code" id="modal_eq_code" class="form-control rounded-3" placeholder="เช่น EQ-ICT-001">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">ยี่ห้อ / รุ่น</label>
                            <input type="text" name="eq_brand_model" id="modal_eq_brand_model" class="form-control rounded-3" placeholder="เช่น Sony, Bosch">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">หมายเลขเครื่อง / Serial</label>
                            <input type="text" name="eq_serial" id="modal_eq_serial" class="form-control rounded-3" placeholder="Serial Number">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">จำนวนทั้งหมด <span class="text-danger">*</span></label>
                            <input type="number" name="total_qty" id="modal_total_qty" class="form-control rounded-3" value="1" min="1" required>
                        </div>
                        <div class="col-md-4" id="divAvailableQty" style="display: none;">
                            <label class="form-label fw-semibold">คงเหลือ (พร้อมยืม)</label>
                            <input type="number" name="available_qty" id="modal_available_qty" class="form-control rounded-3" value="1" min="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">หน่วยนับ</label>
                            <input type="text" name="eq_unit" id="modal_eq_unit" class="form-control rounded-3" value="ชิ้น" placeholder="เช่น ชิ้น, ตัว, ชุด, กล่อง">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">สถานที่จัดเก็บ</label>
                            <input type="text" name="eq_location" id="modal_eq_location" class="form-control rounded-3" placeholder="เช่น ห้องโสตทัศน์, ตู้พัสดุ 2">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">สถานะการใช้งาน</label>
                            <select name="eq_status" id="modal_eq_status" class="form-select rounded-3">
                                <option value="active">พร้อมใช้งาน (Active)</option>
                                <option value="maintenance">กำลังส่งซ่อม (Maintenance)</option>
                                <option value="retired">เลิกใช้งาน/จำหน่าย (Retired)</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">รูปภาพพัสดุ</label>
                            <input type="file" name="eq_image" class="form-control rounded-3" accept="image/*">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">รายละเอียดเพิ่มเติม / คุณสมบัติ</label>
                            <textarea name="eq_detail" id="modal_eq_detail" class="form-control rounded-3" rows="2" placeholder="ระบุรายละเอียดเพิ่มเติมของอุปกรณ์"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="btnSubmitEquipment">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal จัดการหมวดหมู่ -->
<div class="modal fade" id="modalCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form id="formCategory">
                <?= csrf_field() ?>
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title text-white fw-bold"><i class="bx bx-category me-2"></i>จัดการหมวดหมู่พัสดุ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ชื่อหมวดหมู่ใหม่ <span class="text-danger">*</span></label>
                        <input type="text" name="category_name" class="form-control rounded-3" required placeholder="เช่น อุปกรณ์ไอที, เครื่องเสียง">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ไอคอน (Boxicons)</label>
                        <input type="text" name="category_icon" class="form-control rounded-3" value="bx-box" placeholder="เช่น bx-camera, bx-wrench">
                    </div>
                    <button type="submit" class="btn btn-primary rounded-pill w-100 mb-4">เพิ่มหมวดหมู่นี้</button>

                    <h6 class="fw-bold mb-2">หมวดหมู่ที่มีอยู่ในระบบ:</h6>
                    <ul class="list-group">
                        <?php foreach ($categories as $cat): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div><i class="bx <?= $cat['category_icon'] ?: 'bx-box' ?> me-2"></i><?= esc($cat['category_name']) ?></div>
                                <span class="badge bg-label-primary rounded-pill"><?= $cat['category_status'] ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('customJS') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const modalEquipment = new bootstrap.Modal(document.getElementById('modalEquipment'));

    function openAddModal() {
        document.getElementById('formEquipment').reset();
        document.getElementById('modal_eq_id').value = '';
        document.getElementById('modalEquipmentTitle').innerHTML = '<i class="bx bx-plus-circle me-2"></i>เพิ่มพัสดุอุปกรณ์';
        document.getElementById('divAvailableQty').style.display = 'none';
        modalEquipment.show();
    }

    function openEditModal(eq) {
        document.getElementById('formEquipment').reset();
        document.getElementById('modal_eq_id').value = eq.eq_id;
        document.getElementById('modal_eq_name').value = eq.eq_name;
        document.getElementById('modal_category_id').value = eq.category_id;
        document.getElementById('modal_eq_code').value = eq.eq_code;
        document.getElementById('modal_eq_brand_model').value = eq.eq_brand_model || '';
        document.getElementById('modal_eq_serial').value = eq.eq_serial || '';
        document.getElementById('modal_total_qty').value = eq.total_qty;
        document.getElementById('modal_available_qty').value = eq.available_qty;
        document.getElementById('modal_eq_unit').value = eq.eq_unit;
        document.getElementById('modal_eq_location').value = eq.eq_location || '';
        document.getElementById('modal_eq_status').value = eq.eq_status;
        document.getElementById('modal_eq_detail').value = eq.eq_detail || '';

        document.getElementById('modalEquipmentTitle').innerHTML = '<i class="bx bx-edit me-2"></i>แก้ไขพัสดุอุปกรณ์';
        document.getElementById('divAvailableQty').style.display = 'block';
        modalEquipment.show();
    }

    document.getElementById('formEquipment').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const eqId = document.getElementById('modal_eq_id').value;
        const url = eqId ? '<?= base_url('Admin/Equipment/updateEquipment') ?>' : '<?= base_url('Admin/Equipment/insertEquipment') ?>';

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                modalEquipment.hide();
                Swal.fire('สำเร็จ', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
            }
        });
    });

    document.getElementById('formCategory').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('<?= base_url('Admin/Equipment/saveCategory') ?>', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire('สำเร็จ', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
            }
        });
    });

    function deleteEquipment(eqId, name) {
        Swal.fire({
            title: `ลบพัสดุ "${name}"?`,
            text: 'คุณแน่ใจหรือไม่ว่าต้องการลบรายการพัสดุนี้',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('<?= base_url('Admin/Equipment/deleteEquipment') ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'eq_id=' + eqId + '&<?= csrf_token() ?>=<?= csrf_hash() ?>'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('สำเร็จ', data.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด', data.message, 'error');
                    }
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>
