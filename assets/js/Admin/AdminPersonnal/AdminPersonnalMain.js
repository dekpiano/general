$(document).on('submit', '#FormPersonnalAdd', function(e) {
    e.preventDefault();

    $.ajax({
        url: "../../../Admin/WorkPerson/Personnel/DB/Insert",
        method: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        success: function(res) {
            console.log(res);
            if (res == 1) {
                Swal.fire(
                    'แจ้งเตือน!', "บันทึกข้อมูลสำเร็จ!",
                    'success'
                )
                Swal.fire({
                    title: 'แจ้งเตือน?',
                    text: "บันทึกข้อมูลสำเร็จ!",
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../../../Admin/WorkPerson/Personnel";
                    }
                })

            } else if (res.success == false) {
                Swal.fire(
                    'แจ้งเตือน!', "บันทึกข้อมูลไม่สำเร็จ!",
                    'error'
                )
            }
        }
    });
});