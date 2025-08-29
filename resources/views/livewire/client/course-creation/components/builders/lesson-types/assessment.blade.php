<div @class([
       'course-field mb--20 mt-3 position-relative border p-5 rounded',
       'border-danger' => $errors->has('assessment.*'),
   ])
>
    <h6>Bài kiểm tra</h6>
    <div class="position-absolute" style="right: 10px; top: 10px; cursor: pointer;">
        <div class="inner">
            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-3 align-items-center">
                <li>
                    <button type="button" class="btn quiz-modal__edit-btn dropdown-toggle me-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="feather-more-horizontal"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#" type="button">
                                <i class="feather-eye-off"></i> Xem chi tiết
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item delete-item" href="#">
                                <i class="feather-trash"></i>
                                Xóa
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="radio-inputs my-3" :key="'radio-'.$index">
        @foreach(\App\Models\Assessment::$ASSESSMENT_PRACTICE_TYPES as $key => $label)
            <label class="radio">
                <input wire:model.lazy="assessment.type" type="radio" name="assessment.type" value="{{ $key }}">
                <span class="name">{{ $label }}</span>
            </label>
        @endforeach
    </div>
    @if(isset($assessment['type']))
        @if($assessment['type'] === 'quiz')
            <livewire:client.course-creation.components.builders.assessment-types.quiz wire:model="assessment"/>
        @elseif($assessment['type'] === 'assignment')
            <livewire:client.course-creation.components.builders.assessment-types.assignment wire:model="assessment"/>
        @elseif($assessment['type'] === 'programming')
            <livewire:client.course-creation.components.builders.assessment-types.programming wire:model="assessment"/>
        @endif
    @endif
</div>
