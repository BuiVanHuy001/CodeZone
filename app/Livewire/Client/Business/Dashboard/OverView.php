<?php

namespace App\Livewire\Client\Business\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

class OverView extends Component
{
	#[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
	    return view('livewire.client.business.dashboard.overview');
    }
}
