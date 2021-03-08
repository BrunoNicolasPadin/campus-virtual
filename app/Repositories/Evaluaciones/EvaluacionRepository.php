<?php

namespace App\Repositories\Evaluaciones;

use App\Models\Evaluaciones\Evaluacion;

class EvaluacionRepository
{
    public function find($id)
    {
        return Evaluacion::findOrFail($id);
    }
}