<?php

namespace App\View\Components\Client\ShareUi;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class FilterSelect extends Component
{
    public mixed $selectedValue;

    public function __construct(
        public array|Collection $items,
        public string           $label,
        public string           $name,
        public bool             $isModern = false,
        public ?string          $model = null,
        public string           $placeholder = 'Select an option'
    )
    {
        $value = request($this->name);

        if (is_array($value)) {
            $this->selectedValue = collect($value)->map(fn($id) => (int)$id)->all();
        } elseif (is_string($value) && str_contains($value, ',')) {
            $this->selectedValue = array_map('intval', explode(',', $value));
        } else {
            $this->selectedValue = $value;
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.client.share-ui.filter-select');
    }
}
