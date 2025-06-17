<?php

namespace App\Livewire\Client\Instructor;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Dashboard')]
class IndexDashboard extends Component
{
    public function render()
    {
        return view('livewire.client.instructor.index-dashboard');
    }
}
