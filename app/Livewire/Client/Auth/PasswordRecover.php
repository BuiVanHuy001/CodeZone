<?php

namespace App\Livewire\Client\Auth;

use App\Models\User;
use App\Services\Client\TraditionalLogin\AuthenticationService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PasswordRecover extends Component
{
    #[Validate('required|email', [
        'required' => 'Please enter your emailInput address to search for your account.',
        'email' => 'Enter a valid email address.',
    ])]
    public $emailInput;
    public ?User $user;


    public function findAccount(): void
    {
        $this->validate();
        $this->user = User::where('email', $this->emailInput)->first();
        if (!$this->user) {
            $this->swal(
                title: 'Account Not Found',
                text: 'We could not find an account associated with this mail address.',
                icon: 'warning'
            );

            $this->addError('mail', 'No user found with this mail address.');
        }
    }

    public function sendPasswordResetLink(AuthenticationService $authenticationService): void
    {
        if ($this->user) {
            $authenticationService->resetPassword($this->user);
            redirect()->route('client.login', [
                'email' => $this->user->email
            ])->with('swal', [
                'title' => 'Password Reset',
                'text' => 'A new password has been sent to your email address.',
                'icon' => 'success',
            ]);
        }
    }


    public function render(): Factory|Application|View
    {
        return view('livewire.client.auth.password-recovery');
    }
}
