<?php

namespace App\Livewire\Admin\Student;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.admin.student.index')->layout('components.layouts.admin-dashboard');
    }
}
