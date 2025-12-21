<div>
    <div class="rbt-dashboard-content bg-color-white rbt-shadow-box mb--60">
        <div class="content">
            <div class="section-title">
                <h4 class="rbt-title-style-3">Dashboard</h4>
            </div>
            <div class="row g-5">
                <x-client.dashboard.counter-card
                    title="Khóa học đang hoạt động"
                    :count="$this->publishedCourses"
                    icon="book-open"
                />

                <x-client.dashboard.counter-card
                    title="Đánh giá trung bình"
                    :count="$this->rating"
                    icon="star"
                    bgClass="bg-warning-opacity"
                    textClass="color-warning"
                />

                <x-client.dashboard.counter-card
                    title="Học viên đăng ký"
                    :count="$this->studentsEnrolled"
                    icon="user"
                    bgClass="bg-violet-opacity"
                    textClass="color-violet"
                />

                <x-client.dashboard.counter-card
                    title="Tổng đánh giá"
                    :count="$this->reviewCount"
                    icon="check-circle"
                    bgClass="bg-coral-opacity"
                    textClass="color-coral"
                />

                <x-client.dashboard.counter-card
                    title="Tổng thu nhập"
                    :count="$this->totalEarnings"
                    icon="dollar-sign"
                    bgClass="bg-pink-opacity"
                    textClass="color-pink"
                />
            </div>
        </div>
    </div>
</div>
