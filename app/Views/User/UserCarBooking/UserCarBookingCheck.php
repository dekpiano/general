<!-- Layout container -->
<div class="layout-page">
    <?php echo view('User/UserLeyout/UserNavbar'); ?>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y demo">

            <h4>ค้นหารถที่ว่าง</h4>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">ออกเดินทางวันที่</label>
                                <input type="date" name="" id="" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">เดินทางกลับวันที่</label>
                                <input type="date" name="" id="" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <button class="btn btn-primary"><i class='bx bx-search-alt-2'></i>
                                ค้นหารถที่ยังว่าง</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">

                </div>
            </div>

        </div>
    </div>
    <!-- Content wrapper -->
</div>
<!-- / Layout page -->