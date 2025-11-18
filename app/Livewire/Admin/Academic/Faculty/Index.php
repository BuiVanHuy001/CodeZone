<?php

namespace App\Livewire\Admin\Academic\Faculty;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component {
    public function render(): View
    {
        return view('livewire.admin.academic.faculty.index')
            ->layout('components.layouts.admin-dashboard');
    }
}
