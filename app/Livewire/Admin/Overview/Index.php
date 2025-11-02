<?php

namespace App\Livewire\Admin\Overview;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Admin Overview')]
class Index extends Component
{
    public function render(): View
    {
        return view('livewire.admin.overview.index')
            ->layout('components.layouts.admin-dashboard');
    }
}
