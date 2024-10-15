<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - Dreamers Academy</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="/assets/img/favicon.png" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- bootstrap 4.3 cdn for css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    @toastr_css
</head>

<body class="toggle-sidebar">

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="/" class=" d-flex align-items-center">
                <img height="50" src="/assets/img/logo.png" alt="">
                <!-- <span class="d-none d-lg-block">Dreamers Academy</span> -->
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="/assets/img/DA-logo.png" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ auth()->user()->name }}</h6>
                            <span>{{ auth()->user()->user_name }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="/logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->
    </header><!-- End Header -->
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('')) ? 'active' : '' }}" href="/">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- End Dashboard Nav -->
            @canany(['codingforkids.list'])
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('my-session-list/*') ? '' : 'collapsed' }}" data-bs-target="#course-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-layout-text-window-reverse"></i><span>Courses</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="course-nav" class="nav-content {{ request()->is('my-session-list/*') ? '' : 'collapsed' }}" data-bs-parent="#sidebar-nav">
                        @can('codingforkids.list')
                            <li>
                                <a class="{{ (request()->is('my-session-list/*')) ? 'active' : '' }}" href="/my-session-list/{{@$student->class->id}}">
                                    <i class="bi bi-circle"></i><span>{{@$student->class->name}}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!-- <li class="nav-item">
                <a class="nav-link {{ ( request()->is('payment*') || 
            request()->is('payment*') ) ? '' : 'collapsed' }}" data-bs-target="#payment-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-currency-dollar"></i><span>Payments</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="payment-nav" class="nav-content collapse {{ (request()->is('payment*') || request()->is('payment/fee*') ) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class=" {{ (request()->is('payment')) ? 'active' : '' }}" href="/payment">
                            <i class="bi bi-currency-dollar"></i>
                            <span>All Payments</span>
                        </a>
                    </li>
                    <li>
                        <a class=" {{ (request()->is('payment/fee')) ? 'active' : '' }}" href="/payment/fee">
                            <i class="bi bi-currency-dollar"></i>
                            <span>New Payment</span>
                        </a>
                    </li>
                </ul>
            </li> -->

            <!-- End Profile Page Nav -->
            <!-- <li class="nav-heading">Pages</li> -->
            <!-- 
            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.html">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-faq.html">
                    <i class="bi bi-question-circle"></i>
                    <span>F.A.Q</span>
                </a>
            </li> 
            -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="/logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside><!-- End Sidebar-->
    <main id="main" class="main">
        {{ $slot }}
    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div style="font-size: 13px;font-weight: bold; text-align:center">
            <a target="_blank" href="https://dreamersacademy.com.bd/terms-cond.html">Terms and Condition</a> | <a target="_blank" href="https://dreamersacademy.com.bd/return-policy.html">Return and Refund Policy</a> | <a target="_blank" href="https://dreamersacademy.com.bd/privacy-policy.html">Privacy Policy</a>
        </div>
        <div class="copyright">
            &copy; Copyright <strong><span>Dreamers Academy</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    @yield('custom-js')

    <!-- Vendor JS Files -->
    <script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/chart.js/chart.min.js"></script>
    <script src="/assets/vendor/echarts/echarts.min.js"></script>
    <script src="/assets/vendor/quill/quill.min.js"></script>
    <script src="/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="/assets/js/main.js"></script>

    <!-- Include Choices JavaScript (latest) -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        // Pass single element
        const element = document.querySelector('.choices');
        const choices = new Choices(element);
    </script>

    @jquery
    @toastr_js
    @toastr_render

</body>

</html>