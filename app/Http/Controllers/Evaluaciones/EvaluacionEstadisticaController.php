<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use Inertia\Inertia;

class EvaluacionEstadisticaController extends Controller
{
    public function mostrarEstadisticas($institucion_id, $division_id, $evaluacion_id)
    {
        $evaluacion = Evaluacion::findOrFail($evaluacion_id);
        $entregas = Entrega::where('evaluacion_id', $evaluacion_id)
            ->with(['archivos', 'alumno', 'alumno.user'])
            ->orderBy('calificacion')
            ->get();
        
        $aprobados = 0;
        $desaprobados = 0;
        $sinCalificar = 0;
        $entregados = 0;
        $noEntregados = 0;
        $entregadosTiempo = 0;
        $entregasDestiempo = 0;
        $mejorNota = '0';

        $aprobadosArray = [];
        $desaprobadosArray = [];
        $sinCalificarArray = [];
        $entregadosArray = [];
        $noEntregadosArray = [];
        $mejoresNotasArray = [];
        
        foreach ($entregas as $entrega) {

            if ($entrega->calificacion >= 6) {
                $aprobados = $aprobados + 1;
                array_push($aprobadosArray, [
                    'nombre' => $entrega->alumno->user->name,
                    'calificacion' => $entrega->calificacion,
                    'id' => $entrega->id,
                ]);
            }
            elseif ($entrega->calificacion <= 5 && $entrega->calificacion >= 1) {
                $desaprobados = $desaprobados + 1;
                array_push($desaprobadosArray, [
                    'nombre' => $entrega->alumno->user->name,
                    'calificacion' => $entrega->calificacion,
                    'id' => $entrega->id,
                ]);
            }

            elseif ($entrega->calificacion == null) {
                $sinCalificar = $sinCalificar + 1;
                array_push($sinCalificarArray, [
                    'nombre' => $entrega->alumno->user->name,
                    'id' => $entrega->id,
                ]);
            }
            
            $i = 0;
            foreach ($entrega->archivos as $archivo) {
                $i++;
                $entregados = $entregados + 1;

                if ($archivo->created_at <= $evaluacion->fechaHoraFinalizacion) {
                    $entregadosTiempo = $entregadosTiempo + 1;
                    array_push($entregadosArray, [
                        'nombre' => $entrega->alumno->user->name,
                        'id' => $entrega->id,
                        'tiempo' => true,
                    ]);
                    break;
                }
                else {
                    $entregasDestiempo = $entregasDestiempo + 1;
                    array_push($entregadosArray, [
                        'nombre' => $entrega->alumno->user->name,
                        'id' => $entrega->id,
                        'tiempo' => false,
                    ]);
                    break;
                }
            }

            if ($i == 0) {
                $noEntregados = $noEntregados + 1;
                array_push($noEntregadosArray, [
                    'nombre' => $entrega->alumno->user->name,
                    'id' => $entrega->id,
                ]);
            }

            if ($entrega->calificacion >= $mejorNota) {
                if ($entrega->calificacion > $mejorNota) {
                    $mejorNota = $entrega->calificacion;
                }
                array_push($mejoresNotasArray, [
                    'nombre' => $entrega->alumno->user->name,
                    'calificacion' => $entrega->calificacion,
                    'id' => $entrega->id,
                ]);
            }
            $i = 0;
        }

        $numerosArray = [
            'aprobados' => $aprobadosArray,
            'desaprobados' => $desaprobadosArray,
            'sinCalificar' => $sinCalificarArray,
            'entregados' => $entregadosArray,
            'noEntregados' => $noEntregadosArray,
            'mejoresNotas' => $mejoresNotasArray,
        ];

        $numeros = [
            'aprobados' => $aprobados,
            'desaprobados' => $desaprobados,
            'sinCalificar' => $sinCalificar,
            'entregados' => $entregados,
            'noEntregados' => $noEntregados,
            'entregadosTiempo' => $entregadosTiempo,
            'entregasDestiempo' => $entregasDestiempo,
            'mejorNota' => $mejorNota,
        ];

        return Inertia::render('Evaluaciones/Estadisticas/Mostrar', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => $evaluacion,
            'numerosArray' => $numerosArray,
            'numeros' => $numeros,
        ]);
    }
}
