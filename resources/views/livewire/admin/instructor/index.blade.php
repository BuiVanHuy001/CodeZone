<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Active Instructor</h5>
            </div>
            <div class="card-body">
                <table id="activeInstructorTable" class="table nowrap align-middle" style="width:100%">
                    <thead>
                    <tr>
                        <th data-ordering="false">Instructor ID</th>
                        <th>Full Name</th>
                        <th>Average Rating</th>
                        <th>Courses Offered</th>
                        <th>Students Enrolled</th>
                        <th>Account Status</th>
                        <th>Total Earnings</th>
                        <th>Joined On</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($instructors['active'] as $instructor)
                        <tr>
                            <td>{{ $instructor->id }}</td>
                            <td>
                                <div class="d-flex align-items-center fw-medium">
                                    <a href="{{ $instructor['profileUrl'] }}" class="currency_name" target="_blank">
                                        <img src="{{ $instructor->avatar }}" alt="Instructor profile" class="rounded-circle avatar-xxs me-2">
                                        {{ $instructor->name }}
                                    </a>
                                </div>
                            </td>
                            <td>{{ $instructor->ratingText }}</td>
                            <td>{{ $instructor->courseCountText }}</td>
                            <td>{{ $instructor->studentCountText }}</td>
                            <td>
                                <span class="badge {{ $instructor->status['class'] }}">{{ $instructor->status['label'] }}</span>
                            </td>
                            <td>{{ $instructor->totalEarningsText }}</td>
                            <td>{{ $instructor->joinedDateText }}</td>
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

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Pending review Instructor</h5>
            </div>
            <div class="card-body">
                <table id="pendingInstructorTable" class="table nowrap align-middle" style="width:100%">
                    <thead>
                    <tr>
                        <th data-ordering="false">Instructor ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Joined On</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($instructors['pending'] as $instructor)
                        <tr>
                            <td>{{ $instructor->id }}</td>
                            <td>{{ $instructor->name }}</td>
                            <td><a href="mailto:{{ $instructor->email }}">{{ $instructor->email }}</a></td>
                            <td>
                                <span class="badge {{ $instructor->status['class'] }}">{{ $instructor->status['label'] }}</span>
                            </td>
                            <td>{{ $instructor->joinedDateText }}</td>
                            <td>
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill align-middle"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item">
                                                <button class="btn btn-xl">
                                                    <span class="badge bg-success-subtle">
                                                        <i class="ri-checkbox-circle-line align-bottom me-2 text-success"></i>Approve
                                                    </span>
                                                </button>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item">
                                                <button class="btn btn-xl">
                                                    <span class="badge bg-danger-subtle text-danger">
                                                        <i class="ri-close-circle-fill align-bottom me-2 text-danger"></i>Reject
                                                    </span>
                                                </button>
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
        let activeInstructorTableInstance = null;
        let pendingInstructorTableInstance = null;

        function initDataTables() {
            // Destroy existing instances if they exist
            if (activeInstructorTableInstance) {
                activeInstructorTableInstance.destroy();
                activeInstructorTableInstance = null;
            }
            if (pendingInstructorTableInstance) {
                pendingInstructorTableInstance.destroy();
                pendingInstructorTableInstance = null;
            }

            var activeInstructorTable = $('#activeInstructorTable');
            if (activeInstructorTable.length) {
                activeInstructorTableInstance = activeInstructorTable.DataTable({
                    dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6 d-flex align-items-center"li><"col-sm-12 col-md-6"p>>',
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                    pageLength: 10,
                    searching: true,
                    fixedHeader: true,
                    scrollX: true,
                    scrollY: 500,
                    language: {
                        info: "Showing _START_ to _END_ of _TOTAL_ instructors",
                        infoEmpty: "No instructors to display",
                        lengthMenu: "Show _MENU_ instructors",
                        search: "Search instructors:",
                        zeroRecords: "No matching instructors found",
                        paginate: {previous: 'Prev', next: 'Next'}
                    },
                });
            }

            var pendingInstructorTable = $('#pendingInstructorTable');
            if (pendingInstructorTable.length) {
                pendingInstructorTableInstance = pendingInstructorTable.DataTable({
                    dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6 d-flex align-items-center"li><"col-sm-12 col-md-6"p>>',
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                    pageLength: 10,
                    searching: true,
                    scrollY: 500,
                    language: {
                        info: "Showing _START_ to _END_ of _TOTAL_ instructors",
                        infoEmpty: "No pending instructors to display",
                        lengthMenu: "Show _MENU_ instructors",
                        search: "Search instructors:",
                        zeroRecords: "No matching instructors found",
                        paginate: {previous: 'Prev', next: 'Next'}
                    },
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            initDataTables();
        });

        // Reinitialize DataTables when navigating with Livewire
        document.addEventListener('livewire:navigated', function () {
            initDataTables();
        });

        // Cleanup DataTables before navigating away
        document.addEventListener('livewire:navigating', function () {
            if (activeInstructorTableInstance) {
                activeInstructorTableInstance.destroy();
                activeInstructorTableInstance = null;
            }
            if (pendingInstructorTableInstance) {
                pendingInstructorTableInstance.destroy();
                pendingInstructorTableInstance = null;
            }
        });
    </script>
@endpush
