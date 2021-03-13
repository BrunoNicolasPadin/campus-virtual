<?php

namespace App\Observers\Evaluaciones;

use App\Jobs\Evaluaciones\NuevaRespuestaJob;
use App\Models\Evaluaciones\EvaluacionRespuesta;
use Illuminate\Support\Facades\Auth;

class EvaluacionRespuestaObserver
{
    public function created(EvaluacionRespuesta $evaluacionRespuesta)
    {
        $tipo = session('tipo');
        NuevaRespuestaJob::dispatch($evaluacionRespuesta, $tipo);
    }
}
