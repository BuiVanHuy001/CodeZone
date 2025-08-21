<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">
        <div class="section-title">
            <h4 class="rbt-title-style-3">My Profile</h4>
        </div>

        @foreach($infos as $key => $info)
            <div class="rbt-profile-row row row--15">
                <div class="col-lg-4 col-md-4">
                    <div class="rbt-profile-content b2">{{ $key }}</div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="rbt-profile-content b2">{{ $info }}</div>
                </div>
            </div>
        @endforeach

    </div>
</div>
