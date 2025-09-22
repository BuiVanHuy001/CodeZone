<x-client.dashboard.inputs.markdown-area
    id="lesson-document"
    label="Document"
    info="Markdown is supported. This is the document that will be displayed to the student."
    name="document"
/>
@script
<script>
    createCodeEditor(
        'lesson-document-editor',
        'markdown',
        '',
        false,
        @json($this->getId(), JSON_THROW_ON_ERROR),
        'document'
    )
</script>
@endscript
