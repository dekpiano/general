<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a
                        href="<?=base_url('Booking/Select')?>">สถานที่</a> / ข้อมูลการจองทั้งหมด</span>
            
            </h4>

            <div class="card">
                <h5 class="card-header">ข้อมูลการจองทั้งหมด</h5>
                <div class="table-responsive text-nowrap p-3">
                    <table class="table table-hover display nowrap"  id="TBShowDataBookingExecutive">
                        <thead>
                            <tr>
                            <th>เลขที่จอง</th>
                                <th>หัวข้อ</th>
                                <th>ชื่อห้อง</th>
                                <th>ชื่อผู้จอง</th>
                                <th>อนุมัติโดย Admin</th>          
                                <th>อนุมัติโดย ผู้บริหาร</th>
                                <th>คำสั่ง</th>
                                <th>ลายเซ็น</th>
                                <th>เอกสาร</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->

<!-- Modal -->
<div class="modal fade" id="ModalSignatureExecutive" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ลายเซ็น</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      <canvas id="SignatureAdmin" width="400" height="200" style="border: 1px solid #000;"></canvas><br>
      <button id="clear">ล้างลายเซ็น</button>
      <hr>
      </div>
      <div class="modal-footer justify-content-center">        
        <button type="button" class="btn btn-primary" id="SaveSignatureExecutive">บันทึกลายเซ็น</button>
      </div>
    </div>
  </div>
</div>