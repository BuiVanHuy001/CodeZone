<?php

namespace App\Listeners\Course;

use App\Events\Course\RestoredEvent;
use App\Notifications\Course\CourseRestoredNotification;

class SendRestoredNotification {
    public function __construct() {}

    public function handle(RestoredEvent $event): void
    {
        $course = $event->course;
        $instructor = $course->author;
        $instructor->notify(new CourseRestoredNotification($course));
    }
}
