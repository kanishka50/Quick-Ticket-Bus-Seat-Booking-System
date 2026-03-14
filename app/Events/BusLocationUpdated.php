<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BusLocationUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $scheduleDateId,
        public float $latitude,
        public float $longitude,
        public ?string $locationName,
        public ?float $speed,
        public string $recordedAt,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('tracking.' . $this->scheduleDateId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'location.updated';
    }
}
