<?php

namespace App\Livewire\Client\Instructor;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Create New Course')]
class CreateCourse extends Component
{
public string $title = '';
public string $slug = '';

public function updatedTitle($value): void
{
    $this->slug = Str::slug($value);
}

public function render(): Factory|Application|View
{
    return view('livewire.client.instructor.create-course');
}
}
