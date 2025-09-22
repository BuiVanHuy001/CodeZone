<?php

namespace App\View\Components\Client\CourseDetails;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeatureBox extends Component
{
    public array $chunks;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string       $title,
        public string|array $features
    )
    {
        if (is_string($this->features)) {
            $features = json_decode($features, true);
        }
        $this->features = $features;
        $this->chunks = array_chunk(
            $this->features,
            ceil(count($this->features) / 2)
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.course-details.feature-box');
    }
}
