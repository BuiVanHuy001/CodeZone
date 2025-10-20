<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">
        <div class="section-title">
            <h4 class="rbt-title-style-3">My Profile</h4>
        </div>
        <div class="rbt-profile-row row row--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Registration Date</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->created_at->diffForHumans() }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Full name</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->name }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Email</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->email }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Course amount</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->courseCountText }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Student amount</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ $instructor->studentCountText }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Rating</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">
                    <x-client.course-details.reviews.components.star :star-number="$instructor->rating" class="rating"/>
                    ({{ $instructor->reviewCountText }})
                </div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">About me</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{!! nl2br(e($instructor->aboutMe)) !!}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Biography</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2 markdown-body">
                    @markdown($instructor->bio)
                </div>
            </div>
        </div>
    </div>
</div>
