<?php

namespace App\Observers;

use App\Jobs\Deudores\EnviarEmailActualizacionInscripcionJob;
use App\Models\Deudores\Inscripcion;

class InscripcionObserver
{
    public function updated(Inscripcion $inscripcion)
    {
        EnviarEmailActualizacionInscripcionJob::dispatch($inscripcion);
    }
}
