<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LibretaActualizada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $libreta;

    public function __construct($libreta)
    {
        $this->libreta = $libreta;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
