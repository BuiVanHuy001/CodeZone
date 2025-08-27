<?php

namespace App\View\Components\Client\Dashboard\CourseCreation\Builders\AssessmentTypes\Quiz;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OptionEditor extends Component {
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.client.dashboard.course-creation.builders.assessment-types.quiz.option-editor');
    }
}
