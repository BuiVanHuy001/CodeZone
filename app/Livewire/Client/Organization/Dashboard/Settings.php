<?php

namespace App\Livewire\Client\Organization\Dashboard;

use App\Livewire\Client\Shared\SettingsBase;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;

class Settings extends SettingsBase {
	#[Layout('components.layouts.dashboard')]
	public function render(): View|Application|Factory
	{
		return view('livewire.client.organization.dashboard.settings');
	}
}
