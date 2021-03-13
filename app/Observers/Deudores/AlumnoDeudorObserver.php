<?php

namespace App\Observers\Deudores;

use App\Jobs\Deudores\NuevaAsignaturaAdeudadaJob;
use App\Models\Deudores\AlumnoDeudor;

class AlumnoDeudorObserver
{
    public function created(AlumnoDeudor $alumnoDeudor)
    {
        NuevaAsignaturaAdeudadaJob::dispatch($alumnoDeudor);
    }
}
