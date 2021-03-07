<?php

namespace App\Observers;

use App\Jobs\Evaluaciones\EnviarEmailActualizacionEntregaJob;
use App\Models\Evaluaciones\Entrega;

class EntregaObserver
{
    public function updated(Entrega $entrega)
    {
        EnviarEmailActualizacionEntregaJob::dispatch($entrega);
    }
}
