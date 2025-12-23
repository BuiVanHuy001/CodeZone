<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
            <h4 class="mb-sm-0">Quản lý Khoa</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">Khoa</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5">
            <livewire:admin.academic.components.faculty.faculty-list/>
        </div>

        <div class="col-xl-7">
            <livewire:admin.academic.components.major.major-list/>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <livewire:admin.academic.components.classroom.classroom-list/>
        </div>
    </div>

    <livewire:admin.academic.components.faculty.create-faculty/>
    <livewire:admin.academic.components.faculty.edit-faculty/>
    <livewire:admin.academic.components.faculty.faculty-detail/>
    <livewire:admin.academic.components.faculty.delete-faculty/>

    <livewire:admin.academic.components.major.create-major/>
    <livewire:admin.academic.components.major.edit-major/>
    <livewire:admin.academic.components.major.major-detail/>
    <livewire:admin.academic.components.major.delete-major/>

    <livewire:admin.academic.components.classroom.create-classroom/>
    <livewire:admin.academic.components.classroom.classroom-detail/>
    <livewire:admin.academic.components.classroom.edit-classroom/>
    <livewire:admin.academic.components.classroom.delete-classroom/>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('swal-confirm-delete-empty', (event) => {
                const id = Array.isArray(event) ? event[0].id : event.id;

                Swal.fire({
                    title: 'Xóa Khoa này?',
                    text: "Khoa này chưa có chuyên ngành nào. Bạn có chắc muốn xóa?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Xóa luôn!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete-empty-faculty-confirmed', {id: id});
                    }
                });
            });

            Livewire.on('swal-confirm-delete-empty-major', (event) => {
                const id = Array.isArray(event) ? event[0].id : event.id;

                Swal.fire({
                    title: 'Xóa Ngành này?',
                    text: "Chuyên ngành này chưa có dữ liệu (Lớp, GV, SV). Xóa ngay?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Xóa luôn!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete-empty-major-confirmed', {id: id});
                    }
                });
            });

            Livewire.on('swal-confirm-delete-empty-classroom', (event) => {
                let id = null;
                if (Array.isArray(event) && event[0]?.id) id = event[0].id;
                else if (event && event.id) id = event.id;
                else id = event;

                Swal.fire({
                    title: 'Xóa Lớp này?',
                    text: "Lớp học này chưa có sinh viên. Xóa ngay?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Xóa luôn!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete-empty-classroom-confirmed', {id: id});
                    }
                });
            });
        });
    </script>
@endpush
