<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\RestoredEvent;
use App\Notifications\Instructor\InstructorApprovedNotification;

class SendRestoredNotification {
    public function __construct() {}

    public function handle(RestoredEvent $event): void
    {
        $event->instructor->notify(new InstructorApprovedNotification());
    }
}
