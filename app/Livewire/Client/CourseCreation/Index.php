<?php

namespace App\Livewire\Client\CourseCreation;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\Batch;
use App\Models\BatchEnrollments;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\ProgrammingAssignmentDetails;
use App\Traits\HasErrors;
use App\Validator\CourseInfoValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

#[Title('Create New Course')]
class Index extends Component {
    use WithFileUploads, HasErrors;

    public string $title = '';
    public string $slug = '';
    public string $heading = '';
    public string $description = '';
    public $image;
    public $imageUrl;
    public ?string $previousImagePath = null;
    public string $price = '0';
    public string $category = '';
    public string $level = '';
    public string $requirements = '';
    public $requirementsJson = null;
    public string $skills = '';
    private $skillsJson = null;
    public array $membersAssigned = [];
    public $startDate = '';
    public $endDate = '';
    public array $modules = [
        [
            'title' => 'Module 1',
            'lessons' => [
                [
                    'title' => 'Lesson 1',
                    'type' => 'document',
                    'document' => 'This is a lesson content',
                    'preview' => false,
                    'duration' => 0,
                    'video_file_name' => '',
                    'assessment' => [],
                    'practice_assessments' => [],
                ]
            ]
        ]
    ];
    public string $activeCourseSettingTab = 'general';

    public function setTab(string $tab): void
    {
        $this->activeCourseSettingTab = $tab;
    }

    public function rules(): array
    {
        return CourseInfoValidator::rules();
    }

    public array $messages;

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function mount(): void
    {
        $this->messages = CourseInfoValidator::$MESSAGES;
    }

    public function updatedTitle(): void
    {
        $this->validateOnly('title');
        $this->slug = Str::slug($this->title);
    }

    private function updateJsonFromMultilineInput(string $field): void
    {
        $lines = array_filter(array_map(
                'trim',
                explode("\n", $this->$field)
            )
        );
        if (empty($lines)) {
            $this->{$field . 'Json'} = null;
        } else {
            $this->{$field . 'Json'} = json_encode(array_values(array_map(fn($item) => ['name' => $item], $lines)));
        }
    }

    public function updatedImage(): void
    {
        if ($this->image && $this->previousImagePath) {
            File::delete($this->previousImagePath);
        }

        $this->previousImagePath = $this->image->getRealPath();

        $this->imageUrl = $this->image->temporaryUrl();
    }

    public function deleteImage(): void
    {
        if ($this->image) {
            File::delete($this->image->getRealPath());
            $this->reset('image', 'imageUrl', 'previousImagePath');
        }
    }

