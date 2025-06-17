<?php

namespace App\Livewire\Client\Instructor;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Settings')]
class SettingsDashboard extends Component
{
    public function render()
    {
        return view('livewire.client.instructor.settings-dashboard');
    }
}
