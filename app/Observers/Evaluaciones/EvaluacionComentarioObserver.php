<?php

namespace App\Observers\Evaluaciones;

use App\Jobs\Evaluaciones\NuevoComentarioJob;
use App\Models\Evaluaciones\EvaluacionComentario;
use Illuminate\Support\Facades\Auth;

class EvaluacionComentarioObserver
{
    public function created(EvaluacionComentario $evaluacionComentario)
    {
        NuevoComentarioJob::dispatch($evaluacionComentario);
    }
}
