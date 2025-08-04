<div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape">
    <h5 class="modal-title mb--20" id="LessonLabel">Assignment</h5>
    <div class="course-field mb--20">
        <label>Assignment Title</label>
        <input type="text"
               placeholder="Type your assignments title"
               wire:model="assignment.title">
    </div>
    <div class="course-field mb--30">
        <label>Assignment Description</label>
        <div id="assignment-description-{{ $moduleIndex }}-{{ $lessonIndex }}-editor"></div>
        <input type="hidden"
               id="assignment-description-{{ $moduleIndex }}-{{ $lessonIndex }}-input"
               value="{{ $assignment['description'] }}"
               wire:model="assignment.description"/>
    </div>
    <div class="d-flex pt--30 justify-content-between">
        <button wire:click="removeAssignment"
                type="button"
                class="rbt-btn btn-border btn-md radius-round-10">
            Cancel
        </button>

        <button wire:click="saveAssignment"
                type="button"
                class="rbt-btn btn-md radius-round-10">
            Save
        </button>
    </div>
</div>
@script
<script>
    const assignmentDescriptionEditor = document.getElementById('assignment-description-{{ $moduleIndex }}-{{ $lessonIndex }}-editor');
    const assignmentDescriptionInput = document.getElementById('assignment-description-{{ $moduleIndex }}-{{ $lessonIndex }}-input');
    new EditorView(
        {
            extensions: [
                lineNumbers(),
                markdown(),
                highlightActiveLineGutter(),
                highlightActiveLine(),
                highlightSpecialChars(),
                EditorView.lineWrapping,
                EditorView.updateListener.of(update => {
                    if (update.docChanged) {
                        assignmentDescriptionInput.value = update.state.doc.toString();
                        assignmentDescriptionInput.dispatchEvent(new Event('input'));
                    }
                }),
                EditorView.theme({
                    "&": {
                        height: "200px",
                        width: "100%",
                        border: "1px solid #ddd",
                        borderRadius: "4px",
                        padding: "10px",
                        fontSize: "13px",
                    },
                    ".cm-content": {
                        caretColor: "#000",
                    },
                }),
            ],
            doc: assignmentDescriptionInput.value,
            parent: assignmentDescriptionEditor,
        }
    )
</script>
@endscript
