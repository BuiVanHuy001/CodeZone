@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Danh sách học viên</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="display text-center" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên</th>
                                            <th>Avatar</th>
                                            <th>Giới tính</th>
                                            <th>Khóa học</th>
                                            <td>Trạng thái</td>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($students->sortBy('created_at') as $student)
                                            <tr class="tr-{{ $student->user->slug }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('admin.student.show', [$student->user->slug]) }}">{{ $student->user->name }}</a>
                                                </td>
                                                <td><img class="rounded-circle" width="35"
                                                         src="{{ $student->user->avatarPath() }}" alt=""></td>
                                                <td>{{ $student->user->gender === 'male' ? 'Nam' : 'Nữ' }}</td>
                                                <td>{{ number_format($student->courses->where('status', 'paid')->count()) }}</td>
                                                <td><span
                                                        class="badge badge-rounded {{ $student->getBadgeColor() }}">{{ $student->getStatusName() }}</span>
                                                </td>
                                                <td>{{ $student->user->email }}</td>
                                                <td data-url="{{ route('admin.update-student-status', encrypt($student->id)) }}">
                                                    <button data-type="suspended" type="button"
                                                            {{ $student->user->status === 'suspended' ? 'disabled' : '' }}
                                                            class="btn btn-dark text-light" data-toggle="tooltip"
                                                            data-placement="top"
                                                            title="Khóa"><i
                                                            class="fa-solid fa-lock"></i>
                                                    </button>
                                                    <button data-type="unblock" type="button"
                                                            {{ $student->user->status === 'active' ? 'disabled' : '' }}
                                                            class="btn btn-success text-light" data-toggle="tooltip"
                                                            data-placement="top" title="Mở khóa"><i
                                                            class="fa-solid fa-unlock"></i>
                                                    </button>
                                                    <button data-type="delete" type="button" class="btn btn-danger"
                                                            data-toggle="tooltip"
                                                            data-placement="top" title="Xóa">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
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
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            let table = new DataTable('#dataTable', {
                layout: {
                    topStart: {
                        buttons: ['pageLength', {
                            extend: 'spacer',
                            style: 'bar',
                            text: 'Xuất file:'
                        }, 'excel', 'pdf', 'print'],
                    }
                },
            });

            $(document).on('click', '.btn', function () {
                let button = $(this);
                let url = button.parent().data('url');
                let type = button.data('type');
                let title = button.prop('title');
                Swal.fire({
                    title: `Bạn có chắc ${title.toLowerCase()} không?`,
                    text: "Bạn sẽ không thể hoàn tác lại được!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log(type);
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: type
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    button.closest('tr').find('span.badge').removeClass().addClass('badge badge-rounded ' + response.badgeColor).text(response.statusName);
                                    if (type === 'suspended') {
                                        button.closest('td').find('button[data-type="suspended"]').prop('disabled', true);
                                        button.closest('td').find('button[data-type="unblock"]').prop('disabled', false);
                                    } else if (type === 'unblock') {
                                        button.closest('td').find('button[data-type="unblock"]').prop('disabled', true);
                                        button.closest('td').find('button[data-type="suspended"]').prop('disabled', false);
                                    } else {
                                        button.closest('tr').remove()
                                    }
                                }
                                Swal.fire({
                                    position: "center",
                                    icon: response.status,
                                    title: response.message,
                                    showConfirmButton: true
                                });
                            },
                            error: function (response) {
                                Swal.fire({
                                    title: response.responseJSON.message,
                                    icon: "warning"
                                });
                            }
                        });
                    }
                });
            })
        });

    </script>
@endsection
