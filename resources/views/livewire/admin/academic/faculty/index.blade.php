<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Faculty</h4>
        </div>
    </div>

    <div class="col-12">
        <button type="button"
                class="btn btn-primary btn-label waves-effect waves-light mb-3 float-end"
                data-bs-toggle="modal"
                data-bs-target="#add-faculty-modal"
        >
            <i class="ri-upload-cloud-2-line label-icon align-middle fs-16 me-2"></i> Add Faculty
        </button>
    </div>

    <x-admin.shared-ui.data-table-card tableTitle="Faculties" tableId="internalStudentsTable">
        <x-slot:tableHeader>
            <th>Name</th>
            <th>Code</th>
            <th>Majors amount</th>
            <th>Students amount</th>
            <th>Created at</th>
            <th>Action</th>
        </x-slot:tableHeader>

        <x-slot:tableBody>
            @foreach($internalStudentTable as $index => $student)
                <tr>
                    <td>{{ $student->studentCodeText }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->dobText }}</td>
                    <td>{{ $student->genderText }}</td>
                    <td>
                        <p class="fw-bold cursor-pointer text-primary">
                            <span data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  data-bs-title="{{ $student->facultyNameText }}"
                            >{{ $student->facultyCodeText }}</span> -
                            <span data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  data-bs-title="Ngành {{ $student->majorNameText }}"
                            >{{ $student->majorCodeText }}</span>
                        </p>
                    </td>
                    <td>
                        <p class="fw-bold cursor-pointer text-primary">
                            <span data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  data-bs-title="{{ $student->classRoomNameText }}"
                            >{{ $student->classRoomCodeText }}</span>
                        </p>
                    </td>
                    <td>{{ $student->enrolledCountText }}</td>
                    <td>{{ $student->enrollmentYearText }}</td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button onclick="" class="btn btn-xl text-secondary dropdown-item">
                                        <i class="ri-checkbox-circle-line align-bottom me-2"></i>Show Details
                                    </button>
                                </li>
                                <li>
                                    <button onclick="" class="btn btn-xl text-danger dropdown-item">
                                        <i class="ri-close-circle-fill align-bottom me-2"></i>Banned
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:tableBody>
    </x-admin.shared-ui.data-table-card>
</div>
