<div class="side-bar" id="sidebar">
    <h3 class="text-center sidebar-title">
        <span class="full-text">
            Salary Management
        </span>
    </h3>

    <hr class="mt-4 mb-1">
    <ul class="list-unstyled">
        {{-- @if (session()->has('user_role')) --}}

        {{-- ================= ADMIN MENU ================= --}}
        {{-- @if (session('user_role') == 'admin') --}}

        <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class="fa-solid fa-gauge me-2"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>

        <li class="{{ Request::routeIs('department') ? 'active' : '' }}">
            <a href="{{ route('department') }}">
                <i class="fa-solid fa-building me-2"></i>
                <span class="sidebar-text">Departments</span>
            </a>
        </li>
        <li class="{{ Request::routeIs('designation') ? 'active' : '' }}">
            <a href="{{ route('designation') }}">
                <i class="fa-solid fa-briefcase me-2"></i>

                <span class="sidebar-text">Designations</span>
            </a>
        </li>

        <li class="{{ Request::routeIs('employee') ? 'active' : '' }}">
            <a href="{{ route('employee') }}">
                <i class="fa-solid fa-users me-2"></i>
                <span class="sidebar-text">Employees</span>
            </a>
        </li>

        <li class="{{ Request::routeIs('attendance') ? 'active' : '' }}">
            <a href="{{ route('attendance') }}">
                <i class="fa-solid fa-calendar-check me-2"></i>
                <span class="sidebar-text">Attendance</span>
            </a>
        </li>

        <li class="has-submenu">
            <a href="javascript:void(0);" class="submenu-toggle">
                <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                <span class="sidebar-text">Payroll</span>
                <i class="fa-solid fa-chevron-right submenu-arrow"></i>
            </a>

            <ul class="submenu">

                <li class="{{ Request::routeIs('salary_period') ? 'active' : '' }}">
                    <a href="{{ route('salary_period') }}">
                        <span class="submenu-dot"></span>
                        <span class="sidebar-text">Salary Period</span>
                    </a>
                </li>

                <li class="{{ Request::routeIs('salary_details') ? 'active' : '' }}">
                    <a href="{{ route('salary_details') }}">
                        <span class="submenu-dot"></span>
                        <span class="sidebar-text">Salary Details</span>
                    </a>
                </li>

                <li class="{{ Request::routeIs('salary_payment') ? 'active' : '' }}">
                    <a href="{{ route('salary_payment') }}">
                        <span class="submenu-dot"></span>
                        <span class="sidebar-text">Salary Payment</span>
                    </a>
                </li>

            </ul>
        </li>



        {{-- <li>
            <a href="#">
                <i class="fa-solid fa-gear me-2"></i>
                <span class="sidebar-text">Settings</span>
            </a>
        </li> --}}

        {{-- ================= EMPLOYEE MENU ================= --}}
        {{-- @else
        <li>
            <a href="#">
                <i class="fa-solid fa-gauge me-2"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>



        <li>
            <a href="#">
                <i class="fa-solid fa-calendar-check me-2"></i>
                <span class="sidebar-text">My Attendance</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-money-bill-wave me-2"></i>
                <span class="sidebar-text">My Salary</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                <span class="sidebar-text">Salary Slip</span>
            </a>
        </li>




        <li>
            <a href="#">
                <i class="fa-solid fa-bell me-2"></i>
                <span class="sidebar-text">Notifications</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-user me-2"></i>
                <span class="sidebar-text">My Profile</span>
            </a>
        </li>

        @endif
        @endif --}}
        {{-- Logout --}}
        {{-- <li>
            <a href="#">
                <i class="fa-solid fa-right-from-bracket me-2"></i>
                <span class="sidebar-text">Logout</span>
            </a>
        </li> --}}

    </ul>
</div>
