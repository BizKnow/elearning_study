document.addEventListener('DOMContentLoaded',function(){
    const withdrawal_status = $('[name="withdrawal_status"]')

    withdrawal_status.on('change',function(){
        // alert(this.value);
        var status = $(this).val();
        if(status > 0){
            if(status == 1){
                $('#transcation_id').show().find('input').attr('required','required');
                $('#reason-box').hide().find('input').removeAttr('required');
            }
            else{
                $('#transcation_id').hide().find('input').removeAttr('required');
                $('#reason-box').show().find('input').attr('required','required');
            }
        }
        else{
            $('#transcation_id,#reason-box').hide().find('input').removeAttr('required');
        }
    })
    $(document).on('submit','.withdrawal-request',function(r){
        r.preventDefault();
        $.AryaAjax({
            url : 'student/withdrawal-request-accept',
            data : new FormData(this)
        }).then(re => {
            log(re);
            if(re.status){

            }
            showResponseError(re);
        });
    })
})