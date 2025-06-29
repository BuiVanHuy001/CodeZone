<?php

namespace App\Livewire\Client\Instructor;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Create New Course')]
class CreateCourse extends Component
{
    use WithFileUploads;

    public function rules(): array
    {
        return ['title' => 'required|min:3|max:255', 'slug' => 'required|min:3|max:255|unique:courses,slug', 'heading' => 'required|min:3|max:255', 'description' => 'nullable|max:1000', 'image' => 'nullable|image|max:2048', 'price' => 'required|numeric|min:0', 'category' => 'required|exists:categories,id', 'level' => 'required|in:beginner,intermediate,advanced',];
    }

    public string $title = '';
    public string $slug = '';
    public string $heading = '';
    public string $description = '';
    public $image;
    public ?string $imagePath = null;
    public string $price = '';
    public string $category = '';
    public string $level = '';
    public string $requirements = '';
    public $requirementsJson = null;
    public string $skills = '';
    private $skillsJson = null;

    public array $modules = [['title' => 'Module 1', 'position' => 1, 'lessons' => [['title' => 'Lesson 1', 'position' => 1, 'description' => '', 'video_url' => '', 'content' => '', 'preview' => false,],]]];

    #[On('titleUpdated')]
    public function updatedTitle()
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


    public function updatedImage()
    {
        if ($this->image) {
            $this->imagePath = $this->image->store('tmp', 'public');
        }
    }

    public function deleteImage()
    {
        if ($this->imagePath && Storage::disk('public')->exists($this->imagePath)) {
            Storage::disk('public')->delete($this->imagePath);
        }

        $this->reset(['image', 'imagePath']);
    }

    public function save()
    {
        $this->updateJsonFromMultilineInput('skills');
        $this->updateJsonFromMultilineInput('requirements');

        //        $this->validate();
        dd(['title' => $this->title, 'slug' => $this->slug, 'heading' => $this->heading, 'description' => $this->description, 'image' => $this->image, 'price' => $this->price, 'category' => $this->category, 'level' => $this->level, 'requirements' => $this->requirementsJson, 'skills' => $this->skillsJson, 'modules' => $this->modules,]);
    }


    public function render(): Factory|Application|View
    {
        return view('livewire.client.instructor.create-course');
    }


}
