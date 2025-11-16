<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\InstructorRestored;
use App\Notifications\InstructorApprovedNotification;

class SendInstructorRestoredNotification {
    public function __construct() {}

    public function handle(InstructorRestored $event): void
    {
        $event->instructor->notify(new InstructorApprovedNotification());
    }
}
