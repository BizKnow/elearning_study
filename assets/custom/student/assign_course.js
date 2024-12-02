document.addEventListener('DOMContentLoaded', function (e) {
    select2Student('select[name="student_id"]');
    const form = $('#fetch-stduent');
    const box = $('#nx');

    form.submit(function(e){
        e.preventDefault();
        // alert($(this).serialize());
        box.html('<i class="fa fa-spin fa-spinner"></i> Load Data...').addClass('fade');
        $.AryaAjax({
            url : 'student/assign-course',
            data : new FormData(this)
        }).then((res) => {           
            box.html(res.html).removeClass('fade');
        });
    });

    $(document).on('click','.do-assign',function(){
        var student_id = $(this).data('student_id');
        var course_id = $(this).data('course_id');
        SwalWarning('Confirmation','Are you sure to assign it',true,'Yes').then((res) => {
            if(res.isConfirmed){
                $.AryaAjax({
                    url : 'student/do-assign-course',
                    data : {student_id,course_id},
                    success_message : 'Course Assigned Successfully...'
                }).then((result) => {
                    showResponseError(result);
                    if(result.status){
                        form.trigger('submit');
                    }
                });
            }
        });
    });
});
