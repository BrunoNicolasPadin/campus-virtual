<?php

namespace App\Observers\Muro;

use App\Jobs\Muro\NuevaRespuestaJob;
use App\Models\Muro\MuroRespuesta;

class MuroRespuestaObserver
{
    public function created(MuroRespuesta $muroRespuesta)
    {
        $tipo = session('tipo');
        NuevaRespuestaJob::dispatch($muroRespuesta, $tipo);
    }
}
