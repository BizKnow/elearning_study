<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard - {meta_title}</title>
    <!-- CSS files -->
    <link href="{base_url}assets/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="{base_url}assets/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="{base_url}assets/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="{base_url}assets/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="{base_url}assets/dist/css/demo.min.css?1684106062" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400&display=swap">
    <style>
        * {
            /* font-family: 'Reem Kufi', sans-serif !important; */
        }

        .btn-primary {
            background-color: #5c5cc6;
        }

        .btn-primary:hover {
            background-color: #363672 !important;
        }
        .avatar{
            background-size:100% 100%
        }
        @media (max-width: 768px) {
            .bottom-nav {
                position: fixed;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 100%;
                background: #182433;
                display: flex;
                justify-content: space-around;
                align-items: center;
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.15);
                border-top: 4px groove #f76707
            }

            /* ✅ Navigation Button */
            .bottom-nav .nav-item {
                flex: 1;
                text-align: center;
                color: white;
                text-decoration: none;
                font-size: 14px;
                padding: 12px 0;
                position: relative;
                transition: all 0.3s ease;
            }

            .bottom-nav .nav-item i {
                display: block;
                font-size: 22px;
                margin-bottom: 3px;
                transition: all 0.3s ease;
            }

            /* ✅ Active Menu Effect - Slightly Lifted */
            .bottom-nav .nav-item.active {
                transform: translateY(-29px);
                color: #f76707;
                border-radius: 20%;
                background: #182433;
                border-top: 4px groove #f76707
            }

            .bottom-nav .nav-item.active::before {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 50%;
                transform: translateX(-50%);
                width: 40px;
                height: 4px;
                background: #f76707;
                border-radius: 5px;
            }

            /* ✅ Hover Effect */
            .bottom-nav .nav-item:hover {
                color: #f76707;
            }

            .bottom-nav .nav-item:hover i {
                transform: scale(1.1);
            }
        }

        /* ✅ Responsive */
        @media (max-width: 500px) {
            .bottom-nav .nav-item {
                font-size: 12px;
            }

            .bottom-nav .nav-item i {
                font-size: 18px;
            }
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

        /* Custom styling for DataTables pagination buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.5em 0.75em;
            /* Adjust padding as needed */
            margin: 0;
            /* Remove default margin */
            font-size: 14px;
            /* Adjust font size as needed */
            border-radius: 4px;
            /* Add rounded corners */
            cursor: pointer;
            margin-right: 9px;
            text-decoration: none;
        }

        /* Style the active page button */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #007bff;
            /* Set background color for active button */
            color: #fff;
            /* Set text color for active button */
        }

        /* Style the hover effect on buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #eee;
            /* Set background color for hover effect */
            color: #333;
            /* Set text color for hover effect */
        }

        /* Adjust the styling of the "Previous" and "Next" buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next {
            border: 1px solid #007bff;
            /* Add border for previous and next buttons */
        }

        /* Style the "Previous" and "Next" buttons on hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover {
            background-color: #007bff;
            /* Set background color for hover effect */
            color: #fff;
            /* Set text color for hover effect */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body data-bs-theme="dark">
    <script src="{base_url}assets/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
        <!-- Navbar -->
        <?php
        /*
       <header class="navbar navbar-expand-md d-print-none sticky-top">
           <div class="container-xl">
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                   aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                   <span class="navbar-toggler-icon"></span>
               </button>

               <div class="navbar-nav flex-row order-md-last">
                   <div class="d-none d-md-flex">
                       <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" data-bs-toggle="tooltip"
                           data-bs-placement="bottom" aria-label="Enable dark mode"
                           data-bs-original-title="Enable dark mode">
                           <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="icon">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path
                                   d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z">
                               </path>
                           </svg>
                       </a>
                       <a href="?theme=light" class="nav-link px-0 hide-theme-light" data-bs-toggle="tooltip"
                           data-bs-placement="bottom" aria-label="Enable light mode"
                           data-bs-original-title="Enable light mode">
                           <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                               fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                               stroke-linejoin="round" class="icon">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                               <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                               <path
                                   d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7">
                               </path>
                           </svg>
                       </a>
                   </div>
                   <div class="nav-item dropdown">
                       <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                           aria-label="Open user menu">
                           <span class="avatar avatar-sm"
                               style="background-image: url({base_url}upload/{image})"></span>
                           <div class="d-none d-xl-block ps-2">
                               <div>{student_name}</div>
                               <div class="mt-1 small text-muted">Student</div>
                           </div>
                       </a>
                       <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                           <a href="{base_url}admin/setting" class="dropdown-item">Settings</a>
                           <a href="{base_url}admin/logout" class="dropdown-item">Logout</a>
                       </div>
                   </div>
               </div>
               <div class="collapse navbar-collapse" id="navbar-menu">
                   <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                       <ul class="navbar-nav">
                           <li class="nav-item <?= $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
                               <a class="nav-link" href="{base_url}student">
                                   <span
                                       class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                       <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                           viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                           stroke-linecap="round" stroke-linejoin="round">
                                           <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                           <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                           <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                           <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                       </svg>
                                   </span>
                                   <span class="nav-link-title">
                                       Dashboard
                                   </span>
                               </a>
                           </li>
                           <li class="nav-item <?= $this->router->fetch_method() == 'profile' ? 'active' : '' ?>">
                               <a class="nav-link" href="{base_url}student/profile">
                                   <span
                                       class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/ghost -->
                                       <svg xmlns="http://www.w3.org/2000/svg"
                                           class="icon icon-tabler icon-tabler-report" width="24" height="24"
                                           viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                           stroke-linecap="round" stroke-linejoin="round">
                                           <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                           <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" />
                                           <path d="M18 14v4h4" />
                                           <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" />
                                           <path
                                               d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                           <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                           <path d="M8 11h4" />
                                           <path d="M8 15h3" />
                                       </svg>
                                   </span>
                                   <span class="nav-link-title">
                                       My Profile
                                   </span>
                               </a>
                           </li>
                           <li
                               class="nav-item <?= $this->router->fetch_method() == 'study-material' ? 'active' : '' ?>">
                               <a class="nav-link" href="{base_url}student/study-material">
                                   <span
                                       class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/ghost -->
                                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                           viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                           stroke-linecap="round" stroke-linejoin="round"
                                           class="icon icon-tabler icons-tabler-outline icon-tabler-screen-share">
                                           <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                           <path
                                               d="M21 12v3a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h9" />
                                           <path d="M7 20l10 0" />
                                           <path d="M9 16l0 4" />
                                           <path d="M15 16l0 4" />
                                           <path d="M17 4h4v4" />
                                           <path d="M16 9l5 -5" />
                                       </svg>
                                   </span>
                                   <span class="nav-link-title">
                                       Study Material
                                   </span>
                               </a>
                           </li>
                           <li
                               class="nav-item <?= $this->router->fetch_method() == 'study-material' ? 'active' : '' ?>">
                               <a class="nav-link" href="{base_url}student/refer-to-earn">
                                   <span
                                       class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/ghost -->
                                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                           viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                           stroke-linecap="round" stroke-linejoin="round"
                                           class="icon icon-tabler icons-tabler-outline icon-tabler-wallet">
                                           <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                           <path
                                               d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                                           <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                                       </svg>
                                   </span>
                                   <span class="nav-link-title">
                                       Refer to Earn
                                   </span>
                               </a>
                           </li>
                       </ul>
                   </div>
               </div>
           </div>
       </header>
       */
        ?>
        <aside class="navbar navbar-vertical navbar-expand-lg sticky-top" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                    aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href="{base_url}student/dashboard">
                        {student_name}
                        <!-- <img src="./static/logo.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image"> -->
                    </a>
                </h1>
                <div class="navbar-nav flex-row order-md-last d-md-none">
                    <div class="nav-item d-md-flex me-3">
                        <div class="btn-list">
                            <a href="{base_url}student/wallet" class="btn btn-6" rel="noreferrer">
                                Wallet
                                <?= $wallet = $this->db->select('wallet')->where('id', $this->session->userdata('student_id'))->get('students')->row('wallet') ?>&nbsp;
                                {inr}
                            </a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                style="background-image: url({base_url}upload/{image})"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{student_name}</div>
                                <div class="mt-1 small text-muted">Student</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <!-- <a href="#" class="dropdown-item">Status</a>
                            <a href="./profile.html" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Feedback</a>
                            <div class="dropdown-divider"></div> -->
                            <a href="{base_url}student/profile" class="dropdown-item">Profile</a>
                            <a href="{base_url}student/sign_out" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="<?= $this->router->fetch_method() == 'index' ? 'active' : '' ?> nav-item"><a
                                class="nav-link" href="{base_url}student/index">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fa fa-home"></i>
                                </span>
                                <span class="nav-link-title">Dashboard</span></a>
                        </li>
                        <li class="<?= $this->router->fetch_method() == 'profile' ? 'active' : '' ?> nav-item"><a
                                class="nav-link" href="{base_url}student/profile">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fa fa-user"></i>
                                </span>
                                <span class="nav-link-title">Profile</span></a>
                        </li>

                        <li class="<?= $this->router->fetch_method() == 'study_material' ? 'active' : '' ?> nav-item"><a
                                class="nav-link" href="{base_url}student/study-material">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fa fa-book-open"></i>
                                </span>
                                <span class="nav-link-title">Study Material</span></a>
                        </li>
                        <li class="<?= $this->router->fetch_method() == 'refer_to_earn' ? 'active' : '' ?> nav-item"><a
                                class="nav-link" href="{base_url}student/refer-to-earn">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fa fa-wallet"></i>
                                </span>
                                <span class="nav-link-title">Refer to earn</span></a>
                        </li>

                        <li class=" nav-item"><a class="nav-link" href="{base_url}student/sign-out">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="fa fa-power-off"></i>
                                </span>
                                <span class="nav-link-title">Logout</span></a>
                        </li>

                    </ul>
                </div>
            </div>
        </aside>
        <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item d-md-flex me-3">
                        <div class="btn-list">
                            <a href="{base_url}student/wallet" class="btn btn-6" rel="noreferrer">
                                Wallet <?= $wallet ?>&nbsp; {inr}
                            </a>
                        </div>
                    </div>
                    <div class="d-none d-md-flex">
                        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z">
                                </path>
                            </svg>
                        </a>
                        <a href="?theme=light" class="nav-link px-0 hide-theme-light" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" aria-label="Enable light mode"
                            data-bs-original-title="Enable light mode">
                            <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path
                                    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7">
                                </path>
                            </svg>
                        </a>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                style="background-image: url({base_url}upload/{image})"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{student_name}</div>
                                <div class="mt-1 small text-muted">Student</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <!-- <a href="#" class="dropdown-item">Status</a>
                            <a href="./profile.html" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Feedback</a>
                            <div class="dropdown-divider"></div> -->
                            <a href="{base_url}student/profile" class="dropdown-item">Profile</a>
                            <a href="{base_url}student/sign_out" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <div>
                        <form action="./" method="get" autocomplete="off" novalidate="">
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                        <path d="M21 21l-6 -6"></path>
                                    </svg>
                                </span>
                                <input type="text" value="" class="form-control" placeholder="Search…"
                                    aria-label="Search in website">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-wrapper">
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <?php
                    if ($successMessage = $this->session->flashdata('success'))
                        echo alert($successMessage, 'success mb-2');

                    if ($successMessage = $this->session->flashdata('error'))
                        echo alert($successMessage, 'danger mb-2');
                    $class = strtolower($this->router->fetch_method());
                    ?>
                    {page_output}
                </div>
            </div>
            <div class="bottom-nav d-md-none">
                <a href="{base_url}student/dashboard" class="nav-item <?= $class == 'dashboard' ? 'active' : '' ?>"><i
                        class="fas fa-book"></i> Course(s)</a>
                <a href="{base_url}student/wallet" class="nav-item <?= $class == 'wallet' ? 'active' : '' ?>"><i
                        class="fas fa-wallet"></i> Wallet</a>
                <a href="{base_url}student/profile" class="nav-item <?= $class == 'profile' ? 'active' : '' ?>"><i
                        class="fas fa-user "></i> Profile</a>
                <a href="{base_url}student/refer-to-earn"
                    class="nav-item <?= $class == 'refer_to_earn' ? 'active' : '' ?>"><i class="fas fa-inr"></i> Refer To
                    Earn</a>
                <a href="{base_url}student/help" class="nav-item  <?= $class == 'help' ? 'active' : '' ?>"><i
                        class="fas fa-question-circle"></i> Help</a>
            </div>
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">

                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy;
                                    <?= date('Y') ?>
                                    <a href="#" class="link-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon text-pink icon-filled icon-inline" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572">
                                            </path>
                                        </svg>
                                        S.N. Digital Hub</a>.
                                    All rights reserved.
                                </li>
                                <!-- <li class="list-inline-item">
                                    <a href="./changelog.html" class="link-secondary" rel="noopener">
                                        v1.0.0-beta19
                                    </a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEnd" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvasEndLabel">User Details</h2>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">

        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Resume</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Tabler Core -->
    <script src="{base_url}assets/dist/libs/tinymce/tinymce.min.js?1684106062" defer></script>
    <script src="{base_url}assets/dist/libs/litepicker/dist/litepicker.js?1684106062" defer></script>
    <script src="{base_url}assets/dist/js/tabler.min.js?1684106062" defer></script>
    <script src="{base_url}assets/dist/js/demo.min.js?1684106062" defer></script>
    <script>
        const base_url = '<?= base_url() ?>';
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" integrity="sha512-BMbq2It2D3J17/C7aRklzOODG1IQ3+MHw3ifzBHMBwGO/0yUqYmsStgBjI0z5EYlaDEFnvYV7gNYdD3vFLRKsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
        integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.foundation.min.css" integrity="sha512-jyhJOXPqmwwlzhhy2/7edoig3tkyTClebiDZsV2zGb5k4nBol09WyZhK7w1KLl11q79UJjPWgybVu1m52cVehw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.jqueryui.min.css" integrity="sha512-x2AeaPQ8YOMtmWeicVYULhggwMf73vuodGL7GwzRyrPDjOUSABKU7Rw9c3WNFRua9/BvX/ED1IK3VTSsISF6TQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5/bootstrap-4.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <!-- <script src="{base_url}assets/common.js"></script>
    <script src="{base_url}assets/admin.js"></script> -->
    <script>
        $(document).on('click', 'a.my-link', function (e) {
            e.preventDefault();
            // alert(this.id);
            var type = this.id,
                selectedURL = this.href;
            // alert(href);
            switch (type) {
                case 'whatsapp':
                    const whatsappURL = `https://wa.me/?text=${encodeURIComponent(selectedURL)}`;
                    window.open(whatsappURL, "_blank");
                    break;
                case 'facebook':
                    const facebookURL = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(selectedURL)}`;
                    window.open(facebookURL, "_blank");
                    break;
                case 'twitter':
                    const twitterURL = `https://twitter.com/intent/tweet?url=${encodeURIComponent(selectedURL)}`;
                    window.open(twitterURL, "_blank");
                    break;
                case 'linkedin':
                    const linkedinURL = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(selectedURL)}`;
                    window.open(linkedinURL, "_blank");
                    break;
                default:
                    const tempInput = $("<input>");
                    $("body").append(tempInput);
                    tempInput.val(selectedURL).select();
                    document.execCommand("copy");
                    tempInput.remove();
                    // Swal.fire('Copy!','Link Copied Successfully..');
                    Swal.fire({
                        title: 'Success!',
                        text: 'Link Copied Successfully..',
                        icon: 'success',
                        timer: 2000, // 2 seconds
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    break;
            }
        })
    </script>
    <script src="{base_url}assets/custom/custom.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
    {js_file}
</body>

</html>