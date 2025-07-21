<?php

namespace App\Livewire\Client\Components;

use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        $role = auth()->user()->getRole();
        if ($role === 'student') {
            return view('livewire.client.components.student-sidebar');
        } elseif ($role === 'instructor') {
            return view('livewire.client.components.instructor-sidebar');
        }
        return view('livewire.client.components.business-sidebar');
    }
}
