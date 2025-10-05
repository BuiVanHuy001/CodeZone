<?php

namespace App\Livewire\Client\Student\Dashboard;

use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Reviews extends Component
{
    public Collection $courseReviews;
    public Collection $instructorReviews;

    public function mount(): void
    {
        $this->courseReviews = Review::course()->where('user_id', auth()->id())->get();
        $this->instructorReviews = Review::instructor()->where('user_id', auth()->id())->get();
        dd($this->courseReviews, $this->instructorReviews);
    }

    #[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.student.dashboard.reviews');
    }
}
