<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">

        <div class="section-title">
            <h4 class="rbt-title-style-3">My Courses</h4>
        </div>

        <div class="advance-tab-button mb--30">
            <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="myTab-4" role="tablist">
                <li role="presentation">
                    <a href="#" class="tab-button active" id="all-tab-4" data-bs-toggle="tab"
                       data-bs-target="#all-4" role="tab" aria-controls="all-4" aria-selected="true">
                        <span class="title">All Courses</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="learning-tab-4" data-bs-toggle="tab"
                       data-bs-target="#learning-4" role="tab" aria-controls="learning-4" aria-selected="false">
                        <span class="title">In Progress Courses</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="notstarted-tab-4" data-bs-toggle="tab"
                       data-bs-target="#notstarted-4" role="tab" aria-controls="notstarted-4" aria-selected="false">
                        <span class="title">Not Started Courses</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="completed-tab-4" data-bs-toggle="tab"
                       data-bs-target="#completed-4" role="tab" aria-controls="completed-4" aria-selected="false">
                        <span class="title">Completed Courses</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade active show" id="all-4" role="tabpanel" aria-labelledby="all-tab-4">
                <div class="row g-5">
                    @forelse($courses as $course)
                        <x-client.share-ui.student-course-card
                            :course="$course"
                        />
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No courses found.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="learning-4" role="tabpanel" aria-labelledby="learning-tab-4">
                <div class="row g-5">
                    @forelse($inProgressCourses as $course)
                        <x-client.share-ui.student-course-card
                            :course="$course"
                        />
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No courses in progress.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="notstarted-4" role="tabpanel" aria-labelledby="notstarted-tab-4">
                <div class="row g-5">
                    @forelse($notStartedCourses as $course)
                        <x-client.share-ui.student-course-card
                            :course="$course"
                        />
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No courses waiting to start.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="completed-4" role="tabpanel" aria-labelledby="completed-tab-4">
                <div class="row g-5">
                    @forelse($completedCourses as $course)
                        <x-client.share-ui.student-course-card
                            :course="$course"
                        />
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No completed courses yet.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
