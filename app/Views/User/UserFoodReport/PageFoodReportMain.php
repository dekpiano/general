<?php $isLoggedIn = session()->get('logged_in'); ?>
<?= $this->extend('User/UserLeyout/user_layout') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">เมนู /</span> รายงานอาหาร</h4>

    <div class="card p-3">
        <div class="card-header">
            <?php if ($isLoggedIn && in_array('งานรายงานอาหาร', explode(',', session()->get('rloes')))): ?>
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0 font-bold">ข้อมูลรายงานอาหาร</h5>
                <div class="dt-action-buttons text-end pt-3 pt-md-0">
                    <div class="dt-buttons">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addReportModal">
                            <span><i class="bx bx-plus me-sm-1"></i> <span
                                    class="d-none d-sm-inline-block">เพิ่มรายงานใหม่</span></span>
                        </button>
                    </div>
                </div>
            </div>

            <?php elseif (!$isLoggedIn): ?>
            <div class="dt-action-buttons text-end pt-3 pt-md-0">
                <div class="dt-buttons">
                    <a href="<?=base_url('LoginOfficerGeneral?return_to='.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);?>"
                        class="btn btn-success">
                        <span><i class="bx bx-log-in me-sm-1"></i> <span class="d-none d-sm-inline-block">เข้าสู่ระบบ
                                สำหรับผู้บันทึก</span></span>
                    </a>
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
                        <?php if ($isLoggedIn && in_array('งานรายงานอาหาร', explode(',', session()->get('rloes')))): ?>
                        <th>ผู้บันทึก</th>
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

<?php if ($isLoggedIn && in_array('งานรายงานอาหาร', explode(',', session()->get('rloes')))): ?>
<!-- Add Report Modal -->
<div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReportModalLabel">เพิ่มรายงานอาหารใหม่</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addReportForm" action="<?= base_url('FoodReport/insert') ?>" method="post"
                enctype="multipart/form-data">
                <input type="hidden" id="food_id" name="food_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="food_date" class="form-label">วันที่</label>
                        <input type="date" class="form-control" id="food_date" name="food_date"
                            value="<?=date("Y-m-d")?>" required>
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
                        <input class="form-control" type="file" id="food_images" name="food_images[]" multiple
                            accept="image/*">
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

