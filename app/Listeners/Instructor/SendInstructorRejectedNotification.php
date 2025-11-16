<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\InstructorRejected;
use App\Notifications\InstructorRejectedNotification;

class SendInstructorRejectedNotification {
    public function __construct() {}

    public function handle(InstructorRejected $event): void
    {
        $event->instructor->notify(new InstructorRejectedNotification());
    }
}
