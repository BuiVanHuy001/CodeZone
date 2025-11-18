<?php

namespace App\Listeners\Course;

use App\Events\Course\ApprovedEvent;
use App\Notifications\Course\CourseApprovedNotification;

class SendApprovedNotification {
    public function __construct() {}

    public function handle(ApprovedEvent $event): void
    {
        $course = $event->course;
        $instructor = $course->author;

        $instructor->notify(new CourseApprovedNotification($course));
    }
}
