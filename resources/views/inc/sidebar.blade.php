<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('admin')) ? '' : 'collapsed' }}" href="/admin">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('class*')) ? '' : 'collapsed' }}" href="/class">
                <i class="bi bi-card-list"></i>
                <span>Classes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('class-schedule*')) ? '' : 'collapsed' }}" href="/class-schedule">
                <i class="bi bi-card-list"></i>
                <span>Class Schedule</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('quiz*')) ? '' : 'collapsed' }}" href="/quiz">
                <i class="bi bi-card-list"></i>
                <span>Quiz</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('quiz*')) ? '' : 'collapsed' }}" href="/quiz">
                <i class="bi bi-card-list"></i>
                <span>Student Attendance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('quiz*')) ? '' : 'collapsed' }}" href="/quiz">
                <i class="bi bi-card-list"></i>
                <span>Student Project</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('quiz*')) ? '' : 'collapsed' }}" href="/quiz">
                <i class="bi bi-card-list"></i>
                <span>Student Quiz</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('course*')) ? '' : 'collapsed' }}" href="/course">
                <i class="bi bi-card-list"></i>
                <span>Courses</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('project*')) ? '' : 'collapsed' }}" href="/project">
                <i class="bi bi-bounding-box"></i>
                <span>Projects</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('students*') || 
            request()->is('parents*') || 
            request()->is('users*')) ? '' : 'collapsed' }}" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="icons-nav" class="nav-content collapse {{ (request()->is('students*') || request()->is('parents*') || request()->is('users*')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a class=" {{ (request()->is('students*')) ? 'active' : '' }}" href="/students">
                        <i class="bi bi-people"></i>
                        <span>Students</span>
                    </a>
                </li>
                <li>
                    <a class=" {{ (request()->is('parents*')) ? 'active' : '' }}" href="/parents">
                        <i class="bi bi-people"></i>
                        <span>Parents</span>
                    </a>
                </li>
                <li>
                    <a class=" {{ (request()->is('users*')) ? 'active' : '' }}" href="/users">
                        <i class="bi bi-people"></i>
                        <span>All Users</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/my/profile">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>
        <!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->


    </ul>

</aside>