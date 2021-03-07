<?php

namespace App\Observers;

use App\Jobs\EnviarEmailActualizacionLibreta;
use App\Models\Libretas\Calificacion;

class LibretaObserver
{
    public function updated(Calificacion $calificacion)
    {
        /* EnviarEmailActualizacionLibreta::dispatch($calificacion); */
    }
}
