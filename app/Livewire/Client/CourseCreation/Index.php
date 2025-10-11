<?php

namespace App\Livewire\Client\CourseCreation;

use App\Models\Course;
use App\Services\Course\ManagementService;
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

#[Title('Create New Course')]
class Index extends Component
{
    use WithFileUploads;

    public string $title = '';
    public string $slug = '';
    public string $heading = '';
    public string $description = '';
    public $thumbnail;

    public string $price = '0';
    public string $category = '';
    public string $level = '';
    public string $requirements = '';
    public string $skills = '';
    public string $targetAudiences;
    public array $membersAssigned = [];

    public $startDate = '';
    public $endDate = '';
    public array $modules = [];

    public string $activeCourseSettingTab = 'general';

    public array $messages;

    public function mount(): void
    {
        $this->messages = CourseInfoValidator::$MESSAGES;
    }

    #[Layout('components.layouts.app')]
    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.index');
    }

    #[On('thumbnail-upload-error')]
    public function handleThumbnailUploadError(string $message): void
    {
        $this->addError('thumbnail', $message);
    }

    public function rules(): array
    {
        return CourseInfoValidator::rules();
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'title') {
            $this->slug = Str::slug($this->title);
        }
    }

    private function validateFields(): void
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->swalError(
                'Validation Failed',
                'Please fix the errors and try again:',
                $e->getMessage()
            );
            throw $e;
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeCourseSettingTab = $tab;
    }

    public function store(ManagementService $managementService): void
    {
        $this->validateFields();

        DB::beginTransaction();
        try {
            $managementService->create(
                auth()->user(),
                [
                    'title' => $this->title,
                    'slug' => $this->slug,
                    'heading' => $this->heading,
                    'description' => $this->description,
                    'thumbnail' => $this->thumbnail,
                    'price' => $this->price,
                    'category' => $this->category,
                    'level' => Course::$LEVELS[$this->level],
                    'requirements' => $this->requirements,
                    'targetAudiences' => $this->targetAudiences,
                    'skills' => $this->skills,
                    'modules' => $this->modules,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                    'membersAssigned' => $this->membersAssigned,
                ]
            );
            DB::commit();

            $this->dispatch('course-creation-submitted');
            $this->handleRedirect(true);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->swalError(
                'Error',
                'Something went wrong while creating the builders:',
                $e->getMessage()
            );

            $this->handleRedirect(false);
        }
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
            }

            return redirect()
                ->route('instructor.dashboard.index')
                ->with('swal', [
                    'title' => 'Course Created',
                    'text' => 'Your course has been created successfully.',
                    'icon' => 'success',
                    'timer' => 3000,
                ]);
        }

        return redirect()->back();
    }
}
