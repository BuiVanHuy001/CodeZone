<?php

namespace App\Events\Student;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusChanged {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public User   $student,
        public string $oldStatus,
        public string $newStatus,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
