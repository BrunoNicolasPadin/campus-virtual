<?php

namespace App\Observers;

use App\Jobs\Evaluaciones\EnviarEmailNuevaEvaluacion;
use App\Models\Evaluaciones\Evaluacion;

class EvaluacionObserver
{
    public function created(Evaluacion $evaluacion)
    {
        EnviarEmailNuevaEvaluacion::dispatch($evaluacion);
    }
}
