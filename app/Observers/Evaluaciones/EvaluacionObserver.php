<?php

namespace App\Observers\Evaluaciones;

use App\Jobs\Evaluaciones\CrearEntregaJob;
use App\Jobs\Evaluaciones\NuevaEvaluacionJob;
use App\Models\Evaluaciones\Evaluacion;

class EvaluacionObserver
{
    public function created(Evaluacion $evaluacion)
    {
        CrearEntregaJob::dispatch($evaluacion);
        NuevaEvaluacionJob::dispatch($evaluacion);
    }
}
