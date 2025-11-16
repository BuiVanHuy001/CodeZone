<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\InstructorApproved;
use App\Notifications\InstructorApprovedNotification;

class SendInstructorApprovedNotification {
    public function __construct() {}

    public function handle(InstructorApproved $event): void
    {
        $event->instructor->notify(new InstructorApprovedNotification());
    }
}
