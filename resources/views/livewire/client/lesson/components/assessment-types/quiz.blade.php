<div class="content">
    @if($results !== [])
        <div class="section-title">
            <p class="mb--10">Quiz</p>
            <h5>{{ $quiz->title }}</h5>
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
                        <p class="b3 mb--5">Just now</p>
                    </th>
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
                            <p class="b3">{{ $attempt['total_questions_count'] }}</p>
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
                            <button class="rbt-btn btn-border rbt-sm-btn-2" type="button"
                                    wire:click="viewAttemptDetails({{ $attempt['id'] }})">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Details</span>
                                </span>
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
    @else
        <form wire:submit.prevent="quizSubmit" x-data="{currentQuestion: 1 }" class="quiz-form-wrapper">
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
                                                id="{{ $isMultipleChoice ? "rbt-checkbox-$option->id" : "rbt-radio-{$question->id}-$option->id" }}"
                                                name="{{ $isMultipleChoice ? "answers[{$question->id}][]" : "answers[{$question->id}]" }}"
                                                wire:click="addAnswers({{ $question->id }}, {{ $option->id }})"
                                                type="{{ $isMultipleChoice ? 'checkbox' : 'radio' }}"
                                                class="{{ $isMultipleChoice ? '' : 'form-check-input' }}"
                                            >
                                            <label
                                                class="{{ $isMultipleChoice ? '' : 'form-check-label' }}"
                                                for="{{ $isMultipleChoice ? "rbt-checkbox-$option->id" : "rbt-radio-{$question->id}-$option->id" }}"
                                            >
                                                {{ $option->content }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-lg-6">
                                    <div class="rbt-form-check">
                                        <input class="form-check-input" type="radio" name="rbt-single-select" id="rbt-single-select-10"><label class="form-check-label" for="rbt-single-select-10">True</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="rbt-form-check">
                                        <input class="form-check-input" type="radio" name="rbt-single-select" id="rbt-single-select-20"><label class="form-check-label" for="rbt-single-select-20">False</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="rbt-quiz-btn-wrapper mt--30">
                <button
                    class="rbt-btn bg-primary-opacity btn-sm"
                    id="prev-btn"
                    type="button"
                    x-on:click="currentQuestion = Math.max(currentQuestion - 1, 1)"
                    x-bind:disabled="currentQuestion === 1">
                    Previous
                </button>
                <button
                    class="rbt-btn bg-primary-opacity btn-sm"
                    id="next-btn"
                    type="button"
                    x-on:click="currentQuestion = Math.min(currentQuestion + 1, {{ $quiz->questions_count }})"
                    x-bind:disabled="currentQuestion === {{ $quiz->questions_count }}">
                    Next
                </button>
                <button
                    type="submit"
                    class="rbt-btn btn-gradient btn-sm"
                    id="submit-btn"
                    x-show="currentQuestion === {{ $quiz->questions_count }}"
                    style="display: none;">
                    Submit
                </button>
            </div>
        </form>
    @endif

</div>
