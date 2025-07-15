<div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape">
    <h5 class="modal-title mb--20" id="LessonLabel">Assignment</h5>
    <div class="course-field mb--20">
        <label for="assignment_title_{{ $moduleIndex }}_{{ $lessonIndex }}">Assignment Title</label>
        <input id="assignment_title_{{ $moduleIndex }}_{{ $lessonIndex }}" type="text" placeholder="Type your assignments title" wire:model="assignment.title">
    </div>
    <div class="course-field mb--30">
        <label for="assignment_description_{{ $moduleIndex }}_{{ $lessonIndex }}">Assignment Description</label>
        <textarea id="assignment_description_{{ $moduleIndex }}_{{ $lessonIndex }}" wire:model="assignment.description"></textarea>
    </div>
    <div class="d-flex pt--30 justify-content-between">
        <button wire:click="removeAssignment" type="button" class="rbt-btn btn-border btn-md radius-round-10">
            Cancel
        </button>

        <button type="button" wire:click="saveAssignment" class="rbt-btn btn-md radius-round-10">Save</button>
    </div>
</div>
