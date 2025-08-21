<div class="course-field mb--20">
    <h6>Document</h6>
    <div id="new-lesson-document-editor" wire:ignore></div>
    <input type="hidden" id="new-lesson-document-input">
</div>

@script
<script>
    const documentEditor = document.getElementById('new-lesson-document-editor');
    const documentInput = document.getElementById('new-lesson-document-input');

    const editor = new EditorView({
        extensions: [
            lineNumbers(),
            markdown(),
            highlightActiveLineGutter(),
            highlightActiveLine(),
            highlightSpecialChars(),
            EditorView.lineWrapping,
            EditorView.domEventHandlers({
                blur: (event, view) => {
                    const content = view.state.doc.toString();
                    console.log('Content:', content);
                    Livewire.dispatch('document-changed', {document: content});
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
                ".cm-content": {caretColor: "#000"},
            }),
        ],
        parent: documentEditor,
    });
</script>
@endscript
