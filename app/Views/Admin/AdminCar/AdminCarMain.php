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
                    <table class="TbDataCar table border-top">
                        <thead>
                            <tr>
                                <th>รูป</th>
                                <th>รายละเอียดรถ</th>
                                <th>ประเภทรถ</th>
                                <th>จำนวนที่นั่ง</th>
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
<div class="modal right" id="rightModal2" tabindex="-1" aria-labelledby="rightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md w-100">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rightModalLabel">เพิ่ม<?=$title?></h5>

            </div>
            <div class="modal-body">
                <div class="col-md">
                    <form class="needs-validation" novalidate="" id="FromCarInsert">                        
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="CarD_Register">ทะเบียนรถยนต์</label>
                                    <input type="text" class="form-control" id="CarD_Register" name="CarD_Register"
                                        placeholder="ตย. กขค 123" required="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="CarD_Province">จังหวัดรถ</label>
                                    <select id="CarD_Province" name="CarD_Province" class="form-select">
                                        <option value="">กรุณาเลือกจังหวัด</option>
                                        <?php foreach ($Province as $key => $value) : ?>
                                            <option value="<?=$value->name_th?>"><?=$value->name_th?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback"> กรุณาเลือกจังหวัดรถ </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="CarD_Category">ประเภทรถ</label>
                                    <select id="CarD_Category" name="CarD_Category" class="form-select">
                                        <option value="">กรุณาเลือกประเภทรถ</option>
                                        <?php $CarCategor = array('รถกระบะ 4 ประตู','รถตู้',"รถบรรทุกเล็ก 6 ล้อ","รถมินิบัส"); ?>
                                        <?php foreach ($CarCategor as $key => $value) : ?>
                                            <option value="<?=$value?>"><?=$value?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback"> กรุณาเลือกประเภทรถ </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="CarD_Brand">ยี่ห้อรถ</label>
                                    <input type="text" class="form-control" id="CarD_Brand" name="CarD_Brand"
                                        placeholder="ตย. Toyota" required="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="CarD_Model">รุ่นรถ</label>
                                    <input type="text" class="form-control" id="CarD_Model" name="CarD_Model"
                                        placeholder="ตย. Vego" required="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="CarD_NumberSeats">จำนวนที่นั่ง</label>
                                    <input type="text" class="form-control" id="CarD_NumberSeats"
                                        name="CarD_NumberSeats" placeholder="ตย. 7" required="">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="CarD_Details">รายละเอียดอื่น ๆ</label>
                    <textarea class="form-control" id="CarD_Details" name="CarD_Details" rows="3"
                        required=""></textarea>
                    <div class="invalid-feedback"> กรอกรายละเอียด</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="CarD_Img">รูปภาพรถ</label>
                    <input type="file" class="form-control" id="CarD_Img" name="CarD_Img" >
                    <div class="invalid-feedback"> กรอกรายละเอียด</div>
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