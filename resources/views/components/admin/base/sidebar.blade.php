<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a wire:navigate href="{{ route('admin.overview.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('images/logo/logo-dark.png') }}" alt=""/>
            </span>
            <span class="logo-lg">
                <img src="{{ asset('images/logo/logo-dark.png') }}" alt=""/>
            </span>
        </a>

        <a wire:navigate href="{{ route('admin.overview.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('images/logo/logo-light.png') }}" alt=""/>
            </span>
            <span class="logo-lg">
                <img src="{{ asset('images/logo/logo-light.png') }}" alt=""/>
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
                <li class="nav-item">
                    <a class="nav-link menu-link"
                       wire:navigate
                       wire:current="active"
                       href="{{ route('admin.overview.index') }}"
                    >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Overview</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link"
                       wire:navigate
                       wire:current="active"
                       href="{{ route('admin.courses.index') }}">
                        <i class="bx bxs-graduation"></i>
                        <span data-key="t-authentication">Courses</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link"
                       wire:navigate
                       wire:current="active"
                       href="{{ route('admin.instructors.index') }}"
                    >
                        <i class="bx bxs-user-voice"></i>
                        <span data-key="t-authentication">Instructors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link"
                       wire:navigate
                       wire:current="active"
                       href="{{ route('admin.students.index') }}"
                    >
                        <i class="bx bxs-user-detail"></i>
                        <span data-key="t-students">Students</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link"
                       href=""
                    >
                        <i class="bx bx-credit-card-front"></i>
                        <span data-key="t-transactions">Transactions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        {{--                       wire:current="active"--}}
                       class="nav-link menu-link"
                       href=""
                    >
                        <i class="bx bx-news"></i>
                        <span data-key="t-content">Content</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link menu-link"
                        href="#sidebarSettings"
                        data-bs-toggle="collapse"
                        role="button"
                        aria-expanded="false"
                        aria-controls="sidebarSettings"
                    >
                        <i class="bx bx-cog"></i>
                        <span data-key="t-settings">Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href=""
                                   class="nav-link"
                                   data-key="t-general"
                                >
                                    General Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href=""
                                   class="nav-link"
                                   data-key="t-roles"
                                >
                                    Roles & Permissions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href=""
                                   class="nav-link"
                                   data-key="t-email"
                                >
                                    Email & Notifications
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <form action="{{ route('client.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link menu-link">
                            <i class="bx bx-log-out"></i>
                            <span data-key="t-logout">Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
