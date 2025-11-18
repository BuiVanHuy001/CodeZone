<?php

namespace App\Listeners\Instructor;

use App\Events\Instructor\RejectedEvent;
use App\Notifications\Instructor\InstructorRejectedNotification;

class SendRejectedNotification {
    public function __construct() {}

    public function handle(RejectedEvent $event): void
    {
        $event->instructor->notify(new InstructorRejectedNotification());
    }
}
