<?php $isLoggedIn = session()->get('logged_in'); ?>
<?= $this->extend('User/UserLeyout/user_layout') ?>
<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">เมนู /</span> รายงานอาหาร</h4>

    <div class="card">
        <div class="card-header">
            <?php if ($isLoggedIn): ?>
            <div class="dt-action-buttons text-end pt-3 pt-md-0">
                <div class="dt-buttons">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReportModal">
                        <span><i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">เพิ่มรายงานใหม่</span></span>
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table datatables-basic" id="food-reports-table">
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>มื้ออาหาร</th>
                        <th>เมนู</th>
                        <th>รูปภาพ</th>
                        <?php if ($isLoggedIn): ?>
                        <th>พิมพ์</th>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data is loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if ($isLoggedIn): ?>
<!-- Add Report Modal -->
<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addReportModalLabel">เพิ่มรายงานอาหารใหม่</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addReportForm" action="<?= base_url('FoodReport/insert') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="mb-3">
                <label for="food_date" class="form-label">วันที่</label>
                <input type="date" class="form-control" id="food_date" name="food_date" value="<?=date("Y-m-d")?>" required> 
            </div>
            <div class="mb-3">
                <label for="food_meal" class="form-label">มื้ออาหาร</label>
                <select class="form-select" id="food_meal" name="food_meal" required>
                    <option selected disabled value="">เลือกมื้ออาหาร...</option>
                    <option value="มื้อเช้า">มื้อเช้า</option>
                    <option value="มื้อกลางวัน">มื้อกลางวัน</option>
                    <option value="มื้อเย็น">มื้อเย็น</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="food_menu" class="form-label">เมนูอาหาร (คั่นด้วยจุลภาค ,)</label>
                <textarea class="form-control" id="food_menu" name="food_menu" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="food_images" class="form-label">รูปภาพ (เลือกได้หลายรูป)</label>
                <input class="form-control" type="file" id="food_images" name="food_images[]" multiple accept="image/*">
            </div>
            <div id="image-preview" class="mt-3 d-flex flex-wrap gap-3"></div>
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

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if ($isLoggedIn): ?>
<script>
// This is the script for the "Add Report" modal form
document.getElementById('food_images').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = ''; // Clear previous previews
    const files = event.target.files;

    if (files) {
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.style.position = 'relative';
                    imgWrapper.style.width = '150px';
                    imgWrapper.style.height = '150px';
                    imgWrapper.style.border = '2px solid #ddd';
                    imgWrapper.style.borderRadius = '8px';
                    imgWrapper.style.padding = '5px';
                    imgWrapper.style.overflow = 'hidden';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    
                    imgWrapper.appendChild(img);
                    previewContainer.appendChild(imgWrapper);
                };
                
                reader.readAsDataURL(file);
            }
        });
    }
});

// Clear file input and preview when modal is closed
const addReportModal = document.getElementById('addReportModal');
addReportModal.addEventListener('hidden.bs.modal', function () {
    document.getElementById('addReportForm').reset();
    document.getElementById('image-preview').innerHTML = '';
});

// Handle form submission via AJAX
document.getElementById('addReportForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    const form = event.target;
    const formData = new FormData(form);
    const url = form.action; // Get the form action URL

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('บันทึกข้อมูลสำเร็จ!');
            const addReportModalInstance = bootstrap.Modal.getInstance(document.getElementById('addReportModal'));
            addReportModalInstance.hide();
            // Reload DataTable instead of the whole page
            $('#food-reports-table').DataTable().ajax.reload();
        } else {
            alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error.message);
    });
});
</script>
<?php endif; ?>

<script>
$(document).ready(function() {
    const sftp_partweb = '<?= $sftp_partweb ?? '' ?>';
    const sftp_partfullweb = '<?= $sftp_partfullweb ?? '' ?>';
    const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

    let columns = [
        { 
            "data": "food_date", 
            "render": function(data) {
                if (!data) return '';
                var date = new Date(data);
                var day = ('0' + date.getDate()).slice(-2);
                var month = ('0' + (date.getMonth() + 1)).slice(-2);
                var year = date.getFullYear();
                return day + '/' + month + '/' + year;
            }
        },
        { "data": "food_meal" },
        { "data": "food_menu" },
        { 
            "data": "food_images", 
            "render": function(data, type, row) {
                let images;
                try {
                    images = (data && typeof data === 'string') ? JSON.parse(data) : [];
                } catch (e) {
                    console.error('Error parsing food_images JSON:', e, 'Raw data:', data);
                    images = [];
                }
                
                let html = '';
                if (Array.isArray(images) && images.length > 0) {
                    images.forEach(function(image) {
                        let originalUrl = `http://${sftp_partweb}${sftp_partfullweb}${row.food_date}/${image}`;
                        let proxyUrl = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(originalUrl)}`;
                        html += `<img src="${proxyUrl}" alt="Food Image" width="100" class="me-2 mb-2 img-thumbnail">`;
                    });
                }
                return html;
            },
            "orderable": false,
            "searchable": false
        }
    ];

    if (isLoggedIn) {
        columns.push({
            "data": "food_id",
            "render": function(data, type, row) {
                let printUrl = `<?= base_url('FoodReport/print/') ?>${data}`;
                return `<a href="${printUrl}" target="_blank" class="btn btn-sm btn-info"><i class="bx bx-printer me-1"></i> พิมพ์</a>`;
            },
            "orderable": false, "searchable": false
        });
        columns.push({
            "data": "food_id",
            "render": function(data, type, row) {
                return `<div class="d-inline-block">
                                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;" class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> แก้ไข</a>
                                    <a href="javascript:;" class="dropdown-item text-danger"><i class="bx bx-trash me-1"></i> ลบ</a>
                                </div>
                            </div>`;
            },
            "orderable": false, "searchable": false
        });
    }

    $('#food-reports-table').DataTable({
        "ajax": {
            "url": "<?= base_url('FoodReport/getFoodReportsJson') ?>",
            "error": function (xhr, error, thrown) {
                alert('เกิดข้อผิดพลาดในการโหลดข้อมูลตาราง โปรดลองอีกครั้ง');
                console.error('DataTables AJAX error:', error, thrown);
            }
        },
        "columns": columns,
        "order": [[ 0, "desc" ]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Thai.json"
        }
    });
});
</script>
<?= $this->endSection() ?>