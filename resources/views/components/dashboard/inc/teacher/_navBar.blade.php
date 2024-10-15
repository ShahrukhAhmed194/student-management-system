<ul id="sidebarnav">
    <!-- =================== -->
    <!-- Home -->
    <!-- =================== -->
    <li class="sidebar-item">
        <a class="sidebar-link" href="/dashboard">
            <span>
                <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Home</span>
        </a>
    </li>
    <!-- ============================= -->
    <!-- Attendance -->
    <!-- ============================= -->
    @can('attendance.list')
        <li class="sidebar-item">
            <a class="sidebar-link" href="/attendance">
                <span>
                    <i class="ti ti-report"></i>
                </span>
                <span class="hide-menu">Attendance</span>
            </a>
        </li>
    @endcan
    <!-- ============================= -->
    <!-- Project Assessment -->
    <!-- ============================= -->
    @can('projectassesment.list')
        <li class="sidebar-item">
            <a class="sidebar-link" href="/project-assesment">
                <span>
                    <i class="ti ti-books"></i>
                </span>
                <span class="hide-menu">Project Assessment</span>
            </a>
        </li>
    @endcan
    <!-- ============================= -->
    <!-- ============================= -->
    <!-- Homework -->
    <!-- ============================= -->
    @can('homework.list')
        <li class="sidebar-item">
            <a class="sidebar-link" href="/homework">
                <span>
                    <i class="ti ti-books"></i>
                </span>
                <span class="hide-menu">Homework</span>
            </a>
        </li>
    @endcan
    <!-- ============================= -->
    <!-- Trial Classes -->
    <!-- ============================= -->
    @can('trial_class.list')
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('teacher.trial.class.index') }}">
                <span>
                    <i class="ti ti-books"></i>
                </span>
                <span class="hide-menu">Trial Classes</span>
            </a>
        </li>
    @endcan
</ul>