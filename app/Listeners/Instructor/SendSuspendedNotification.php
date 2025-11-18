<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\SuspendedEvent;
use App\Notifications\Instructor\InstructorSuspendedNotification;

class SendSuspendedNotification {
    public function __construct() {}

    public function handle(SuspendedEvent $event): void
    {
        $event->instructor->notify(new InstructorSuspendedNotification());
    }
}
