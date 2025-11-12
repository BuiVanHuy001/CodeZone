<div class="row">
    <div wire:loading wire:target="approve, reject, suspend">
        <x-client.share-ui.loading-effect/>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Active Courses</h5>
            </div>
            <div class="card-body">
                <div>
                    <table id="activeCourseTable" class="table nowrap align-middle" style="width:100%">
                        <thead>
                        <tr>
                            <th data-ordering="false">ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Students</th>
                            <th>Rating</th>
                            <th>Create At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courses['published'] as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>
                                    <a href="{{ $course->detailsPageUrl }}" target="_blank" class="fw-bold">{{ $course->title }}</a>
                                </td>
                                <td>{{ $course->categoryName }}</td>
                                <td>{{ $course->priceFormatted }}</td>
                                <td>
                                    <div class="d-flex align-items-center fw-medium">
                                        <a href="{{ $course->authorInfo['profileUrl'] }}" class="currency_name">
                                            <img src="{{ $course->authorInfo['avatar'] }}" alt="Instructor profile" loading="lazy" class="rounded-circle avatar-xxs me-2">
                                            {{ $course->authorInfo['name'] }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $course->status['bg-color'] }}">{{ $course->status['label'] }}</span>
                                </td>
                                <td>{{ $course->enrollmentCountText }}</td>
                                <td>{{ $course->ratingText }}</td>
                                <td>{{ $course->createdAtText }}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="{{ route('course.learn', $course->slug) }}" class="dropdown-item text-secondary" target="_blank">
                                                    <i class="ri-eye-line align-bottom me-2"></i> View Course Content
                                                </a>
                                            </li>
                                            <li>
                                                <button onclick="showSuspendedConfirm('{{ $course->id }}')" class="dropdown-item text-warning">
                                                    <i class="ri-pause-circle-line align-bottom me-2"></i> Suspend
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pending Courses</h5>
            </div>
            <div class="card-body">
                <div>
                    <table id="pendingCourseTable" class="table align-middle" style="width:100%">
                        <thead>
                        <tr>
                            <th data-ordering="false">ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Author</th>
                            <th>Duration</th>
                            <th>Create At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courses['pending'] as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td><a href="{{ $course->detailsPageUrl }}" class="fw-bold">{{ $course->title }}</a>
                                </td>
                                <td>{{ $course->categoryName }}</td>
                                <td>{{ $course->priceFormatted }}</td>
                                <td>
                                    <div class="d-flex align-items-center fw-medium">
                                        <a href="{{ $course->authorInfo['profileUrl'] }}" class="currency_name">
                                            <img src="{{ $course->authorInfo['avatar'] }}" alt="Instructor profile" loading="lazy" class="rounded-circle avatar-xxs me-2">
                                            {{ $course->authorInfo['name'] }}
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $course->durationText }}</td>
                                <td>{{ $course->createdAtText }}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button onclick="showApprovedConfirm('{{ $course->id }}')" class="btn btn-xl dropdown-item text-success">
                                                    <i class="ri-checkbox-circle-line align-bottom me-2 text-success"></i>Approve
                                                </button>
                                            </li>
                                            <li>
                                                <button onlick="showRejectedConfirm('{{ $course->id }}')" class="btn btn-xl dropdown-item text-danger">
                                                    <i class="ri-close-circle-fill align-bottom me-2"></i>Reject
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Suspended Courses</h5>
            </div>
            <div class="card-body">
                <div>
                    <table id="suspendedCourseTable" class="table align-middle" style="width:100%">
                        <thead>
                        <tr>
                            <th data-ordering="false">ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Author</th>
                            <th>Duration</th>
                            <th>Create At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($courses['suspended'] as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td><a href="{{ $course->detailsPageUrl }}" class="fw-bold">{{ $course->title }}</a>
                                </td>
                                <td>{{ $course->categoryName }}</td>
                                <td>{{ $course->priceFormatted }}</td>
                                <td>
                                    <div class="d-flex align-items-center fw-medium">
                                        <a href="{{ $course->authorInfo['profileUrl'] }}" class="currency_name">
                                            <img src="{{ $course->authorInfo['avatar'] }}" alt="Instructor profile" loading="lazy" class="rounded-circle avatar-xxs me-2">
                                            {{ $course->authorInfo['name'] }}
                                        </a>
                                    </div>
                                </td>
                                <td>{{ $course->durationText }}</td>
                                <td>{{ $course->createdAtText }}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button onclick="showRestoredConfirm('{{ $course->id }}')" class="btn btn-xl dropdown-item text-success">
                                                    <i class="ri-checkbox-circle-line align-bottom me-2"></i> Re-Active
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@assets
<link href="{{ Vite::asset('resources/assets/admin/libs/datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ Vite::asset('resources/assets/admin/libs/datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ Vite::asset('resources/assets/admin/libs/datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
<style>
    div.dataTables_length,
    div.dataTables_info {
        display: inline-block;
    }

    div.dataTables_length {
        margin-right: 15px;
        vertical-align: middle;
    }

    div.dataTables_length label {
        margin-bottom: 0;
    }

    div.dataTables_info {
        padding-top: 0 !important;
        vertical-align: middle;
    }

    div.dt-buttons {
        display: inline-block;
        vertical-align: middle;
    }
</style>
@endassets

@push('scripts')
    <script src="{{ Vite::asset('resources/assets/admin/libs/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/admin/libs/datatables.net/1.11.5/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/admin/libs/datatables.net/1.11.5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/admin/libs/datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/admin/libs/datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/admin/libs/datatables.net/buttons/2.2.2/js/buttons.print.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/admin/libs/datatables.net/buttons/2.2.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/admin/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/admin/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
    <script src="{{ Vite::asset('resources/assets/admin/libs/jszip/3.1.3/jszip.min.js') }}"></script>

    <script>
        (function () {
            let initializedTables = {};

            function initTable(selector, opts = {}) {
                if (typeof $ === 'undefined' || typeof $.fn === 'undefined') {
                    console.warn('jQuery not loaded yet, skipping DataTable initialization');
                    return null;
                }

                const el = $(selector);
                if (!el.length) return null;

                if (typeof $.fn.DataTable === 'undefined') {
                    console.warn('DataTables plugin not loaded yet');
                    return null;
                }

                if ($.fn.DataTable.isDataTable(selector)) {
                    $(selector).DataTable().destroy();
                }

                const defaultOptions = {
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                    pageLength: 10,
                    searching: true,
                    order: [],
                    language: {
                        info: "Displaying items _START_ to _END_ out of _TOTAL_ total courses.",
                        infoEmpty: "No courses found to display",
                        lengthMenu: "Show _MENU_ courses",
                        search: "Search courses:",
                    },
                };

                const config = Object.assign({}, defaultOptions, opts);
                const table = el.DataTable(config);
                initializedTables[selector] = table;
                return table;
            }

            function initializeDataTables() {
                setTimeout(() => {
                    const tableDefinitions = [
                        {
                            selector: '#activeCourseTable',
                            opts: {
                                dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6 d-flex align-items-center"li><"col-sm-12 col-md-6"p>>',
                                fixedHeader: true,
                                scrollX: true,
                                scrollY: 500,
                            }
                        },
                        {
                            selector: '#pendingCourseTable',
                            opts: {
                                scrollY: 500
                            }
                        },
                        {
                            selector: '#suspendedCourseTable',
                            opts: {
                                scrollY: 500
                            }
                        }
                    ];

                    tableDefinitions.forEach(({selector, opts}) => initTable(selector, opts));
                }, 100);
            }
            document.addEventListener('DOMContentLoaded', initializeDataTables);

            document.addEventListener('livewire:navigated', initializeDataTables);

            document.addEventListener('livewire:initialized', () => {
                Livewire.on('course-change', () => {
                    console.log('Course changed, reinitializing tables...');
                    initializeDataTables();
                });
            });
        })();
    </script>

    <script>
        function showSuspendedConfirm(courseId) {
            swalConfirm(
                'Are you sure?',
                'You are about to suspend this course.',
                () => {
                    @this.
                    suspend(courseId);
                },
                'Yes, suspend it!'
            );
        }

        function showApprovedConfirm(courseId) {
            swalConfirm(
                'Are you sure?',
                'This action will approve and publish the course.',
                () => {
                    @this.
                    approveCourse(courseId);
                },
                'Yes, approve it!'
            );
        }

        function showRejectedConfirm(courseId) {
            swalConfirm(
                'Are you sure?',
                'This action will reject the course submission.',
                () => {
                    @this.
                    rejectCourse(courseId);
                },
                'Yes, reject it!'
            );
        }

        function showRestoredConfirm(courseId) {
            swalConfirm(
                'Are you sure?',
                'You are about to re-activate this course.',
                () => {
                    @this.
                    restore(courseId);
                },
                'Yes, re-activate it!'
            );
        }
    </script>
@endpush
