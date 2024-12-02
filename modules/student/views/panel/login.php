<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Student Login - {meta_title}</title>
  <!-- CSS files -->
  <link href="{base_url}assets/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
  <link href="{base_url}assets/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
  <link href="{base_url}assets/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
  <link href="{base_url}assets/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
  <link href="{base_url}assets/dist/css/demo.min.css?1684106062" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400&display=swap">
  <style>
    * {
      font-family: 'Reem Kufi', sans-serif !important;
    }

    .btn-primary {
      background-color: #5c5cc6;
    }

    .btn-primary:hover {
      background-color: #363672 !important;
    }
  </style>
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";

    }
  </style>
</head>

<body class=" d-flex flex-column" style="height:100%!important" data-bs-theme="dark">
  <!-- <script src="{base_url}assets/dist/js/demo-theme.min.js?1684106062"></script> -->
  <div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center mb-4">
        <h1>Student Login</h1>
      </div>
      <div class="card card-md">
        <div class="card-body" style="position:relative">
          <div class="card-status-top bg-yellow"></div>
          <h2 class="h2 text-center mb-4">Login to your account</h2>
          <?php
      if($msg = $this->session->flashdata('msg'))
        echo $msg;
          ?>
          <form action="" class="student-login-form" method="get" autocomplete="off" novalidate>
            <div class="mb-3">
              <label class="form-label">Mobile</label>
              <input type="text" class="form-control" name="mobile" placeholder="Mobile" autocomplete="off">
            </div>
            <div class="mb-2">
              <label class="form-label">
                Password
                <!-- <span class="form-label-description">
                    <a href="./forgot-password.html">I forgot password</a>
                  </span> -->
              </label>
              <input type="password" name="password" class="form-control" placeholder="Your password"
                autocomplete="off">

            </div>
            <!-- <div class="mb-2">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input"/>
                  <span class="form-check-label">Remember me on this device</span>
                </label>
              </div> -->
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Sign in</button>
            </div>
          </form>
        </div>
      </div>
      <!-- <div class="text-center text-muted mt-3">
          Don't have account yet? <a href="./sign-up.html" tabindex="-1">Sign up</a>
        </div> -->
    </div>
  </div>
  <!-- Libs JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- Tabler Core -->
  <script src="{base_url}assets/dist/js/tabler.min.js?1684106062" defer></script>
  <script src="{base_url}assets/dist/js/demo.min.js?1684106062" defer></script>
  <script>
    const base_url = '<?= base_url() ?>';
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
    integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5/bootstrap-4.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <script src="{base_url}assets/custom/custom.js"></script>
  <script src="{base_url}assets/project.js"></script>
  
</body>

</html>