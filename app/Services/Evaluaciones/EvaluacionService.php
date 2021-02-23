<?php

namespace App\Services\Evaluaciones;

use App\Models\Evaluaciones\Evaluacion;

class EvaluacionService
{
    public function find($id)
    {
        return Evaluacion::select('titulo')->findOrFail($id);
    }
}