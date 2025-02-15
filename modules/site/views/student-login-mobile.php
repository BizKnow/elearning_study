<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        a {
            color: #ff6f00;
            text-decoration: underline;
            text-align: center;
        }
        div:where(.swal2-container) button:where(.swal2-styled):where(.swal2-confirm){
            background-color: #ff6f00!important
        }
        <?php
        $this->load->library('user_agent');
        if($this->agent->is_mobile()){
            ?>
            body{
                background-color: white!important;
            }
            <?php
        }
        ?>
    </style>
</head>

<body>
    <div class="form-container">
        <div class="logo-container d-flex justify-content-center align-items-center">
            <img src="<?= base_url() ?>upload/smll-logo.png" alt="Colours of Success Logo" class="img-fluid">
        </div>
        <div class="forms-wrapper">
            <!-- Login Form -->
            <div class="login-form">
                <h4 class="welcome-text mt-3">Welcome!</h3>
                    <h5 class="form-title fw-bold mb-4">Login to continue</h5>
                    <?php
                    if (isset($error))
                        echo alert($error, 'danger');
                    ?>
                    <form id="loginForm">
                        <div class="">
                            <label for="mobile" class="form-label">Mobile. No</label>
                            <input type="text" class="form-control" maxlength="10" id="mobile" name="mobile">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    <div class="bottom-links d-flex flex-column">
                        <a href="#" class="register-link mt-3">Register</a>
                        <a href="#" class="my-2 forgot-link">Forgot Password?</a>
                        <div class="footer-links d-flex justify-content-center gap-3">
                            <a href="https://rainboweduzone.com/policy">Privacy Policy</a>
                            <a href="https://rainboweduzone.com/terms">Terms & Conditions</a>
                        </div>
                    </div>
            </div>



            <!-- Register Form -->
            <div class="register-form">
                <h4 class="welcome-text mt-3">Welcome!</h3>
                    <h5 class="form-title fw-bold mb-4">Register to continue</h5>
                    <form id="register">
                        <!-- <div class="">
                            <label for="referrel_id" class="form-label">Referrel Id</label>
                            <input type="text" class="form-control" id="referrel_id" name="referrel_id">
                        </div> -->
                        <div class="">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile. No</label>
                            <input type="text" maxlength="10" class="form-control" id="mobile" name="contact_number">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                    <div class="bottom-links">
                        <a href="#" class="login-link mt-3">Back to Login</a>
                    </div>
            </div>

            <!-- Forgot Password Form -->
            <div class="forgot-form">
                <h4 class="welcome-text mt-3">Forgot Password?</h4>
                <h5 class="form-title fw-bold mb-4">Reset your password</h5>
                <form id="forgot-password">
                    <label for="forgot-email" class="form-label">Enter your Email or Mobile</label>
                    <input type="text" class="form-control" id="forgot-email" name="mobile_or_email">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </form>
                <div class="bottom-links">
                    <a href="#" class="login-link mt-3">Back to Login</a>
                </div>
            </div>

            <!-- OTP Verification Form -->
            <div class="otp-form">
                <h4 class="welcome-text mt-3">OTP Verification</h4>
                <h5 class="form-title fw-bold mb-4 otp-message">Enter the OTP sent to your email</h5>
                <form id="otp-verify">
                    <label for="otp" class="form-label">OTP</label>
                    <input type="hidden" name="student_id">
                    <input type="text" class="form-control" id="otp" name="otp" required>
                    <button type="submit" class="btn btn-primary">Verify OTP</button>
                </form>
                <div class="bottom-links">
                    <a href="#" class="login-link mt-3">Back to Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#register').submit(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Loading..',
                    text: 'Please wait while we submit your data.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '<?= base_url('ajax/website/student_admission') ?>',
                    type: 'POST',
                    data: $('#register').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        Swal.close();
                        if (data.status == 1) {
                            Swal.fire('Success!', data.message, 'success').then(() => {
                                location.href = '<?=base_url('student')?>';
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    }
                });

            })
            $('[name="mobile"],[name="contact_number"]').on("input", function () {
                var value = $(this).val();

                // Allow only numbers
                $(this).val(value.replace(/\D/g, ''));

                // Check if length is greater than 10
                if (value.length > 10) {
                    $(this).val(value.substring(0, 10));
                }
            });
            $('.register-link').click(function (e) {
                e.preventDefault();
                $('.forms-wrapper').addClass('show-register').removeClass('show-forgot show-otp');
            });

            $('.login-link').click(function (e) {
                e.preventDefault();
                $('.forms-wrapper').removeClass('show-register show-forgot show-otp');
            });

            $('.forgot-link').click(function (e) {
                e.preventDefault();
                $('.forms-wrapper').addClass('show-forgot').removeClass('show-register show-otp');
            });

            $('#loginForm').submit(function (e) {
                e.preventDefault();
                // $('.forms-wrapper').addClass('show-otp').removeClass('show-register show-forgot');
            });
            $('#loginForm').submit(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Logging in...',
                    text: 'Please wait while we authenticate.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '<?= base_url('ajax/website/login-with-email-otp') ?>',
                    type: 'POST',
                    data: $('#loginForm').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        Swal.close();
                        if (data.status == 1) {
                            Swal.fire('Success!', data.message, 'success').then(() => {
                                $('.otp-message').html(data.message);
                                $('[name="student_id"]').val(data.student_id);
                                $('.forms-wrapper').addClass('show-otp').removeClass('show-register show-forgot');
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    }
                });
            });
            $('#forgot-password').submit(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Verify Email or mobile...',
                    text: 'Please wait while we verify your details.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '<?= base_url('ajax/website/forgot-password') ?>',
                    type: 'POST',
                    data: $('#forgot-password').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        Swal.close();
                        if (data.status == 1) {
                            Swal.fire('Success!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    }
                });

            })
            $('#otp-verify').submit(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Verify OTP...',
                    text: 'Please wait while we verify OTP.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '<?= base_url('ajax/website/verify-login-otp') ?>',
                    type: 'POST',
                    data: $('#otp-verify').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        Swal.close();
                        if (data.status == 1) {
                            Swal.fire('Success!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    }
                });
            });

        });
    </script>
</body>

</html>