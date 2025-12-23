<div class="course-field mb--15 edu-bg-gray" x-data="{ activeTab: 'classification' }">
    <h6>Cấu hình chi tiết</h6>
    <div class="rbt-course-settings-content">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="advance-tab-button advance-tab-button-1">
                    <ul class="rbt-default-tab-button nav nav-tabs" role="tablist">
                        <li class="nav-item w-100">
                            <a href="#" @click.prevent="activeTab = 'classification'" :class="{ 'active': activeTab === 'classification' }">
                                <span>Phân loại đào tạo</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" @click.prevent="activeTab = 'goals'" :class="{ 'active': activeTab === 'goals' }">
                                <span>Mục tiêu & Yêu cầu</span>
                            </a>
                        </li>
                        <li class="nav-item w-100">
                            <a href="#" @click.prevent="activeTab = 'enrollment'" :class="{ 'active': activeTab === 'enrollment' }">
                                <span>Hình thức & Học phí</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="tab-content">
                    <div x-show="activeTab === 'classification'" class="tab-pane fade show active">
                        <x-client.dashboard.inputs.select
                            wire:model="category"
                            placeholder="-- Chọn danh mục --"
                            label="Danh mục học thuật"
                            name="category"
                            info="Phân loại theo nhóm kiến thức (VD: Đồ họa, Lập trình, Marketing...)"
                            :options="App\Models\Category::fetchCategoriesWithChildren()"
                        />
                        <x-client.dashboard.inputs.select
                            wire:model="level"
                            placeholder="Chọn cấp độ"
                            label="Trình độ chuyên môn"
                            name="level"
                            info="Đánh giá mức độ khó của nội dung bài học."
                            :options="App\Models\Course::$LEVELS"
                        />
                    </div>

                    <div x-show="activeTab === 'goals'" class="tab-pane fade show active">
                        <x-client.dashboard.inputs.text-area
                            wire:model="targetAudiences"
                            label="Đối tượng người học"
                            name="targetAudiences"
                            placeholder="Ví dụ: Sinh viên năm cuối ngành Thiết kế đồ họa..."
                        />
                        <x-client.dashboard.inputs.text-area
                            wire:model="requirements"
                            label="Điều kiện tham gia"
                            name="requirements"
                            placeholder="Ví dụ: Đã hoàn thành môn Cơ sở dữ liệu..."
                        />
                        <x-client.dashboard.inputs.text-area
                            wire:model="skills"
                            label="Chuẩn đầu ra (Kỹ năng)"
                            name="skills"
                            placeholder="Sinh viên sẽ làm được gì sau khi kết thúc khóa học?"
                        />
                    </div>

                    <div x-show="activeTab === 'enrollment'" class="tab-pane fade show active">
                        <div class="rbt-form-group mb--20">
                            <label class="form-label d-block fw-bold mb--10">Chế độ ghi danh và Học phí</label>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="courseTypeGroup" wire:model.live="courseType" value="internal" id="type_internal">
                                        <label class="form-check-label" for="type_internal">
                                            <strong>Học phần chính quy</strong> (Dành cho sinh viên nội bộ trường)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="courseTypeGroup" wire:model.live="courseType" value="free" id="type_free">
                                        <label class="form-check-label" for="type_free">
                                            <strong>Khóa học kỹ năng - Miễn phí</strong> (Công khai cho mọi đối tượng)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="courseTypeGroup" wire:model.live="courseType" value="paid" id="type_paid">
                                        <label class="form-check-label" for="type_paid">
                                            <strong>Khóa học kỹ năng - Có thu phí</strong> (Khóa học thương mại dành cho
                                            mọi đối tượng)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if($courseType === 'paid')
                                <div class="mt--20 animate__animated animate__fadeIn border-top pt--20">
                                    <x-client.dashboard.inputs.text
                                        model="price"
                                        label="Mức học phí niêm yết (VND)"
                                        name="price"
                                        placeholder="Ví dụ: 500000"
                                        info="Hệ thống sẽ tính phí dựa trên con số này khi học viên thanh toán."
                                    />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
