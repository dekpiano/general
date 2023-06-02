ShowDataInstruction();

function ShowDataInstruction() {
    $('.TbDataInstruction').DataTable({
        'processing': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '../../Admin/Dictation/ShowData'
        },
        order: [
            [3, 'desc']
        ],
        'columns': [
            { data: 'dicta_year' },
            { data: 'dicta_number' },
            { data: 'dicta_title' },
            { data: 'dicta_createdate' },
            {
                data: 'dicta_file',
                render: function(data, type, row) {
                    return '<a target="_blank" href="../../uploads/admin/dictation/' + data + '">เปิดดู</a>';
                }
            },
            {
                data: 'dicta_title',
                render: function(data, type, row) {
                    return '<div class="d-inline-block text-nowrap"><button class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></button><button class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash"></i></button></div>';
                }
            }
        ]
    });
}

$(document).on('submit', '#FromDictationInsert', function(e) {
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
            url: "../../Admin/Dictation/Insert",
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
                    $('.TbDataInstruction').DataTable().ajax.reload();
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