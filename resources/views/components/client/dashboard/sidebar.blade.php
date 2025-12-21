<div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border overflow-y-scroll">
    <div class="inner">
        <div class="content-item-content">
            <div class="rbt-default-sidebar-wrapper">
                <div class="section-title mb--20">
                    <h6 class="rbt-title-style-2">Hello, {{ auth()->user()->name }}</h6>
                </div>
                <nav class="mainmenu-nav">
                    @foreach(\App\Support\ClientMenuMapping::getMenuForRole() as $section)
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
                                <h6 class="rbt-title-style-2">Người dùng</h6>
                            </div>
                        @endunless
                    @endforeach
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li>
                            <form class="menu-logout-form" action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a class="menu-logout-btn" href="#">
                                    <i class="feather-log-out"></i><span>Đăng xuất</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
