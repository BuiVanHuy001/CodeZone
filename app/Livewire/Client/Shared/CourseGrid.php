<?php

namespace App\Livewire\Client\Shared;

use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class CourseGrid extends Component
{
    #[Reactive]
    public LengthAwarePaginator $courses;

    public function render(): View
    {
        return view('livewire.client.shared.course-grid');
    }
}
