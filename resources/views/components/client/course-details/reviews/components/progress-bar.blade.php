<div class="single-progress-bar">
    <x-client.course-details.reviews.components.star
        :starNumber="$starNumber"
    />
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: {{ $percent }}%"
             aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>
    <span class="value-text">{{ $percent }}%</span>
</div>
