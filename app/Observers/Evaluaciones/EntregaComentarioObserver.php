<?php

namespace App\Observers\Evaluaciones;

use App\Jobs\Evaluaciones\NuevoEntregaComentarioJob;
use App\Models\Evaluaciones\EntregaComentario;

class EntregaComentarioObserver
{
    public function created(EntregaComentario $entregaComentario)
    {
        $tipo = session('tipo');
        NuevoEntregaComentarioJob::dispatch($entregaComentario, $tipo);
    }
}
