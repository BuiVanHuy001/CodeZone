<div class="course-field mb--20 mt-3 rbt-course-wrape position-relative">
    <h6>Assignment</h6>
    <div class="position-absolute" style="right: 10px; top: 10px; cursor: pointer;">
        <i wire:click="removeQuiz" @click="activeTab = null" class="feather-trash me-auto"></i>
    </div>

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
