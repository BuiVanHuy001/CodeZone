<div class="content">
    @if($results !== [])
        <div class="section-title">
            <h5>{{ $quiz->title }}</h5>
        </div>
        <div class="rbt-dashboard-table table-responsive mobile-table-750 mt--30">
            <table class="rbt-table rbt-table-scroll table table-borderless">
                <thead>
                <tr>
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
                    <td>
                        <p class="b3">{{ $quiz->questions_count }}</p>
                    </td>
                    <td>
                        <p class="b3">{{ $results['correctAnswersCount'] }}</p>
                    </td>
                    <td>
                        <p class="b3">{{ $quiz->questions_count - $results['correctAnswersCount'] }}</p>
                    </td>
                    <td>
                        <p class="b3">{{ $results['score'] }}/10</p>
                    </td>
                    <td>
                        <span class="rbt-badge-5 bg-color-success-opacity color-{{ $results['result'] === 'pass' ? 'success' : 'danger' }}">{{ ucfirst($results['result']) }}</span>
                    </td>
                    <td>
                        <button class="rbt-btn btn-border rbt-sm-btn-2"
                                data-bs-toggle="modal"
                                data-bs-target="#quizResultDetails"
                                wire:click="showAttemptDetail({{ $results['id'] }})"
                                type="button">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Details</span>
                                </span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    @else
        <form wire:submit.prevent="quizSubmit"
              x-data="{
        currentQuestion: 0,
        answers: {},
        nextQuestion() {
            const ans = this.answers[this.currentQuestion];
            if (!ans || (Array.isArray(ans) && ans.length === 0)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Please select an answer before continuing!',
                });
                return;
            }
            this.currentQuestion++;
        },
        setAnswer(qid, oid) {
            const isMultipleChoice = {{ json_encode($quiz->questions->pluck('type')->toArray()) }}[qid - 1] === 'multiple_choice';
            if (isMultipleChoice) {
                if (!Array.isArray(this.answers[qid])) {
                    this.answers[qid] = [];
                }
                const idx = this.answers[qid].indexOf(oid);
                if (idx > -1) {
                    this.answers[qid].splice(idx, 1);
                } else {
                    this.answers[qid].push(oid);
                }
                if (this.answers[qid].length === 0) {
                    delete this.answers[qid];
                }
            } else {
                this.answers[qid] = oid;
            }
        }
    }"
              class="quiz-form-wrapper">
            <div x-show="currentQuestion === 0">
                <div class="section-title">
                    <h5>{{ $quiz->title }}</h5>
                </div>
                <p class="b3 mb--30">You have <strong>{{ $quiz->questions_count }}</strong> questions to answer.</p>

                <div id="course-document" class="markdown-body has-show-more">
                    <div class="has-show-more-inner-content">
                        @markdown($quiz->description)
                    </div>
                    <div class="rbt-show-more-btn">Show More</div>
                </div>


            </div>
            @foreach($quiz->questions as $questionKey => $question)
                <div id="question-{{ $questionKey + 1 }}" x-show="currentQuestion === {{ $questionKey + 1 }}">
                    <div class="quize-top-meta">
                        <div class="quize-top-left">
                            <span>Questions No: <strong>{{ $questionKey + 1 . '/' . $quiz->questions_count }}</strong></span>
                            <span>Attempts Allowed: <strong>1</strong></span>
                        </div>
                        <div class="quize-top-right">
                            <span>Time remaining: <strong>No Limit</strong></span>
                        </div>
                    </div>
                    <hr>
                    <div class="rbt-single-quiz">
                        <h4>{{ $question->content }}</h4>
                        <div class="row g-3 mt--10">
                            @if($question->type === 'multiple_choice')
                                @php
                                    $isMultipleChoice = $question->isMultipleAnswers();
                                @endphp
                                @foreach($question->options as $option)
                                    <div class="col-lg-6">
                                        <div class="{{ $isMultipleChoice ? 'rbt-checkbox-wrapper mb--5' : 'rbt-form-check' }}">
                                            <input
                                                id="{{ $isMultipleChoice ? "rbt-checkbox-$loop->index" : "rbt-radio-{$question->id}-$loop->index" }}"
                                                name="{{ $isMultipleChoice ? "answers[{$question->id}][]" : "answers[{$question->id}]" }}"
                                                wire:click="addAnswers({{ $question->id }}, {{ $loop->index }})"
                                                type="{{ $isMultipleChoice ? 'checkbox' : 'radio' }}"
                                                class="{{ $isMultipleChoice ? '' : 'form-check-input' }}"
                                                x-on:change="setAnswer({{ $questionKey + 1 }}, {{ $loop->index }})"
                                            >
                                            <label
                                                class="{{ $isMultipleChoice ? '' : 'form-check-label' }}"
                                                for="{{ $isMultipleChoice ? "rbt-checkbox-$loop->index" : "rbt-radio-{$question->id}-$loop->index" }}"
                                            >
                                                {{ $option['content'] }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="rbt-quiz-btn-wrapper mt--30">
                <button
                    type="button"
                    class="rbt-btn btn-gradient btn-sm"
                    id="start-btn"
                    x-show="currentQuestion === 0"
                    x-on:click="currentQuestion = 1; $wire.hidePreviousAttemptsTable()">
                    {{ $quiz->getUserAttempts(auth()->user()) ? 'Re-attempt until get 10 score' : 'Start Quiz' }}
                </button>

                <button
                    class="rbt-btn bg-primary-opacity btn-sm"
                    id="prev-btn"
                    type="button"
                    x-show="currentQuestion > 1"
                    x-on:click="currentQuestion = currentQuestion - 1">
                    Previous
                </button>

                <button
                    class="rbt-btn bg-primary-opacity btn-sm"
                    id="next-btn"
                    type="button"
                    x-show="currentQuestion > 0 && currentQuestion < {{ $quiz->questions_count }}"
                    x-on:click="nextQuestion()">
                    Next
                </button>

                <button
                    type="submit"
                    class="rbt-btn btn-gradient btn-sm"
                    id="submit-btn"
                    wire:click="showPreviousAttemptsTable"
                    x-show="currentQuestion === {{ $quiz->questions_count }}">
                    Submit
                </button>
            </div>

            @if ($isShowPreviousAttempts)
                <div class="rbt-dashboard-table table-responsive mobile-table-750 mt--50 quiz-result-enter quiz-result-enter-active">
                    <h3 class="section-title">Your previous attempts</h3>
                    <table class="rbt-table rbt-table-scroll table table-borderless">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total Question</th>
                            <th>Correct Answer</th>
                            <th>Score</th>
                            <th>Result</th>
                            <th>Details</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($quiz->getUserAttempts(auth()->user()) as $attempt)
                            <tr>
                                <td>
                                    <p class="b3 mb--5">{{ $attempt['created_at']->diffForHumans() }}</p>
                                </td>
                                <td>
                                    <p class="b3">{{ $attempt['total_questions_count'] }}</p>
                                </td>
                                <td>
                                    <p class="b3">{{ $attempt['correct_answers_count'] }}</p>
                                </td>
                                <td>
                                    <p class="b3">{{ number_format($attempt['score'], 1) }}</p>
                                </td>
                                <td>
                                <span @class(['rbt-badge-5', 'bg-color-success-opacity color-success' => $attempt['is_passed'], 'bg-color-danger-opacity color-danger' => !$attempt['is_passed']])>
                                    {{ $attempt['is_passed'] ? 'Pass' : 'Fail' }}
                                </span>
                                </td>
                                <td>
                                    <button type="button"
                                            wire:click="showAttemptDetail({{ $attempt['id'] }})"
                                            class="rbt-btn btn-border rbt-sm-btn-2">
                                        <span class="btn-text">Details</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No attempts found for this quiz.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </form>
    @endif

    <div class="rbt-team-modal modal fade rbt-modal-default"
         id="quizResultDetails"
         tabindex="-1"
         aria-labelledby="quizResultDetails"
         wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="feather-x"></i>
                    </button>
                    <h5 class="modal-title">Quiz Result Details</h5>
                </div>

                <div class="modal-body">
                    @if($selectedAttempt)
                        <div class="inner">
                            <ul class="mb-0">
                                <li class="m-0">Question count:
                                    <strong>{{ $selectedAttempt->total_questions_count }}</strong></li>
                                <li class="m-0">Correct count:
                                    <strong>{{ $selectedAttempt->correct_answers_count }}</strong></li>
                                <li class="m-0">Score:
                                    <strong>{{ number_format($selectedAttempt->assessmentAttempt->total_score, 1) }}</strong>
                                </li>

                                <li class="m-0">
                                <span @class([
                                    'rbt-badge-5',
                                    'bg-color-success-opacity color-success' => $selectedAttempt->assessmentAttempt->is_passed,
                                    'bg-color-danger-opacity color-danger' => !$selectedAttempt->assessmentAttempt->is_passed
                                ])>
                                    {{ $selectedAttempt->assessmentAttempt->is_passed ? 'Pass' : 'Fail' }}
                                </span>
                                </li>
                            </ul>

                            <div class="rbt-dashboard-table table-responsive mobile-table-750 mt--30 quiz-result-enter quiz-result-enter-active">
                                <table class="rbt-table rbt-table-scroll table table-borderless">
                                    <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Question</th>
                                        <th>Your Answer</th>
                                        <th>Explanation</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($selectedAttempt->answers as $key => $answer)
                                        <tr>
                                            <td>
                                            <span
                                                @class([
                                                    'rbt-badge-5', 'bg-color-success-opacity color-success' => $answer['is_correct'],
                                                    'bg-color-danger-opacity color-danger' => !$answer['is_correct']
                                                ])>
                                                {{ $answer['is_correct'] ? 'Correct' : 'Incorrect' }}
                                            </span>
                                            </td>
                                            <td>
                                                <p class="b3">{{ $answer['user_answers'][0]['question']}}</p>
                                            </td>
                                            <td>
                                                @if(count($answer['user_answers']) > 1)
                                                    <ul class="m-0">
                                                        @foreach($answer['user_answers'] as $detail)
                                                            <li @class(['m-0', 'text-danger' => !$detail['is_correct'], 'text-success' => $detail['is_correct']])>{{ $detail['content'] }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p @class(['m-0', 'text-danger' => !$answer['is_correct'], 'text-success' => $answer['is_correct']])>{{ $answer['user_answers'][0]['content'] }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if(count($answer) > 1)
                                                    <ul class="m-0">
                                                        @foreach($answer['user_answers'] as $detail)
                                                            <li class="m-0">{{ $detail['explanation'] }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="b3">{{ $answer['user_answers'][0]['explanation'] }}</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="py-5 text-center">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-3 mb-0">Loading...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-attempt-modal', () => {
                const el = document.getElementById('quizResultDetails');
                if (!el) return;
                const modal = bootstrap.Modal.getOrCreateInstance(el);
                modal.show();
            });
        });
    </script>
@endpush
