<?php

namespace App\Observers;

use App\Jobs\Evaluaciones\EnviarEmailActualizacionEntrega;
use App\Models\Evaluaciones\Entrega;

class EntregaObserver
{
    public function updated(Entrega $entrega)
    {
        /* EnviarEmailActualizacionEntrega::dispatch($entrega); */
    }
}
