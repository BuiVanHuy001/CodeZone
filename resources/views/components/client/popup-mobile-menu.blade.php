<div class="popup-mobile-menu">
    <div class="inner-wrapper">
        <div class="inner-top">
            <div class="content">
                <div class="logo">
                    <div class="logo logo-dark">
                        <a href="">
                            <img src="{{ asset('images/logo/logo-dark.png') }}" alt="CodeZone Logo">
                        </a>
                    </div>

                    <div class="logo d-none logo-light">
                        <a href="">
                            <img src="{{ asset('images/logo/logo-light.png') }}" alt="CodeZone Logo">
                        </a>
                    </div>
                </div>
                <div class="rbt-btn-close">
                    <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                </div>
            </div>
            <p class="description">CodeZone is an education website template. You can customize all.</p>
            <ul class="navbar-top-left rbt-information-list justify-content-start">
                <li>
                    <a href="mailto:hello@example.com"><i class="feather-mail"></i>hi@codezone.com</a>
                </li>
                <li>
                    <a href="#"><i class="feather-phone"></i>(302) 555-0107</a>
                </li>
            </ul>
        </div>

        <nav class="mainmenu-nav">
            <ul class="mainmenu">
                <li>
                    <a href="#">Home</a>
                </li>

                <li class="with-megamenu has-menu-child-item position-static">
                    <a href="#">Categories</a>
                    <ul class="rbt-megamenu rbt-vertical-nav-list-wrapper vertical-nav-menu">
                        <h6 class="rbt-short-title">Explore by Goal</h6>
                        @foreach ($categories as $category)
                            <li class="vertical-nav-item with-megamenu has-menu-child-item position-static">
                                <a href="#">{{ $category->name }}</a>
                                <div class="vartical-nav-content-menu-wrapper">
                                    <div class="vartical-nav-content-menu">
                                        <ul class="rbt-vertical-nav-list-wrapper">
                                            @forelse($category->children as $child)
                                                <li><a href="#">{{ $child->name }}</a></li>
                                            @empty
                                                <li><a href="#">No Subcategories</a></li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li>
                    <a href="#">Dashboard</a>
                </li>

                <li class="position-static">
                    <a href="#">Blogs</a>
                </li>

                <li class="position-static">
                    <a href="#">Contact</a>
                </li>
            </ul>
        </nav>

        <div class="mobile-menu-bottom">
            <div class="social-share-wrapper">
                <span class="rbt-short-title d-block">Find With Us</span>
                <ul class="social-icon social-default transparent-with-border justify-content-start mt--20">
                    <li><a href="https://www.facebook.com/">
                            <i class="feather-facebook"></i>
                        </a>
                    </li>
                    <li><a href="https://www.twitter.com">
                            <i class="feather-twitter"></i>
                        </a>
                    </li>
                    <li><a href="https://www.instagram.com/">
                            <i class="feather-instagram"></i>
                        </a>
                    </li>
                    <li><a href="https://www.linkdin.com/">
                            <i class="feather-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
