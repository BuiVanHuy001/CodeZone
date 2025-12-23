<?php

namespace App\Livewire\Admin\Academic\Components\Major;

use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class MajorList extends Component {
    public string $search = '';
    public string $sortDirection = 'desc';

    #[On('major-created')]
    #[On('major-updated')]
    #[On('major-deleted')]
    public function refresh() {}

    public function toggleSort(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function render(): View
    {
        $majors = AcademicCache::getCachedMajorsOnly();

        if ($this->search) {
            $keyword = Str::lower(Str::ascii($this->search));

            $majors = $majors->filter(function ($major) use ($keyword) {
                $name = Str::lower(Str::ascii($major->name));
                $code = Str::lower(Str::ascii($major->code));

                return str_contains($name, $keyword) || str_contains($code, $keyword);
            });
        }

        if ($this->sortDirection === 'asc') {
            $majors = $majors->sortBy('created_at');
        } else {
            $majors = $majors->sortByDesc('created_at');
        }

        return view('livewire.admin.academic.components.major.major-list', [
            'majors' => $majors->values()
        ]);
    }
}
