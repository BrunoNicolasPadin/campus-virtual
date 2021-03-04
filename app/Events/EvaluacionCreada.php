<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EvaluacionCreada
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $evaluacion;
    public $alumno;

    public function __construct($evaluacion, $alumno)
    {
        $this->evaluacion = $evaluacion;
        $this->alumno = $alumno;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
