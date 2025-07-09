<?php

namespace App\Livewire\Client\Instructor;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        return ['title' => 'required|min:3|max:255', 'slug' => 'required|min:3|max:255|unique:courses,slug', 'heading' => 'required|min:3|max:255', 'description' => 'nullable|max:1000', 'image' => 'nullable|image|max:2048', 'price' => 'required|numeric|min:0', 'category' => 'required|exists:categories,id', 'level' => 'required|in:beginner,intermediate,advanced'];
    }

    public string $title = '';
    public string $slug = '';
    public string $heading = '';
    public string $description = '';
    public $image;
    public $imageUrl;
    public string $price = '';
    public string $category = '';
    public string $level = '';
    public string $requirements = '';
    public $requirementsJson = null;
    public string $skills = '';
    private $skillsJson = null;

    public array $modules = [['title' => 'Module 1', 'position' => 1, 'lessons' => [['title' => 'Lesson 1', 'position' => 1, 'type' => 'video', 'description' => '', 'video_url' => '', 'content' => '', 'preview' => false, 'duration' => 0,],]]];

    #[On('titleUpdated')]
    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    private function updateJsonFromMultilineInput(string $field): void
    {
        $lines = array_filter(array_map('trim', explode("\n", $this->$field)));
        if (empty($lines)) {
            $this->{$field . 'Json'} = null;
        } else {
            $this->{$field . 'Json'} = json_encode(array_values(array_map(fn($item) => ['name' => $item], $lines)));
        }
    }


	public function updatedImage(): void
    {
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
            $course = Course::create(['title' => $this->title, 'heading' => $this->heading, 'description' => $this->description, 'thumbnail_url' => $this->imageUrl, 'price' => $this->price, 'review_count' => 0, 'lesson_count' => 0, // Will be updated later
                'level' => $this->level, 'duration' => 0, // Will be updated later
                'status' => 'pending', 'category_id' => $this->category, 'requirements' => $this->requirementsJson, 'skills' => $this->skillsJson, 'user_id' => auth()->id(),]);
            foreach ($this->modules as $moduleData) {
                $moduleDuration = 0;
                $module = Module::create(['title' => $moduleData['title'], 'lesson_count' => count($moduleData['lessons']), 'position' => $moduleData['position'], 'duration' => 0, // Will be updated later
                    'course_id' => $course->id,]);
                foreach ($moduleData['lessons'] as $lessonData) {
                    $moduleDuration += $lessonData['duration'];
                    $lesson = Lesson::create(['title' => $lessonData['title'], 'type' => $lessonData['type'], 'duration' => $lessonData['duration'], 'video_url' => $lessonData['video_url'], 'content' => $lessonData['content'], 'preview' => $lessonData['preview'] ?? false, 'position' => $lessonData['position'], 'module_id' => $module->id,]);

                    if (isset($lessonData['assessments'])) {
                        $assessmentData = $lessonData['assessments'];
                        $assessment = Assessment::create(['title' => $assessmentData['title'], 'description' => $assessmentData['description'], 'type' => $assessmentData['type'], 'questions_count' => count($assessmentData['assessments_questions']), 'lesson_id' => $lesson->id,]);
                        if ($assessmentData['type'] === 'file_upload') {
                            AssessmentQuestion::create(['content' => $assessmentData['description'], 'type' => $assessmentData['type'], 'assessment_id' => $assessment->id,]);
                        } else {
                            foreach ($assessmentData['assessments_questions'] as $key => $question) {
                                $assessmentQuestion = AssessmentQuestion::create(['content' => $question['content'], 'type' => $question['type'], 'position' => $key + 1, 'assessment_id' => $assessment->id,]);
                                foreach ($question['question_options'] as $option) {
                                    $assessmentQuestion->options()->create(['content' => $option['content'], 'is_correct' => $option['is_correct'] ?? false, 'explanation' => $option['explanation'] ?? '', 'position' => $option['position'] ?? 0,]);
                                }
                            }
                        }
                    }
                }
                $module->duration = $moduleDuration;
                $module->save();
                $courseDuration += $moduleDuration;
            }
            $course->duration = $courseDuration;
            $course->lesson_count = Lesson::where('module_id', $module->id)->count();
            $course->save();


            DB::commit();
            return redirect()->route('instructor.dashboard.index')->with('sweetalert2', 'Course created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('sweetalert2', 'Something went wrong while creating the course');
        }
    }


    public function render(): Factory|Application|View
    {
        return view('livewire.client.instructor.create-course');
    }
}