<?php if ($isLoggedIn && in_array('งานรายงานอาหาร', explode(',', session()->get('rloes')))): ?>
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
addReportModal.addEventListener('hidden.bs.modal', function() {
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
    submitButton.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กำลังบันทึก...';

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

            const foodId = document.getElementById('food_id').value;
            const successMessage = foodId ? 'แก้ไขข้อมูลสำเร็จ!' : 'บันทึกข้อมูลสำเร็จ!';
            const errorMessage = 'เกิดข้อผิดพลาด!'; // Define error message here

            if (data.status === 'success') {
                const addReportModalInstance = bootstrap.Modal.getInstance(document
                    .getElementById('addReportModal'));
                addReportModalInstance.hide(); // Hide the modal immediately

                Swal.fire({
                    icon: 'success',
                    title: successMessage,
                    showConfirmButton: true // Explicitly show confirm button
                }).then((result) => {
                    if (result.isConfirmed) { // Check if confirm button was clicked
                        $('#food-reports-table').DataTable().ajax.reload();
                    }
                });
            } else {
                console.error('Server error:', data); // Log the full error data
                Swal.fire({
                    icon: 'error',
                    title: errorMessage, // Use defined error message
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

// Handle modal show event for add/edit
const addReportModalElement = document.getElementById('addReportModal');
addReportModalElement.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const form = document.getElementById('addReportForm');
    const modalTitle = document.getElementById('addReportModalLabel');
    const foodIdInput = document.getElementById('food_id');
    const imagePreviewContainer = document.getElementById('image-preview');

    // Reset form and image preview
    form.reset();
    imagePreviewContainer.innerHTML = '';

    if (button && button.classList.contains('item-edit')) { // Edit mode
        const foodId = button.getAttribute('data-id');
        modalTitle.textContent = 'แก้ไขรายงานอาหาร';
        form.action = '<?= base_url('FoodReport/update') ?>';
        foodIdInput.value = foodId;

        // Fetch report data
        fetch(`<?= base_url('FoodReport/getReportById/') ?>${foodId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.report) {
                    const report = data.report;
                    document.getElementById('food_date').value = report.food_date;
                    document.getElementById('food_meal').value = report.food_meal;
                    document.getElementById('food_menu').value = report.food_menu;

                    // Display existing images
                    let images;
                    try {
                        images = (report.food_images && typeof report.food_images === 'string') ? JSON.parse(report.food_images) : [];
                    } catch (e) {
                        images = [];
                    }

                    if (Array.isArray(images) && images.length > 0) {
                        images.forEach(function(image) {
                            const foodDate = report.food_date; // Use report's food_date for image path
                            let originalUrl = `<?=env('upload.server.baseurl')?>${foodDate}/${image}`;
                            let proxyUrl = `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(originalUrl)}`;

                            const imgWrapper = document.createElement('div');
                            imgWrapper.style.position = 'relative';
                            imgWrapper.style.width = '150px';
                            imgWrapper.style.height = '150px';
                            imgWrapper.style.border = '2px solid #ddd';
                            imgWrapper.style.borderRadius = '8px';
                            imgWrapper.style.padding = '5px';
                            imgWrapper.style.overflow = 'hidden';

                            const img = document.createElement('img');
                            img.src = proxyUrl;
                            img.alt = 'Food Image';
                            img.style.width = '100%';
                            img.style.height = '100%';
                            img.style.objectFit = 'cover';
                            
                            imgWrapper.appendChild(img);
                            imagePreviewContainer.appendChild(imgWrapper);
                        });
                    }
                } else {
                    Swal.fire('เกิดข้อผิดพลาด!', 'ไม่สามารถดึงข้อมูลรายงานได้: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error fetching report data:', error);
                Swal.fire('เกิดข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการดึงข้อมูลรายงาน', 'error');
            });

    } else { // Add mode
        modalTitle.textContent = 'เพิ่มรายงานอาหารใหม่';
        form.action = '<?= base_url('FoodReport/insert') ?>';
        foodIdInput.value = '';
        document.getElementById('food_date').value = '<?= date("Y-m-d") ?>'; // Set default date for add mode
    }
});
</script>
<?php endif; ?>

<script>
$(document).ready(function() {
    const sftp_partweb = '<?= $sftp_partweb ?? '' ?>';
    const sftp_partfullweb = '<?= $sftp_partfullweb ?? '' ?>';
    const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
    const loggedInUserId = '<?= session()->get('id') ?? 'null' ?>';

    let columns = [{
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
        {
            "data": "food_meal"
        },
        {
            "data": "food_menu"
        },
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
            "data": "recorder_full_name", // Assumes the backend will provide the full name (ชื่อ-นามสกุล) of the recorder.
            "render": function(data, type, row) {
                return data ? data : '<span class="text-muted">N/A</span>';
            }
        });
        columns.push({
            "data": "food_id",
            "render": function(data, type, row) {
                let printUrl = `<?= base_url('FoodReport/print/') ?>${data}`;
                return `<a href="${printUrl}" target="_blank" class="btn btn-sm btn-info"><i class="bx bx-printer me-1"></i> พิมพ์</a>`;
            },
            "orderable": false,
            "searchable": false
        });
        columns.push({
            "data": "food_id",
            "render": function(data, type, row) {
                // This check assumes that the JSON response for each row contains a `user_id` field,
                // which holds the ID of the user who created the report.
                if (isLoggedIn && loggedInUserId && row.user_id && row.user_id == loggedInUserId) {
                    // If the user is the owner, show edit and delete buttons
                    return `<div class="d-inline-flex gap-2">
                                <a href="javascript:;" class="btn btn-sm btn-icon item-edit" title="แก้ไข" data-bs-toggle="modal" data-bs-target="#addReportModal" data-id="${data}"><i class="bx bx-edit-alt"></i></a>
                                <button type="button" class="btn btn-sm btn-icon delete-btn" data-id="${data}" title="ลบ"><i class="bx bx-trash"></i></button>
                            </div>`;
                } else {
                    // If not the owner, show disabled-like buttons that trigger an alert
                    return `<div class="d-inline-flex gap-2">
                                <button type="button" class="btn btn-sm btn-icon permission-denied" title="แก้ไข"><i class="bx bx-edit-alt"></i></button>
                                <button type="button" class="btn btn-sm btn-icon permission-denied" title="ลบ"><i class="bx bx-trash"></i></button>
                            </div>`;
                }
            },
            "orderable": false,
            "searchable": false
        });
    }

    $('#food-reports-table').DataTable({
        "responsive": true,
        "ajax": {
            "url": "<?= base_url('FoodReport/getFoodReportsJson') ?>",
            "error": function(xhr, error, thrown) {
                Swal.fire(
                    'เกิดข้อผิดพลาด!',
                    'เกิดข้อผิดพลาดในการโหลดข้อมูลตาราง โปรดลองอีกครั้ง',
                    'error'
                );
                console.error('DataTables AJAX error:', error, thrown);
            }
        },
        "columns": columns,
        "order": [
            [0, "desc"]
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Thai.json"
        }
    });

    // Handle permission denied button click
    $('#food-reports-table tbody').on('click', '.permission-denied', function() {
        Swal.fire({
            icon: 'warning',
            title: 'ไม่ได้รับอนุญาต',
            text: 'คุณสามารถแก้ไขหรือลบได้เฉพาะรายงานที่คุณสร้างเองเท่านั้น',
        });
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
                    data: {
                        id: foodId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'ลบสำเร็จ!',
                                'รายงานของคุณถูกลบเรียบร้อยแล้ว',
                                'success'
                            ).then(() => {
                                $('#food-reports-table').DataTable().ajax
                                    .reload();
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
        imageViewerModal.addEventListener('show.bs.modal', function(event) {
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
                    let proxyUrl =
                        `<?= base_url('image_proxy.php') ?>?url=${encodeURIComponent(originalUrl)}`;

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