<?php

namespace App\Livewire\Client\Organization\Dashboard;

use App\Models\OrganizationUser;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Members extends Component
{
    public string $activeTab = 'list';

    #[Validate('string|max:255|required')]
    public string $search = '';

    public $userResults = null;

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function searchUser(): void
    {
        $this->validate();
        if (!empty($this->search)) {
	        $this->userResults = User::where('name', 'like', '%' . $this->search . '%')
	                                 ->orWhere('email', 'like', '%' . $this->search . '%')
	                                 ->get();
            $this->activeTab = 'add';
        }
    }

    public function addEmployee(User $user): void
    {
	    if (!OrganizationUser::where('organization_id', auth()->user()->id)->where('user_id', $user->id)->exists()) {
		    OrganizationUser::create(
			    ['organization_id' => auth()->user()->id,
				    'user_id' => $user->id
			    ]);
        }
    }

    public function deleteEmployee(User $user): void
    {
	    OrganizationUser::where('organization_id', auth()->user()->id)
	                     ->where('user_id', $user->id)->delete();
    }

	#[Layout('components.layouts.dashboard')]
	public function render(): View|Application|Factory|\Illuminate\View\View
    {
	    $employees = OrganizationUser::where('organization_id', auth()->user()->id)->with('user')->get();

        return view('livewire.client.organization.dashboard.members', ['employees' => $employees]);
    }
}
