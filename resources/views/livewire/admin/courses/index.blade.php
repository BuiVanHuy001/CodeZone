<div class="row">
    <div wire:loading wire:target="approve, reject, suspend, restore" class="loading-overlay">
        <x-client.share-ui.loading-effect/>
    </div>
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent mb-3">
            <h4 class="mb-sm-0 text-uppercase fw-bold text-primary">Quản lý Khóa học</h4>
            <div class="page-title-right">
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0 position-relative">
            <div class="card-header border-bottom-0 bg-light-subtle pt-3 px-3 pb-0">
                <ul class="nav nav-tabs nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $currentTab === 'published' ? 'active' : '' }} cursor-pointer fw-medium py-3 px-4"
                           wire:click="setTab('published')">
                            <i class="ri-checkbox-circle-fill me-1 align-bottom {{ $currentTab === 'published' ? 'text-success' : 'text-muted' }}"></i>
                            Đang hoạt động
                            <span class="badge bg-success-subtle text-success ms-2 rounded-pill">{{ $counts['published'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $currentTab === 'pending' ? 'active' : '' }} cursor-pointer fw-medium py-3 px-4"
                           wire:click="setTab('pending')">
                            <i class="ri-time-fill me-1 align-bottom {{ $currentTab === 'pending' ? 'text-warning' : 'text-muted' }}"></i>
                            Chờ duyệt
                            @if($counts['pending'] > 0)
                                <span class="badge bg-danger ms-2 rounded-pill">{{ $counts['pending'] }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $currentTab === 'suspended' ? 'active' : '' }} cursor-pointer fw-medium py-3 px-4"
                           wire:click="setTab('suspended')">
                            <i class="ri-prohibited-fill me-1 align-bottom {{ $currentTab === 'suspended' ? 'text-danger' : 'text-muted' }}"></i>
                            Đã khóa
                            <span class="badge bg-secondary-subtle text-secondary ms-2 rounded-pill">{{ $counts['suspended'] }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="p-3 border-bottom bg-light bg-opacity-10">
                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <div class="search-box">
                                <input type="text" class="form-control search bg-light border-light"
                                       placeholder="Tìm khóa học, giảng viên..."
                                       wire:model.live.debounce.300ms="search"
                                       wire:key="search-box-{{ $currentTab }}">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-light text-muted"><i class="ri-filter-3-line"></i></span>
                                <select class="form-select bg-light border-light" wire:model.live="selectedCategory">
                                    <option value="">Tất cả Danh mục</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 ms-auto">
                            <select class="form-select bg-light border-light" wire:model.live="sortDirection">
                                <option value="desc">Mới nhất</option>
                                <option value="asc">Cũ nhất</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-nowrap align-middle mb-0">
                        <thead class="table-light text-muted">
                        <tr>
                            <th scope="col" style="width: 50px;" class="text-center">#</th>
                            <th scope="col" class="ps-4" style="width: 35%;">Khóa học</th>
                            <th scope="col" style="width: 20%;">Giảng viên</th>
                            <th scope="col" style="width: 30%;">Thông tin & Thống kê</th>
                            <th scope="col" class="text-end pe-4">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($courses as $index => $course)
                            <tr wire:key="course-{{ $course['id'] }}" class="group">
                                <td class="fw-medium text-center text-muted">
                                    {{ $courses->firstItem() + $index }}
                                </td>

                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3 position-relative">
                                            <img src="{{ $course['thumbnail'] }}" alt="" class="avatar-md rounded-3 object-fit-cover border shadow-sm">
                                        </div>
                                        <div class="flex-grow-1" style="max-width: 350px;">
                                            <h6 class="fs-14 mb-1">
                                                <a href="{{ $course['detailUrl'] }}" target="_blank" class="text-dark link-primary text-truncate d-block fw-semibold" title="{{ $course['name'] }}">
                                                    {{ $course['name'] }}
                                                </a>
                                            </h6>
                                            <div class="d-flex align-items-center gap-2 text-muted fs-12">
                                                    <span class="badge bg-light text-muted border fw-normal text-truncate" style="max-width: 150px;">
                                                        {{ $course['categoryName'] }}
                                                    </span>
                                                <span class="text-success fw-bold">{{ $course['priceFormatted'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <a href="{{ $course['authorProfileUrl'] }}" target="_blank" class="d-flex align-items-center text-reset group-hover:text-primary">
                                        <img src="{{ $course['authorAvatar'] ?? asset('images/default-avatar.png') }}" alt="" class="avatar-xs rounded-circle me-2 border object-fit-cover">
                                        <span class="text-dark fw-medium">{{ $course['authorName'] }}</span>
                                    </a>
                                </td>

                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        <div>
                                            <span class="badge bg-{{ $course['levelClass'] }}-subtle text-{{ $course['levelClass'] }} border border-{{ $course['levelClass'] }}-subtle px-2 rounded-1 fw-normal">
                                                {{ $course['levelLabel'] }}
                                            </span>
                                            @if($currentTab === 'published' || $currentTab === 'suspended')
                                                <span class="badge bg-info-subtle text-info border border-info-subtle fw-normal" data-bs-toggle="tooltip" title="Số lượng học viên">
                                                    <i class="ri-group-line align-middle me-1"></i> {{ $course['enrollmentCount'] }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center gap-1">
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fw-normal" data-bs-toggle="tooltip" title="Thời lượng">
                                                <i class="ri-time-line align-middle me-1"></i> {{ $course['durationFormatted'] ?: '--' }}
                                            </span>
                                        </div>

                                        <div class="d-flex align-items-center gap-3 fs-12 text-muted">
                                            <div class="d-flex align-items-center" data-bs-toggle="tooltip" title="Ngày tạo: {{ $course['createdAt'] }}">
                                                <i class="ri-calendar-line me-1"></i> {{ $course['createdAt'] }}
                                            </div>

                                            @if($currentTab === 'published' || $currentTab === 'suspended')
                                                <div class="d-flex align-items-center border-start ps-3" data-bs-toggle="tooltip" title="Đánh giá trung bình">
                                                    <i class="ri-star-fill me-1 text-warning"></i>
                                                    <span class="fw-medium text-dark">{{ number_format($course['rating'], 1) }}</span>
                                                    <span class="text-muted ms-1">({{ $course['reviewCount'] }})</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="text-end pe-4">
                                    @if($currentTab === 'pending')
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-sm btn-soft-success d-flex align-items-center gap-1 px-2"
                                                    data-bs-toggle="tooltip" title="Chấp thuận"
                                                    onclick="showConfirmAction(@this, '{{ $course['id'] }}', 'approve', { title: 'Duyệt khóa học?', confirmButtonText: 'Duyệt', confirmButtonColor: '#0ab39c' })">
                                                <i class="ri-check-line"></i>
                                            </button>
                                            <button class="btn btn-sm btn-soft-danger d-flex align-items-center gap-1 px-2"
                                                    data-bs-toggle="tooltip" title="Từ chối"
                                                    onclick="showConfirmAction(@this, '{{ $course['id'] }}', 'reject', { title: 'Từ chối?', confirmButtonText: 'Từ chối', confirmButtonColor: '#f06548' })">
                                                <i class="ri-close-line"></i>
                                            </button>
                                        </div>
                                    @elseif($currentTab === 'published')
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                                <li>
                                                    <a href="{{ route('course.learn', $course['slug']) }}" target="_blank" class="dropdown-item">
                                                        <i class="ri-eye-line align-bottom me-2 text-muted"></i> Xem nội
                                                        dung
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-danger"
                                                            onclick="showConfirmAction(@this, '{{ $course['id'] }}', 'suspend', { title: 'Đình chỉ khóa học?', text: 'Khóa học sẽ bị ẩn khỏi danh sách.', confirmButtonText: 'Đình chỉ', confirmButtonColor: '#f1b44c' })">
                                                        <i class="ri-prohibited-line align-bottom me-2"></i> Đình chỉ
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    @elseif($currentTab === 'suspended')
                                        <button class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 ms-auto"
                                                data-bs-toggle="tooltip" title="Khôi phục"
                                                onclick="showConfirmAction(@this, '{{ $course['id'] }}', 'restore', { title: 'Khôi phục?', confirmButtonText: 'Khôi phục', confirmButtonColor: '#0ab39c' })">
                                            <i class="ri-refresh-line align-bottom me-1"></i> Khôi phục
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="avatar-lg mx-auto mb-3">
                                        <div class="avatar-title bg-light rounded-circle text-primary">
                                            <i class="ri-search-2-line fs-24"></i>
                                        </div>
                                    </div>
                                    <h5 class="text-muted mb-1">Không tìm thấy dữ liệu</h5>
                                    <p class="text-muted fs-13">Thử thay đổi bộ lọc hoặc tìm kiếm từ khóa khác.</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 border-top bg-light-subtle">
                    <div class="d-flex justify-content-end">
                        {{ $courses->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
