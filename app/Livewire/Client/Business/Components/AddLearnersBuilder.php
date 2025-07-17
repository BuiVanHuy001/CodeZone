<?php

namespace App\Livewire\Client\Business\Components;

use App\Models\OrganizationUsers;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class AddLearnersBuilder extends Component {
    #[Modelable]
    public array $learners = [];


    private function getEmployees()
    {
        if (!auth()->user()->isBusiness()) {
            return [];
        }
        return OrganizationUsers::where('organization_id', auth()->user()->id)->with('user')->get();
    }

    public function addEmployeeAssign(string $userId): void
    {
        $user = User::find($userId);
        if (auth()->user()->isBusiness() && auth()->user()->isEmployeeOfThisBusiness($user)) {
            if (!in_array($userId, $this->learners)) {
                $this->learners[] = $userId;
            }
        }
    }

    public function removeEmployeeAssign(string $userId): void
    {
        if (($key = array_search($userId, $this->learners)) !== false) {
            unset($this->learners[$key]);
        }
    }

    public function render(): View|Application|Factory
    {
        $employees = $this->getEmployees();
        return view('livewire.client.business.components.add-learners-builder', ['employees' => $employees,]);
    }
}
