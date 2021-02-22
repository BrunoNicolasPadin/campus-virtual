<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use Inertia\Inertia;

class EvaluacionEstadisticaController extends Controller
{
    public function mostrarEstadisticas($institucion_id, $division_id, $evaluacion_id)
    {
        $division = Division::findOrFail($division_id);
        $formaEvaluacion = FormaEvaluacion::findOrFail($division->forma_evaluacion_id);
        $partida = null;
        $calificacionesAprobadas = [];
        $tipo = $formaEvaluacion->tipo;

        if ($tipo == 'Escrita') {
            $formasDescripcion = FormaDescripcion::where('forma_evaluacion_id', $division->forma_evaluacion_id)->get();

            foreach ($formasDescripcion as $formaDescripcion) {
                if ($formaDescripcion->aprobado) {
                    array_push($calificacionesAprobadas, $formaDescripcion->opcion);
                }
            }
        }
        else {
            $partida = $formaEvaluacion->desdeCuando;
        }


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
        
        foreach ($entregas as $entrega) {

            $arrayTemporal = $this->obtenerAprobados($entrega, $partida, $calificacionesAprobadas, $aprobados, $aprobadosArray);
            $aprobados = $arrayTemporal[0];
            $aprobadosArray = $arrayTemporal[1];

            $arrayTemporal = $this->obtenerDesaprobados($entrega, $partida, $calificacionesAprobadas, $desaprobados, $desaprobadosArray);
            $desaprobados = $arrayTemporal[0];
            $desaprobadosArray = $arrayTemporal[1];

            $arrayTemporal = $this->obtenerSinCalificar($entrega, $sinCalificar, $sinCalificarArray);
            $sinCalificar = $arrayTemporal[0];
            $sinCalificarArray = $arrayTemporal[1];
            
            $i = 0;

            foreach ($entrega->archivos as $archivo) {
                $i++;
                $entregados = $entregados + 1;

                $arrayTemporal = $this->obtenerEntregadosATiempo($entrega, $archivo, $evaluacion, $entregadosTiempo, $entregadosArray);
                $entregadosTiempo = $arrayTemporal[0];
                $entregadosArray = $arrayTemporal[1];

                $arrayTemporal = $this->obtenerEntregadosADestiempo($entrega, $archivo, $evaluacion, $entregasDestiempo, $entregadosArray);
                $entregasDestiempo = $arrayTemporal[0];
                $entregadosArray = $arrayTemporal[1];
            }

            if ($i == 0) {
                $noEntregados = $noEntregados + 1;
                array_push($noEntregadosArray, [
                    'nombre' => $entrega->alumno->user->name,
                    'id' => $entrega->id,
                ]);
            }

            if (!($tipo == 'Escrita')) {
                $mejorNota = $this->obtenerMejorCalificacion($entrega, $mejorNota);
            }
            $i = 0;
        }

        $numerosArray = [
            'aprobados' => $aprobadosArray,
            'desaprobados' => $desaprobadosArray,
            'sinCalificar' => $sinCalificarArray,
            'entregados' => $entregadosArray,
            'noEntregados' => $noEntregadosArray,
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
            'tipoEvaluacion' => $tipo,
        ]);
    }

    public function obtenerAprobados($entrega, $partida, $calificacionesAprobadas, $aprobados, $aprobadosArray)
    {
        if ($entrega->calificacion >= $partida || in_array($entrega->calificacion, $calificacionesAprobadas)) {
            $aprobados = $aprobados + 1;
            array_push($aprobadosArray, [
                'nombre' => $entrega->alumno->user->name,
                'calificacion' => $entrega->calificacion,
                'id' => $entrega->id,
            ]);
        }
        return [$aprobados, $aprobadosArray];
    }

    public function obtenerDesaprobados($entrega, $partida, $calificacionesAprobadas, $desaprobados, $desaprobadosArray)
    {
        if ($entrega->calificacion < $partida && !(in_array($entrega->calificacion, $calificacionesAprobadas))) {
            $desaprobados = $desaprobados + 1;
            array_push($desaprobadosArray, [
                'nombre' => $entrega->alumno->user->name,
                'calificacion' => $entrega->calificacion,
                'id' => $entrega->id,
            ]);
        }
        return [$desaprobados, $desaprobadosArray];
    }

    public function obtenerSinCalificar($entrega, $sinCalificar, $sinCalificarArray)
    {
        if ($entrega->calificacion == null) {
            $sinCalificar = $sinCalificar + 1;
            array_push($sinCalificarArray, [
                'nombre' => $entrega->alumno->user->name,
                'id' => $entrega->id,
            ]);
        }
        return [$sinCalificar, $sinCalificar];
    }

    public function obtenerEntregadosATiempo($entrega, $archivo, $evaluacion, $entregadosTiempo, $entregadosArray)
    {
        if ($archivo->created_at <= $evaluacion->fechaHoraFinalizacion) {
            $entregadosTiempo = $entregadosTiempo + 1;
            array_push($entregadosArray, [
                'nombre' => $entrega->alumno->user->name,
                'id' => $entrega->id,
                'tiempo' => true,
            ]);
        }
        return [$entregadosTiempo, $entregadosArray];
    }

    public function obtenerEntregadosADestiempo($entrega, $archivo, $evaluacion, $entregasDestiempo, $entregadosArray)
    {
        if ($archivo->created_at > $evaluacion->fechaHoraFinalizacion) {
            $entregasDestiempo = $entregasDestiempo + 1;
            array_push($entregadosArray, [
                'nombre' => $entrega->alumno->user->name,
                'id' => $entrega->id,
                'tiempo' => false,
            ]);
        }
        return [$entregasDestiempo, $entregadosArray];
    }

    public function obtenerMejorCalificacion($entrega, $mejorNota)
    {
        if ($entrega->calificacion >= $mejorNota) {
            if ($entrega->calificacion > $mejorNota) {
                $mejorNota = $entrega->calificacion;
            }
        }
        return $mejorNota;
    }
}
