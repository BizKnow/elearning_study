document.addEventListener('DOMContentLoaded', function () {
    const courseInputBox = $('select[name="courses[]"]');
    courseInputBox.on('change', function () {
        let totalAmount = 0;

        // Loop through selected options
        $('select[name="courses[]"] option:selected').each(function () {
            // Get the 'amount' attribute and add to the total
            let amount = parseFloat($(this).attr('amount')) || 0;
            totalAmount += amount;
        });

        // Display the total amount
        $('[name="amount"]').val(totalAmount);
    });
    $(document).on('submit', '#form', function (r) {
        r.preventDefault();
        // var form = $(this);
        var formData = new FormData(this);
        $.AryaAjax({
            url: 'course/add-combo',
            data: formData,
            success_message: 'Course Combo Added Successfully..',
            page_reload: true
        }).then((res) => {
            log(res);
            if (!res.status)
                showResponseError(res);
        });
    })
    const table = $('#table');
    const dt = table.DataTable({
        ajax: {
            url: `${ajax_url}course/list-combo`,
            success: function (d) {
                // console.log(d);
                if (d.data && d.data.length) {
                    dt.clear();
                    dt.rows.add(d.data).draw();
                }
                else {
                    toastr.error('Table Data Not Found.');
                    DataTableEmptyMessage(table);
                }
            },
            error: function (a, b, v) {
                console.warn(a.responseText);
            }
        },
        columns: [
            { 'data': null },
            { "data": 'title' },
            { "data": 'amount' },
            // {"data" : 'courses'},
            { "data": null },
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, rowm, meta) {
                    return `${meta.row + 1}.`;
                }
            },
            {
                targets: 2,
                render: function (data) {
                    return `${data} ${inr}`;
                }
            },
            {
                targets: -1,
                render: function (data, type, row) {
                    return deleteBtnRender(1, row.id);

                }
            }
        ]
    }).on('draw', function () {
        const handle = handleDeleteRows('course/delete-combo');
        handle.done(function (e) {
            // console.log(e);
            table.DataTable().ajax.reload();
        });
    })
})