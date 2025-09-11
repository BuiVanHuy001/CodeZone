<?php

namespace App\Livewire\Client\CourseCreation;

use App\Services\CourseCreation\CreateCourseService;
use App\Traits\HasErrors;
use App\Validator\CourseInfoValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\WithFileUploads;
use Throwable;

#[Title('Create New Course')]
class Index extends Component {
    use WithFileUploads, HasErrors;

    public string $title = '';
    public string $slug = '';
    public string $heading = '';
    public string $description = '';
    public $thumbnail;
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
    public array $modules = [];
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

    public function mount(): void
    {
        $this->messages = CourseInfoValidator::$MESSAGES;
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
        if ($propertyName === 'title') {
            $this->slug = Str::slug($this->title);
        }
    }

    /**
     * @throws Throwable
     */
    public function store(CreateCourseService $createCourseService): void
    {
        $this->validateFields();
        DB::beginTransaction();
        try {
            $createCourseService->storeCourse([
                'title' => $this->title,
                'slug' => $this->slug,
                'heading' => $this->heading,
                'description' => $this->description,
                'thumbnail' => $this->thumbnail,
                'price' => $this->price,
                'category' => $this->category,
                'level' => $this->level,
                'requirements' => $this->requirements,
                'skills' => $this->skills,
                'modules' => $this->modules,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'membersAssigned' => $this->membersAssigned,
            ]);
            DB::commit();

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Course created successfully',
                'showConfirmButton' => true,
            ]);

            $this->dispatch('course-creation-submitted');
            $this->handleRedirect(true);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Something went wrong while creating the builders: ' . $e->getMessage(),
                'showConfirmButton' => true,
            ]);
            $this->handleRedirect(false);
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
                'html' => 'Please fix the errors and try again. <br/>' . $this->prepareRenderErrors($e),
                'showConfirmButton' => true,
            ]);

            throw $e;
        }
    }

    #[On('thumbnail-upload-error')]
    public function handleThumbnailUploadError(string $message): void
    {
        $this->addError('thumbnail', $message);
    }

    private function handleRedirect(bool $isSuccess): RedirectResponse|Redirector
    {
        if ($isSuccess) {
            if (auth()->user()->isOrganization()) {
                return redirect()
                    ->route('organization.dashboard.overview')
                    ->with('swal', [
                        'title' => 'Course Created',
                        'text' => 'Your course has been created successfully.',
                        'icon' => 'success',
                        'timer' => 3000,
                    ]);
            } else {
                return redirect()
                    ->route('instructor.dashboard.index')
                    ->with('swal', [
                        'title' => 'Course Created',
                        'text' => 'Your course has been created successfully.',
                        'icon' => 'success',
                        'timer' => 3000,
                    ]);
            }
        }
        return redirect()->back();
    }

    #[Layout('components.layouts.app')]
    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.index');
    }
}
