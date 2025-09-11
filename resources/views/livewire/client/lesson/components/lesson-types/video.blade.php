<video id="player" playsinline controls class="w-100">
    <source src="{{  $videoUrl }}" type="video/mp4"/>
</video>
@push('scripts')
    <script>
        document.addEventListener('video-changed', () => {
            new Plyr('#player');
        });

        document.addEventListener('DOMContentLoaded', function () {
            new Plyr('#player');
        });
    </script>
@endpush
