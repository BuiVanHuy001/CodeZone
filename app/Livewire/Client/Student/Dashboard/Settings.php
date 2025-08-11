<?php

namespace App\Livewire\Client\Student\Dashboard;

use App\Livewire\Client\Shared\SettingsBase;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;

class Settings extends SettingsBase {
	#[Layout('components.layouts.dashboard')]
	public function render(): Factory|Application|View
	{
		return view('livewire.client.student.dashboard.settings');
	}
}
