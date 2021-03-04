<?php

namespace App\Observers;

use App\Events\InscripcionActualizada;
use App\Models\Deudores\Anotado;

class InscripcionObserver
{
    public function updated(Anotado $inscripcion)
    {
        event(new InscripcionActualizada($inscripcion));
    }
}
