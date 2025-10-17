<div class="rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="inner">
        <div class="container">
            <div class="rbt-course-grid-column">
                @forelse($courses as $course)
                    <x-client.share-ui.course-card
                        :course="$course"
                        class="course-grid-3"
                        wire:ignore
                    />
                @empty
                    <div class="col-lg-12">
                        <div class="rbt-alert alert-warning mb--0" role="alert">
                            No courses found.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="row">
                <div class="col-lg-12 mt--60">
                    <nav>
                        <ul class="rbt-pagination">
                            {{-- Previous Page Link --}}
                            @if ($courses->onFirstPage())
                                <li class="disabled">
                                    <span aria-label="Previous"><i class="feather-chevron-left"></i></span></li>
                            @else
                                <li>
                                    <a href="{{ $courses->previousPageUrl() }}" aria-label="Previous"><i class="feather-chevron-left"></i></a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                                @if ($page == $courses->currentPage())
                                    <li class="active"><a href="#">{{ $page }}</a></li>
                                @else
                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($courses->hasMorePages())
                                <li>
                                    <a href="{{ $courses->nextPageUrl() }}" aria-label="Next"><i class="feather-chevron-right"></i></a>
                                </li>
                            @else
                                <li class="disabled">
                                    <span aria-label="Next"><i class="feather-chevron-right"></i></span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
