<?php $isLoggedIn = session()->get('logged_in'); ?>
<?= $this->extend('User/UserLayout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <h4 class="py-3 mb-0">
            <span class="text-muted fw-light">เมนู /</span> รายงานอาหาร
        </h4>
        <div>
            <?php if ($isLoggedIn && in_array('งานรายงานอาหาร', explode(',', session()->get('rloes')))): ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReportModal">
                <i class="bx bx-plus me-1"></i>เพิ่มรายงานใหม่
            </button>
            <?php elseif (!$isLoggedIn): ?>
            <a href="<?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>" class="btn btn-success">
                <i class="bx bx-log-in me-1"></i>เข้าสู่ระบบ สำหรับผู้บันทึก
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">ข้อมูลรายงานอาหาร</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table table-hover nowrap" style="width:100%" id="food-reports-table">
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>มื้ออาหาร</th>
                        <th>เมนู</th>
                        <th>รูปภาพ</th>
                        <?php if ($isLoggedIn && in_array('งานรายงานอาหาร', explode(',', session()->get('rloes')))): ?>
                        <th>ผู้บันทึก</th>
                        <th>พิมพ์</th>
                        <th>Actions</th>
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
<div class="modal fade" id="addReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReportModalLabel">เพิ่มรายงานอาหารใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addReportForm" action="<?= base_url('FoodReport/insert') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" id="food_id" name="food_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">วันที่</label>
                            <input type="date" class="form-control" id="food_date" name="food_date" value="<?=date("Y-m-d")?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">มื้ออาหาร</label>
                            <select class="form-select" id="food_meal" name="food_meal" required>
                                <option selected disabled value="">เลือกมื้ออาหาร...</option>
                                <option value="มื้อเช้า">มื้อเช้า</option>
                                <option value="มื้อกลางวัน">มื้อกลางวัน</option>
                                <option value="มื้อเย็น">มื้อเย็น</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">เมนูอาหาร (คั่นด้วยจุลภาค ,)</label>
                            <textarea class="form-control" id="food_menu" name="food_menu" rows="3" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">รูปภาพ (เลือกได้หลายรูป)</label>
                            <input class="form-control" type="file" id="food_images" name="food_images[]" multiple accept="image/*">
                        </div>
                        <div class="col-12">
                            <div id="image-preview" class="d-flex flex-wrap gap-3 mt-2"></div>
                        </div>
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
<?php endif; ?>

<!-- Image Viewer Modal -->
<div class="modal fade" id="imageViewerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รูปภาพประกอบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="image-gallery-in-modal" class="d-flex flex-wrap gap-3 justify-content-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
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
                wrapper.style.cssText = 'width:120px;height:120px;border:2px solid #ddd;border-radius:8px;padding:5px;overflow:hidden;';
                wrapper.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        }
    });
});

document.getElementById('addReportModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('addReportForm').reset();
    document.getElementById('image-preview').innerHTML = '';
});

