<div class="section-title content">
    <h4>Programming Assignment</h4>
    <div class="row">
        <div class="col-6">
            <h5 class="rbt-title-style-3">{{ $programmingPractice->title }}</h5>
            <div class="markdown-body">
                @markdown($programmingPractice->description)
            </div>
        </div>
        <div class="col-6">
            <h5>Select programming language</h5>
            <div class="rbt-modern-select bg-transparent height-45 mb-3">
                <select class="w-100" wire:model.live="languageSelected">
                    @foreach($allowedLanguages as $language)
                        <option value="{{ $language }}">{{ \App\Models\ProgrammingAssignmentDetails::$SUPPORTED_LANGUAGES[$language] }}</option>
                    @endforeach
                </select>
            </div>

            <div id="code-editor" wire:ignore></div>
            <input type="hidden" id="code-input" wire:model.live="userCode">

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
        document.addEventListener('livewire:initialized', () => {
            let editorView;
            const userCodeInput = document.getElementById('code-input');
            const codeTemplates = @json($codeTemplates);

            const getLanguageExtension = (language) => {
                switch (language) {
                    case 'python':
                        return python();
                    case 'js':
                        return javascript();
                    case 'java':
                        return java();
                    case 'cpp':
                        return cpp();
                    case 'php':
                        return php();
                    default:
                        return [];
                }
            };

            const initOrUpdateEditor = (language, initialContent) => {
                const editorEl = document.getElementById('code-editor');
                if (!editorEl) {
                    return;
                }

                if (editorView) {
                    editorView.destroy();
                }

                editorView = new EditorView({
                    doc: initialContent,
                    extensions: [
                        lineNumbers(),
                        foldGutter(),
                        autocompletion(),
                        CodeMirrorHistory(),
                        getLanguageExtension(language),
                        highlightActiveLine(),
                        highlightActiveLineGutter(),
                        oneDark,
                        keymap.of([...defaultKeymap, ...historyKeymap]),
                        EditorView.lineWrapping,
                        EditorView.updateListener.of(update => {
                            if (update.docChanged) {
                                userCodeInput.value = update.state.doc.toString();
                                userCodeInput.dispatchEvent(new Event('input'));
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
                            ".cm-content": {
                                caretColor: "#fff",
                            },
                        }),
                    ],
                    parent: editorEl
                });
            };

            const initialLanguage = '{{ $languageSelected }}';
            const initialTemplate = codeTemplates[initialLanguage] || '';
            initOrUpdateEditor(initialLanguage, initialTemplate);

            Livewire.on('language-selected-changed', ({language}) => {
                const newTemplate = codeTemplates[language] || '';
                initOrUpdateEditor(language, newTemplate);
            });

            Livewire.on('programming-practice-init', (event) => {
                console.log('Programming practice initialized with event');
                initOrUpdateEditor(event[0][0], codeTemplates[event[0][0]]);
            });
        });
    </script>
@endpush
