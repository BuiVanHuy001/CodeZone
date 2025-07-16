<?php

namespace App\Livewire\Client\Student;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Index extends Component {
    public function render(): View|Application|Factory
    {
        return view('livewire.client.student.index');
    }
}
