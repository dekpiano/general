<!-- Layout container -->
<div class="layout-page">
    <?php echo view('Admin/AdminLeyout/AdminNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"></span> กำหนดสิทธิ์ใช้งานในระบบบริหารทั่วไป
            </h4>
            <div class="card">
            <div class="card-header">
                    <h5>ผู้บริหาร</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($Manager as $key => $v_Manager) : ?>
                        <?php if($v_Manager->admin_rloes_status ==="ManagerGeneral" || $v_Manager->admin_rloes_status === "ExecutiveGeneral"): ?>
                        <div class="col-md-4">
                            <label for=""><?php echo $v_Manager->admin_rloes_nanetype;?></label>
                            <div class="mt-3">
                                <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                                    rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                                    Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                                    <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                                    <option
                                        <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                        value="<?=$v_NameTeacher->pers_id?>">
                                        <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>งานอาคารสถานที่</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <?php foreach ($Manager as $key => $v_Manager) : ?>
                        <?php if($v_Manager->admin_rloes_nanetype === "งานอาคารสถานที่"): ?>

                        <div class="col-md-4 mt-2">
                            <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                            echo $SubLevel[1]; ?></label>
                            <div class="mt-2">
                                <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                                rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                                rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                                Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                                    <option value="">เลือกเจ้าหน้าที่</option>
                                    <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                                    <option
                                        <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                        value="<?=$v_NameTeacher->pers_id?>">
                                        <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>งานธุรการ</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <?php foreach ($Manager as $key => $v_Manager) : ?>
                        <?php if($v_Manager->admin_rloes_nanetype === "งานธุรการ"): ?>

                        <div class="col-md-4 mt-2">
                            <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                            echo $SubLevel[1]; ?></label>
                            <div class="mt-2">
                                <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                                rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                                rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                                Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                                    <option value="">เลือกเจ้าหน้าที่</option>
                                    <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                                    <option
                                        <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                        value="<?=$v_NameTeacher->pers_id?>">
                                        <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>


            <div class="card mt-3">
                <div class="card-header">
                    <h5>งานยานพาหนะ</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <?php foreach ($Manager as $key => $v_Manager) : ?>
                        <?php if($v_Manager->admin_rloes_nanetype === "งานยานพาหนะ"): ?>

                        <div class="col-md-4 mt-2">
                            <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                            echo $SubLevel[1]; ?></label>
                            <div class="mt-2">
                                <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                                rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                                rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                                Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                                    <option value="">เลือกเจ้าหน้าที่</option>
                                    <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                                    <option
                                        <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                        value="<?=$v_NameTeacher->pers_id?>">
                                        <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5>งานแจ้งซ่อม</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <?php foreach ($Manager as $key => $v_Manager) : ?>
                        <?php if($v_Manager->admin_rloes_nanetype === "งานแจ้งซ่อม"): ?>

                        <div class="col-md-4 mt-2">
                            <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                            echo $SubLevel[1]; ?></label>
                            <div class="mt-2">
                                <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                                rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                                rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                                Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                                    <option value="">เลือกเจ้าหน้าที่</option>
                                    <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                                    <option
                                        <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                        value="<?=$v_NameTeacher->pers_id?>">
                                        <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5>งานบุคลากร</h5>
                </div>
                <div class="card-body">
                    <div class="row">

                        <?php foreach ($Manager as $key => $v_Manager) : ?>
                        <?php if($v_Manager->admin_rloes_nanetype === "งานบุคลากร"): ?>

                        <div class="col-md-4 mt-2">
                            <label for=""><?php $SubLevel = explode("/",$v_Manager->admin_rloes_level);
                            echo $SubLevel[1]; ?></label>
                            <div class="mt-2">
                                <select class="select2Rloes form-select form-select-lg SettingGeneralRloes"
                                rloes-id="<?=$v_Manager->admin_rloes_id;?>"
                                rloes-level="<?=$v_Manager->admin_rloes_level;?>"
                                Key-nanetype="<?=$v_Manager->admin_rloes_nanetype;?>">
                                    <option value="">เลือกเจ้าหน้าที่</option>
                                    <?php  foreach ($NameTeacher as $key => $v_NameTeacher) : ?>
                                    <option
                                        <?=$v_Manager->admin_rloes_userid == $v_NameTeacher->pers_id ? 'selected' : '';?>
                                        value="<?=$v_NameTeacher->pers_id?>">
                                        <?=$v_NameTeacher->pers_prefix.$v_NameTeacher->pers_firstname." ".$v_NameTeacher->pers_lastname?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
      

        </div>
        <!-- / Content -->




        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->

