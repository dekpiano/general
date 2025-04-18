<style>
/* .fc-event-desc,
.fc-event-title {
    white-space: break-spaces;
} */
</style>
<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">

            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item me-3 mb-2">
                    <a class="nav-link active" href="<?=base_url('Repair/Add')?>"><i class="bx bx-bell me-1"></i>
                        แจ้งซ่อม/แจ้งปัญหา</a>
                </li>
                <li class="nav-item me-3 mb-2">
                    <a class="nav-link active" href="<?=base_url('Repair')?>"><i class="bx bx-user me-1"></i>
                        สถานะการซ่อม</a>
                </li>

                <li class="nav-item me-3 mb-2">
                    <a class="nav-link active" href="pages-account-settings-connections.html"><i
                            class="bx bx-link-alt me-1"></i> สถิติแจ้งซ่อม</a>
                </li>
            </ul>

            <div class="card p-3">
                <h5 class="card-header">ตารางแจ้งซ่อม</h5>
                <style>
                @keyframes typing {
                    from {
                        width: 0;
                    }

                    to {
                        width: 100%;
                    }
                }

                .loading-text {
                    overflow: hidden;
                    white-space: nowrap;
                    display: inline-block;
                    animation: typing 3s steps(40, end) infinite;
                }
                </style>
                <table class="table table-hover nowrap dataTable dtr-inline collapsed" id="TbDataRepair">
                    <thead>
                        <tr>
                            <th>วันที่แจ้งซ่อม</th>
                            <th>สถานะ</th>
                            <th>ใบแจ้งซ่อม </th>
                            <th>ผู้แจ้งซ่อม </th>
                            <th>รายการแจ้งซ่อม</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                    </tbody>
                </table>

            </div>



        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->


<!-- Modal -->
<div class="modal fade" id="ModalShowRepair" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">รายละเอียดรายการแจ้งซ่อม</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="bg-primary text-white p-2">
                    ข้อมูลการแจ้งปัญหา
                </div>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">หมายเลขใบแจ้งซ่อม</th>
                            <td id="show_repair_order"></td>
                        </tr>
                        <tr>
                            <th scope="col">รายการแจ้งซ่อม</th>
                            <td scope="col">
                                <div>
                                    ประเภท : <span id="show_repair_caselist"></span>
                                </div>
                                <div>
                                    สถานที่ : <span id="show_repair_location"></span>
                                </div>
                                <div>
                                    <u> รายละเอียดเพิ่มเติม</u>
                                </div>
                                <div id="show_repair_detail"></div>
                                <div id="show_repair_imguser"></div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">วันที่แจ้งซ่อม</th>
                            <td scope="col">
                                <span id="show_repair_datetime"></span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">ผู้แจ้งซ่อม</th>
                            <td scope="col" id="show_repair_userID"></td>
                        </tr>
                        <tr>
                            <th scope="col">ตำแหน่ง</th>
                            <td scope="col" id="show_repair_posi"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-white p-2 bg-success">
                    ข้อมูลการดำเนินการ
                </div>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="col">สถานะการดำเนินการ</th>
                            <td scope="col" id="show_repair_status">รอดำเนินการ</td>
                        </tr>
                        <tr>
                            <th scope="row">วันที่ดำเนินการ</th>
                            <td id="show_repair_datework">รอดำเนินการ</td>
                        </tr>
                        <tr>
                            <th scope="col">ผู้ดำเนินการ</th>
                            <td scope="col" id="show_repair_Repairman">รอดำเนินการ</td>
                        </tr>
                        <tr>
                            <th scope="col">สาเหตุ/วิธีแก้ไข</th>
                            <td scope="col" id="show_repair_cause">รอดำเนินการ</td>
                        </tr>

                        <tr>
                            <th scope="col">รูปภาพ</th>
                            <td scope="col" id="show_repair_imgwork">รอดำเนินการ</td>
                        </tr>
                        <tr>
                            <th scope="col">ลายมือชื่อผู้แจ้งซ่อม</th>
                            <td scope="col" id="show_repair_usersignature">
                                รอดำเนินการ
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <?php $checkRloes = explode(",",@$_SESSION['rloes']);?>
            <div class="modal-footer justify-content-between">
                <?php if(!empty($_SESSION['username']) && $_SESSION['username'] != '' && in_array("งานแจ้งซ่อม",$checkRloes)):?>
                <button type="button" class="btn btn-secondary" id="ModalFormAdmin">สำหรับผู้ซ่อม</button>
                <?php endif; ?>
                <a href="" target="_blank" class="btn btn-primary PrintOrder">พิมพ์ใบแจ้งซ่อม</a>
            </div>
        </div>
    </div>
</div>

