<?php

namespace App\Observers;

use App\Jobs\Evaluaciones\CrearEntregaJob;
use App\Jobs\Evaluaciones\EnviarEmailNuevaEvaluacion;
use App\Models\Evaluaciones\Evaluacion;

class EvaluacionObserver
{
    public function created(Evaluacion $evaluacion)
    {
        CrearEntregaJob::dispatch($evaluacion);
        EnviarEmailNuevaEvaluacion::dispatch($evaluacion);
    }
}
