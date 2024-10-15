<div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="/" class="text-nowrap logo-img">
            <img src="{{asset('assets/img/Dreamers-Academy-Logo.png')}}" class="dark-logo" width="180" alt="" />
        </a>
        <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
        <ul id="sidebarnav">
            <!-- ============================= -->
            <!-- Regular Classes -->
            <!-- ============================= -->
            @canany(['class_schedule.list', 'classes.list', 'classes.details', 'recording.view', 'projects.list', 'courses.list', 'quiz.list'])
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Regular Classes</span>
                </li>
            @endcanany
            <!--  Classes -->
            <!-- =================== -->
            @canany(['class_schedule.list', 'classes.list', 'classes.details'])
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-device-desktop"></i>
                        </span>
                        <span class="hide-menu">Classes</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('class_schedule.list')
                            <li class="sidebar-item">
                                <a href="/class-schedule" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Class Schedules</span>
                                </a>
                            </li>
                        @endcan
                        @can('classes.list')
                            <li class="sidebar-item">
                                <a href="/class" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Class Lists</span>
                                </a>
                            </li>
                        @endcan
                        @can('classes.details')
                            <li class="sidebar-item">
                                <a href="/class-details" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Class Details</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!-- Activities -->
            <!-- =================== -->
            @canany(['recording.view', 'projects.list', 'courses.list', 'quiz.list'])
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                         <span class="d-flex">
                            <i class="ti ti-archive"></i>
                         </span>
                        <span class="hide-menu">Activities</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('recording.view')
                            <li class="sidebar-item">
                                <a href="/update-recording-list" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Recordings</span>
                                </a>
                            </li>
                        @endcan
                        @can('projects.list')
                            <li class="sidebar-item">
                                <a href="/project" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Projects</span>
                                </a>
                            </li>
                        @endcan
                        @can('courses.list')
                            <li class="sidebar-item">
                                <a href="/course" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Courses</span>
                                </a>
                            </li>
                        @endcan
                        @can('quiz.list')
                            <li class="sidebar-item">
                                <a href="/quiz" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Quizzes</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!-- ============================= -->
            <!-- Trial Classes -->
            <!-- ============================= -->
            @canany(['trialclass_schedule.list', 'trial_class.list'])
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Trial Classes</span>
                </li>
                <!-- Trials -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                         <span class="d-flex">
                            <i class="ti ti-device-laptop"></i>
                        </span>
                        <span class="hide-menu">Trials</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('trialclass_schedule.list')
                            <li class="sidebar-item">
                                <a href="/trial-class-schedule" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Trial Class Schedules</span>
                                </a>
                            </li>
                        @endcan
                        @can('trial_class.list')
                            <li class="sidebar-item">
                                <a href="/trial-class" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Trial Class Lists</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!-- ============================= -->
            <!-- Users -->
            <!-- ============================= -->
            @canany(['admitted_student.list', 'terminated_student.list', 'graduated_student.list', 'students.list', 'parents.list', 'users.list'])
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Users</span>
                </li>
            @endcanany
            <!-- Students -->
            <!-- =================== -->
            @canany(['admitted_student.list', 'terminated_student.list', 'graduated_student.list', 'students.list', 'certificate_list'])
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                         <span class="d-flex">
                            <i class="ti ti-users"></i>
                         </span>
                        <span class="hide-menu">Students</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('admitted_student.list')
                            <li class="sidebar-item">
                                <a href="/students" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Admitted Students</span>
                                </a>
                            </li>
                        @endcan
                        @can('terminated_student.list')
                            <li class="sidebar-item">
                                <a href="/students-terminated" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Terminated Students</span>
                                </a>
                            </li>
                        @endcan
                        @can('graduated_student.list')
                            <li class="sidebar-item">
                                <a href="/students-graduated" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Graduated Students</span>
                                </a>
                            </li>
                        @endcan
                        @can('students.list')
                            <li class="sidebar-item">
                                <a href="/allstudents" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">All Students</span>
                                </a>
                            </li>
                        @endcan
                        @can('certificate_list')
                            <li class="sidebar-item">
                                <a href="{{ route('certificate.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Certificate</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!-- Parents -->
            <!-- =================== -->
            @can('parents.list')
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="/parents" aria-expanded="false">
                        <span class="rounded-3">
                            <i class="ti ti-user-heart"></i>
                        </span>
                        <span class="hide-menu">Parents</span>
                    </a>
                </li>
            @endcan
            <!-- All Users -->
            <!-- =================== -->
            @can('users.list')
              <li class="sidebar-item">
                <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                  <span class="d-flex">
                    <i class="ti ti-user-search"></i>
                  </span>
                  <span class="hide-menu">All Users</span>
                </a>
                <ul aria-expanded="false" class="collapse first-level">
                  <li class="sidebar-item">
                    <a href="/active-inactive-user/{{1}}" class="sidebar-link">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">Active Users</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a href="/active-inactive-user/{{0}}" class="sidebar-link">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">Inactive Users</span>
                    </a>
                  </li>
                </ul>
              </li>
            @endcan
            <!-- ============================= -->
            <!-- All Reports -->
            <!-- ============================= -->
            @canany(['comprehensive_report.list', 'attendance_report.list', 'report.sales', 'report.instructor', 'report.trial_class', 'report.students', 'report.termination', 'report.sales_call', 'report.trial_class_payable', 'report.due', 'report.utm_medium', 'report.missing_recording'])
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">All Reports</span>
                </li>
                <!--  Reports -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-report"></i>
                        </span>
                        <span class="hide-menu">Reports</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('comprehensive_report.list')
                            <li class="sidebar-item">
                                <a href="/report-show-comprehensively" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Comprehensive Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('attendance_report.list')
                            <li class="sidebar-item">
                                <a href="/report-show-attendance" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Attendance Report</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="/report-show-registrations" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Registration Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.sales')
                            <li class="sidebar-item">
                                <a href="/show-sales-report" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Sales Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.instructor')
                            <li class="sidebar-item">
                                <a href="/show-instructor-report" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Instructor Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.trial_class')
                            <li class="sidebar-item">
                                <a href="/show-trial-class-report" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Trial Class Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.students')
                            <li class="sidebar-item">
                                <a href="{{route('student-monthly-count-report')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Students Monthly Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.termination')
                            <li class="sidebar-item">
                                <a href="{{route('student-monthly-termination-report')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Student Termination Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.sales_call')
                            <li class="sidebar-item">
                                <a href="{{route('trial-class-sales-call-report')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Sales Call Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.trial_class_payable')
                            <li class="sidebar-item">
                                <a href="{{route('trial-class-payable-details-report')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Trial Class Payable Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.due')
                            <li class="sidebar-item">
                                <a href="{{route('due-report')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Due Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.utm_medium')
                            <li class="sidebar-item">
                                <a href="{{route('utm-medium-report')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">UTM Medium Report</span>
                                </a>
                            </li>
                        @endcan
                        @can('report.missing_recording')
                            <li class="sidebar-item">
                                <a href="{{route('recording-mapping-missing-report')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Recording Mapping Report</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!-- ============================= -->
            <!-- All Payments -->
            <!-- ============================= -->
            @canany(['payment.add', 'payment.list', 'bkash_transaction'])
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">All Payments</span>
                </li>
                <!-- Payments -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-moneybag"></i>
                        </span>
                        <span class="hide-menu">Payments</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">.
                        @can('payment.add')
                            <li class="sidebar-item">
                                <a href="/payment-add-new" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Add Payment</span>
                                </a>
                            </li>
                        @endcan
                        @can('payment.list')
                            <li class="sidebar-item">
                                <a href="/payment-history" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Payment History</span>
                                </a>
                            </li>
                        @endcan
                        @can('bkash_transaction')
                            <li class="sidebar-item">
                                <a href="{{ route('bkash.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Bkash Transaction</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <!-- ============================= -->
            <!-- Roles & Permissions -->
            <!-- ============================= -->
            @canany(['assignrole.add', 'assignrole.list', 'role.add', 'role.list', 'permission.list'])
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Roles & Permissions</span>
                </li>
            @endcanany
            <!-- Roles -->
            <!-- =================== -->
            @canany(['assignrole.add', 'assignrole.list', 'role.add', 'role.list'])
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                    <span class="d-flex">
                        <i class="ti ti-notebook"></i>
                    </span>
                        <span class="hide-menu">Roles</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('assignrole.add')
                            <li class="sidebar-item">
                                <a href="{{ route('assign-role') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Assign Role</span>
                                </a>
                            </li>
                        @endcan
                        @can('assignrole.list')
                            <li class="sidebar-item">
                                <a href="{{ route('assign-role-list') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Assign Role Lists</span>
                                </a>
                            </li>
                        @endcan
                        @can('role.add')
                            <li class="sidebar-item">
                                <a href="{{ route('roles.create') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Add Role</span>
                                </a>
                            </li>
                        @endcan
                        @can('role.list')
                            <li class="sidebar-item">
                                <a href="{{ route('roles.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Role List</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            <!-- Permissions -->
            <!-- =================== -->
            @can('permission.list')
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="{{ route('permission') }}" aria-expanded="false">
                    <span class="rounded-3">
                        <i class="ti ti-accessible-off"></i>
                    </span>
                        <span class="hide-menu">Permissions</span>
                    </a>
                </li>
            @endcan
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>