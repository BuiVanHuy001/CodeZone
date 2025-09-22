<?php

namespace App\View\Components\Client\CourseDetails;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Instructor extends Component
{
    public string $name;
    public string $avatar;
    public ?string $aboutMe = null;
    public ?string $courseCount = null;
    public ?string $studentCount = null;
    public ?string $reviewCount = null;
    public ?string $jobTitle = null;
    public ?float $rating = null;
    public ?array $socials = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public User $instructor
    )
    {
        $this->avatar = $instructor->getAvatarPath();
        $this->name = $instructor->name;
        if ($instructor->getProfile()) {
            $profile = $instructor->getProfile ?? null;
            $this->courseCount = $profile->course_count . Str::plural(' course', $profile->course_count);
            $this->studentCount = $profile->student_count . Str::plural(' student', $profile->student_count);
            $this->jobTitle = $profile->current_job ?? 'CodeZone Instructor';
            $this->rating = $profile->rating ? round($profile->average_rating, 1) : null;
            $this->reviewCount = $profile->review_count . Str::plural(' review', $profile->review_count);
            $this->aboutMe = nl2br(e($instructor->getProfile['about_me'] ?? ''));
            $this->socials = $profile->social_links;

        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.course-details.instructor');
    }
}
