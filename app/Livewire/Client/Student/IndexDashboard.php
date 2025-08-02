<?php

namespace App\Livewire\Client\Student;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

class IndexDashboard extends Component {

	#[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.student.index');
    }
}
