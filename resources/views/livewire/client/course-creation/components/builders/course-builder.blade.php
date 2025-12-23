<div @class([
        'accordion-item card',
        'border border-danger' => $errors->has('modules.required')
    ])
     class="accordion-item card">
    <h2 class="accordion-header card-header" id="accBuilder">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accCollapseBuilder"
                aria-expanded="true" aria-controls="accCollapseBuilder">
            Xây dựng nội dung khóa học
        </button>
    </h2>
    <div id="accCollapseBuilder" class="accordion-collapse collapse" aria-labelledby="accBuilder" wire:ignore.self>
        <div class="accordion-body card-body">
            @foreach ($modules as $moduleIndex => $module)
                <div class="accordion-item card mb--20">
                    <h2 class="accordion-header card-header rbt-course" id="accModules{{ $moduleIndex }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#accCollapseModules{{ $moduleIndex }}" aria-expanded="false"
                                aria-controls="accCollapseModules{{ $moduleIndex }}">
                            <span wire:text="modules[{{ $moduleIndex }}]['title']"></span>
                        </button>

                        <span wire:click="editModule({{ $moduleIndex }})" class="rbt-course-icon rbt-course-edit" title="Chỉnh sửa chương"></span>

                        <span wire:click="destroyModule({{ $moduleIndex }})" class="rbt-course-icon rbt-course-del" title="Xóa chương"></span>
                    </h2>
                    <div id="accCollapseModules{{ $moduleIndex }}" class="accordion-collapse collapse"
                         aria-labelledby="accModules{{ $moduleIndex }}" wire:ignore.self>
                        <div class="accordion-body card-body" id="dnd1">
                            @forelse($module['lessons'] as $lessonIndex => $lesson)
                                <div class="d-flex justify-content-between rbt-course-wrape mb-4" role="button">
                                    <div class="col-10 inner d-flex align-items-center gap-2">
                                        <i class="feather-menu cursor-scroll"></i>
                                        <h6 class="rbt-title mb-0"
                                            wire:text="modules[{{ $moduleIndex }}]['lessons'][{{ $lessonIndex }}]['title']">
                                        </h6>
                                    </div>
                                    <div class="col-2 inner">
                                        <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                            <li>
                                                <i class="feather-trash" wire:click="destroyLesson({{ $moduleIndex }}, {{ $lessonIndex }})" title="Xóa bài học"></i>
                                            </li>
                                            <li>
                                                <i class="feather-edit" wire:click="editLesson({{ $moduleIndex }}, {{ $lessonIndex }})" title="Chỉnh sửa bài học"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <div class="d-flex justify-content-center align-items-center py-4">
                                    <span class="text-muted">Chưa có bài học nào được thêm vào chương này.</span>
                                </div>
                            @endforelse

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="gap-3 d-flex flex-wrap">
                                    <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                            wire:click="createLesson({{ $moduleIndex }})" type="button">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Thêm bài học</span>
                                            <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                            <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <button class="rbt-btn btn-md btn-gradient hover-icon-reverse" type="button" wire:click="createModule">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Thêm chương mới</span>
                    <span class="btn-icon"><i class="feather-plus-circle"></i></span>
                    <span class="btn-icon"><i class="feather-plus-circle"></i></span>
                </span>
            </button>
        </div>
    </div>

    <livewire:client.course-creation.components.builders.module.module-create/>
    <livewire:client.course-creation.components.builders.module.module-update/>
    <livewire:client.course-creation.components.builders.lesson.lesson-create/>
    <livewire:client.course-creation.components.builders.lesson.lesson-update/>
</div>
