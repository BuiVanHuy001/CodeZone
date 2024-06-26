@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row tab-content">
                    <div id="list-view" class="tab-pane fade active show col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Danh sách giảng viên  </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <form method="get" action="{{ route('admin.instructor.index') }}">
                                        <div class="d-flex">
                                            <select name="status" class="w-25" aria-label="Default select example">
                                                <option selected>Lọc theo status</option>
                                                <option {{ $status == 'pending' ? 'selected' : '' }} value="pending">Chờ xác thực</option>
                                                <option {{ $status == 'active' ? 'selected' : '' }} value="active">Xác thực</option>
                                                <option {{ $status == 'suspended' ? 'selected' : '' }} value="suspended">Từ chối</option>
                                            </select>
                                            <button style="width: 15%" class="btn btn-primary p-0">Lọc</button>
                                        </div>
                                    </form>
                                    <table id="dataTable" class="display text-center" style="min-width: 1200px">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên</th>
                                            <th>Avatar</th>
                                            <th>Giới tính</th>
                                            <th>Khóa học</th>
                                            <th>Số điện thoai</th>
                                            <th>Email</th>
                                            <th>Trạng thái</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($instructors->sortByDesc('created_at') as $instructor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><a href="{{ route('admin.instructor.show', ['instructor' => $instructor]) }}">{{ $instructor->user->name }}</a></td>
                                                <td><img class="rounded-circle" width="35" src="{{ $instructor->user->avatarPath() ?? asset('client_assets/images/avatar/default-avatar.png') }}" alt=""></td>
                                                <td>{{ $instructor->gender == 0 ? 'Nữ' : 'Nam' }}</td>
                                                <td>{{ $instructor->courses->where('status', 'approved')->count() }}</td>
                                                <td>{{ $instructor->phone_number }}</td>
                                                <td><a href="javascript:void(0);"><strong>{{ $instructor->user->email }}</strong></a></td>
                                                <td>
                                                    <select data-url="{{ route('admin.update-status', [$instructor->id]) }}" class="form-select p-0 statusSelect" name="status" aria-label="Status select">
                                                        <option {{ $instructor->user->status === 'pending' ? 'selected' : '' }} value="pending">Chờ phê duyệt</option>
                                                        <option {{ $instructor->user->status === 'active' ? 'selected' : '' }} value="active">Hoạt động</option>
                                                        <option {{ $instructor->user->status === 'suspended' ? 'selected' : '' }} value="suspended">Khóa</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <span class="flaticon-more-button-of-three-dots"></span>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                            <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                            <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                        </div>
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
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.statusSelect').change(function() {
            let url = $(this).data('url');
            let status = $(this).val();
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                }
            });
        });
        let table = new DataTable('#dataTable', {
            responsive: true
        });
    </script>
@endsection
