<?php

namespace App\Livewire\Client\Organization\Dashboard;

use App\Models\OrganizationUser;
use App\Models\User;
use App\Services\Organization\MemberImportService;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class Members extends Component
{
    use WithFileUploads;

    public string $activeTab = 'list';

    public array $importedMembers = [];
    public array $dbMembers = [];

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
        $this->dbMembers = $result['dbMembers'];
        if (!empty($result['failures'])) {
            $html = $this->prepareForDisplayFailures($result['failures']);
            $this->swalError(title: "Error", html: $html);
        } else {
            $this->swal('Import Successful', 'The import process has been completed successfully.');
        }

        $this->hasImported = !empty($this->importedMembers);
        $this->dispatch('import-finished');
    }

    private function prepareForDisplayFailures(array|Collection $failures): string
    {
        $html = '<div>Some rows could not be imported due to validation errors. Please review the details below and try again.</div>';
        foreach ($failures as $failure) {
            $html .= '<div class="alert alert-danger" role="alert">';
            $html .= '<strong>Row ' . $failure['row'] . ':</strong> ';
            $html .= implode(' ', $failure['errors']);
            $html .= '</div>';
        }
        return $html;
    }

    public function deleteImportedMember(int $rowIndex): void
    {
        if (isset($this->importedMembers[$rowIndex], $this->dbMembers[$rowIndex])) {
            unset($this->importedMembers[$rowIndex], $this->dbMembers[$rowIndex]);
            $this->importedMembers = array_values($this->importedMembers);
            $this->dbMembers = array_values($this->dbMembers);
            $this->swal('Member Deleted', 'The member has been successfully deleted.');
        }
    }

    /**
     * @throws Throwable
     */
    public function importMembers(): void
    {
        DB::beginTransaction();
        try {
            foreach ($this->dbMembers as $member) {
                ;
                $user = User::createOrFirst([
                    'email' => $member['mail'],
                ], [
                    'name' => $member['full_name'],
                    'email' => $member['mail'],
                    'password' => Hash::make($member['password']),
                    'role' => 'student',
                    'status' => 'active',
                    'avatar' => $member['avatar_url'],
                ]);
                $user->studentProfile()->updateOrCreate([
                    'user_id' => $user->id,
                ], [
                    'gender' => $member['gender'] === 'female',
                    'dob' => $member['date_of_birth'],
                    'addition_data' => json_encode($member['addition_data'], JSON_THROW_ON_ERROR),
                ]);

                OrganizationUser::create([
                    'organization_id' => auth()->id(),
                    'user_id' => $user->id
                ]);
            }
            $this->reset([
                'importedMembers',
                'hasImported',
                'showImportButton',
                'importUsersFile'
            ]);
            $this->setTab('list');
            $this->swal('Import Successful', 'The import process has been completed successfully.');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->swalError('Imported Failed', 'An error occurred while importing members:', $e->getMessage());
        }
    }

    public function cancelImportMembers(): void
    {
        $this->reset([
            'importedMembers',
            'hasImported',
            'showImportButton',
            'importUsersFile'
        ]);
        $this->swal('Import Cancelled', 'The import process has been cancelled.', 'info');
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
