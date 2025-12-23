<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">
        <div class="section-title">
            <h4 class="rbt-title-style-3">Hồ sơ cá nhân</h4>
        </div>

        <div class="rbt-profile-row row row--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Ngày tham gia</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->created_at->diffForHumans() }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Họ và tên</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->name }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Địa chỉ Email</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->email }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Số lượng khóa học</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->courseCountText }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Số lượng sinh viên</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->studentCountText }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Đánh giá trung bình</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">
                    <x-client.course-details.reviews.components.star :star-number="$instructor->rating" class="rating"/>
                    ({{ $instructor->reviewCountText }} lượt đánh giá)
                </div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Giới thiệu ngắn</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{!! nl2br(e($instructor->aboutMe)) !!}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Tiểu sử chi tiết</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2 markdown-body">
                    @markdown($instructor->bio)
                </div>
            </div>
        </div>
    </div>
</div>
