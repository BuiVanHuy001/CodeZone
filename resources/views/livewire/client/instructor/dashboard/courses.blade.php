<div class="rbt-dashboard-content bg-color-white rbt-shadow-box" wire:ignore>
    <div class="content">

        <div class="section-title">
            <h4 class="rbt-title-style-3">Khóa học của tôi</h4>
        </div>

        <div class="advance-tab-button mb--30">
            <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="myTab-4" role="tablist">
                <li role="presentation">
                    <a href="#" class="tab-button active" id="all-tab-4" data-bs-toggle="tab"
                       data-bs-target="#all-4" role="tab" aria-controls="all-4" aria-selected="true">
                        <span class="title">Tất cả</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="public-tab-4" data-bs-toggle="tab"
                       data-bs-target="#public-4" role="tab" aria-controls="public-4" aria-selected="false">
                        <span class="title">Đã xuất bản</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="pending-tab-4" data-bs-toggle="tab"
                       data-bs-target="#pending-4" role="tab" aria-controls="pending-4" aria-selected="false">
                        <span class="title">Chờ phê duyệt</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="draft-tab-4" data-bs-toggle="tab"
                       data-bs-target="#draft-4" role="tab" aria-controls="draft-4" aria-selected="false">
                        <span class="title">Bản nháp</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="rejected-tab-4" data-bs-toggle="tab"
                       data-bs-target="#rejected-4" role="tab" aria-controls="rejected-4" aria-selected="false">
                        <span class="title">Bị từ chối</span>
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
                            <div class="alert alert-info text-center py-5">
                                <i class="feather-info me-2"></i> <strong>Bạn chưa có khóa học nào.</strong>
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
                            <div class="alert alert-info text-center py-5">
                                <i class="feather-info me-2"></i> <strong>Không có khóa học nào đã xuất bản.</strong>
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
                            <div class="alert alert-info text-center py-5">
                                <i class="feather-clock me-2"></i> <strong>Không có khóa học nào đang chờ phê duyệt.</strong>
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
                            <div class="alert alert-info text-center py-5">
                                <i class="feather-edit-3 me-2"></i> <strong>Không có khóa học nào trong bản nháp.</strong>
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
                            <div class="alert alert-info text-center py-5">
                                <i class="feather-x-circle me-2"></i> <strong>Không có khóa học nào bị từ chối.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
