$('.select2Rloes').select2({
    placeholder: "เลือกตัวเลือก",
    allowClear: true
  });

$(document).on("change", ".SettingGeneralRloes", function() {
 
    $.post("../../Admin/Rloes/RloesSettingManager", {
        TeachID: $(this).val(),
        RloesLevel: $(this).attr('rloes-level'),
        Keytype: $(this).attr('Key-nanetype'), 
        RloesID: $(this).attr('rloes-id'),
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