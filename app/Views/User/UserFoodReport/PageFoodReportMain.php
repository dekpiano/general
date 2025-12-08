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
<div class="modal fade" id="addReportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-primary" id="addReportModalLabel"><i class="bx bx-plus-circle me-2"></i>เพิ่มรายงานอาหารใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addReportForm" action="<?= base_url('FoodReport/insert') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" id="food_id" name="food_id">
                <div class="modal-body pt-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="food_date" name="food_date" value="<?=date("Y-m-d")?>" required placeholder="เลือกวันที่">
                                <label for="food_date">วันที่</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="food_meal" name="food_meal" required>
                                    <option selected disabled value="">เลือกมื้ออาหาร...</option>
                                    <option value="มื้อเช้า">มื้อเช้า</option>
                                    <option value="มื้อกลางวัน">มื้อกลางวัน</option>
                                    <option value="มื้อเย็น">มื้อเย็น</option>
                                </select>
                                <label for="food_meal">มื้ออาหาร</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="food_menu" name="food_menu" style="height: 100px" required placeholder="ระบุรายชื่อเมนูอาหาร"></textarea>
                                <label for="food_menu">เมนูอาหาร (คั่นด้วยจุลภาค ,)</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted mb-2"><i class="bx bx-images me-1"></i>รูปภาพ (เลือกได้หลายรูป)</label>
                            <input class="form-control" type="file" id="food_images" name="food_images[]" multiple accept="image/*">
                            <div class="form-text">รองรับไฟล์รูปภาพ .jpg, .png, .jpeg</div>
                        </div>
                        <div class="col-12">
                            <div id="image-preview" class="d-flex flex-wrap gap-3 mt-2 p-3 bg-light rounded-3 border border-dashed text-center justify-content-center" style="min-height: 150px; align-items: center;">
                                <span class="text-muted small">ตัวอย่างรูปภาพจะแสดงที่นี่</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="bx bx-save me-1"></i> บันทึกข้อมูล</button>
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
                wrapper.style.cssText = 'width:120px;height:120px;border:2px solid #ddd;border-radius:12px;padding:4px;overflow:hidden;box-shadow:0 4px 6px rgba(0,0,0,0.1);background:#fff;';
                wrapper.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">`;
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        }
    });
});

document.getElementById('addReportModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('addReportForm').reset();
    document.getElementById('image-preview').innerHTML = '';
    // Reset any validation states if you add them later
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
                    return formatThaiDate(data);
                }
                return data;
            }
        },
        { "data": "food_meal" },
        { 
            "data": "food_menu",
            "render": function(data) {
                return data ? (data.length > 50 ? data.substring(0, 50) + '...' : data) : '';
            }
        },
        {
            "data": "food_images",
            "render": function(data, type, row) {
                let images = [];
                try { images = JSON.parse(data) || []; } catch (e) {}
                return images.length > 0 
                    ? `<button class="btn btn-sm btn-outline-primary view-images-btn rounded-pill" data-bs-toggle="modal" data-bs-target="#imageViewerModal" data-images='${data}' data-food-date="${row.food_date}"><i class="bx bx-images me-1"></i> ดูรูป (${images.length})</button>`
                    : '<span class="text-muted small">ไม่มีรูปภาพ</span>';
            },
            "orderable": false
        }
    ];

    if (isLoggedIn) {
        columns.push({ "data": "recorder_full_name", "render": d => d || '<span class="text-muted">ไม่ระบุ</span>' });
        columns.push({
            "data": "food_id",
            "render": d => `<a href="<?= base_url('FoodReport/print/') ?>${d}" target="_blank" class="btn btn-sm btn-label-info rounded-pill"><i class="bx bx-printer me-1"></i> พิมพ์</a>`,
            "orderable": false
        });
        columns.push({
            "data": "food_id",
            "render": function(data, type, row) {
                if (row.food_admin == loggedInUserId) {
                    return `<div class="d-inline-flex gap-1">
                                <a href="#" class="btn btn-sm btn-icon btn-label-warning item-edit" data-bs-toggle="modal" data-bs-target="#addReportModal" data-id="${data}"><i class="bx bx-edit-alt"></i></a>
                                <button class="btn btn-sm btn-icon btn-label-danger delete-btn" data-id="${data}"><i class="bx bx-trash"></i></button>
                            </div>`;
                }
                return `<div class="d-inline-flex gap-1">
                            <button class="btn btn-sm btn-icon btn-secondary disabled" title="ไม่มีสิทธิ์แก้ไข"><i class="bx bx-edit-alt"></i></button>
                            <button class="btn btn-sm btn-icon btn-secondary disabled" title="ไม่มีสิทธิ์ลบ"><i class="bx bx-trash"></i></button>
                        </div>`;
            },
            "orderable": false
        });
    }

    $('#food-reports-table').DataTable({
        "responsive": true,
        "ajax": { "url": "<?= base_url('FoodReport/getFoodReportsJson') ?>" },
        "columns": columns,
        "order": [[0, "desc"]],
        "language": {
            "search": "ค้นหา:",
            "lengthMenu": "แสดง _MENU_ รายการ",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "paginate": { "first": "หน้าแรก", "last": "หน้าสุดท้าย", "next": "ถัดไป", "previous": "ก่อนหน้า" },
            "emptyTable": "ไม่พบข้อมูลรายการอาหาร"
        }
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
                        Swal.fire({ icon: 'success', title: 'ลบสำเร็จ!', showConfirmButton: false, timer: 1500 });
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
            wrapper.style.cssText = "width:200px; height:200px; transition: transform 0.2s;";
            wrapper.innerHTML = `<img src="${proxy}" class="w-100 h-100 object-fit-cover" 
                                      onerror="this.src='https://via.placeholder.com/200x200?text=Error'">`;
            wrapper.onmouseover = () => wrapper.style.transform = "scale(1.05)";
            wrapper.onmouseout = () => wrapper.style.transform = "scale(1)";
            gallery.appendChild(wrapper);
        });
    });
});
</script>
<?= $this->endSection() ?>
