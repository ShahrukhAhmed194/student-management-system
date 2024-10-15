<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ (request()->is('')) ? '' : 'collapsed' }}" href="/">
                <i class="bi bi-grid"></i>
                <span>Home</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/class-schedule">
                <i class="bi bi-grid"></i>
                <span>Class Schedule</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="attendance.html">
                <i class="bi bi-grid"></i>
                <span>Attendance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="project.html">
                <i class="bi bi-grid"></i>
                <span>Project Assessment</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="quiz.html">
                <i class="bi bi-grid"></i>
                <span>Quiz Assessment</span>
            </a>
        </li>
    </ul>
</aside>