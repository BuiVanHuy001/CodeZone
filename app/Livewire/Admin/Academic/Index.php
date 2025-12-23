<?php

namespace App\Livewire\Admin\Academic;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component {
    public function render(): View
    {
        return view('livewire.admin.academic.index')
            ->layout('components.layouts.admin-dashboard');
    }
}
