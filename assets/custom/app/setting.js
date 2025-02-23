document.addEventListener('DOMContentLoaded',function(){
    const setting_form = $('.setting-update');
    setting_form.on('submit', function (r) {
        r.preventDefault();
        var message = $(this).data('message');
        message = message ? message : 'Setting';
        var formData = new FormData(this);
        $.AryaAjax({
            data: formData,
            url: 'cms/update-setting',
            success_message: `${message} Update Successfully.`,
            formData : true
        }).then((rr) => {
            showResponseError(rr);
        });
    });
})