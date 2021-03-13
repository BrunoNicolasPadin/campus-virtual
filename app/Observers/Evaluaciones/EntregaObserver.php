<?php

namespace App\Observers\Evaluaciones;

use App\Jobs\Evaluaciones\ActualizacionEntregaJob;
use App\Models\Evaluaciones\Entrega;

class EntregaObserver
{
    public function updated(Entrega $entrega)
    {
        ActualizacionEntregaJob::dispatch($entrega);
    }
}
