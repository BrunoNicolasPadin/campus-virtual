<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\Division\DivisionService;
use Inertia\Inertia;

class EvaluacionEstadisticaController extends Controller
{
    protected $divisionService;

    public function __construct(DivisionService $divisionService)

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('evaluacionCorrespondiente');

        $this->divisionService = $divisionService;
    }

    public function mostrarEstadisticas($institucion_id, $division_id, $evaluacion_id)
    {
        $division = $this->divisionService->find($division_id);
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
            ->with(['archivos', 'alumno', 'alumno.user', 'correcciones'])
            ->orderBy('calificacion')
            ->get();
        
        $aprobados = 0;
        $desaprobados = 0;
        $sinCalificar = 0;
        $entregados = 0;
        $noEntregados = 0;
        $entregadosTiempo = 0;
        $entregasDestiempo = 0;
        $conCorreccion = 0;
        $sinCorreccion = 0;
        $mejorNota = '0';

        $aprobadosArray = [];
        $desaprobadosArray = [];
        $sinCalificarArray = [];
        $entregadosArray = [];
        $noEntregadosArray = [];
        $conCorreccionArray = [];
        $sinCorreccionArray = [];
        
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

            foreach ($entrega->archivos->groupBy('entrega_id') as $archivo) {
                $archivo = $archivo->unique('entrega_id');
                $i++;
                $entregados = $entregados + 1;

                $arrayTemporal = $this->obtenerEntregadosATiempo($entrega, $archivo[0], $evaluacion, $entregadosTiempo, $entregadosArray);
                $entregadosTiempo = $arrayTemporal[0];
                $entregadosArray = $arrayTemporal[1];

                $arrayTemporal = $this->obtenerEntregadosADestiempo($entrega, $archivo[0], $evaluacion, $entregasDestiempo, $entregadosArray);
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
            $i = 0;

            if (!($tipo == 'Escrita')) {
                $mejorNota = $this->obtenerMejorCalificacion($entrega, $mejorNota);
            }

            foreach ($entrega->correcciones->groupBy('entrega_id') as $correccion) {
                $correccion = $correccion->unique('entrega_id');
                $i++;

                $arrayTemporal = $this->obtenerConCorreccion($entrega, $conCorreccion, $conCorreccionArray);
                $conCorreccion = $arrayTemporal[0];
                $conCorreccionArray = $arrayTemporal[1];
            }

            if ($i == 0) {
                $sinCorreccion = $sinCorreccion + 1;
                array_push($sinCorreccionArray, [
                    'nombre' => $entrega->alumno->user->name,
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
            'conCorrecciones' => $conCorreccionArray,
            'sinCorrecciones' => $sinCorreccionArray,
        ];

        $numeros = [
            'aprobados' => $aprobados,
            'desaprobados' => $desaprobados,
            'sinCalificar' => $sinCalificar,
            'entregados' => $entregados,
            'noEntregados' => $noEntregados,
            'entregadosTiempo' => $entregadosTiempo,
            'entregasDestiempo' => $entregasDestiempo,
            'conCorreccion' => $conCorreccion,
            'sinCorreccion' => $sinCorreccion,
            'mejorNota' => $mejorNota,
        ];

        return Inertia::render('Evaluaciones/Estadisticas/Mostrar', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $division,
            'evaluacion' => $evaluacion,
            'numerosArray' => $numerosArray,
            'numeros' => $numeros,
            'tipoEvaluacion' => $tipo,
        ]);
    }

    public function obtenerAprobados($entrega, $partida, $calificacionesAprobadas, $aprobados, $aprobadosArray)
    {
        if (($partida <> null && $entrega->calificacion >= $partida) || ($entrega->calificacion <> null && in_array($entrega->calificacion, $calificacionesAprobadas))) {
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
        if (($entrega->calificacion <> null && $entrega->calificacion < $partida) || 
            ($entrega->calificacion <> null && !(in_array($entrega->calificacion, $calificacionesAprobadas)))) {
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
        if ($entrega->calificacion == null || $entrega->calificacion == '') {
            $sinCalificar = $sinCalificar + 1;
            array_push($sinCalificarArray, [
                'nombre' => $entrega->alumno->user->name,
                'id' => $entrega->id,
            ]);
        }
        return [$sinCalificar, $sinCalificarArray];
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
        if (!($archivo) || $archivo->created_at > $evaluacion->fechaHoraFinalizacion) {
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

    public function obtenerConCorreccion($entrega, $conCorreccion, $conCorreccionArray)
    {
            $conCorreccion = $conCorreccion + 1;
            array_push($conCorreccionArray, [
                'nombre' => $entrega->alumno->user->name,
                'id' => $entrega->id,
                'tiempo' => true,
            ]);
        return [$conCorreccion, $conCorreccionArray];
    }
}
