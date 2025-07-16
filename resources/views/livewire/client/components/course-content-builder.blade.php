<div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape">
    <h5 class="modal-title mb--20" id="LessonLabel">Lesson content</h5>
    <div class="course-field mb--30">
        <label for="content_{{ $moduleIndex }}_{{ $lessonIndex }}">Summary about lesson</label>
        <textarea wire:model="content" id="content_{{ $moduleIndex }}_{{ $lessonIndex }}" rows="15"></textarea>
        <small>Markdown is supported. You can use it to format your text, add links, and more.</small>
    </div>

    <div class="d-flex pt--30 justify-content-between">
        <button type="button" class="rbt-btn btn-border btn-md radius-round-10" wire:click="removeContent">
            Cancel
        </button>
        <button wire:click="saveContent" type="button" class="rbt-btn btn-md radius-round-10">Save
        </button>
    </div>
</div>
