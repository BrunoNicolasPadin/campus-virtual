<?php

namespace App\Observers;

use App\Jobs\Deudores\EnviarEmailActualizacionInscripcion;
use App\Models\Deudores\Inscripcion;

class InscripcionObserver
{
    public function updated(Inscripcion $inscripcion)
    {
        /* EnviarEmailActualizacionInscripcion::dispatch($inscripcion); */
    }
}
