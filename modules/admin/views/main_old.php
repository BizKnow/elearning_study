<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="{base_url}assets/images/favicon.png" type="image/x-icon">
  <link rel="shortcut icon" href="{base_url}assets/images/favicon.png" type="image/x-icon">
  <title><?= $this->ki_theme->get_title() ?> - Admin Panel</title>
  <!-- Google font -->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
    rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/font-awesome.css">
  <!-- ico-font-->
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/icofont.css">
  <!-- Themify icon-->
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/themify.css">
  <!-- Flag icon-->
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/flag-icon.css">
  <!-- Feather icon-->
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/feather-icon.css">
  <!-- Plugins css start-->
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/slick.css">
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/slick-theme.css">
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/scrollbar.css">
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/animate.css">
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/datatables.css">
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/dropzone.css">
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/filepond.css">
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/filepond-plugin-image-preview.css">

  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/datatable-extension.css">
  <!-- Plugins css Ends-->
  <!-- Bootstrap css-->
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/vendors/bootstrap.css">
  <!-- App css-->
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/style.css">
  <link id="color" rel="stylesheet" href="{base_url}assets/css/color-1.css" media="screen">
  <!-- Responsive css-->
  <link rel="stylesheet" type="text/css" href="{base_url}assets/css/responsive.css">
  <script>var base_url = '{base_url}';</script>
  <!-- latest jquery-->
  <script src="{base_url}assets/js/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="https://mark-freq32.c9.io/mark3/js/jquery.ui.touch-punch.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.3/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="{base_url}assets/js/notify/bootstrap-notify.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.min.js"></script>
  <script src="{base_url}assets/custom/jquery.nestable.js"></script>
  <link rel="stylesheet" href="{base_url}assets/custom/custom.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js" integrity="sha512-K/oyQtMXpxI4+K0W7H25UopjM8pzq0yrVdFdG21Fh5dBe91I40pDd9A4lzNlHPHBIP2cwZuoxaUSX0GJSObvGA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" integrity="sha512-MQXduO8IQnJVq1qmySpN87QQkiR1bZHtorbJBD0tzy7/0U9+YIC93QWHeGTEoojMVHWWNkoCp8V6OzVSYrX0oQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
  <!-- loader starts-->
  <div class="loader-wrapper">
    <div class="theme-loader">
      <div class="loader-p"></div>
    </div>
  </div>
  <!-- loader ends-->
  <!-- tap on top starts-->
  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
  <!-- tap on tap ends-->
  <!-- page-wrapper Start-->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    <div class="page-header">
      <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
          <div class="logo-wrapper"><a href="index.html"> <img class="img-fluid for-light"
                src="{base_url}assets/images/logo/logo.png" alt=""><img class="img-fluid for-dark"
                src="{base_url}assets/images/logo/logo_dark.png" alt=""></a></div>
          <div class="toggle-sidebar">
            <svg class="sidebar-toggle">
              <use href="{base_url}assets/svg/icon-sprite.svg#stroke-animation"></use>
            </svg>
          </div>
        </div>
        <form class="col-sm-4 form-inline search-full d-none d-xl-block" action="#" method="get">
          <div class="form-group">
            <div class="Typeahead Typeahead--twitterUsers">
              <div class="u-posRelative">
                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                  placeholder="Type to Search .." name="q" title="" autofocus>
                <svg class="search-bg svg-color">
                  <use href="{base_url}assets/svg/icon-sprite.svg#search"></use>
                </svg>
              </div>
            </div>
          </div>
        </form>
        <div class="nav-right col-xl-8 col-lg-12 col-auto pull-right right-header p-0">
          <ul class="nav-menus">
            <li>
              <a href="{base_url}" target="_blank" class="position-relative">
                <i data-feather="globe"></i>
                <span class="rounded-pill badge-danger"></span>
              </a>
            </li>
            <li>
              <div class="mode">
                <svg class="for-dark">
                  <use href="{base_url}assets/svg/icon-sprite.svg#moon"></use>
                </svg>
                <svg class="for-light">
                  <use href="{base_url}assets/svg/icon-sprite.svg#Sun"></use>
                </svg>
              </div>
            </li>
            <li class="profile-nav onhover-dropdown pe-0 py-0">
              <div class="d-flex align-items-center profile-media"><img class="b-r-25"
                  src="{base_url}assets/images/dashboard/profile.png" alt="">
                <div class="flex-grow-1 user"><span>Helen Walter</span>
                  <p class="mb-0 font-nunito">Admin
                    <svg>
                      <use href="{base_url}assets/svg/icon-sprite.svg#header-arrow-down"></use>
                    </svg>
                  </p>
                </div>
              </div>
              <ul class="profile-dropdown onhover-show-div">
                <li><a href="user-profile.html"><i data-feather="user"></i><span>Account </span></a></li>
                <li><a href="letter-box.html"><i data-feather="mail"></i><span>Inbox</span></a></li>
                <li><a href="task.html"><i data-feather="file-text"></i><span>Taskboard</span></a></li>
                <li><a href="edit-profile.html"><i data-feather="settings"></i><span>Settings</span></a></li>
                <li><a href="login.html"> <i data-feather="log-in"></i><span>Log Out</span></a></li>
              </ul>
            </li>
          </ul>
        </div>
        <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">              
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">{{name}}</div>
            </div>
            </div>
          </script>
        <script class="empty-template"
          type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
      </div>
    </div>
    <!-- Page Header Ends                              -->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <!-- Page Sidebar Start-->
      <div class="sidebar-wrapper" data-layout="stroke-svg">
        <div>
          <div class="logo-wrapper"><a href="index.html"> <img class="img-fluid for-light"
                src="{base_url}assets/images/logo/logo.png" alt=""><img class="img-fluid for-dark"
                src="{base_url}assets/images/logo/logo_dark.png" alt=""></a>
            <div class="toggle-sidebar">
              <svg class="sidebar-toggle">
                <use href="{base_url}assets/svg/icon-sprite.svg#toggle-icon"></use>
              </svg>
            </div>
          </div>
          <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid"
                src="{base_url}assets/images/logo/logo-icon.png" alt=""></a></div>
          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">

              <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="index.html"><img class="img-fluid"
                      src="{base_url}assets/images/logo/logo-icon.png" alt=""></a>
                  <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                      aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-main-title">
                  <div>
                    <h6>Pinned</h6>
                  </div>
                </li>
                {menu_item}


              </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
          </nav>
        </div>
      </div>
      <!-- Page Sidebar Ends-->
      <div class="page-body">
        <div class="container-fluid">
        <?php
            echo $this->ki_theme->get_breadcrumb();
            ?>
          <div class="page-title">
            <div class="row">
              <div class="col-xl-4 col-sm-7 box-col-3">
                <h3>Sample Page</h3>
              </div>
              <div class="col-xl-3 col-sm-5 box-col-4">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">
                      <svg class="stroke-icon">
                        <use href="{base_url}assets/svg/icon-sprite.svg#stroke-home"></use>
                      </svg></a></li>
                  <li class="breadcrumb-item">Pages</li>
                  <li class="breadcrumb-item active">Sample Page</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
          {page_output}
        </div>
        <!-- Container-fluid Ends-->
      </div>
      <!-- footer start-->
      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 p-0 footer-copyright">
              <p class="mb-0">Copyright 2024 © Zono theme by pixelstrap.</p>
            </div>
            <div class="col-md-6 p-0">
              <p class="heart mb-0">Hand crafted &amp; made with
                <svg class="footer-icon">
                  <use href="{base_url}assets/svg/icon-sprite.svg#heart"></use>
                </svg>
              </p>
            </div>
          </div>
        </div>
      </footer>
      <div class="modal fade" tabindex="-1" id="mymodal">
        <form class="modal-dialog  modal-dialog-centered  modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5 title" id="mdModalLabel">Full screen below md</h1>
              <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body body">
              <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline hover-rotate-end btn-outline-dashed btn-outline-danger"
                data-bs-dismiss="modal">Close</button>
              {update_button}
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap js-->
  <script src="{base_url}assets/js/bootstrap/bootstrap.bundle.min.js"></script>
  <!-- feather icon js-->
  <script src="{base_url}assets/js/icons/feather-icon/feather.min.js"></script>
  <script src="{base_url}assets/js/icons/feather-icon/feather-icon.js"></script>
  <!-- scrollbar js-->
  <script src="{base_url}assets/js/scrollbar/simplebar.js"></script>
  <script src="{base_url}assets/js/scrollbar/custom.js"></script>
  <!-- Sidebar jquery-->
  <script src="{base_url}assets/js/config.js"></script>
  <!-- Plugins JS start-->
  <script src="{base_url}assets/js/sidebar-menu.js"></script>
  <script src="{base_url}assets/js/sidebar-pin.js"></script>
  <script src="{base_url}assets/js/animation/tilt/tilt.jquery.js"></script>
  <script src="{base_url}assets/js/slick/slick.min.js"></script>
  <script src="{base_url}assets/js/slick/slick.js"></script>
  <script src="{base_url}assets/js/header-slick.js"></script>
  <!-- Plugins JS Ends-->
  <script src="{base_url}assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/jszip.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/pdfmake.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/vfs_fonts.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.select.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/buttons.html5.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/buttons.print.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
  <script src="{base_url}assets/js/datatable/datatable-extension/dataTables.scroller.min.js"></script>
  <script src="{base_url}assets/js/dropzone/dropzone.js"></script>
  <script src="{base_url}assets/js/dropzone/dropzone-script.js"></script>
  <script src="{base_url}assets/js/filepond/filepond-plugin-image-preview.js"></script>
  <script src="{base_url}assets/js/filepond/filepond-plugin-file-rename.js"></script>
  <script src="{base_url}assets/js/filepond/filepond-plugin-image-transform.js"></script>
  <script src="{base_url}assets/js/filepond/filepond.js"></script>
  <script src="{base_url}assets/js/popular.min.js"></script>
  <!-- Theme js-->
  <script src="{base_url}assets/js/script.js"></script>
  <script src="{base_url}assets/js/theme-customizer/customizer.js"></script>
  <script src="{base_url}assets/custom/custom.js"></script>
  {js_file}
  <!-- Plugin used-->
</body>

</html>