<?php

namespace App\Livewire\Client\Student\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Purchases extends Component {
	#[Layout('components.layouts.dashboard')]
	public function render(): Factory|Application|View
	{
		return view('livewire.client.student.dashboard.purchases');
	}
}
