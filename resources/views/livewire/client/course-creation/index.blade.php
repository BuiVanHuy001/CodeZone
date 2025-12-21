<main class="rbt-main-wrapper">
    <div class="rbt-create-course-area bg-color-white rbt-section-gap position-relative">

        <a class="rbt-btn btn-gradient btn-sm hover-icon-reverse position-absolute"
           style="top: 10px; right: 10px"
           href="javascript:void(0);"
           onclick="window.history.back();"
        >
            <span class="icon-reverse-wrapper">
                <span class="btn-text">Quay lại</span>
                <span class="btn-icon"><i class="feather-corner-down-left"></i></span>
                <span class="btn-icon"><i class="feather-corner-down-left"></i></span>
            </span>
        </a>

        <div class="container">
            <div class="row">
                <form wire:submit.prevent>
                    <div class="rbt-accordion-style rbt-accordion-01 rbt-accordion-06 accordion">
                        <div class="accordion" id="courseCreation">

                            <div @class([
                                   'accordion-item card',
                                   'border border-danger' => $errors->hasAny(['title', 'heading', 'description', 'category', 'level', 'price', 'startDate', 'endDate', 'image']),
                                ]) >
                                <h2 class="accordion-header card-header" id="accInfo">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#accCollapseInfo"
                                        aria-expanded="true"
                                        aria-controls="accCollapseInfo">
                                        Thông tin cơ bản
                                    </button>
                                </h2>
                                <div wire:ignore.self
                                     id="accCollapseInfo"
                                     class="accordion-collapse collapse show"
                                     aria-labelledby="accInfo"
                                     data-bs-parent="#courseCreation">
                                    <div class="accordion-body card-body">
                                        <div class="rbt-course-field-wrapper rbt-default-form">

                                            <x-client.dashboard.inputs.text
                                                model="title"
                                                name="title"
                                                label="Tiêu đề khóa học/Môn học"
                                                placeholder="Nhập tên khóa học"
                                                :$slug
                                            />

                                            <x-client.dashboard.inputs.text
                                                model="heading"
                                                name="heading"
                                                label="Mô tả tóm tắt"
                                                placeholder="Nhập một câu tóm tắt hấp dẫn"
                                                info="Dòng giới thiệu ngắn (heading) rõ ràng để thu hút sinh viên."
                                            />

                                            <x-client.dashboard.inputs.markdown-area
                                                id="description"
                                                label="Nội dung chi tiết khóa học"
                                                name="description"
                                                :isError="$errors->has('description')"
                                                info="Hỗ trợ Markdown. Sử dụng để mô tả chi tiết chương trình học, mục tiêu đầu ra."
                                                :livewireComponentId="$this->getId()"
                                            />

                                            <div class="course-field mb--15 edu-bg-gray">
                                                <h6>Cấu hình chung</h6>
                                                <div class="rbt-course-settings-content">
                                                    <div class="row g-5">
                                                        <div class="col-lg-4">
                                                            <div class="advance-tab-button advance-tab-button-1">
                                                                <ul class="rbt-default-tab-button nav nav-tabs" id="courseSetting"
                                                                    role="tablist">
                                                                    <li class="nav-item w-100" role="presentation">
                                                                        <a href="#"
                                                                           @class(['active' => $activeCourseSettingTab === 'general'])
                                                                           wire:click.prevent="setTab('general')"
                                                                           id="general-tab"
                                                                           data-bs-toggle="tab" data-bs-target="#general"
                                                                           role="tab" aria-controls="general" aria-selected="true">
                                                                            <span>Chung</span>
                                                                        </a>
                                                                    </li>

                                                                    @if (auth()->user()->hasRole('instructor'))
                                                                        <li class="nav-item w-100" role="presentation">
                                                                            <a href="#"
                                                                               id="price-tab"
                                                                               @class(['active' => $activeCourseSettingTab === 'price'])
                                                                               wire:click.prevent="setTab('price')"
                                                                               data-bs-toggle="tab"
                                                                               data-bs-target="#price"
                                                                               role="tab"
                                                                               aria-controls="price" aria-selected="true">
                                                                                <span>Giá & Thanh toán</span>
                                                                            </a>
                                                                        </li>
                                                                    @else
                                                                        <li class="nav-item w-100" role="presentation">
                                                                            <a href="#" id="batch-tab" data-bs-toggle="tab"
                                                                               @class(['active' => $activeCourseSettingTab === 'batch'])
                                                                               wire:click.prevent="setTab('batch')"
                                                                               data-bs-target="#batch" role="tab"
                                                                               aria-controls="batch" aria-selected="true">
                                                                                <span>Thời gian học</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif

                                                                    <li class="nav-item w-100" role="presentation">
                                                                        <a href="#" id="information-tab" data-bs-toggle="tab"
                                                                           data-bs-target="#information" role="tab"
                                                                           @class(['active' => $activeCourseSettingTab === 'additional'])
                                                                           wire:click.prevent="setTab('additional')"
                                                                           aria-controls="information" aria-selected="true">
                                                                            <span>Thông tin bổ sung</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-8">
                                                            <div class="tab-content">

                                                                <div @class([
                                                                        'tab-pane fade advance-tab-content-1',
                                                                        'active show' => $activeCourseSettingTab === 'general',
                                                                    ])
                                                                     id="general" role="tabpanel" aria-labelledby="general-tab">
                                                                    <x-client.dashboard.inputs.select
                                                                        wire:model="category"
                                                                        placeholder="Chọn Khoa/Ngành"
                                                                        label="Danh mục (Chuyên ngành)"
                                                                        name="category"
                                                                        info="Chọn Khoa hoặc Chuyên ngành chính của khóa học này."
                                                                        :options="App\Models\Category::fetchCategoriesWithChildren()"
                                                                    />

                                                                    <x-client.dashboard.inputs.select
                                                                        wire:model="level"
                                                                        placeholder="Chọn Trình độ"
                                                                        label="Cấp độ khóa học"
                                                                        name="level"
                                                                        info="Chọn cấp độ (Sơ cấp, Trung cấp, Nâng cao) của khóa học."
                                                                        :options="App\Models\Course::$LEVELS"
                                                                    />
                                                                </div>

                                                                @if (auth()->user()->hasRole('instructor'))
                                                                    <div @class([
                                                                            'tab-pane fade advance-tab-content-1',
                                                                            'active show' => $activeCourseSettingTab === 'price',
                                                                        ])
                                                                         id="price"
                                                                         role="tabpanel" aria-labelledby="price-tab">
                                                                        <div class="course-field mb--15">
                                                                            <x-client.dashboard.inputs.text
                                                                                model="price"
                                                                                label="Giá bán (VND)"
                                                                                name="price"
                                                                                placeholder="Giá bán khóa học"
                                                                                type="number"
                                                                                info="Giá tiền bán khóa học kỹ năng cho sinh viên/học viên ngoài."
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div @class([
                                                                            'tab-pane fade advance-tab-content-1',
                                                                            'active show' => $activeCourseSettingTab === 'batch',
                                                                        ])
                                                                         id="batch"
                                                                         role="tabpanel" aria-labelledby="batch-tab">
                                                                        <div class="course-field mb--15">
                                                                            <x-client.dashboard.inputs.text
                                                                                model="startDate"
                                                                                label="Ngày bắt đầu"
                                                                                name="startDate"
                                                                                info="Thời gian sinh viên bắt đầu học (00:00)."
                                                                                type="date"
                                                                            />

                                                                            <x-client.dashboard.inputs.text
                                                                                model="endDate"
                                                                                label="Ngày kết thúc"
                                                                                name="endDate"
                                                                                info="Thời gian kết thúc môn học (23:59)."
                                                                                type="date"
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div @class([
                                                                            'tab-pane fade advance-tab-content-1',
                                                                            'active show' => $activeCourseSettingTab === 'additional',
                                                                        ]) id="information"
                                                                     role="tabpanel" aria-labelledby="information-tab">
                                                                    <x-client.dashboard.inputs.text-area
                                                                        wire:model="skills"
                                                                        label="Kỹ năng đạt được" name="skills"
                                                                        placeholder="Liệt kê các kỹ năng chính sinh viên sẽ làm chủ sau khi hoàn thành khóa học/môn học này."/>

                                                                    <x-client.dashboard.inputs.text-area
                                                                        wire:model="requirements"
                                                                        label="Điều kiện tiên quyết" name="requirements"
                                                                        placeholder="Chỉ rõ bất kỳ kiến thức/môn học nào cần phải học trước khi tham gia khóa này."/>

                                                                    <x-client.dashboard.inputs.text-area
                                                                        wire:model="targetAudiences"
                                                                        label="Đối tượng phù hợp" name="requirements"
                                                                        placeholder="Mô tả đối tượng sinh viên/học viên lý tưởng cho khóa học này."/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <livewire:client.course-creation.components.course-thumbnail wire:model="thumbnail"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <livewire:client.course-creation.components.builders.course-builder wire:model="modules"/>
                        </div>
                    </div>

                    <div class="mt--10 row g-5">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-8">
                            <button type="button" wire:click="store" class="rbt-btn btn-gradient hover-icon-reverse w-100 text-center">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Lưu và Xuất bản </span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
