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
                        <h5 class="card-title mb-0">ข้อมูลคำสั่ง</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons btn-group flex-wrap">

                            <button class="btn btn-secondary create-new btn-primary" type="button"
                                data-bs-toggle="modal" data-bs-target="#rightModal2">
                                <span><i class="bx bx-plus me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">
                                        เพิ่มข้อมูลคำสั่ง
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-datatable table-responsive p-3">
                    <table class="TbDataInstruction table border-top">
                        <thead>
                            <tr>
                                <th>ปีการศึกษา</th>
                                <th>เลขที่คำสั่ง</th>
                                <th>เรื่อง</th>
                                <th>วันที่</th>
                                <th>ไฟล์</th>
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


<!-- Drawer Style Right Modal -->

<div class="modal right" id="rightModal2" tabindex="-1" aria-labelledby="rightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md w-100">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rightModalLabel">เพิ่มข้อมูลคำสั่ง</h5>

            </div>
            <div class="modal-body">
                <div class="col-md">

                    <form class="needs-validation" novalidate="" id="FromDictationInsert">
                    <div class="mb-3">
                            <label class="form-label" for="bs-validation-country">ปีการศึกษา</label>
                            <select class="form-select" id="dicta_year" name="dicta_year" required="">
                                <?php for ($i=date('Y')+540; $i <= date('Y')+544; $i++) : ?>
                                <option <?=date('Y')+543 == $i ?"selected":""?> value="<?=$i;?>"><?=$i;?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="invalid-feedback"> เลือกปีการศึกษา</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">เลขที่คำสั่ง</label>
                            <input type="text" class="form-control" id="dicta_number" name="dicta_number" placeholder="ศธ/111"
                                required="">
                            <div class="invalid-feedback"> ใส่เลขคำสั่ง </div>
                        </div>    
                        <div class="mb-3">
                            <label class="form-label" for="dicta_createdate">วันที่คำสั่ง</label>
                            <input type="datetime-local" class="form-control flatpickr-validation flatpickr-input"
                                id="dicta_createdate" name="dicta_createdate" required="">
                            <div class="invalid-feedback"> โปรดเลือกวันที่คำสั่ง </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="dicta_title">ชื่อเรื่อง</label>
                            <textarea class="form-control" id="dicta_title" name="dicta_title" rows="3"
                                required=""></textarea>
                                <div class="invalid-feedback"> กรอกหัวเรื่อง </div>
                        </div>
                       
                        <div class="mb-3">
                            <label class="form-label" for="dicta_file">ไพล์แนบ (เป็น PDF เท่านั้น)</label>
                            <input type="file" class="form-control" id="dicta_file" name="dicta_file" required="">
                            <div class="invalid-feedback"> กรุณาแนบไฟล์ เป็น PDF เท่านั้น </div>
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
<!-- End Drawer Style Right Modal -->