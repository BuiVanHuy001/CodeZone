<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\ApprovedEvent;
use App\Notifications\Instructor\InstructorApprovedNotification;

class SendApprovedNotification {
    public function __construct() {}

    public function handle(ApprovedEvent $event): void
    {
        $event->instructor->notify(new InstructorApprovedNotification());
    }
}
