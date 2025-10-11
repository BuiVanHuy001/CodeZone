<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">
        <div class="section-title">
            <h4 class="rbt-title-style-3">Your Purchases</h4>
        </div>

        <div class="rbt-dashboard-table table-responsive mobile-table-750">
            <table class="rbt-table table table-borderless">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Course Name</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                @forelse($purchases as $purchase)
                    <tr>
                        <th>{{ $purchase->id }}</th>
                        <td>
                            <ul>
                                @foreach($purchase->courses as $course)
                                    <li>
                                        <a href="{{ route('page.course_detail', $course->slug) }}">{{ $course->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $purchase->created_at->diffForHumans() }}</td>
                        <td>{{ $purchase->totalPriceText }}</td>
                        <td><span class="rbt-badge-5 bg-primary-opacity">{{ $purchase->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No purchases found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
