<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Row;

class RowCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $row;

    public function __construct(array $row)
    {
        $this->row = $row;
    }

    public function broadcastOn()
    {
        return new Channel('rows');
    }
}
