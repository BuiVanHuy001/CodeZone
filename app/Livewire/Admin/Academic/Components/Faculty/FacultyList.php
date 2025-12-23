<?php

namespace App\Livewire\Admin\Academic\Components\Faculty;

use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class FacultyList extends Component {
    public string $search = '';

    public string $sortDirection = 'desc';

    #[On('faculty-created')]
    #[On('faculty-updated')]
    #[On('faculty-deleted')]
    public function refresh() {}

    public function toggleSort(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function render(): View
    {
        $faculties = AcademicCache::getCachedFacultiesOnly();

        if ($this->search) {
            $faculties = $faculties->filter(function ($faculty) {
                return str_contains(strtolower($faculty->name), strtolower($this->search))
                    || str_contains(strtolower($faculty->code), strtolower($this->search));
            });
        }

        if ($this->sortDirection === 'asc') {
            $faculties = $faculties->sortBy('created_at');
        } else {
            $faculties = $faculties->sortByDesc('created_at');
        }

        return view('livewire.admin.academic.components.faculty.faculty-list', [
            'faculties' => $faculties->values()
        ]);
    }
}
