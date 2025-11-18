<?php

namespace App\Listeners\Course;

use App\Events\Course\SuspendedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSuspendedNotification {
    public function __construct() {}

    public function handle(SuspendedEvent $event): void
    {
        $course = $event->course;
        $instructor = $course->author;
        $instructor->notify(new SendSuspendedNotification($course));
    }
}
