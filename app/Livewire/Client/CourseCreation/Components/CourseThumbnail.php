<?php

namespace App\Livewire\Client\CourseCreation\Components;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class CourseThumbnail extends Component {
    use WithFileUploads;

    #[Modelable]
    public $thumbnail;

    public $image;
    public string $imagePreview = '';

    public function updatedImage(): void
    {
        try {
            $this->validate(['image' => 'image|mimes:jpeg,png,jpg,webp'], [
                'image.image' => 'Tệp tải lên phải là một hình ảnh.',
                'image.mimes' => 'Định dạng ảnh không hỗ trợ. Vui lòng dùng: jpeg, png, jpg, webp.',
            ]);
            $this->imagePreview = $this->image->temporaryUrl();
            $this->thumbnail = $this->image->getFilename();
        } catch (Exception $e) {
            $this->deleteImage();
            $this->dispatch('thumbnail-upload-error', message: $e->getMessage());
            throw $e;
        }
    }

    public function deleteImage(): void
    {
        if ($this->image) {
            File::delete($this->image->getRealPath());
            $this->reset('image', 'imagePreview', 'thumbnail');
        }
    }

    #[On('course-creation-submitted')]
    public function storeThumbnail(): void
    {
        if ($this->thumbnail && Storage::disk('local')->exists('livewire-tmp/' . $this->thumbnail)) {
            $this->image->storeAs(
                path: config('filesystems.paths.course.internal.thumbnail.pending'),
                name: $this->thumbnail,
                options: 'public'
            );
            $this->deleteImage();
        }
    }

    public function render(): View
    {
        return view('livewire.client.course-creation.components.course-thumbnail');
    }
}
