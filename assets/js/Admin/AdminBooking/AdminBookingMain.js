ShowDataLocationRoom();

function ShowDataLocationRoom() {
    $('.TbDataLocationRoom').DataTable({
        'processing': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '../../Admin/LocationRoom/ShowData'
        },
        order: [
            [3, 'desc']
        ],
        'columns': [{
                data: 'location_img',
                render: function(data, type, row) {
                    return '<img style="width:200px;" class="card-img-top" src="../../uploads/admin/LocationRoom/' + data + '" alt="Card image cap">';
                }
            },
            { data: 'location_name' },
            { data: 'location_detail' },
            { data: 'location_number' },
            { data: 'location_seats' },
            {
                data: 'location_ID',
                render: function(data, type, row) {
                    return '<div class="d-inline-block text-nowrap"><button class="btn btn-sm btn-icon"><i class="bx bx-edit" data-bs-toggle="modal" data-bs-target="#UpdateInstruction"></i></button><button class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash" id="DelLocationRoom" key-id="' + row.location_ID + '"></i></button></div>';
                }
            }
        ]
    });
}

$(document).on('submit', '#FromLocationRoomInsert', function(e) {
    $('.uploadBtn').html('Uploading ...');
    $('.uploadBtn').prop('Disabled');
    e.preventDefault();
    if ($('#file').val() == '') {
        alert("Choose File");
        $('.uploadBtn').html('Upload');
        $('.uploadBtn').prop('enabled');
        document.getElementById("upload_image_form").reset();
    } else {
        $.ajax({
            url: "../../Admin/LocationRoom/Insert",
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
                    $('.TbDataLocationRoom').DataTable().ajax.reload();
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

$(document).on('click', '#DelLocationRoom', function() {
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

            $.post('../../Admin/LocationRoom/Delete', { DelKey: $(this).attr('key-id') }, function(res) {
                if (res) {
                    Swal.fire(
                        'แจ้งเตือน!',
                        'ลบข้อมูลสำเร็จ.',
                        'success'
                    )
                }
                $('.TbDataLocationRoom').DataTable().ajax.reload();
            });

        }
    })

});

$(".select2Rloes").select2({
    width: 'resolve' // need to override the changed default
});

$(document).on("change", ".SettingGeneralRloes", function() {

    console.log($(this).val());
    console.log($(this).attr('rloes-id'));

    $.post("../../Admin/Rloes/RloesSettingManager", {
        TeachID: $(this).val(),
        RloesID: $(this).attr('rloes-id')
    }, function(data, status) {
        if (data == 1) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'เป็นผู้ใช้งานเรียบร้อย',
                showConfirmButton: false,
                timer: 1500
            })
        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'เปลี่ยนแปลงข้อมูลไม่สำเร็จ',
                showConfirmButton: false,
                timer: 1500
            })
        }
    });
});