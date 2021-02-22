<?php

namespace App\Observers;

use App\Events\EntregaActualizada;
use App\Models\Evaluaciones\Entrega;

class EntregaObserver
{
    public function updated(Entrega $entrega)
    {
        event(new EntregaActualizada($entrega));
    }
}
