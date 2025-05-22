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
            <div class="repair-menu-mobile">
                <a class="repair-btn-mobile" href="<?=base_url('Repair/Add')?>">
                    <span class="repair-icon-mobile">
                        <i class="bi bi-bell"></i>
                    </span>
                    <span class="repair-label-mobile">แจ้งซ่อม/แจ้งปัญหา</span>
                </a>
                <a class="repair-btn-mobile" href="<?=base_url('Repair')?>">
                    <span class="repair-icon-mobile">
                        <i class="bi bi-person"></i>
                    </span>
                    <span class="repair-label-mobile">สถานะการซ่อม</span>
                </a>
                <a class="repair-btn-mobile" href="<?=base_url('Repair/RepairStatistics')?>">
                    <span class="repair-icon-mobile">
                        <i class="bi bi-bar-chart"></i>
                    </span>
                    <span class="repair-label-mobile">สถิติแจ้งซ่อม</span>
                </a>
            </div>

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

                .repair-menu-mobile {
                    display: flex;
                    flex-direction: column;
                    gap: 16px;
                    margin: 16px 0;
                }

                .repair-btn-mobile {
                    display: flex;
                    align-items: center;
                    width: 100%;
                    background: #fff;
                    border: none;
                    border-radius: 1rem;
                    box-shadow: 0 1px 6px rgba(44, 76, 255, 0.10);
                    padding: 18px 16px;
                    font-size: 1.1rem;
                    transition: box-shadow 0.18s, background 0.18s;
                }

                .repair-btn-mobile:active,
                .repair-btn-mobile:focus {
                    background: #eaf0ff;
                    box-shadow: 0 3px 16px rgba(44, 76, 255, 0.20);
                }

                .repair-icon-mobile {
                    background: #556cff;
                    color: #fff;
                    border-radius: 50%;
                    font-size: 1.55rem;
                    width: 2.8rem;
                    height: 2.8rem;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-right: 16px;
                }

                .repair-label-mobile {
                    font-weight: 600;
                    color: #333;
                    font-size: 1.07rem;
                    letter-spacing: 0.02em;
                }

                .repair-btn-mobile {
                    /* ...เดิม... */
                    transition: box-shadow 0.18s, background 0.18s, transform 0.18s;
                }

                .repair-btn-mobile:hover,
                .repair-btn-mobile:focus,
                .repair-btn-mobile:active {
                    background: #f1f4ff;
                    box-shadow: 0 3px 16px rgba(44, 76, 255, 0.18);
                    transform: translateY(-2px) scale(1.03);
                }

                .repair-btn-mobile:hover .repair-icon-mobile,
                .repair-btn-mobile:focus .repair-icon-mobile,
                .repair-btn-mobile:active .repair-icon-mobile {
                    background: #3245d6;
                    transform: scale(1.13) rotate(-6deg);
                    transition: background 0.16s, transform 0.18s;
                }

                .repair-btn-mobile:hover .repair-label-mobile,
                .repair-btn-mobile:focus .repair-label-mobile,
                .repair-btn-mobile:active .repair-label-mobile {
                    color: #1d275a;
                    font-weight: 700;
                }


                /* Responsive: บนจอใหญ่ >600px ให้แสดงแนวนอน */
                @media (min-width: 600px) {
                    .repair-menu-mobile {
                        flex-direction: row;
                        justify-content: flex-start;
                        gap: 18px;
                    }

                    .repair-btn-mobile {
                        width: auto;
                        min-width: 170px;
                        justify-content: flex-start;
                    }

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