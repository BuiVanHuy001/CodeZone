<div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
    <div class="inner">
        <div class="content-item-content">
            <div class="rbt-default-sidebar-wrapper">
                <div class="section-title mb--20">
                    <h6 class="rbt-title-style-2">Welcome, {{ auth()->user()->name }}</h6>
                </div>
                <nav class="mainmenu-nav">
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li>
                            <a href="" class="{{ $activeMenu === 'dashboard' ? 'active' : '' }}" wire:click.prevent="selectComponent('dashboard.instructor-'); setActiveMenu('dashboard')"><i class="feather-home"></i><span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="" class="{{ $activeMenu === 'profile' ? 'active' : '' }}" wire:click.prevent="setActiveMenu('profile')"><i class="feather-user"></i><span>My Profile</span></a>
                        </li>
                        <li>
                            <a href="" class="{{ $activeMenu === 'courses' ? 'active' : '' }}" wire:click.prevent="setActiveMenu('courses')"><i class="feather-book-open"></i><span>My Courses</span></a>
                        </li>
                        <li>
                            <a href="" class="{{ $activeMenu === 'reviews' ? 'active' : '' }}" wire:click.prevent="setActiveMenu('reviews')"><i class="feather-star"></i><span>Reviews</span></a>
                        </li>
                    </ul>
                </nav>

                <div class="section-title mt--40 mb--20">
                    <h6 class="rbt-title-style-2">User</h6>
                </div>

                <nav class="mainmenu-nav">
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li><a href=""><i class="feather-settings"></i><span>Settings</span></a></li>
                        <li><a href=""><i class="feather-log-out"></i><span>Logout</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
