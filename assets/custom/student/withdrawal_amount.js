document.addEventListener('DOMContentLoaded',function(){
    const form =  document.getElementById('withdrawal-form');
    
    $(form).on('submit',function(r){
        r.preventDefault();
        $.AryaAjax({
            url : 'student/withdrawal-amount',
            data : new FormData(this),
        }).then((res) => {
            log(res)
            if(res.status){

            }
            showResponseError(res);
        });
    })

})