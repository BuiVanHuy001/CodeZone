<header class="rbt-header rbt-header-4">
    <div class="rbt-sticky-placeholder"></div>

    <div class="rbt-header-wrapper header-space-betwween bg-color-white header-sticky">
        <div class="container-fluid">
            <div class="mainbar-row rbt-navigation-start align-items-center">
                <div class="header-left d-flex align-items-center">
                    <div class="logo logo-dark">
                        <a href="{{ route('page.home') }}">
                            <img src="{{ asset('images/logo/logo-dark.png') }}" alt="Education Logo Images">
                        </a>
                    </div>

                    <div class="logo d-none logo-light">
                        <a href="{{ route('page.home') }}">
                            <img src="{{ asset('images/logo/logo-light.png') }}" alt="Education Logo Images">
                        </a>
                    </div>
                    <div class="d-none d-xl-block ms-4">
                        <div class="rbt-category-menu-wrapper">
                            <div class="rbt-category-btn rbt-side-offcanvas-activation">
                                <div class="rbt-offcanvas-trigger md-size icon">
                                        <span class="d-none d-xl-block">
                                    <i class="feather-grid"></i>
                                </span>
                                    <i title="Category" class="feather-grid d-block d-xl-none"></i>
                                </div>
                                <span class="category-text">Category</span>
                            </div>

                            <div class="category-dropdown-menu d-none d-xl-block">
                                <div class="category-menu-item">
                                    <div class="rbt-vertical-nav">
                                        <ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">
                                            <h3 class="rbt-short-title">Explore by Goal</h3>
                                        @foreach($categories as $category)
                                                <li class="vertical-nav-item active">
                                                    <a href="#tab{{ $loop->iteration }}">{{ $category->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="rbt-vertical-nav-content">
                                        @foreach($categories as $category)
                                            <div class="rbt-vertical-inner tab-content" id="tab{{ $loop->iteration }}" @if($loop->iteration === 1)style="display:block" @endif>
                                                <div class="rbt-vertical-single">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="vartical-nav-content-menu">
                                                                <ul class="rbt-vertical-nav-list-wrapper">
                                                                    @forelse($category->children as $categoryChildren)
                                                                        <li><a href="#">{{ $categoryChildren->name }}</a></li>
                                                                    @empty
                                                                        <li><a href="#">No Subcategories</a></li>
                                                                    @endforelse
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rbt-main-navigation d-none d-xl-block">
                    <nav class="mainmenu-nav">
                        <ul class="mainmenu">
                            <li>
                                <a href="#">Home</a>
                            </li>

                            <li>
                                <a href="#">About us</a>
                            </li>

                            <li>
                                <a href="#">Courses</a>
                            </li>

                            <li>
                                <a href="#">Blogs</a>
                            </li>

                            <li>
                                <a href="#">Contact</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="header-right">
                    <ul class="quick-access">
                        <li class="access-icon">
                            <a class="search-trigger-active rbt-round-btn" href="#">
                                <i class="feather-search"></i>
                            </a>
                        </li>

                        @auth
                        <li class="access-icon rbt-user-wrapper right-align-dropdown">
                            <a class="rbt-round-btn" href="#">
                                <i class="feather-user"></i>
                            </a>
                            <div class="rbt-user-menu-list-wrapper">
                                <div class="inner">
                                    <div class="rbt-admin-profile">
                                        <div class="admin-thumbnail">
                                            <img src="{{ auth()->user()->getAvatarPath() }}" alt="User Images" crossorigin="anonymous">
                                        </div>
                                        <div class="admin-info">
                                            <span class="name">{{ auth()->user()->name }}</span>
                                        </div>
                                    </div>
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="{{ auth()->user()->isInstructor() ? route('instructor.dashboard.index') : route('business.dashboard.index') }}">
                                                <i class="feather-home"></i>
                                                <span>Dashboard</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="feather-bookmark"></i>
                                                <span>My Courses</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="feather-shopping-bag"></i>
                                                <span>My Purchases</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="feather-heart"></i>
                                                <span>My Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <i class="feather-star"></i>
                                                <span>My Reviews</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <hr class="mt--10 mb--10">
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="#">
                                                <i class="feather-book-open"></i>
                                                <span>My Learning</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <hr class="mt--10 mb--10">
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="">
                                                <i class="feather-settings"></i>
                                                <span>Settings</span>
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('client.logout') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="logout-button btn btn-danger">
                                                    <i class="feather-log-out"></i>
                                                    <span>Logout</span>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="access-icon rbt-mini-cart">
                            <a class="rbt-cart-sidenav-activation rbt-round-btn" href="#">
                                <i class="feather-shopping-cart"></i>
                                <span class="rbt-cart-count">4</span>
                            </a>
                        </li>
                        @endauth

                        @guest
                        <li class="access-icon rbt-user-wrapper right-align-dropdown gap-2">
                            <a class="rbt-btn btn-sm btn-border" href="{{ route('client.login') }}">Login</a>
                            <a class="rbt-btn btn-sm" href="{{ route('client.register') }}">Register</a>
                        </li>
                        @endguest

                        <li>
                            <div id="my_switcher" class="my_switcher">
                                <ul>
                                    <li>
                                        <a href="javascript: void(0);" data-theme="light" class="setColor light">
                                            <img src="{{ asset('images/about/sun-01.svg') }}" alt="Sun images"><span title="Light Mode"> Light</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: void(0);" data-theme="dark" class="setColor dark">
                                            <img src="{{ asset('images/about/vector.svg') }}" alt="Vector Images"><span title="Dark Mode"> Dark</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>

                    <div class="mobile-menu-bar d-block d-xl-none">
                        <div class="hamberger">
                            <button class="hamberger-button rbt-round-btn">
                                <i class="feather-menu"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rbt-search-dropdown">
            <div class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="#">
                            <label>
                                <input type="text" placeholder="What are you looking for?">
                            </label>
                            <div class="submit-btn">
                                <a class="rbt-btn btn-gradient btn-md" href="#">Search</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="rbt-separator-mid">
                    <hr class="rbt-separator m-0">
                </div>

                <div class="row g-4 pt--30 pb--60">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h5 class="rbt-title-style-2">Our Top Course</h5>
                        </div>
                    </div>

                    <!-- Start Single Card  -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-01.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title"><a href="">React Js</a>
                                </h5>
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$15</span>
                                        <span class="off-price">$25</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-02.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title"><a href="">Java Program</a>
                                </h5>
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$10</span>
                                        <span class="off-price">$40</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->

                    <!-- Start Single Card  -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-03.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title"><a href="">Web Design</a>
                                </h5>
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$10</span>
                                        <span class="off-price">$20</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->

                    <!-- Start Single Card  -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-04.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <h5 class="rbt-card-title"><a href="">Web Design</a>
                                </h5>
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$20</span>
                                        <span class="off-price">$40</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</header>
<x-popup-mobile-menu :$categories />
<x-cart-side-menu/>
