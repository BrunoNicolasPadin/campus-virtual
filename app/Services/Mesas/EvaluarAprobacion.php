<?php

namespace App\Services\Mesas;

use App\Models\Deudores\AlumnoDeudor;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;

class EvaluarAprobacion
{
    public function actualizacionDeInscripcion($division_id, $request, $inscripcion, $asignatura_id)
    {
        $division = Division::findOrFail($division_id);
        $formaEvaluacion = FormaEvaluacion::findOrFail($division->forma_evaluacion_id);

        if ($formaEvaluacion->tipo == 'Escrita') {
            $this->evaluarAprobacionEscrita($formaEvaluacion, $request, $inscripcion, $asignatura_id);
        }
        else {
            $this->evaluarAprobacionNumericaPorcentual($formaEvaluacion, $request, $inscripcion, $asignatura_id);
        }
    }

    public function evaluarAprobacionEscrita($formaEvaluacion, $request, $inscripcion, $asignatura_id)
    {
        $formasDescripcion = FormaDescripcion::where('forma_evaluacion_id', $formaEvaluacion->id)->get();

        foreach ($formasDescripcion as $formaDescripcion) {
            
            if ($formaDescripcion->opcion == $request->calificacion) {
                
                if ($formaDescripcion->aprobado) {
                    AlumnoDeudor::where('alumno_id', $inscripcion->alumno_id)->where('asignatura_id', $asignatura_id)->update([
                        'aprobado' => '1',
                    ]);
                }
                else {
                    AlumnoDeudor::where('alumno_id', $inscripcion->alumno_id)->where('asignatura_id', $asignatura_id)->update([
                        'aprobado' => '0',
                    ]);
                }
            }
        }
    }

    public function evaluarAprobacionNumericaPorcentual($formaEvaluacion, $request, $inscripcion, $asignatura_id)
    {
        if ($formaEvaluacion->desdeCuando >= $request->calificacion) {
                    
            AlumnoDeudor::where('alumno_id', $inscripcion->alumno_id)->where('asignatura_id', $asignatura_id)->update([
                'aprobado' => '1',
            ]);
        }
        else {
            AlumnoDeudor::where('alumno_id', $inscripcion->alumno_id)->where('asignatura_id', $asignatura_id)->update([
                'aprobado' => '0',
            ]);
        }
    }
}

    