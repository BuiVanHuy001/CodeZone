<?php

namespace App\Livewire\Client\Organization\Dashboard;

use App\Models\OrganizationUser;
use App\Models\User;
use App\Services\Business\MemberImportService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Members extends Component
{
    use WithFileUploads;

    public string $activeTab = 'list';
    public array $importedMembers = [];
    public array $dbMembers = [];
    public array $tableRows = [];
    public bool $hasImported = false;
    public bool $showImportButton = false;
    public string $search = '';
    public $userResults = null;

    #[Validate('required|file|mimes:xlsx,xls,csv')]
    public $importUsersFile;

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function searchUser(): void
    {
        $this->validate(['search' => 'string|max:255|required']);

        $this->userResults = User::query()
                                 ->whereKeyNot(auth()->id())
                                 ->where('role', '!=', 'organization')
                                 ->where(function ($q) {
                                     $term = '%' . $this->search . '%';
                                     $q
                                         ->where('name', 'like', $term)
                                         ->orWhere('email', 'like', $term);
                                 })
                                 ->get();

        $this->activeTab = 'add';
    }

    public function updatedSearch(): void
    {
        if (empty($this->search)) {
            $this->userResults = null;
        }
    }

    public function addMember(User $user): void
    {
        if (!auth()->user()->isMemberOfOrganization($user->id, auth()->id())) {
            OrganizationUser::create([
                'organization_id' => auth()->id(),
                'user_id' => $user->id
            ]);
        }
    }

    public function deleteMember(User $user): void
    {
        OrganizationUser::where('organization_id', auth()->id())
                        ->where('user_id', $user->id)
                        ->delete();
    }

    public function updatedImportUsersFile(MemberImportService $importService): void
    {
        $result = $importService->importFile($this->importUsersFile->getRealPath());
        $this->importedMembers = $result['displayMembers'];

        $this->hasImported = !empty($this->importedMembers);
        $this->dispatch('import-finished');
    }


    public function deleteImportedMember(int $rowIndex): void
    {
        if (isset($this->importedMembers[$rowIndex]) && isset($this->dbMembers[$rowIndex])) {
            unset($this->importedMembers[$rowIndex]);
            unset($this->dbMembers[$rowIndex]);
            $this->importedMembers = array_values($this->importedMembers);
            $this->dbMembers = array_values($this->dbMembers);
            $this->dispatch('swal', [
                'title' => 'Member Deleted',
                'text' => 'The member has been successfully deleted.',
                'icon' => 'success',
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'allowOutsideClick' => false,
                'allowEscapeKey' => false,
            ]);
        }
    }

    public function cancelImportMembers(): void
    {
        $this->reset([
            'importedMembers',
            'importErrors',
            'hasImported',
            'showImportButton',
            'importUsersFile'
        ]);
        $this->dispatch('swal', [
            'title' => 'Import Cancelled',
            'text' => 'The import process has been cancelled.',
            'icon' => 'info',
            'showConfirmButton' => true,
            'confirmButtonText' => 'OK',
            'allowOutsideClick' => false,
            'allowEscapeKey' => false,
        ]);
    }

    #[Layout('components.layouts.dashboard')]
    public function render(): View|Application|\Illuminate\View\View
    {
        $members = OrganizationUser::where('organization_id', auth()->id())
                                   ->with('user')
                                   ->get();

        return view('livewire.client.organization.dashboard.members', compact('members'));
    }
}
