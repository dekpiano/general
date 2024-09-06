ShowDataCar();

function ShowDataCar() {
    $('.TbDataCar').DataTable({
        'processing': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '../../Admin/Car/ShowData'
        },
        order: [
            [3, 'desc']
        ],
        'columns': [{
                data: 'car_img',
                render: function(data, type, row) {
                    return '<img style="width:200px;" class="card-img-top" src="../../uploads/admin/Car/' + data + '" alt="Card image cap">';
                }
            },
            {
                data: 'car_registration',
                render: function(data, type, row) {
                    return 'ทะเบียนรถ : ' + row.car_registration + ' ' + row.car_province + '<br>ยี่ห้อ : ' + row.car_brand + ' <br>รุ่น : ' + row.car_model;
                }
            },
            { data: 'car_category' },
            { data: 'car_seats' },
            {
                data: 'car_ID',
                render: function(data, type, row) {
                    return '<div class="d-inline-block text-nowrap"><button class="btn btn-sm btn-icon"><i class="bx bx-edit" data-bs-toggle="modal" data-bs-target="#UpdateInstruction"></i></button><button class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash" id="DelCar" key-id="' + row.car_ID + '"></i></button></div>';
                }
            }
        ]
    });
}

$(document).on('submit', '#FromCarInsert', function(e) {
    e.preventDefault();
    if ($('#file').val() == '') {
        alert("Choose File");
        $('.uploadBtn').html('Upload');
        $('.uploadBtn').prop('enabled');
        document.getElementById("upload_image_form").reset();
    } else {
        $.ajax({
            url: "../../Admin/Car/Insert",
            method: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            success: function(res) {
                console.log(res.data);
                if (res.success == true) {
                    $('#rightModal2').hide();
                    $('.modal-backdrop').hide();
                    Swal.fire(
                        'แจ้งเตือน!', res.msg,
                        'success'
                    )
                    $('.TbDataCar').DataTable().ajax.reload();
                    $('#FromCarInsert')[0].reset();
                } else if (res.success == false) {
                    $('#rightModal2').hide();
                    $('.modal-backdrop').hide();
                    Swal.fire(
                        'แจ้งเตือน!', res.msg,
                        'error'
                    )
                }
            }
        });
    }
});

$(document).on('click', '#DelCar', function() {
    
    Swal.fire({
        title: 'คุณต้องการลบข้อมูลหรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
     
            $.post('../../Admin/Car/Delete', { DelKey: $(this).attr('key-id') }, function(res) {
                if (res) {
                    console.log(res);
                    Swal.fire(
                        'แจ้งเตือน!',
                        'ลบข้อมูลสำเร็จ.',
                        'success'
                    )
                }
                $('.TbDataCar').DataTable().ajax.reload();
            });

        }
    })

});

$(".select2Rloes").select2({
    width: 'resolve' // need to override the changed default
});

// ---------------- คนขับรถ -----------------

$('#cardriver_userID').select2({
    dropdownParent: $("#rightModal2") 
});

ShowDataCarDriver();
function ShowDataCarDriver() {
    $('.TbDataCarDriver').DataTable({
        'processing': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '../../Admin/CarDriver/ShowData'
        },
        order: [
            [3, 'desc']
        ],
        'columns': [{
                data: 'cardriver_id',
                render: function(data, type, row) {
                    return '<img style="width:100px;" class="card-img-top" src="https://general.skj.ac.th/uploads/admin/Personnal/' + row.cardriver_img + '" alt="Card image cap">';
                }
            },
            {
                data: 'cardriver_Fullname'
            },
            { data: 'cardriver_phone' },
            { data: 'cardriver_id',
                render: function(data, type, row) {
                    return '<button class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash h1" id="DelCarDriver" key-id="' + row.cardriver_id + '"></i></button></div>';
                }
            }
        ]
    });
}

$(document).on('submit', '#FromCarDriverInsert', function(e) {
    e.preventDefault();
   
        $.ajax({
            url: "../../Admin/CarDriver/Insert",
            method: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            dataType: "json",
            success: function(res) {
                console.log(res.data);
                if (res.success == true) {
                    $('#rightModal2').hide();
                    $('.modal-backdrop').hide();
                    Swal.fire(
                        'แจ้งเตือน!', res.msg,
                        'success'
                    )
                    $('.TbDataCarDriver').DataTable().ajax.reload();
                    $('#FromCarInsert')[0].reset();
                } else if (res.success == false) {
                    $('#rightModal2').hide();
                    $('.modal-backdrop').hide();
                    Swal.fire(
                        'แจ้งเตือน!', res.msg,
                        'error'
                    )
                }
            }
        });
});

$(document).on('click', '#DelCarDriver', function() {
    
    Swal.fire({
        title: 'คุณต้องการลบข้อมูลคนขับรถหรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, ฉันต้องการลบ!'
    }).then((result) => {
        if (result.isConfirmed) {
     
            $.post('../../Admin/CarDriver/Delete', { DelKey: $(this).attr('key-id') }, function(res) {
                if (res) {
                    console.log(res);
                    Swal.fire(
                        'แจ้งเตือน!',
                        'ลบข้อมูลสำเร็จ.',
                        'success'
                    )
                }
                $('.TbDataCarDriver').DataTable().ajax.reload();
            });

        }
    })

});

