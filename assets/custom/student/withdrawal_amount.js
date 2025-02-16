document.addEventListener('DOMContentLoaded',function(){
    const form =  document.getElementById('withdrawal-form');
    
    $(form).on('submit',function(r){
        r.preventDefault();
        $.AryaAjax({
            url : 'website/withdrawal-amount',
            data : new FormData(this),
        }).then((res) => {
            log(res)
            if(res.status){
                SwalSuccess('Request Submit Successfully..',false,'OK').then((res) => {
                    if(res.isConfirmed){
                        location.reload();
                    }
                });
            }
            showResponseError(res);
        });
    })

})