@extends('layouts.client')

@section('content')
    <div class="rbt-page-banner-wrapper">
        <div class="rbt-banner-image"></div>
        <div class="rbt-banner-content">
            <div class="rbt-banner-content-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="page-list">
                                <li class="rbt-breadcrumb-item"><a href="{{ route('page.home') }}">Home</a></li>
                                <li>
                                    <div class="icon-right"><i class="feather-chevron-right"></i></div>
                                </li>
                                <li class="rbt-breadcrumb-item active">All Courses</li>
                            </ul>

                            <div class=" title-wrapper">
                                <h1 class="title mb--0">All Courses</h1>
                                <a href="#" class="rbt-badge-2">
                                    <div class="image">🎉</div> {{ $courses->total() }} Courses
                                </a>
                            </div>

                            <p class="description">Explore courses from experienced, real-world experts.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rbt-course-top-wrapper mt--40 mt_sm--20">
                <div class="container">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-5 col-md-12">
                            <div class="rbt-sorting-list d-flex flex-wrap align-items-center">
                                <div class="rbt-short-item">
                                    <span class="course-index">
                                        Showing {{ $courses->firstItem() }}–{{ $courses->lastItem() }} of {{ $courses->total() }} courses
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-12">
                            <div class="rbt-sorting-list d-flex flex-wrap align-items-center justify-content-start justify-content-lg-end">
                                <div class="rbt-short-item">
                                    <form action="{{ route('page.courses') }}" method="GET" class="rbt-search-style me-0">
                                        <input name="search" value="{{ request('search') }}" type="text" placeholder="Search for anything">
                                        <button type="submit" class="rbt-search-btn rbt-round-btn">
                                            <i class="feather-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="default-exp-wrapper">
                        <form id="filterForm" action="{{ route('page.courses') }}" method="GET">
                            <div class="filter-inner">
                                <x-client.share-ui.filter-select label="Short By" :items="$shortByOptions" name="short_by"/>

                                <x-client.share-ui.filter-select label="Short By Author" :items="$topInstructors" :isModern="true" name="instructor"/>

                                <x-client.share-ui.filter-select label="Short By Offer" :items="$offsetOptions" name="offer"/>

                                <x-client.share-ui.filter-select label="Short By Category" :items="$categories" name="category"/>

                                <button class="rbt-btn btn-sm my-auto" type="submit">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="inner">
            <div class="container">
                <div class="rbt-course-grid-column">
                    @forelse($courses as $course)
                        <x-client.share-ui.course-card
                            :course="$course"
                            class="course-grid-3"
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
                                @if ($courses->onFirstPage())
                                    <li class="disabled">
                                        <span aria-label="Previous"><i class="feather-chevron-left"></i></span></li>
                                @else
                                    <li>
                                        <a href="{{ $courses->appends(request()->query())->previousPageUrl() }}" aria-label="Previous"><i class="feather-chevron-left"></i></a>
                                    </li>
                                @endif

                                @foreach ($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                                    @if ($page == $courses->currentPage())
                                        <li class="active"><a href="#">{{ $page }}</a></li>
                                    @else
                                        <li>
                                            <a href="{{ $courses->appends(request()->query())->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                @if ($courses->hasMorePages())
                                    <li>
                                        <a href="{{ $courses->appends(request()->query())->nextPageUrl() }}" aria-label="Next"><i class="feather-chevron-right"></i></a>
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
@endsection

@push('scripts')
    <script>
        document.getElementById('filterForm').addEventListener('submit', function (e) {
            const instructorSelect = this.querySelector('select[name="instructor[]"]');
            if (instructorSelect) {
                const selected = Array.from(instructorSelect.selectedOptions).map(opt => opt.value);
                if (selected.length > 0) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'instructor';
                    hiddenInput.value = selected.join(',');
                    this.appendChild(hiddenInput);
                }
                instructorSelect.removeAttribute('name');
            }
            const formElements = this.elements;
            const defaultValues = ['all', 'popular', ''];

            for (const element of formElements) {
                if (defaultValues.includes(element.value.trim())) {
                    element.disabled = true;
                }
            }
        });
    </script>
@endpush
