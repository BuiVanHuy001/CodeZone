<div class="rbt-dashboard-content bg-color-white rbt-shadow-box" wire:ignore>
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
                    <a href="#" class="tab-button" id="public-tab-4" data-bs-toggle="tab"
                       data-bs-target="#public-4" role="tab" aria-controls="public-4" aria-selected="false">
                        <span class="title">Public Courses</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="pending-tab-4" data-bs-toggle="tab"
                       data-bs-target="#pending-4" role="tab" aria-controls="pending-4" aria-selected="false">
                        <span class="title">Pending Courses</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="draft-tab-4" data-bs-toggle="tab"
                       data-bs-target="#draft-4" role="tab" aria-controls="draft-4" aria-selected="false">
                        <span class="title">Draft Courses</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="rejected-tab-4" data-bs-toggle="tab"
                       data-bs-target="#rejected-4" role="tab" aria-controls="rejected-4" aria-selected="false">
                        <span class="title">Rejected Courses</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade active show" id="all-4" role="tabpanel" aria-labelledby="all-tab-4">
                <div class="row g-5">
                    @forelse($allCourses as $course)
                        <x-client.share-ui.instructor-course-card :$course/>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No courses found.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="public-4" role="tabpanel" aria-labelledby="public-tab-4">
                <div class="row g-5">
                    @forelse($publicCourses as $course)
                        <x-client.share-ui.instructor-course-card :$course/>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No public courses found.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="pending-4" role="tabpanel" aria-labelledby="pending-tab-4">
                <div class="row g-5">
                    @forelse($pendingCourses as $course)
                        <x-client.share-ui.instructor-course-card :$course/>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No pending courses found.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="draft-4" role="tabpanel" aria-labelledby="draft-tab-4">
                <div class="row g-5">
                    @forelse($draftCourses as $course)
                        <x-client.share-ui.instructor-course-card :$course/>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No draft courses found.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="rejected-4" role="tabpanel" aria-labelledby="rejected-tab-4">
                <div class="row g-5">
                    @forelse($rejectedCourses as $course)
                        <x-client.share-ui.instructor-course-card :$course/>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No rejected courses found.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
