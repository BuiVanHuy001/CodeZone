<div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape" x-show="activeTab === 'assignment'" x-transition>
    <h5 class="modal-title mb--20" id="LessonLabel">Assignment</h5>
    <div class="course-field mb--20"><label for="">Assignment
            Title</label><input id="" type="text" placeholder="Assignments">
    </div>
    <div class="course-field mb--30">
        <label for="modal-field-3">Summary</label>
        <textarea id="editor3"></textarea>
    </div>
    <div class="d-flex pt--30 justify-content-between">
        <button type="button" class="rbt-btn btn-border btn-md radius-round-10" @click="activeTab = null">
            Cancel
        </button>

        <button type="button" class="rbt-btn btn-md radius-round-10">Save
        </button>
    </div>
</div>
