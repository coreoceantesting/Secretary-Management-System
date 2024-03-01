<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/logo-sm.png') }}" alt="" height="22" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/logo-dark.png') }}" alt="" height="17" />
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/logo-sm.png') }}" alt="" height="22" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/logo-light.png') }}" alt="" height="17" />
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title">
                    <span data-key="t-menu">Menu</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                @canany(['department.view', 'home_department.view', 'wards.view', 'member.view', 'meeting.view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('master.*') ? 'active' : '' }}" href="#sidebarMaster" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaster">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Masters</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMaster">
                        <ul class="nav nav-sm flex-column">
                            @can('department.view')
                            <li class="nav-item">
                                <a href="{{ route('master.department.index') }}" class="nav-link {{ request()->routeIs('master.department.*') ? 'active' : '' }}" data-key="t-horizontal">Department</a>
                            </li>
                            @endcan
                            @can('home_department.view')
                            <li class="nav-item">
                                <a href="{{ route('master.home-department.index') }}" class="nav-link {{ request()->routeIs('master.home-department.*') ? 'active' : '' }}" data-key="t-horizontal">Home Department</a>
                            </li>
                            @endcan
                            @can('wards.view')
                            <li class="nav-item">
                                <a href="{{ route('master.ward.index') }}" class="nav-link {{ request()->routeIs('master.ward.*') ? 'active' : '' }}" data-key="t-horizontal">Ward</a>
                            </li>
                            @endcan
                            @can('member.view')
                            <li class="nav-item">
                                <a href="{{ route('master.member.index') }}" class="nav-link {{ request()->routeIs('master.member.*') ? 'active' : '' }}" data-key="t-horizontal">Member</a>
                            </li>
                            @endcan
                            @can('meeting.view')
                            <li class="nav-item">
                                <a href="{{ route('master.meeting.index') }}" class="nav-link {{ request()->routeIs('master.meeting.*') ? 'active' : '' }}" data-key="t-horizontal">Meeting</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan


                @canany(['users.view', 'roles.view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUserManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUserManagement">
                        <i class="bx bx-user-circle"></i>
                        <span data-key="t-layouts">User Management</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarUserManagement">
                        <ul class="nav nav-sm flex-column">
                            @can('users.view')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link" data-key="t-horizontal">Users</a>
                                </li>
                            @endcan
                            @can('roles.view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link" data-key="t-horizontal">Roles</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @canany(['goshwara.view', 'goshwara.create', 'goshwara.send'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarGoshwara" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarGoshwara">
                        <i class="bx bx-user-circle"></i>
                        <span data-key="t-layouts">Goshwara</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarGoshwara">
                        <ul class="nav nav-sm flex-column">
                            @can('goshwara.view')
                            <li class="nav-item">
                                <a href="{{ route('goshwara.index') }}" class="nav-link" data-key="t-horizontal">@if(Auth::user()->hasRole('Department'))Goshwara @else Received Goshwara @endif</a>
                            </li>
                            @endcan

                            @can('goshwara.create')
                            <li class="nav-item">
                                <a href="{{ route('goshwara.create') }}" class="nav-link" data-key="t-horizontal">Upload Goshwara</a>
                            </li>
                            @endcan

                            @can('goshwara.send')
                            <li class="nav-item">
                                <a href="{{ route('goshwara.send') }}" class="nav-link" data-key="t-horizontal">Send Goshwara</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @can('agenda.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}" href="{{ route('agenda.index') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Agenda</span>
                    </a>
                </li>
                @endcan

                @can('schedule_meeting.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('schedule-meeting.*') ? 'active' : '' }}" href="{{ route('schedule-meeting.index') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Schedule Meeting</span>
                    </a>
                </li>
                @endcan

                @can('question.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('question.*') ? 'active' : '' }}" href="{{ route('question.index') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Question</span>
                    </a>
                </li>
                @endcan

                @can('schedule_meeting.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('reschedule-meeting.*') ? 'active' : '' }}" href="{{ route('reschedule-meeting.index') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Reschedule Meeting</span>
                    </a>
                </li>
                @endcan

            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>


<div class="vertical-overlay"></div>
