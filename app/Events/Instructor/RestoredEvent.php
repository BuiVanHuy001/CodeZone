<?php

namespace App\Events\Instructor;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RestoredEvent {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly User $instructor,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
