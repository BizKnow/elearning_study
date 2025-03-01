document.addEventListener('DOMContentLoaded', function () {
    const notification_list = $('#notification_list');
    // const form = document.getElementById('');
    // var validation = MyFormValidation(form);
    $(document).on('submit', '#live-notification', function () {
        $.AryaAjax({
            url: 'add-notification',
            data: new FromData(this),
            page_reload: true,
            success_message: 'Notification Added Successfully..'
        }).then((res) => showResponseError(res));
    })
    // alert(3);
    var dt = notification_list.DataTable({
        dom: small_dom,
        ajax: {
            url: ajax_url + 'live-notifications',
        },
        columns: [
            { 'data': null },
            { 'data': 'title' },
            { 'data': 'starttime' },
            { 'data': 'endtime' },
            { 'data': null }
        ],
        columnDefs: [
            {
                target: 0,
                render: function (data, type, row, meta) {
                    return `${meta.row + 1}.`;
                }
            },
            {
                targets: 2,
                render: function (data, type, row) {
                    return data != null ? moment(data).format('YYYY-MM-DD HH:mm:ss') : '';
                }
            },
            {
                target: 3,
                render: function (data, type, row) {
                    return data != null ? moment(data).format('YYYY-MM-DD HH:mm:ss') : '';
                }
            },
            {
                target: -1,
                orderable: false,
                render: function (data, type, row) {
                    return deleteBtnRender(1, row.id);
                }
            }
        ]
    });
    dt.on('draw', function (r) {
        handleDeleteRows('delete-live-notifications').then((e) => notification_list.DataTable().ajax.reload())
    })
})