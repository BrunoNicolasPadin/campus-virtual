<?php

namespace App\Observers\Libretas;

use App\Jobs\Libretas\ActualizacionLibretaJob;
use App\Models\Libretas\Calificacion;

class LibretaObserver
{
    public function updated(Calificacion $calificacion)
    {
        ActualizacionLibretaJob::dispatch($calificacion);
    }
}
