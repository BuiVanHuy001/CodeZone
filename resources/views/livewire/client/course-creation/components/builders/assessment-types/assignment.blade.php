<div @class([
        'course-field mb--20 mt-3 position-relative border p-5 rounded',
        'border-danger' => $errors->has('assignment.*'),
    ])>
    <h6>Assignment: <span wire:text="assignment.title"></span></h6>
    <div class="position-absolute" style="right: 10px; top: 10px; cursor: pointer;">
        <div class="inner">
            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-3 align-items-center">
                <li>
                    <button type="button" class="btn quiz-modal__edit-btn dropdown-toggle me-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="feather-more-horizontal"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a disabled wire:click="toggleShowDetail" class="dropdown-item" href="#" type="button">
                                @if($showDetail)
                                    <i class="feather-eye-off"></i>
                                    Hide detail
                                @else
                                    <i class="feather-edit-2"></i>
                                    Show detail
                                @endif
                            </a>
                        </li>
                        <li>
                            <a wire:click.prevent="removeAssignment" class="dropdown-item delete-item" href="#">
                                <i class="feather-trash"></i>
                                Delete
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    @if($showDetail)
        <x-client.dashboard.inputs.text
            model="assignment.title"
            name="assignment.title"
            label="Assignment Title"
            placeholder="Enter assignment title"
            info="Provide a clear, descriptive title for this assignment."
            :isError="$errors->has('assignment.title')"
        />

        <x-client.dashboard.inputs.markdown-area
            id="assignment-description"
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
                        wire:click="removeAssignment">
                    Cancel
                </button>
            </div>

            <div class="content">
                <button
                    type="button"
                    class="awe-btn"
                    wire:click="saveAssignment"
                    @disabled($errors->has('assignment.*'))>
                    <span>Save</span>
                </button>
            </div>
        </div>
    @endif
</div>
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
            doc: '',
            parent: document.getElementById('assignment-description-editor'),
        }
    )
</script>
@endscript
