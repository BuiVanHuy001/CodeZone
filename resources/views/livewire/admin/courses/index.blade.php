<div class="row">
    <div wire:loading wire:target="approveCourse, rejectCourse">
        <x-client.share-ui.loading-effect/>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Active Courses</h5>
            </div>
            <div class="card-body">
                <div wire:ignore.self>
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
                            <td><a href="{{ $course->detailsPageUrl }}" class="fw-bold">{{ $course->title }}</a></td>
                            <td>{{ $course->categoryName }}</td>
                            <td>{{ $course->priceFormatted }}</td>
                            <td>
                                <div class="d-flex align-items-center fw-medium">
                                    <a href="{{ $course->authorInfo['profileUrl'] }}" class="currency_name">
                                        <img src="{{ $course->authorInfo['avatar'] }}" alt="Instructor profile" class="rounded-circle avatar-xxs me-2">
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
                                            <a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                View</a></li>
                                        <li>
                                            <a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit</a></li>
                                        <li>
                                            <a class="dropdown-item remove-item-btn">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                            </a>
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
                <div wire:ignore.self>
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
                            <td><a href="{{ $course->detailsPageUrl }}" class="fw-bold">{{ $course->title }}</a></td>
                            <td>{{ $course->categoryName }}</td>
                            <td>{{ $course->priceFormatted }}</td>
                            <td>
                                <div class="d-flex align-items-center fw-medium">
                                    <a href="{{ $course->authorInfo['profileUrl'] }}" class="currency_name">
                                        <img src="{{ $course->authorInfo['avatar'] }}" alt="Instructor profile" class="rounded-circle avatar-xxs me-2">
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
                                            <button wire:click="approve('{{ $course->id }}')"
                                                    class="btn btn-xl dropdown-item">
                                                <span class="badge bg-success-subtle">
                                                    <i class="ri-checkbox-circle-line align-bottom me-2 text-success"></i>Approve
                                                </span>
                                            </button>
                                        </li>
                                        <li>
                                            <button wire:click="reject('{{ $course->id }}')" class="btn btn-xl dropdown-item">
                                                <span class="badge bg-danger-subtle text-danger">
                                                    <i class="ri-close-circle-fill align-bottom me-2 text-danger"></i>Reject
                                                </span>
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
<link
    href="{{ Vite::asset('resources/assets/admin/libs/datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}"
    rel="stylesheet"
    type="text/css"
/>
<link
    href="{{ Vite::asset('resources/assets/admin/libs/datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css') }}"
    rel="stylesheet"
    type="text/css"
/>
<link
    href="{{ Vite::asset('resources/assets/admin/libs/datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css') }}"
    rel="stylesheet"
    type="text/css"
/>
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
        let initializedTables = {};

        function initTable(selector, opts = {}) {
            const el = $(selector);
            if (!el.length) return null;

            // destroy previous instance if exists
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
                }
            ];

            tableDefinitions.forEach(({selector, opts}) => initTable(selector, opts));
        }

        document.addEventListener('DOMContentLoaded', initializeDataTables);

        document.addEventListener('livewire:initialized', function () {
            window.Livewire.on('course-approved', () => {
                setTimeout(initializeDataTables, 200);
            });

            window.Livewire.hook('morph.updated', ({el, component}) => {
                setTimeout(initializeDataTables, 200);
            });
        });
    </script>
@endpush
