<?php

namespace App\Observers;

use App\Models\Evaluaciones\Evaluacion;

class EvaluacionObserver
{
    protected $entregaController;

    public function __construct()
    {
        
    }

    public function created(Evaluacion $evaluacion)
    {
        /* $this-> */
    }

    public function updated(Evaluacion $evaluacion)
    {
        //
    }

    public function deleted(Evaluacion $evaluacion)
    {
        //
    }

    public function restored(Evaluacion $evaluacion)
    {
        //
    }

    public function forceDeleted(Evaluacion $evaluacion)
    {
        //
    }
}
