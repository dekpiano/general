<?= $this->extend('User/UserLayout/user_layout') ?>

<?= $this->section('customCSS') ?>
<style>
    :root {
        --car-primary: #696cff;
        --car-gradient: linear-gradient(135deg, #696cff 0%, #3f4191 100%);
        --glass-bg: rgba(255, 255, 255, 0.9);
        --glass-border: rgba(255, 255, 255, 0.5);
    }

    /* --- Animations --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .premium-animate {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Page Header --- */
    .page-header {
        background: var(--car-gradient);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        color: #fff;
        box-shadow: 0 15px 40px -10px rgba(105, 108, 255, 0.3);
    }
    .header-content { position: relative; z-index: 2; }
    .page-header::before {
        content: ''; position: absolute; top: -50%; right: -10%; width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    /* --- Table Styling --- */
    .table-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(105, 108, 255, 0.1);
        padding: 1.5rem;
    }

    .status-badge {
        padding: 8px 12px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .booking-row:hover { background-color: rgba(105, 108, 255, 0.03) !important; }

    .car-cell-img {
        width: 120px;
        height: 70px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .btn-action-mini {
        width: 35px;
        height: 35px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        border: none;
    }
    .btn-action-mini:hover { transform: scale(1.1); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Premium Header -->
    <div class="page-header premium-animate">
        <div class="header-content d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="<?=base_url('CarBooking');?>" class="text-white-50">จองยานพาหนะ</a></li>
                        <li class="breadcrumb-item active text-white">ประวัติการจอง</li>
                    </ol>
                </nav>
                <h3 class="mb-0 fw-bold text-white">ประวัติการจองของฉัน</h3>
            </div>
            <i class='bx bxs-car fs-1 text-white-50'></i>
        </div>
    </div>

    <!-- Data Table Section -->
    <div class="table-card premium-animate" style="animation-delay: 0.1s">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="mb-0 fw-bold text-dark"><i class='bx bx-list-ul me-2 text-primary'></i> รายการจองล่าสุด</h5>
            <button type="button" class="btn btn-label-primary btn-sm rounded-pill px-3" onclick="location.reload()">
                <i class='bx bx-refresh me-1'></i>รีเฟรช
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover border-top-0 display nowrap" id="TBShowDataCarBooking" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="border-0">สถานะ</th>
                        <th class="border-0">เลขที่จอง / ผู้จอง</th>
                        <th class="border-0">ยานพาหนะ</th>
                        <th class="border-0">ปลายทาง / ภารกิจ</th>
                        <th class="border-0">วัน-เวลา</th>
                        <th class="border-0 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('customScripts') ?>
<script>
$(document).ready(function() {
    const table = $("#TBShowDataCarBooking").DataTable({
        responsive: false, // Set to false to see the premium look better on wide screens
        serverMethod: "post",
        ajax: {
            url: "<?= base_url('CarBooking/DB/DataTable/View') ?>",
        },
        order: [[1, "desc"]],
        columns: [
            {
                data: "car_reserv_status",
                className: "align-middle",
                render: function (data, type, row) {
                    let badgeClass = 'bg-label-warning';
                    let icon = 'bx-hourglass';
                    if (data == "อนุมัติ") { badgeClass = 'bg-label-success'; icon = 'bx-check-circle'; }
                    else if (data == "ไม่อนุมัติ") { badgeClass = 'bg-label-danger'; icon = 'bx-x-circle'; }
                    
                    return `<span class="status-badge ${badgeClass}"><i class='bx ${icon}'></i>${data}</span>`;
                },
            },
            { 
                data: "car_reserv_order",
                className: "align-middle",
                render: function (data, type, row) {
                    return `
                        <div class="fw-bold text-dark">${data}</div>
                        <div class="small text-muted">${row.Member}</div>
                    `;
                }
            },
            {
                data: "car_img",
                className: "align-middle",
                render: function (data, type, row) {
                    return `
                        <div class="d-flex align-items-center">
                            <img class="car-cell-img me-3" src="<?= base_url('uploads/admin/Car/') ?>${data}" onerror="this.src='<?= base_url('assets/img/elements/1.jpg') ?>'">
                            <div>
                                <div class="fw-bold text-primary small">${row.car_registration}</div>
                                <div class="text-muted" style="font-size:0.7rem;">${row.car_category}</div>
                            </div>
                        </div>
                    `;
                },
            },
            {
                data: "car_reserv_location",
                className: "align-middle",
                render: function (data, type, row) {
                    return `
                        <div class="fw-bold text-dark">${data}</div>
                        <div class="small text-muted text-truncate" style="max-width: 15rem;" title="${row.car_reserv_detail}">${row.car_reserv_detail}</div>
                    `;
                },
            },
            { 
                data: "Date",
                className: "align-middle",
                render: function(data, type, row) {
                    return `<div class="small fw-medium">${data}</div>`;
                }
            },
            {
                data: null,
                className: "text-center align-middle",
                render: function(data, type, row) {
                    const isApproved = row.car_reserv_status === 'อนุมัติ';
                    const isPending = row.car_reserv_status === 'รอตรวจสอบ';
                    const isOwner = row.car_reserv_memberID == '<?= $_SESSION['id'] ?>';
                    
                    let actions = `<div class="d-flex justify-content-center gap-2">`;
                    
                    // Edit Button
                    if (isPending && isOwner) {
                        actions += `
                            <a href="<?= base_url('CarBooking/Edit/') ?>${row.car_reserv_id}" class="btn-action-mini btn-label-warning" title="แก้ไข">
                                <i class='bx bx-edit'></i>
                            </a>`;
                    }

                    // Print Button
                    if (isApproved) {
                        actions += `
                            <a target="_blank" href="<?= base_url('CarBooking/Approve/Admin/Print/') ?>${row.car_reserv_id}" class="btn-action-mini btn-label-info" title="พิมพ์ใบงาน">
                                <i class='bx bx-printer'></i>
                            </a>`;
                    }

                    // Cancel/Delete Button
                    if (isPending && isOwner) {
                         actions += `
                            <button type="button" class="btn-action-mini btn-label-danger btn-cancel-car" data-id="${row.car_reserv_id}" title="ยกเลิก">
                                <i class='bx bx-trash'></i>
                            </button>`;
                    }

                    actions += `</div>`;
                    return actions;
                }
            }
        ],
    });

    // Handle Cancel Action
    $(document).on('click', '.btn-cancel-car', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'ยกเลิกการจอง?',
            text: "ท่านต้องการยกเลิกคำขอจองยานพาหนะนี้ใช่หรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'ยืนยันยกเลิก',
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('CarBooking/Cancel') ?>',
                    type: 'POST',
                    data: { car_reserv_id: id },
                    success: function(response) {
                        if (response.status === 'success' || response == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'ยกเลิกสำเร็จ',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                table.ajax.reload();
                            });
                        } else {
                            Swal.fire('ผิดพลาด', 'ไม่สามารถยกเลิกได้ กรุณาลองใหม่', 'error');
                        }
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
