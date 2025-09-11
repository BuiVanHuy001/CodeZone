<x-client.dashboard.inputs.markdown-area
    id="lesson-document"
    label="Document"
    info="Markdown is supported. This is the document that will be displayed to the student."
    name="document"/>

@script
<script>
    new EditorView({
        extensions: [
            lineNumbers(),
            markdown(),
            highlightActiveLineGutter(),
            highlightActiveLine(),
            highlightSpecialChars(),
            EditorView.lineWrapping,
            EditorView.domEventHandlers({
                blur: (event, view) => {
                    $wire.set('document', view.state.doc.toString());
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
                    caretColor: "#000"
                },
            }),
        ],
        doc: @json($document),
        parent: document.getElementById('lesson-document-editor'),
    });
</script>
@endscript
