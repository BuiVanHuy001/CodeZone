<?php

namespace App\Livewire\Client\Organization\Components;

use App\Models\OrganizationUser;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use LaravelIdea\Helper\App\Models\_IH_OrganizationUser_C;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class AddLearnersBuilder extends Component {
    #[Modelable]
    public array $learners = [];


    private function getEmployees(): Collection|_IH_OrganizationUser_C|array
    {
        if (!auth()->user()->isOrganization()) {
            return [];
        }
	    return OrganizationUser::where('organization_id', auth()->user()->id)->with('user')->get();
    }

    public function addEmployeeAssign(string $userId): void
    {
        $user = User::find($userId);
        if (auth()->user()->isEmployeeOfThisOrganization($user)) {
            if (auth()->user()->isOrganization()) {
                if (!in_array($userId, $this->learners)) {
                    $this->learners[] = $userId;
                }
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
        return view('livewire.client.organization.components.add-learners-builder', ['employees' => $employees,]);
    }
}
