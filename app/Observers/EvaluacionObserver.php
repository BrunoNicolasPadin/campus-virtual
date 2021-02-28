<?php

namespace App\Observers;

use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Roles\Alumno;

class EvaluacionObserver
{
    public function created(Evaluacion $evaluacion)
    {
        $alumnos = Alumno::where('division_id', $evaluacion->division_id)->get();

        foreach ($alumnos as $alumno) {

            $entrega = new Entrega();
            $entrega->evaluacion_id = $evaluacion->id;
            $entrega->alumno_id = $alumno->id;
            $entrega->save();
        }
    }
}
