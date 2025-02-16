

$(document).ready(function () {

    $(document).on('click', '.print-btn', function (e) {
        e.preventDefault();
        window.print();
    })
    $(document).on('submit', '.student-admission-form', function (e) {
        e.preventDefault();
        $.AryaAjax({
            url: 'website/student-admission',
            data: new FormData(this),
        }).then((r) => {
            if (r.status) {
                mySwal('Registration Successfully..', `
                   
                `).then((res) => {
                    if (res.isConfirmed) {
                        // location.reload();
                        location.href = r.url;
                    }
                });
                // location.href = r.url;
            }
            showResponseError(r);
        });
    })
    $(document).on('click', '.paynow', function (e) {
        e.preventDefault();
        var token = $(this).data('token');
        // alert(token)
        $.AryaAjax({
            url: 'website/student-course-payment',
            data: { token: token },
        }).then(R => {
            showResponseError(R);
            if (R.status) {
                var options = R.option;
                options.handler = function (response) {
                    $.AryaAjax({
                        url: 'website/update-course-payment',
                        data: {
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: options.order_id,
                            razorpay_signature: response.razorpay_signature,
                            merchant_order_id: options.notes.merchant_order_id,
                            amount: options.amount
                        }
                    }).then((res) => {
                        showResponseError(res);
                        if (res.status) {
                            SwalSuccess('Success!', 'Course Purchased Successfully..');
                            // location.reload();
                            location.href = `${base_url}student/dashboard`;
                        }
                    });
                };
                razorpayPOPUP(options);
            }
        });
    })
    $(document).ready(function () {

        $('.login-with-otp').click(function () {
            Swal.fire({
                title: 'Enter your phone number:',
                input: 'number',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Send OTP',
                showLoaderOnConfirm: true,
                preConfirm: (phoneNumber) => {
                    return new Promise((resolve, reject) => {

                        $.ajax({
                            url: ajax_url + 'website/verify_student_phone',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                phoneNumber: phoneNumber
                            },
                            success: function (response) {
                                // log(response);
                                if (response.status != 'success') {
                                    Swal.showValidationMessage(`The Mobile number is not found..`)
                                }
                                resolve();
                            },
                            error: function (xhr, error, status) {
                                log(xhr.responseText)
                            }
                        });

                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'OTP Sent!',
                        text: 'Please check your phone for the OTP.',
                        icon: 'success',
                        confirmButtonText: 'Enter OTP'
                    }).then(() => {
                        Swal.fire({
                            title: 'Enter OTP:',
                            input: 'text',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Verify OTP',
                            showLoaderOnConfirm: true,
                            preConfirm: (otp) => {
                                return new Promise((resolve, reject) => {
                                    $.ajax({
                                        url: ajax_url + 'website/verify_login_otp',
                                        type: 'POST',
                                        data: { otp: otp, phoneNumber: result.value },
                                        dataType: 'json',
                                        success: function (response) {
                                            // log(response);
                                            if (response.status != 'success') {
                                                Swal.showValidationMessage(`Invalid Otp.`)
                                            }
                                            resolve();
                                        }
                                    })
                                });
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((otpResult) => {
                            if (otpResult.isConfirmed) {
                                Swal.fire('Verified!', 'Your phone number has been verified, Redirect to Your Dashboard Click to Ok', 'success').then((e) => {
                                    if (e.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    });
                }
            });
        });
    });

    // alert(3)
    $(document).on('submit', '.student-login-form', function (r) {
        r.preventDefault();
        $.AryaAjax({
            url: 'website/student-login-form',
            data: new FormData(this)
        }).then((res) => {
            showResponseError(res);
            // log(res)
            if (res.status) {
                mySwal(`Welcome <b>${res.student_name}</b>`, 'Student Login Successfully.').then((r) => {
                    if (r.isConfirmed) {
                        // location.href = `${base_url}student/dashboard`;
                        location.reload();
                    }
                })
            }
        });
    });

    $(document).on('click', '.show-course', function () {
        var courses = $(this).data('courses');
        const parts = courses.split('|');
        document.getElementById("subjectList").innerHTML = '';
        document.getElementById('smTitle').innerHTML = 'Courses of ' + $(this).data('title');

        $.each(parts, function (index, value) {
            // log(value)
            document.getElementById("subjectList").innerHTML += `<li class="list-group-item">${value}</li>`;
        });
        var subjectModal = new bootstrap.Modal(document.getElementById('mymodal'));
        // alert(4);

        // document.getElementById('smTitle').innerHTML = ' Courses';

        subjectModal.show();
    })
    /*===================================*
      08. CONTACT FORM JS
      *===================================*/





    const myDataTable = $('.my-data-table');
    if (myDataTable) {
        myDataTable.DataTable({
            dom: small_dom,
            "pagingType": "full_numbers",
            "language": {
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
    }
});