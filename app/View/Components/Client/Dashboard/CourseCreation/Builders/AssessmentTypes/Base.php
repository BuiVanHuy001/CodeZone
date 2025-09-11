<?php

namespace App\View\Components\Client\Dashboard\CourseCreation\Builders\AssessmentTypes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Base extends Component {
    public function __construct(
        public string $title,
        public string $name,
        public string $wireDeleteMethod = 'remove',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.client.dashboard.course-creation.builders.assessment-types.base');
    }
}
