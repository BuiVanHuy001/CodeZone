<?php

namespace App\Livewire\Client;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\BatchEnrollments;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\ProgrammingAssignmentDetails;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Create New Course')]
class CreateCourse extends Component
{
    use WithFileUploads;

    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:courses,slug',
            'heading' => 'required|min:3|max:255',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'category' => 'required|exists:categories,id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after_or_equal:startDate',
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|min:3|max:255',
            'modules.*.lessons' => 'required|array|min:1',
            'modules.*.lessons.*.title' => 'required|min:3|max:255',
            'modules.*.lessons.*.type' => ['required', Rule::in(Lesson::$TYPES)],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public array $openTabs = ['info'];

    public function setTab(string $tab): void
    {
        $key = array_search($tab, $this->openTabs);
        if ($key !== false) {
            unset($this->openTabs[$key]);
            $this->openTabs = array_values($this->openTabs);
        } else {
            $this->openTabs[] = $tab;
        }
    }

    public string $title = '';
    public string $slug = '';
    public string $heading = '';
    public string $description = '';
    public $image;
    public $imageUrl;
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
            'title' => '',
            'lesson_count' => 1,
            'lessons' => [
                [
                    'title' => '',
                    'type' => '',
                    'description' => '',
                    'video_url' => '',
                    'content' => '',
                    'preview' => false,
                ]
            ]
        ]
    ];


    #[On('titleUpdated')]
    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    private function updateJsonFromMultilineInput(string $field): void
    {
        $lines = array_filter(
	        array_map(
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
        $this->validate([
            'image' => 'nullable|image|max:2048',
        ]);
        if ($this->image) {
            $path = $this->image->storePublicly('tmp', 'public');
            $this->imageUrl = Storage::url($path);
        }
    }

    public function deleteImage(): void
    {
        if ($this->imageUrl) {
            $relativePath = str_replace('/storage/', '', $this->imageUrl);
            Storage::disk('public')->delete($relativePath);
            File::cleanDirectory(\storage_path('app/private/livewire-tmp'));
            $this->reset(['image', 'imageUrl',]);
        }
    }

    public function save()
    {
        $this->updateJsonFromMultilineInput('skills');
        $this->updateJsonFromMultilineInput('requirements');
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
                        'content' => $lessonData['content'],
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
                                'problem_details' => $assessmentData['problem_details'],
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
            if (auth()->user()->isBusiness()) {
	            $batch = Batch::create([
                    'start_at' => $this->startDate,
                    'end_at' => $this->endDate,
                    'course_id' => $course->id
                ]);
                $course->enrollment_count = count($this->employeesAssigned);
                foreach ($this->employeesAssigned as $employeeId) {
                    BatchEnrollments::create([
                        'batches_id' => $batch->id,
                        'user_id' => $employeeId,
                        'status' => 'not_started'
                    ]);
                }
            }
            $course->save();
            DB::commit();
            if (auth()->user()->isBusiness()) {
                return redirect()
                    ->route('business.dashboard.index')
                    ->with('sweetalert2', 'Course created successfully!');
            }
            return redirect()
                ->route('instructor.dashboard.index')
                ->with('sweetalert2', 'Course created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error creating course: ' . $e->getMessage());
            return redirect()->back()->with('sweetalert2', 'Something went wrong while creating the course');
        }
    }

    public function render(): Factory|Application|View
    {
        if (auth()->user()->isBusiness()) {
            return view('livewire.client.create-course')->layout('components.layouts.business-dashboard');
        }
        return view('livewire.client.create-course')->layout('components.layouts.instructor-dashboard');
    }
}
