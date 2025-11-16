<div class="row">
    <div wire:loading wire:target="approve, reject, suspend">
        <x-client.share-ui.loading-effect/>
    </div>

    <x-admin.shared-ui.data-table-card tableTitle="Active Courses" tableId="activeCourseTable">
        <x-slot:tableHeader>
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
        </x-slot>

        <x-slot:tableBody>
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
        </x-slot>
    </x-admin.shared-ui.data-table-card>

    <x-admin.shared-ui.data-table-card tableTitle="Pending Courses" tableId="pendingCourseTable">
        <x-slot:tableHeader>
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
        </x-slot>

        <x-slot:tableBody>
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
                                    <button onclick="showRejectedConfirm('{{ $course->id }}')" class="btn btn-xl dropdown-item text-danger">
                                        <i class="ri-close-circle-fill align-bottom me-2"></i>Reject
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.shared-ui.data-table-card>

    <x-admin.shared-ui.data-table-card tableTitle="Suspended Courses" tableId="suspendedCourseTable">
        <x-slot:tableHeader>
            <tr>
                <th data-ordering="false">ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Author</th>
                <th>Duration</th>
                <th>Suspended At</th>
                <th>Action</th>
            </tr>
        </x-slot>

        <x-slot:tableBody>
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
                    <td>{{ $course->updatedAtText }}</td>
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
        </x-slot>
    </x-admin.shared-ui.data-table-card>
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
        function initializeCourseDataTables() {
            const tableDefinitions = [
                {
                    selector: '#activeCourseTable',
                    opts: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: '<i class="ri-file-excel-2-line"></i> Excel',
                                titleAttr: 'Export to Excel',
                                filename: 'active-courses-export-' + new Date().toISOString().split('T')[0],
                                className: 'btn btn-outline-secondary',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                },
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="ri-file-pdf-line"></i> PDF',
                                titleAttr: 'Export to PDF',
                                filename: 'active-courses-export-' + new Date().toISOString().split('T')[0],
                                className: 'btn btn-outline-secondary',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                },
                            },
                            {
                                extend: 'print',
                                text: '<i class="ri-printer-line"></i> Print',
                                titleAttr: 'Print Table',
                                className: 'btn btn-outline-secondary',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                },
                            }
                        ]
                    },
                },
                {
                    selector: '#pendingCourseTable',
                    opts: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: '<i class="ri-file-excel-2-line"></i> Excel',
                                titleAttr: 'Export to Excel',
                                className: 'btn btn-outline-secondary',
                                filename: 'pending-courses-export-' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                },
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="ri-file-pdf-line"></i> PDF',
                                titleAttr: 'Export to PDF',
                                filename: 'pending-courses-export-' + new Date().toISOString().split('T')[0],
                                className: 'btn btn-outline-secondary',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                },
                            },
                            {
                                extend: 'print',
                                text: '<i class="ri-printer-line"></i> Print',
                                titleAttr: 'Print Table',
                                className: 'btn btn-outline-secondary',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                },
                            }
                        ]
                    },
                },
                {
                    selector: '#suspendedCourseTable',
                    opts: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: '<i class="ri-file-excel-2-line"></i> Excel',
                                titleAttr: 'Export to Excel',
                                className: 'btn btn-outline-secondary',
                                filename: 'suspended-courses-export-' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                },
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="ri-file-pdf-line"></i> PDF',
                                titleAttr: 'Export to PDF',
                                filename: 'suspended-courses-export-' + new Date().toISOString().split('T')[0],
                                className: 'btn btn-outline-secondary',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                },
                            },
                            {
                                extend: 'print',
                                text: '<i class="ri-printer-line"></i> Print',
                                titleAttr: 'Print Table',
                                className: 'btn btn-outline-secondary',
                                exportOptions: {
                                    columns: ':not(:last-child)',
                                },
                            }
                        ]
                    },
                }
            ];

            if (window.AppDataTableHelper && window.AppDataTableHelper.initializeDataTables) {
                window.AppDataTableHelper.initializeDataTables(tableDefinitions);
            } else {
                console.error('DataTable initializer (AppDataTableHelper) not found.');
            }
        }

        document.addEventListener('DOMContentLoaded', initializeCourseDataTables);
        document.addEventListener('livewire:navigated', initializeCourseDataTables);
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('course-change', () => {
                initializeCourseDataTables();
            });
        });
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
                    approve(courseId);
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
                    reject(courseId);
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
