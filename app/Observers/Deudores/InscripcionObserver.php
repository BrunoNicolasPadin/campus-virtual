<?php

namespace App\Observers\Deudores;

use App\Jobs\Deudores\ActualizacionInscripcionJob;
use App\Models\Deudores\Inscripcion;

class InscripcionObserver
{
    public function updated(Inscripcion $inscripcion)
    {
        ActualizacionInscripcionJob::dispatch($inscripcion);
    }
}
