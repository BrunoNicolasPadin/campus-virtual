<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EntregaActualizada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $entrega;

    public function __construct($entrega)
    {
        $this->entrega = $entrega;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
