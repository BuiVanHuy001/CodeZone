<?php

namespace App\Livewire\Admin\Instructor\Components;

use App\Services\Admin\Instructor\InstructorService;
use App\Services\Cache\AcademicCache;
use App\Validator\InstructorValidator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateModal extends Component {
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public $avatar;
    public string $avatarLink = '';
    public string $gender = 'male';
    public $major_id = '';

    public Collection $faculties;

    public function mount(): void
    {
        $this->faculties = app(AcademicCache::class)->getCachedFacultiesWithMajors();
    }

    protected function rules(): array
    {
        return InstructorValidator::rules();
    }

    protected function messages(): array
    {
        return InstructorValidator::$MESSAGES;
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
        if ($propertyName === 'avatar' && $this->avatar) {
            $this->reset('avatarLink');
        }

        if ($propertyName === 'avatarLink' && !empty($this->avatarLink)) {
            $this->reset('avatar');
        }
    }

    public function generatePassword(): void
    {
        $this->password = Str::password(16, true, true, false);
    }

    public function storeInstructor(): void
    {
        $this->validate();
        app(InstructorService::class)->storeInstructor([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'avatar' => $this->avatar ? $this->avatar->store('avatars', 'public') : null,
            'avatarLink' => $this->avatarLink,
            'major_id' => $this->major_id,
            'gender' => $this->gender,
        ]);
    }

    public function render(): View
    {
        return view('livewire.admin.instructor.components.create-modal');
    }
}
