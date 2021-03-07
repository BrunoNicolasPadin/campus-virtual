<?php

namespace App\Observers;

use App\Jobs\EnviarEmailActualizacionLibretaJob;
use App\Models\Libretas\Calificacion;

class LibretaObserver
{
    public function updated(Calificacion $calificacion)
    {
        EnviarEmailActualizacionLibretaJob::dispatch($calificacion);
    }
}
