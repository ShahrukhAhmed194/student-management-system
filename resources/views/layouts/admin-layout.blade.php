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

    <!-- Font Awsome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
    <!-- Bootstrap 4.3 cdn for css -->
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
    <link rel="stylesheet" href="/assets/vendor/select2/css/select2.min-1.0.0.css" />

    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" /> 


    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <!-- jQuery 3.6 cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <link href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

    @toastr_css

    {{ $style ?? '' }}
</head>
<style>
    .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        border-top: 4px solid #07477D;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        }
  
        @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
        }
        #loader-main {
        width: 100%;
        height: 100%;
        top: 0;
        position: fixed;
        z-index: 999999;
        background-color: rgba(183, 198, 211, 0.4);
        overflow: hidden;
        }
  
        #loader2 {
        border: 4px solid #ffffff;
        border-radius: 50%;
        border-top: 4px solid #003662;
        width: 80px;
        height: 80px;
        position: absolute;
        left: 50%;
        right: 0;
        top: 50%;
        margin-left: -60px;
        margin-top: -60px;
        bottom: 0;
        animation: spin 2s linear infinite;
        }
  </style>
<body class="toggle-sidebar">
    <div class="loader-populate"></div>
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

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->
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
                            <a class="dropdown-item d-flex align-items-center" href="/my/profile">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
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

    @php
    $usr = Auth::guard('web')->user();
    @endphp 
    
    @role('Teacher')
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ (request()->is('')) ? '' : 'collapsed' }}" href="/">
                    <i class="bi bi-grid"></i>
                    <span>Home</span>
                </a>
            </li>

             @if ($usr->can('attendance.list'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('attendance*')) ? '' : 'collapsed' }}" href="/attendance">
                    <i class="bi bi-grid"></i>
                    <span>Attendance</span>
                </a>
            </li>
            @endif
            @if ($usr->can('projectassesment.list'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('project-assesment*')) ? '' : 'collapsed' }}" href="/project-assesment">
                    <i class="bi bi-grid"></i>
                    <span>Project Assessment</span>
                </a>
            </li>
            @endif
             @if ($usr->can('trial_class.list'))
                <li class="nav-item">
                    <a class="nav-link {{ (request()->is('trial-class-list*')) ? '' : 'collapsed' }}" href="/trial-class-list">
                        <i class="bi bi-tv"></i><span>Trial Classes</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>
    @else
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ (request()->is('dashboard')) ? '' : 'collapsed' }}" href="/dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- End Dashboard Nav -->

            @if ($usr->can('classes.list'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('class')) ? '' : 'collapsed' }}" href="/class">
                    <i class="bi bi-card-list"></i>
                    <span>Classes</span>
                </a>
            </li>
            @endif
            @if ($usr->can('classes.list'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('class-details*')) ? '' : 'collapsed' }}" href="/class-details">
                    <i class="bi bi-card-list"></i>
                    <span>Class Details</span>
                </a>
            </li>
            @endif

            @if ($usr->can('recording.view'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('update-recording-list')) ? '' : 'collapsed' }}" href="/update-recording-list">
                    <i class="bi bi-film"></i>
                    <span>Recordings</span>
                </a>
            </li>
            @endif
            @if ($usr->can('class_schedule.list'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('class-schedule*')) ? '' : 'collapsed' }}" href="/class-schedule">
                    <i class="bi bi-clock"></i>
                    <span>Class Schedule</span>
                </a>
            </li>
            @endif
            @if ($usr->can('quiz.list'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('quiz*')) ? '' : 'collapsed' }}" href="/quiz">
                    <i class="bi bi-journal-check"></i>
                    <span>Quiz</span>
                </a>
            </li>
            @endif
            @if ($usr->can('courses.list'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('course*')) ? '' : 'collapsed' }}" href="/course">
                    <i class="bi bi-card-list"></i>
                    <span>Courses</span>
                </a>
            </li>
            @endif

            @if ($usr->can('projects.list'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('project*')) ? '' : 'collapsed' }}" href="/project">
                    <i class="bi bi-bounding-box"></i>
                    <span>Projects</span>
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link {{ ( request()->is('trial-class*') || 
            request()->is('trial-class-schedule*') ) ? '' : 'collapsed' }}" data-bs-target="#trial-class-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-tv"></i><span>Trial Class</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="trial-class-nav" class="nav-content collapse {{ (request()->is('trial-class*') || request()->is('trial-class-schedule*') ) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                @if ($usr->can('trial_class.list'))
                    <li>
                        <a class=" {{ (request()->is('trial-class')) ? 'active' : '' }}" href="/trial-class">
                            <i class="bi bi-list"></i>
                            <span>Trial Classes</span>
                        </a>
                    </li>
                @endif
                @if ($usr->can('trialclass_schedule.list'))
                    <li>
                        <a class=" {{ (request()->is('trial-class-schedule')) ? 'active' : '' }}" href="/trial-class-schedule">
                            <i class="bi bi-clock"></i>
                            <span>Trial Class Schedule</span>
                        </a>
                    </li>
                @endif
                </ul>
            </li>

             @if ($usr->can('students.list') || $usr->can('graduated_student.list') || $usr->can('terminated_student.list') || $usr->can('parents.list') || $usr->can('users.list'))
            <li class="nav-item">
                <a class="nav-link {{ (request()->is('students*') || request()->is('parents*') || request()->is('users*')) ? '' : 'collapsed' }}" 
                    data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="icons-nav" class="nav-content collapse {{ (request()->is('students*') || request()->is('parents*') || request()->is('users*') || request()->is('allstudents')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li >
                        <a class="nav-link {{ (request()->is('students*') || request()->is('allstudents')) ? '' : 'collapsed' }}" data-bs-target="#students-nav" data-bs-toggle="collapse" href="#">
                            <i class="bi bi-people"></i>
                            <span>Students</span>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="students-nav" class="nav-content px-4 {{(request()->is('students*') || request()->is('allstudents')) ? '' : 'collapse'}}"  data-bs-parent="#icons-nav" >
                        @if ($usr->can('students.allstudent'))
                        <li>
                                <a class=" {{ request()->is('allstudents') ? 'active' : '' }}"  href="/allstudents">
                                <i class="bi bi-people"></i>
                                <span>All Students</span>
                                </a>
                            </li>
                        @endif
                        @if ($usr->can('students.list'))
                            <li>
                                <a class=" {{ request()->is('students') ? 'active' : '' }}"  href="/students">
                                <i class="bi bi-people"></i>
                                <span>Admitted Students</span>
                                </a>
                            </li>
                        @endif
                        @if ($usr->can('graduated_student.list'))
                            <li>
                                <a class=" {{ request()->is('students-graduated') ? 'active' : '' }}"  href="/students-graduated">
                                <i class="bi bi-people"></i>
                                <span>Graduated Students</span>
                                </a>
                            </li>
                        @endif
                        @if ($usr->can('terminated_student.list'))
                            <li>
                                <a class=" {{ request()->is('students-terminated') ? 'active' : '' }}"  href="/students-terminated">
                                <i class="bi bi-people"></i>
                                <span>Terminated Students</span>
                                </a>
                            </li>
                        @endif
                        </ul>
                    </li>
                    @if ($usr->can('parents.list'))
                    <li>
                        <a class=" {{ (request()->is('parents*')) ? 'active' : '' }}" href="/parents">
                            <i class="bi bi-people"></i>
                            <span>Parents</span>
                        </a>
                    </li>
                    @endif
                    @if ($usr->can('users.list'))
                    <li>
                        <a class=" {{ (request()->is('users*')) ? 'active' : '' }}" href="/users">
                            <i class="bi bi-people"></i>
                            <span>All Users</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if ($usr->can('comprehensive_report.list') || $usr->can('attendance_report.list'))
            <li class="nav-item">
                <a class="nav-link {{ ( request()->is('report-show-*')) ? '' : 'collapsed' }}" data-bs-target="#report-show-comprehensively-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-tv"></i><span>Report</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="report-show-comprehensively-nav" class="nav-content collapse 
                {{ (request()->is('report-show-*')) ? 'show' : '' }}"
                 data-bs-parent="#sidebar-nav">
                 @if ($usr->can('comprehensive_report.list'))
                    <li>
                        <a class=" {{ (request()->is('report-show-comprehensively')) ? 'active' : '' }}" href="/report-show-comprehensively">
                            <i class="bi bi-list"></i>
                            <span>Comprehensive Report</span>
                        </a>
                    </li>
                @endif
                @if ($usr->can('attendance_report.list'))
                    <li>
                        <a class=" {{ request()->is('report-show-attendance') ? 'active' : '' }}" href="/report-show-attendance">
                            <i class="bi bi-people"></i>
                            <span>Attendance Report</span>
                        </a>
                    </li>
                @endif
                @if ($usr->can('attendance_report.list'))
                    <li>
                        <a class=" {{ request()->is('report-show-registrations') ? 'active' : '' }}" href="/report-show-registrations">
                            <i class="bi bi-people"></i>
                            <span>Registration Report</span>
                        </a>
                    </li>
                @endif
                </ul>
            </li>
            @endif

            @if ($usr->can('payment.add') || $usr->can('payment.list'))
            <li class="nav-item">
                <a class="nav-link {{ ( request()->is('payment-*') ) ? '' : 'collapsed' }}" data-bs-target="#payment-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa fa-credit-card"></i><span>Payments</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="payment-nav" class="nav-content collapse {{ (request()->is('payment-*') ) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                @if ($usr->can('payment.add'))
                    <li>
                        <a class=" {{ (request()->is('payment-add-new')) ? 'active' : '' }}" href="/payment-add-new">
                            <i class="bi bi-list"></i>
                            <span>Add Payment</span>
                        </a>
                    </li>
                @endif
                @if ($usr->can('payment.list'))
                    <li>
                        <a class=" {{ (request()->is('payment-history')) ? 'active' : '' }}" href="/payment-history">
                            <i class="bi bi-clock"></i>
                            <span>Payment History</span>
                        </a>
                    </li>
                @endif
                </ul>
            </li>
            @endif

            @if ($usr->can('assignrole.add') || $usr->can('assignrole.list') || $usr->can('role.add') || $usr->can('role.list') || $usr->can('permission.add'))
            <li class="nav-item">
                <a class="nav-link {{ ( request()->is('role-show-*')) ? '' : 'collapsed' }}" data-bs-target="#role-show-status-count-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-tv"></i><span>Roles & Permission</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="role-show-status-count-nav" class="nav-content collapse 
                {{ (request()->is('role-show-*')) ? 'show' : '' }}"
                 data-bs-parent="#sidebar-nav">
                @if ($usr->can('assignrole.add'))
                    <li>
                        <a class=" {{ (request()->is('assign-role')) ? 'active' : '' }}" href="{{ route('assign-role') }}">
                            <i class="bi bi-list"></i>
                            <span>Assign Role</span>
                        </a>
                    </li>
                @endif
                @if ($usr->can('assignrole.list'))
                    <li>
                        <a class=" {{ (request()->is('assign-role')) ? 'active' : '' }}" href="{{ route('assign-role-list') }}">
                            <i class="bi bi-list"></i>
                            <span>Assign Role List</span>
                        </a>
                    </li>
                @endif
                @if ($usr->can('role.add'))
                    <li>
                        <a class=" {{ (request()->is('add-role-show')) ? 'active' : '' }}" href="{{ route('roles.create') }}">
                            <i class="bi bi-list"></i>
                            <span>Add Role</span>
                        </a>
                    </li>
                @endif
                @if ($usr->can('role.list'))
                    <li>
                        <a class=" {{ request()->is('role-list-show-') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                            <i class="bi bi-people"></i>
                            <span>Role List</span>
                        </a>
                    </li> 
                @endif
                @if ($usr->can('permission.list'))
                    <li>
                        <a class=" {{ request()->is('permission-show') ? 'active' : '' }}" href="{{ route('permission') }}">
                            <i class="bi bi-people"></i>
                            <span>Permissions</span>
                        </a>
                    </li>
                @endif
                </ul>
            </li>
            @endif
            </ul>
            </li>
        </ul>
    </aside>

    @endrole




    <main id="main" class="main">

        {{ $slot }}

    </main>

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

    <script>
        var deleteLinks = document.querySelectorAll('.delete');

        for (var i = 0; i < deleteLinks.length; i++) {
            deleteLinks[i].addEventListener('click', function(event) {
                event.preventDefault();

                var choice = confirm(this.getAttribute('data-confirm'));

                if (choice) {
                    window.location.href = this.getAttribute('href');
                }
            });
        }
    </script>

    <!-- Vendor JS Files -->
    <script src="/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/chart.js/chart.min.js"></script>
    <script src="/assets/vendor/echarts/echarts.min.js"></script>
    <script src="/assets/vendor/quill/quill.min.js"></script>
    <script src="/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/assets/vendor/php-email-form/validate.js"></script>
    
    {{-- ---------------- datatables start------------------ --}}
    <link href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/buttons.dataTables.min.css') }}" rel="stylesheet">
    {{-- ---------------- datatables close------------------ --}}

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

    <!-- popover scripts -->
    
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>

    <script>
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        });
        $(document).ready(function(){
            $(".placeholder-single").select2();
        });
    </script>

    <!-- Poper js cdn-->

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/assets/vendor/select2/js/select2.min-1.0.0.js"></script>
    <script src="/assets/vendor/toastr/toastr.min.js"></script>
    {{-- ---------------- datatables start------------------ --}}
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/buttons.print.min.js') }}"></script>
    {{-- ---------------- datatables close------------------ --}}

    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

    {{ $script ?? '' }}
</body>
</html>
