<div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape">
    <h5 class="modal-title mb--20" id="LessonLabel">Lesson document</h5>
    <div class="course-field mb--30">
        <label>Type you lesson document</label>
        <div id="document-{{ $moduleIndex }}-{{ $lessonIndex }}-editor"></div>
        <input type="hidden" id="content-{{ $moduleIndex }}-{{ $lessonIndex }}-input" wire:model="document" value="{{ $document }}">
        <small>Markdown is supported.</small>
    </div>

    <div class="d-flex pt--30 justify-content-between">
        <button type="button" class="rbt-btn btn-border btn-md radius-round-10" wire:click="removeContent">
            Cancel
        </button>
        <button wire:click="saveDocument" type="button" class="rbt-btn btn-md radius-round-10">Save
        </button>
    </div>
</div>
@script
<script>
    const documentEditor = document.getElementById('document-{{ $moduleIndex }}-{{ $lessonIndex }}-editor')
    const documentInput = document.getElementById('content-{{ $moduleIndex }}-{{ $lessonIndex }}-input');
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
                        documentInput.value = update.state.doc.toString();
                        documentInput.dispatchEvent(new Event('input'));
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
            doc: documentInput.value,
            parent: documentEditor,
        }
    )
</script>
@endscript
