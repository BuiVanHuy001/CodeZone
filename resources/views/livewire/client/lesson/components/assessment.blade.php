<div class="content">
    @if($results !== [])
        <div class="section-title">
            <p class="mb--10">Quiz</p>
            <h5>{{ $assessment->title }}</h5>
        </div>
        <div class="rbt-dashboard-table table-responsive mobile-table-750 mt--30">
            <table class="rbt-table rbt-table-scroll table table-borderless">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Question</th>
                    <th>Correct Answer</th>
                    <th>Incorrect Answer</th>
                    <th>Score</th>
                    <th>Result</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>
                        <p class="b3 mb--5">December 26, 2024</p>
                    </th>
                    <td>
                        <p class="b3">{{ $assessment->questions_count }}</p>
                    </td>
                    <td>
                        <p class="b3">{{ $results['correctAnswers'] }}</p>
                    </td>
                    <td>
                        <p class="b3">{{ $assessment->questions_count - $results['correctAnswers'] }}</p>
                    </td>
                    <td>
                        <p class="b3">{{ $results['score'] }}/10</p>
                    </td>
                    <td>
                        <span class="rbt-badge-5 bg-color-success-opacity color-{{ $results['result'] === 'pass' ? 'success' : 'danger' }}">{{ ucfirst($results['result']) }}</span>
                    </td>
                    <td>
                        <button class="rbt-btn btn-border rbt-sm-btn-2" type="button">
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">Details</span>
                            </span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="rbt-dashboard-table table-responsive mobile-table-750 mt--50 quiz-result-enter quiz-result-enter-active">
            <table class="rbt-table rbt-table-scroll table table-borderless">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Type</th>
                    <th>Question</th>
                    <th>Given Answer</th>
                    <th>Correct Answer</th>
                    <th>Result</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <p class="b3 mb--5">1</p>
                    </td>
                    <td>
                        <p class="b3">True/False</p>
                    </td>
                    <td>
                        <p class="b3">What is the capital of France?</p>
                    </td>
                    <td>
                        <p class="b3">True</p>
                    </td>
                    <td>
                        <p class="b3">True</p>
                    </td>
                    <td><span
                            class="rbt-badge-5 bg-color-success-opacity color-success">Correct</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="b3 mb--5">2</p>
                    </td>
                    <td>
                        <p class="b3">Single Chice</p>
                    </td>
                    <td>
                        <p class="b3">What are the key features of Next.js ?</p>
                    </td>
                    <td>
                        <p class="b3">True</p>
                    </td>
                    <td>
                        <p class="b3">False</p>
                    </td>
                    <td><span
                            class="rbt-badge-5 bg-color-danger-opacity color-danger">Incorrect</span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    @elseif($assessment->type === 'programming')
        <div class="section-title">
            <h4>Programming Assignment</h4>
            <div class="row">
                <div class="col-6">
                    <h5 class="rbt-title-style-3">{{ $assessment->title }}</h5>
                    @markdown($assessment->description)
                </div>
                <div class="col-6">
                    <h5>Select programming language</h5>
                    <div class="rbt-modern-select bg-transparent height-45">
                        <select class="w-100">
                            @foreach($allowedProgrammingLanguages as $language)
                                <option value="{{ $language }}">{{ \App\Models\ProgrammingAssignmentDetails::$SUPPORTED_LANGUAGES[$language] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="code-editor"></div>
                </div>
            </div>
        </div>
    @else
        <div class="section-title">
            <h4>{{ $assessment->title  }}</h4>
            <p>{{ $assessment->description }}</p>
            <div class="bg-color-white rbt-shadow-box">
                <h5 class="rbt-title-style-3">Assignment Submission</h5>
                <form action="#">
                    <label for="images" class="drop-container rbt-custom-file-upload mt--30">
                        <span class="mb--0 h5">Drop files here</span>
                        or
                        <input type="file" id="images" required>
                    </label>
                </form>


                <div class="submit-btn mt--35">
                    <a class="rbt-btn btn-gradient hover-icon-reverse" href="">
                        <span class="icon-reverse-wrapper">
                            <span class="btn-text">Submit Assignment</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('assignment-programming-ready', () => {
                new EditorView(
                    {
                        extensions: [
                            lineNumbers(),
                            javascript(),
                            highlightSpecialChars(),
                            EditorView.lineWrapping,
                            EditorView.updateListener.of(update => {
                                if (update.docChanged) {
                                    // Assuming 'courseDescriptionInput' is defined elsewhere or needs to be selected
                                    // For example:
                                    // const courseDescriptionInput = document.getElementById('some-input-id');
                                    // courseDescriptionInput.value = update.state.doc.toString();
                                    // courseDescriptionInput.dispatchEvent(new Event('input'));
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
                        doc: @json($assessment->description),
                        parent: document.querySelector('.code-editor'),
                    }
                );
            });
        });
    </script>
@endpush
