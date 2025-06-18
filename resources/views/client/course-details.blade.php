<x-base categories="$categories" page-title="Home">
    <div class="rbt-breadcrumb-default rbt-breadcrumb-style-3">
        <div class="breadcrumb-inner breadcrumb-dark">
            <img src="{{ asset('images/bg/bg-image-10.jpg') }}" alt="Education Images">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content text-start">
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Web developer</li>
                        </ul>
                        <h1 class="title">Node.js, Express, MongoDB & More: The Complete Bootcamp</h1>
                        <p class="description">Master Node by building a real-world RESTful API and web app (with authentication, Node.js security, payments & more)</p>

                        <div class="d-flex align-items-center mb--20 flex-wrap rbt-course-details-feature">

                            <div class="feature-sin best-seller-badge">
                                <span class="rbt-badge-2">
                                    <span class="image">
	                                    <img src="{{ asset('images/icons/card-icon-1.png') }}" alt="Best Seller Icon">
                                    </span> Bestseller
                                </span>
                            </div>

                            <div class="feature-sin rating">
                                <a href="#">4.8</a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                            </div>

                            <div class="feature-sin total-rating">
                                <a class="rbt-badge-4" href="#">215,475 rating</a>
                            </div>

                            <div class="feature-sin total-student">
                                <span>616,029 students</span>
                            </div>

                        </div>

                        <div class="rbt-author-meta mb--20">
                            <div class="rbt-avater">
                                <a href="#">
                                    <img src="{{ asset('images/client/avatar-02.png') }}" alt="Sophia Jaymes">
                                </a>
                            </div>
                            <div class="rbt-author-info">
                                By <a href="">Angela</a> in <a href="#">Developer</a>
                            </div>
                        </div>

                        <ul class="rbt-meta">
                            <li><i class="feather-calendar"></i>Last updates 12/2024</li>
                            <li><i class="feather-globe"></i>English</li>
                            <li><i class="feather-award"></i>Certification</li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-course-details-area ptb--60">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-8">
                    <div class="course-details-content">
                        <div class="rbt-course-feature-box rbt-shadow-box thuumbnail">
                            <img class="w-100" src="{{ asset('images/course/course-01.jpg') }}" alt="Card image">
                        </div>

                        <div class="rbt-inner-onepage-navigation sticky-top mt--30">
                            <nav class="mainmenu-nav onepagenav">
                                <ul class="mainmenu">
                                    <li class="current">
                                        <a href="#overview">Overview</a>
                                    </li>
                                    <li>
                                        <a href="#coursecontent">Course content</a>
                                    </li>
                                    <li>
                                        <a href="#details">Description</a>
                                    </li>
                                    <li>
                                        <a href="#intructor">Instructor</a>
                                    </li>
                                    <li>
                                        <a href="#review">Reviews</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div class="rbt-course-feature-box overview-wrapper rbt-shadow-box mt--30 has-show-more"
                             id="overview">
                            <div class="rbt-course-feature-inner has-show-more-inner-content">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3">What you'll learn</h4>
                                </div>
                                <div class="row g-5 mb--30">
                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-1">
                                            <li><i class="feather-check"></i>Master the entire modern back-end stack: Node,
                                                Express, MongoDB and Mongoose (MongoDB JS driver).
                                            </li>
                                            <li><i class="feather-check"></i>Build a fast, scalable, feature-rich RESTful
                                                API (includes filters, sorts, pagination, and much more.
                                            </li>
                                            <li><i class="feather-check"></i>CRUD operations with MongoDB and Mongoose.</li>
                                            <li><i class="feather-check"></i>Server-side website rendering with Pug
                                                templates.
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-1">
                                            <li><i class="feather-check"></i>Build a complete, beautiful & real-world
                                                application from start to finish (API and server-side rendered website).
                                            </li>
                                            <li><i class="feather-check"></i>Learn how Node really works behind the scenes:
                                                event loop, blocking vs non-blocking code, streams, modules, etc.
                                            </li>
                                            <li><i class="feather-check"></i>Sending emails & uploading files.</li>
                                            <li><i class="feather-check"></i>Downloadable videos, code and design assets for
                                                projects.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="rbt-show-more-btn">Xem thêm</div>
                        </div>

                        <div class="course-content rbt-shadow-box coursecontent-wrapper mt--30" id="coursecontent">
                            <div class="rbt-course-feature-inner">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3">Course content</h4>
                                </div>
                                <div class="rbt-accordion-style rbt-accordion-02 accordion">
                                    <div class="accordion" id="accordionExampleb2">

                                        <div class="accordion-item card">
                                            <h2 class="accordion-header card-header" id="headingTwo2">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo2"
                                                        aria-expanded="false" aria-controls="collapseTwo2">
                                                    Basic Knowledge
                                                    <span class="rbt-badge-5 ml--10">2 hours 30 minutes</span>
                                                </button>
                                            </h2>
                                            <div id="collapseTwo2" class="accordion-collapse collapse"
                                                 aria-labelledby="headingTwo2" data-bs-parent="#accordionExampleb2">
                                                <div class="accordion-body card-body pr--0">
                                                    <ul class="rbt-course-main-content liststyle">
                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span
                                                                        class="text">Course Introduction</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>
                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span
                                                                        class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span
                                                                        class="text">Why You Shouldn't Pursue Education.</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span
                                                                        class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span
                                                                        class="text">Ten Factors Affecting the Longevity of Education.</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span
                                                                        class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item card">
                                            <h2 class="accordion-header card-header" id="headingTwo3">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo3"
                                                        aria-expanded="false" aria-controls="collapseTwo3">
                                                    Skill Development and Setup <span class="rbt-badge-5 ml--10">1 hour 50 minutes</span>
                                                </button>
                                            </h2>
                                            <div id="collapseTwo3" class="accordion-collapse collapse"
                                                 aria-labelledby="headingTwo3" data-bs-parent="#accordionExampleb2">
                                                <div class="accordion-body card-body pr--0">
                                                    <ul class="rbt-course-main-content liststyle">
                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span
                                                                        class="text">Course Introduction</span>
                                                                </div>
                                                                <div class="course-content-right">
															<span class="course-lock">
																<i class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>
                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span
                                                                        class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
															<span class="course-lock">
																<i class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li>
                                                            <a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i>
                                                                    <span class="text">Why You Shouldn't Pursue Education.</span>
                                                                </div>
                                                                <div class="course-content-right">
															<span class="course-lock">
																<i class="feather-lock"></i></span>
                                                                </div>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i>
                                                                    <span class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
															<span class="course-lock"><i class="feather-lock"></i>
															</span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span
                                                                        class="text">Ten Factors Affecting the Longevity of Education.</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span
                                                                        class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item card">
                                            <h2 class="accordion-header card-header" id="headingTwo4">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo4"
                                                        aria-expanded="false" aria-controls="collapseTwo4">
                                                    15 Things to Know About Education? <span class="rbt-badge-5 ml--10">2 hours 60 minutes</span>
                                                </button>
                                            </h2>
                                            <div id="collapseTwo4" class="accordion-collapse collapse"
                                                 aria-labelledby="headingTwo4" data-bs-parent="#accordionExampleb2">
                                                <div class="accordion-body card-body pr--0">
                                                    <ul class="rbt-course-main-content liststyle">
                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i>
                                                                    <span class="text">Course Introduction</span>
                                                                </div>
                                                                <div class="course-content-right">
                                                                    <span class="course-lock"><i class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>
                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                                                                    <span class="course-lock"><i class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span class="text">Why You Shouldn't Pursue Education.</span>
                                                                </div>
                                                                <div class="course-content-right">
                                                                    <span class="course-lock"><i class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span
                                                                        class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                                                                    <span class="course-lock"><i class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span
                                                                        class="text">Ten Factors Affecting the Longevity of Education.</span>
                                                                </div>
                                                                <div class="course-content-right">
                                                                    <span class="course-lock"><i class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                                                                    <span class="course-lock"><i class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-item card">
                                            <h2 class="accordion-header card-header" id="headingTwo5">
                                                <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo5"
                                                        aria-expanded="false" aria-controls="collapseTwo5">
                                                    Course Description
                                                    <span class="rbt-badge-5 ml--10">2 hours 20 minutes</span>
                                                </button>
                                            </h2>
                                            <div id="collapseTwo5" class="accordion-collapse collapse"
                                                 aria-labelledby="headingTwo5" data-bs-parent="#accordionExampleb2">
                                                <div class="accordion-body card-body pr--0">
                                                    <ul class="rbt-course-main-content liststyle">
                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span
                                                                        class="text">Course Introduction</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>
                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span
                                                                        class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span
                                                                        class="text">Why You Shouldn't Pursue Education.</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span
                                                                        class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-play-circle"></i> <span
                                                                        class="text">Ten Factors Affecting the Longevity of Education.</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>

                                                        <li><a href="">
                                                                <div class="course-content-left">
                                                                    <i class="feather-file-text"></i> <span
                                                                        class="text">Read Before Starting</span>
                                                                </div>
                                                                <div class="course-content-right">
                            <span class="course-lock"><i
                                    class="feather-lock"></i></span>
                                                                </div>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rbt-course-feature-box rbt-shadow-box details-wrapper mt--30" id="details">
                            <div class="row g-5">
                                <div class="col-lg-6">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3 mb--20">Yêu cầu</h4>
                                    </div>
                                    <ul class="rbt-list-style-1">
                                        <li><i class="feather-check"></i>Trở thành một lập trình viên JavaScript nâng
                                            cao, tự tin và hiện đại
                                            từ con số không.
                                        </li>
                                        <li><i class="feather-check"></i>Có kỹ năng lập trình Python ở mức trung cấp.
                                        </li>
                                        <li><i class="feather-check"></i>Có một danh mục các dự án phân tích dữ liệu
                                            đa dạng.
                                        </li>
                                        <li><i class="feather-check"></i>Sử dụng thư viện numpy để tạo và thao tác
                                            mảng.
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-lg-6">
                                    <div class="section-title">
                                        <h4 class="rbt-title-style-3 mb--20">Mô tả</h4>
                                    </div>
                                    <ul class="rbt-list-style-1">
                                        <li><i class="feather-check"></i>Sử dụng môi trường Jupyter Notebook.
                                            Lập trình viên JavaScript từ con số không.
                                        </li>
                                        <li><i class="feather-check"></i>Sử dụng module pandas với Python để tạo và
                                            cấu trúc dữ liệu.
                                        </li>
                                        <li><i class="feather-check"></i>Có một danh mục các dự án phân tích dữ liệu
                                            đa dạng.
                                        </li>
                                        <li><i class="feather-check"></i>Tạo trực quan hóa dữ liệu bằng matplotlib và
                                            seaborn.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="rbt-instructor rbt-shadow-box intructor-wrapper mt--30" id="intructor">
                            <div class="about-author border-0 pb--0 pt--0">
                                <div class="section-title mb--30">
                                    <h4 class="rbt-title-style-3">Instructor</h4>
                                </div>
                                <div class="media align-items-center">
                                    <div class="thumbnail">
                                        <a href="">
                                            <img src="{{ asset('images/testimonial/testimonial-7.jpg') }}" alt="Author Images">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="author-info">
                                            <h5 class="title">
                                                <a class="hover-flip-item-wrapper" href="./profile">B.M. Rafekul Islam</a>
                                            </h5>
                                            <span class="b3 subtitle">Web Developer, Designer, and Teacher</span>
                                            <ul class="rbt-meta mb--20 mt--10">
                                                <li><i class="fa fa-star color-warning"></i>75,237 Reviews<span
                                                        class="rbt-badge-5 ml--5">4.4 Rating</span></li>
                                                <li><i class="feather-users"></i>912,970 Students</li>
                                                <li><a href="#"><i class="feather-video"></i>16 courses</a></li>
                                            </ul>
                                        </div>
                                        <div class="content">
                                            <p class="description">Hi, I'm Rafekul Islam! I'm one of CodeZone's Top
                                                Instructors, and all my premium courses have earned the best-selling status
                                                for outstanding performance and student satisfaction.</p>

                                            <p class="description">
                                                I'm a full-stack web developer and designer with a passion for building
                                                beautiful web interfaces from scratch. I've been building websites and apps
                                                since 2010 and also have a Master's degree in Engineering.
                                            </p>
                                            <p class="description">
                                                I discovered my passion for teaching and helping others by sharing
                                                everything I knew during college. This passion led me to CodeZone in 2015,
                                                where I now have the privilege of training 2,000,000+ learners in the field
                                                of web development.
                                            </p>

                                            <ul class="social-icon social-default icon-naked justify-content-start">
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
                        </div>

                        <div class="rbt-review-wrapper rbt-shadow-box review-wrapper mt--30" id="review">
                            <div class="course-content">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3">Reviews</h4>
                                </div>
                                <div class="row g-5 align-items-center">
                                    <div class="col-lg-3">
                                        <div class="rating-box">
                                            <div class="rating-number">5.0</div>
                                            <div class="rating">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                </svg>
                                            </div>
                                            <span class="sub-title">Course reviews</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="review-wrapper">
                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 63%"
                                                         aria-valuenow="63" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text">63%</span>
                                            </div>

                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 29%"
                                                         aria-valuenow="29" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text">29%</span>
                                            </div>

                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 6%"
                                                         aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text">6%</span>
                                            </div>

                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 1%"
                                                         aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text">1%</span>
                                            </div>

                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 1%"
                                                         aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text">1%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Edu Review List  -->

                        <div class="about-author-list rbt-shadow-box featured-wrapper mt--30 has-show-more">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Featured review</h4>
                            </div>
                            <div class="has-show-more-inner-content rbt-featured-review-list-wrapper">
                                <div class="rbt-course-review about-author">
                                    <div class="media">
                                        <div class="thumbnail">
                                            <a href="#">
                                                <img src="{{ asset('images/testimonial/testimonial-3.jpg') }}"
                                                     alt="Author Images">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="author-info">
                                                <h5 class="title">
                                                    <a class="hover-flip-item-wrapper" href="#">
                                                        Farjana Bawnia
                                                    </a>
                                                </h5>
                                                <div class="rating">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <p class="description">At 29 years old, my favorite compliment is being
                                                    told that I look like my mom. Seeing myself in her image, like this
                                                    daughter up top.</p>
                                                <ul
                                                    class="social-icon social-default transparent-with-border justify-content-start">
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-up"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-down"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rbt-course-review about-author">
                                    <div class="media">
                                        <div class="thumbnail">
                                            <a href="#">
                                                <img src="{{ asset('images/testimonial/testimonial-4.jpg') }}"
                                                     alt="Author Images">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="author-info">
                                                <h5 class="title">
                                                    <a class="hover-flip-item-wrapper" href="#">Razwan Islam</a>
                                                </h5>
                                                <div class="rating">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <p class="description">My favorite compliment is being
                                                    told that I look like my mom. Seeing myself in her image, like this
                                                    daughter up top.</p>
                                                <ul
                                                    class="social-icon social-default transparent-with-border justify-content-start">
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-up"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-down"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rbt-course-review about-author">
                                    <div class="media">
                                        <div class="thumbnail">
                                            <a href="#">
                                                <img src="{{ asset('images/testimonial/testimonial-1.jpg') }}"
                                                     alt="Author Images">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="author-info">
                                                <h5 class="title">
                                                    <a class="hover-flip-item-wrapper" href="#">Babor Azom</a>
                                                </h5>
                                                <div class="rating">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <p class="description">My favorite compliment is being
                                                    told that I look like my mom. Seeing myself in her image, like this
                                                    daughter up top.</p>
                                                <ul
                                                    class="social-icon social-default transparent-with-border justify-content-start">
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-up"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-down"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rbt-course-review about-author">
                                    <div class="media">
                                        <div class="thumbnail">
                                            <a href="#">
                                                <img src="{{ asset('images/testimonial/testimonial-6.jpg') }}"
                                                     alt="Author Images">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="author-info">
                                                <h5 class="title">
                                                    <a class="hover-flip-item-wrapper" href="#">Mohammad Ali</a>
                                                </h5>
                                                <div class="rating">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <p class="description">My favorite compliment is being
                                                    told that I look like my mom. Seeing myself in her image, like this
                                                    daughter up top.</p>
                                                <ul
                                                    class="social-icon social-default transparent-with-border justify-content-start">
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-up"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-down"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rbt-course-review about-author">
                                    <div class="media">
                                        <div class="thumbnail">
                                            <a href="#">
                                                <img src="{{ asset('images/testimonial/testimonial-8.jpg') }}"
                                                     alt="Author Images">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="author-info">
                                                <h5 class="title">
                                                    <a class="hover-flip-item-wrapper" href="#">Sakib Al Hasan</a>
                                                </h5>
                                                <div class="rating">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <p class="description">My favorite compliment is being
                                                    told that I look like my mom. Seeing myself in her image, like this
                                                    daughter up top.</p>
                                                <ul
                                                    class="social-icon social-default transparent-with-border justify-content-start">
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-up"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="#">
                                                            <i class="feather-thumbs-down"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rbt-show-more-btn">Show all reviews</div>
                        </div>
                    </div>
                    <div class="related-course mt--60">
                        <div class="row g-5 align-items-end mb--40">
                            <div class="col-lg-8 col-md-8 col-12">
                                <div class="section-title">
                                    <h4 class="title">More Courses by <strong class="color-primary">Angela</strong>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="read-more-btn text-start text-md-end">
                                    <a class="rbt-btn rbt-switch-btn btn-border btn-sm" href="#">
                                        <span data-text="Xem tất cả Khóa học">View all courses</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up"
                                 data-sal-duration="800">
                                <div class="rbt-card variation-01 rbt-hover">
                                    <div class="rbt-card-img">
                                        <a href="course-details.html">
                                            <img src="{{ asset('images/course/course-online-01.jpg') }}" alt="Card image">
                                            <div class="rbt-badge-3 bg-white">
                                                <span>-40%</span>
                                                <span>Giảm</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="rbt-card-body">
                                        <div class="rbt-card-top">
                                            <div class="rbt-review">
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span class="rating-count"> (15 Đánh giá)</span>
                                            </div>
                                            <div class="rbt-bookmark-btn">
                                                <a class="rbt-round-btn" title="Đánh dấu" href="#"><i
                                                        class="feather-bookmark"></i></a>
                                            </div>
                                        </div>

                                        <h4 class="rbt-card-title"><a href="">React Từ Frontend đến
                                                Backend</a>
                                        </h4>

                                        <ul class="rbt-meta">
                                            <li><i class="feather-book"></i>12 Bài học</li>
                                            <li><i class="feather-users"></i>50 Học viên</li>
                                        </ul>

                                        <p class="rbt-card-text">Đây là một sự thật đã được thiết lập từ lâu rằng người
                                            đọc sẽ bị
                                            phân tâm.</p>
                                        <div class="rbt-author-meta mb--10">
                                            <div class="rbt-avater">
                                                <a href="#">
                                                    <img src="{{ asset('images/client/avatar-02.png') }}" alt="Sophia Jaymes">
                                                </a>
                                            </div>
                                            <div class="rbt-author-info">
                                                Bởi <a href="profile.html">Angela</a> Trong <a href="#">Phát triển</a>
                                            </div>
                                        </div>
                                        <div class="rbt-card-bottom">
                                            <div class="rbt-price">
                                                <span class="current-price">1.500.000₫</span>
                                                <span class="off-price">3.000.000₫</span>
                                            </div>
                                            <a class="rbt-btn-link" href="course-details.html">Tìm hiểu
                                                thêm<i class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Card  -->

                            <!-- Start Single Card  -->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up"
                                 data-sal-duration="800">
                                <div class="rbt-card variation-01 rbt-hover">
                                    <div class="rbt-card-img">
                                        <a href="course-details.html">
                                            <img src="{{ asset('images/course/course-online-02.jpg') }}" alt="Card image">
                                        </a>
                                    </div>
                                    <div class="rbt-card-body">
                                        <div class="rbt-card-top">
                                            <div class="rbt-review">
                                                <div class="rating">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <span class="rating-count"> (15 Đánh giá)</span>
                                            </div>
                                            <div class="rbt-bookmark-btn">
                                                <a class="rbt-round-btn" title="Đánh dấu" href="#"><i
                                                        class="feather-bookmark"></i></a>
                                            </div>
                                        </div>
                                        <h4 class="rbt-card-title"><a href="course-details.html">PHP Từ Cơ bản đến
                                                Nâng cao</a>
                                        </h4>
                                        <ul class="rbt-meta">
                                            <li><i class="feather-book"></i>12 Bài học</li>
                                            <li><i class="feather-users"></i>50 Học viên</li>
                                        </ul>

                                        <p class="rbt-card-text">Đây là một sự thật đã được thiết lập từ lâu rằng người đọc
                                            sẽ bị phân tâm.</p>
                                        <div class="rbt-author-meta mb--10">
                                            <div class="rbt-avater">
                                                <a href="#">
                                                    <img src="{{ asset('images/client/avatar-02.png') }}" alt="Sophia Jaymes">
                                                </a>
                                            </div>
                                            <div class="rbt-author-info">
                                                Bởi <a href="profile.html">Angela</a> in <a href="#">Development</a>
                                            </div>
                                        </div>
                                        <div class="rbt-card-bottom">
                                            <div class="rbt-price">
                                                <span class="current-price">1.500.000₫</span>
                                                <span class="off-price">3.000.000₫</span>
                                            </div>
                                            <a class="rbt-btn-link left-icon" href="course-details.html"><i
                                                    class="feather-shopping-cart"></i>Add to cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="course-sidebar sticky-top rbt-shadow-box course-sidebar-top rbt-gradient-border">
                        <div class="inner">

                            <a class="video-popup-with-text video-popup-wrapper text-center popup-video sidebar-video-hidden mb--15"
                               href="https://www.youtube.com/watch?v=nA1Aqp0sPQo">
                                <div class="video-content">
                                    <img class="w-100 rbt-radius" src="images/others/video-01.jpg"
                                         alt="Video Images">
                                    <div class="position-to-top">
                                        <span class="rbt-btn rounded-player-2 with-animation">
                                            <span class="play-icon"></span>
                                        </span>
                                    </div>
                                    <span class="play-view-text d-block color-white"><i class="feather-eye"></i> Preview this course</span>
                                </div>
                            </a>

                            <div class="content-item-content">
                                <div
                                    class="rbt-price-wrapper d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="rbt-price">
                                        <span class="current-price">1.524.750₫</span>
                                        <span class="off-price">2.124.750₫</span>
                                    </div>
                                    <div class="discount-time">
                                        <span class="rbt-badge color-danger bg-color-danger-opacity"><i
                                                class="feather-clock"></i> 3 days left!</span>
                                    </div>
                                </div>

                                <div class="add-to-card-button mt--15">
                                    <a class="rbt-btn btn-gradient icon-hover w-100 d-block text-center" href="#">
                                        <span class="btn-text">Add to cart</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </a>
                                </div>

                                <div class="buy-now-btn mt--15">
                                    <a class="rbt-btn btn-border icon-hover w-100 d-block text-center" href="#">
                                        <span class="btn-text">Buy now</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </a>
                                </div>
                                <div class="rbt-widget-details has-show-more">
                                    <ul class="has-show-more-inner-content rbt-course-details-list-wrapper">
                                        <li>
                                            <span>Duration: </span><span class="rbt-feature-value rbt-badge-5">5 hours 20 minutes</span>
                                        </li>
                                        <li>
                                            <span>Enrolled: </span><span class="rbt-feature-value rbt-badge-5">100</span>
                                        </li>
                                        <li>
                                            <span>Lesson</span><span class="rbt-feature-value rbt-badge-5">50</span>
                                        </li>
                                        <li>
                                            <span>Level</span><span class="rbt-feature-value rbt-badge-5">Basic</span>
                                        </li>
                                        <li>
                                            <span>Language: </span><span class="rbt-feature-value rbt-badge-5">English</span>
                                        </li>
                                        <li>
                                            <span>Quiz</span><span class="rbt-feature-value rbt-badge-5">10</span>
                                        </li>
                                        <li>
                                            <span>Certification</span><span class="rbt-feature-value rbt-badge-5">Yes</span>
                                        </li>
                                    </ul>
                                    <div class="rbt-show-more-btn">Show more</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>

    <div class="rbt-course-action-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="section-title text-center text-md-start">
                        <h5 class="title mb--0">Node.js, Express, MongoDB & More: The Complete Bootcamp</h5>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mt_sm--15">
                    <div class="course-action-bottom-right rbt-single-group">
                        <div class="rbt-single-list rbt-price large-size justify-content-center">
                            <span class="current-price color-primary">18.750.000₫</span>
                            <span class="off-price">37.500.000₫</span>
                        </div>
                        <div class="rbt-single-list action-btn">
                            <a class="rbt-btn btn-gradient hover-icon-reverse btn-md" href="#">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Buy now</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
</x-base>
