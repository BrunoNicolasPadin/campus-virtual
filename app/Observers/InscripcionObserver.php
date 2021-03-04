<?php

namespace App\Observers;

use App\Jobs\Deudores\EnviarEmailActualizacionInscripcion;
use App\Models\Deudores\Anotado;

class InscripcionObserver
{
    public function updated(Anotado $inscripcion)
    {
        EnviarEmailActualizacionInscripcion::dispatch($inscripcion);
    }
}
