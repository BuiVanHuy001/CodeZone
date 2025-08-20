<div class="course-field mb--20">
    <h6>Document</h6>
        <div id="document-{{ $moduleIndex }}-{{ $lessonIndex }}-editor"></div>
        <input type="hidden" id="content-{{ $moduleIndex }}-{{ $lessonIndex }}-input" wire:model="document" value="{{ $document }}">
        <small>Markdown is supported.</small>
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
