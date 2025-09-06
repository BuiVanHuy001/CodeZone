<div @class([
       'course-field mb--20 mt-3 position-relative border p-5 rounded',
       'border-danger' => $errors->has("$name.*"),
    ])
     x-data="{ {{ $name }}: @entangle($name), step: 1, showDetail: @entangle('showDetails') }"
>
    <h6>{{ $title }}: <span wire:text="{{ $name }}.title"></span></h6>
    <div class="position-absolute" style="right: 10px; top: 10px; cursor: pointer;">
        <div class="inner">
            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-3 align-items-center">
                <li>
                    <button type="button" class="btn quiz-modal__edit-btn dropdown-toggle me-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="feather-more-horizontal"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a @click.prevent="{{ $name }}.title ? showDetail = !showDetail : null"
                               class="dropdown-item"
                               :class="{ 'disabled text-muted': !{{ $name }}.title }"
                               href="#"
                            >
                                <i :class="showDetail ? 'feather-eye-off' : 'feather-eye'"></i>
                                <span x-text="showDetail ? 'Hide detail' : 'Show detail'"></span>
                            </a>
                        </li>
                        <li>
                            <a wire:click.prevent="{{ $wireDeleteMethod }}"
                               class="dropdown-item delete-item"
                               :class="{ 'disabled text-muted': !{{ $name }}.title }"
                               href="#">
                                <i class="feather-trash"></i>
                                Delete
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    {{ $slot }}
</div>
