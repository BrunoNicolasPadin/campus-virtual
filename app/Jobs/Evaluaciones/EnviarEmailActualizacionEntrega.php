<?php

namespace App\Jobs\Evaluaciones;

use App\Events\EntregaActualizada;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarEmailActualizacionEntrega implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entrega;

    public function __construct($entrega)
    {
        $this->entrega = $entrega;
    }

    public function handle()
    {
        event(new EntregaActualizada($this->entrega));
    }
}
