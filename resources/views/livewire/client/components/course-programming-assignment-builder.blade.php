<div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape">
    <h5 class="modal-title mb--20" id="LessonLabel">Programming Assessment</h5>
    <div class="course-field mb--20">
        <label for="">Title</label>
        <input id="" wire:model="lesson.title" type="text" placeholder="Type your assignments title">
    </div>

    <div class="course-field mb--30">
        <label for="">Description</label>
        <div id="description-editor"></div>
        <small>Markdown is supported.</small>
    </div>

    <div class="course-field mb--20 col-lg-6">
        <label>Select Programming Language</label>
        <div x-data x-init="$nextTick(() => $('select[data-live-search]').selectpicker('render'))" x-show="true"
             class="rbt-modern-select b-g-transparent height-45 w-100">
            <select class="w-100" data-live-search="true" title="Select Language" multiple data-size="7" data-actions-box="true" data-selected-text-format="count > 2">
                @foreach(\App\Models\ProgrammingAssignmentDetails::$SUPPORTED_LANGUAGES as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12">
        <label for="">Code template for Python</label>
        <div id="code-editor"></div>
    </div>
    <div class="col-12">
        <label for="">Code template for PHP</label>
        <textarea id="" class="form-control" rows="5" placeholder="Type your code template here..."></textarea>
    </div>

    <div class="d-flex pt--30 justify-content-between">
        <button type="button" class="rbt-btn btn-border btn-md radius-round-10">Cancel</button>
        <button type="button" class="rbt-btn btn-md radius-round-10">Save</button>
    </div>
</div>
@section('cus_js')
    <script>
        let codeEditor = new EditorView({
            extensions: [
                lineNumbers(),
                foldGutter(),
                autocompletion(),
                history(),
                python(),
                highlightActiveLine(),
                highlightActiveLineGutter(),
                keymap.of([...defaultKeymap, ...historyKeymap]),
                EditorView.lineWrapping,
                EditorView.theme({
                    "&": {
                        height: "300px",
                        width: "100%",
                        border: "1px solid #ddd",
                        borderRadius: "4px",
                        padding: "10px",
                        fontSize: "13px",
                    },
                    ".cm-content": {
                        caretColor: "#fff",
                    },
                }),

                oneDark,
            ],
            doc: `# Viết code của bạn vào đây
def sum_array(numbers):
    # TODO: Viết logic của bạn ở đây
    return 0

# Dữ liệu đầu vào đ�� kiểm thử
input_data = [1, 2, 3, 4, 5]

# Gọi hàm của bạn và in kết quả
print(sum_array(input_data))`,
            parent: document.getElementById('code-editor')
        });

        const courseDescriptionInput = document.querySelector('#description_input');
        let descriptionEditor = new EditorView(
            {
                extensions: [
                    lineNumbers(),
                    markdown(),
                    highlightSpecialChars(),
                    EditorView.lineWrapping,
                    EditorView.updateListener.of(update => {
                        if (update.docChanged) {
                            courseDescriptionInput.value = update.state.doc.toString();
                            courseDescriptionInput.dispatchEvent(new Event('input'));
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
                parent: document.getElementById('description'),
            }
        );
    </script>
@endsection
