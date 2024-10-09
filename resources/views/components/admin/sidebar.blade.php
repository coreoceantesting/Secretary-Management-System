<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/logo-light.png') }}" height="22" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/logo-light.png') }}" height="55" />
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/logo-light.png') }}" height="22" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/logo-light.png') }}" height="55" />
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

                @can('dashboard.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                @endcan

                @canany(['department.view', 'home_department.view', 'wards.view', 'member.view', 'meeting.view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('master.*') ? 'active' : '' }}" href="#sidebarMaster" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaster">
                        <i class="ri-layout-3-line"></i>
                        <span data-key="t-layouts">Masters</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('master.*') ? 'show' : '' }}" id="sidebarMaster">
                        <ul class="nav nav-sm flex-column">
                            @can('department.view')
                            <li class="nav-item">
                                <a href="{{ route('master.department.index') }}" class="nav-link {{ request()->routeIs('master.department.*') ? 'active' : '' }}" data-key="t-horizontal">Department(विभाग)</a>
                            </li>
                            @endcan
                            @can('home_department.view')
                            <li class="nav-item">
                                <a href="{{ route('master.home-department.index') }}" class="nav-link {{ request()->routeIs('master.home-department.*') ? 'active' : '' }}" data-key="t-horizontal">Home&nbsp;Department(गृह विभाग)</a>
                            </li>
                            @endcan

                            @can('party.view')
                            <li class="nav-item">
                                <a href="{{ route('master.party.index') }}" class="nav-link {{ request()->routeIs('master.party.*') ? 'active' : '' }}" data-key="t-horizontal">Party(पक्ष)</a>
                            </li>
                            @endcan
                            @can('wards.view')
                            <li class="nav-item">
                                <a href="{{ route('master.ward.index') }}" class="nav-link {{ request()->routeIs('master.ward.*') ? 'active' : '' }}" data-key="t-horizontal">Ward(वार्ड)</a>
                            </li>
                            @endcan
                            @can('member.view')
                            <li class="nav-item">
                                <a href="{{ route('master.member.index') }}" class="nav-link {{ request()->routeIs('master.member.*') ? 'active' : '' }}" data-key="t-horizontal">Member(सदस्य)</a>
                            </li>
                            @endcan
                            @can('meeting.view')
                            <li class="nav-item">
                                <a href="{{ route('master.meeting.index') }}" class="nav-link {{ request()->routeIs('master.meeting.*') ? 'active' : '' }}" data-key="t-horizontal">Meeting(बैठक)</a>
                            </li>
                            @endcan
                            @can('reservation-category.index')
                            <li class="nav-item">
                                <a href="{{ route('master.reservation-category.index') }}" class="nav-link {{ request()->routeIs('master.reservation-category.*') ? 'active' : '' }}" data-key="t-horizontal">Reservation Category(आरक्षण श्रेणी)</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan


                @canany(['users.view', 'roles.view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('users.*') ? 'active' : '' }} {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="#sidebarUserManagement" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUserManagement">
                        <i class="bx bx-user-circle"></i>
                        <span data-key="t-layouts">User&nbsp;Management</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('users.*') ? 'show' : '' }} {{ request()->routeIs('roles.*') ? 'show' : '' }}" id="sidebarUserManagement">
                        <ul class="nav nav-sm flex-column">
                            @can('users.view')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" data-key="t-horizontal">Users(वापरकर्ते)</a>
                                </li>
                            @endcan
                            @can('roles.view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" data-key="t-horizontal">Roles(भूमिका)</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @canany(['goshwara.view', 'goshwara.create', 'goshwara.send', 'goshwara.get-selected-status', 'goshwara.select-goshwara'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('goshwara.*') ? 'active' : '' }}" href="#sidebarGoshwara" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarGoshwara">
                        <i class="bx bxs-notification"></i>
                        <span data-key="t-layouts">Goshwara</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('goshwara.*') ? 'show' : '' }}" id="sidebarGoshwara">
                        <ul class="nav nav-sm flex-column">

                            @can('goshwara.create')
                            <li class="nav-item">
                                <a href="{{ route('goshwara.create') }}" class="nav-link {{ request()->routeIs('goshwara.create') ? 'active' : '' }}" data-key="t-horizontal">Upload&nbsp;Goshwara(गोषवारा अपलोड करा)</a>
                            </li>
                            @endcan

                            @can('goshwara.send')
                            <li class="nav-item">
                                <a href="{{ route('goshwara.send') }}" class="nav-link {{ request()->routeIs('goshwara.send') ? 'active' : '' }}" data-key="t-horizontal">Send&nbsp;Goshwara(गोषवारा पाठवा)</a>
                            </li>
                            @endcan

                            @can('goshwara.view')
                            <li class="nav-item">
                                <a href="{{ route('goshwara.index') }}" class="nav-link {{ request()->routeIs('goshwara.index') ? 'active' : '' }}" data-key="t-horizontal">@if(Auth::user()->hasRole('Department'))Sent Goshwara&nbsp;List(पाठवले गोषवारा यादी) @else Received&nbsp;Goshwara(गोषवारा प्राप्त झाला) @endif</a>
                            </li>
                            @endcan

                        </ul>
                    </div>
                </li>
                @endcan



                @canany(['agenda.view', 'suplimentry-agenda.view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('agenda.*') ? 'active' : '' }} {{ request()->routeIs('suplimentry-agenda.*') ? 'active' : '' }}" href="#sidebarAgenda" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAgenda">
                        <i class="bx bxs-hourglass-top"></i>
                        <span data-key="t-layouts">Agenda</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('agenda.*') ? 'show' : '' }} {{ request()->routeIs('suplimentry-agenda.*') ? 'show' : '' }}" id="sidebarAgenda">
                        <ul class="nav nav-sm flex-column">
                            @can('agenda.view')
                            <li class="nav-item">
                                <a href="{{ route('agenda.index') }}" class="nav-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}" data-key="t-horizontal">Agenda List(अजेंडा यादी)</a>
                            </li>
                            @endcan

                            @can('suplimentry-agenda.view')
                            <li class="nav-item">
                                <a href="{{ route('suplimentry-agenda.index') }}" class="nav-link {{ request()->routeIs('suplimentry-agenda.*') ? 'active' : '' }}" data-key="t-horizontal">Suplimentry Agenda(पूरक अजेंडा)</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan


                @canany(['schedule_meeting.view', 'reschedule_meeting.view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('schedule-meeting.*') ? 'active' : '' }} {{ request()->routeIs('reschedule-meeting.*') ? 'active' : '' }} " href="#sidebarMeeting" data-bs-toggle="collapse" role="button" aria-expanded="false"aria-controls="sidebarMeeting">
                        <i class="bx bx-target-lock"></i>
                        <span data-key="t-layouts">Meeting</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('schedule-meeting.*') ? 'show' : '' }} {{ request()->routeIs('reschedule-meeting.*') ? 'show' : '' }}" id="sidebarMeeting">
                        <ul class="nav nav-sm flex-column">
                            @can('schedule_meeting.view')
                            <li class="nav-item">
                                <a href="{{ route('schedule-meeting.index') }}" class="nav-link {{ request()->routeIs('schedule-meeting.*') ? 'active' : '' }}" data-key="t-horizontal">Schedule&nbsp;Meeting(बैठकीचे वेळापत्रक)</a>
                            </li>
                            @endcan

                            @can('reschedule_meeting.view')
                            <li class="nav-item">
                                <a href="{{ route('reschedule-meeting.index') }}" class="nav-link {{ request()->routeIs('reschedule-meeting.*') ? 'active' : '' }}" data-key="t-horizontal">Reschedule&nbsp;Meeting(मीटिंग पुन्हा शेड्युल करा)</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan



                @can('question.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('question.*') ? 'active' : '' }}" href="{{ route('question.index') }}" >
                        <i class="bx bx-question-mark"></i>
                        <span data-key="t-dashboards">Questions</span>
                    </a>
                </li>
                @endcan

                @can('question.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('prastav-suchana.*') ? 'active' : '' }}" href="{{ route('prastav-suchana.index') }}" >
                        <i class="bx bx-spreadsheet"></i>
                        <span data-key="t-dashboards">Prastav Suchana</span>
                    </a>
                </li>
                @endcan

                @can('question.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('laxvadi.*') ? 'active' : '' }}" href="{{ route('laxvadi.index') }}" >
                        <i class="bx bx-layout"></i>
                        <span data-key="t-dashboards">Laxvebhi</span>
                    </a>
                </li>
                @endcan

                @can('attendance.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                        <i class="bx bx-bell"></i>
                        <span data-key="t-dashboards">Attendance</span>
                    </a>
                </li>
                @endcan

                @can('proceeding-record.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('proceeding-record.*') ? 'active' : '' }}" href="{{ route('proceeding-record.index') }}">
                        <i class="bx bxs-coin-stack"></i>
                        <span data-key="t-dashboards">Proceeding Records</span>
                    </a>
                </li>
                @endcan

                @can('tharav.view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('tharav.*') ? 'active' : '' }}" href="{{ route('tharav.index') }}">
                        <i class="bx bx-info-circle"></i>
                        <span data-key="t-dashboards">Tharav</span>
                    </a>
                </li>
                @endcan


                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('report.*') ? 'active' : '' }}" href="#sidebarReport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarReport">
                        <i class="bx bxs-report"></i>
                        <span data-key="t-layouts">Report</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('report.*') ? 'show' : '' }}" id="sidebarReport">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('report.schedule-meeting') }}" class="nav-link {{ request()->routeIs('report.schedule-meeting') ? 'active' : '' }} {{ request()->routeIs('report.schedule-meeting.*') ? 'active' : '' }}" data-key="t-horizontal">Meeting Report</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.attendance-meeting') }}" class="nav-link {{ request()->routeIs('report.attendance-meeting') ? 'active' : '' }}" data-key="t-horizontal">Attendance Report</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.tharav') }}" class="nav-link {{ request()->routeIs('report.tharav') ? 'active' : '' }}" data-key="t-horizontal">Tharav Report</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report.question-response') }}" class="nav-link {{ request()->routeIs('report.question-response') ? 'active' : '' }}" data-key="t-horizontal">Question Response Report</a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>


<div class="vertical-overlay"></div>
