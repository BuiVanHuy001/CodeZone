<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Members;

use App\Models\OrganizationUser;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AddLearners extends Component {
    use WithPagination, WithoutUrlPagination;

    #[Modelable]
    public array $learners = [];
    public string $search = '';

    private function getAllMembers(): LengthAwarePaginator
    {
        return OrganizationUser::where('organization_id', auth()->user()->id)
                               ->with('user')
                               ->when($this->search, function ($query, $search) {
                                   $query->whereHas('user', function ($userQuery) use ($search) {
                                       $userQuery
                                           ->withName($search)
                                           ->withEmail($search);
                                   });
                               })
                               ->orderBy('created_at')
                               ->paginate(15);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }


    public function addMemberAssign(string $userId): void
    {
        if (
            !in_array($userId, $this->learners, true) &&
            auth()->user()->isMemberOfOrganization($userId, auth()->user()->id)
        ) {
            $this->learners[] = $userId;
        }
    }

    public function removeMemberAssign(string $userId): void
    {
        if (($key = array_search($userId, $this->learners, true)) !== false) {
            unset($this->learners[$key]);
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.members.add-learners', [
            'members' => $this->getAllMembers(),
        ]);
    }
}
