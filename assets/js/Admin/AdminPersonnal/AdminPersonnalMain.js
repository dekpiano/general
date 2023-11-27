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

$(document).on('submit', '#FormPersonnalUpdateDataGeneral', function(e) {
    e.preventDefault();

    $.ajax({
        url: "../../../../Admin/WorkPerson/Personnel/DB/Update/DataGeneral",
        method: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        success: function(res) {
            console.log(res);
            if (res == 1) {
                Swal.fire({
                    title: 'แจ้งเตือน?',
                    text: "อัพเดตข้อมูลสำเร็จ!",
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {

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


$(document).on('change', '#pers_img', function() {

    var fileInput = $('#pers_img')[0].files[0];
    var formData = new FormData();
    formData.append('file', fileInput);
    formData.append('KeyPresID', $(this).attr('key-persid'));
    $.ajax({
        url: "../../../../Admin/WorkPerson/Personnel/DB/Update/Img",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function(res) {
            if (res == 1) {
                Swal.fire(
                    'แจ้งเตือน!', "เปลี่ยนรูปภาพสำเร็จ",
                    'success'
                )
            }
        }
    });
});


var items = document.querySelector('.sortable');
Sortable.create(items, {
    animation: 150,
    chosenClass: "selected",
    ghostClass: "ghost",
    dragClass: "drag",
    onEnd: () => {
        //console.log('an element was inserted');
    },
    group: "cards",
    store: {
        set: (sortable) => {
            const orden = sortable.toArray();
            localStorage.setItem(sortable.options.group.name, orden.join('|'));
            // console.log(orden);

            $.post("../../../../Admin/WorkPerson/Personnel/DB/SortableTeacher", {
                data: orden
            }, function(data, status) {
                console.log("Data: " + data + "\nStatus: " + status);
            });
        },
        //get list order       
        get: (sortable) => {
            const orden = localStorage.getItem(sortable.options.group.name);
            return orden ? orden.split('|') : [];
            console.log(orden);
        }

    }
});