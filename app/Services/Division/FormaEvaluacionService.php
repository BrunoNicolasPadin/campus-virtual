<?php

namespace App\Services\Division;

use App\Models\Estructuras\FormaEvaluacion;

class FormaEvaluacionService
{
    public function find($id)
    {
        return FormaEvaluacion::select('id', 'nombre', 'tipo', 'desdeCuando')->findOrFail($id);
    }
}