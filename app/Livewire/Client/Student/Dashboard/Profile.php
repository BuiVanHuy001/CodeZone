<?php

namespace App\Livewire\Client\Student\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Profile extends Component {
    public array $infos;

    public function mount(): void
    {
        $user = auth()->user();

        $this->infos = [
            'Full Name' => $user->name,
            'Email' => $user->email,
            'Register Date' => $user->created_at->diffForHumans(),
            'Member' => $user->getOrganizationOfUser()
        ];

        if ($user->studentProfile) {
            $this->infos = array_merge($this->infos, [
                'Date Of Birth' => $user->studentProfile->dob->format('d/m/Y'),
                'Gender' => $user->studentProfile->gender === 0 ? 'Male' : 'Female',
                'Enrolled Course Amount' => $user->studentProfile->enrolled_count,
                'Completed Course Amount' => $user->studentProfile->completed_count,
            ]);

            if ($user->studentProfile->addition_data) {
                $this->infos = array_merge($this->infos, $user->studentProfile->addition_data);
            }
        }
    }


    #[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.student.dashboard.profile');
    }
}
