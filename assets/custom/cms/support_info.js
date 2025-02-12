document.addEventListener('DOMContentLoaded', function (e) {
    const page_form = document.getElementById('page_form');
    const table = $('#list');
    // $('.page_setting').addClass('mm-active');
    // $('.add_page').addClass('mm-active');
    var link = '';
    var validation = MyFormValidation(page_form);
    validation.addField('type', {
        validators: {
            notEmpty: {
                message: 'Please Select A Type...'
            }
        }
    });
    validation.addField('title', {
        validators: {
            notEmpty: {
                message: 'Please Enter Title...'
            }
        }
    });
    validation.addField('value', {
        validators: {
            notEmpty: {
                message: 'Please Enter Value...'
            }
        }
    });
    page_form.addEventListener('submit', function (r) {
        r.preventDefault();
        $.AryaAjax({
            validation: validation,
            data: new FormData(page_form),
            url: 'cms/add-support-data',
            success_message: 'Data Added Successfully..',
            page_reload: true
        });
    });

    table.DataTable({
        ajax: {
            url: ajax_url + 'cms/get-support-data'
        },
        columns: [
            { 'data': null },
            { 'data': 'title' },
            { 'data': 'type' },
            { 'data': null }
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    return `${meta.row + 1}.`;
                }
            }, {
                targets: 1,
                render: function (data, type, row, meta) {
                    var url = '';
                    if (row.type == 'mobile') {
                        url = `tel:${row.value}`;
                    }
                    else if (row.type == 'email') {
                        url = `mailto:${row.value}`;
                    }
                    else
                        url = row.value;
                    return `<a target="_blank" href="${url}">${data}</a>`;

                }
            },
            {
                targets : -1,
                orderable : false,
                render : function (data, type, row, meta) {
                    return ` ${deleteBtnRender(1, row.id)}`;
                }
            }
        ]
    }).on('draw',function(){
        handleDeleteRows('cms/delete-support-data').then((e) => table.DataTable().ajax.reload());

    });
});