    /**
     * @throws Throwable
     */
    public function save(): RedirectResponse
    {
        dd($this->membersAssigned);
        if ($this->image) {
            $this->image->storePublicly(path: 'course/thumbnails', options: 'public');
            File::delete($this->image->getRealPath());
        }
        $this->updateJsonFromMultilineInput('skills');
        $this->updateJsonFromMultilineInput('requirements');
        $this->validateFields();
        DB::beginTransaction();
        try {
            $courseDuration = 0;
            $lessonCount = 0;
            $course = Course::create([
                'title' => $this->title,
                'heading' => $this->heading,
                'description' => $this->description,
                'thumbnail_url' => $this->imageUrl,
                'price' => $this->price ?? 0,
                'review_count' => 0,
                'lesson_count' => $lessonCount,
                'level' => $this->level,
                'duration' => $courseDuration,
                'status' => 'pending',
                'category_id' => $this->category,
                'requirements' => $this->requirementsJson,
                'skills' => $this->skillsJson,
                'user_id' => auth()->user()->id,
            ]);
            foreach ($this->modules as $moduleIndex => $moduleData) {
                $moduleDuration = 0;
                $moduleLessonCount = count($moduleData['lessons']);
                $lessonCount += $moduleLessonCount;

                $module = Module::create([
                    'title' => $moduleData['title'],
                    'lesson_count' => $moduleLessonCount,
                    'position' => $moduleIndex,
                    'duration' => 0,
                    'course_id' => $course->id,
                ]);

                foreach ($moduleData['lessons'] as $lessonKey => $lessonData) {
                    $moduleDuration += $lessonData['duration'] ?? 0;
                    $lesson = Lesson::create([
                        'title' => $lessonData['title'],
                        'type' => $lessonData['type'],
                        'duration' => $lessonData['duration'] ?? 0,
                        'video_file_name' => $lessonData['video_file_name'],
                        'document' => $lessonData['document'],
                        'preview' => $lessonData['preview'],
                        'position' => $lessonKey + 1,
                        'module_id' => $module->id
                    ]);

                    if (isset($lessonData['assessment'])) {
                        $this->storeAssessment($lessonData['assessment'], $lesson->id);
                    } elseif (isset($lessonData['practice_assessments'])) {
                        foreach ($lessonData['practice_assessments'] as $practiceAssessment) {
                            $this->storeAssessment($practiceAssessment, $lesson->id);
                        }
                    }
                }
                $module->duration = $moduleDuration;
                $module->save();
                $courseDuration += $moduleDuration;
            }
            $course->duration = $courseDuration;
            $course->lesson_count = $lessonCount;

            if (auth()->user()->isOrganization()) {
                $batch = Batch::create([
                    'start_at' => $this->startDate,
                    'end_at' => $this->endDate,
                    'course_id' => $course->id
                ]);
                $course->enrollment_count = count($this->membersAssigned);
                foreach ($this->membersAssigned as $employeeId) {
                    BatchEnrollments::create([
                        'batch_id' => $batch->id,
                        'user_id' => $employeeId,
                        'status' => 'not_started'
                    ]);
                }
            }
            $course->save();
            DB::commit();
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Course created successfully',
                'showConfirmButton' => true,
            ]);
            if (auth()->user()->isOrganization()) {
                return redirect()
                    ->route('organization.dashboard.overview')
                    ->with('swal', [
                        'title' => 'Course Created',
                        'text' => 'Your course has been created successfully.',
                        'icon' => 'success',
                        'timer' => 3000,
                    ]);
            }
            return redirect()
                ->route('instructor.dashboard.index')
                ->with('swal', [
                    'title' => 'Course Created',
                    'text' => 'Your course has been created successfully.',
                    'icon' => 'success',
                    'timer' => 3000,
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating course: ' . $e->getMessage());
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Something went wrong while creating the builders: ' . $e->getMessage(),
                'showConfirmButton' => true,
            ]);
            return redirect()->back();
        }
    }

    private function storeAssessment(array $assessmentData, string|int $lessonId): void
    {
        if ($assessmentData['type'] === 'quiz') {
            $questionCount = count($assessmentData['assessments_questions']);
        }

        $assessment = Assessment::create([
            'title' => $assessmentData['title'],
            'description' => $assessmentData['description'],
            'type' => $assessmentData['type'],
            'lesson_id' => $lessonId,
            'questions_count' => $questionCount ?? 1,
        ]);
        $assessment->save();

        match ($assessmentData['type']) {
            'quiz' => $this->storeQuiz($assessmentData['assessments_questions'], $assessment->id),
            'programming' => $this->storeProgrammingPractice($assessmentData, $lessonId),
            default => null,
        };
    }

    private function storeProgrammingPractice(array $programmingPracticeData, string|int $lessonId): void
    {
        ProgrammingAssignmentDetails::create([
            'assessment_id' => $lessonId,
            'function_name' => $programmingPracticeData['problem_details']['function_name'],
            'code_templates' => $programmingPracticeData['problem_details']['code_templates'],
            'test_cases' => $programmingPracticeData['problem_details']['test_cases']
        ]);
    }

    private function storeQuiz(array $questions, string|int $assessmentId): void
    {
        foreach ($questions as $index => $question) {
            $assessmentQuestion = AssessmentQuestion::create([
                'content' => $question['content'],
                'type' => $question['type'],
                'position' => $index + 1,
                'assessment_id' => $assessmentId
            ]);
            foreach ($question['question_options'] as $optionIndex => $option) {
                $assessmentQuestion->options()->create([
                    'assessment_question_id' => $assessmentQuestion->id,
                    'content' => $option['content'],
                    'is_correct' => $option['is_correct'] ?? false,
                    'explanation' => $option['explanation'] ?? '',
                    'position' => $optionIndex + 1
                ]);
            }
        }
    }

    private function validateFields(): void
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Validation Failed',
                'html' => 'Please fix the errors and try again. <br/>' .
                    $this->prepareRenderErrors($e),
                'showConfirmButton' => true,
            ]);

            throw $e;
        }
    }

    #[Layout('components.layouts.app')]
    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.index');
    }
}
