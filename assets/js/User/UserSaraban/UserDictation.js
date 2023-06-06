ShowDataInstruction();

function ShowDataInstruction() {
    $('.TbDataInstruction').DataTable({
        'processing': true,
        'serverMethod': 'post',
        'ajax': {
            'url': '../../User/Dictation/ShowData'
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
            }

        ]
    });
}