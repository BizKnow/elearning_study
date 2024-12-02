<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin Login" name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{base_url}assets/assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="{base_url}assets/assets/js/config.js"></script>

    <!-- Vendor css -->
    <link href="{base_url}assets/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{base_url}assets/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <script>var base_url = `{base_url}`;</script>
    <link href="{base_url}assets/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">

                    <h3 class="fw-semibold mb-2">Login your account</h3>

                    <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>


                    <form action="" class="text-start mb-3 theme-form login">
                        <div class="mb-3">
                            <label class="form-label" for="example-email">Email</label>
                            <input type="email" id="example-email" name="username" class="form-control"
                                placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="example-password">Password</label>
                            <input type="password" id="example-password" class="form-control"
                                placeholder="Enter your password" name="password">
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>

                            <!-- <a href="auth-recoverpw.html" class="text-muted border-bottom border-dashed">Forget Password</a> -->
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>

                    <!-- <p class="text-danger fs-14 mb-4">Don't have an account? <a href="auth-register.html" class="fw-semibold text-dark ms-1">Sign Up !</a></p> -->

                    <!-- <p class="mt-auto mb-0">
                        <script>document.write(new Date().getFullYear())</script> © Osen - By <span class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">Coderthemes</span>
                    </p> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="{base_url}assets/assets/js/vendor.min.js"></script>

    <!-- App js --><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css" rel="stylesheet">

    <script src="{base_url}assets/assets/js/app.js"></script>
    <script src="{base_url}assets/custom/custom.js"></script>

</body>

</html>