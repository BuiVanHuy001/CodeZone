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
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Create New Course')]
class Index extends Component {
    use WithFileUploads;

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
    public array $employeesAssigned = [];
    public $startDate = '';
    public $endDate = '';
    public array $modules = [
        [
            'title' => 'Bui Van Huy',
            'lesson_count' => 1,
            'lessons' => [
            ]
        ]
    ];

    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:courses,slug',
            'heading' => 'required|min:3|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|exists:categories,id',
            'level' => ['required', Rule::in(Course::$LEVELS)],
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate',
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|min:3|max:255',
            'modules.*.lessons' => 'required|array|min:1',
            'modules.*.lessons.*.title' => 'required|min:3|max:255',
            'modules.*.lessons.*.type' => ['required', Rule::in(Lesson::$TYPES)],
        ];
    }

    public array $messages = [
        'title.required' => 'Course title is required to identify this course.',
        'title.min' => 'Course title must be at least :min characters for clarity.',
        'title.max' => 'Course title cannot exceed :max characters to ensure proper display.',

        'slug.required' => 'Course URL slug is required for web accessibility.',
        'slug.min' => 'Course slug must be at least :min characters.',
        'slug.max' => 'Course slug cannot exceed :max characters.',
        'slug.unique' => 'This course URL already exists. Please choose a different slug.',

        'heading.required' => 'Course heading is required for course presentation.',
        'heading.min' => 'Course heading must be at least :min characters for clarity.',
        'heading.max' => 'Course heading cannot exceed :max characters to ensure proper display.',

        'description.max' => 'Course description cannot exceed :max characters.',

        'price.required' => 'Course price must be specified.',
        'price.numeric' => 'Course price must be a valid number.',
        'price.min' => 'Course price cannot be negative.',

        'category.required' => 'Course category must be selected.',
        'category.exists' => 'Selected category does not exist. Please choose a valid category.',

        'level.required' => 'Course difficulty level must be specified.',
        'level.in' => 'Please select a valid course level from the available options.',

        'startDate.required' => 'Course start date is required.',
        'startDate.date' => 'Please enter a valid start date.',
        'startDate.after_or_equal' => 'Course start date cannot be in the past.',

        'endDate.required' => 'Course end date is required.',
        'endDate.date' => 'Please enter a valid end date.',
        'endDate.after_or_equal' => 'Course end date must be after or equal to the start date.',

        'modules.required' => 'At least one module must be created for this course.',
        'modules.min' => 'Course must contain at least :min module.',
        'modules.*.title.required' => 'Module title is required for each learning section.',
        'modules.*.title.min' => 'Module title must be at least :min characters for clarity.',
        'modules.*.title.max' => 'Module title cannot exceed :max characters to ensure proper display.',

        'modules.*.lessons.required' => 'Each module must contain at least one lesson.',
        'modules.*.lessons.min' => 'Each module must have at least :min lesson.',
        'modules.*.lessons.*.title.required' => 'Lesson title is required for each learning unit.',
        'modules.*.lessons.*.title.min' => 'Lesson title must be at least :min characters for clarity.',
        'modules.*.lessons.*.title.max' => 'Lesson title cannot exceed :max characters to ensure proper display.',
        'modules.*.lessons.*.type.required' => 'Lesson type must be selected to define the content format.',
        'modules.*.lessons.*.type.in' => 'Please select a valid lesson type from the available options.',
    ];

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function updatedTitle(): void
    {
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

    public function save()
    {
        if ($this->image) {
            $this->image->storePublicly(path: 'course/thumbnails', options: 'public');
            File::delete(storage_path('app/private/course/thumbnails/' . $this->image->getFileName()));
            File::delete($this->image->getRealPath());
        }
        $this->updateJsonFromMultilineInput('skills');
        $this->updateJsonFromMultilineInput('requirements');
        //        $this->validateFields();

        dd([
            'title' => $this->title,
            'slug' => $this->slug,
            'heading' => $this->heading,
            'description' => $this->description,
            'price' => $this->price,
            'category' => $this->category,
            'level' => $this->level,
            'requirements' => $this->requirementsJson,
            'skills' => $this->skillsJson,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'modules' => $this->modules,
            'employeesAssigned' => $this->employeesAssigned,
            'imageUrl' => $this->imageUrl,
        ]);
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
                        'video_url' => $lessonData['video_url'],
                        'document' => $lessonData['content'], // Fix: Use 'content' for a document
                        'preview' => $lessonData['preview'] ?? false,
                        'position' => $lessonKey,
                        'module_id' => $module->id
                    ]);

                    if (isset($lessonData['assessments'])) {
                        $assessmentData = $lessonData['assessments'];
                        $assessment = Assessment::create([
                            'title' => $assessmentData['title'],
                            'description' => $assessmentData['description'],
                            'type' => $assessmentData['type'],
                            'lesson_id' => $lesson->id
                        ]);
                        if ($assessmentData['type'] === 'quiz') {
                            $assessment->questions_count = count($assessmentData['assessments_questions']);
                            $assessment->save();
                            foreach ($assessmentData['assessments_questions'] as $questionKey => $question) {
                                $assessmentQuestion = AssessmentQuestion::create([
                                    'content' => $question['content'],
                                    'type' => $question['type'],
                                    'position' => $questionKey + 1,
                                    'assessment_id' => $assessment->id
                                ]);
                                foreach ($question['question_options'] as $optionKey => $option) {
                                    $assessmentQuestion->options()->create([
                                        'content' => $option['content'],
                                        'is_correct' => $option['is_correct'] ?? false,
                                        'explanation' => $option['explanation'] ?? '',
                                        'position' => $optionKey
                                    ]);
                                }
                            }
                        }
                        if ($assessmentData['type'] === 'programming') {
                            ProgrammingAssignmentDetails::create([
                                'assessment_id' => $assessment->id,
                                'function_name' => $assessmentData['problem_details']['function_name'],
                                'code_templates' => $assessmentData['problem_details']['code_templates'],
                                'test_cases' => $assessmentData['problem_details']['test_cases']
                            ]);
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
                $course->enrollment_count = count($this->employeesAssigned);
                foreach ($this->employeesAssigned as $employeeId) {
                    BatchEnrollments::create([
                        'batch_id' => $batch->id,
                        'user_id' => $employeeId,
                        'status' => 'not_started'
                    ]);
                }
            }
            $course->save();
            DB::commit();
            if (auth()->user()->isOrganization()) {
                return redirect()
                    ->route('organization.dashboard.overview')
                    ->with('swal', 'Course created successfully!');
            }
            return redirect()
                ->route('instructor.dashboard.index')
                ->with('swal', 'Course created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Something went wrong while creating the builders: ' . $e->getMessage(),
                'showConfirmButton' => true,
            ]);
            return redirect()->back()->with('swal', 'Something went wrong while creating the builders');
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
                    $this->prepareDisplayErrors($e->validator->errors()->toArray()),
                'showConfirmButton' => true,
            ]);

            throw $e;
        }
    }

    private function prepareDisplayErrors(array $errors): string
    {
        $html = '<ul>';
        foreach ($errors as $field => $messages) {
            $html .= '<li>' . $field . ': ' . implode(', ', $messages) . '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    #[Layout('components.layouts.app')]
    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.index');
    }
}
