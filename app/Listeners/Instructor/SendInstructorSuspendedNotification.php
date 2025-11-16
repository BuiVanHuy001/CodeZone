<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\InstructorSuspended;
use App\Notifications\InstructorSuspendedNotification;

class SendInstructorSuspendedNotification {
    public function __construct() {}

    public function handle(InstructorSuspended $event): void
    {
        $event->instructor->notify(new InstructorSuspendedNotification());
    }
}
