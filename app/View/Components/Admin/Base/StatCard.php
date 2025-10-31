<?php

namespace App\View\Components\Admin\Base;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatCard extends Component
{
    public string $changeIconClass;
    public string $changeColorClass;
    public string $mainIconBgClass;
    public string $mainIconColorClass;

    public function __construct(
        public string  $title,
        public string  $change,
        public string  $mainValue,
        public string  $linkText,
        public string  $mainIcon,
        public string  $color,
        public ?string $prefix = null,
        public ?string $suffix = null,
        public string  $linkUrl = '#'
    )
    {
        $this->setChangeClasses();
        $this->setMainIconClasses();
    }

    private function setChangeClasses(): void
    {
        if ($this->change !== '+0.00 %' && str_starts_with($this->change, '+')) {
            $this->changeIconClass = 'ri-arrow-right-up-line';
            $this->changeColorClass = 'text-success';
        } elseif (str_starts_with($this->change, '-')) {
            $this->changeIconClass = 'ri-arrow-right-down-line';
            $this->changeColorClass = 'text-danger';
        } else {
            $this->changeIconClass = '';
            $this->changeColorClass = 'text-muted';
        }
    }

    private function setMainIconClasses(): void
    {
        $this->mainIconBgClass = "bg-{$this->color}-subtle";
        $this->mainIconColorClass = "text-{$this->color}";
    }

    public function render(): View|Closure|string
    {
        return view('components.admin.base.stat-card');
    }
}
