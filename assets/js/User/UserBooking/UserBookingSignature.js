$(document).ready(function() {
    const canvas = document.getElementById('SignatureAdmin');
    if (!canvas) return;

    const signaturePad = new SignaturePad(canvas);
    signaturePad.penColor = '#0066CC';

    // ล้างลายเซ็น
    const clearBtn = document.getElementById('clear');
    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            signaturePad.clear();
        });
    }

    // โหลดลายเซ็นเมื่อเปิด Modal (ปุ่มใน DataTable)
    $(document).on('click', '#FormSignatureAdmin', function() {
        const BookingID = $(this).attr('data-idBooking');
        signaturePad.clear(); // ล้างของเก่าก่อนโหลดใหม่

        fetch("../../Booking/DB/BookingSignatureAdmin/Show/" + BookingID)
            .then(response => response.json())
            .then(data => {
                if (data && data.booking_admin_signature) {
                    signaturePad.fromDataURL(data.booking_admin_signature);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // บันทึกลายเซ็น
    $(document).on('click', '#SaveSignatureAdmin', function() {
        const $btn = $(this);
        const originalHtml = $btn.html();
        const BookingID = $('#FormSignatureAdmin').attr('data-idBooking');
        const dataURL = signaturePad.toDataURL('image/png');

        if (signaturePad.isEmpty()) {
            Swal.fire('แจ้งเตือน', 'กรุณาลงลายเซ็นก่อนบันทึก', 'warning');
            return;
        }

        $.ajax({
            url: "../../Booking/DB/BookingSignatureAdmin/Save",
            method: "POST",
            data: {
                BookingID: BookingID,
                signature: dataURL
            },
            beforeSend: function() {
                $btn.html('<span class="spinner-border spinner-border-sm me-1"></span> บันทึก...').addClass("disabled");
            },
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire('สำเร็จ!', 'บันทึกลายเซ็นเรียบร้อยแล้ว', 'success').then(() => {
                        $('#ModalSignatureAdmin').modal('hide');
                    });
                } else {
                    Swal.fire('ผิดพลาด', 'ไม่สามารถบันทึกข้อมูลได้', 'error');
                }
            },
            error: function() {
                Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อ', 'error');
            },
            complete: function() {
                $btn.html(originalHtml).removeClass("disabled");
            }
        });
    });
});
