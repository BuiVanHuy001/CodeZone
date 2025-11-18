<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Instructor</h4>
        </div>
    </div>

    <div wire:loading wire:target="approve, reject, suspend, restore">
        <x-client.share-ui.loading-effect/>
    </div>

    <div class="col-xl-12">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div class="row row-cols-md-3 row-cols-1">
                    <x-admin.shared-ui.counter-card
                        title="Active Instructors"
                        count="197"
                        icon="ri-checkbox-circle-line"
                        color="success"
                        :border="true"
                    />

                    <x-admin.shared-ui.counter-card
                        title="Suspended Instructors"
                        count="489"
                        icon="ri-pause-circle-line"
                        color="info"
                        :border="true"
                    />

                    <x-admin.shared-ui.counter-card
                        title="Pending Review Instructors"
                        :count="count($instructors['pending'])"
                        icon="ri-trophy-line"
                        color="warning"
                        :border="true"
                    />
                </div>
            </div>
        </div>
        <button type="button"
                class="btn btn-success btn-label waves-effect waves-light mb-3 float-end"
                data-bs-toggle="modal"
                data-bs-target="#create-instructor-modal"
        >
            <i class="ri-user-add-line label-icon align-middle fs-16 me-2"></i> Add Instructor
        </button>
    </div>

    <x-admin.shared-ui.data-table-card tableTitle="Active Instructor" tableId="activeInstructorTable">
        <x-slot:tableHeader>
            <th>Full Name</th>
            <th>Average Rating</th>
            <th>Major (Faculty)</th>
            <th>Courses Offered</th>
            <th>Students Enrolled</th>
            <th>Total Earnings</th>
            <th>Joined On</th>
            <th>Actions</th>
        </x-slot:tableHeader>

        <x-slot:tableBody>
            @foreach($instructors['active'] as $instructor)
                <tr>
                    <td>
                        <div class="d-flex align-items-center fw-medium">
                            <a href="{{ $instructor['profileUrl'] }}" class="currency_name" target="_blank">
                                <img src="{{ $instructor->avatar }}" alt="Instructor profile" loading="lazy" class="rounded-circle avatar-xxs me-2">
                                {{ $instructor->name }}
                            </a>
                        </div>
                    </td>
                    <td>{{ $instructor->ratingText }}</td>
                    <td>{{ $instructor->majorText }}</td>
                    <td>{{ $instructor->courseCountText }}</td>
                    <td>{{ $instructor->studentCountText }}</td>
                    <td>{{ $instructor->totalEarningsText }}</td>
                    <td>{{ $instructor->createdAtText }}</td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="{{ $instructor->profileUrl }}" class="btn btn-xl dropdown-item text-secondary">
                                        <i class="ri-eye-line align-bottom me-2"></i> View Profile
                                    </a>
                                </li>
                                <li>
                                    <button onclick="showSuspendedConfirm(@this, '{{ $instructor->id }}', 'Confirm Suspension', 'Are you sure you want to suspend instructor {{ $instructor->name }}?')" class="btn btn-xl dropdown-item text-warning">
                                        <i class="ri-pause-circle-line align-bottom me-2"></i> Suspend
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:tableBody>
    </x-admin.shared-ui.data-table-card>

    <x-admin.shared-ui.data-table-card tableTitle="Suspended Instructor" tableId="suspendedInstructorTable">
        <x-slot:tableHeader>
            <th>Full Name</th>
            <th>Email</th>
            <th>Major (Faculty)</th>
            <th>Pended At</th>
            <th>Actions</th>
        </x-slot:tableHeader>

        <x-slot:tableBody>
            @foreach($instructors['suspended'] as $instructor)
                <tr>
                    <td>{{ $instructor->name }}</td>
                    <td><a href="mailto:{{ $instructor->email }}">{{ $instructor->email }}</a></td>
                    <td>{{ $instructor->majorText }}</td>
                    <td>{{ $instructor->updatedAtText }}</td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button onclick="showRestoredConfirm(@this, '{{ $instructor->id }}', 'Confirm Re-activation', 'Do you want to re-activate instructor {{ $instructor->name }}?')" class="btn btn-xl text-success dropdown-item">
                                        <i class="ri-checkbox-circle-line align-bottom me-2"></i> Re-active
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:tableBody>
    </x-admin.shared-ui.data-table-card>

    <x-admin.shared-ui.data-table-card tableTitle="Pending review Instructor" tableId="pendingInstructorTable">
        <x-slot:tableHeader>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Suspended At</th>
                <th>Actions</th>
            </tr>
        </x-slot:tableHeader>

        <x-slot:tableBody>
            @foreach($instructors['pending'] as $instructor)
                <tr>
                    <td>{{ $instructor->name }}</td>
                    <td><a href="mailto:{{ $instructor->email }}">{{ $instructor->email }}</a></td>
                    <td>{{ $instructor->updatedAtText }}</td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button onclick="showApprovedConfirm(@this, '{{ $instructor->id }}', 'Confirm Approval', 'Do you want to approve instructor {{ $instructor->name }}?')" class="btn btn-xl text-success dropdown-item">
                                        <i class="ri-checkbox-circle-line align-bottom me-2"></i> Approve
                                    </button>
                                </li>
                                <li>
                                    <button onclick="showRejectedConfirm(@this, '{{ $instructor->id }}', 'Confirm Rejection', 'Do you want to reject instructor {{ $instructor->name }}?')" class="btn btn-xl text-danger dropdown-item">
                                        <i class="ri-close-circle-fill align-bottom me-2"></i> Reject
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:tableBody>
    </x-admin.shared-ui.data-table-card>

    <livewire:admin.instructor.components.create-modal/>
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
        function initializeInstructorDataTables() {
            const tableDefinitions = [
                {
                    selector: '#activeInstructorTable',
                    opts: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: '<i class="ri-file-excel-2-fill me-1 align-bottom"></i>Export to Excel',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Excel',
                                filename: 'Active_Instructors_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="ri-file-pdf-fill me-1 align-bottom"></i>Export to PDF',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'PDF',
                                filename: 'Active_Instructors_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="ri-printer-fill me-1 align-bottom"></i>Print',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Print',
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            }
                        ]
                    }
                },
                {
                    selector: '#pendingInstructorTable',
                    opts: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: '<i class="ri-file-excel-2-fill me-1 align-bottom"></i>Export to Excel',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Excel',
                                filename: 'Pending_Instructors_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="ri-file-pdf-fill me-1 align-bottom"></i>Export to PDF',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'PDF',
                                filename: 'Pending_Instructors_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="ri-printer-fill me-1 align-bottom"></i>Print',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Print',
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            }
                        ]
                    }
                },
                {
                    selector: '#suspendedInstructorTable',
                    opts: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: '<i class="ri-file-excel-2-fill me-1 align-bottom"></i>Export to Excel',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Excel',
                                filename: 'Suspended_Instructors_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="ri-file-pdf-fill me-1 align-bottom"></i>Export to PDF',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'PDF',
                                filename: 'Suspended_Instructors_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="ri-printer-fill me-1 align-bottom"></i>Print',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Print',
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            }
                        ]
                    }
                }
            ];
            if (window.AppDataTableHelper && window.AppDataTableHelper.initializeDataTables) {
                window.AppDataTableHelper.initializeDataTables(tableDefinitions);
            } else {
                console.error('DataTable initializer (AppDataTableHelper) not found.');
            }
        }

        function setupPageEventListeners() {
            if ($.fn.DataTable.isDataTable('#activeInstructorTable')) {
                $('#activeInstructorTable').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#pendingInstructorTable')) {
                $('#pendingInstructorTable').DataTable().destroy();
            }
            if ($.fn.DataTable.isDataTable('#suspendedInstructorTable')) {
                $('#suspendedInstructorTable').DataTable().destroy();
            }
            initializeInstructorDataTables();
        }

        document.addEventListener('DOMContentLoaded', setupPageEventListeners);
        document.addEventListener('livewire:navigated', setupPageEventListeners);

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('instructor-updated', () => {
                setupPageEventListeners();
            });
        });
    </script>
@endpush
