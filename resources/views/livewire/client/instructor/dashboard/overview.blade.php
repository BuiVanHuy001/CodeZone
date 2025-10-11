<div>
    <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
        <div class="content">
            <div class="section-title">
                <h4 class="rbt-title-style-3">Dashboard</h4>
            </div>
            <div class="row g-5">
                <x-client.dashboard.counter-card
                    title="Active Courses"
                    :count="$this->publishedCourses"
                    icon="book-open"
                />

                <x-client.dashboard.counter-card
                    title="Total Earnings"
                    :count="$this->rating"
                    icon="star"
                    bgClass="bg-warning-opacity"
                    textClass="color-warning"
                />

                <x-client.dashboard.counter-card
                    title="Student"
                    :count="$this->studentsEnrolled"
                    icon="user"
                    bgClass="bg-violet-opacity"
                    textClass="color-violet"
                />

                <x-client.dashboard.counter-card
                    title="Reviews"
                    :count="$this->reviewCount"
                    icon="check-circle"
                    bgClass="bg-coral-opacity"
                    textClass="color-coral"
                />

                <x-client.dashboard.counter-card
                    title="Total Earnings"
                    :count="$this->totalEarnings"
                    icon="dollar-sign"
                    bgClass="bg-pink-opacity"
                    textClass="color-pink"
                />
            </div>
        </div>
    </div>
    <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h4 class="rbt-title-style-3">My Courses</h4>
                    </div>
                </div>
            </div>
            <div class="row gy-5">
                <div class="col-lg-12">
                    <div class="rbt-dashboard-table table-responsive">
                        <table class="rbt-table table table-borderless">
                            <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Enrolled</th>
                                <th>Rating</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th><a href="#">Accounting</a></th>
                                <td>50</td>
                                <td>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><a href="#">Marketing</a></th>
                                <td>40</td>
                                <td>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><a href="#">Web Design</a></th>
                                <td>75</td>
                                <td>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><a href="#">Graphic</a></th>
                                <td>20</td>
                                <td>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="off fas fa-star"></i>
                                        <i class="off fas fa-star"></i>
                                        <i class="off fas fa-star"></i>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="load-more-btn text-center">
                        <a class="rbt-btn-link" href="#">Browse All
                            Course<i class="feather-arrow-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
