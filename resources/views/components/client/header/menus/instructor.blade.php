<ul class="user-list-wrapper">
    <li>
        <a href="{{ route('instructor.dashboard.index') }}">
            <i class="feather-home"></i>
            <span>Overview</span>
        </a>
    </li>
    <li>
        <a href="{{ route('instructor.dashboard.courses') }}">
            <i class="feather-book-open"></i>
            <span>My Courses</span>
        </a>
    </li>
    <li>
        <a href="{{ route('instructor.dashboard.profile') }}">
            <i class="feather-book-open"></i>
            <span>My Profile</span>
        </a>
    </li>

    <li>
        <a href="{{ route('instructor.dashboard.reviews') }}">
            <i class="feather-star"></i>
            <span>My Reviews</span>
        </a>
    </li>
</ul>
