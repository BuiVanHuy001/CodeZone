<?php

namespace App\Livewire\Client\Business;

use App\Models\OrganizationUsers;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EmployeesDashboard extends Component {
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
        if (!OrganizationUsers::where('organization_id', auth()->user()->id)->where('user_id', $user->id)->exists()) {
            OrganizationUsers::create(['organization_id' => auth()->user()->id, 'user_id' => $user->id,]);
        }
    }

    public function deleteEmployee(User $user): void
    {
	    OrganizationUsers::where('organization_id', auth()->user()->id)
	                     ->where('user_id', $user->id)->delete();
    }

    #[Layout('components.layouts.business-dashboard')]
    public function render()
    {
        $employees = OrganizationUsers::where('organization_id', auth()->user()->id)->with('user')->get();

        return view('livewire.client.business.employees', ['employees' => $employees]);
    }
}
