<x-client.dashboard.course-creation.builders.assessment-types.base
    title="Assignment"
    name="assignment">
    <div x-show="showDetail">
        <x-client.dashboard.inputs.text
            model="assignment.title"
            name="assignment.title"
            label="Assignment Title"
            placeholder="Enter assignment title"
            info="Provide a clear, descriptive title for this assignment."
            :isError="$errors->has('assignment.title')"
        />

        <x-client.dashboard.inputs.markdown-area
            id="assignment-description{{ !empty($unique) ? '-' . $unique : '' }}"
            label="Assignment Description"
            info="Markdown is supported."
            name="assignment.description"
            placeholder="Enter assignment description"
            :isError="$errors->has('assignment.description')"
        />

        <div class="d-flex pt--30 justify-content-between">
            <div class="content">
                <button type="button"
                        class="awe-btn bg-danger"
                        wire:click="remove">
                    Cancel
                </button>
            </div>

            <div class="content">
                <button
                    type="button"
                    class="awe-btn"
                    wire:click="save"
                    @disabled($errors->has('assignment.*'))>
                    <span>Save</span>
                </button>
            </div>
        </div>

    </div>
</x-client.dashboard.course-creation.builders.assessment-types.base>
@script
<script>
    new EditorView(
        {
            extensions: [
                lineNumbers(),
                markdown(),
                highlightActiveLineGutter(),
                highlightActiveLine(),
                highlightSpecialChars(),
                EditorView.lineWrapping,
                EditorView.domEventHandlers({
                    blur: (event, view) => {
                        $wire.set('assignment.description', view.state.doc.toString());
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
            doc: @json($assignment['description'] ?? ''),
            parent: document.getElementById('assignment-description{{ !empty($unique) ? '-' . $unique : '' }}-editor'),
        }
    )
</script>
@endscript
