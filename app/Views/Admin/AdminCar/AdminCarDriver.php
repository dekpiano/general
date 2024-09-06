<!-- Layout container -->
<div class="layout-page">
    <?php echo view('Admin/AdminLeyout/AdminNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <div class="card">
                <div class="card-header d-flex justify-content-between flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0"><?=$title;?></h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">

                            <button class="btn btn-secondary create-new btn-primary" type="button"
                                data-bs-toggle="modal" data-bs-target="#rightModal2">
                                <span><i class="bx bx-plus me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">
                                        เพิ่ม<?=$title;?>
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive p-3">
                    <table class="TbDataCarDriver table border-top">
                        <thead>
                            <tr>
                                <th>รูป</th>
                                <th>ชื่อคนขับ</th>
                                <th>เบอร์โทร</th>
                                <th>คำสั่ง</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>



        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->


<!-- เพิ่มหนังสือคำสั่ง Modal -->
<div class="modal right" id="rightModal2"  aria-labelledby="rightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md w-100">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rightModalLabel">เพิ่ม<?=$title?></h5>
             
            </div>
            <div class="modal-body">
                <div class="col-md">
                    <form class="needs-validation" novalidate="" id="FromCarDriverInsert">                        
                        <div class="row">
                           
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="CarD_Province">คนขับรถ</label>
                                    <select id="cardriver_userID" name="cardriver_userID" class="form-select">
                                        <option value="">กรุณาเลือกคนขับรถ</option>
                                        <?php foreach ($CheckDriver as $key => $value) : ?>
                                            <option value="<?=$value->pers_id?>"><?=$value->pers_prefix.$value->pers_firstname.' '.$value->pers_lastname?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback"> กรุณาเลือกคนขับรถ </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

    </div>
</div>
</div>
<!-- End เพิ่มหนังสือคำสั่ง Modal -->