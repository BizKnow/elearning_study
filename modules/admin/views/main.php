<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $this->ki_theme->get_title() ?> - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- Icons css -->
    <link href="{base_url}assets/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{base_url}assets/assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="{base_url}assets/assets/js/config.js"></script>

    <!-- Vendor css -->
    <link href="{base_url}assets/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <link href="{base_url}assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{base_url}assets/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link rel="stylesheet" href="{base_url}assets/icon-picker/dist/iconpicker-1.5.0.css">
    <script src="{base_url}assets/icon-picker/dist/iconpicker-1.5.0.js"></script>
    <link href="{base_url}assets/custom/custom.css" rel="stylesheet" type="text/css" />

    <script>var base_url = '{base_url}',login_type = 'admin';</script>
    
    <style>
        :root {
            --bs-danger: rgb(255, 0, 0, 1);
            --bs-body-bg: var(--osen-secondary-bg);
            --bs-danger-rgb: 255, 0, 0;
        }
        .custom_setting_input {
    font-size: 21px;
    background: transparent;
    border: 0;
    outline: 0;
}
        .m-h-100px{
            min-height: 75px;
        }
        .h-60px{
            height: 60px;
        }
        .w-60px{
            width: 60px;;
        }
        label.required{
            position: relative
        }
        label.required::after{
            content:'*';
            color: red;
            margin-left: 3px;
            position: absolute;
            top:-2px
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 20px !important
        }

        .radio-wrapper {
            list-style: none;
        }

        button span.indicator-progress,
        .card-toolbar.rotate-180 {
            display: none
        }
    </style>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- Sidenav Menu Start -->
        <div class="sidenav-menu">

            <!-- Brand Logo -->
            <a href="" class="logo">
                <span class="logo-light">
                    <span class="logo-lg"><img src="<?= $logo = logo() ?>" alt="logo"></span>
                    <!-- <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span> -->
                </span>

                <span class="logo-dark">
                    <span class="logo-lg"><img src="<?= $logo ?>" alt="dark logo"></span>
                    <!-- <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span> -->
                </span>
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <button class="button-sm-hover">
                <i class="ti ti-circle align-middle"></i>
            </button>

            <!-- Full Sidebar Menu Close Button -->
            <button class="button-close-fullsidebar">
                <i class="ti ti-x align-middle"></i>
            </button>

            <div data-simplebar>

                <!--- Sidenav Menu -->
                <ul class="side-nav">
                    {menu_item}
                </ul>

                <!-- Help Box -->
                <div class="help-box text-center d-none">
                    <img src="assets/images/coffee-cup.svg" height="90" alt="Helper Icon Image" />
                    <h5 class="mt-3 fw-semibold fs-16">Unlimited Access</h5>
                    <p class="mb-3 text-muted">Upgrade to plan to get access to unlimited reports</p>
                    <a href="javascript: void(0);" class="btn btn-danger btn-sm">Upgrade</a>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Sidenav Menu End -->


        <!-- Topbar Start -->
        <header class="app-topbar">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">

                    <!-- Brand Logo -->
                    <a href="" class="logo">
                        <span class="logo-light">
                            <span class="logo-lg"><img src="<?= $logo ?>" alt="logo"></span>
                            <!-- <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span> -->
                        </span>

                        <span class="logo-dark">
                            <span class="logo-lg"><img src="<?= $logo ?>" alt="dark logo"></span>
                            <!-- <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span> -->
                        </span>
                    </a>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="sidenav-toggle-button px-2">
                        <i class="ti ti-menu-deep fs-24"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="topnav-toggle-button px-2" data-bs-toggle="collapse"
                        data-bs-target="#topnav-menu-content">
                        <i class="ti ti-menu-deep fs-22"></i>
                    </button>


                </div>

                <div class="d-flex align-items-center gap-2">



                    <!-- Notification Dropdown -->
                    <div class="topbar-item d-none">
                        <div class="dropdown">
                            <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                data-bs-offset="0,25" type="button" data-bs-auto-close="outside" aria-haspopup="false"
                                aria-expanded="false">
                                <i class="ti ti-bell animate-ring fs-22"></i>
                                <span class="noti-icon-badge"></span>
                            </button>

                            <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg"
                                style="min-height: 300px;">
                                <div class="p-3 border-bottom border-dashed">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold"> Notifications</h6>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle drop-arrow-none link-dark"
                                                    data-bs-toggle="dropdown" data-bs-offset="0,15"
                                                    aria-expanded="false">
                                                    <i class="ti ti-settings fs-22 align-middle"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Mark as Read</a>
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Delete All</a>
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Do not
                                                        Disturb</a>
                                                    <!-- item-->
                                                    <a href="javascript:void(0);" class="dropdown-item">Other
                                                        Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="position-relative z-2 card shadow-none rounded-0" style="max-height: 300px;"
                                    data-simplebar>
                                    <!-- item-->
                                    <div class="dropdown-item notification-item py-2 text-wrap active"
                                        id="notification-1">
                                        <span class="d-flex align-items-center">
                                            <span class="me-3 position-relative flex-shrink-0">
                                                <img src="assets/images/users/avatar-2.jpg"
                                                    class="avatar-md rounded-circle" alt="" />
                                                <span
                                                    class="position-absolute rounded-pill bg-danger notification-badge">
                                                    <i class="ti ti-message-circle"></i>
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">Glady Haid</span> commented on <span
                                                    class="fw-medium text-body">paces admin status</span>
                                                <br />
                                                <span class="fs-12">25m ago</span>
                                            </span>
                                            <span class="notification-item-close">
                                                <button type="button"
                                                    class="btn btn-ghost-danger rounded-circle btn-sm btn-icon"
                                                    data-dismissible="#notification-1">
                                                    <i class="ti ti-x fs-16"></i>
                                                </button>
                                            </span>
                                        </span>
                                    </div>

                                    <!-- item-->
                                    <div class="dropdown-item notification-item py-2 text-wrap" id="notification-2">
                                        <span class="d-flex align-items-center">
                                            <span class="me-3 position-relative flex-shrink-0">
                                                <img src="assets/images/users/avatar-4.jpg"
                                                    class="avatar-md rounded-circle" alt="" />
                                                <span class="position-absolute rounded-pill bg-info notification-badge">
                                                    <i class="ti ti-currency-dollar"></i>
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">Tommy Berry</span> donated <span
                                                    class="text-success">$100.00</span> for <span
                                                    class="fw-medium text-body">Carbon removal program</span>
                                                <br />
                                                <span class="fs-12">58m ago</span>
                                            </span>
                                            <span class="notification-item-close">
                                                <button type="button"
                                                    class="btn btn-ghost-danger rounded-circle btn-sm btn-icon"
                                                    data-dismissible="#notification-2">
                                                    <i class="ti ti-x fs-16"></i>
                                                </button>
                                            </span>
                                        </span>
                                    </div>

                                    <!-- item-->
                                    <div class="dropdown-item notification-item py-2 text-wrap" id="notification-3">
                                        <span class="d-flex align-items-center">
                                            <div class="avatar-md flex-shrink-0 me-3">
                                                <span
                                                    class="avatar-title bg-success-subtle text-success rounded-circle fs-22">
                                                    <iconify-icon icon="solar:wallet-money-bold-duotone"></iconify-icon>
                                                </span>
                                            </div>
                                            <span class="flex-grow-1 text-muted">
                                                You withdraw a <span class="fw-medium text-body">$500</span> by <span
                                                    class="fw-medium text-body">New York ATM</span>
                                                <br />
                                                <span class="fs-12">2h ago</span>
                                            </span>
                                            <span class="notification-item-close">
                                                <button type="button"
                                                    class="btn btn-ghost-danger rounded-circle btn-sm btn-icon"
                                                    data-dismissible="#notification-3">
                                                    <i class="ti ti-x fs-16"></i>
                                                </button>
                                            </span>
                                        </span>
                                    </div>

                                    <!-- item-->
                                    <div class="dropdown-item notification-item py-2 text-wrap" id="notification-4">
                                        <span class="d-flex align-items-center">
                                            <span class="me-3 position-relative flex-shrink-0">
                                                <img src="assets/images/users/avatar-7.jpg"
                                                    class="avatar-md rounded-circle" alt="" />
                                                <span
                                                    class="position-absolute rounded-pill bg-secondary notification-badge">
                                                    <i class="ti ti-plus"></i>
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">Richard Allen</span> followed you in
                                                <span class="fw-medium text-body">Facebook</span>
                                                <br />
                                                <span class="fs-12">3h ago</span>
                                            </span>
                                            <span class="notification-item-close">
                                                <button type="button"
                                                    class="btn btn-ghost-danger rounded-circle btn-sm btn-icon"
                                                    data-dismissible="#notification-4">
                                                    <i class="ti ti-x fs-16"></i>
                                                </button>
                                            </span>
                                        </span>
                                    </div>

                                    <!-- item-->
                                    <div class="dropdown-item notification-item py-2 text-wrap" id="notification-5">
                                        <span class="d-flex align-items-center">
                                            <span class="me-3 position-relative flex-shrink-0">
                                                <img src="assets/images/users/avatar-10.jpg"
                                                    class="avatar-md rounded-circle" alt="" />
                                                <span
                                                    class="position-absolute rounded-pill bg-danger notification-badge">
                                                    <i class="ti ti-heart-filled"></i>
                                                    <span class="visually-hidden">unread messages</span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1 text-muted">
                                                <span class="fw-medium text-body">Victor Collier</span> liked you recent
                                                photo in <span class="fw-medium text-body">Instagram</span>
                                                <br />
                                                <span class="fs-12">10h ago</span>
                                            </span>
                                            <span class="notification-item-close">
                                                <button type="button"
                                                    class="btn btn-ghost-danger rounded-circle btn-sm btn-icon"
                                                    data-dismissible="#notification-5">
                                                    <i class="ti ti-x fs-16"></i>
                                                </button>
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                <div style="height: 300px;"
                                    class="d-flex align-items-center justify-content-center text-center position-absolute top-0 bottom-0 start-0 end-0 z-1">
                                    <div>
                                        <iconify-icon icon="line-md:bell-twotone-alert-loop"
                                            class="fs-80 text-secondary mt-2"></iconify-icon>
                                        <h4 class="fw-semibold mb-0 fst-italic lh-base mt-3">Hey! 👋 <br />You have no
                                            any notifications</h4>
                                    </div>
                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item notification-item position-fixed z-2 bottom-0 text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>


                    <!-- Button Trigger Customizer Offcanvas -->
                    <div class="topbar-item d-none d-sm-flex">
                        <button class="topbar-link" data-bs-toggle="offcanvas"
                            data-bs-target="#theme-settings-offcanvas" type="button">
                            <i class="ti ti-settings fs-22"></i>
                        </button>
                    </div>

                    <!-- Light/Dark Mode Button -->
                    <div class="topbar-item d-none d-sm-flex">
                        <button class="topbar-link" id="light-dark-mode" type="button">
                            <i class="ti ti-moon fs-22"></i>
                        </button>
                    </div>

                    <!-- User Dropdown -->
                    <div class="topbar-item nav-user">
                        <div class="dropdown">
                            <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown"
                                data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?=logo()?>" width="32"
                                    class="rounded-circle me-lg-2 d-flex" alt="user-image">
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    <h5 class="my-0">Admin</h5>
                                    <h6 class="my-0 fw-normal">Premium</h6>
                                </span>
                                <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome Admin!</h6>
                                </div>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item active fw-semibold text-danger">
                                    <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                    <span class="align-middle">Sign Out</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-transparent">
                    <div class="card mb-1">
                        <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                            <i class="ti ti-search fs-22"></i>
                            <input type="search" class="form-control border-0" id="search-modal-input"
                                placeholder="Search for actions, people,">
                            <button type="button" class="btn p-0" data-bs-dismiss="modal"
                                aria-label="Close">[esc]</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">

            <div class="page-container">


                <?php
                echo $this->ki_theme->get_breadcrumb();
                ?>


                {page_output}

            </div> <!-- container -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6 text-end">
                            <script>document.write(new Date().getFullYear())</script> © <span
                                class="fw-bold text-decoration-underline text-uppercase text-reset fs-12">S.N. Digital Hub</span>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" 
    <?= $this->ki_theme->drawer_main_div_attr() ?>
    data-kt-drawer-name="set_in_page"
    >
        <div class="offcanvas-header">
            <h4 class="offcanvas-title title" id="offcanvasExampleLabel">Offcanvas</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div> <!-- end offcanvas-header-->

        <div class="offcanvas-body body">
        </div> <!-- end offcanvas-body-->
    </div>
    <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
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
    </div><!-- /.modal -->
    <!-- Vendor js -->
    <script src="{base_url}assets/assets/js/vendor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"
    integrity="sha512-6JR4bbn8rCKvrkdoTJd/VFyXAN4CE9XMtgykPWgKiHjou56YDJxWsi90hAeMTYxNwUnKSQu9JPc3SQUg+aGCHw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
    .tox-promotion {
        display: none !important;
    }
</style>
    <script src="{base_url}assets/assets/js/app.js"></script>

    <!-- App js -->
    <link href="{base_url}assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.min.js"></script>

    <script src="{base_url}assets/plugins/global/plugins.bundle.js"></script>
    <script src="{base_url}assets/plugins/global/plugins.bundle.js"></script>
    <script src="{base_url}assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="{base_url}assets/custom/jquery.nestable.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>

    <script src="{base_url}assets/custom/jquery.nestable.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/formvalidation@0.6.2-dev/dist/js/formValidation.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/formvalidation@0.6.2-dev/dist/css/formValidation.min.css" rel="stylesheet"> -->
    <script src="{base_url}assets/custom/custom.js"></script>
    {js_file}

</body>

</html>