document.getElementById('addReportForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const originalHtml = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> กำลังบันทึก...';

    fetch(form.action, { method: 'POST', body: new FormData(form) })
        .then(r => r.json())
        .then(data => {
            submitButton.disabled = false;
            submitButton.innerHTML = originalHtml;
            if (data.status === 'success') {
                bootstrap.Modal.getInstance(document.getElementById('addReportModal')).hide();
                Swal.fire({ icon: 'success', title: 'บันทึกสำเร็จ!' }).then(() => $('#food-reports-table').DataTable().ajax.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด!', text: data.message });
            }
        })
        .catch(error => {
            submitButton.disabled = false;
            submitButton.innerHTML = originalHtml;
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
    preview.innerHTML = '';

    if (button && button.classList.contains('item-edit')) {
        const foodId = button.getAttribute('data-id');
        modalTitle.textContent = 'แก้ไขรายงานอาหาร';
        form.action = '<?= base_url('FoodReport/update') ?>';
        foodIdInput.value = foodId;
        fetch(`<?= base_url('FoodReport/getReportById/') ?>${foodId}`)
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success' && data.report) {
                    document.getElementById('food_date').value = data.report.food_date;
                    document.getElementById('food_meal').value = data.report.food_meal;
                    document.getElementById('food_menu').value = data.report.food_menu;
                    let images = [];
                    try { images = JSON.parse(data.report.food_images) || []; } catch (e) {}
                    images.forEach(img => {
                        const url = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(`<?=env('upload.server.baseurl')?>${data.report.food_date}/${img}`)}`;
                        const wrapper = document.createElement('div');
                        wrapper.style.cssText = 'width:120px;height:120px;border:2px solid #ddd;border-radius:8px;padding:5px;overflow:hidden;';
                        wrapper.innerHTML = `<img src="${url}" style="width:100%;height:100%;object-fit:cover;">`;
                        preview.appendChild(wrapper);
                    });
                }
            });
    } else {
        modalTitle.textContent = 'เพิ่มรายงานอาหารใหม่';
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
    const loggedInUserId = '<?= session()->get('id') ?? '' ?>';

    let columns = [
        { "data": "food_date", "render": d => d ? new Date(d).toLocaleDateString('th-TH') : '' },
        { "data": "food_meal" },
        { "data": "food_menu" },
        {
            "data": "food_images",
            "render": function(data, type, row) {
                let images = [];
                try { images = JSON.parse(data) || []; } catch (e) {}
                return images.length > 0 
                    ? `<button class="btn btn-sm btn-outline-primary view-images-btn" data-bs-toggle="modal" data-bs-target="#imageViewerModal" data-images='${data}' data-food-date="${row.food_date}"><i class="bx bx-images"></i> ดูรูป (${images.length})</button>`
                    : 'ไม่มีรูปภาพ';
            },
            "orderable": false
        }
    ];

    if (isLoggedIn) {
        columns.push({ "data": "recorder_full_name", "render": d => d || 'N/A' });
        columns.push({
            "data": "food_id",
            "render": d => `<a href="<?= base_url('FoodReport/print/') ?>${d}" target="_blank" class="btn btn-sm btn-info"><i class="bx bx-printer"></i> พิมพ์</a>`,
            "orderable": false
        });
        columns.push({
            "data": "food_id",
            "render": function(data, type, row) {
                if (row.food_admin == loggedInUserId) {
                    return `<a href="#" class="btn btn-sm btn-icon item-edit" data-bs-toggle="modal" data-bs-target="#addReportModal" data-id="${data}"><i class="bx bx-edit-alt"></i></a>
                            <button class="btn btn-sm btn-icon delete-btn" data-id="${data}"><i class="bx bx-trash"></i></button>`;
                }
                return `<button class="btn btn-sm btn-icon permission-denied"><i class="bx bx-edit-alt"></i></button>
                        <button class="btn btn-sm btn-icon permission-denied"><i class="bx bx-trash"></i></button>`;
            },
            "orderable": false
        });
    }

    $('#food-reports-table').DataTable({
        "responsive": true,
        "ajax": { "url": "<?= base_url('FoodReport/getFoodReportsJson') ?>" },
        "columns": columns,
        "order": [[0, "desc"]],
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Thai.json" }
    });

    $('#food-reports-table tbody').on('click', '.permission-denied', function() {
        Swal.fire({ icon: 'warning', title: 'ไม่ได้รับอนุญาต', text: 'คุณสามารถแก้ไข/ลบได้เฉพาะรายงานที่คุณสร้างเท่านั้น' });
    });

    $('#food-reports-table tbody').on('click', '.delete-btn', function() {
        const foodId = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบ', icon: 'warning', showCancelButton: true,
            confirmButtonText: 'ลบ', cancelButtonText: 'ยกเลิก'
        }).then(result => {
            if (result.isConfirmed) {
                $.post('<?= base_url('FoodReport/delete') ?>', { id: foodId }, function(r) {
                    if (r.status === 'success') {
                        Swal.fire('ลบสำเร็จ!', '', 'success').then(() => $('#food-reports-table').DataTable().ajax.reload());
                    } else {
                        Swal.fire('เกิดข้อผิดพลาด!', r.message, 'error');
                    }
                }, 'json');
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
        images.forEach(img => {
            const url = `<?=env('upload.server.baseurl')?>${foodDate}/${img}`;
            const proxy = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(url)}`;
            gallery.innerHTML += `<a href="${url}" target="_blank"><img src="${proxy}" class="img-thumbnail" style="max-width:200px;max-height:200px;"></a>`;
        });
        if (!images.length) gallery.innerHTML = '<p>ไม่พบรูปภาพ</p>';
    });
});
</script>
<?= $this->endSection() ?>
