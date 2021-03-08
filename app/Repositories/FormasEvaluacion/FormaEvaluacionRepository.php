<?php

namespace App\Repositories\FormasEvaluacion;

use App\Models\Estructuras\FormaEvaluacion;

class FormaEvaluacionRepository
{
    public function find($id)
    {
        return FormaEvaluacion::select('id', 'nombre', 'tipo', 'desdeCuando')->findOrFail($id);
    }
}