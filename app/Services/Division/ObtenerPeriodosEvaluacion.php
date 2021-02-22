<?php

namespace App\Services\Division;

use Illuminate\Support\Facades\Hash;

class ObtenerPeriodosEvaluacion
{
    public function obtenerPeriodos($libreta)
    {
        if ($libreta['periodo_id'] == 1) {
            return ['1er bimestre', '2do bimestre', '3er bimestre', '4to bimestre', 'Nota final'];
        }
        elseif ($libreta['periodo_id'] == 2) {
            return ['1er trimestre', '2do trimestre', '3er trimestre', 'Nota final'];
        }
        elseif ($libreta['periodo_id'] == 3) {
            return ['1er cuatrimestre', '2do cuatrimestre', 'Nota final'];
        }
    }
}