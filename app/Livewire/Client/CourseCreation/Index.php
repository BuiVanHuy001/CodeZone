<?php

namespace App\Livewire\Client\CourseCreation;

use App\Models\Course;
use App\Services\Client\Course\CourseService;
use App\Traits\WithSwal;
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

#[Title('Tạo khóa học mới')]
class Index extends Component
{
    use WithFileUploads, WithSwal;

    private CourseService $courseService;

    public string $title = '';
    public string $slug = '';
    public string $heading = '';
    public string $description = '';
    public $thumbnail;

    public string $courseType = 'internal';
    public string $price = '0';
    public string $category = '';
    public string $level = '';
    public string $requirements = '';
    public string $skills = '';
    public string $targetAudiences = '';
    public array $modules = [];

    public array $messages;

    public function boot(): void
    {
        $this->courseService = app(CourseService::class);
    }

    public function mount(): void
    {
        $this->messages = CourseInfoValidator::$MESSAGES;
    }

    #[On('thumbnail-upload-error')]
    public function handleThumbnailUploadError(string $message): void
    {
        $this->addError('thumbnail', 'Lỗi tải ảnh đại diện: ' . $message);
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
                'Lỗi xác thực',
                'Vui lòng kiểm tra lại các thông tin và thử lại:',
                $e->errors()
            );
            throw $e;
        }
    }

    public function store(): void
    {
        $this->validateFields();

        DB::beginTransaction();
        try {
            $this->courseService->storeCourse(
                auth()->user(),
                [
                    'title' => $this->title,
                    'slug' => $this->slug,
                    'heading' => $this->heading,
                    'description' => $this->description,
                    'thumbnail' => $this->thumbnail,
                    'price' => $this->price,
                    'courseType' => $this->courseType,
                    'category' => $this->category,
                    'level' => $this->level,
                    'requirements' => $this->requirements,
                    'targetAudiences' => $this->targetAudiences,
                    'skills' => $this->skills,
                    'modules' => $this->modules,
                ]
            );
            DB::commit();

            $this->dispatch('course-creation-submitted');
            $this->handleRedirect(true);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->swalError(
                'Lỗi hệ thống',
                'Có lỗi xảy ra trong quá trình khởi tạo khóa học:',
                $e->getMessage()
            );

            $this->handleRedirect(false);
        }
    }

    private function handleRedirect(bool $isSuccess): RedirectResponse|Redirector
    {
        if ($isSuccess) {
            return redirect()
                ->route('instructor.dashboard.index')
                ->with('swal', [
                    'title' => 'Tạo khóa học thành công',
                    'text' => 'Khóa học của bạn đã được khởi tạo thành công. Vui lòng chờ quản trị viên phê duyệt trước khi khóa học được hiển thị chính thức.',
                    'icon' => 'success',
                    'timer' => 5000,
                ]);
        }

        return redirect()->back();
    }

    #[Layout('components.layouts.app')]
    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.index');
    }
}
