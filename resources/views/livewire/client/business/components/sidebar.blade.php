<div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border overflow-y-scroll">
    <div class="inner">
        <div class="content-item-content">
            <div class="rbt-default-sidebar-wrapper">
                <div class="section-title mb--20">
                    <h6 class="rbt-title-style-2">Welcome, {{ auth()->user()->name }} back</h6>
                </div>
                <nav class="mainmenu-nav">
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li>
                            <a wire:navigate href="{{ route('business.dashboard.index') }}"
                               wire:current="active">
                                <i class="feather-home"></i><span>Overview</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('business.dashboard.employees') }}"
                               wire:current="active">
                                <i class="feather-users"></i><span>Employees</span>
                            </a>
                        </li>
                        <li>
                            <a wire:navigate href="{{ route('business.dashboard.courses') }}"
                               wire:current="active">
                                <i class="feather-users"></i><span>Course</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="section-title mt--40 mb--20">
                    <h6 class="rbt-title-style-2">User</h6>
                </div>

                <nav class="mainmenu-nav">
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li><a wire:navigate href="{{ route('instructor.dashboard.settings') }}"
                                @class(['active' => request()->is('instructor/dashboard/settings')])><i class="feather-settings"></i><span>Settings</span></a>
                        </li>
                        <li x-data>
                            <form action="{{ route('client.logout') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="#" @click.prevent="$el.closest('form').submit()">
                                    <i class="feather-log-out"></i><span>Logout</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
