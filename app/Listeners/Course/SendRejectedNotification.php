<?php

namespace App\Listeners\Course;

use App\Events\Course\RejectedEvent;
use App\Notifications\Course\CourseRejectedNotification;

class SendRejectedNotification {
    public function __construct() {}

    public function handle(RejectedEvent $event): void
    {
        $course = $event->course;
        $instructor = $course->author;

        $instructor->notify(new CourseRejectedNotification($course));
    }
}
