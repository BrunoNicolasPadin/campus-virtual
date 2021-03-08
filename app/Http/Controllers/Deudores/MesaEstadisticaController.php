<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Models\Deudores\Inscripcion;
use App\Models\Deudores\Mesa;
use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;
use App\Repositories\Asignaturas\AsignaturaRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class MesaEstadisticaController extends Controller
{
    protected $formatoService;
    protected $divisionRepository;
    protected $asignaturaRepository;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        DivisionRepository $divisionRepository, 
        AsignaturaRepository $asignaturaRepository,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('mesaCorrespondiente');

        $this->formatoService = $formatoService;
        $this->divisionRepository = $divisionRepository;
        $this->asignaturaRepository = $asignaturaRepository;
    }

    public function mostrarEstadisticas($institucion_id, $division_id, $asignatura_id, $id)
    {
        $division = $this->divisionRepository->find($division_id);
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


        $mesa = Mesa::with('asignatura')->findOrFail($id);
        $inscripciones = Inscripcion::where('mesa_id', $id)
            ->with(['entregas', 'alumno', 'alumno.user', 'correcciones'])
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
        
        foreach ($inscripciones as $inscripcion) {

            $arrayTemporal = $this->obtenerAprobados($inscripcion, $partida, $calificacionesAprobadas, $aprobados, $aprobadosArray);
            $aprobados = $arrayTemporal[0];
            $aprobadosArray = $arrayTemporal[1];

            $arrayTemporal = $this->obtenerDesaprobados($inscripcion, $partida, $calificacionesAprobadas, $desaprobados, $desaprobadosArray);
            $desaprobados = $arrayTemporal[0];
            $desaprobadosArray = $arrayTemporal[1];

            $arrayTemporal = $this->obtenerSinCalificar($inscripcion, $sinCalificar, $sinCalificarArray);
            $sinCalificar = $arrayTemporal[0];
            $sinCalificarArray = $arrayTemporal[1];
            
            $i = 0;

            foreach ($inscripcion->entregas->groupBy('inscripcion_id') as $entrega) {
                $entrega = $entrega->unique('inscripcion_id');
                $i++;
                $entregados = $entregados + 1;

                $arrayTemporal = $this->obtenerEntregadosATiempo($inscripcion, $entrega[0], $mesa, $entregadosTiempo, $entregadosArray);
                $entregadosTiempo = $arrayTemporal[0];
                $entregadosArray = $arrayTemporal[1];

                $arrayTemporal = $this->obtenerEntregadosADestiempo($inscripcion, $entrega[0], $mesa, $entregasDestiempo, $entregadosArray);
                $entregasDestiempo = $arrayTemporal[0];
                $entregadosArray = $arrayTemporal[1];
            }

            if ($i == 0) {
                $noEntregados = $noEntregados + 1;
                array_push($noEntregadosArray, [
                    'nombre' => $inscripcion->alumno->user->name,
                    'id' => $inscripcion->id,
                ]);
            }
            $i = 0;

            if (!($tipo == 'Escrita')) {
                $mejorNota = $this->obtenerMejorCalificacion($inscripcion, $mejorNota);
            }

            foreach ($inscripcion->correcciones->groupBy('inscripcion_id') as $correccion) {
                $correccion = $correccion->unique('inscripcion_id');
                $i++;

                $arrayTemporal = $this->obtenerConCorreccion($inscripcion, $conCorreccion, $conCorreccionArray);
                $conCorreccion = $arrayTemporal[0];
                $conCorreccionArray = $arrayTemporal[1];
            }

            if ($i == 0) {
                $sinCorreccion = $sinCorreccion + 1;
                array_push($sinCorreccionArray, [
                    'nombre' => $inscripcion->alumno->user->name,
                    'id' => $inscripcion->id,
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

        return Inertia::render('Deudores/Mesas/Estadisticas', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'asignatura' => $this->asignaturaRepository->find($asignatura_id),
            'mesa' => [
                'id' => $mesa->id,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
            ],
            'numerosArray' => $numerosArray,
            'numeros' => $numeros,
            'tipoEvaluacion' => $tipo,
        ]);
    }

    public function obtenerAprobados($inscripcion, $partida, $calificacionesAprobadas, $aprobados, $aprobadosArray)
    {
        if (($partida <> null && $inscripcion->calificacion >= $partida) || ($inscripcion->calificacion <> null && in_array($inscripcion->calificacion, $calificacionesAprobadas))) {
            $aprobados = $aprobados + 1;
            array_push($aprobadosArray, [
                'nombre' => $inscripcion->alumno->user->name,
                'calificacion' => $inscripcion->calificacion,
                'id' => $inscripcion->id,
            ]);
        }
        return [$aprobados, $aprobadosArray];
    }

    public function obtenerDesaprobados($inscripcion, $partida, $calificacionesAprobadas, $desaprobados, $desaprobadosArray)
    {
        if (($inscripcion->calificacion <> null && $inscripcion->calificacion < $partida) || 
            ($inscripcion->calificacion <> null && !(in_array($inscripcion->calificacion, $calificacionesAprobadas)))) {
            $desaprobados = $desaprobados + 1;
            array_push($desaprobadosArray, [
                'nombre' => $inscripcion->alumno->user->name,
                'calificacion' => $inscripcion->calificacion,
                'id' => $inscripcion->id,
            ]);
        }
        return [$desaprobados, $desaprobadosArray];
    }

    public function obtenerSinCalificar($inscripcion, $sinCalificar, $sinCalificarArray)
    {
        if ($inscripcion->calificacion == null || $inscripcion->calificacion == '') {
            $sinCalificar = $sinCalificar + 1;
            array_push($sinCalificarArray, [
                'nombre' => $inscripcion->alumno->user->name,
                'id' => $inscripcion->id,
            ]);
        }
        return [$sinCalificar, $sinCalificarArray];
    }

    public function obtenerEntregadosATiempo($inscripcion, $archivo, $mesa, $entregadosTiempo, $entregadosArray)
    {
        if ($archivo->created_at <= $mesa->fechaHoraFinalizacion) {
            $entregadosTiempo = $entregadosTiempo + 1;
            array_push($entregadosArray, [
                'nombre' => $inscripcion->alumno->user->name,
                'id' => $inscripcion->id,
                'tiempo' => true,
            ]);
        }
        return [$entregadosTiempo, $entregadosArray];
    }

    public function obtenerEntregadosADestiempo($inscripcion, $archivo, $mesa, $entregasDestiempo, $entregadosArray)
    {
        if (!($archivo) || $archivo->created_at > $mesa->fechaHoraFinalizacion) {
            $entregasDestiempo = $entregasDestiempo + 1;
            array_push($entregadosArray, [
                'nombre' => $inscripcion->alumno->user->name,
                'id' => $inscripcion->id,
                'tiempo' => false,
            ]);
        }
        return [$entregasDestiempo, $entregadosArray];
    }

    public function obtenerMejorCalificacion($inscripcion, $mejorNota)
    {
        if ($inscripcion->calificacion >= $mejorNota) {
            if ($inscripcion->calificacion > $mejorNota) {
                $mejorNota = $inscripcion->calificacion;
            }
        }
        return $mejorNota;
    }

    public function obtenerConCorreccion($inscripcion, $conCorreccion, $conCorreccionArray)
    {
            $conCorreccion = $conCorreccion + 1;
            array_push($conCorreccionArray, [
                'nombre' => $inscripcion->alumno->user->name,
                'id' => $inscripcion->id,
                'tiempo' => true,
            ]);
        return [$conCorreccion, $conCorreccionArray];
    }
}
