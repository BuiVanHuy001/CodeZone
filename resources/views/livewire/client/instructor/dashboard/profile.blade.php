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
                <div class="rbt-profile-content b2">{{ auth()->user()->created_at->diffForHumans()  }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Full name</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ auth()->user()->name }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Email</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{{ auth()->user()->email }}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Course amount</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">Updated later</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">About me</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2">{!! nl2br(e(auth()->user()->getProfile->about_me)) !!}</div>
            </div>
        </div>

        <div class="rbt-profile-row row row--15 mt--15">
            <div class="col-lg-4 col-md-4">
                <div class="rbt-profile-content b2">Biography</div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="rbt-profile-content b2 markdown-body">
                    @markdown(auth()->user()->getProfile->bio)
                </div>
            </div>
        </div>
    </div>
</div>
