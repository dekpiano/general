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
                data: 'CarD_Img',
                render: function(data, type, row) {
                    return '<img style="width:200px;" class="card-img-top" src="../../uploads/admin/Car/' + data + '" alt="Card image cap">';
                }
            },
            {
                data: 'CarD_Register',
                render: function(data, type, row) {
                    return 'ทะเบียนรถ : ' + row.CarD_Register + ' ' + row.CarD_Province + '<br>ยี่ห้อ : ' + row.CarD_Brand + ' <br>รุ่น : ' + row.CarD_Model;
                }
            },
            { data: 'CarD_Category' },
            { data: 'CarD_NumberSeats' },
            {
                data: 'CarD_ID ',
                render: function(data, type, row) {
                    return '<div class="d-inline-block text-nowrap"><button class="btn btn-sm btn-icon"><i class="bx bx-edit" data-bs-toggle="modal" data-bs-target="#UpdateInstruction"></i></button><button class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash" id="DelCar" key-id="' + row.CarD_ID + '"></i></button></div>';
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
    console.log($(this).attr('key-id'));
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