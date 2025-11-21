<?php

namespace App\Livewire\Admin\Academic\Components\Major;

use App\Models\Major;
use App\Services\Admin\Major\MajorService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class MajorDetail extends Component {
    public ?Major $major = null;
    public bool $isLoading = true;

    #[On('view-major-details')]
    public function loadMajor(int $id): void
    {
        $this->isLoading = true;

        $this->major = app(MajorService::class)->getById($id);

        $this->isLoading = false;

        $this->dispatch('open-major-detail-modal');
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.major.major-detail');
    }
}
