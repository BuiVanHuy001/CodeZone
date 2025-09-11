<?php

namespace App\Livewire\Client\CourseCreation\Components;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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
    public string $imagePreview;

    /**
     * @throws Exception
     */
    public function updatedImage(): void
    {
        try {
            $this->validate(['image' => 'image|mimes:jpeg,png,jpg,webp'], [
                'image.image' => 'The file must be an image.',
                'image.mimes' => 'The file must be a file of type: jpeg, png, jpg, webp.',
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
        if (Storage::disk('local')->exists('livewire-tmp/' . $this->thumbnail)) {
            $this->image->storeAs(
                path: 'course/thumbnails',
                options: 'public',
                name: $this->thumbnail
            );
            $this->deleteImage();
        }
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.course-thumbnail');
    }
}
