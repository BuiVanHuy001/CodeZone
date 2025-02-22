<header class="rbt-header rbt-header-10">
    <div class="rbt-sticky-placeholder"></div>
    <div class="rbt-header-wrapper header-space-betwween header-sticky">
        <div class="container-fluid">
            <div class="mainbar-row rbt-navigation-center align-items-center">
                <div class="header-left rbt-header-content">
                    <div class="header-info">
                        <div class="logo logo-dark">
                            <a href="">
                                <img src="{{ asset('assets/images/logo/logo.png') }} " alt="CodeZone Logo Images">
                            </a>
                        </div>

                        <div class="logo d-none logo-light">
                            <a href="">
                                <img src="{{ asset('assets/images/logo/logo.png') }} " alt="CodeZone Logo Images">
                            </a>
                        </div>
                    </div>
                    <div class="header-info">
                        <div class="rbt-category-menu-wrapper rbt-category-update">
                            <div class="rbt-category-btn">
                                <div class="rbt-offcanvas-trigger md-size icon">
                                        <span class="d-none d-xl-block">
                                    <i class="feather-grid"></i>
                                </span>
                                    <i title="Category" class="feather-grid d-block d-xl-none"></i>
                                </div>
                                <span class="category-text d-none d-xl-block">Category</span>
                            </div>
                            <div class="category-dropdown-menu d-none d-xl-block">
                                <div class="category-menu-item">
                                    <div class="rbt-vertical-nav">
                                        <ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">
                                            @foreach($categories->where('parent_id', null) as $category)
                                                <li class="vertical-nav-item{{ $loop->iteration === 1 ? ' active' : '' }}">
                                                    <a href="#tab{{ $loop->iteration }}">{{ $category->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="rbt-vertical-nav-content">
                                        @for($i = 1; $i <= $categories->where('parent_id', null)->count(); $i++)
                                            <div class="rbt-vertical-inner tab-content{{ $i === 1 ? ' active' : '' }}" id="tab{{ $i }}" style="{{ $i === 1 ? 'display: block' : '' }}">
                                                <div class="rbt-vertical-single">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="vartical-nav-content-menu">
                                                                <ul class="rbt-vertical-nav-list-wrapper">
                                                                    @foreach($categories->where('parent_id', $i) as $category)
                                                                        <li><a href="#">{{ $category->name }}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="rbt-main-navigation d-none d-xl-block">
                    <nav class="mainmenu-nav">
                        <ul class="mainmenu">
                            <li class="with-megamenu has-menu-child-item position-static">
                                <a href="#">Home</a>
                            </li>

                            <li class="with-megamenu has-menu-child-item">
                                <a href="#">About us</a>
                            </li>

                            <li class="with-megamenu has-menu-child-item">
                                <a href="#">CodeZone Business</a>
                            </li>

                            <li class="with-megamenu has-menu-child-item">
                                <a href="#">Tech on CodeZone</a>
                            </li>

                            <li class="with-megamenu has-menu-child-item position-static">
                                <a href="#">Blog</a>
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

                        <li class="access-icon rbt-mini-cart">
                            <a class="rbt-cart-sidenav-activation rbt-round-btn" href="#">
                                <i class="feather-shopping-cart"></i>
                                <span class="rbt-cart-count">0</span>
                            </a>
                        </li>

                        <!--                        <li class="account-access rbt-user-wrapper d-none d-xl-block">-->
                        <!--                            <a href="#"><i class="feather-user"></i>Admin</a>-->
                        <!--                            <div class="rbt-user-menu-list-wrapper">-->
                        <!--                                <div class="inner">-->
                        <!--                                    <div class="rbt-admin-profile">-->
                        <!--                                        <div class="admin-thumbnail">-->
                        <!--                                            <img src="assets/images/team/avatar.jpg" alt="User Images">-->
                        <!--                                        </div>-->
                        <!--                                        <div class="admin-info">-->
                        <!--                                            <span class="name">RainbowIT</span>-->
                        <!--                                            <a class="rbt-btn-link color-primary" href="profile.html">View Profile</a>-->
                        <!--                                        </div>-->
                        <!--                                    </div>-->
                        <!--                                    <ul class="user-list-wrapper">-->
                        <!--                                        <li>-->
                        <!--                                            <a href="instructor-dashboard.html">-->
                        <!--                                                <i class="feather-home"></i>-->
                        <!--                                                <span>My Dashboard</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                        <li>-->
                        <!--                                            <a href="#">-->
                        <!--                                                <i class="feather-bookmark"></i>-->
                        <!--                                                <span>Bookmark</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                        <li>-->
                        <!--                                            <a href="instructor-enrolled-courses.html">-->
                        <!--                                                <i class="feather-shopping-bag"></i>-->
                        <!--                                                <span>Enrolled Courses</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                        <li>-->
                        <!--                                            <a href="instructor-wishlist.html">-->
                        <!--                                                <i class="feather-heart"></i>-->
                        <!--                                                <span>Wishlist</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                        <li>-->
                        <!--                                            <a href="instructor-reviews.html">-->
                        <!--                                                <i class="feather-star"></i>-->
                        <!--                                                <span>Reviews</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                        <li>-->
                        <!--                                            <a href="instructor-my-quiz-attempts.html">-->
                        <!--                                                <i class="feather-list"></i>-->
                        <!--                                                <span>My Quiz Attempts</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                        <li>-->
                        <!--                                            <a href="instructor-order-history.html">-->
                        <!--                                                <i class="feather-clock"></i>-->
                        <!--                                                <span>Order History</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                        <li>-->
                        <!--                                            <a href="instructor-quiz-attempts.html">-->
                        <!--                                                <i class="feather-message-square"></i>-->
                        <!--                                                <span>Question & Answer</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                    </ul>-->
                        <!--                                    <hr class="mt&#45;&#45;10 mb&#45;&#45;10">-->
                        <!--                                    <ul class="user-list-wrapper">-->
                        <!--                                        <li>-->
                        <!--                                            <a href="#">-->
                        <!--                                                <i class="feather-book-open"></i>-->
                        <!--                                                <span>Getting Started</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                    </ul>-->
                        <!--                                    <hr class="mt&#45;&#45;10 mb&#45;&#45;10">-->
                        <!--                                    <ul class="user-list-wrapper">-->
                        <!--                                        <li>-->
                        <!--                                            <a href="instructor-settings.html">-->
                        <!--                                                <i class="feather-settings"></i>-->
                        <!--                                                <span>Settings</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                        <li>-->
                        <!--                                            <a href="">-->
                        <!--                                                <i class="feather-log-out"></i>-->
                        <!--                                                <span>Logout</span>-->
                        <!--                                            </a>-->
                        <!--                                        </li>-->
                        <!--                                    </ul>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </li>-->

                        <li class="access-icon rbt-user-wrapper d-block d-xl-none">
                            <a class="rbt-round-btn" href="#"><i class="feather-user"></i></a>
                            <div class="rbt-user-menu-list-wrapper">
                                <div class="inner">
                                    <div class="rbt-admin-profile">
                                        <div class="admin-thumbnail">
                                            <img src="assets/images/team/avatar.jpg" alt="User Images">
                                        </div>
                                        <div class="admin-info">
                                            <span class="name">RainbowIT</span>
                                            <a class="rbt-btn-link color-primary" href="profile.html">View Profile</a>
                                        </div>
                                    </div>
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="instructor-dashboard.html">
                                                <i class="feather-home"></i>
                                                <span>My Dashboard</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="feather-bookmark"></i>
                                                <span>Bookmark</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-enrolled-courses.html">
                                                <i class="feather-shopping-bag"></i>
                                                <span>Enrolled Courses</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-wishlist.html">
                                                <i class="feather-heart"></i>
                                                <span>Wishlist</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-reviews.html">
                                                <i class="feather-star"></i>
                                                <span>Reviews</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-my-quiz-attempts.html">
                                                <i class="feather-list"></i>
                                                <span>My Quiz Attempts</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-order-history.html">
                                                <i class="feather-clock"></i>
                                                <span>Order History</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="instructor-quiz-attempts.html">
                                                <i class="feather-message-square"></i>
                                                <span>Question & Answer</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <hr class="mt--10 mb--10">
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="#">
                                                <i class="feather-book-open"></i>
                                                <span>Getting Started</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <hr class="mt--10 mb--10">
                                    <ul class="user-list-wrapper">
                                        <li>
                                            <a href="instructor-settings.html">
                                                <i class="feather-settings"></i>
                                                <span>Settings</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <i class="feather-log-out"></i>
                                                <span>Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <div class="rbt-btn-wrapper d-none d-xl-block ms-3">
                        <a class="rbt-btn icon-hover btn-sm" href="#">
                            <span class="btn-text">Sign in</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </a>
                        <a class="rbt-btn btn-white icon-hover btn-sm" href="#">
                            <span class="btn-text">Sign up</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </a>
                    </div>

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
                            <input type="text" placeholder="What are you looking for?">
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
                                    <img src="{{ asset('assets/images/course/course-online-01.jpg') }} "
                                         alt="Card image">
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
                    <!-- End Single Card  -->

                    <!-- Start Single Card  -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="assets/images/course/course-online-02.jpg" alt="Card image">
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
                                    <img src="assets/images/course/course-online-03.jpg" alt="Card image">
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
                                    <img src="assets/images/course/course-online-04.jpg" alt="Card image">
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
                    <!-- End Single Card  -->
                </div>

            </div>
        </div>
    </div>
    <div class="rbt-offcanvas-side-menu rbt-category-sidemenu">
        <div class="inner-wrapper">
            <div class="inner-top">
                <div class="inner-title">
                    <h4 class="title">Course Category</h4>
                </div>
                <div class="rbt-btn-close">
                    <button class="rbt-close-offcanvas rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
            <nav class="side-nav w-100">
                <ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">
                    <li class="vertical-nav-item">
                        <a href="#">Course School</a>
                        <div class="vartical-nav-content-menu-wrapper">
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Web Design</a></li>
                                    <li><a href="#">Art</a></li>
                                    <li><a href="#">Figma</a></li>
                                    <li><a href="#">Adobe</a></li>
                                </ul>
                            </div>
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Photo</a></li>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Math</a></li>
                                    <li><a href="#">Read</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="vertical-nav-item">
                        <a href="#">Online School</a>
                        <div class="vartical-nav-content-menu-wrapper">
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Photo</a></li>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Math</a></li>
                                    <li><a href="#">Read</a></li>
                                </ul>
                            </div>
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Web Design</a></li>
                                    <li><a href="#">Art</a></li>
                                    <li><a href="#">Figma</a></li>
                                    <li><a href="#">Adobe</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="vertical-nav-item">
                        <a href="#">kindergarten</a>
                        <div class="vartical-nav-content-menu-wrapper">
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Photo</a></li>
                                    <li><a href="#">English</a></li>
                                    <li><a href="#">Math</a></li>
                                    <li><a href="#">Read</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="vertical-nav-item">
                        <a href="#">Classic LMS</a>
                        <div class="vartical-nav-content-menu-wrapper">
                            <div class="vartical-nav-content-menu">
                                <h3 class="rbt-short-title">Course Title</h3>
                                <ul class="rbt-vertical-nav-list-wrapper">
                                    <li><a href="#">Web Design</a></li>
                                    <li><a href="#">Art</a></li>
                                    <li><a href="#">Figma</a></li>
                                    <li><a href="#">Adobe</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="read-more-btn">
                    <div class="rbt-btn-wrapper mt--20">
                        <a class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center"
                           href="#">
                            <span>Learn More</span>
                        </a>
                    </div>
                </div>
            </nav>
            <div class="rbt-offcanvas-footer">

            </div>
        </div>
    </div>
    <a class="rbt-close_side_menu" href="javascript:void(0);"></a>
</header>
