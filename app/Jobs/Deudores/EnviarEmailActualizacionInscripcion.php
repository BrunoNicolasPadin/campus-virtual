<?php

namespace App\Jobs\Deudores;

use App\Events\InscripcionActualizada;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarEmailActualizacionInscripcion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inscripcion;

    public function __construct($inscripcion)
    {
        $this->inscripcion = $inscripcion;
    }

    public function handle()
    {
        event(new InscripcionActualizada($this->inscripcion));
    }
}
