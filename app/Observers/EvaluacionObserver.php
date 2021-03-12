<?php

namespace App\Observers;

use App\Jobs\Evaluaciones\CrearEntregaJob;
use App\Jobs\Evaluaciones\EnviarEmailNuevaEvaluacionJob;
use App\Models\Evaluaciones\Evaluacion;

class EvaluacionObserver
{
    public function created(Evaluacion $evaluacion)
    {
        CrearEntregaJob::dispatch($evaluacion)->onQueue('entregas');
        EnviarEmailNuevaEvaluacionJob::dispatch($evaluacion)->onQueue('entregas');
    }
}
