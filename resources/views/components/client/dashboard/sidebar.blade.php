<div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border overflow-y-scroll">
    <div class="inner">
        <div class="content-item-content">
            <div class="rbt-default-sidebar-wrapper">
                <div class="section-title mb--20">
                    <h6 class="rbt-title-style-2">Welcome, {{ auth()->user()->name }} back</h6>
                </div>
                <nav class="mainmenu-nav">
                    @foreach(auth()->user()->getDashboardMenu() as $section)
                        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                            @foreach($section as $label => $item)
                                <li>
                                    <a wire:navigate href="{{ route($item['route']) }}"
                                       wire:current="active">
                                        <i class="{{ $item['icon'] }}"></i><span>{{ $label }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        @unless($loop->last)
                            <div class="section-title mt--40 mb--20">
                                <h6 class="rbt-title-style-2">User</h6>
                            </div>
                        @endunless
                    @endforeach
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li>
                            <form class="menu-logout-form" action="{{ route('client.logout') }}" method="POST">
                                @csrf
                                @method('POST')
                                <a class="menu-logout-btn" href="#">
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
