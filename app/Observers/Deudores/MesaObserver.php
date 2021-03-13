<?php

namespace App\Observers\Deudores;

use App\Jobs\Deudores\ActualizacionMesaJob;
use App\Models\Deudores\Mesa;

class MesaObserver
{
    public function updated(Mesa $mesa)
    {
        ActualizacionMesaJob::dispatch($mesa);
    }
}
