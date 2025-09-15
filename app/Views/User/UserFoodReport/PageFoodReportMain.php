<?php $isLoggedIn = session()->get('logged_in'); ?>
<?= $this->extend('User/UserLeyout/user_layout') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">เมนู /</span> รายงานอาหาร</h4>

    <div class="card p-3">
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
            <table class="table datatables-basic nowrap" style="width:100%" id="food-reports-table">
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

<!-- Image Viewer Modal -->
<div class="modal fade" id="imageViewerModal" tabindex="-1" aria-labelledby="imageViewerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageViewerModalLabel">รูปภาพประกอบ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="image-gallery-in-modal" class="d-flex flex-wrap gap-3 justify-content-center">
          <!-- Images will be loaded here dynamically -->
        </div>
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
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonHtml = submitButton.innerHTML;

    // Disable button and show loader
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กำลังบันทึก...';

    const formData = new FormData(form);
    const url = form.action;

    console.log('Submitting to URL:', url); // Check the URL value

    const restoreButton = () => {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonHtml;
    };

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        restoreButton(); // Restore button on success/error
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                const addReportModalInstance = bootstrap.Modal.getInstance(document.getElementById('addReportModal'));
                addReportModalInstance.hide();
                $('#food-reports-table').DataTable().ajax.reload();
            });
        } else {
            console.error('Server error:', data); // Log the full error data
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' + data.message
            });
        }
    })
    .catch(error => {
        restoreButton(); // Restore button on failure
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด!',
            text: 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error.message
        });
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
                    images = [];
                }

                if (Array.isArray(images) && images.length > 0) {
                    return `<button type="button" class="btn btn-sm btn-outline-primary view-images-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#imageViewerModal"
                                    data-images='${data}'
                                    data-food-date="${row.food_date}">
                                <i class="bx bx-images me-1"></i> ดูรูปภาพ (${images.length})
                            </button>`;
                }
                return 'ไม่มีรูปภาพ';
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
                                    <a href="javascript:;" class="dropdown-item text-danger delete-btn" data-id="${data}"><i class="bx bx-trash me-1"></i> ลบ</a>
                                </div>
                            </div>`;
            },
            "orderable": false, "searchable": false
        });
    }

    $('#food-reports-table').DataTable({
        "responsive": true,
        "ajax": {
            "url": "<?= base_url('FoodReport/getFoodReportsJson') ?>",
            "error": function (xhr, error, thrown) {
                Swal.fire(
                    'เกิดข้อผิดพลาด!',
                    'เกิดข้อผิดพลาดในการโหลดข้อมูลตาราง โปรดลองอีกครั้ง',
                    'error'
                );
                console.error('DataTables AJAX error:', error, thrown);
            }
        },
        "columns": columns,
        "order": [[ 0, "desc" ]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Thai.json"
        }
    });

    // Handle delete button click
    $('#food-reports-table tbody').on('click', '.delete-btn', function() {
        const foodId = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบ',
            text: "คุณแน่ใจหรือไม่ว่าต้องการลบรายงานนี้? การกระทำนี้ไม่สามารถย้อนกลับได้",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังลบข้อมูล...',
                    text: 'กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: `<?= base_url('FoodReport/delete') ?>`,
                    type: 'POST',
                    data: { id: foodId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'ลบสำเร็จ!',
                                'รายงานของคุณถูกลบเรียบร้อยแล้ว',
                                'success'
                            ).then(() => {
                                $('#food-reports-table').DataTable().ajax.reload();
                            });
                        } else {
                            Swal.fire(
                                'เกิดข้อผิดพลาด!',
                                'เกิดข้อผิดพลาดในการลบ: ' + response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'เกิดข้อผิดพลาด!',
                            'ไม่สามารถสื่อสารกับเซิร์ฟเวอร์ได้',
                            'error'
                        );
                        console.error('AJAX Error:', status, error);
                    }
                });
            }
        });
    });

    // Handle image viewer modal
    const imageViewerModal = document.getElementById('imageViewerModal');
    if (imageViewerModal) {
        imageViewerModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const imagesJson = button.getAttribute('data-images');
            const foodDate = button.getAttribute('data-food-date');
            const gallery = document.getElementById('image-gallery-in-modal');
            gallery.innerHTML = ''; // Clear previous images

            let images;
            try {
                images = JSON.parse(imagesJson);
            } catch (e) {
                console.error('Error parsing images JSON for modal:', e);
                images = [];
            }

            if (Array.isArray(images) && images.length > 0) {
                images.forEach(function(image) {
                    let originalUrl = `<?=env('upload.server.baseurl')?>${foodDate}/${image}`;
                    let proxyUrl = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(originalUrl)}`;

                    const link = document.createElement('a');
                    link.href = originalUrl;
                    link.target = '_blank';

                    const img = document.createElement('img');
                    img.src = proxyUrl;
                    img.alt = 'Food Image';
                    img.className = 'img-fluid img-thumbnail';
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';
                    img.style.cursor = 'pointer';

                    link.appendChild(img);
                    gallery.appendChild(link);
                });
            } else {
                gallery.innerHTML = '<p>ไม่พบรูปภาพ</p>';
            }
        });
    }
});
</script>
<?= $this->endSection() ?>