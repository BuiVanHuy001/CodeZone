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
                    <th>Result</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <p class="b3">{{ $totalQuestions }}</p>
                    </td>
                    <td>
                        <p class="b3">{{ $results['correct_answers_count'] }}</p>
                    </td>
                    <td>
                        <p class="b3">{{ $totalQuestions - $results['correct_answers_count'] }}</p>
                    </td>
                    <td>
                        <span class="rbt-badge-5 bg-color-success-opacity color-{{ $results['is_passed'] ? 'success' : 'danger' }}">{{ $results['is_passed'] ? 'Pass' : 'Fail' }}</span>
                    </td>
                    <td>
                        <button class="rbt-btn btn-border rbt-sm-btn-2"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#attempt-details-modal">
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">Details</span>
                            </span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        @if($canNextLesson)
            <button wire:click="redirectToNextLesson" class="rbt-btn btn-border rbt-sm-btn-2"
                    type="button">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Next lesson</span>
                    </span>
            </button>
        @endif

        @if(isset($resultDetails))
            <div class="rbt-team-modal modal fade rbt-modal-default"
                 id="attempt-details-modal"
                 tabindex="-1"
                 aria-labelledby="attempt-details-modal"
                 wire:ignore.self>
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i class="feather-x"></i>
                            </button>
                            <h5 class="modal-title">Quiz Result Details</h5>
                        </div>

                        <div class="modal-body">
                            <div class="inner">
                                <ul class="mb-0">
                                    <li class="m-0">Question count:
                                        <strong>{{ $totalQuestions }}</strong>
                                    </li>
                                    <li class="m-0">Correct count:
                                        <strong>{{ $results['correct_answers_count'] }}</strong>
                                    </li>

                                    <li class="m-0">
                                <span @class([
                                    'rbt-badge-5',
                                    'bg-color-success-opacity color-success' => $results['is_passed'],
                                    'bg-color-danger-opacity color-danger' => !$results['is_passed']
                                ])>
                                    {{ $results['is_passed'] ? 'Pass' : 'Fail' }}
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
                                        @foreach($resultDetails as $key => $question)
                                            <tr>
                                                <td>
                                            <span
                                                @class([
                                                    'rbt-badge-5', 'bg-color-success-opacity color-success' => $question['is_question_correct'],
                                                    'bg-color-danger-opacity color-danger' => !$question['is_question_correct']
                                                ])>
                                                {{ $question['is_question_correct'] ? 'Correct' : 'Incorrect' }}
                                            </span>
                                                </td>
                                                <td>
                                                    <p class="b3">{{ $question['question_content'] }}</p>
                                                </td>
                                                <td>
                                                    @if(count($question['selected_answers']) > 1)
                                                        <ul class="m-0">
                                                            @foreach($question['selected_answers'] as $detail)
                                                                <li @class(['m-0', 'text-danger' => !$detail['is_correct'], 'text-success' => $detail['is_correct']])>{{ $detail['content'] }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p @class(['m-0', 'text-danger' => !$question['is_question_correct'], 'text-success' => $question['is_question_correct']])>
                                                            {{ $question['selected_answers'][0]['content'] ?? 'No answer selected' }}
                                                        </p>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(count($question['selected_answers']) > 1)
                                                        <ul class="m-0">
                                                            @foreach($question['selected_answers'] as $detail)
                                                                <li class="m-0">{{ $detail['explanation'] }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <p class="b3">{{ $question['selected_answers'][0]['explanation'] ?? 'No explanation available' }}</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <form wire:submit.prevent="quizSubmit"
              class="quiz-form-wrapper">
            <div wire:show="isShowPreviousAttempts">
                <div class="section-title">
                    <h5>{{ $quiz->title }}</h5>
                </div>
                <p class="b3 mb--30">You have <strong>{{ $totalQuestions }}</strong> questions to answer.</p>

                <div id="course-document" class="markdown-body has-show-more">
                    <div class="has-show-more-inner-content">
                        @markdown($quiz->description)
                    </div>
                    <div class="rbt-show-more-btn">Show More</div>
                </div>
            </div>
            <div id="question" wire:show="!isShowPreviousAttempts">
                <div class="quize-top-meta">
                    <div class="quize-top-left">
                        <span>Questions No: <strong>{{ $currentIndexQuestion + 1 . '/' . $totalQuestions }}</strong></span>
                    </div>
                </div>
                <hr>
                <div class="rbt-single-quiz">
                    <h4>{{ $currentQuestion['content'] }}</h4>
                    <div class="row g-3 mt--10">
                        @foreach($currentQuestion['options'] as $optionIndex => $option)
                            <div class="col-lg-6">
                                <div class="{{ $currentQuestion['is_multiple_answers'] ? 'rbt-checkbox-wrapper mb--5' : 'rbt-form-check' }}">
                                    <input
                                        id="{{ $currentQuestion['is_multiple_answers'] ? "rbt-checkbox-{$currentQuestion['id']}-{$optionIndex}" : "rbt-radio-{$currentQuestion['id']}-{$optionIndex}" }}"
                                        name="{{ $currentQuestion['is_multiple_answers'] ? "answers[{$currentQuestion['id']}][]" : "answers[{$currentQuestion['id']}]" }}"
                                        wire:click="addAnswers({{ $currentQuestion['id'] }}, {{ $optionIndex }})"
                                        type="{{ $currentQuestion['is_multiple_answers'] ? 'checkbox' : 'radio' }}"
                                        class="{{ $currentQuestion['is_multiple_answers'] ? '' : 'form-check-input' }}"
                                        @if($currentQuestion['is_multiple_answers'])
                                            @if(isset($userAnswers[$currentQuestion['id']]) && in_array($option['content'], $userAnswers[$currentQuestion['id']]))
                                                checked
                                        @endif
                                        @else
                                            @if(isset($userAnswers[$currentQuestion['id']]) && in_array($option['content'], $userAnswers[$currentQuestion['id']]))
                                                checked
                                        @endif
                                        @endif
                                    >
                                    <label
                                        class="{{ $currentQuestion['is_multiple_answers'] ? '' : 'form-check-label' }}"
                                        for="{{ $currentQuestion['is_multiple_answers'] ? "rbt-checkbox-{$currentQuestion['id']}-{$optionIndex}" : "rbt-radio-{$currentQuestion['id']}-{$optionIndex}" }}"
                                    >
                                        {{ $option['content'] }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="rbt-quiz-btn-wrapper mt--30">
                @if($isShowQuestionNavigator)
                    @if($canBack)
                        <button class="rbt-btn bg-primary-opacity btn-sm" id="prev-btn" type="button" wire:click="prevQuestion">
                            Previous
                        </button>
                    @endif

                    @if($canNext)
                        <button class="rbt-btn bg-primary-opacity btn-sm" id="next-btn" type="button" wire:click="nextQuestion">
                            Next
                        </button>
                    @endif
                @else
                    @if($isCompleted)
                        <button class="rbt-btn btn-sm hover-icon-reverse"
                                wire:click="startQuiz"
                                type="button"
                        >
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">Retry Quiz</span>
                            <span class="btn-icon"><i class="feather-refresh-cw"></i></span>
                            <span class="btn-icon"><i class="feather-refresh-cw"></i></span>
                            </span>
                        </button>
                    @else
                        <button type="button"
                                class="rbt-btn btn-gradient btn-sm"
                                id="start-btn"
                                wire:click="startQuiz">
                            Start Quiz
                        </button>
                    @endif
                @endif

                @if($canSubmit)
                    <button type="submit"
                            class="rbt-btn btn-gradient btn-sm"
                            id="submit-btn"
                            wire:click="$set('isShowPreviousAttempts', true)">
                        Submit
                    </button>
                @endif

            </div>
        </form>
    @endif
</div>
