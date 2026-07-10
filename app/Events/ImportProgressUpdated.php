<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportProgressUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct( public int $importId,public int $progress,public string $status)
    {
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        /*return [
            new PrivateChannel('product-progress'),
        ];*/
        

        return [new Channel('product-progress')];

    }

    public function broadcastAs(): string{
         return 'progress.updated';
    }
    
    public function broadcastWith(): array
    {
        return [
            'importId' => $this->importId,
            'progress' => $this->progress,
            'status' => $this->status,
        ];
    }

}
