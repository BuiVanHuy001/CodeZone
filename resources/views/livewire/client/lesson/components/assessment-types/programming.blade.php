<div class="section-title content">
    <h4>Programming Assignment</h4>
    <div class="row">
        <div class="col-6">
            <h5 class="rbt-title-style-3">{{ $programmingPractice->title }}</h5>
            <div class="markdown-body mt-4 has-show-more">
                <div class="has-show-more-inner-content">
                    @markdown($programmingPractice->description)
                </div>
                <div class="rbt-show-more-btn">Show More</div>
            </div>
        </div>
        <div class="col-6">
            <x-client.dashboard.inputs.select
                label="Select programming language"
                :options="$allowedLanguages"
                model="languageSelected"
                name="languageSelected"
                info="Select programming language to start coding"
                placeholder="Select programming language"
                :default="$this->languageSelected"
            />

            <div id="code-editor-{{ $programmingPractice->id }}" wire:ignore></div>

            <div class="d-flex justify-content-end">
                <button wire:click="submitCode" class="rbt-btn btn-border icon-hover btn-sm mt-3" href="#">
                    <span class="btn-text">Submit code</span>
                    <span class="btn-icon"><i class="feather-upload-cloud"></i></span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:init", () => {
            const documentEditor = document.getElementById('code-editor-{{ $programmingPractice->id }}');
            if (documentEditor) {
                new EditorView({
                    extensions: [
                        lineNumbers(),
                        python(),
                        highlightActiveLineGutter(),
                        highlightActiveLine(),
                        highlightSpecialChars(),
                        EditorView.lineWrapping,
                        oneDark,
                        EditorView.domEventHandlers({
                            blur: (event, view) => {
                                const content = view.state.doc.toString();
                                @this.
                                set('userCode', content)
                            }
                        }),
                        EditorView.theme({
                            "&": {
                                height: "400px",
                                width: "100%",
                                border: "1px solid #ddd",
                                borderRadius: "4px",
                                padding: "10px",
                                fontSize: "13px",
                            },
                            ".cm-content": {}
                        })
                    ],
                    parent: documentEditor,
                    doc: @json($template),
                });
            }
            Livewire.on('language-changed', (template) => {
                if (editorView) {
                    editorView.dispatch({
                        changes: {
                            from: 0,
                            to: editorView.state.doc.length,
                            insert: template
                        }
                    });
                }
            });
        });
    </script>
@endpush
